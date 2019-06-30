@extends('layouts.main')

@section('content')
    <div class="card">
        <div class="card-header">Averages</div>
        <div class="card-body">
            Service Hours: {{$averages['service']}}
            <br>
            Money Donated: {{$averages['money']}}
            <br>
            Involvement Points: {{$averages['points']}}
        </div>
    </div>

    <div class="card">
        <div class="card-header">Totals</div>
        <div class="card-body">
            Service Hours: {{$totals['service']}}  / {{$sumTotals['service']}}
            <br>
            Money Donated: {{$totals['money']}}  /  {{$sumTotals['money']}}
            <br>
            Involvement Points: {{$totals['points']}} / {{$sumTotals['points']}}
        </div>
    </div>
    <button type="button" class="btn btn-warning-outline" data-toggle="modal" data-target="#modal">Reset Totals</button>



    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="modal-close" data-dismiss="modal" aria-label="Close">
                            <i class="font-icon-close-2"></i>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">Reset Totals</h4>
                    </div>

                </div>
            </div>
        </div>


@endsection


