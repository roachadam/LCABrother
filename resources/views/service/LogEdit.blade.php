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
                <a href="{{ action('UserController@serviceBreakdown', ['user'=> $serviceLog->user]) }}" class="btn btn-secondary mr-2">Cancel</a>
                <button type="submit" class="btn btn-primary mr-2">Submit</button>
            </form>
            <div class="row m-t-md offset-1">

                <button type="button" class="btn btn-danger-outline" data-toggle="modal" data-target="#deleteModal">Delete Event</button>
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                    <i class="font-icon-close-2"></i>
                                </button>
                                <h4 class="modal-title" id="myModalLabel">Delete</h4>
                            </div>
                            <form action="/serviceLog/{{$serviceLog->id}}"  method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-body">
                                    <div class="col-md-12">
                                        <p>Are you sure you want to delete this Log?</p>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-inline btn-danger">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection
