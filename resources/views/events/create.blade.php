@extends('layouts.main')

@section('content')

<header class="section-header">
        <div class="tbl">
            <h3>Add Event</h3>
            {{-- <ol class="breadcrumb breadcrumb-simple">
                <li><a href="#">StartUI</a></li>
                <li><a href="#">Forms</a></li>
                <li class="active">Buttons</li>
            </ol> --}}
        </div>
    </header>


<section class="card">
    <div class="card-block">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-header">Event Details</div>
                @include('partials.errors')
                <div class="card-body">
                    <form method="POST" action="/event">
                        @csrf
                        {{-- Name --}}
                        <label for="name" class="col-form-label">{{ __('Event Name') }}</label>
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <div class="form-control-wrapper form-control-icon-left">
                                    <input id="name" type="text" class="form-control " name="name" value="{{ isset($calendarItem) ? $calendarItem->name : old('name') }}" required autocomplete="name" autofocus>
                                    <i class="fa fa-pencil"></i>
                                </div>
                            </div>
                        </div>

                        {{--date_of_event --}}
                        <label for="date_of_event" class="col-form-label">{{ __('Date of Event') }}</label>
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <div class="form-control-wrapper form-control-icon-left">
                                    <input id="date_of_event" type="date" class="form-control" name="date_of_event" value="{{ isset($calendarItem) ? $calendarItem->start_date : old('name') }}" required autocomplete="date_of_event" autofocus>
                                    <i class="fa fa-calendar"></i>
                                </div>
                            </div>
                        </div>

                        {{-- num_invites --}}
                        <label for="num_invites" class="col-form-label">{{ __('# Of Invites Per Member') }}</label>
                        <div class="form-group row">

                            <div class="col-lg-3">
                                <div class="form-control-wrapper form-control-icon-left">
                                    <input id="num_invites" type="text" class="form-control " name="num_invites" value="{{ old('num_invites') }}" required autocomplete="num_invites" autofocus>
                                    <i class="fa fa-users"></i>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-lg-3">
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
