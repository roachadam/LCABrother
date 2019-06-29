@extends('layouts.main')



@section('content')
<section class="card">
    <div class="card-block">
        <form action="/serviceLog/{{$serviceLog->id}}"  method="POST">
            @csrf
            @method('PATCH')
            <h3>{{$serviceLog->serviceEvent->name}} Log Edit</h3>
            <div class="row m-t-md">
                <div class="col-md-6">
                    <label for="money_donated">Money Donated</label>

                    <div class='input-group'>
                        <input id="money_donated" type="text" class="form-control"  name="money_donated" value="{{ $serviceLog->money_donated }}"  autofocus>
                    </div>
                </div>
            </div>


            <div class="row m-t-md">
                <div class="col-md-6">
                    <label for="hours_served">Hours Served</label>

                    <div class='input-group'>
                        <input id="hours_served" type="text" class="form-control" name="hours_served" value="{{ $serviceLog->hours_served !== null ? $serviceLog->hours_served : 0 }}"  autofocus>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>


        <form action="/serviceLog/{{$serviceLog->id}}"  method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure?')">Delete</button>
        </form>
        <a href="{{ action('UserController@serviceBreakdown', ['user'=> $serviceLog->user]) }}" class="btn btn-primary">Cancel</a>
    </div>
</section>
@endsection
