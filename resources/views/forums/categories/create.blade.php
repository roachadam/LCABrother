@extends('layouts.main')

@section('content')

<div class="container">
    @include('partials.errors')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Set Forum Categories') }}</div>

                <div class="card-body">
                    <div class="flex-b"></div>
                        @if ($category->count())
                            <h5>Current Categories:</h5>
                            <ul>
                                @foreach ($category as $cat)
                                <div class="row offset-1">
                                    <ol>
                                    {{ $cat->name}}
                                    </ol>
                                </div>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <p class="offset-1">Enter the names of the topics your members can post on the forum under.</p>
                    <form method="POST" action="/forum/create/categories">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name of Category') }}</label>
                            <div class="col-md-4">
                                <input id="name" type="text" class="form-control " name="name" value="{{ old('name') }}" required autocomplete="service_hours_goal" autofocus>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-2 offset-2">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit Categories') }}
                                </button>
                            </div>
                            <a href="/massInvite" class="btn btn-default offset-2">Next</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

