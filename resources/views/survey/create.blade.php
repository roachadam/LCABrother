@extends('layouts.main')
<style>
    input{
    display: block;
    }
    select{
    display: block;
    }
</style>
@section('content')

<div class="card">
    <div class="card-header">Create Survey</div>
    <div class="card-body">
        <div class="col-md-12">
            <form id="frm" action="/survey" method="POST">
                @csrf
                <label>Survey Name</label>
                <input type="text" name="name" id="name" class="form-control">

                <div class="form-row col-md-4 offset-1">
                    <div id="frmAccess""></div>
                </div>

                <button type="submit" class="btn btn-primary-outline">Submit</button>
            </form>
        </div>
        <button id="btn" type="button" class="btn">Add Field</button>
    </div>
</div>

<script>
    (function() {
    var counter = 0;
    var btn = document.getElementById('btn');
    var form = document.getElementById('frmAccess');
    var addInput = function() {
        counter++;
        var input = document.createElement("input");
        input.id = 'input-' + counter;
        input.className="form-control";
        input.type = 'text';
        input.name = 'field_name[]';
        input.placeholder = 'Survey Field Name';
        form.appendChild(input);

        var select = document.createElement("select");
        select.id = 'select-' + counter;
        select.name = 'field_type[]';
        select.className="form-control";
        select.options[select.options.length] = new Option('Text', 'text');
        select.options[select.options.length] = new Option('Date', 'date');
        select.options[select.options.length] = new Option('TextArea', 'textarea');
        select.options[select.options.length] = new Option('CheckBox', 'checkbox');
        select.options[select.options.length] = new Option('Dropdown', 'select');
        form.appendChild(select);
    };
    btn.addEventListener('click', function() {
        addInput();
    }.bind(this));
    })();
</script>
{{-- <script>
    (function() {
    var elements = document.querySelectorAll('select[id^="select-"]');
    var form = document.getElementById('frmAccess');
    for(var i = 0; i < elements.length; i++) {
        elements[i].addEventListener("change", checkValue(i));
        console.log(i);
    }

    var createOptions = function() {
        console.log("Tried");
        var input = document.createElement("input");
        input.id = 'input-';
        input.className="form-control";
        input.type = 'text';
        input.name = 'field_name[]';
        input.placeholder = 'Survey Field Name';
        form.appendChild(input);
    };
    var checkValue = function(i) {
        console.log(i);
        var indexChoice = element[i].selectedIndex;
        if(indexChoice == 3 || indexChoice == 4){
            createOptions();
        }
    };
        })();

</script> --}}
@endsection

