@extends('layouts.app')

@section('content')

<div class="container">
    @include('partials.errors')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $event->name }}</div>
                <div class="card-body">
                    <p>Date of Event: {{ $event->date_of_event }}</p>
                    <p>Invites per member: {{ $event->num_invites }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
