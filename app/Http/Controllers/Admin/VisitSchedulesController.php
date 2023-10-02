<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Ramsey\Uuid\Uuid;
use Illuminate\View\View;
use App\Models\Sales\Visit;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Termwind\Components\Raw;
use App\Models\VisitSchedules;
use App\Models\Toko\OfficialStore;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\VisitSchedulesRequest;

class VisitSchedulesController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:visit-schedules-list|visit-schedules-create|visit-schedules-edit|visit-schedules-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:visit-schedules-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:visit-schedules-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:visit-schedules-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        if (Gate::denies('visit-schedules-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        // $visit_schedules = VisitSchedules::with('user', 'official_store')->get();

        // $visit_sales = Visit::select(['id', 'user_id', 'official_store_id', 'ip_address', 'check_in', 'check_out'])->latest()->paginate(10);
        $perPage = $request->input('perPage', 10); // Jumlah data per halaman, default 10.

        $query = VisitSchedules::select(['id', 'user_id', 'official_store_id', 'custom_visit_day', 'custom_visit_note', 'created_at'])->latest();

        // Check if $perPage is 'Semua' to decide whether to use paginate or not.
        if ($perPage == 'Semua') {
            // Fetch all data using chunk to process them in smaller chunks.
            $chunkSize = 500; // Jumlah data per potongan.
            $visit_schedules = [];
            $query->chunk($chunkSize, function ($visitsChunk) use (&$visit_schedules) {
                foreach ($visitsChunk as $visit) {
                    // Lakukan pengolahan data di sini untuk setiap toko.
                    // Misalnya, Anda dapat melakukan sesuatu seperti:
                    // $store->name atau $store->status
                    $visit_schedules[] = $visit;
                }
            });
        } else {
            // Use paginate if $perPage is not 'Semua'.
            $visit_schedules = $query->paginate($perPage);
        }

        return view('pages.dashboard_admin.visit_schedules.index', [
            'visit_schedules' => $visit_schedules,
            'title' => 'Visit Schedules',
            'active' => 'visit-schedules',
            'i' => ($visit_schedules->currentPage() - 1) * $visit_schedules->perPage() + 1,
            'breadcumb' => [
                'links' => [
                    [
                        'name' => 'Visit Schedules',
                        'url' => route('dashboard.visit-schedules.index'),
                    ],
                ],
            ],
        ]);
    }
    /**
     * Show the form for creating the resource.
     */
    public function create(): View
    {
        if (Gate::denies('visit-schedules-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        $users = User::select(['id', 'name'])->get();
        $official_stores = OfficialStore::select(['id', 'name'])->get();
        $officialStoresSelect = OfficialStore::paginate(10); // Paginasi dengan 10 item per halaman

        return view('pages.dashboard_admin.visit_schedules.create', [
            'title' => 'Visit Schedules',
            'active' => 'visit-schedules',
            'users' => $users,
            'officialStores' => $official_stores,
            'officialStoresSelect' => $officialStoresSelect,
        ]);
    }

    /**
     * Store the newly created resource in storage.
     */
    public function store(VisitSchedulesRequest $request): RedirectResponse
    {
        if (Gate::denies('visit-schedules-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        $visit_schedules = new VisitSchedules();
        $visit_schedules->user_id = $request->user_id;
        $visit_schedules->official_store_id = $request->official_store_id;
        $visit_schedules->custom_visit_day = $request->custom_visit_day;
        $visit_schedules->custom_visit_note = $request->custom_visit_note;
        $visit_schedules->save();

        if ($visit_schedules) {
            return redirect()->route('dashboard.visit-schedules.index')->with('success', 'Visit Schedules has been created successfully!');
        } else {
            return redirect()->route('dashboard.visit-schedules.index')->with('error', 'Visit Schedules failed to create!');
        }
    }

    /**
     * Display the resource.
     */
    public function show(): never
    {
        abort(404);
    }

    /**
     * Show the form for editing the resource.
     */
    public function edit($id): View
    {
        if (Gate::denies('visit-schedules-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        $visit_schedules = VisitSchedules::findOrFail($id);
        $users = User::select(['id', 'name'])->get();
        $official_stores = OfficialStore::select(['id', 'name'])->get();

        return view('pages.dashboard_admin.visit_schedules.edit', [
            'title' => 'Visit Schedules',
            'active' => 'visit-schedules',
            'visit_schedules' => $visit_schedules,
            'users' => $users,
            'officialStores' => $official_stores,
        ]);
    }

    /**
     * Update the resource in storage.
     */
    public function update(VisitSchedulesRequest $request, $id): RedirectResponse
    {
        if (Gate::denies('visit-schedules-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        $visit_schedules = VisitSchedules::findOrFail($id);
        $visit_schedules->user_id = $request->user_id;
        $visit_schedules->official_store_id = $request->official_store_id;
        $visit_schedules->custom_visit_day = $request->custom_visit_day;
        $visit_schedules->custom_visit_note = $request->custom_visit_note;
        $visit_schedules->save();

        if ($visit_schedules) {
            return redirect()->route('dashboard.visit-schedules.index')->with('success', 'Visit Schedules has been updated successfully!');
        } else {
            return redirect()->route('dashboard.visit-schedules.index')->with('error', 'Visit Schedules failed to update!');
        }
    }

    /**
     * Remove the resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        if (Gate::denies('visit-schedules-list')) {
            abort(403); // Tampilkan halaman 403 Forbidden jika tidak memiliki izin.
        }

        $visit_schedules = VisitSchedules::findOrFail($id);
        $visit_schedules->delete();

        if ($visit_schedules) {
            return redirect()->route('dashboard.visit-schedules.index')->with('success', 'Visit Schedules has been deleted successfully!');
        } else {
            return redirect()->route('dashboard.visit-schedules.index')->with('error', 'Visit Schedules failed to delete!');
        }
    }
}
