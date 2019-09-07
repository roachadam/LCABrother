@extends('layouts.main')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/user">Members</a></li>
        <li class="breadcrumb-item"><a href="/alumni">Alumni</a></li>
        <li class="breadcrumb-item active" aria-current="page">Alumni Contact</li>
    </ol>
</nav>

<section class="card col-md-10">
    <header class="card-header">
        <div class="row">
            <h3 class="card-title">Contact ALumni</h3>
            <div class="ml-auto" id="headerButtons">
                {{-- <a href="/alumni/contact" class="btn btn-inline btn-primary">Contact Alumni</a> --}}
            </div>
        </div>
    </header>
    <form method='POST' action="/alumni/contact/send" role="presentation" class="form">
        @csrf
        <div class="card-body">
            <div class="col-md-10">

                <label for="alum0">Alumni To Contact</label>
                <div class="checkbox-toggle form-group offset-1">
                    <input type="checkbox" value="0" id="alum0" name="alum[]">
                    <label for="alum0">
                        All Alumni
                    </label>
                </div>



                @foreach ($alumni as $alum)
                    <div class="checkbox-toggle form-group offset-1 row m-t-sm">
                        <input type="checkbox" value="{{$alum->id}}" id="alum{{$alum->id}}" name="alum[]">
                        <label for="alum{{$alum->id}}">
                            {{$alum->name}}
                        </label>
                    </div>
                @endforeach

                <div class="row m-t-md">
                    <label for="subject">Subject</label>
                    <input class="offset-1 form-control" type="text" name="subject" id='subject' placeholder="Alumni Event Upcoming">
                </div>

                <div class="row m-t-md">
                    <label for='body'>Body</label>
                    <textarea class="offset-1 form-control" name="body" id="body" cols="30" rows="10" placeholder="We would love to see you at the event!"></textarea>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <button type='submit' class="btn btn-primary-outline">Send</button>
            </div>
        </div>
    </form>

</section>
    {{-- <form method='POST' action="/alumni/contact/send" role="presentation" class="form">
        @csrf

            <label>Alumni To Contact</label>
            <div class="checkbox-toggle form-group offset-1">
                    <input type="checkbox" value="0" id="alum0" name="alum[]">
                    <label for="alum0">
                        All Alumni
                    </label>
                </div>


            @foreach ($alumni as $alum)
                <div class="checkbox-toggle form-group offset-1">
                    <input type="checkbox" value="{{$alum->id}}" id="alum{{$alum->id}}" name="alum[]">
                    <label for="alum{{$alum->id}}">
                        {{$alum->name}}
                    </label>
                </div>
            @endforeach

        <div class="row m-t-md">
            <label>Subject</label>
            <input class="offset-1 form-control" type="text" name="subject" id='subject' placeholder="Alumni Event Upcoming">
        </div>

        <div class="row m-t-md">
            <label for='body'>Body</label>
            <textarea class="offset-1 form-control" name="body" id="body" cols="30" rows="10" placeholder="We would love to see you at the event!"></textarea>
        </div>

        <div class="row m-t-md">
            <button type='submit' class="btn btn-primary">Send</button>
        </div> --}}
@endsection


