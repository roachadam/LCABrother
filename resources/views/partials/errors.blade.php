@if ($errors->{ $bag ?? 'default' }->any())
    <ul class="form-error-text-block">
        @foreach ($errors->{ $bag ?? 'default' }->all() as $error)
            <li class="text-sm text-red">{{ $error }}</li>
        @endforeach
    </ul>
@endif

