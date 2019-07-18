@extends('layouts.main')
@section('title', 'Service Event Breakdown')


@section('content')

<header class="section-header">
    <div class="tbl">
        <div class="tbl-row">
            <div class="tbl-cell">
            <h2>{{$user->name}}'s Service Breakdown</h2>
            </div>
        </div>
    </div>
</header>
<section class="card">
<div class="card-block">
    <table id="table" class="display table table-bordered" cellspacing="0" width="100%">
        <thead>
        @if ($serviceLogs->count())
            <tr>
                <th>Name</th>
                <th>Service Hours</th>
                <th>Money Donated</th>
                <th>Date Logged</th>
                @if (auth()->user()->canManageService())
                    <th>Manage</th>
                    <th>Delete</th>
                @endif
            </tr>
        @endif

        </thead>
        <tbody>

            @forelse ($serviceLogs as $serviceLog)
                <tr>
                    <td>{{ $serviceLog->serviceEvent->name }}</td>
                    <td> {{ $serviceLog->hours_served !== null ? $serviceLog->hours_served : "N/A" }} </td>
                    <td> {{ $serviceLog->money_donated !== null ? $serviceLog->money_donated : "N/A"}} </td>
                    <td>{{ date('m-d-y', strtotime($serviceLog->created_at)) }}</td>
                    @if (auth()->user()->canManageService())
                        <td><a href={{route('serviceLogs.edit', $serviceLog)}} class="btn btn-primary">Edit</a></td>
                        <td><button type="button" class="btn btn-inline btn-danger-outline" data-toggle="modal" data-target="#deleteLog{{$serviceLog->id}}">Delete</button></td>

                        <div class="modal fade" id="deleteLog{{$serviceLog->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                                            <i class="font-icon-close-2"></i>
                                        </button>
                                        <h4 class="modal-title" id="myModalLabel">Delete</h4>
                                    </div>
                                    <form action={{route('serviceLogs.destroy', $serviceLog)}}  method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <div class="modal-body">
                                            <div class="col-md-12">
                                                <p>Are you sure you want to delete {{$serviceLog->user->name}}'s log for {{$serviceLog->serviceEvent->name}}?</p>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-inline btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-inline btn-danger">Delete</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif

                </tr>
            @empty
                This User has no service logs!
            @endforelse

        </tbody>
    </table>
</div>
</section>
@section('js')
<script type="text/javascript" src="{{ asset('js/lib/datatables-net/datatables.min.js') }}"></script>
<script>
$(function() {
    $('#table').DataTable({
        responsive: true
    });
});
</script>
@endsection
@endsection
