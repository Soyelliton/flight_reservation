@extends('layouts.app')

@section('title', 'Airlines')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Airlines Management</h2>
            <p class="text-muted mb-0">Manage airline information and details</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAirlineModal">
            <i class="fas fa-plus me-2"></i>Add New Airline
        </button>
    </div>

    <!-- Airlines Table -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-building me-2"></i>
                Airlines List
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="airlinesTable" class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Country</th>
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

<!-- Add Airline Modal -->
<div class="modal fade" id="addAirlineModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>Add New Airline
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addAirlineForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="code" class="form-label">Airline Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="code" name="code" required maxlength="3" placeholder="e.g., AA">
                        <div class="invalid-feedback">Please provide a valid airline code.</div>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Airline Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" required placeholder="e.g., American Airlines">
                        <div class="invalid-feedback">Please provide the airline name.</div>
                    </div>
                    <div class="mb-3">
                        <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="country" name="country" required placeholder="e.g., United States">
                        <div class="invalid-feedback">Please provide the country.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Airline
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Airline Modal -->
<div class="modal fade" id="editAirlineModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Edit Airline
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editAirlineForm">
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_code" class="form-label">Airline Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_code" name="code" required maxlength="3">
                        <div class="invalid-feedback">Please provide a valid airline code.</div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Airline Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                        <div class="invalid-feedback">Please provide the airline name.</div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_country" class="form-label">Country <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_country" name="country" required>
                        <div class="invalid-feedback">Please provide the country.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Airline
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Airline Modal -->
<div class="modal fade" id="viewAirlineModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-eye me-2"></i>Airline Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <strong>Airline Code:</strong>
                    </div>
                    <div class="col-md-8" id="view_code"></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <strong>Airline Name:</strong>
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
    initializeAirlinesTable();
    
    // Add airline form submission
    $('#addAirlineForm').on('submit', function(e) {
        e.preventDefault();
        if (validateForm('#addAirlineForm')) {
            $.ajax({
                url: '/airlines',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#addAirlineModal').modal('hide');
                    clearForm('#addAirlineForm');
                    $('#airlinesTable').DataTable().ajax.reload();
                    showToast('Airline added successfully');
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach(function(key) {
                            $('#' + key).addClass('is-invalid');
                            $('#' + key).next('.invalid-feedback').text(errors[key][0]);
                        });
                    } else {
                        showToast('Error adding airline', 'error');
                    }
                }
            });
        }
    });
    
    // Edit airline form submission
    $('#editAirlineForm').on('submit', function(e) {
        e.preventDefault();
        if (validateForm('#editAirlineForm')) {
            const id = $('#edit_id').val();
            $.ajax({
                url: '/airlines/' + id,
                type: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    $('#editAirlineModal').modal('hide');
                    $('#airlinesTable').DataTable().ajax.reload();
                    showToast('Airline updated successfully');
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach(function(key) {
                            $('#edit_' + key).addClass('is-invalid');
                            $('#edit_' + key).next('.invalid-feedback').text(errors[key][0]);
                        });
                    } else {
                        showToast('Error updating airline', 'error');
                    }
                }
            });
        }
    });
    
    // Clear form validation on modal close
    $('.modal').on('hidden.bs.modal', function() {
        clearForm('#addAirlineForm');
        clearForm('#editAirlineForm');
    });
});

function initializeAirlinesTable() {
    $('#airlinesTable').DataTable({
        ajax: '/api/airlines',
        columns: [
            { data: 'id' },
            { 
                data: 'code',
                render: function(data) {
                    return '<span class="badge bg-primary">' + data + '</span>';
                }
            },
            { data: 'name' },
            { data: 'country' },
            {
                data: 'id',
                orderable: false,
                render: function(data) {
                    return `
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-info" onclick="viewAirline(${data})" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-outline-primary" onclick="editAirline(${data})" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-outline-danger" onclick="deleteAirline(${data})" title="Delete">
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

function viewAirline(id) {
    $.get('/airlines/' + id, function(data) {
        $('#view_code').text(data.code);
        $('#view_name').text(data.name);
        $('#view_country').text(data.country);
        $('#view_created').text(new Date(data.created_at).toLocaleString());
        $('#viewAirlineModal').modal('show');
    });
}

function editAirline(id) {
    $.get('/airlines/' + id, function(data) {
        $('#edit_id').val(data.id);
        $('#edit_code').val(data.code);
        $('#edit_name').val(data.name);
        $('#edit_country').val(data.country);
        $('#editAirlineModal').modal('show');
    });
}

function deleteAirline(id) {
    confirmDelete('/airlines/' + id, '#airlinesTable');
}
</script>
@endsection 