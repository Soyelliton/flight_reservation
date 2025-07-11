@extends('layouts.app')

@section('title', 'Cities')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Cities Management</h2>
            <p class="text-muted mb-0">Manage city information and details</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCityModal">
            <i class="fas fa-plus me-2"></i>Add New City
        </button>
    </div>

    <!-- Cities Table -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-city me-2"></i>
                Cities List
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="citiesTable" class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Country</th>
                            <th>State/Province</th>
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

<!-- Add City Modal -->
<div class="modal fade" id="addCityModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>Add New City
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addCityForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">City Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" required placeholder="e.g., New York">
                        <div class="invalid-feedback">Please provide the city name.</div>
                    </div>
                    <div class="mb-3">
                        <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="country" name="country" required placeholder="e.g., United States">
                        <div class="invalid-feedback">Please provide the country.</div>
                    </div>
                    <div class="mb-3">
                        <label for="state_province" class="form-label">State/Province <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="state_province" name="state_province" required placeholder="e.g., New York">
                        <div class="invalid-feedback">Please provide the state or province.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save City
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit City Modal -->
<div class="modal fade" id="editCityModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Edit City
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editCityForm">
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">City Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                        <div class="invalid-feedback">Please provide the city name.</div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_country" class="form-label">Country <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_country" name="country" required>
                        <div class="invalid-feedback">Please provide the country.</div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_state_province" class="form-label">State/Province <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_state_province" name="state_province" required>
                        <div class="invalid-feedback">Please provide the state or province.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update City
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View City Modal -->
<div class="modal fade" id="viewCityModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-eye me-2"></i>City Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <strong>City Name:</strong>
                    </div>
                    <div class="col-md-8" id="view_name"></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <strong>Country:</strong>
                    </div>
                    <div class="col-md-8" id="view_country"></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <strong>State/Province:</strong>
                    </div>
                    <div class="col-md-8" id="view_state_province"></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <strong>Created:</strong>
                    </div>
                    <div class="col-md-8" id="view_created"></div>
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
    initializeCitiesTable();
    
    // Add city form submission
    $('#addCityForm').on('submit', function(e) {
        e.preventDefault();
        if (validateForm('#addCityForm')) {
            $.ajax({
                url: '/api/cities',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#addCityModal').modal('hide');
                    clearForm('#addCityForm');
                    $('#citiesTable').DataTable().ajax.reload();
                    showToast('City added successfully');
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach(function(key) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).next('.invalid-feedback').text(errors[key][0]);
                        });
                    } else {
                        showToast('Error adding city', 'error');
                    }
                }
            });
        }
    });
    
    // Edit city form submission
    $('#editCityForm').on('submit', function(e) {
        e.preventDefault();
        if (validateForm('#editCityForm')) {
            const id = $('#edit_id').val();
            $.ajax({
                url: '/api/cities/' + id,
                type: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    $('#editCityModal').modal('hide');
                    $('#citiesTable').DataTable().ajax.reload();
                    showToast('City updated successfully');
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach(function(key) {
                            $('#edit_' + key).addClass('is-invalid');
                            $('#edit_' + key).next('.invalid-feedback').text(errors[key][0]);
                        });
                    } else {
                        showToast('Error updating city', 'error');
                    }
                }
            });
        }
    });
    
    // Clear form validation on modal close
    $('.modal').on('hidden.bs.modal', function() {
        clearForm('#addCityForm');
        clearForm('#editCityForm');
    });
});

function initializeCitiesTable() {
    $('#citiesTable').DataTable({
        ajax: {
            url: '/api/cities',
            dataSrc: 'data'
        },
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'country' },
            { data: 'state_province' },
            {
                data: 'id',
                orderable: false,
                searchable: false,
                render: function(data) {
                    return `
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-info" onclick="viewCity(${data})" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-primary" onclick="editCity(${data})" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteCity(${data})" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    `;
                }
            }
        ],
        responsive: true,
        order: [[0, 'desc']],
        processing: true,
        serverSide: false,
        pageLength: 10,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        language: {
            search: "Search:",
            lengthMenu: "Show _MENU_ entries per page",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "Showing 0 to 0 of 0 entries",
            infoFiltered: "(filtered from _MAX_ total entries)",
            zeroRecords: "No matching records found",
            processing: "Processing..."
        }
    });
}

function viewCity(id) {
    $.get('/api/cities/' + id, function(data) {
        $('#view_name').text(data.name);
        $('#view_country').text(data.country);
        $('#view_state_province').text(data.state_province || 'N/A');
        $('#view_created').text(new Date(data.created_at).toLocaleString());
        $('#viewCityModal').modal('show');
    });
}

function editCity(id) {
    $.get('/api/cities/' + id, function(data) {
        $('#edit_id').val(data.id);
        $('#edit_name').val(data.name);
        $('#edit_country').val(data.country);
        $('#edit_state_province').val(data.state_province || '');
        $('#editCityModal').modal('show');
    });
}

function deleteCity(id) {
    confirmDelete('/api/cities/' + id, '#citiesTable');
}
</script>
@endsection 