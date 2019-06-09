(function() {
    let counter = 0;
    let btn = document.getElementById('btn');
    let form = document.getElementById('frmAccess');
    let form2 = document.getElementById('frmAccess2');
    let addInput = function() {
        counter++;
        let input = document.createElement('input');
        input.id = 'input-' + counter;
        input.className = 'form-control m-t-md offset-1';
        input.type = 'text';
        input.name = 'field_name[]';
        input.placeholder = 'Survey Field Name';
        form.appendChild(input);

        let select = document.createElement('select');
        select.id = 'select-' + counter;
        select.name = 'field_type[]';
        select.className = 'form-control m-t-md offset-1';
        select.options[select.options.length] = new Option('Text', 'text');
        select.options[select.options.length] = new Option('Date', 'date');
        select.options[select.options.length] = new Option(
            'TextArea',
            'textarea'
        );
        //select.options[select.options.length] = new Option('CheckBox', 'checkbox');
        //select.options[select.options.length] = new Option('Dropdown', 'select');
        form2.appendChild(select);
    };
    btn.addEventListener(
        'click',
        function() {
            addInput();
        }.bind(this)
    );
})();

(function() {
    let elements = document.querySelectorAll('select[id^="select-"]');
    let form = document.getElementById('frmAccess');
    for (let i = 0; i < elements.length; i++) {
        elements[i].addEventListener('change', checkValue(i));
        console.log(i);
    }

    let createOptions = function() {
        console.log('Tried');
        let input = document.createElement('input');
        input.id = 'input-';
        input.className = 'form-control';
        input.type = 'text';
        input.name = 'field_name[]';
        input.placeholder = 'Survey Field Name';
        form.appendChild(input);
    };
    let checkValue = function(i) {
        console.log(i);
        let indexChoice = element[i].selectedIndex;
        if (indexChoice == 3 || indexChoice == 4) {
            createOptions();
        }
    };
})();
