@extends('layouts.dashboard')


@section('admin')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Data Visit Schedules</h2>
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



    {!! Form::model($visit_schedules, [
        'route' => ['dashboard.visit-schedules.update', $visit_schedules->id],
        'method' => 'PUT',
    ]) !!}
    <div class="card my-3">
        <div class="card-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 my-2">
                    <div class="form-group">
                        <label for="user_id" class="my-2 fw-bold required">Sales User:</label>
                        {!! Form::select('user_id', $users->pluck('name', 'id'), $visit_schedules->user_id, [
                            'class' => 'single-select',
                        ]) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 my-2">
                    <div class="form-group">
                        <label for="official_store_id" class="my-2 fw-bold required">Official Store:</label>
                        {!! Form::select(
                            'official_store_id',
                            $officialStores->pluck('name', 'id'),
                            $visit_schedules->official_store_id,
                            ['class' => 'single-select'],
                        ) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 my-2">
                    <div class="form-group">
                        <label for="custom_visit_day" class="my-2 fw-bold required">Visit Day:</label>
                        {!! Form::date('custom_visit_day', $visit_schedules->custom_visit_day, [
                            'class' => 'form-control',
                            'required' => 'required',
                        ]) !!}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 my-2">
                    <div class="form-group">
                        <label for="custom_visit_note" class="my-2 fw-bold">Note:</label>
                        {!! Form::textarea('custom_visit_note', $visit_schedules->custom_visit_note, [
                            'class' => 'form-control',
                            'placeholder' => 'Note',
                        ]) !!}
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
