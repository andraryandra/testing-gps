@extends('layouts.dashboard')


@section('admin')
    <div class="row mb-3">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Visit Sales - {{ $visit_sales['official_store']['name'] }} - Image</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('dashboard.visit-sales.create.store-page', $visit_sales['id']) }}">
                    Back</a>
            </div>
        </div>
    </div>

    @include('layouts.partials.alert-prompt.alert')


    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="mb-3">
                        @php
                            use Carbon\Carbon;
                        @endphp
                        <div class="my-2">
                            <label for="official_store_id">Official Store:</label>
                            {!! Form::text('official_store_id', $visit_sales['official_store']['name'], [
                                'class' => 'form-control my-2',
                                'disabled' => 'disabled',
                            ]) !!}
                        </div>
                        <div class="my-2">
                            <label for="visit_schedules_id">Visit Schedules:</label>
                            {!! Form::text(
                                'visit_schedules_id',
                                Carbon::parse($visit_sales['visit_schedules']['custom_visit_day'])->isoFormat('DD MMMM YYYY, dddd'),
                                [
                                    'class' => 'form-control my-2',
                                    'disabled' => 'disabled',
                                ],
                            ) !!}
                        </div>
                        {!! Form::open([
                            'route' => ['dashboard.visit-sales.storeImageOfficial', $visit_sales->id],
                            'method' => 'POST',
                            'enctype' => 'multipart/form-data',
                        ]) !!}
                        @method('PUT')
                        @csrf
                        {!! Form::hidden('official_store_id', $visit_sales['official_store']['id']) !!}
                        {!! Form::hidden('visit_schedules_id', $visit_sales['visit_schedules_id']) !!}
                        <div class="my-2">
                            <label for="image">Image Official Store:</label>
                            {!! Form::file('image', ['class' => 'form-control']) !!}
                            @if (isset($imageOfficial['image']))
                                <img src="{{ Storage::url($imageOfficial->image) }}" alt="Image" class="rounded my-2"
                                    width="10%">
                            @endif
                        </div>


                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-sm col-md-2 p-2 shadow"
                                title="Simpan">Save</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Pastikan Anda telah menyertakan jQuery -->
    @endpush
@endsection
