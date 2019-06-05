@extends('layouts.main')

@section('content')

<h2 >Mass Invite Membership</h2>
    <ul class="offset-1">
        <li>Enter your email list to automatically invite your members!</li>
        <li>Please only use commas/spaces/newlines to seperate addresses.</li>
    </ul>


<div class="container">
    @include('partials.errors')
    <form method="POST" action="/massInvite/send">
        @csrf

        <div class="form-group row">
            <label for="emailList" class="col-sm-2 form-control-label">Email List</label>
            <div class="col-sm-10">
                <textarea name='emailList' id="emailList" rows="12" class="form-control" placeholder="dawson@louisiana.edu, adam@gmail.com"></textarea>
            </div>
        </div>

        <button type="submit" class="btn btn-inline btn-primary">Submit</button>
    </form>

    <form action="/dash">
        <button type="submit" class="btn btn-inline btn-primary">Skip</button>
    </form>
</div>

@endsection
