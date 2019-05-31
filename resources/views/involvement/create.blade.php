@extends('layouts.main')

@section('content')

<h2 >Involvement</h2>

<div class="container">



    <div class="col-md-10">
        <div class="card">
            @include('partials.errors')
            <div class="card-header">{{ __('Create New Involvement') }}</div>
            <div class="card-body">
                <form method="POST" action="/involvement">
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        </div>
                        </div>

                    <div class="form-group row">
                        <label for="points" class="col-md-4 col-form-label text-md-right">{{ __('Point Value') }}</label>

                        <div class="col-md-6">
                            <input id="points" type="text" class="form-control" name="points" value="{{ old('points') }}" required autocomplete="points" autofocus>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-inline btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
