@extends('layouts.main')

@section('css')
<link href="{{ asset('css/bootstrap-combobox.css') }}" rel="stylesheet">
<link href="{{ asset('css/separate/vendor/bootstrap-daterangepicker.min.css') }}" rel="stylesheet" >
@endsection

@section('content')


<header class="section-header">
    <div class="tbl">
        <h3>Submit Service Hours</h3>
        {{-- <ol class="breadcrumb breadcrumb-simple">
            <li><a href="#">StartUI</a></li>
            <li><a href="#">Forms</a></li>
            <li class="active">Buttons</li>
        </ol> --}}
    </div>
</header>

<section class="card">
        <div class="card-block">
            <div class="col-lg-12">
                <form method="POST" action="/serviceEvent">
                    @csrf
                    @include('partials.errors')

                    <div class="row ">
                        <div class="col-md-12">
                                <label for="eventName">Event Name</label>

                            <div class='input-group'>
                                <select class="combobox form-control" name="name" id="EventName" >
                                    @foreach ($serviceEvents as $serviceEvent)
                                        <option value="{{ $serviceEvent->id }}">{{ $serviceEvent->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="row m-t-md">
                        <div class="col-md-6">
                            <label for='date_of_event'>Date of Event</label>

                            <div class='input-group date'>
                                <div class="form-control-wrapper form-control-icon-left">
                                    <input id="date_of_event" type="text" class="form-control" name="date_of_event">
                                    <i class="fa fa-calendar "></i>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row m-t-md">
                        <div class="col-md-6">
                            <label for="hours_served">Hours Served (Optional)</label>
                            {{-- <div class='input-group'> --}}
                            <div class="form-control-wrapper form-control-icon-left">
                                <input id="hours_served" type="text" class="form-control" name="hours_served" value="{{ old('hours_served') }}"  autofocus>
                                <i class="fa fa-hourglass-start"></i>
                            </div>
                        </div>
                    </div>

                    <div class="row m-t-md">
                        <div class="col-md-6">
                            <label for="money_donated">Money Donated (Optional)</label>
                            <div class="form-control-wrapper form-control-icon-left">
                                <input id="money_donated" type="text" class="form-control"  name="money_donated" value="{{ old('money_donated') }}"  autofocus>
                                <i class="fa fa-usd"></i>
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
        $('#EventName').combobox({
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

