@extends('layouts.app')

@section('title', 'Flights')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Flights Management</h2>
            <p class="text-muted mb-0">Manage flight schedules and availability</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addFlightModal">
            <i class="fas fa-plus me-2"></i>Add New Flight
        </button>
    </div>

    <!-- Flights Table -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-plane me-2"></i>
                Flights List
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="flightsTable" class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Flight Number</th>
                            <th>Airline</th>
                            <th>Business Class</th>
                            <th>Smoking Allowed</th>
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

<!-- Add Flight Modal -->
<div class="modal fade" id="addFlightModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>Add New Flight
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addFlightForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="flight_number" class="form-label">Flight Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="flight_number" name="flight_number" required>
                                <div class="invalid-feedback">Please provide the flight number.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="airline_id" class="form-label">Airline <span class="text-danger">*</span></label>
                                <select class="form-select" id="airline_id" name="airline_id" required>
                                    <option value="">Select Airline</option>
                                </select>
                                <div class="invalid-feedback">Please select an airline.</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="business_class" class="form-label">Business Class <span class="text-danger">*</span></label>
                                <select class="form-select" id="business_class" name="business_class" required>
                                    <option value="">Select Option</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                <div class="invalid-feedback">Please select business class availability.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="smoking_allowed" class="form-label">Smoking Allowed <span class="text-danger">*</span></label>
                                <select class="form-select" id="smoking_allowed" name="smoking_allowed" required>
                                    <option value="">Select Option</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                <div class="invalid-feedback">Please select smoking policy.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Flight
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Flight Modal -->
<div class="modal fade" id="editFlightModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Edit Flight
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editFlightForm">
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_flight_number" class="form-label">Flight Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_flight_number" name="flight_number" required>
                                <div class="invalid-feedback">Please provide the flight number.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_airline_id" class="form-label">Airline <span class="text-danger">*</span></label>
                                <select class="form-select" id="edit_airline_id" name="airline_id" required>
                                    <option value="">Select Airline</option>
                                </select>
                                <div class="invalid-feedback">Please select an airline.</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_business_class" class="form-label">Business Class <span class="text-danger">*</span></label>
                                <select class="form-select" id="edit_business_class" name="business_class" required>
                                    <option value="">Select Option</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                <div class="invalid-feedback">Please select business class availability.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_smoking_allowed" class="form-label">Smoking Allowed <span class="text-danger">*</span></label>
                                <select class="form-select" id="edit_smoking_allowed" name="smoking_allowed" required>
                                    <option value="">Select Option</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                                <div class="invalid-feedback">Please select smoking policy.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Flight
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Flight Modal -->
<div class="modal fade" id="viewFlightModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-eye me-2"></i>Flight Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Flight Information</h6>
                        <div class="mb-2">
                            <strong>Flight Number:</strong> <span id="view_flight_number"></span>
                        </div>
                        <div class="mb-2">
                            <strong>Airline:</strong> <span id="view_airline"></span>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <h6>Flight Features</h6>
                        <div class="mb-2">
                            <strong>Business Class:</strong> <span id="view_business_class"></span>
                        </div>
                        <div class="mb-2">
                            <strong>Smoking Allowed:</strong> <span id="view_smoking_allowed"></span>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Created:</strong> <span id="view_created"></span>
                    </div>
                    <div class="col-md-6">
                        <strong>Last Updated:</strong> <span id="view_updated"></span>
                    </div>
                </div>
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
    loadAirlines();
    initializeFlightsTable();
    
    // Add flight form submission
    $('#addFlightForm').on('submit', function(e) {
        e.preventDefault();
        if (validateForm('#addFlightForm')) {
            $.ajax({
                url: '/flights',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#addFlightModal').modal('hide');
                    clearForm('#addFlightForm');
                    $('#flightsTable').DataTable().ajax.reload();
                    showToast('Flight added successfully');
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach(function(key) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).next('.invalid-feedback').text(errors[key][0]);
                        });
                    } else {
                        showToast('Error adding flight', 'error');
                    }
                }
            });
        }
    });
    
    // Edit flight form submission
    $('#editFlightForm').on('submit', function(e) {
        e.preventDefault();
        if (validateForm('#editFlightForm')) {
            const id = $('#edit_id').val();
            $.ajax({
                url: '/flights/' + id,
                type: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    $('#editFlightModal').modal('hide');
                    $('#flightsTable').DataTable().ajax.reload();
                    showToast('Flight updated successfully');
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach(function(key) {
                            $('#edit_' + key).addClass('is-invalid');
                            $('#edit_' + key).next('.invalid-feedback').text(errors[key][0]);
                        });
                    } else {
                        showToast('Error updating flight', 'error');
                    }
                }
            });
        }
    });
    
    // Clear form validation on modal close
    $('.modal').on('hidden.bs.modal', function() {
        clearForm('#addFlightForm');
        clearForm('#editFlightForm');
    });
});

function loadAirlines() {
    $.get('/api/airlines', function(data) {
        let options = '<option value="">Select Airline</option>';
        data.data.forEach(function(airline) {
            options += '<option value="' + airline.id + '">' + airline.name + ' (' + airline.code + ')</option>';
        });
        $('#airline_id, #edit_airline_id').html(options);
    });
}

function initializeFlightsTable() {
    $('#flightsTable').DataTable({
        ajax: '/api/flights',
        columns: [
            { data: 'id' },
            { 
                data: 'flight_number',
                render: function(data) {
                    return '<span class="badge bg-primary">' + data + '</span>';
                }
            },
            { 
                data: 'airline',
                render: function(data) {
                    return data ? data.name : 'N/A';
                }
            },
            { 
                data: 'business_class',
                render: function(data) {
                    return data ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>';
                }
            },
            { 
                data: 'smoking_allowed',
                render: function(data) {
                    return data ? '<span class="badge bg-warning">Yes</span>' : '<span class="badge bg-secondary">No</span>';
                }
            },
            {
                data: 'id',
                orderable: false,
                render: function(data) {
                    return `
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-info" onclick="viewFlight(${data})" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-primary" onclick="editFlight(${data})" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-outline-danger" onclick="deleteFlight(${data})" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        responsive: true,
        order: [[0, 'desc']]
    });
}

function viewFlight(id) {
    $.get('/flights/' + id, function(data) {
        $('#view_flight_number').text(data.flight_number);
        $('#view_airline').text(data.airline ? data.airline.name : 'N/A');
        $('#view_business_class').text(data.business_class ? 'Yes' : 'No');
        $('#view_smoking_allowed').text(data.smoking_allowed ? 'Yes' : 'No');
        $('#view_created').text(new Date(data.created_at).toLocaleString());
        $('#view_updated').text(new Date(data.updated_at).toLocaleString());
        $('#viewFlightModal').modal('show');
    });
}

function editFlight(id) {
    $.get('/flights/' + id, function(data) {
        $('#edit_id').val(data.id);
        $('#edit_flight_number').val(data.flight_number);
        $('#edit_airline_id').val(data.airline_id);
        $('#edit_business_class').val(data.business_class ? '1' : '0');
        $('#edit_smoking_allowed').val(data.smoking_allowed ? '1' : '0');
        $('#editFlightModal').modal('show');
    });
}

function deleteFlight(id) {
    confirmDelete('/flights/' + id, '#flightsTable');
}
</script>
@endsection 