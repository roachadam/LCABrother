@extends('layouts.main')

@section('content')
<div class="card">
<div class="card-header">{{$event->name}}: Your invites</div>
        <div class="card-body">
            <h4> Your guestlist:</h4>
            <ul class="offset-1">
            @foreach ($invites as $invite)

                <li> {{ $invite->guest_name }}</li>

            @endforeach
            </ul>
        </div>
    </div>

@endsection
