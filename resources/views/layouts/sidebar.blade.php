<nav class="side-menu">
    <ul class="side-menu-list">
        <li class="grey with-sub">
            <span>
                <i class="font-icon font-icon-dashboard"></i>
                <span class="lbl">Dashboard</span>
            </span>
            <ul>
                <li><a href="index.html"><span class="lbl">Default</span><span class="label label-custom label-pill label-danger">new</span></a></li>
                <li><a href="dashboard-top-menu.html"><span class="lbl">Top menu</span></a></li>
                <li><a href="side-menu-compact-full.html"><span class="lbl">Compact menu</span></a></li>
            </ul>
        </li>
        <li class="red">
            <a href="/serviceEvent/create">
                <i class="font-icon glyphicon glyphicon-send"></i>
                <span class="lbl">Submit Service Hours</span>
            </a>
        </li>
        <li class="green">
                <a href="/serviceEvent">
                    <i class="font-icon glyphicon glyphicon-leaf"></i>
                    <span class="lbl">View Service Events</span>
                </a>
        </li>
        <li class="blue">
                <a href="/involvementLog">
                    <i class="glyphicon glyphicon-equalizer"></i>
                    <span class="lbl">View Involvment Scores</span>
                </a>
        </li>
        <li class="yellow">
            <a href="/users/contact">
                <i class="glyphicon glyphicon-earphone"></i>
                <span class="lbl">View Contact Info</span>
            </a>
        </li>
        <li class="yellow">
                <a href="/event">
                    <i class="glyphicon glyphicon-tasks "></i>
                    <span class="lbl">Events</span>
                </a>
            </li>
        <li class="yellow">
            <a href="/forums">
                <i class="glyphicon glyphicon-console"></i>
                <span class="lbl">Forum</span>
            </a>
        </li>
    </ul>

    {{-- TODO: Inline has permission check? --}}
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
                <li class="blue">
                    <a href="/totals">
                    <span>
                        <i class="glyphicon glyphicon-briefcase"></i>
                        <span class="lbl">Totals</span>
                    </span>
                    </a>
                </li>
            @endif
            @if (auth()->user()->canManageMembers())
                <li class="blue">
                    <a href="/survey/create">
                    <span>
                        <i class="glyphicon glyphicon-briefcase"></i>
                        <span class="lbl">Create Survey</span>
                    </span>
                    </a>
                </li>
            @endif
        </ul>
    </section>
</nav><!--.side-menu-->
