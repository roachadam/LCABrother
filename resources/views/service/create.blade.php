@extends('layouts.main')

@section('title', 'Add Service Log')
@section('css')
<link href="{{ asset('css/separate/vendor/bootstrap-daterangepicker.min.css') }}" rel="stylesheet" >
@endsection
@section('content')


<header class="section-header">
    <div class="tbl">
        <h3>Submit Service Hours</h3>
        <ol class="breadcrumb breadcrumb-simple">
            <li><a href="#">StartUI</a></li>
            <li><a href="#">Forms</a></li>
            <li class="active">Buttons</li>
        </ol>
    </div>
</header>

<section class="card">
    <div class="card-block">
        <div class="row">
            <div class="col-lg-12">
                <form method="POST" action="/serviceEvent">
                    @csrf
                    @include('partials.errors')

                    <div class="row ">
                        <div class="col-md-6">
                            <label for="name">Event Name</label>
                            <div class='input-group'>
                                <select class="combobox form-control" name="name" id="eventName">
                                    <option value="0">Choose Existing Event</option>
                                    @if ($serviceEvents->count())
                                        @foreach ($serviceEvents as $serviceEvent)
                                            <option value="{{ $serviceEvent->id }}">{{ $serviceEvent->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row m-t-md">
                        <div class="col-md-6">
                            <label for='date_of_event'>Date of Event</label>
                            <div class='input-group date'>
                                <input id="date_of_event" type="text" value="10/24/2019" class="form-control" name="date_of_event">
                                <span class="input-group-append">
                                    <span class="input-group-text"><i class="font-icon font-icon-calend"></i></span>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="row m-t-md">
                        <div class="col-md-6">
                            <label for="hours_served">Hours Served</label>
                            <div class='input-group'>
                                <input id="hours_served" type="text" class="form-control" name="hours_served" value="{{ old('hours_served') }}"  autofocus>
                            </div>
                        </div>
                    </div>

                    <div class="row m-t-md">
                        <div class="col-md-6">
                            <label for="money_donated">Money Donated (Optional)</label>
                            <div class='input-group'>
                                <input id="money_donated" type="text" class="form-control"  name="money_donated" value="{{ old('money_donated') }}"  autofocus>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary m-t-md">Submit</button>
                </form>
            </div>
        </div>
    </div>
</section>

@section('js')
<script type="text/javascript" src="{{ asset('js/lib/moment/moment-with-locales.min.js') }}"></script>
<script src="{{ asset('js/lib/daterangepicker/daterangepicker.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#eventName').combobox({
            freeInput:{
                name:'name',
                value:''
            }
        });
        $('#date_of_event').daterangepicker({
				singleDatePicker: true,
				showDropdowns: true
		});
    });
</script>
@endsection
@endsection

