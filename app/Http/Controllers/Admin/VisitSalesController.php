<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use Ramsey\Uuid\Uuid;
use App\Models\Sales\Visit;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\VisitSchedules;
use App\Models\Toko\ImageOfficial;
use App\Models\Toko\OfficialStore;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\VisitSalesRequest;
use Stevebauman\Location\Facades\Location;
use App\Http\Requests\StoreVisitSalesRequest;

class VisitSalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:visit-sales-list|visit-sales-create|visit-sales-edit|visit-sales-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:visit-sales-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:visit-sales-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:visit-sales-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     if (Gate::denies('visit-sales-list')) {
    //         abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
    //     }

    //     // $visit_sales = Visit::select(['id', 'user_id', 'official_store_id', 'ip_address', 'check_in', 'check_out'])->latest()->paginate(10);
    //     $perPage = $request->input('perPage', 10); // Jumlah data per halaman, default 10.

    //     $query = Visit::select(['id', 'user_id', 'official_store_id', 'ip_address', 'check_in', 'check_out'])->latest();

    //     $query_visit_schedules = VisitSchedules::select(['id', 'user_id', 'official_store_id', 'ip_address', 'check_in', 'check_out'])->latest();

    //     // Check if $perPage is 'Semua' to decide whether to use paginate or not.
    //     if ($perPage == 'Semua') {
    //         // Fetch all data using chunk to process them in smaller chunks.
    //         $chunkSize = 500; // Jumlah data per potongan.
    //         $visits = [];
    //         $query->chunk($chunkSize, function ($visitsChunk) use (&$visits) {
    //             foreach ($visitsChunk as $visit) {
    //                 // Lakukan pengolahan data di sini untuk setiap toko.
    //                 // Misalnya, Anda dapat melakukan sesuatu seperti:
    //                 // $store->name atau $store->status
    //                 $visits[] = $visit;
    //             }
    //         });
    //     } else {
    //         // Use paginate if $perPage is not 'Semua'.
    //         $visits = $query->paginate($perPage);
    //     }

    //     return view('pages.dashboard_admin.visit_sales.index', [
    //         'visit_sales' => $visits,
    //         'visit_schedules' => $query_visit_schedules,
    //         'title' => 'Visit Sales',
    //         'active' => 'visit-sales',
    //         'i' => ($visits->currentPage() - 1) * $visits->perPage() + 1,
    //         'breadcumb' => [
    //             'links' => [
    //                 [
    //                     'name' => 'Visit Sales',
    //                     'url' => route('dashboard.visit-sales.index')
    //                 ]
    //             ]
    //         ]
    //     ]);
    // }

    public function index(Request $request)
    {
        if (Gate::denies('visit-sales-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        $perPage = $request->input('perPage', 10);

        $today = Carbon::today();

        $visits = Visit::select(['id', 'user_id', 'official_store_id', 'ip_address', 'check_in', 'check_out'])
            ->whereDate('check_in', $today)
            ->latest()
            ->paginate($perPage);

        $visit_schedules = VisitSchedules::with(['official_store', 'visit_sales', 'image_officials'])
            ->select(['id', 'user_id', 'official_store_id', 'custom_visit_day', 'custom_visit_note'])
            ->where('custom_visit_day', $today)
            ->where('user_id', Auth::user()->id)
            ->latest()
            ->get();


        return view('pages.dashboard_admin.visit_sales.index', [
            'visit_sales' => $visits,
            'visit_schedules' => $visit_schedules,
            'title' => 'Visit Sales',
            'active' => 'visit-sales',
            'i' => ($visits->currentPage() - 1) * $visits->perPage() + 1,
            'breadcumb' => [
                'links' => [
                    [
                        'name' => 'Visit Sales',
                        'url' => route('dashboard.visit-sales.index')
                    ]
                ]
            ]
        ]);
    }

    public function getStoreLocation(Request $request)
    {
        $officialStore = OfficialStore::where('id', $request->selected)->first();

        if (!$officialStore) {
            return response()->json(['error' => 'Official Store not found'], 404);
        }

        return response()->json(['latitude' => $officialStore->latitude, 'longitude' => $officialStore->longitude]);
    }


    /**
     * Show the form for creating the resource.
     */
    public function create()
    {
        if (Gate::denies('visit-sales-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        $users = User::select(['id', 'name', 'email'])->get();
        $stores = OfficialStore::select(['id', 'name', 'status', 'phone', 'email', 'city', 'latitude', 'longitude', 'description'])->get();

        return view('pages.dashboard_admin.visit_sales.create', [
            'title' => 'Create Visit Sales',
            'active' => 'visit-sales',
            'users' => $users,
            'officialStores' => $stores,
        ]);
    }

    /**
     * Store the newly created resource in storage.
     */
    public function store(VisitSalesRequest $request)
    {
        if (Gate::denies('visit-sales-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        $visit_sales = new Visit();
        $visit_sales->user_id = $request->user_id;
        $visit_sales->official_store_id = $request->official_store_id;
        $visit_sales->ip_address = $request->ip() ?? $request->server('REMOTE_ADDR'); // Gunakan alamat IP saat ini, jika tersedia.
        $visit_sales->check_in = $request->check_in;
        $visit_sales->check_out = $request->check_out;

        // Ambil lokasi pengunjung berdasarkan alamat IP.
        $visit_sales->latitude = $request->latitude;
        $visit_sales->longitude = $request->longitude;

        $visit_sales->save();

        return redirect()->route('dashboard.visit-sales.index')->with('success', 'Visit Sales has been created!');
    }


    public function storeVisitSales(StoreVisitSalesRequest $request)
    {
        if (Gate::denies('visit-sales-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        // Periksa apakah sudah ada entri dengan visit_schedules_id yang sama
        $existingEntry = Visit::where('visit_schedules_id', $request->visit_schedules_id)->first();

        if ($existingEntry) {
            return redirect()->route('dashboard.visit-sales.create.store-page', ['id' => $existingEntry->id])->with('warning', 'Visit Sales already exists!');
        }

        $visit_sales = new Visit();
        $visit_sales->user_id = Auth::user()->id;
        $visit_sales->official_store_id = $request->official_store_id;
        $visit_sales->visit_schedules_id = $request->visit_schedules_id;
        $visit_sales->ip_address = $request->ip() ?? $request->server('REMOTE_ADDR'); // Gunakan alamat IP saat ini, jika tersedia.
        $visit_sales->check_in = Carbon::now();

        $visit_sales->save();

        $visitId = $visit_sales->id == null ? Uuid::uuid4()->toString() : $visit_sales->id;

        return redirect()->route('dashboard.visit-sales.create.store-page', ['id' => $visitId])->with('success', 'Visit Sales has been created!');
    }

    public function createPageVisitSales($id)
    {
        if (Gate::denies('visit-sales-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        $visit_sales = Visit::with(['official_store', 'user', 'visit_schedules'])->findOrFail($id);
        $users = User::select(['id', 'name', 'email'])->get();
        $stores = OfficialStore::select(['id', 'name', 'status', 'phone', 'email', 'city', 'latitude', 'longitude', 'description'])->get();
        $imageOfficial = ImageOfficial::where('visit_schedules_id', $visit_sales->visit_schedules_id)->first();

        return view('pages.dashboard_admin.visit_sales.page_visit_sales', [
            'title' => 'Create Visit Sales',
            'active' => 'visit-sales',
            'visit_sales' => $visit_sales,
            'users' => $users,
            'officialStores' => $stores,
            'imageOfficial' => $imageOfficial,
        ]);
    }


    public function storeVisitSalesCheckOut(Request $request, $id)
    {
        if (Gate::denies('visit-sales-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        $visit_sales = Visit::findOrFail($id);
        $visit_sales->check_out = Carbon::now();
        $visit_sales->latitude = $request->latitude;
        $visit_sales->longitude = $request->longitude;

        $visit_sales->save();
        return redirect()->route('dashboard.visit-sales.index')->with('success', 'Visit Sales has been created!');
    }

    // public function createStoreImageOfficial($id, $image)
    // {
    //     if (Gate::denies('visit-sales-list')) {
    //         abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
    //     }

    //     $visit_sales = Visit::with(['user', 'official_store'])->find(['id' => $id, 'image' => $image]);
    //     $officialStore = OfficialStore::select(['id', 'name', 'status', 'phone', 'email', 'city', 'latitude', 'longitude', 'description'])->get();

    //     return view('pages.dashboard_admin.visit_sales.post_official_image', [
    //         'title' => 'Create Visit Sales',
    //         'active' => 'visit-sales',
    //         'visit_sales' => $visit_sales,
    //         'officialStores' => $officialStore,
    //     ]);
    // }

    public function createStoreImageOfficial($id)
    {
        if (Gate::denies('visit-sales-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        // Menggunakan findOrFail untuk mencari kunjungan dengan ID tertentu.
        $visit_sales = Visit::with(['user', 'official_store'])->findOrFail($id);

        $officialStore = OfficialStore::select(['id', 'name', 'status', 'phone', 'email', 'city', 'latitude', 'longitude', 'description'])->get();
        $imageOfficial = ImageOfficial::where('visit_schedules_id', $visit_sales->visit_schedules_id)->first();

        return view('pages.dashboard_admin.visit_sales.post_official_image', [
            'title' => 'Create Visit Sales',
            'active' => 'visit-sales',
            'visit_sales' => $visit_sales,
            'officialStores' => $officialStore,
            'imageOfficial' => $imageOfficial,
        ]);
    }


    public function storeImageOfficial(Request $request, $id)
    {
        if (Gate::denies('visit-sales-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        // Menggunakan findOrFail untuk mencari kunjungan dengan ID tertentu.
        $visit_sales = Visit::with(['user', 'official_store'])->find($id);

        $officialStoreData = [
            'visit_schedules_id' => $visit_sales->visit_schedules_id,
            'official_store_id' => $request->official_store_id
        ];

        $image = $request->file('image');

        if ($image) {
            // Hapus file lama jika ada
            $existingEntry = ImageOfficial::where('visit_schedules_id', $visit_sales->visit_schedules_id)->first();

            if ($existingEntry) {
                Storage::delete($existingEntry->image);
            }

            $image_name = Str::random(10) . '.' . $image->getClientOriginalExtension();
            $image_path = $image->storeAs('public/visit_sales', $image_name);
            $officialStoreData['image'] = $image_path;
        }

        $existingEntry = ImageOfficial::updateOrCreate(
            ['visit_schedules_id' => $visit_sales->visit_schedules_id],
            $officialStoreData
        );

        return redirect()->route('dashboard.visit-sales.create.store-page', ['id' => $visit_sales->id])->with('success', 'Gambar berhasil ' . ($existingEntry->wasRecentlyCreated ? 'disimpan.' : 'diupdate.'));
    }









    /**
     * Display the resource.
     */
    public function show(): never
    {
        if (Gate::denies('visit-sales-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        abort(404);
    }

    /**
     * Show the form for editing the resource.
     */
    public function edit($id)
    {
        if (Gate::denies('visit-sales-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        $visit_sales = Visit::findOrFail($id);
        $users = User::select(['id', 'name', 'email'])->get();
        $stores = OfficialStore::select(['id', 'name', 'status', 'phone', 'email', 'city', 'latitude', 'longitude', 'description'])->get();

        return view('pages.dashboard_admin.visit_sales.edit', [
            'title' => 'Edit Visit Sales',
            'active' => 'visit-sales',
            'visit_sales' => $visit_sales,
            'users' => $users,
            'stores' => $stores,
        ]);
    }

    /**
     * Update the resource in storage.
     */
    public function update(VisitSalesRequest $request, $id)
    {
        if (Gate::denies('visit-sales-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        $visit_sales = Visit::findOrFail($id);
        $visit_sales->user_id = $request->user_id;
        $visit_sales->official_store_id = $request->official_store_id;
        $visit_sales->ip_address = $request->ip_address;
        $visit_sales->check_in = $request->check_in;
        $visit_sales->check_out = $request->check_out;

        // Ambil lokasi pengunjung berdasarkan alamat IP.
        $visit_sales->latitude = $request->latitude;
        $visit_sales->longitude = $request->longitude;

        $visit_sales->save();

        return redirect()->route('dashboard.visit-sales.index')->with('success', 'Visit Sales has been updated!');
    }

    /**
     * Remove the resource from storage.
     */
    public function destroy($id)
    {
        if (Gate::denies('visit-sales-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        $visit_sales = Visit::findOrFail($id);
        $visit_sales->delete();

        return redirect()->route('dashboard.visit-sales.index')->with('success', 'Visit Sales has been deleted!');
    }
}
