@extends('layouts.dashboard')


@section('admin')
    <div class="row mb-3">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Visit Sales - {{ $visit_sales['official_store']['name'] }}</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('dashboard.visit-sales.index') }}"> Back</a>
            </div>
        </div>
    </div>

    @include('layouts.partials.alert-prompt.alert')

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="mb-3">
                <label for="name">Visit Schedulues</label>
                @php
                    use Carbon\Carbon;
                @endphp

                {!! Form::text(
                    'visit_schedules_id',
                    Carbon::parse($visit_sales['visit_schedules']['custom_visit_day'])->isoFormat('DD MMMM YYYY, dddd'),
                    [
                        'class' => 'form-control',
                        'required' => 'required',
                        'disabled' => 'disabled',
                    ],
                ) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="mb-3">
                <label for="name">Official Stores</label>
                {!! Form::text('name', $visit_sales['official_store']['name'], [
                    'class' => 'form-control',
                    'required' => 'required',
                    'disabled' => 'disabled',
                ]) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="mb-3">
                <label for="ip_address">IP Address</label>
                {!! Form::text('ip_address', $visit_sales['ip_address'], [
                    'class' => 'form-control',
                    'required' => 'required',
                    'disabled' => 'disabled',
                ]) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="mb-3">
                <label for="check_in">Check In</label>
                {!! Form::datetimeLocal('check_in', $visit_sales['check_in'], [
                    'class' => 'form-control',
                    'required' => 'required',
                    'disabled' => 'disabled',
                ]) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="mb-3">
                <label for="check_in">Post Image</label>
                <a href="{{ route('dashboard.visit-sales.createStoreImageOfficial', ['id' => $visit_sales['id']]) }}"
                    class="btn btn-action btn-sm @if (!empty($imageOfficial['image'])) btn-success @else btn-primary @endif"
                    title="Post Image">Image @if (empty($imageOfficial['image']))
                        (Belum terisi)
                    @else
                        (Sudah terisi)
                    @endif
                </a>
            </div>
        </div>



        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <div class="mb-3">
                <label for="check_out">Check Out</label>
                <br>
                @if (is_null($visit_sales->check_out))
                    {!! Form::open(['route' => ['dashboard.visit-sales.check-out', $visit_sales->id], 'method' => 'POST']) !!}
                    {!! Form::hidden('_method', 'PUT') !!}
                    {!! Form::hidden('latitude', null, ['id' => 'latitude']) !!} <!-- Field tersembunyi untuk latitude -->
                    {!! Form::hidden('longitude', null, ['id' => 'longitude']) !!} <!-- Field tersembunyi untuk longitude -->
                    <button type="submit" class="btn btn-primary btn-sm">Check Out</button>
                    {!! Form::close() !!}
                @else
                    <!-- Tambahkan pesan atau tindakan yang sesuai ketika check_out sudah terisi -->
                    <p>Visit has already been checked out.</p>
                @endif
            </div>
        </div>
    </div>

    @push('script')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Pastikan Anda telah menyertakan jQuery -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelector('button[type="submit"]').addEventListener('click', function(e) {
                    e.preventDefault(); // Mencegah formulir terkirim secara otomatis

                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(function(position) {
                            var latitude = position.coords.latitude;
                            var longitude = position.coords.longitude;

                            // Mengisi nilai latitude dan longitude ke field tersembunyi
                            document.getElementById('latitude').value = latitude;
                            document.getElementById('longitude').value = longitude;

                            // Mengirimkan formulir
                            this.closest('form').submit(); // Melakukan submit formulir
                        }.bind(this));
                    } else {
                        alert('Geolocation tidak didukung di peramban ini.');
                    }
                });
            });
        </script>



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
