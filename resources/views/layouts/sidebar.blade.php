<nav id="sidebar">
    <div class="sidebar-header">
        <h3>
            <img src="{{ asset('img/Repair.png') }}" class="img-fluid" />
            Repair Service
        </h3>
    </div>
    <ul class="list-unstyled components">
        <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a href="{{ route('dashboard') }}"><i class="material-icons">dashboard</i><span>Dashboard</span></a>
        </li>
        <li class="{{ request()->routeIs('customers.*') ? 'active' : '' }}">
            <a href="{{ route('customers.index') }}"><i class="material-icons">people</i><span>Customer Info</span></a>
        </li>
        <li class="{{ request()->routeIs('services.*') ? 'active' : '' }}">
            <a href="{{ route('services.index') }}"><i class="material-icons">description</i><span>Service
                    Report</span></a>
        </li>
        <li class="{{ request()->routeIs('transactions.*') ? 'active' : '' }}">
            <a href="{{ route('transactions.index') }}"><i
                    class="material-icons">payment</i><span>Transactions</span></a>
        </li>
        <li class="{{ request()->routeIs('inventory.*') ? 'active' : '' }}">
            <a href="{{ route('inventory.index') }}"><i class="material-icons">build</i><span>Parts</span></a>
        </li>
        <!-- Work Service link was in original, mapped to Services for now or ignore if redundant -->
        <!-- <li class="{{ request()->is('work_service.php') ? 'active' : '' }}">
            <a href="#"><i class="material-icons">miscellaneous_services</i><span>Work Service</span></a>
        </li> -->

        @can('admin-only')
            <li class="{{ request()->routeIs('staff.*') ? 'active' : '' }}">
                <a href="{{ route('staff.index') }}"><i class="material-icons">engineering</i><span>Staff</span></a>
            </li>
            <li class="{{ request()->routeIs('archive.*') ? 'active' : '' }}">
                <a href="{{ route('archive.index') }}"><i class="material-icons">archive</i><span>Archive History</span></a>
            </li>
            <li class="{{ request()->routeIs('prices.*') ? 'active' : '' }}">
                <a href="{{ route('prices.index') }}"><i class="material-icons">price_change</i><span>Service
                        Prices</span></a>
            </li>
        @endcan
    </ul>

    <div class="logout-container">
        <form method="POST" action="{{ route('logout') }}" id="logout-form">
            @csrf
            <a href="#" class="btn-logout"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <span class="material-icons align-middle">logout</span>
                <span class="logout-text">Logout</span>
            </a>
        </form>
    </div>
</nav>