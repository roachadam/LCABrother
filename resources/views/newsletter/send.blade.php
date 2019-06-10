@extends('layouts.main')
<link rel="stylesheet" href="/vendor/trumbowyg/ui/trumbowyg.css">
@section('content')


    <form action="/newsletter/send" method="POST">
        @csrf
        <div class="form-row">
            <label for="newsletterId">Choose Newsletter to contact</label>
            <select name="newsletterId" id="newsletterId" class="form-control">
                @foreach ($newsletters as $newsletter)
                    <option value="{{$newsletter->id}}">{{$newsletter->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-row m-t-md">
            <label for="editor">Email Body</label>
            <textarea name="body" id="editor" cols="30" rows="10"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Send</button>
    </form>

    {{-- <form action="/newsletter/send/preview" method="post">
        @csrf
        <textarea name="body" id="editor2" cols="30" rows="10" style="display:none;"></textarea> --}}
        <button id="previewButton" type="submit" class="btn btn-primary-outline" data-toggle="modal" data-target="#showPreview">Preview</button>

    {{-- </form> --}}

<div class="modal fade" id="showPreview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                <i class="font-icon-close-2"></i>
            </button>
            <h4 class="modal-title" id="myModalLabel">Preview</h4>
        </div>
        {{-- Body of modal --}}
        <div class="modal-body">
            <div id="htmlInsert"></div>
        </div>
    </div>
</div>
</div>

    @section('js')
        <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')</script>
        <script src="/vendor/trumbowyg/trumbowyg.js"></script>
        <script src="/vendor/trumbowyg/plugins/upload/trumbowyg.upload.js"></script>
        <script src="vendor/trumbowyg/plugins/pasteimage/trumbowyg.pasteimage.min.js"></script>
        <script>
            $('#editor').trumbowyg({
                btnsDef: {
                    // Create a new dropdown
                    image: {
                        dropdown: ['insertImage', 'upload'],
                        ico: 'insertImage'
                    }
                },
                // Redefine the button pane
                btns: [
                    ['viewHTML'],
                    ['formatting'],
                    ['strong', 'em', 'del'],
                    ['superscript', 'subscript'],
                    ['link'],
                    ['image'], // Our fresh created dropdown
                    ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                    ['unorderedList', 'orderedList'],
                    ['horizontalRule'],
                    ['removeformat'],
                    ['fullscreen']
                ],
                plugins: {
                    // Add imagur parameters to upload plugin for demo purposes
                    upload: {
                        serverPath: 'https://api.imgur.com/3/image',
                        fileFieldName: 'image',
                        headers: {
                            'Authorization': 'Client-ID xxxxxxxxxxxx'
                        },
                        urlPropertyName: 'data.link'
                    }
                }
            });
        </script>
        <script>
            $('#previewButton').click(function(){
                var input = document.getElementById("editor").value;
                var elementExists = document.getElementById("previewData");
                if(elementExists){
                    document.getElementById('htmlInsert').removeChild(elementExists);
                }
                var div = document.createElement('div');
                div.id = 'previewData'
                div.innerHTML = input;
                document.getElementById('htmlInsert').appendChild(div);
                });
        </script>
    @endsection

@endsection
