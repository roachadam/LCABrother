@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>


                {{-- todo: middleware for organization being set --}}
                <div class="card-body">
                    <form method="POST" action="/user/{{ Auth::user()->id}}">
                        @csrf
                        @method('patch')


                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name of Organization') }}</label>

                            <div class="col-md-6">
                                <select class="form-control m-bot15" name="organization">
                                @foreach ($orgs as $org)
                                    <option value="{{ $org->id }}">{{ $org->name }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Join Organization') }}
                                </button>
                            </div>
                        </div>
                    </form>


                    <form method="GET" action="/organization/create">
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary" name="RegisterNewOrg">
                                        {{ __('Register New Organization') }}
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
