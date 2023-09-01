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
            <div class="d-flex align-items-center">
                <h5 class="mb-0">Official Store Details</h5>
                <form class="ms-auto position-relative">
                    <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-search"></i>
                    </div>
                    <input class="form-control ps-5" type="text" placeholder="search">
                </form>


            </div>
            <div class="table-responsive mt-3">
                {{-- <table id="official-store-table" class="table align-middle"> --}}
                <table id="crudTable" class="table align-middle data-table">
                    <thead class="table-secondary">
                        <tr>
                            <th>No</th>
                            <th>Category ID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>City</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th>Slug</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- @push('script') --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            // Setup - add a text input to each footer cell
            $('#crudTable tfoot th:not(:last-child):not(.no-search)').each(function() {
                var title = $(this).text();
                $(this).html(
                    '<input type="text" class="text-xs rounded-full font-semibold tracking-wide text-left " style="text-align: left;" placeholder="Search ... ' +
                    title + '" />'
                );
            });

            // DataTable
            var table = $('#crudTable').DataTable({
                initComplete: function() {
                    // Apply the search
                    this.api()
                        .columns(':not(:last-child)')
                        .every(function() {
                            var that = this;

                            $('input', this.footer()).on('keyup change clear', function() {
                                if (that.search() !== this.value) {
                                    that.search(this.value).draw();
                                }
                            });
                        });
                    // Set width for search tfoot
                    $('tfoot tr').children().each(function(index, element) {
                        if (index == 0) {
                            $(element).css('width', '2%'); // Set width for id column
                        } else if (index == 1) {
                            $(element).css('width', '7%'); // Set width for id column
                        } else if (index == 2) {
                            $(element).css('width', '7%'); // Set width for id column
                        } else if (index == 3) {
                            $(element).css('width', '10%'); // Set width for id column
                        } else if (index == 4) {
                            $(element).css('width', '8%'); // Set width for id column
                        } else if (index == 5) {
                            $(element).css('width', '10%'); // Set width for id column
                        } else {
                            $(element).css('width', 'auto'); // Set width for other columns
                        }
                    });
                },
                processing: true,
                serverSide: true,
                responsive: false,
                ajax: {
                    url: '{!! url()->current() !!}',
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'category_id',
                        name: 'category_id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'phone',
                        name: 'phone'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'city',
                        name: 'city'
                    },
                    {
                        data: 'latitude',
                        name: 'latitude'
                    },
                    {
                        data: 'longitude',
                        name: 'longitude'
                    },
                    {
                        data: 'slug',
                        name: 'slug'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
    {{-- @endpush --}}






    @push('style')
        {{-- <style>
            /* CSS Bootstrap untuk tombol "First" dan "Last" */
            .pagination {
                justify-content: center;
            }

            .pagination .page-item:first-child .page-link,
            .pagination .page-item:last-child .page-link {
                border-radius: 0;
            }

            .pagination .page-item:first-child .page-link::before,
            .pagination .page-item:last-child .page-link::before {
                content: "«";
                /* Simbol "First" dan "Last" */
                margin-right: 0.25rem;
            }

            .pagination .page-item:first-child .page-link:hover::before,
            .pagination .page-item:last-child .page-link:hover::before {
                text-decoration: none;
            }

            .pagination .page-item:first-child .page-link[aria-disabled="true"]::before,
            .pagination .page-item:last-child .page-link[aria-disabled="true"]::before {
                color: #6c757d;
                /* Warna tombol nonaktif */
            }
        </style> --}}
    @endpush
@endsection
