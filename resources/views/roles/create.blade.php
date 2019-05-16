@extends('layouts.app')

@section('content')

<h1>Add Roles to {{ $org->name }}</h1>
<p> {{ $org->roles() }}</p>
@endsection
