@extends('layouts.dashboard')


@section('admin')

    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Tabel Visit Sales</div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard.admin') }}"><i class="bx bx-home-alt"></i></a>
                    </li>
                    @if (isset($breadcumb['links']))
                        @foreach ($breadcumb['links'] as $link)
                            <li class="breadcrumb-item">
                                <a href="{{ $link['url'] }}">{{ $link['name'] }}</a>
                            </li>
                        @endforeach
                    @endif
                    @if (isset($breadcumb['current']))
                        <li class="breadcrumb-item active" aria-current="page">{{ $breadcumb['current'] }}</li>
                    @endif
                </ol>
            </nav>
        </div>

    </div>
    <!--end breadcrumb-->

    @include('layouts.partials.alert-prompt.alert')

    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-lg-3 col-xl-2">
                    @can('visit-sales-create')
                        <a href="{{ route('dashboard.visit-sales.create') }}" class="btn btn-sm btn-primary mb-3 mb-lg-0"
                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Tambah"><i
                                class="bi bi-plus-square-fill mx-1"></i>
                            Tambah Visit Sales
                        </a>
                    @endcan
                </div>
                <div class="col-lg-9 col-xl-10">
                    <form class="float-lg-end">
                        <div class="row row-cols-lg-auto g-2">
                            <div class="col-12">
                                <a href="javascript:;" class="btn btn-light mb-3 mb-lg-0"><i
                                        class="bi bi-download"></i>Export</a>
                            </div>
                            <div class="col-12">
                                <a href="javascript:;" class="btn btn-light mb-3 mb-lg-0"><i
                                        class="bi bi-upload"></i>Import</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-lg-4 col-md-6 me-auto">
                    <label for="perPage">Search:</label>
                    <div class="ms-auto position-relative">
                        <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i
                                class="bi bi-search"></i></div>
                        <input class="form-control ps-5" type="text" placeholder="search produts">
                    </div>
                </div>
                <div class="col-lg-2 col-6 col-md-3">
                    <label for="status">Status:</label>
                    <select class="form-select">
                        <option>Status</option>
                        <option>Active</option>
                        <option>Disabled</option>
                        <option>Pending</option>
                        <option>Show All</option>
                    </select>
                </div>
                <div class="col-lg-2 col-6 col-md-3">
                    <form method="GET" action="{{ route('dashboard.visit-sales.index') }}">
                        <label for="perPage">Tampilkan:</label>
                        <select id="perPage" name="perPage" class="form-select" onchange="this.form.submit()">
                            <option value="10" {{ request('perPage') == '10' ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request('perPage') == '25' ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request('perPage') == '50' ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request('perPage') == '100' ? 'selected' : '' }}>100</option>
                            <option value="500" {{ request('perPage') == '500' ? 'selected' : '' }}>500</option>
                            <option value="1000" {{ request('perPage') == '1000' ? 'selected' : '' }}>1000</option>
                            <option value="2500" {{ request('perPage') == '2500' ? 'selected' : '' }}>2500</option>
                            <option value="5000" {{ request('perPage') == '5000' ? 'selected' : '' }}>5000</option>
                            <option value="{{ $visit_sales->total() }}"
                                {{ request('perPage') == $visit_sales->total() ? 'selected' : '' }}>Semua</option>
                        </select>
                    </form>

                </div>
                <div class="container mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Tampilkan jumlah data yang ditampilkan -->
                            @if (!$visit_sales->isEmpty())
                                <p class="d-inline-block">Showing {{ $visit_sales->firstItem() }} to
                                    {{ $visit_sales->lastItem() }} of
                                    {{ $visit_sales->total() }} entries</p>
                            @endif
                        </div>

                        <!-- Daftar data yang akan diperbarui -->
                        {{-- <button id="load-updated-data" style="display: none;" class="btn btn-primary">
                            Load New Updated Data
                        </button> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive mt-3">
            <table class="table align-middle">
                <thead class="table-secondary">
                    <tr>
                        <th>#</th>
                        <th>User Name</th>
                        <th>Official Store Name</th>
                        <th>IP Address</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Visit Sales Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($visit_schedules as $item)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->official_store->name }}</td>

                            @forelse ($item->visit_sales as $visit)
                                <td>{{ $visit['ip_address'] }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($visit['check_in'])->isoFormat('dddd, DD MMMM YYYY [at] HH:mm:ss (A)') }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($visit['check_out'])->isoFormat('dddd, DD MMMM YYYY [at] HH:mm:ss (A)') }}
                                </td>
                            @empty
                                <td>
                                    <span class="badge bg-warning">Belum Terisi</span>
                                </td>
                                <td>
                                    <span class="badge bg-warning">Belum Terisi</span>
                                </td>
                                <td>
                                    <span class="badge bg-warning">Belum Terisi</span>
                                </td>
                            @endforelse

                            <td>
                                {{ \Carbon\Carbon::parse($item['custom_visit_day'])->isoFormat('DD MMMM YYYY, dddd') }}
                            </td>
                            <td>
                                <form action="{{ route('dashboard.visit-sales.store.store-page') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="official_store_id" value="{{ $item->official_store_id }}">
                                    <input type="hidden" name="visit_schedules_id" value="{{ $item->id }}">

                                    @if (
                                        !$item->visit_sales->isEmpty() &&
                                            isset($item->visit_sales[0]->check_in) &&
                                            isset($item->visit_sales[0]->check_out) &&
                                            !$item->image_officials->isEmpty() &&
                                            isset($item->image_officials[0]->image))
                                        <button type="submit" class="btn btn-sm mx-2 my-2 btn-success"
                                            title="Outlet {{ $item['official_store']['name'] }}">Kunjungi Outlet
                                            {{ $item['official_store']['name'] }}
                                        </button>
                                    @elseif (isset($item->visit_sales[0]->check_in) &&
                                            isset($item->visit_sales[0]->check_out) &&
                                            $item->image_officials->isEmpty())
                                        <button type="submit" class="btn btn-sm mx-2 my-2 btn-warning"
                                            title="Outlet {{ $item['official_store']['name'] }}">Kunjungi Outlet
                                            {{ $item['official_store']['name'] }}
                                        </button>
                                    @elseif (isset($item->visit_sales[0]->check_in) &&
                                            is_null($item->visit_sales[0]->check_out) &&
                                            $item->image_officials->isEmpty())
                                        <button type="submit" class="btn btn-sm mx-2 my-2 btn-warning"
                                            title="Outlet {{ $item['official_store']['name'] }}">Kunjungi Outlet
                                            {{ $item['official_store']['name'] }}
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-sm mx-2 my-2 btn-secondary"
                                            title="Outlet {{ $item['official_store']['name'] }}">Kunjungi Outlet
                                            {{ $item['official_store']['name'] }}
                                        </button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No Data
                            </td>
                        </tr>
                    @endforelse

                </tbody>
                <tfoot>
                    <th>#</th>
                    <th>User Name</th>
                    <th>Official Store Name</th>
                    <th>IP Address</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Visit Sales Date</th>
                    <th></th>
                </tfoot>
            </table>
        </div>

    </div>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12 text-center">
                <!-- Tampilkan pagination links jika lebih dari 1 halaman -->
                @if ($visit_sales->total() > $visit_sales->perPage())
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item {{ $visit_sales->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ $visit_sales->appends(['perPage' => Request::get('perPage')])->url(1) }}"
                                    aria-label="First">
                                    <span aria-hidden="true">First</span>
                                </a>
                            </li>
                            {{ $visit_sales->appends(['perPage' => Request::get('perPage')])->links() }}
                            <li class="page-item {{ $visit_sales->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $visit_sales->url($visit_sales->lastPage()) }}"
                                    aria-label="Last">
                                    <span aria-hidden="true">Last</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                @endif
            </div>
        </div>
    </div>




    @push('script')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
            const loadUpdatedDataButton = document.getElementById('load-updated-data');

            function checkForUpdates() {
                fetch("{{ route('dashboard.official-store.loadNewData') }}")
                    .then(response => response.json())
                    .then(data => {
                        const newDataCount = data.newDataCount;

                        // Tampilkan jumlah data baru dalam tombol
                        loadUpdatedDataButton.textContent = `Load Updated Data (${newDataCount} new)`;

                        // Jika ada data baru, tampilkan tombol
                        if (newDataCount > 0) {
                            loadUpdatedDataButton.style.display = 'block';
                        } else {
                            loadUpdatedDataButton.style.display = 'none';
                        }

                        // Fungsi untuk mereload halaman saat tombol diklik
                        loadUpdatedDataButton.addEventListener('click', function(event) {
                            event.preventDefault();
                            location.reload(); // Fungsi ini akan mereload halaman.
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }

            // Polling data setiap 5 detik
            setInterval(checkForUpdates, 5000);

            // Panggil checkForUpdates() pertama kali saat halaman dimuat
            checkForUpdates();
        </script>
    @endpush

    @push('style')
        <style>
            /* Mengatur responsivitas pagination */
            .pagination {
                display: flex;
                justify-content: center;
                /* align-items: center; */
                /* margin-top: 20px; */
            }

            /* Mengatur tampilan pagination di perangkat dengan lebar kecil */
            @media (max-width: 768px) {
                .pagination {
                    flex-direction: column;
                }

                .pagination ul {
                    margin-top: 10px;
                }
            }
        </style>
    @endpush
@endsection
