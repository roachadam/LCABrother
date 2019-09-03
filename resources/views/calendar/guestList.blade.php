@extends('layouts.main')

@section('content')

<div class="container">
    @include('partials.errors')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Add Event') }}</div>
                <div class="card-body">
                    <form method="POST" action="/calendarItem/{{$calendarItem->id}}/event/create">
                        @csrf
                        {{-- <div class="col-md-12"> --}}

                            <label for="name" class="col-form-label text-md-left">{{ __('Event Name') }}</label>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="form-control-wrapper form-control-icon-left">
                                        <input id="name" type="text" class="form-control " name="name" value="{{$calendarItem->name}}" required autocomplete="name" autofocus>
                                        <i class="fa fa-pencil"></i>
                                    </div>
                                </div>
                            </div>

                            <label for='date_of_event' class="col-form-label text-md-left">{{ __('Date of Event') }}</label>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="form-control-wrapper form-control-icon-left">
                                        <input id="date_of_event" type="date" class="form-control" name="date_of_event" value="{{ \Carbon\Carbon::parse($calendarItem->start_datetime)->format('Y-m-d') }}" required autocomplete="date_of_event" autofocus>
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                            </div>

                            <label for='num_invites' class="col-form-label text-md-left">{{ __('# Of Invites Per Member') }}</label>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="form-control-wrapper form-control-icon-left">
                                        <input id="num_invites" type="text" class="form-control " name="num_invites" value="{{ old('num_invites') }}" required autocomplete="num_invites" autofocus>
                                        <i class="fa fa-users"></i>
                                    </div>
                                </div>
                            </div>

                        {{-- </div> --}}

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Add Event') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
