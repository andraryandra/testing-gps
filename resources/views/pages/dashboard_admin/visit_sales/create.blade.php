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
                        {{-- <label for="official_store_id" class="my-2 fw-bold required">Official Store:</label>
                        {!! Form::select('official_store_id', $officialStores->pluck('name', 'id'), null, ['class' => 'form-control']) !!} --}}
                        <label for="official_store_id" class="fw-bold">Official Store:</label>
                        <select name="official_store_id" id="official_store_id" class="form-control">
                            <option value="">Select an Official Store</option>
                            @foreach ($officialStores as $officialStore)
                                <option value="{{ $officialStore->id }}" data-latitude="{{ $officialStore->latitude }}"
                                    data-longitude="{{ $officialStore->longitude }}">{{ $officialStore->name }}</option>
                            @endforeach
                        </select>
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


                <div class="col-xs-12 col-sm-12 col-md-12 my-2">
                    <div class="form-group">
                        {{-- <label for="latitude" class="my-2 fw-bold">Latitude:</label>
                        {!! Form::text('latitude', null, ['id' => 'latitude', 'class' => 'form-control', 'placeholder' => 'Latitude']) !!} --}}
                        <label for="latitude" class="fw-bold">Latitude:</label>
                        <input type="text" name="latitude" id="latitude" class="form-control" placeholder="Latitude"
                            readonly>

                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 my-2">
                    <div class="form-group">
                        {{-- <label for="longitude" class="my-2 fw-bold">Longitude:</label>
                        {!! Form::text('longitude', null, [
                            'id' => 'longitude',
                            'class' => 'form-control',
                            'placeholder' => 'Longitude',
                        ]) !!} --}}
                        <label for="longitude" class="fw-bold">Longitude:</label>
                        <input type="text" name="longitude" id="longitude" class="form-control" placeholder="Longitude"
                            readonly>

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

        {{-- <script>
            document.addEventListener('DOMContentLoaded', function() {
                var officialStoreDropdown = document.getElementById('official_store_id');
                var latitudeInput = document.getElementById('latitude');
                var longitudeInput = document.getElementById('longitude');

                officialStoreDropdown.addEventListener('change', function() {
                    var selectedOfficialStoreId = officialStoreDropdown.value;

                    if (!selectedOfficialStoreId) {
                        return;
                    }

                    fetch('{{ route('dashboard.visit-sales.json.location') }}/' + selectedOfficialStoreId)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            latitudeInput.value = data.latitude;
                            longitudeInput.value = data.longitude;
                        })
                        .catch(error => {
                            console.error('There was a problem with the fetch operation:', error);
                            alert('An error occurred while fetching location data');
                        });
                });
            });
        </script> --}}

        <script>
            var officialStoreDropdown = document.getElementById('official_store_id');
            var latitudeInput = document.getElementById('latitude');
            var longitudeInput = document.getElementById('longitude');

            officialStoreDropdown.addEventListener('change', function() {
                var selectedOfficialStoreId = this.value;

                $.ajax({
                    type: 'GET',
                    url: "{{ route('dashboard.visit-sales.json.location') }}", // Gunakan route() untuk menghasilkan URL dengan nama rute
                    data: {
                        selected: selectedOfficialStoreId
                    },
                    success: function(response) {
                        $("#latitude").val(response.latitude);
                        $("#longitude").val(response.longitude);
                    }
                })
            });
        </script>
    @endpush


@endsection
