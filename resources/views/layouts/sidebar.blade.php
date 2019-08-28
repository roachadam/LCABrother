<nav class="side-menu">
    <ul class="side-menu-list">
        <li class="grey {{ request()->is('dash') ? 'opened' : '' }}">
            <a href="/dash">
                <i class="font-icon glyphicon glyphicon-home"></i>
                <span class="lbl ">Dashboard</span>
            </a>
        </li>
        <li class="green {{ request()->is('serviceEvent') ? 'opened' : '' }}">
                <a href="/serviceEvent">
                    <i class="font-icon glyphicon glyphicon-leaf"></i>
                    <span class="lbl">Service Events</span>
                </a>
        </li>
        <li class="blue {{ request()->is('serviceLogs') ? 'opened' : '' }}">
            <a href="/serviceLogs">
                <i class="glyphicon glyphicon-calendar"></i>
                <span class="lbl">Service Logs</span>
            </a>
        </li>
        <li class="pink {{ request()->is('involvement') ? 'opened' : '' }}">
            <a href="/involvement">
                <i class="glyphicon glyphicon-equalizer"></i>
                <span class="lbl">Involvment</span>
            </a>
        </li>
        <li class="blue {{ request()->is('users/contact') ? 'opened' : '' }}">
            <a href="/users/contact">
                <i class="glyphicon glyphicon-earphone"></i>
                <span class="lbl">Member Info</span>
            </a>
        </li>
        <li class="red {{ request()->is('event') ? 'opened' : '' }}">
            <a href="/event">
                <i class="glyphicon glyphicon-tasks "></i>
                <span class="lbl">Events</span>
            </a>
        </li>
        {{-- <li class="green {{ request()->is('forums') ? 'opened' : '' }}">
            <a href="/forums">
                <i class="glyphicon glyphicon-bullhorn"></i>
                <span class="lbl">Forum</span>
            </a>
        </li> --}}
        <li class="pink {{ request()->is('survey') ? 'opened' : '' }}">
            <a href="/survey">
                <i class=" glyphicon glyphicon-blackboard "></i>
                <span class="lbl">Surveys</span>
            </a>
        </li>
        <li class="purple {{ request()->is('tasks') ? 'opened' : '' }}">
            <a href="/tasks">
                <i class="glyphicon glyphicon-list-alt"></i>
                <span class="lbl">Tasks</span>
            </a>
        </li>
        <li class="blue {{ request()->is('calendarItem') ? 'opened' : '' }}">
            <a href="/calendarItem">
                <i class="glyphicon glyphicon-calendar"></i>
                <span class="lbl">Calendar</span>
            </a>
        </li>
        <li class="blue {{ request()->is('attendanceEvents') ? 'opened' : '' }}">
            <a href="/attendanceEvents">
                <i class="glyphicon glyphicon-calendar"></i>
                <span class="lbl">Attendance</span>
            </a>
        </li>
    </ul>
    <section>
        <ul class="side-menu-list">
            @if (auth()->user()->canViewMembers())
                <header class="side-menu-title">High Zeta</header>
                <li class="blue {{ request()->is('user') ? 'opened' : '' }}">
                    <a href="/user">
                    <span>
                        <i class="font-icon font-icon-users"></i>
                        <span class="lbl">Members</span>
                    </span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->canManageInvolvement())
                <li class="red {{ request()->is('involvement/edit') ? 'opened' : '' }}">
                    <a href="/involvement/adminView">
                    <span>
                        <i class="glyphicon glyphicon-signal"></i>
                        <span class="lbl">Involvement Events</span>
                    </span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->canManageAllStudy())
                <li class="green {{ request()->is('academics') ? 'opened' : '' }}">
                    <a href="/academics">
                    <span>
                        <i class="fa fa-book"></i>
                        <span class="lbl">Academics</span>
                    </span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->canManageMembers())
                <li class="pink {{ request()->is('role') ? 'opened' : '' }}">
                    <a href="/role">
                    <span>
                        <i class="glyphicon glyphicon-th-list"></i>
                        <span class="lbl">Roles</span>
                    </span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->canManageGoals())
                <li class="red {{ request()->is('totals') ? 'opened' : '' }}">
                    <a href="/totals">
                    <span>
                        <i class="glyphicon glyphicon-book"></i>
                        <span class="lbl">Totals</span>
                    </span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->canManageSurveys())
                <li class="green {{ request()->is('survey/create') ? 'opened' : '' }}">
                    <a href="/survey/create">
                    <span>
                        <i class="glyphicon glyphicon-blackboard"></i>
                        <span class="lbl">Create Survey</span>
                    </span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->canManageAlumni())
                <li class="pink {{ request()->is('alumni') ? 'opened' : '' }}">
                    <a href="/alumni">
                    <span>
                        <i class=" glyphicon glyphicon-tent "></i>
                        <span class="lbl">Alumni</span>
                    </span>
                    </a>
                </li>
            @endif
            {{-- @if (auth()->user()->canManageCalendar())
            <li class="blue {{ request()->is('calendarItem/create') ? 'opened' : '' }}">
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
