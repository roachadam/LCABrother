@extends('layouts.main')

@section('content')


    <form method='POST' action="/alumni/contact/send" role="presentation" class="form">
        @csrf

            <label>Alumni To Contact</label>
            <div class="form-check offset-1">
                    <input class="form-check-input" type="checkbox" value="0" id="alum[]" name="alum[]">
                    <label class="form-check-label" for="alum[]">
                        All Alumni
                    </label>
                </div>
            @foreach ($alumni as $alum)
                <div class="form-check offset-1">
                    <input class="form-check-input" type="checkbox" value="{{$alum->id}}" id="alum[]" name="alum[]">
                    <label class="form-check-label" for="alum[]">
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


