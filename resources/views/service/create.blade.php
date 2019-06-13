@extends('layouts.main')
@section('title', 'Add Service Log')
@section('content')

<div class="text-container">
        <h3 class="app__main__title">Service Logs</h3>
</div>
<form method="POST" action="/serviceEvent">
    @csrf
    @include('partials.errors')


    @if ($serviceEvents->count())
        <div class="row m-t-md">
            <label for="service_event_id">Existing Events</label>
            <div class="col-md-4">
                <select class="form-control m-bot15" name="service_event_id" id="service_event_id">
                    <option value="-1" >Choose Existing Event</option>
                    @foreach ($serviceEvents as $serviceEvent)
                        <option value="{{ $serviceEvent->id }}">{{ $serviceEvent->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif
    <div class="row m-t-md">
        <label>New Event Name</label>
        <div class="col-md-4">
            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}"  autofocus>
        </div>
    </div>

    <div class="row m-t-md">
        <label for='date_of_event'>Date of Event</label>
        <div class="col-md-4">
                <input class="offset-1 form-control" type="date" name="date_of_event" id="date_of_event">
        </div>
    </div>

    <div class="row m-t-md">
        <label for="money_donated">Money Donated</label>
        <div class="col-md-4">
            <input id="money_donated" type="number" class="offset-1 form-control"  name="money_donated" value="{{ old('money_donated') }}"  autofocus>
        </div>
    </div>

    <div class="row m-t-md">
            <label for="hours_served">Hours Served</label>
            <div class="col-md-4">
                    <input id="hours_served" type="number" class="offset-1 form-control" name="hours_served" value="{{ old('hours_served') }}"  autofocus>
                </div>
    </div>


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

