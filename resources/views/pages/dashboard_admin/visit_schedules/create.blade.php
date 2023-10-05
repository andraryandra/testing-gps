@extends('layouts.dashboard')


@section('admin')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Tambah Data Baru Visit Schedules</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('dashboard.visit-schedules.index') }}"> Back</a>
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


    {!! Form::open(['route' => 'dashboard.visit-schedules.store', 'method' => 'POST']) !!}
    <div class="card my-3">
        <div class="card-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 my-2">
                    <div class="form-group">
                        <label for="user_id" class="my-2 fw-bold required">Sales User:</label>
                        {!! Form::select('user_id', $users->pluck('name', 'id'), null, ['class' => 'single-select']) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 my-2">
                    <div class="form-group">
                        <label for="official_store_id" class="my-2 fw-bold required">Official Store:</label>
                        {!! Form::select('official_store_id', $officialStoresSelect->pluck('name', 'id'), null, [
                            'class' => 'single-select',
                        ]) !!}
                    </div>
                </div>

                {{ $officialStoresSelect->render() }}

                <div class="col-xs-12 col-sm-12 col-md-12 my-2">
                    <div class="form-group">
                        <label for="custom_visit_day" class="my-2 fw-bold required">Visit Day:</label>
                        {!! Form::date('custom_visit_day', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 my-2">
                    <div class="form-group">
                        <label for="custom_visit_note" class="my-2 fw-bold">Note:</label>
                        {!! Form::textarea('custom_visit_note', null, ['class' => 'form-control', 'placeholder' => 'Note']) !!}
                    </div>
                </div>

            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}


    @push('script')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Pastikan Anda telah menyertakan jQuery -->
    @endpush


@endsection
