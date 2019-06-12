@extends('layouts.main');

@section('content')
<div class="container">
    @include('partials.errors')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Override Academics') }}</div>
                <div class="card-body">
                    <form method="POST" action="/academics/{{$academics->id}}/update">
                        @csrf
                        @method('PATCH')
                        <div class="form-group row"> {{-- Name --}}
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('User Name') }}</label>

                            <div class="col-md-4">
                                <input id="name" type="text" class="form-control " name="name" value="{{ $academics->name }}" required  readonly="readonly" autofocus>
                            </div>
                        </div>

                        <div class="form-group row"> {{--date_of_event --}}
                            <label for="Cumulative_GPA" class="col-md-4 col-form-label text-md-right">{{ __('Cumulative GPA') }}</label>

                            <div class="col-md-4">
                                <input id="Cumulative_GPA" type="text" class="form-control" name="Cumulative_GPA" value="{{ $academics->Cumulative_GPA }}" autofocus>
                            </div>
                        </div>

                        <div class="form-group row"> {{-- num_invites --}}
                            <label for="Previous_Term_GPA" class="col-md-4 col-form-label text-md-right">{{ __('Previous Term GPA') }}</label>

                            <div class="col-md-4">
                                <input id="Previous_Term_GPA" type="text" class="form-control " name="Previous_Term_GPA" value="{{ $academics->Previous_Term_GPA }}" autofocus>
                            </div>
                        </div>

                        <div class="form-group row"> {{-- num_invites --}}
                            <label for="Current_Term_GPA" class="col-md-4 col-form-label text-md-right">{{ __('Current Term GPA') }}</label>

                            <div class="col-md-4">
                                <input id="Current_Term_GPA" type="text" class="form-control " name="Current_Term_GPA" value="{{ $academics->Current_Term_GPA }}" autofocus>
                            </div>
                        </div>

                        <div class="form-group row"> {{-- num_invites --}}
                            <label for="Previous_Academic_Standing" class="col-md-4 col-form-label text-md-right">{{ __('Previous Academic Standing') }}</label>

                            <div class="col-md-4">
                                <input id="Previous_Academic_Standing" type="text" class="form-control " name="Previous_Academic_Standing" value="{{ $academics->Previous_Academic_Standing }}" autofocus>
                            </div>
                        </div>

                        <div class="form-group row"> {{-- num_invites --}}
                            <label for="Current_Academic_Standing" class="col-md-4 col-form-label text-md-right">{{ __('Current Academic Standing') }}</label>

                            <div class="col-md-4">
                                <input id="Current_Academic_Standing" type="text" class="form-control " name="Current_Academic_Standing" value="{{ $academics->Current_Academic_Standing }}" autofocus>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <a href="/academics" class="btn btn-primary">Cancel</a>
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
