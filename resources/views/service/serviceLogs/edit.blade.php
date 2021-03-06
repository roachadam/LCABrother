@extends('layouts.main')
@section('title', 'Edit Service Log')

@section('content')
    <div class="container">
        @include('partials.errors')
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{$serviceLog->serviceEvent->name}} Log Edit</div>
                        <div class="card-body">
                            <form action={{route('serviceLogs.update', $serviceLog)}}  method="POST">
                                @method('PATCH')
                                @csrf

                                <div class="form-group row">
                                    <label for="hours_served" class="col-md-4 col-form-label text-md-right">Hours Served</label>

                                    <div class="form-control-wrapper form-control-icon-left">
                                        <input id="hours_served" type="text" class="form-control" name="hours_served" value="{{ $serviceLog->hours_served }}"  autofocus>
                                        <i class="fa fa-hourglass-start"></i>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="money_donated" class="col-md-4 col-form-label text-md-right">Money Donated </label>

                                    <div class="form-control-wrapper form-control-icon-left">
                                        <input id="money_donated" type="text" class="form-control"  name="money_donated" value="{{ $serviceLog->money_donated }}"  autofocus>
                                        <i class="fa fa-usd"></i>
                                    </div>
                                </div>

                                <div class="card-footer float-right" style="border-top:none">
                                    <a href={{ route('serviceLogs.breakdown', $serviceLog->user)}} class="btn btn-secondary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

