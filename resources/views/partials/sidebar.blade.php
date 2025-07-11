<nav class="sidebar p-3">
    <div class="d-flex align-items-center mb-4">
        <i class="fas fa-plane-departure fa-2x text-white me-3"></i>
        <h5 class="text-white mb-0">Air Reservation</h5>
    </div>
    
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link {{ request()->is('flights*') ? 'active' : '' }}" href="/flights">
                <i class="fas fa-plane"></i>
                Flights
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link {{ request()->is('airlines*') ? 'active' : '' }}" href="/airlines">
                <i class="fas fa-building"></i>
                Airlines
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link {{ request()->is('cities*') ? 'active' : '' }}" href="/cities">
                <i class="fas fa-city"></i>
                Cities
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link {{ request()->is('customers*') ? 'active' : '' }}" href="/customers">
                <i class="fas fa-users"></i>
                Customers
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link {{ request()->is('bookings*') ? 'active' : '' }}" href="/bookings">
                <i class="fas fa-ticket-alt"></i>
                Bookings
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link {{ request()->is('currency-rates*') ? 'active' : '' }}" href="/currency-rates">
                <i class="fas fa-dollar-sign"></i>
                Currency Rates
            </a>
        </li>
    </ul>
    
    <div class="mt-auto pt-4">
        <div class="text-white-50 small">
            <i class="fas fa-info-circle me-2"></i>
            Admin Dashboard v1.0
        </div>
    </div>
</nav> 