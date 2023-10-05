@extends('layouts.dashboard')


@section('admin')



    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Tabel Category</div>
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
                    @can('category-create')
                        <a href="{{ route('dashboard.categories.create') }}" class="btn btn-sm btn-primary mb-3 mb-lg-0"
                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Tambah"><i
                                class="bi bi-plus-square-fill mx-1"></i>
                            Tambah Category
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
                <h5 class="mb-0">Categories Details</h5>
                <div class="ms-auto position-relative">
                    <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-search"></i>
                    </div>
                    <input type="text" id="searchInput" class="form-control ps-5" placeholder="Search...">
                </div>
            </div>
            <div class="table-responsive mt-3">
                <table id="example" class="table align-middle " style="width:100%">
                    <thead class="table-secondary">
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Detail</th>
                            <th>Dibuat</th>
                            <th width="280px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $kategori)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $kategori['name'] }}</td>
                                <td>{{ $kategori['detail'] }}</td>
                                <td>{{ $kategori['created_at'] }}</td>
                                <td>
                                    <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                        @can('category-edit')
                                            <a href="{{ route('dashboard.categories.edit', $kategori['id']) }}"
                                                class="text-warning ml-4" data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Edit"><i class="bi bi-pencil-fill"></i></a>
                                        @endcan
                                        @can('category-delete')
                                            <a href="{{ route('dashboard.categories.destroy', $kategori->id) }}"
                                                class="text-danger mx-5" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                title="Hapus"
                                                onclick="event.preventDefault();
                                                     if (confirm('Anda yakin ingin menghapus?')) {
                                                         document.getElementById('delete-form-{{ $kategori->id }}').submit();
                                                     }">
                                                <i class="bi bi-trash-fill"></i>
                                            </a>
                                            <form id="delete-form-{{ $kategori->id }}"
                                                action="{{ route('dashboard.categories.destroy', $kategori->id) }}"
                                                method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('style')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
        <style>
            #example_filter {
                display: none;
            }
        </style>
    @endpush

    @push('script')
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

        <script>
            $(document).ready(function() {
                var table = new DataTable('#example', {
                    "language": {
                        "search": "Search:",
                        "searchPlaceholder": "Search your word..."
                    },
                    columnDefs: [{
                        orderable: false,
                        targets: 4
                    }]
                });

                $('#searchInput').on('keyup', function() {
                    table.search(this.value).draw();
                });
            });
        </script>
    @endpush

    {{-- {!! $categories->render() !!} --}}
@endsection
