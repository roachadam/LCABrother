@extends('layouts.main')

@section('title', 'Service Events')

@section('css')
    <link href="{{ asset('css/bootstrap-combobox.css') }}" rel="stylesheet">
    <link href="{{ asset('css/separate/vendor/bootstrap-daterangepicker.min.css') }}" rel="stylesheet">
@endsection

@section('content')

    <section class="card">
        <div class="card-block">
            <header class="card-header" style="border-bottom: 0">
                <div class="row">
                    <h2 class="card-title">{{ auth()->user()->organization->getActiveSemester()->semester_name }}: Service Events</h2>
                    <div class="ml-auto" id="headerButtons">
                        <button type="button" class="btn btn-inline btn-secondary-outline" data-toggle="modal" data-target="#submitServiceHours">Submit Service Hours</button>
                        <a href={{route('serviceLogs.breakdown', auth()->user())}} class="btn btn-inline btn-primary">My Service Breakdown</a>
                    </div>
                </div>
            </header>

            @include('partials.errors')
            <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Date</th>
                        <th>Attendance</th>
                        @if (auth()->user()->canManageService())
                            <th>Manage</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if ($serviceEvents->count())
                        @foreach ($serviceEvents as $serviceEvent)
                        <tr>
                            <td>{{$serviceEvent->name}}</td>
                            <td> {{$serviceEvent->date_of_event}} </td>
                            <td> {{ $serviceEvent->getAttendance()}} </td>
                            @if (auth()->user()->canManageService())
                                <td><a href={{route('serviceEvent.show', $serviceEvent)}} class="btn btn-primary">Manage</a></td>
                            @endif

                        </tr>
                        @endforeach
                    @endif

                </tbody>
            </table>
        </div>
    </section>


    <!--.modal for submitting service hours-->
    <div class="modal fade" id="submitServiceHours" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                            <i class="font-icon-close-2"></i>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Submit Service Hours</h4>
                    </div>
                    <form method="POST" action="/serviceEvent" class="box" >
                        <div class="modal-body">
                            @csrf
                            <div class="col-md-12">
                                <div class="row col-md-6">
                                    <label for="eventName">Event Name</label>

                                    <div class='input-group'>
                                        <select class="combobox form-control" name="name" id="EventName" >
                                            @foreach ($serviceEvents as $serviceEvent)
                                                <option value="{{ $serviceEvent->id }}">{{ $serviceEvent->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row m-t-md col-md-6">
                                    <label for='date_of_event'>Date of Event</label>

                                    <div class='input-group date'>
                                        <div class="form-control-wrapper form-control-icon-left">
                                            <input id="date_of_event" type="text" class="form-control" name="date_of_event">
                                            <i class="fa fa-calendar "></i>
                                        </div>
                                    </div>
                                </div>


                                <div class="row m-t-md col-md-6">
                                    <label for="hours_served">Hours Served (Optional)</label>
                                    <div class="form-control-wrapper form-control-icon-left">
                                        <input id="hours_served" type="text" class="form-control" name="hours_served" value="{{ old('hours_served') }}"  autofocus>
                                        <i class="fa fa-hourglass-start"></i>
                                    </div>
                                </div>

                                <div class="row m-t-md col-md-6">
                                    <label for="money_donated">Money Donated (Optional)</label>
                                    <div class="form-control-wrapper form-control-icon-left">
                                        <input id="money_donated" type="text" class="form-control"  name="money_donated" value="{{ old('money_donated') }}"  autofocus>
                                        <i class="fa fa-usd"></i>
                                    </div>
                                </div>
                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-inline btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div><!--.modal-->
    @section('js')
        <script type="text/javascript" src="{{ asset('js/lib/datatables-net/datatables.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/lib/moment/moment-with-locales.min.js') }}"></script>
        <script src="{{ asset('js/lib/daterangepicker/daterangepicker.js') }}"></script>
        <script>
            $(document).ready(function () {
                $('#table').DataTable({
                    responsive: true
                });

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
