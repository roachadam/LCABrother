@extends('layouts.main')


@section('content')
<header class="section-header">
        <div class="tbl">
            <div class="tbl-row">
                <div class="tbl-cell">
                    <h2>Surveys</h2>
                    {{-- <div class="subtitle">Welcome to Ultimate Dashboard</div> --}}
                </div>
            </div>
        </div>
    </header>
    <section class="card">
    <div class="card-block">
        <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Survey Name</th>
                    <th>Date Posted</th>
                    <th>Answer</th>
                    @if (auth()->user()->canManageService())
                        <th>View Responses</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($surveys as $survey)
                    <tr>
                        <td>{{$survey->name}}</td>
                        <td>{{$survey->created_at}}</td>
                        <td><a href="/survey/{{$survey->id}}" class="btn btn-inline {{auth()->user()->hasResponded($survey) ? 'disabled' : ''}}" >Submit Response</a></td>
                        <td><a href="/survey/{{$survey->id}}/responses" class="btn btn-inline">View Responses</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

@endsection
