@extends('layouts.main')

@section('content')
    <div class="card">
        <div class="card-header">{{$calendarItem->name}}</div>
        <div class="card-body">
            {{$calendarItem->description}}
        </div>
    </div>


@endsection
