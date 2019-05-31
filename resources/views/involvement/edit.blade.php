@extends('layouts.main')

@section('content')
<h2>Edit Invovlvement</h2>
<p>Event Name : {{ $involvement->name }}</p>
<p>Event's Points value : {{ $involvement->points }}</p>

@endsection
