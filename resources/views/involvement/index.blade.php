@extends('layouts.main')

@section('content')

<h2 >Involvement</h2>

<div class="container">
    <div class="container">
        @include('partials.errors')
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Add New Involvement Scores') }}</div>
                <div class="card-body">
                    @if($involvements->count())
                    <form method="POST" action="/involvementLog">
                        @csrf

                        {{-- @if($involvements->count()) --}}
                        <div class="form-group row">
                            <label for="involvement_id" class="col-form-label text-md-right">{{ __('Involvement Items') }}</label>

                            <div class="col-md-4">
                                <select class="form-control m-bot15" name="involvement_id">
                                    <option value="" selected="selected" disabled >Choose One</option>
                                    @foreach ($involvements as $invovlement)
                                        <option value="{{ $invovlement->id }}">{{ $invovlement->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                                <label for="date_of_event" class="col-form-label text-md-right">Date of Event</label>
                                <div class="col-md-4">
                                        <input id="date_of_event" type="text" class="form-control" name="date_of_event" placeholder="2019-05-20 03:50:15" value="2001-10-26 21:32:52" autofocus="">
                                </div>
                        </div>
                        <div class="form-group row">
                            <label for="usersInvolved[]" class="col-form-label text-md-right">{{ __('Members Involved') }}</label>
                        </div>
                        @foreach (auth()->user()->organization->getVerifiedMembers() as $user)
                            <div class="row offset-1">
                                <div class="checkbox-toggle form-group">
                                        <input type="checkbox" id="usersInvolved{{$user->id}}" name="usersInvolved[]" value="{{$user->id}}">
                                        <label for="attendance">{{ $user->name }}
                                </div>
                            </div>
                        @endforeach


                        <button type="submit" class="btn btn-inline btn-primary">Submit</button>
                    </form>
                    @else
                    <p>Please create  at least one involvement event to submit scores</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card">
            <div class="card-header">{{ __('Create New Involvement Item') }}</div>
            <form action="/involvement/create">
                <button type="submit" class="btn btn-inline btn-primary offset-1">Create New</button>
            </form>
        </div>
    </div>
</div>

@endsection
