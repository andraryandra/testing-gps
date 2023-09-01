<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Sales\Visit;
use Illuminate\Http\Request;
use App\Models\Toko\OfficialStore;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\VisitSalesRequest;

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
    public function index(Request $request)
    {
        if (Gate::denies('visit-sales-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        // $visit_sales = Visit::select(['id', 'user_id', 'official_store_id', 'ip_address', 'check_in', 'check_out'])->latest()->paginate(10);
        $perPage = $request->input('perPage', 10); // Jumlah data per halaman, default 10.

        $query = Visit::select(['id', 'user_id', 'official_store_id', 'ip_address', 'check_in', 'check_out'])->latest();

        // Check if $perPage is 'Semua' to decide whether to use paginate or not.
        if ($perPage == 'Semua') {
            // Fetch all data using chunk to process them in smaller chunks.
            $chunkSize = 500; // Jumlah data per potongan.
            $visits = [];
            $query->chunk($chunkSize, function ($visitsChunk) use (&$visits) {
                foreach ($visitsChunk as $visit) {
                    // Lakukan pengolahan data di sini untuk setiap toko.
                    // Misalnya, Anda dapat melakukan sesuatu seperti:
                    // $store->name atau $store->status
                    $visits[] = $visit;
                }
            });
        } else {
            // Use paginate if $perPage is not 'Semua'.
            $visits = $query->paginate($perPage);
        }



        return view('pages.dashboard_admin.visit_sales.index', [
            'visit_sales' => $visits,
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
        $visit_sales->ip_address = $request->ip_address;
        $visit_sales->check_in = $request->check_in;
        $visit_sales->check_out = $request->check_out;
        $visit_sales->save();

        return redirect()->route('dashboard.visit-sales.index')->with('success', 'Visit Sales has been created!');
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
