<?php

namespace App\Http\Controllers\Admin\Toko;

use Carbon\Carbon;
use App\Models\Categories;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Toko\OfficialStore;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Http\Requests\OfficialStoreRequest;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Pagination\LengthAwarePaginator;

class OfficialStoreController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:official-store-list|official-store-create|official-store-edit|official-store-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:official-store-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:official-store-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:official-store-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Gate::denies('official-store-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        $perPage = $request->input('perPage', 10); // Jumlah data per halaman, default 10.

        $query = OfficialStore::select(['id', 'category_id', 'name', 'status', 'phone', 'email', 'city', 'latitude', 'longitude', 'description'])->latest();

        // Check if $perPage is 'Semua' to decide whether to use paginate or not.
        if ($perPage == 'Semua') {
            // Fetch all data using chunk to process them in smaller chunks.
            $chunkSize = 500; // Jumlah data per potongan.
            $stores = [];
            $query->chunk($chunkSize, function ($storesChunk) use (&$stores) {
                foreach ($storesChunk as $store) {
                    // Lakukan pengolahan data di sini untuk setiap toko.
                    // Misalnya, Anda dapat melakukan sesuatu seperti:
                    // $store->name atau $store->status
                    $stores[] = $store;
                }
            });
        } else {
            // Use paginate if $perPage is not 'Semua'.
            $stores = $query->paginate($perPage);
        }

        return view('pages.dashboard_admin.official_stores.index', [
            'title' => 'Official Store',
            'active' => 'official-store',
            'i' => ($stores->currentPage() - 1) * $stores->perPage() + 1,
            'stores' => $stores,
            'breadcumb' => [
                'links' => [
                    [
                        'name' => 'Official Store',
                        'url' => route('dashboard.official-store.index')
                    ]
                ]
            ]
        ]);
    }

    public function loadNewData()
    {
        $newDataCount = OfficialStore::where('created_at', '>', Carbon::now()->subSeconds(10))->count(); // Anda dapat menyesuaikan waktu interval sesuai kebutuhan Anda.

        return response()->json(['newDataCount' => $newDataCount]);
    }

    /**
     * Show the form for creating the resource.
     */
    public function create()
    {
        if (Gate::denies('official-store-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        $categories = Categories::select(['id', 'name'])->get();

        return view('pages.dashboard_admin.official_stores.create', [
            'title' => 'Official Store',
            'active' => 'official-store',
            'categories' => $categories,
        ]);
    }

    /**
     * Store the newly created resource in storage.
     */

    public function store(OfficialStoreRequest $request)
    {
        if (Gate::denies('official-store-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        // Simpan data ke dalam database
        $stores = new OfficialStore();
        $stores->category_id = $request->category_id;
        $stores->name = $request->name;
        $stores->status = $request->status;
        $stores->phone = $request->phone;
        $stores->email = $request->email;
        $stores->city = $request->city;
        $stores->province = $request->province;
        $stores->address = $request->address;
        $stores->postal_code = $request->postal_code;
        $stores->latitude = $request->latitude;
        $stores->longitude = $request->longitude;

        $stores->slug = Str::slug($stores->name);

        $stores->description = $request->description;
        $stores->save();

        // Redirect ke halaman yang sesuai setelah berhasil disimpan
        return redirect()->route('dashboard.official-store.index')
            ->with('success', 'Official Store berhasil ditambahkan.');
    }


    /**
     * Display the resource.
     */
    public function show()
    {
        if (Gate::denies('official-store-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }
    }

    /**
     * Show the form for editing the resource.
     */
    public function edit($id)
    {
        if (Gate::denies('official-store-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        $categories = Categories::select(['id', 'name'])->get();
        $stores = OfficialStore::findOrFail($id);

        return view('pages.dashboard_admin.official_stores.edit', [
            'title' => 'Official Store',
            'active' => 'official-store',
            'categories' => $categories,
            'officialStore' => $stores,
        ]);
    }

    /**
     * Update the resource in storage.
     */
    public function update(OfficialStoreRequest $request, $id)
    {
        if (Gate::denies('official-store-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        // Temukan instance OfficialStore yang sudah ada dengan ID yang sesuai
        $stores = OfficialStore::findOrFail($id);

        // Update data pada instance yang sudah ada
        $stores->category_id = $request->category_id;
        $stores->name = $request->name;
        $stores->status = $request->status;
        $stores->phone = $request->phone;
        $stores->email = $request->email;
        $stores->city = $request->city;
        $stores->province = $request->province;
        $stores->address = $request->address;
        $stores->postal_code = $request->postal_code;
        $stores->latitude = $request->latitude;
        $stores->longitude = $request->longitude;

        $stores->slug = Str::slug($stores->name);

        $stores->description = $request->description;
        $stores->save();

        // Redirect ke halaman yang sesuai setelah berhasil diupdate
        return redirect()->route('dashboard.official-store.index')
            ->with('success', 'Official Store berhasil diupdate.');
    }

    /**
     * Remove the resource from storage.
     */
    public function destroy($id)
    {
        if (Gate::denies('official-store-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        // Hapus data dari database
        $stores = OfficialStore::findOrFail($id);
        $stores->delete();

        // Redirect ke halaman yang sesuai setelah berhasil dihapus
        return redirect()->route('dashboard.official-store.index')
            ->with('success', 'Official Store berhasil dihapus.');
    }
}
