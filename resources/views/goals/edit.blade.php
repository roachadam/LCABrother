@extends('layouts.main')

@section('content')
<div class="container">
    @include('partials.errors')

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Edit Organization Goals') }}</div>
                <div class="card-body">
                    <form method="POST" action="/goals/{{ $goals->id }}/update">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Service Hours Goal') }}</label>

                            <div class="col-md-4">
                                <input id="service_hours_goal" type="text" class="form-control" name="service_hours_goal" value="{{ $goals->service_hours_goal }}" required autocomplete="service_hours_goal" autofocus>
                            </div>

                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Money Donated Goal') }}</label>

                            <div class="col-md-4">
                                <input id="service_money_goal" type="text" class="form-control" name="service_money_goal" value="{{ $goals->service_money_goal }}" required autocomplete="service_money_goal" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="study_goal" class="col-md-4 col-form-label text-md-right">{{ __('Study Hours Goal') }}</label>

                            <div class="col-md-4">
                                <input id="study_goal" type="text" class="form-control " name="study_goal" value="{{ $goals->study_goal }}" required autocomplete="study_goal" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="points_goal" class="col-md-4 col-form-label text-md-right">{{ __('Involvement Points Goal') }}</label>

                            <div class="col-md-4">
                                <input id="points_goal" type="text" class="form-control" name="points_goal" value="{{ $goals->points_goal }}" required autocomplete="points_goal" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-3 offset-2">
                                <a href="/goals/" id="cancel" name="cancel" class="btn btn-default">
                                    Cancel
                                </a>
                            </div>

                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Set Goals') }}
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
