<div class="mobile-menu-left-overlay"></div>
<nav class="side-menu jscroll" id="sidebar">
    <ul class="side-menu-list">
        <li class="grey {{ request()->is('dash') ? 'opened' : '' }}">
            <a href="/dash">
                <i class="font-icon glyphicon glyphicon-home"></i>
                <span class="lbl ">Dashboard</span>
            </a>
        </li>
        <li class="red {{ request()->is('serviceEvent/create') ? 'opened' : '' }}">
            <a href="/serviceEvent/create">
                <i class="font-icon glyphicon glyphicon-send"></i>
                <span class="lbl">Submit Service Hours</span>
            </a>
        </li>
        <li class="green {{ request()->is('serviceEvent') ? 'opened' : '' }}">
                <a href="/serviceEvent">
                    <i class="font-icon glyphicon glyphicon-leaf"></i>
                    <span class="lbl">View Service Events</span>
                </a>
        </li>
        <li class="blue {{ request()->is('serviceEvents/indexByUser') ? 'opened' : '' }}">
            <a href="/serviceEvents/indexByUser">
                <i class="glyphicon glyphicon-calendar"></i>
                <span class="lbl">View Service Logs</span>
            </a>
        </li>
        <li class="pink {{ request()->is('involvementLog') ? 'opened' : '' }}">
            <a href="/involvementLog">
                <i class="glyphicon glyphicon-equalizer"></i>
                <span class="lbl">Involvment Points</span>
            </a>
        </li>
        <li class="blue {{ request()->is('users/contact') ? 'opened' : '' }}">
            <a href="/users/contact">
                <i class="glyphicon glyphicon-earphone"></i>
                <span class="lbl">Member Info</span>
            </a>
        </li>
        <li class="red">
            <a href="/event">
                <i class="glyphicon glyphicon-tasks "></i>
                <span class="lbl">Events</span>
            </a>
        </li>
        <li class="green">
            <a href="/forums">
                <i class="glyphicon glyphicon-bullhorn"></i>
                <span class="lbl">Forum</span>
            </a>
        </li>
        <li class="pink">
            <a href="/survey">
                <i class=" glyphicon glyphicon-blackboard "></i>
                <span class="lbl">Surveys</span>
            </a>
        </li>
        <li class="blue">
            <a href="/calendarItem">
                <i class="glyphicon glyphicon-calendar"></i>
                <span class="lbl">Calendar</span>
            </a>
        </li>
        <li class="blue">
            <a href="/attendanceEvents">
                <i class="glyphicon glyphicon-calendar"></i>
                <span class="lbl">Attendace</span>
            </a>
        </li>

    </ul>
    <section>
        <ul class="side-menu-list">
            @if (auth()->user()->canManageMembers())
                <header class="side-menu-title">High Zeta</header>
                <li class="blue">
                    <a href="/user">
                    <span>
                        <i class="font-icon font-icon-users"></i>
                        <span class="lbl">Members</span>
                    </span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->canManageInvolvment())
                <li class="red">
                    <a href="/involvement">
                    <span>
                        <i class="glyphicon glyphicon-signal"></i>
                        <span class="lbl">Submit Involvement Data</span>
                    </span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->canManageAllStudy())
                <li class="green">
                    <a href="/academics">
                    <span>
                        <i class="fa fa-book"></i>
                        <span class="lbl">Manage Academics</span>
                    </span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->canManageMembers())
                <li class="pink">
                    <a href="/role">
                    <span>
                        <i class="glyphicon glyphicon-th-list"></i>
                        <span class="lbl">Roles</span>
                    </span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->canManageMembers())
                <li class="blue">
                    <a href="/goals">
                    <span>
                        <i class="font-icon font-icon-users"></i>
                        <span class="lbl">Organization Goals</span>
                    </span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->canManageMembers())
                <li class="red">
                    <a href="/totals">
                    <span>
                        <i class="glyphicon glyphicon-book"></i>
                        <span class="lbl">Totals</span>
                    </span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->canManageSurveys())
                <li class="green">
                    <a href="/survey/create">
                    <span>
                        <i class="glyphicon glyphicon-blackboard"></i>
                        <span class="lbl">Create Survey</span>
                    </span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->canManageMembers())
                <li class="pink">
                    <a href="/alumni">
                    <span>
                        <i class=" glyphicon glyphicon-tent "></i>
                        <span class="lbl">Alumni</span>
                    </span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->canManageCalendar())
            <li class="blue">
                <a href="/calendarItem/create">
                <span>
                    <i class="glyphicon glyphicon-calendar"></i>
                    <span class="lbl">Create Calendar Event</span>
                </span>
                </a>
            </li>
            @endif
            {{-- <li class="red">
                <a href="/newsletter/send/show">
                <span>
                    <i class="glyphicon glyphicon-calendar"></i>
                    <span class="lbl">Send newsletter</span>
                </span>
                </a>
            </li>
            <li class="red">
                <a href="/newsletter/create">
                <span>
                    <i class="glyphicon glyphicon-calendar"></i>
                    <span class="lbl">Create newsletter</span>
                </span>
                </a>
            </li>
            <li class="red">
                <a href="/newsletter">
                <span>
                    <i class="glyphicon glyphicon-calendar"></i>
                    <span class="lbl">View Newsletters</span>
                </span>
                </a>
            </li> --}}
        </ul>
    </section>
</nav><!--.side-menu-->
