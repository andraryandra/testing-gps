@extends('layouts.dashboard')


@section('admin')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Tambah Data Baru Kategori</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('dashboard.categories.index') }}"> Back</a>
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



    {!! Form::open(['route' => 'dashboard.categories.store', 'method' => 'POST']) !!}
    <div class="card my-3">

        <div class="card-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 my-2">
                    <div class="form-group">
                        <strong>Nama Kategori:</strong>
                        {!! Form::text('name', null, ['placeholder' => 'Nama Kategori', 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 my-2">
                    <div class="form-group">
                        <strong>Detail Kategori:</strong>
                        {!! Form::text('detail', null, ['placeholder' => 'Detail Kategori', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}


@endsection
