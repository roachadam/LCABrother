@extends('layouts.main')


@section('title', 'Dashboard')

@section('content')


<div class="row">
    {{-- <div class="col-xl-6">
        <div class="chart-statistic-box">
            <div class="chart-txt">
                <div class="chart-txt-top">
                    <p><span class="unit">$</span><span class="number">1540</span></p>
                    <p class="caption">Week income</p>
                </div>
                <table class="tbl-data">
                    <tbody><tr>
                        <td class="price color-purple">120$</td>
                        <td>Orders</td>
                    </tr>
                    <tr>
                        <td class="price color-yellow">15$</td>
                        <td>Investments</td>
                    </tr>
                    <tr>
                        <td class="price color-lime">55$</td>
                        <td>Others</td>
                    </tr>
                </tbody></table>
            </div>
            <div class="chart-container">
                <div class="chart-container-in">
                    <div id="chart_div"><div style="position: relative;"><div style="position: relative; width: 385px; height: 314px;" dir="ltr"><div style="position: absolute; left: 0px; top: 0px; width: 100%; height: 100%;" aria-label="A chart."><svg width="385" height="314" style="overflow: hidden;" aria-label="A chart."><defs id="_ABSTRACT_RENDERER_ID_30"><clipPath id="_ABSTRACT_RENDERER_ID_31"><rect x="0" y="0" width="385" height="314"></rect></clipPath></defs><rect x="0" y="0" width="385" height="314" stroke="none" stroke-width="0" fill="#008ffb"></rect><g><rect x="0" y="0" width="385" height="314" stroke="none" stroke-width="0" fill-opacity="0" fill="#ffffff"></rect><g clip-path="url(file:///C:/Users/Admin/Desktop/startui/build/dark-menu.html#_ABSTRACT_RENDERER_ID_31)"><g><rect x="0" y="313" width="385" height="1" stroke="none" stroke-width="0" fill="#1ba0fc"></rect><rect x="0" y="291" width="385" height="1" stroke="none" stroke-width="0" fill="#1ba0fc"></rect><rect x="0" y="268" width="385" height="1" stroke="none" stroke-width="0" fill="#1ba0fc"></rect><rect x="0" y="246" width="385" height="1" stroke="none" stroke-width="0" fill="#1ba0fc"></rect><rect x="0" y="224" width="385" height="1" stroke="none" stroke-width="0" fill="#1ba0fc"></rect><rect x="0" y="201" width="385" height="1" stroke="none" stroke-width="0" fill="#1ba0fc"></rect><rect x="0" y="179" width="385" height="1" stroke="none" stroke-width="0" fill="#1ba0fc"></rect><rect x="0" y="157" width="385" height="1" stroke="none" stroke-width="0" fill="#1ba0fc"></rect><rect x="0" y="134" width="385" height="1" stroke="none" stroke-width="0" fill="#1ba0fc"></rect><rect x="0" y="112" width="385" height="1" stroke="none" stroke-width="0" fill="#1ba0fc"></rect><rect x="0" y="89" width="385" height="1" stroke="none" stroke-width="0" fill="#1ba0fc"></rect><rect x="0" y="67" width="385" height="1" stroke="none" stroke-width="0" fill="#1ba0fc"></rect><rect x="0" y="45" width="385" height="1" stroke="none" stroke-width="0" fill="#1ba0fc"></rect><rect x="0" y="22" width="385" height="1" stroke="none" stroke-width="0" fill="#1ba0fc"></rect><rect x="0" y="0" width="385" height="1" stroke="none" stroke-width="0" fill="#1ba0fc"></rect></g><g><g><path d="M0.5,313.5L0.5,313.5L0.5,197.24285714285713L48.5,197.24285714285713L96.5,152.52857142857144L144.5,157L192.5,134.64285714285714L240.5,161.4714285714286L288.5,89.92857142857144L336.5,116.75714285714287L384.5,116.75714285714287L384.5,313.5L384.5,313.5Z" stroke="none" stroke-width="0" fill-opacity="0.18" fill="#ffffff"></path></g></g><g><rect x="0" y="313" width="385" height="1" stroke="none" stroke-width="0" fill="#16b4fc"></rect></g><g><path d="M0.5,197.24285714285713L48.5,197.24285714285713L96.5,152.52857142857144L144.5,157L192.5,134.64285714285714L240.5,161.4714285714286L288.5,89.92857142857144L336.5,116.75714285714287L384.5,116.75714285714287" stroke="#ffffff" stroke-width="2" fill-opacity="1" fill="none"></path></g></g><g><circle cx="0.5" cy="197.24285714285713" r="3.5" stroke="none" stroke-width="0" fill="#ffffff"></circle><circle cx="48.5" cy="197.24285714285713" r="3.5" stroke="none" stroke-width="0" fill="#ffffff"></circle><circle cx="96.5" cy="152.52857142857144" r="3.5" stroke="none" stroke-width="0" fill="#ffffff"></circle><circle cx="144.5" cy="157" r="3.5" stroke="none" stroke-width="0" fill="#ffffff"></circle><circle cx="192.5" cy="134.64285714285714" r="3.5" stroke="none" stroke-width="0" fill="#ffffff"></circle><circle cx="240.5" cy="161.4714285714286" r="3.5" stroke="none" stroke-width="0" fill="#ffffff"></circle><circle cx="288.5" cy="89.92857142857144" r="3.5" stroke="none" stroke-width="0" fill="#ffffff"></circle><circle cx="336.5" cy="116.75714285714287" r="3.5" stroke="none" stroke-width="0" fill="#ffffff"></circle><circle cx="384.5" cy="116.75714285714287" r="3.5" stroke="none" stroke-width="0" fill="#ffffff"></circle></g></g><g></g></svg><div aria-label="A tabular representation of the data in the chart." style="position: absolute; left: -10000px; top: auto; width: 1px; height: 1px; overflow: hidden;"><table><thead><tr><th>Day</th><th>Values</th></tr></thead><tbody><tr><td>MON</td><td>130</td></tr><tr><td>TUE</td><td>130</td></tr><tr><td>WED</td><td>180</td></tr><tr><td>THU</td><td>175</td></tr><tr><td>FRI</td><td>200</td></tr><tr><td>SAT</td><td>170</td></tr><tr><td>SUN</td><td>250</td></tr><tr><td>MON</td><td>220</td></tr><tr><td>TUE</td><td>220</td></tr></tbody></table></div></div></div><div style="display: none; position: absolute; top: 324px; left: 395px; white-space: nowrap; font-family: Proxima Nova; font-size: 11px; font-weight: bold;" aria-hidden="true">...</div><div></div></div></div>
                    <header class="chart-container-title">Income</header>
                    <div class="chart-container-x">
                        <div class="item"></div>
                        <div class="item">tue</div>
                        <div class="item">wed</div>
                        <div class="item">thu</div>
                        <div class="item">fri</div>
                        <div class="item">sat</div>
                        <div class="item">sun</div>
                        <div class="item">mon</div>
                        <div class="item"></div>
                    </div>
                    <div class="chart-container-y">
                        <div class="item">300</div>
                        <div class="item"></div>
                        <div class="item">250</div>
                        <div class="item"></div>
                        <div class="item">200</div>
                        <div class="item"></div>
                        <div class="item">150</div>
                        <div class="item"></div>
                        <div class="item">100</div>
                        <div class="item"></div>
                        <div class="item">50</div>
                        <div class="item"></div>
                    </div>
                </div>
            </div>
        </div><!--.chart-statistic-box-->
    </div><!--.col--> --}}
    <div class="col-xl-12">
        <div class="row">
            <div class="col-sm-3">
                <article class="statistic-box red" id="serviceHours">
                    <div>
                        <div class="number">{{ $hoursServed }}</div>
                        <div class="caption"><div>Service Hours</div></div>
                    </div>
                </article>
            </div><!--.col-->

            <div class="col-sm-3">
                <article class="statistic-box green" id="moneyDonated">
                    <div>
                        <div class="number">{{ $moneyDonated }}</div>
                        <div class="caption"><div>Money Donated</div></div>
                    </div>
                </article>
            </div><!--.col-->

            <div class="col-sm-3">
                <article class="statistic-box blue" id="points">
                    <div>
                        <div class="number">{{ $points }}</div>
                        <div class="caption"><div>Points</div></div>
                    </div>
                </article>
            </div><!--.col-->

            <div class="col-sm-3">
                <article class="statistic-box yellow" id="academics">
                    <div>
                        <div class="number">{{ $gpa }}</div>
                        <div class="caption"><div>Semester GPA</div></div>
                    </div>
                </article>
            </div><!--.col-->
        </div><!--.row-->
    </div><!--.col-->
</div><!--.row-->

<section class="box-typical">
    <header class="box-typical-header">
        <div class="tbl-row">
            <div class="tbl-cell tbl-cell-title">
                <h1>Invites</h1>
            </div>
        </div>
    </header>
    <div class="box-typical-body">
        <div class="table-responsive">
            <table class="table table-hover" id="table2">
                <thead>
                    <tr>
                        <th>Event Name</th>
                        <th>Date</th>
                        <th>Invites Remaining</th>
                        <th>Add Guest</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($eventsWithInvites as $event)
                        <tr>
                            <td>{{$event->name}}</td>
                            <td>{{$event->date_of_event}}</td>
                            <td>{{$user->getInvitesRemaining($event)}}</td>
                            <td><a href={{route('invite.create', $event)}} class="btn btn-inline btn-primary">Add Guest</a></td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div><!--.box-typical-body-->
</section><!--.box-typical-->

<section class="box-typical">
    <header class="box-typical-header">
        <div class="tbl-row">
            <div class="tbl-cell tbl-cell-title">
                <h1>Surveys</h1>
            </div>
        </div>
    </header>
    <div class="box-typical-body">
        <div class="table-responsive">
            <table class="table table-hover" id="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Date Posted</th>
                        <th>Respond</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($unAnsweredSurveys as $survey)
                        <tr>
                            <td>{{$survey->name}}</td>
                            <td>{{$survey->desc}}</td>
                            <td>{{$survey->created_at}}</td>
                            <td><a href={{route('survey.show', $survey)}} class="btn btn-inline btn-primary">Respond</a></td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div><!--.box-typical-body-->
</section><!--.box-typical-->


@endsection
@section('js')
<script type="text/javascript" src="{{ asset('js/lib/datatables-net/datatables.min.js') }}"></script>
<script>
    $(function() {
        $('#table').DataTable({
            responsive: true,
            bPaginate: false,
            bFilter: false,
            bInfo: false,
            ordering: false
        });
        $('#table2').DataTable({
            responsive: true,
            bPaginate: false,
            bFilter: false,
            bInfo: false,
            ordering: false
        });
    });
</script>

<script>

$(document).ready(function() {

    const serviceHours = $("#serviceHours")
    const moneyDonated = $("#moneyDonated")
    const points    = $("#points")
    const academics = $("#academics")

    serviceHours.click(function() {
        window.location.href = '{{route("serviceLogs.breakdown", $user)}}';
    });
    serviceHours.hover(function() {
        $(this).css('cursor','pointer');
    });

    moneyDonated.click(function() {
        window.location.href = '{{route("serviceLogs.breakdown", $user)}}';
    });
    moneyDonated.hover(function() {
        $(this).css('cursor','pointer');
    });

    points.click(function() {
        window.location.href = '{{route("involvement.breakdown", $user)}}';
    });
    points.hover(function() {
        $(this).css('cursor','pointer');
    });

    academics.click(function() {
        window.location.href = '{{route("academics.index")}}';
    });
    academics.hover(function() {
        $(this).css('cursor','pointer');
    });

  });
</script>

@endsection
