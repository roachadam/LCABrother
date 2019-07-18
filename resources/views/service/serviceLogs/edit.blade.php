@extends('layouts.main')
@section('title', 'Edit Service Log')

@section('content')
<section class="card">
    <div class="card-block">
        <form action="/serviceLog/{{$serviceLog->id}}"  method="POST">
            @csrf
            @method('PATCH')
            <h3>{{$serviceLog->serviceEvent->name}} Log Edit</h3>
            <div class="row m-t-md">
                    <div class="col-md-6">
                        <label for="hours_served">Hours Served </label>
                        {{-- <div class='input-group'> --}}
                        <div class="form-control-wrapper form-control-icon-left">
                            <input id="hours_served" type="text" class="form-control" name="hours_served" value="{{ $serviceLog->hours_served }}"  autofocus>
                            <i class="fa fa-hourglass-start"></i>
                        </div>
                    </div>
                </div>

                <div class="row m-t-md">
                    <div class="col-md-6">
                        <label for="money_donated">Money Donated </label>
                        <div class="form-control-wrapper form-control-icon-left">
                            <input id="money_donated" type="text" class="form-control"  name="money_donated" value="{{ $serviceLog->money_donated }}"  autofocus>
                            <i class="fa fa-usd"></i>
                        </div>
                    </div>
                </div>
                <a href={{ route('serviceLogs.breakdown', $serviceLog->user)}} class="btn btn-secondary mr-2">Cancel</a>
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
            </form>
            <div class="row m-t-md offset-1">
            </div>
        </div>
</section>
@endsection
