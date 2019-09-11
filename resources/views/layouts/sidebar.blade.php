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
    </ul>
    {{-- <ul class="side-menu-list">
        <li class="green">
            <a href="#" id="bugReport" style="position:fixed; bottom: 0; height:40px;">
                <span>
                    <i class="font-icon fas fa-bug"></i>
                    <span class="lbl">Report A Bug</span>
                </span>
            </a>
        </li>
    </ul> --}}
</nav><!--.side-menu-->
