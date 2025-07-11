@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Dashboard</h2>
            <p class="text-muted mb-0">Welcome to Air Reservation System Admin Panel</p>
        </div>
        <div class="text-end">
            <small class="text-muted">Last updated: <span id="lastUpdated"></span></small>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-1">Total Flights</h6>
                            <h3 class="mb-0 text-white" id="totalFlights">-</h3>
                        </div>
                        <div class="text-end">
                            <i class="fas fa-plane fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card-2 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-1">Total Customers</h6>
                            <h3 class="mb-0 text-white" id="totalCustomers">-</h3>
                        </div>
                        <div class="text-end">
                            <i class="fas fa-users fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card-3 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-1">Total Bookings</h6>
                            <h3 class="mb-0 text-white" id="totalBookings">-</h3>
                        </div>
                        <div class="text-end">
                            <i class="fas fa-ticket-alt fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title text-white-50 mb-1">Total Revenue</h6>
                            <h3 class="mb-0 text-white" id="totalRevenue">-</h3>
                        </div>
                        <div class="text-end">
                            <i class="fas fa-dollar-sign fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="card">
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-clock me-2"></i>
                    Recent Bookings
                </h5>
                <a href="/bookings" class="btn btn-primary btn-sm">
                    <i class="fas fa-eye me-1"></i>
                    View All
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="recentBookingsTable" class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Booking ID</th>
                            <th>Customer</th>
                            <th>Flight</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be loaded via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- View Booking Modal -->
<div class="modal fade" id="dashboardViewBookingModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-eye me-2"></i>Booking Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="dashboardViewBookingBody">
                <!-- Populated by JS -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Update last updated time
    $('#lastUpdated').text(new Date().toLocaleString());
    
    // Load dashboard statistics
    loadDashboardStats();
    
    // Initialize recent bookings table
    initializeRecentBookingsTable();
    
    // Refresh data every 30 seconds
    setInterval(function() {
        loadDashboardStats();
        $('#recentBookingsTable').DataTable().ajax.reload();
    }, 30000);
});

function loadDashboardStats() {
    // Load flights count
    $.get('/api/flights', function(data) {
        $('#totalFlights').text(data.data.length);
    });
    
    // Load customers count
    $.get('/api/customers', function(data) {
        $('#totalCustomers').text(data.data.length);
    });
    
    // Load bookings count and calculate revenue
    $.get('/api/bookings', function(data) {
        $('#totalBookings').text(data.data.length);
        
        // Calculate total revenue (assuming each booking has a price field)
        let totalRevenue = 0;
        data.data.forEach(function(booking) {
            if (booking.price) {
                totalRevenue += parseFloat(booking.price);
            }
        });
        $('#totalRevenue').text('$' + totalRevenue.toFixed(2));
    });
}

function initializeRecentBookingsTable() {
    $('#recentBookingsTable').DataTable({
        ajax: {
            url: '/api/bookings',
            dataSrc: function(json) {
                // Return only the first 10 bookings for recent view
                return json.data.slice(0, 10);
            }
        },
        columns: [
            { 
                data: 'id',
                render: function(data) {
                    return '<span class="badge bg-primary">#' + data + '</span>';
                }
            },
            { 
                data: 'customer',
                render: function(data) {
                    if (data) {
                        return data.first_name + ' ' + data.last_name;
                    }
                    return 'N/A';
                }
            },
            { 
                data: 'flight',
                render: function(data) {
                    if (data) {
                        return data.flight_number || 'N/A';
                    }
                    return 'N/A';
                }
            },
            { 
                data: 'created_at',
                render: function(data) {
                    return new Date(data).toLocaleDateString();
                }
            },
            { 
                data: 'status',
                render: function(data) {
                    const statusClasses = {
                        'confirmed': 'bg-success',
                        'pending': 'bg-warning',
                        'cancelled': 'bg-danger'
                    };
                    const statusClass = statusClasses[data] || 'bg-secondary';
                    return '<span class="badge ' + statusClass + '">' + (data || 'N/A') + '</span>';
                }
            },
            {
                data: 'id',
                orderable: false,
                render: function(data) {
                    return `
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-primary" onclick="viewBookingFromDashboard(${data})" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        order: [[3, 'desc']], // Sort by date descending
        pageLength: 10,
        searching: false,
        lengthChange: false,
        info: false,
        responsive: true
    });
}

function viewBookingFromDashboard(id) {
    $.get(`/api/bookings/${id}`, function(data) {
        let html = `<div class="row">
            <div class="col-md-6">
                <h6>Booking Info</h6>
                <div><strong>Booking No:</strong> ${data.booking_no}</div>
                <div><strong>City:</strong> ${data.city}</div>
                <div><strong>Booking Date:</strong> ${data.booking_date ? new Date(data.booking_date).toLocaleDateString() : ''}</div>
                <div><strong>Status:</strong> ${data.status}</div>
                <div><strong>Class:</strong> ${data.class}</div>
                <div><strong>Total Price (Local):</strong> ${(data.total_price_local && data.local_currency) ? `${data.total_price_local} ${data.local_currency}` : 'N/A'}</div>
            </div>
            <div class="col-md-6">
                <h6>Flight Info</h6>
                <div><strong>Flight No:</strong> ${data.flight && data.flight.flight_number ? data.flight.flight_number : ''}</div>
                <div><strong>Departure:</strong> ${data.departure_datetime ? new Date(data.departure_datetime).toLocaleString() : ''}</div>
                <div><strong>Arrival:</strong> ${data.arrival_datetime ? new Date(data.arrival_datetime).toLocaleString() : ''}</div>
                <div><strong>Airline:</strong> ${data.flight && data.flight.airline ? data.flight.airline.name : ''}</div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <h6>Customer</h6>
                <div><strong>Name:</strong> ${data.customer ? (data.customer.first_name + ' ' + data.customer.last_name) : ''}</div>
            </div>
            <div class="col-md-6">
                <h6>Passenger</h6>
                <div><strong>Name on Ticket:</strong> ${data.passenger_name}</div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <h6>Price Breakdown</h6>
                <div><strong>Flight Price (USD):</strong> ${data.flight && data.flight.price ? data.flight.price : 'N/A'}</div>
                <div><strong>Origin Tax:</strong> ${data.flight && data.flight.origin_city ? data.flight.origin_city.airport_tax + ' ' + data.flight.origin_city.currency_code : 'N/A'}</div>
                <div><strong>Destination Tax:</strong> ${data.flight && data.flight.destination_city ? data.flight.destination_city.airport_tax + ' ' + data.flight.destination_city.currency_code : 'N/A'}</div>
                <div><strong>Exchange Rate:</strong> ${data.local_currency && data.local_currency !== 'USD' ? `1 ${data.local_currency} = ${data.total_price_local && data.flight && data.flight.price ? (data.flight.price / data.total_price_local).toFixed(4) + ' USD' : 'N/A'}` : '1 USD = 1 USD'}</div>
                <div><strong>Total Price (Local):</strong> ${(data.total_price_local && data.local_currency) ? `${data.total_price_local} ${data.local_currency}` : 'N/A'}</div>
            </div>
        </div>`;
        $('#dashboardViewBookingBody').html(html);
        $('#dashboardViewBookingModal').modal('show');
    });
}
</script>
@endsection 