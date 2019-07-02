@extends('layouts.main')

@section('content')
    <form action="" method="POST">
        @csrf
        @method('PATCH')

        @foreach ($nullEvents as $event)
            <div class="form-group row">
                <label for="point_value" class="col-md-4 col-form-label text-md-right">{{ __($event->name) }}</label>

                <div class="col-md-4">
                    <input id="point_value" type="text" class="form-control" name="point_value" value="{{ $event->points }}" autofocus>
                </div>
            </div>
        @endforeach

        <div class="form-group row mb-0">
            <button type="submit" class="btn btn-primary offset-7">{{ __('Submit') }}</button>
        </div>
    </form>
@endsection
