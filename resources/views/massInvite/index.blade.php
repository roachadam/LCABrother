@extends('layouts.theme')
@section('title', 'Mass Invite')
@section('content')
    <div class="auth__media">
        <img src="/img/home/ordinary.svg">
    </div>
    <div class="auth__auth">
        <h1 class="auth__title">Mass Invite Membership</h1>
        @include('partials.errors')
        <li>Enter your email list to automatically invite your members!</li>
        <li>Please only use commas/spaces/newlines to seperate addresses.</li>
        <form method="POST" action="/massInvite/send">
            @csrf
                <label>Email List</label>
                <textarea name='emailList' id="emailList" rows="12" class="form-control" placeholder="dawson@louisiana.edu, adam@gmail.com"></textarea>

            <button type="submit" class="button button__primary">Submit</button>
            <a href="/dash" class="button">Skip</a>
        </form>

        <p>
            or share this link with your organization:
            <b>
                {{env('APP_URL')}}/organizations/{{auth()->user()->organization->id}}/join
            </b>
        </p>

    </div>
@endsection

