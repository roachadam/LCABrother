@extends('layouts.main')

@section('content')


    <form method='POST' action="/alumni/contact/send" role="presentation" class="form">
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
        </div>

    </form>
@endsection


