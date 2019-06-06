@extends('layouts.dashtheme')
@section('title', 'Add Service Log')
@section('content')

<div class="text-container">
        <h3 class="app__main__title">Service Logs</h3>
</div>
<form method="POST" action="/serviceEvent">
    @csrf
    @include('partials.errors')


    @if ($serviceEvents->count())
            <label>Existing Events</label>
            <select class="form-control m-bot15" name="service_event_id" id="service_event_id">
                <option value="-1" >Choose Existing Event</option>
            @foreach ($serviceEvents as $serviceEvent)
                <option value="{{ $serviceEvent->id }}">{{ $serviceEvent->name }}</option>
            @endforeach
            </select>
    @endif

    <label>New Event Name</label>
    <input id="name" type="text" class="fakefield" name="name" value="{{ old('name') }}"  autofocus>

    <label>Date of Event</label>
    <input id="date_of_event" type="text" class="fakefield"  name="date_of_event" placeholder="2019-05-20 03:50:15" value="2001-10-26 21:32:52" autofocus>

    <label for="money_donated" class="col-form-label offset-md-1 text-left">{{ __('Money Donated') }}</label>
    <input id="money_donated" type="number" class="fakefield"  name="money_donated" value="{{ old('money_donated') }}"  autofocus>

    <label>Hours Served</label>
    <input id="hours_served" type="number" class="fakefield" name="hours_served" value="{{ old('hours_served') }}"  autofocus>

    <button type="submit" class="btn btn-primary">Log Event</button>

</form>

@section('js')
<script>
    var dis1 = document.getElementById("service_event_id");
    dis1.onchange = function () {
        if (dis1.value != "-1") {
            document.getElementById("name").disabled = true;
        }
        if (dis1.value === "-1") {
            document.getElementById("name").disabled = false;
        }
    }
</script>

<script>
    var dis1 = document.getElementById("name");
    dis1.onchange = function () {
        if (this.value != "" || this.value.length > 0) {
            document.getElementById("service_event_id").disabled = true;
        }
    }
</script>

@endsection

@endsection

