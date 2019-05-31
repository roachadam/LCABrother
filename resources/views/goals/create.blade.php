@extends('layouts.app')

@section('content')
<div class="container">
    @include('partials.errors')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Set Organization Goals') }}</div>


                {{-- todo: middleware for organization being set --}}
                <div class="card-body">
                    <form method="POST" action="/goals/store">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Service Hours Goal') }}</label>

                            <div class="col-md-4">
                                <input id="service_hours_goal" type="text" class="form-control " name="service_hours_goal" value="{{ old('service_hours_goal') }}" required autocomplete="service_hours_goal" autofocus>
                            </div>

                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Money Donated Goal') }}</label>

                            <div class="col-md-4">
                                <input id="service_money_goal" type="text" class="form-control" name="service_money_goal" value="{{ old('service_money_goal') }}" required autocomplete="service_money_goal" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="study_goal" class="col-md-4 col-form-label text-md-right">{{ __('Study Hours Goal') }}</label>

                            <div class="col-md-4">
                                <input id="study_goal" type="text" class="form-control " name="study_goal" value="{{ old('study_goal') }}" required autocomplete="study_goal" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="points_goal" class="col-md-4 col-form-label text-md-right">{{ __('Involvement Points Goal') }}</label>

                            <div class="col-md-4">
                                <input id="points_goal" type="text" class="form-control " name="points_goal" value="{{ old('points_goal') }}" required autocomplete="points_goal" autofocus>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
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
