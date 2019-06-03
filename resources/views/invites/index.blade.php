@extends('layouts.main')

@section('content')
<div class="card">
<div class="card-header">{{$event->name}}: Your invites</div>
        <div class="card-body">
            <h4> Your guestlist:</h4>

            @foreach ($invites as $invite)

                <div class="row offset-1">
                    {{ $invite->guest_name }}
                    <div class="offset-1">
                        <form action="/invite/{{ $invite->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div>
                                <button class="btn btn-inline" type="submit">Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
