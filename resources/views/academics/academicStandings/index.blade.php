@extends('layouts.main')

@section('content')
    <header class="section-header">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h2>Academic Standing Rules</h2>
                </div>
            </div>
        </div>
    </header>

    @include('partials.errors')

    <section class="card">
        <div class="card-block">
            <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Term GPA Min</th>
                    <th>Cumulative GPA Min</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($academicStandings as $academicStanding)
                        <tr>
                            <td>{{ $academicStanding->name }}</td>
                            <td>{{ $academicStanding->Term_GPA_Min }}</td>
                            <td>{{ $academicStanding->Cumulative_GPA_Min }}</td>
                            <td><a href="/academicStandings/{{$academicStanding->id}}/edit" class="btn btn-inline">Edit</a></td>
                            <td><button type="button" class="btn btn-inline btn-outline-danger" data-toggle="modal" data-target="#{{$academicStanding->name}}">Delete</button></td>
                        </tr>

                        <!--.modal for confirming deletion-->
                        <div class="modal fade" id="{{$academicStanding->name}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                            <i class="font-icon-close-2"></i>
                                        </button>
                                        <h4 class="modal-title" id="myModalLabel">Delete</h4>
                                    </div>
                                    <form action="/academicStandings/{{$academicStanding->id}}" method="POST" class="box" >
                                        <div class="modal-body">
                                            @csrf
                                            @method('DELETE')
                                            <div class="col-md-12">
                                                <p>Are you sure you want to delete this standing?</p>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-inline btn-danger">Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div><!--.modal-->
                    @endforeach
                </tbody>
            </table>
            <button type="button" class="btn btn-inline btn-primary align-right" data-toggle="modal" data-target="#addMoreRules">Add More Standing Rules</button>

            <!--.modal for adding standing rules-->
            <div class="modal fade" id="addMoreRules" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                <i class="font-icon-close-2"></i>
                            </button>
                            <h4 class="modal-title" id="myModalLabel">Add a new rule</h4>
                        </div>
                        <form method="POST" action="/academicStandings" class="box" >
                            <div class="modal-body">
                                @csrf
                                <label>Name of Category</label>
                                <input id="name" type="text" class="form-control " name="name" value="{{ old('name') }}" required autofocus>

                                <div class="form-group" id="GPAs">
                                    <label>Current Term Gpa Min</label>
                                    <input id="Term_GPA_Min" type="text" class="form-control " name="Term_GPA_Min" value="{{ old('Term_GPA_Min') }}" required autofocus>

                                    <label>Cumulative Term Gpa Min</label>
                                    <input id="Cumulative_GPA_Min" type="text" class="form-control " name="Cumulative_GPA_Min" value="{{ old('Cumulative_GPA_Min') }}" required autofocus>
                                </div>
                            </div>

                            <input type="hidden" name="SubmitAndFinishCheck" id="SubmitAndFinishCheck" value="0">

                            <div class="modal-footer">
                                <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-inline btn-primary">Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!--.modal-->
        </div>
    </section>
@endsection
