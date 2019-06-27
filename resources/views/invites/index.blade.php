@extends('layouts.main')

@section('content')
<div class="card">
<div class="card-header">{{$event->name}}: Your invites</div>
    <div class="card-body">
        <h4>Your guestlist:</h4>

        <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
            <thead>
                    <tr>
                        <th>Name</th>
                        <th>Delete</th>
                    </tr>
            </thead>
            <tbody>
                @foreach ($invites as $invite)
                    <tr>
                        <td>{{ $invite->guest_name }}</td>
                        <td><button type="button" class="btn btn-inline btn-danger"  data-toggle="modal" data-target="#{{$invite->id}}">Delete</button></td>
                    </tr>

                    <!--.modal for confirming deletion-->
                    <div class="modal fade" id="{{$invite->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                        <i class="font-icon-close-2"></i>
                                    </button>
                                    <h4 class="modal-title" id="myModalLabel">Delete Invite</h4>
                                </div>
                                <form action="/invite/{{ $invite->id }}" method="POST" class="box" >
                                    <div class="modal-body">
                                        @csrf
                                        @method('DELETE')
                                        <div class="col-md-12">
                                            <p>Are you sure you want to delete this invite?</p>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-inline btn-primary">Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div><!--.modal-->
                @endforeach

            </tbody>
        </table>
    </div>
</div>

@endsection
