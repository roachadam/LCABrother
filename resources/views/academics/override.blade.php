@extends('layouts.main');

@section('content')
<div class="container">
    @include('partials.errors')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Override Academics') }}</div>
                <div class="card-body">
                    <form method="POST" action="/user/{{$user->id}}/academics/{{$academics->id}}/update">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('User Name') }}</label>

                            <div class="col-md-4">
                                <input id="name" type="text" class="form-control " name="name" value="{{ $academics->name }}" required  readonly="readonly" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="Cumulative_GPA" class="col-md-4 col-form-label text-md-right">{{ __('Cumulative GPA') }}</label>

                            <div class="col-md-4">
                                <input id="Cumulative_GPA" type="text" class="form-control" name="Cumulative_GPA" value="{{ $academics->Cumulative_GPA }}" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="Previous_Term_GPA" class="col-md-4 col-form-label text-md-right">{{ __('Previous Term GPA') }}</label>

                            <div class="col-md-4">
                                <input id="Previous_Term_GPA" type="text" class="form-control " name="Previous_Term_GPA" value="{{ $academics->Previous_Term_GPA }}" autofocus>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="Current_Term_GPA" class="col-md-4 col-form-label text-md-right">{{ __('Current Term GPA') }}</label>

                            <div class="col-md-4">
                                <input id="Current_Term_GPA" type="text" class="form-control " name="Current_Term_GPA" value="{{ $academics->Current_Term_GPA }}" autofocus>
                            </div>
                        </div>

                        <?php
                            $default_Previous_Academic_Standing = $academics->Previous_Academic_Standing == null ? " " : $academics->Previous_Academic_Standing;
                            $default_Current_Academic_Standing = $academics->Current_Academic_Standing == null ? " " : $academics->Current_Academic_Standing;
                         ?>
                        @section('js')
                        <script>
                                $(document).ready(() => {
                                    $("#Previous_Academic_Standing option:contains(" + '<?php echo $default_Previous_Academic_Standing?>' + ")").attr('selected', 'selected');
                                    $("#Current_Academic_Standing option:contains(" + '<?php echo $default_Current_Academic_Standing?>' + ")").attr('selected', 'selected');
                                });
                            </script>
                        @endsection


                        <div class="form-group row">
                            <label for="Previous_Academic_Standing" class="col-md-4 col-form-label text-md-right">{{ __('Previous Academic Standing') }}</label>

                            <select name="Previous_Academic_Standing" id="Previous_Academic_Standing" class="col-md-4 form-control" value="{{ $academics->Previous_Academic_Standing }}">
                                <option value=" "> </option>
                                <option value="Good">Good</option>
                                <option value="Probation">Probation</option>
                                <option value="Suspension">Suspension</option>
                            </select>
                        </div>

                        <div class="form-group row">
                            <label for="Current_Academic_Standing" class="col-md-4 col-form-label text-md-right">{{ __('Current Academic Standing') }}</label>

                            <select name="Current_Academic_Standing" id="Current_Academic_Standing" class="col-md-4 form-control" value="{{ $academics->Current_Academic_Standing }}">
                                <option value=" "> </option>
                                <option value="Good">Good</option>
                                <option value="Probation">Probation</option>
                                <option value="Suspension">Suspension</option>
                            </select>
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

