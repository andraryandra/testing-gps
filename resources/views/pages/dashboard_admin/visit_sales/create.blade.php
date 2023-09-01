@extends('layouts.dashboard')


@section('admin')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Tambah Data Baru Visit Sales</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('dashboard.visit-sales.index') }}"> Back</a>
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


    {!! Form::open(['route' => 'dashboard.visit-sales.store', 'method' => 'POST']) !!}
    <div class="card my-3">
        <div class="card-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 my-2">
                    <div class="form-group">
                        <label for="user_id" class="my-2 fw-bold required">Sales User:</label>
                        {!! Form::select('user_id', $users->pluck('name', 'id'), null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 my-2">
                    <div class="form-group">
                        <label for="official_store_id" class="my-2 fw-bold required">Official Store:</label>
                        {!! Form::select('official_store_id', $officialStores->pluck('name', 'id'), null, ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 my-2">
                    <div class="form-group">
                        <label for="ip_address" class="my-2 fw-bold">IP Address:</label>
                        {!! Form::text('ip_address', null, ['class' => 'form-control', 'placeholder' => 'IP Address']) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 my-2">
                    <div class="form-group">
                        <label for="check_in" class="my-2 fw-bold required">Check In:</label>
                        {!! Form::datetimeLocal('check_in', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 my-2">
                    <div class="form-group">
                        <label for="check_out" class="my-2 fw-bold">Check Out:</label>
                        {!! Form::datetimeLocal('check_out', null, ['class' => 'form-control']) !!}
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}



@endsection
