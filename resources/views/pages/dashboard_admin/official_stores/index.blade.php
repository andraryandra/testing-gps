@extends('layouts.dashboard')


@section('admin')



    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Tabel Official Store</div>
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
                    @can('official-store-create')
                        <a href="{{ route('dashboard.official-store.create') }}" class="btn btn-sm btn-primary mb-3 mb-lg-0"
                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Tambah"><i
                                class="bi bi-plus-square-fill mx-1"></i>
                            Tambah Official Store
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
                    <form method="GET" action="{{ route('dashboard.official-store.index') }}">
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
                            <option value="{{ $stores->total() }}"
                                {{ request('perPage') == $stores->total() ? 'selected' : '' }}>Semua</option>
                        </select>
                    </form>

                </div>
                <div class="container mt-4">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Tampilkan jumlah data yang ditampilkan -->
                            @if (!$stores->isEmpty())
                                <p class="d-inline-block">Showing {{ $stores->firstItem() }} to
                                    {{ $stores->lastItem() }} of
                                    {{ $stores->total() }} entries</p>
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
                        <th>Category ID</th>
                        <th>Name Company</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>City</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($stores as $store)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $store['category']['name'] }}</td>
                            <td>{{ $store['name'] }}</td>
                            <td>{{ $store['phone'] }}</td>
                            <td>{{ $store['email'] }}</td>
                            <td>
                                @if ($store['status'] == 'ACTIVE')
                                    <span class="badge bg-success">ACTIVE</span>
                                @elseif ($store['status'] == 'INACTIVE')
                                    <span class="badge bg-danger">INACTIVE</span>
                                @endif
                            </td>
                            <td>{{ $store['city'] }}</td>
                            <td>{{ $store['latitude'] }}</td>
                            <td>{{ $store['longitude'] }}</td>
                            <td>{{ $store['description'] }}</td>
                            <td>
                                <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                    @can('official-store-edit')
                                        <a href="{{ route('dashboard.official-store.edit', $store['id']) }}"
                                            class="text-warning ml-4" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Edit"><i class="bi bi-pencil-fill"></i></a>
                                    @endcan
                                    @can('official-store-delete')
                                        <a href="{{ route('dashboard.official-store.destroy', $store->id) }}"
                                            class="text-danger mx-5" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            title="Hapus"
                                            onclick="event.preventDefault();
                                                     if (confirm('Anda yakin ingin menghapus?')) {
                                                         document.getElementById('delete-form-{{ $store->id }}').submit();
                                                     }">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                        <form id="delete-form-{{ $store->id }}"
                                            action="{{ route('dashboard.official-store.destroy', $store->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <th>#</th>
                    <th>Category ID</th>
                    <th>Name Company</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>City</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Description</th>
                    <th></th>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12 text-center">
                <!-- Tampilkan pagination links jika lebih dari 1 halaman -->
                @if ($stores->total() > $stores->perPage())
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item {{ $stores->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link"
                                    href="{{ $stores->appends(['perPage' => Request::get('perPage')])->url(1) }}"
                                    aria-label="First">
                                    <span aria-hidden="true">First</span>
                                </a>
                            </li>
                            {{ $stores->appends(['perPage' => Request::get('perPage')])->links() }}
                            <li class="page-item {{ $stores->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $stores->url($stores->lastPage()) }}" aria-label="Last">
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

        {{-- <script>
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
        </script> --}}
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
