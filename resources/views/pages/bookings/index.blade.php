@extends('layouts.app')

@section('title', 'Bookings')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Bookings Management</h2>
            <p class="text-muted mb-0">View, print, edit, or delete flight bookings</p>
        </div>
        <a href="#" class="btn btn-primary" id="addBookingBtn">
            <i class="fas fa-plus me-2"></i>New Booking
        </a>
    </div>
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-ticket-alt me-2"></i>Bookings List
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="bookingsTable" class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Booking No</th>
                            <th>City</th>
                            <th>Booking Date</th>
                            <th>Flight No</th>
                            <th>Departure</th>
                            <th>Status</th>
                            <th>Passenger</th>
                            <th>Total Price (Local)</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- View Booking Modal -->
<div class="modal fade" id="viewBookingModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-eye me-2"></i>Booking Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="viewBookingBody">
                <!-- Populated by JS -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Print Ticket Modal -->
<div class="modal fade" id="printTicketModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-print me-2"></i>Print Ticket</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="printTicketBody">
                <!-- Populated by JS -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="window.print()">
                    <i class="fas fa-print me-2"></i>Print
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Booking Modal (skeleton, you can expand as needed) -->
<div class="modal fade" id="editBookingModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editBookingForm">
                <div class="modal-body" id="editBookingBody">
                    <!-- Populated by JS -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Create Booking Modal -->
<div class="modal fade" id="createBookingModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus me-2"></i>New Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createBookingForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">City</label>
                            <input type="text" class="form-control" name="city" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Flight</label>
                            <select class="form-select" name="flight_id" required id="createFlightSelect"></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Booking Date</label>
                            <input type="date" class="form-control" name="booking_date" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Class</label>
                            <select class="form-select" name="class" required>
                                <option value="economy">Economy</option>
                                <option value="business">Business</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Passenger Name</label>
                            <input type="text" class="form-control" name="passenger_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Customer</label>
                            <select class="form-select" name="customer_id" required id="createCustomerSelect"></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Departure</label>
                            <input type="datetime-local" class="form-control" name="departure_datetime" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Arrival</label>
                            <input type="datetime-local" class="form-control" name="arrival_datetime" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Amount Paid</label>
                            <input type="number" class="form-control" name="amount_paid" min="0" value="0" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" name="status" required>
                                <option value="booked">Booked</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="scratched">Scratched</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Initialize DataTable
    const table = $('#bookingsTable').DataTable({
        ajax: {
            url: '/api/bookings',
            dataSrc: 'data'
        },
        columns: [
            { data: 'booking_no' },
            { data: 'city' },
            { data: 'booking_date', render: d => d ? new Date(d).toLocaleDateString() : '' },
            { data: 'flight', render: d => d && d.flight_number ? d.flight_number : '' },
            { data: 'departure_datetime', render: d => d ? new Date(d).toLocaleString() : '' },
            { data: 'status', render: d => d ? d.charAt(0).toUpperCase() + d.slice(1) : '' },
            { data: 'passenger_name' },
            { data: null, render: function(data) {
                return (data.total_price_local && data.local_currency) ? `${data.total_price_local} ${data.local_currency}` : 'N/A';
            }},
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-info" onclick="viewBooking(${row.id})" title="View"><i class="fas fa-eye"></i></button>
                            <button class="btn btn-sm btn-success" onclick="printTicket(${row.id})" title="Print Ticket"><i class="fas fa-print"></i></button>
                            <button class="btn btn-sm btn-primary" onclick="editBooking(${row.id})" title="Edit"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger" onclick="deleteBooking(${row.id})" title="Delete"><i class="fas fa-trash"></i></button>
                        </div>
                    `;
                }
            }
        ],
        responsive: true,
        order: [[0, 'desc']],
        processing: true,
        serverSide: false,
        pageLength: 10
    });

    // View Booking
    window.viewBooking = function(id) {
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
            $('#viewBookingBody').html(html);
            $('#viewBookingModal').modal('show');
        });
    };

    // Print Ticket
    window.printTicket = function(id) {
        $.get(`/api/bookings/${id}`, function(data) {
            let html = `<div class="ticket p-4">
                <h4 class="mb-3"><i class="fas fa-plane me-2"></i>Flight Ticket</h4>
                <div><strong>Booking No:</strong> ${data.booking_no}</div>
                <div><strong>Passenger:</strong> ${data.passenger_name}</div>
                <div><strong>Flight:</strong> ${data.flight && data.flight.flight_number ? data.flight.flight_number : ''} (${data.flight && data.flight.airline ? data.flight.airline.name : ''})</div>
                <div><strong>From:</strong> ${data.city}</div>
                <div><strong>Departure:</strong> ${data.departure_datetime ? new Date(data.departure_datetime).toLocaleString() : ''}</div>
                <div><strong>Arrival:</strong> ${data.arrival_datetime ? new Date(data.arrival_datetime).toLocaleString() : ''}</div>
                <div><strong>Class:</strong> ${data.class}</div>
                <div><strong>Status:</strong> ${data.status}</div>
                <div><strong>Total Price (Local):</strong> ${(data.total_price_local && data.local_currency) ? `${data.total_price_local} ${data.local_currency}` : 'N/A'}</div>
                <hr>
                <div><strong>Price Breakdown:</strong></div>
                <div>Flight Price (USD): ${data.flight && data.flight.price ? data.flight.price : 'N/A'}</div>
                <div>Origin Tax: ${data.flight && data.flight.origin_city ? data.flight.origin_city.airport_tax + ' ' + data.flight.origin_city.currency_code : 'N/A'}</div>
                <div>Destination Tax: ${data.flight && data.flight.destination_city ? data.flight.destination_city.airport_tax + ' ' + data.flight.destination_city.currency_code : 'N/A'}</div>
                <div>Exchange Rate: ${data.local_currency && data.local_currency !== 'USD' ? `1 ${data.local_currency} = ${data.total_price_local && data.flight && data.flight.price ? (data.flight.price / data.total_price_local).toFixed(4) + ' USD' : 'N/A'}` : '1 USD = 1 USD'}</div>
            </div>`;
            $('#printTicketBody').html(html);
            $('#printTicketModal').modal('show');
        });
    };

    // Edit Booking (skeleton)
    window.editBooking = function(id) {
        $.get(`/api/bookings/${id}`, function(data) {
            let html = `<div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Booking No</label>
                        <input type="text" class="form-control" name="booking_no" value="${data.booking_no}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">City</label>
                        <input type="text" class="form-control" name="city" value="${data.city}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Booking Date</label>
                        <input type="date" class="form-control" name="booking_date" value="${data.booking_date ? data.booking_date.split('T')[0] : ''}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Passenger Name</label>
                        <input type="text" class="form-control" name="passenger_name" value="${data.passenger_name}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Amount Paid</label>
                        <input type="number" class="form-control" name="amount_paid" value="${data.amount_paid}">
                    </div>
                </div>
            </div>`;
            $('#editBookingBody').html(html);
            $('#editBookingModal').modal('show');
            $('#editBookingForm').off('submit').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();
                $.ajax({
                    url: `/api/bookings/${id}`,
                    type: 'PUT',
                    data: formData,
                    success: function() {
                        $('#editBookingModal').modal('hide');
                        table.ajax.reload();
                        showToast('Booking updated successfully');
                    },
                    error: function() {
                        showToast('Error updating booking', 'error');
                    }
                });
            });
        });
    };

    // Delete Booking
    window.deleteBooking = function(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This will permanently delete the booking.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/api/bookings/${id}`,
                    type: 'DELETE',
                    success: function() {
                        table.ajax.reload();
                        showToast('Booking deleted successfully');
                    },
                    error: function() {
                        showToast('Error deleting booking', 'error');
                    }
                });
            }
        });
    };

    // Show Create Booking Modal
    $('#addBookingBtn').on('click', function(e) {
        e.preventDefault();
        // Load flights for the select
        $.get('/api/flights', function(response) {
            let options = '<option value="">Select Flight</option>';
            response.data.forEach(function(f) {
                options += `<option value="${f.id}">${f.flight_number} (${f.airline ? f.airline.name : ''})</option>`;
            });
            $('#createFlightSelect').html(options);
        });
        // Load customers for the select
        $.get('/api/customers', function(response) {
            let options = '<option value="">Select Customer</option>';
            response.data.forEach(function(c) {
                options += `<option value="${c.id}">${c.first_name} ${c.last_name}</option>`;
            });
            $('#createCustomerSelect').html(options);
        });
        $('#createBookingModal').modal('show');
    });
    // Handle Create Booking Form Submission
    $('#createBookingForm').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        const formData = form.serializeArray();
        // Add a random booking_no
        formData.push({ name: 'booking_no', value: 'BK' + Math.random().toString(36).substr(2, 8) });
        // Calculate balance = 0 for now (can be updated after creation)
        formData.push({ name: 'balance', value: 0 });
        // Calculate price = 0 for now (will be calculated in backend)
        formData.push({ name: 'price', value: 0 });
        $.ajax({
            url: '/api/bookings',
            type: 'POST',
            data: $.param(formData),
            success: function() {
                $('#createBookingModal').modal('hide');
                form[0].reset();
                $('#bookingsTable').DataTable().ajax.reload();
                showToast('Booking created successfully');
            },
            error: function(xhr) {
                showToast('Error creating booking', 'error');
            }
        });
    });
});
</script>
@endsection 