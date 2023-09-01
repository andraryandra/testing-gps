@extends('layouts.dashboard')


@section('admin')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Data Official Store</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('dashboard.official-store.index') }}"> Back</a>
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



    {!! Form::model($officialStore, [
        'route' => ['dashboard.official-store.update', $officialStore->id],
        'method' => 'PUT',
    ]) !!}
    <div class="card my-3">
        <div class="card-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 my-2">
                    <div class="form-group">
                        <label for="category" class="my-2 fw-bold required">Category:</label>
                        {!! Form::select('category_id', $categories->pluck('name', 'id'), $officialStore->category_id, [
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 my-2">
                    <div class="form-group">
                        <label for="name" class="my-2 fw-bold required">Name:</label>
                        {!! Form::text('name', $officialStore->name, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 my-2">
                    <div class="form-group">
                        <label for="phone" class="my-2 fw-bold required">Phone:</label>
                        {!! Form::text('phone', $officialStore->phone, ['class' => 'form-control', 'placeholder' => 'Phone']) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 my-2">
                    <div class="form-group">
                        <label for="email" class="my-2 fw-bold required">Email:</label>
                        {!! Form::text('email', $officialStore->email, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 my-2">
                    <div class="form-group">
                        <label for="city" class="my-2 fw-bold required">City:</label>
                        {!! Form::text('city', $officialStore->city, ['class' => 'form-control', 'placeholder' => 'City']) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 my-2">
                    <div class="form-group">
                        <label for="province" class="my-2 fw-bold required">Province:</label>
                        {!! Form::text('province', $officialStore->province, ['class' => 'form-control', 'placeholder' => 'Province']) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 my-2">
                    <div class="form-group">
                        <label for="postal_code" class="my-2 fw-bold required">Postal Code:</label>
                        {!! Form::text('postal_code', $officialStore->postal_code, [
                            'class' => 'form-control',
                            'placeholder' => 'Postal Code',
                        ]) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 my-2">
                    <div class="form-group">
                        <label for="address" class="my-2 fw-bold required">Address:</label>
                        {!! Form::textarea('address', $officialStore->address, ['class' => 'form-control', 'placeholder' => 'Address']) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 my-2">
                    <div class="form-group">
                        <label for="latitude" class="my-2 fw-bold required">Latitude:</label>
                        {!! Form::text('latitude', $officialStore->latitude, ['class' => 'form-control', 'placeholder' => 'Latitude']) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 my-2">
                    <div class="form-group">
                        <label for="longitude" class="my-2 fw-bold required">Longitude:</label>
                        {!! Form::text('longitude', $officialStore->longitude, [
                            'class' => 'form-control',
                            'placeholder' => 'Longitude',
                        ]) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 my-2">
                    <div class="form-group">
                        <label for="description" class="my-2 fw-bold">Description:</label>
                        {!! Form::textarea('description', $officialStore->description, [
                            'class' => 'form-control',
                            'placeholder' => 'Description',
                        ]) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 my-2">
                    <div class="form-group">
                        {!! Form::label('status', 'Status:', ['class' => 'fw-bold required']) !!}
                        {!! Form::select('status', ['ACTIVE' => 'ACTIVE', 'INACTIVE' => 'INACTIVE'], $officialStore->status, [
                            'class' => 'form-control',
                        ]) !!}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}



@endsection
