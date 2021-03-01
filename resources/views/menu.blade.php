<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}"><span class="text-warning">CSMC</span> VIMS-IR</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                @if(auth()->check())
                <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/') }}"><i class="fa fa-home"></i> Home</a>
                </li>
                <li class="nav-item {{ request()->is('list*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/list') }}"><i class="fa fa-pencil-square"></i> Encoded List</a>
                </li>
                <li class="nav-item {{ request()->is('masterlist*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ url('/masterlist') }}"><i class="fa fa-database"></i> Master List</a>
                </li>
                <li class="nav-item {{ request()->is('mydata*') ? 'active' : '' }} hidden">
                    <a class="nav-link" href="{{ url('/mydata') }}"><i class="fa fa-database"></i> My Data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/logout') }}"><i class="fa fa-sign-out"></i> Logout</a>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/login') }}"><i class="fa fa-sign-in"></i> Login</a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
