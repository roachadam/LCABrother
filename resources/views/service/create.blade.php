@extends('layouts.main')

@section('title', 'Add Service Log')
@section('css')
<link href="{{ asset('css/separate/vendor/bootstrap-daterangepicker.min.css') }}" rel="stylesheet" >
@endsection
@section('content')


<header class="section-header">
    <div class="tbl">
        <h3>Log Service Hours</h3>
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
{{--

                            @if ($serviceEvents->count())

                                    <label for="name">Existing Events</label>

                                        <select class="combobox form-control" name="name" id="name" >
                                            <option value="-1" >Choose Existing Event</option>
                                            @foreach ($serviceEvents as $serviceEvent)
                                                <option value="{{ $serviceEvent->id }}">{{ $serviceEvent->name }}</option>
                                            @endforeach
                                        </select>


                            @endif --}}
                            <div class="row">
                                    <div class="col-md-6">
                                            <div class='input-group date'>
                                                    <input id="date_of_event" type="text" value="10/24/2019" class="form-control">
                                                    <span class="input-group-append">
                                                        <span class="input-group-text"><i class="font-icon font-icon-calend"></i></span>
                                                    </span>
                                                </div>
                                            {{-- <input id="date_of_event" type="text" value="10/24/2019" class="form-control"> --}}
                                            <label for='date_of_event'>Date of Event</label>
                                            {{-- <input class="form-control" type="date" name="date_of_event" id="date_of_event"> --}}
                                    </div>
                            </div>

                            {{-- <div class="row m-t-md">
                                <label for='date_of_event'>Date of Event</label>
                                <div class="col-md-4">
                                        <input class="offset-1 form-control" type="date" name="date_of_event" id="date_of_event">
                                </div>
                            </div> --}}

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

                </div>
            </div>
        </div>
</section>

@section('js')
<script type="text/javascript" src="{{ asset('js/lib/moment/moment-with-locales.min.js') }}"></script>
<script src="{{ asset('js/lib/daterangepicker/daterangepicker.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#name').combobox({
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

