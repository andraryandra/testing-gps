@extends('layouts.dashboard')


@section('admin')
    {{-- <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Users Management</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('dashboard.users.create') }}"> Create New User</a>
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Roles</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($data as $key => $user)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if (!empty($user->getRoleNames()))
                        @foreach ($user->getRoleNames() as $v)
                            <label class="badge bg-success">{{ $v }}</label>
                        @endforeach
                    @endif
                </td>
                <td>
                    <a class="btn btn-info" href="{{ route('dashboard.users.show', $user->id) }}">Show</a>
                    <a class="btn btn-primary" href="{{ route('dashboard.users.edit', $user->id) }}">Edit</a>
                    {!! Form::open([
                        'method' => 'DELETE',
                        'route' => ['dashboard.users.destroy', $user->id],
                        'style' => 'display:inline',
                    ]) !!}
                    {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
    </table>


    {!! $data->render() !!} --}}


    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3">Tabel All User</div>
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
    <div class="card">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-lg-3 col-xl-2">
                    <a href="{{ route('dashboard.users.create') }}" class="btn btn-primary mb-3 mb-lg-0"
                        data-bs-toggle="tooltip" data-bs-placement="bottom" title="Tambah"><i
                            class="bi bi-plus-square-fill mx-1"></i>
                        Tambah User
                    </a>
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
                <h5 class="mb-0">Customer Details</h5>
                <form class="ms-auto position-relative">
                    <div class="position-absolute top-50 translate-middle-y search-icon px-3"><i class="bi bi-search"></i>
                    </div>
                    <input class="form-control ps-5" type="text" placeholder="search">
                </form>
            </div>
            <div class="table-responsive mt-3">
                <table class="table align-middle">
                    <thead class="table-secondary">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th width="280px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($data->chunk(10) as $chunk) --}}
                        {{-- @foreach ($chunk as $key => $user) --}}
                        @foreach ($data as $key => $user)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-3 cursor-pointer">
                                        <img src="{{ asset('dashboard/assets/images/avatars/avatar-1.png') }}"
                                            class="rounded-circle" width="44" height="44" alt="">
                                        <div class="">
                                            <p class="mb-0">{{ $user->name }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if (!empty($user->getRoleNames()))
                                        @foreach ($user->getRoleNames() as $v)
                                            <label class="badge bg-success">{{ $v }}</label>
                                        @endforeach
                                    @endif
                                </td>
                                <td>
                                    <div class="table-actions d-flex align-items-center gap-3 fs-6">
                                        <a href="{{ route('dashboard.users.show', $user->id) }}" class="text-primary mx-1"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Lihat">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        <a href="{{ route('dashboard.users.edit', $user->id) }}" class="text-warning mx-1"
                                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>

                                        <a href="{{ route('dashboard.users.destroy', $user->id) }}"
                                            class="text-danger mx-5" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                            title="Hapus"
                                            onclick="event.preventDefault();
                                                     if (confirm('Anda yakin ingin menghapus?')) {
                                                         document.getElementById('delete-form-{{ $user->id }}').submit();
                                                     }">
                                            <i class="bi bi-trash-fill"></i>
                                        </a>
                                        <form id="delete-form-{{ $user->id }}"
                                            action="{{ route('dashboard.users.destroy', $user->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        {{-- @endforeach --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {!! $data->render() !!}

@endsection
