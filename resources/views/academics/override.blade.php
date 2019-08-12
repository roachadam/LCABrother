@extends('layouts.main');
@section('title', 'Override')
@section('content')
    <div class="container">
        @include('partials.errors')
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Override Academics</div>
                    <div class="card-body">
                        <form method="post" action={{route('academics.update', [$user, $academics])}}>
                            @method('PATCH')
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">'User Name:</label>

                                <div class="col-md-4">
                                    <input id="name" type="text" class="form-control " name="name" value="{{ $academics->name }}" required  readonly="readonly" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="Cumulative_GPA" class="col-md-4 col-form-label text-md-right">Cumulative GPA:</label>

                                <div class="col-md-4">
                                    <input id="Cumulative_GPA" type="text" class="form-control" name="Cumulative_GPA" value="{{ $academics->Cumulative_GPA }}" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="Previous_Term_GPA" class="col-md-4 col-form-label text-md-right">Previous Term GPA:</label>

                                <div class="col-md-4">
                                    <input id="Previous_Term_GPA" type="text" class="form-control " name="Previous_Term_GPA" value="{{ $academics->Previous_Term_GPA }}" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="Current_Term_GPA" class="col-md-4 col-form-label text-md-right">Current Term GPA:</label>

                                <div class="col-md-4">
                                    <input id="Current_Term_GPA" type="text" class="form-control " name="Current_Term_GPA" value="{{ $academics->Current_Term_GPA }}" autofocus>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="Previous_Academic_Standing" class="col-md-4 col-form-label text-md-right">Previous Academic Standing:</label>

                                <select name="Previous_Academic_Standing" id="Previous_Academic_Standing" class="col-md-4 form-control" value="{{ $academics->Previous_Academic_Standing }}">
                                    <option value=" "> </option>
                                    @foreach ($academicStandings as $academicStanding)
                                        <option value="{{$academicStanding->name}}" {{ $academicStanding->name == $academics->Previous_Academic_Standing ? 'selected' : '' }}>{{$academicStanding->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group row">
                                <label for="Current_Academic_Standing" class="col-md-4 col-form-label text-md-right">Current Academic Standing:</label>

                                <select name="Current_Academic_Standing" id="Current_Academic_Standing" class="col-md-4 form-control" value="{{ $academics->Current_Academic_Standing }}">
                                    <option value=" "> </option>
                                    @foreach ($academicStandings as $academicStanding)
                                        <option value="{{$academicStanding->name}}" {{ $academicStanding->name == $academics->Current_Academic_Standing ? 'selected' : '' }}>{{$academicStanding->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <a href="/academics" class="btn btn-primary">Cancel</a>
                                    <button type="submit" class="btn btn-primary">Override</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

