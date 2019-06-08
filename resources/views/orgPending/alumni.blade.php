@extends('layouts.dashtheme')
@section('title', 'Alumni')
@section('content')


    <div class="text-container">
        <h3 class="app__main__title">Hello Alumni!!!</h3>
        <p>Your organization has marked you as moving into alumni ship! Congrats!</p>
        <br>
        <p>To request that {{auth()->user()->organization->name}} remove your info, please <a href=""><strong>Click here.</strong></a></p>
    </div>



@endsection
