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

{!! $chart->container() !!}

@endsection


