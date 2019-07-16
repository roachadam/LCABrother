@extends('layouts.main')

@section('content')
    <header class="section-header">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                <h2>Edit Involvement Event Points</h2>
                </div>
            </div>
        </div>
    </header>
    <form action="/involvement/setPoints" method="POST">
        @csrf
        @include('partials.errors')
        @foreach ($events as $event)
            <div class="form-group row">
                <label for="point_value[]" class="col-md-4 col-form-label text-md-right">{{ __($event->name) }}</label>

                <input id="name[]" type="hidden" class="form-control" name="name[]" value="{{ $event->name }}">

                <div class="col-md-4">
                    <input id="point_value[]" type="text" class="form-control" name="point_value[]" value="{{ $event->points }}" autofocus required>
                </div>
            </div>
        @endforeach

        <div class="form-group row mb-0">
            <button type="submit" class="btn btn-primary offset-7">{{ __('Submit') }}</button>
        </div>
    </form>
@endsection
