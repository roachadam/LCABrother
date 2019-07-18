@extends('layouts.main');
@section('title', 'Academic Standing Rules')
@section('content')
<div class="container">
    @include('partials.errors')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Override Academic Standing Rules') }}</div>
                <div class="card-body">
                    <form method="post" action="/academicStandings/{{$academicStanding->id}}">
                        @method('PATCH')
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Standing') }}</label>

                            <div class="col-md-4">
                            <input id="name" type="text" class="form-control" name="name" value="{{$academicStanding->name}}" readonly="readonly" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="Term_GPA_Min" class="col-md-4 col-form-label text-md-right">{{ __('Term GPA Minimum') }}</label>

                            <div class="col-md-4">
                                <input id="Term_GPA_Min" type="text" class="form-control " name="Term_GPA_Min" value="{{$academicStanding->Term_GPA_Min}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="Cumulative_GPA_Min" class="col-md-4 col-form-label text-md-right">{{ __('Cumulative GPA Minimum') }}</label>

                            <div class="col-md-4">
                                <input id="Cumulative_GPA_Min" type="text" class="form-control " name="Cumulative_GPA_Min" value="{{$academicStanding->Cumulative_GPA_Min}}">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <a href="/academicStandings" class="btn btn-primary">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Override') }}
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

