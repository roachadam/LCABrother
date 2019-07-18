@extends('layouts.main')
@section('title', 'Create Survey')
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
                <input type="text" name="name" id="name" class="form-control" required>

                <label>Survey Description</label>
                <textarea type="text" name="desc" id="desc" class="form-control" required></textarea>




                <div class="form-row m-t-md">
                    <input type="text" name="field_name[]" id="field_name[]" placeholder="Survey Field Name" class="form-control m-t-md" required>
                    <select name="field_type[]" id="select-0" class="form-control m-t-md" required>
                        <option value="text">Text</option>
                        <option value="date">Date</option>
                        <option value="textarea">TextArea</option>
                    </select>

                    <div id="frmAccess" ></div>
                    <div id="frmAccess2" class="offset-1" ></div>
                </div>

                <div class="row m-t-md">
                    <button id="btn" type="button" class="btn">Add Field</button>
                    <button type="submit" class="btn btn-primary-outline offset-1">Submit</button>
                </div>

            </form>
        </div>
    </div>
</div>

{{-- <script src="resources\js\survey.js"></script> --}}
<script>
    (function() {
    let counter = 0;
    let btn = document.getElementById('btn');
    let form = document.getElementById('frmAccess');
    let form2 = document.getElementById('frmAccess2');
    let addInput = function() {
        counter++;
        let input = document.createElement("input");
        input.id = 'input-' + counter;
        input.className="form-control m-t-md offset-1";
        input.type = 'text';
        input.name = 'field_name[]';
        input.placeholder = 'Survey Field Name';
        form.appendChild(input);

        let select = document.createElement("select");
        select.id = 'select-' + counter;
        select.name = 'field_type[]';
        select.className="form-control m-t-md offset-1";
        select.options[select.options.length] = new Option('Text', 'text');
        select.options[select.options.length] = new Option('Date', 'date');
        select.options[select.options.length] = new Option('TextArea', 'textarea');
        //select.options[select.options.length] = new Option('CheckBox', 'checkbox');
        //select.options[select.options.length] = new Option('Dropdown', 'select');
        form2.appendChild(select);
    };
    btn.addEventListener('click', function() {
        addInput();
    }.bind(this));
    })();
</script>
{{-- <script>
    (function() {
    let elements = document.querySelectorAll('select[id^="select-"]');
    let form = document.getElementById('frmAccess');
    for(let i = 0; i < elements.length; i++) {
        elements[i].addEventListener("change", checkValue(i));
        console.log(i);
    }

    let createOptions = function() {
        console.log("Tried");
        let input = document.createElement("input");
        input.id = 'input-';
        input.className="form-control";
        input.type = 'text';
        input.name = 'field_name[]';
        input.placeholder = 'Survey Field Name';
        form.appendChild(input);
    };
    let checkValue = function(i) {
        console.log(i);
        let indexChoice = element[i].selectedIndex;
        if(indexChoice == 3 || indexChoice == 4){
            createOptions();
        }
    };
        })();

</script> --}}
@endsection

