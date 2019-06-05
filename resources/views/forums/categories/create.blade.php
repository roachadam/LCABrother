@extends('layouts.main')

@section('content')
@if ($category->count())
    <h3>Current Categories:</h3>
    <ul>
        @foreach ($category as $cat)
        <li>
           {{ $cat->name}}
        </li>
        @endforeach
    </ul>
@endif
<div class="container">
    @include('partials.errors')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Set Forum Categories') }}</div>
                {{-- todo: middleware for organization being set --}}
                <div class="card-body">
                    <form method="POST" action="/forum/create/categories">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name of Category') }}</label>
                            <div class="col-md-4">
                                <input id="name" type="text" class="form-control " name="name" value="{{ old('name') }}" required autocomplete="service_hours_goal" autofocus>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit Categories') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

