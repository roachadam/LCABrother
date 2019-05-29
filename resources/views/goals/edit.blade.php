@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Edit Organization Goals') }}</div>


                {{-- todo: middleware for organization being set --}}
                <div class="card-body">
                <form method="POST" action="/goals/{{ $goals->id }}/update">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Service Hours Goal') }}</label>

                            <div class="col-md-4">
                                <input id="service_hours_goal" type="text" class="form-control @error('service_hours_goal') is-invalid @enderror" name="service_hours_goal" value="{{ $goals->service_hours_goal }}" required autocomplete="service_hours_goal" autofocus>

                                @error('service_hours_goal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Money Donated Goal') }}</label>

                            <div class="col-md-4">
                                <input id="service_money_goal" type="text" class="form-control @error('service_money_goal') is-invalid @enderror" name="service_money_goal" value="{{ $goals->service_money_goal }}" required autocomplete="service_money_goal" autofocus>

                                @error('service_money_goal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="study_goal" class="col-md-4 col-form-label text-md-right">{{ __('Study Hours Goal') }}</label>

                            <div class="col-md-4">
                                <input id="study_goal" type="text" class="form-control @error('study_goal') is-invalid @enderror" name="study_goal" value="{{ $goals->study_goal }}" required autocomplete="study_goal" autofocus>

                                @error('study_goal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="points_goal" class="col-md-4 col-form-label text-md-right">{{ __('Involvement Points Goal') }}</label>

                            <div class="col-md-4">
                                <input id="points_goal" type="text" class="form-control @error('points_goal') is-invalid @enderror" name="points_goal" value="{{ $goals->points_goal }}" required autocomplete="points_goal" autofocus>

                                @error('points_goal')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">

                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Set Goals') }}
                                </button>
                            </div>

                            <div class="col-md-6 offset-md-4">
                                <a href="/goals/" id="cancel" name="cancel" class="btn btn-default">
                                    Cancel
                                </a>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
