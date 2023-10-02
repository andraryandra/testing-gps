@extends('layouts.dashboard')


@section('admin')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Role</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('dashboard.roles.index') }}"> Back</a>
            </div>
        </div>
    </div>


    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif


    {!! Form::model($role, ['method' => 'PATCH', 'route' => ['dashboard.roles.update', $role->id]]) !!}
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Name:</strong>
                {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
            </div>
        </div>
        {{-- <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Permission:</strong>
                <br />
                @foreach ($permission as $value)
                    <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, ['class' => 'name']) }}
                        {{ $value->name }}</label>
                    <br />
                @endforeach
            </div>
        </div> --}}


        <div class="row my-4">
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-center">
                            <h5 class="mb-0">Menu Role</h5>
                        </div>
                        <hr />
                        <div class="form-group">
                            @foreach ($permission as $value)
                                @if (strpos($value->name, 'role-') === 0)
                                    <div class="form-check my-2">
                                        <label class="form-check-label" for="permission_{{ $value->id }}">
                                            {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, ['class' => 'form-check-input', 'id' => 'permission_' . $value->id]) }}
                                            <span class="mx-2">{{ $value->name }}</span>
                                        </label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-center">
                            <h5 class="mb-0">Menu Users</h5>
                        </div>
                        <hr />
                        <div class="form-group">
                            @foreach ($permission as $value)
                                @if (strpos($value->name, 'users-') === 0)
                                    <div class="form-check my-2">
                                        <label class="form-check-label" for="permission_{{ $value->id }}">
                                            {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, ['class' => 'form-check-input', 'id' => 'permission_' . $value->id]) }}
                                            <span class="mx-2">{{ $value->name }}</span>
                                        </label>

                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-center">
                            <h5 class="mb-0">Menu Category</h5>
                        </div>
                        <hr />
                        <div class="form-group">
                            @foreach ($permission as $value)
                                @if (strpos($value->name, 'category-') === 0)
                                    <div class="form-check my-2">
                                        <label class="form-check-label" for="permission_{{ $value->id }}">
                                            {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, ['class' => 'form-check-input', 'id' => 'permission_' . $value->id]) }}
                                            <span class="mx-2">{{ $value->name }}</span>
                                        </label>

                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-center">
                            <h5 class="mb-0">Menu Produk</h5>
                        </div>
                        <hr />
                        <div class="form-group">
                            @foreach ($permission as $value)
                                @if (strpos($value->name, 'product-') === 0)
                                    <div class="form-check my-2">
                                        <label class="form-check-label" for="permission_{{ $value->id }}">
                                            {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, ['class' => 'form-check-input', 'id' => 'permission_' . $value->id]) }}
                                            <span class="mx-2">{{ $value->name }}</span>
                                        </label>

                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-center">
                            <h5 class="mb-0">Menu Official Store</h5>
                        </div>
                        <hr />
                        <div class="form-group">
                            @foreach ($permission as $value)
                                @if (strpos($value->name, 'official-store-') === 0)
                                    <div class="form-check my-2">
                                        <label class="form-check-label" for="permission_{{ $value->id }}">
                                            {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, ['class' => 'form-check-input', 'id' => 'permission_' . $value->id]) }}
                                            <span class="mx-2">{{ $value->name }}</span>
                                        </label>

                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-center">
                            <h5 class="mb-0">Menu Visit Schedules</h5>
                        </div>
                        <hr />
                        <div class="form-group">
                            @foreach ($permission as $value)
                                @if (strpos($value->name, 'visit-schedules-') === 0)
                                    <div class="form-check my-2">
                                        <label class="form-check-label" for="permission_{{ $value->id }}">
                                            {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, ['class' => 'form-check-input', 'id' => 'permission_' . $value->id]) }}
                                            <span class="mx-2">{{ $value->name }}</span>
                                        </label>

                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-center">
                            <h5 class="mb-0">Menu Visit Sales</h5>
                        </div>
                        <hr />
                        <div class="form-group">
                            @foreach ($permission as $value)
                                @if (strpos($value->name, 'visit-sales-') === 0)
                                    <div class="form-check my-2">
                                        <label class="form-check-label" for="permission_{{ $value->id }}">
                                            {{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, ['class' => 'form-check-input', 'id' => 'permission_' . $value->id]) }}
                                            <span class="mx-2">{{ $value->name }}</span>
                                        </label>

                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>




        </div>


        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
    {!! Form::close() !!}


    @push('style')
        <style>
            input[type=checkbox] {
                transform: scale(1.5);
            }

            /* Might want to wrap a span around your checkbox text */
        </style>
    @endpush

@endsection
