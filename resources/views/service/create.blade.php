@extends('main.dash')

@section('content')
<h1>Service Events</h1>

<form method="POST" action="/serviceEvent">
    @csrf
    <div class="form-group card">

        <label for="name" class="col-form-label offset-md-1 text-left">{{ __('Name of Event') }}</label>
        @if ($serviceEvents->count())
            <div class="form-group row">
                <label for="name" class="col-form-label offset-md-2 text-left">{{ __('Existing Events') }}</label>

                <div class="col-md-6">
                    <select class="form-control m-bot15 @error('service_event_id') is-invalid @enderror" name="service_event_id">
                        <option value="" >Choose Existing Event</option>
                    @foreach ($serviceEvents as $serviceEvent)
                        <option value="{{ $serviceEvent->id }}">{{ $serviceEvent->name }}</option>
                    @endforeach
                    </select>
                </div>
            </div>
        @endif

            <div class="form-group row">

                <label for="name" class="offcol-form-label offset-md-2 text-left">{{ __('New Event Name') }}</label>
                <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}"  autofocus>
                </div>
            </div>

            <div class="form-group row">
                    <label for="date_of_event" class="col-form-label offset-md-1 text-left">{{ __('Date of Event') }}</label>
                    <div class="col-md-6">
                        {{-- <div class="input-group date">
                            <input id="date_of_event" type="text" value="10/24/2019" class="form-control">
                            <span class="input-group-append">
                                <span class="input-group-text"><i class="font-icon font-icon-calend"></i></span>
                            </span>
                        </div> --}}
                            <input id="date_of_event" type="text" class="form-control"  name="date_of_event" placeholder="2019-05-20 03:50:15" value="2001-10-26 21:32:52" autofocus>
                    </div>
            </div>

            <div class="form-group row">
                    <label for="money_donated" class="col-form-label offset-md-1 text-left">{{ __('Money Donated') }}</label>
                    <div class="col-md-6">
                            <input id="money_donated" type="number" class="form-control @error('money_donated') is-invalid @enderror"  name="money_donated" value="{{ old('money_donated') }}"  autofocus>
                    </div>
            </div>

            <div class="form-group row">
                    <label for="hours_served" class="col-form-label offset-md-1 text-left">{{ __('Hours Served') }}</label>
                    <div class="col-md-6">
                            <input id="hours_served" type="number" class="form-control @error('hours_served') is-invalid @enderror" name="hours_served" value="{{ old('hours_served') }}"  autofocus>
                    </div>
            </div>

            <div class="form-group row mb-0">
                    <div class="col-md-6  offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Log Event') }}
                        </button>
                    </div>
            </div>
    </div>

</form>

@section('js')
<script>			$('#date_of_event').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true
    });
    </script>
@endsection



@endsection

