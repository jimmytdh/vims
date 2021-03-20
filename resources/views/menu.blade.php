<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}"><span class="text-warning">CSMC</span> VIMS</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                @if(auth()->check())
                <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                </li>

                <li class="nav-item dropdown {{ request()->is('report*') ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        <i class="fa fa-line-chart"></i> Report
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item {{ request()->is('report/cbcr') ? 'active' : '' }}" href="{{ url('/report/cbcr') }}"><i class="fa fa-area-chart mr-1"></i> CBCR Report</a>
                        <a class="dropdown-item {{ request()->is('report/facility') ? 'active' : '' }}" href="{{ url('/report/facility') }}"><i class="fa fa-building mr-1"></i> Facility Report</a>
                    </div>
                </li>
                @if(auth()->user()->isAdmin())
                <li class="nav-item {{ request()->is('list/master') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/list/master') }}"><i class="fa fa-database"></i> Advance List</a>
                </li>
                @endif

                <li class="nav-item {{ request()->is('list') ? 'active' : '' }}" hidden>
                    <a class="nav-link" href="{{ url('/list') }}"><i class="fa fa-database"></i> Master List</a>
                </li>

                <li class="nav-item dropdown {{ request()->is('list*') ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        <i class="fa fa-database"></i> Master List
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item {{ request()->is('list') ? 'active' : '' }}" href="{{ url('/list') }}"><i class="fa fa-users mr-1"></i> Personnel</a>
                        <a class="dropdown-item {{ request()->is('list/vas') ? 'active' : '' }}" href="{{ url('/list/vas') }}"><i class="fa fa-users mr-1"></i> Vaccinees</a>
                        <a class="dropdown-item {{ request()->is('list/vas/all') ? 'active' : '' }}" href="{{ url('/list/vas/all') }}"><i class="fa fa-users mr-1"></i> All Data</a>
                    </div>
                </li>

                <li class="nav-item dropdown {{ request()->is('register*') ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        <i class="fa fa-list"></i> Registration
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item {{ request()->is('register') ? 'active' : '' }}" href="{{ url('/register') }}"><i class="fa fa-user-plus mr-1"></i> Personnel</a>
                        <a class="dropdown-item {{ request()->is('register/vas') ? 'active' : '' }}" href="{{ url('/register/vas') }}"><i class="fa fa-user-plus mr-1"></i> Vaccinees</a>
                        <a class="dropdown-item {{ request()->is('vas/vaccinator') ? 'active' : '' }}" href="{{ url('/vas/vaccinator') }}"><i class="fa fa-user-md mr-1"></i> Vaccinator</a>
                    </div>
                </li>

                <li class="nav-item {{ request()->is('employees') ? 'active' : '' }}" hidden>
                    <a class="nav-link" href="{{ url('/employees') }}"><i class="fa fa-users"></i> Employees</a>
                </li>
                @if(auth()->user()->isAdmin())
                <li class="nav-item {{ request()->is('mydata*') ? 'active' : '' }} hidden">
                    <a class="nav-link" href="{{ url('/mydata') }}"><i class="fa fa-database"></i> My Data</a>
                </li>
                <li class="nav-item dropdown {{ request()->is('list/fix*') ? 'active' : '' }} hidden">
                    <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                        <i class="fa fa-gears"></i> Fix Data
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item {{ request()->is('list/fix') ? 'active' : '' }}" href="{{ url('/list/fix') }}"><i class="fa fa-users mr-1"></i> Employees</a>
                        <a class="dropdown-item {{ request()->is('list/fix/muncity*') ? 'active' : '' }}" href="{{ url('/list/fix/muncity') }}"><i class="fa fa-building mr-1"></i> Municipality/City</a>
                        <a class="dropdown-item {{ request()->is('list/fix/brgy*') ? 'active' : '' }}" href="{{ url('/list/fix/brgy') }}"><i class="fa fa-building-o mr-1"></i> Barangay</a>
                    </div>
                </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/logout') }}"><i class="fa fa-sign-out"></i> Logout</a>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('register/vas') ? 'active' : '' }}" href="{{ url('/register/vas') }}"><i class="fa fa-user-plus mr-1"></i> Vaccinees</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/login') }}"><i class="fa fa-sign-in"></i> Login</a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
