@extends('layouts.main')
<link rel="stylesheet" href="/vendor/trumbowyg/ui/trumbowyg.css">
@section('content')



    <div class="row">
            <label for="editor">Email Body</label>
        <textarea name="body" id="editor" cols="30" rows="10"></textarea>
    </div>

    <form action="/" method="post"></form>



    @section('js')
        <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
        <script src="/vendor/trumbowyg/trumbowyg.js"></script>

        <script>
            $('#editor').trumbowyg();
        </script>
    @endsection

@endsection
