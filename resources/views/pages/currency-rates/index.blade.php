@extends('layouts.app')

@section('title', 'Currency Rates')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Currency Exchange Rates</h2>
            <p class="text-muted mb-0">Manage daily exchange rates for all supported currencies</p>
        </div>
        <a href="#" class="btn btn-primary" id="addRateBtn">
            <i class="fas fa-plus me-2"></i>New Rate
        </a>
    </div>
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-coins me-2"></i>Rates List
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="currencyRatesTable" class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Currency</th>
                            <th>Rate to USD</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Rate Modal -->
<div class="modal fade" id="addRateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-plus me-2"></i>Add Rate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addRateForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" class="form-control" name="rate_date" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Currency</label>
                        <select class="form-select" name="currency_code" required>
                            <option value="">Select Currency</option>
                            <option value="CAD">CAD</option>
                            <option value="USD">USD</option>
                            <option value="GBP">GBP</option>
                            <option value="FRF">FRF</option>
                            <option value="DEM">DEM</option>
                            <option value="LIR">LIR</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rate to USD</label>
                        <input type="number" step="0.0001" class="form-control" name="rate_to_usd" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Rate
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Rate Modal (skeleton) -->
<div class="modal fade" id="editRateModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Edit Rate</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editRateForm">
                <div class="modal-body" id="editRateBody">
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
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    const table = $('#currencyRatesTable').DataTable({
        ajax: {
            url: '/api/currency-rates',
            dataSrc: 'data'
        },
        columns: [
            { data: 'rate_date', title: 'Date', render: d => d ? new Date(d).toLocaleDateString() : 'N/A' },
            { data: 'currency_code', title: 'Currency', render: d => d ? d : 'N/A' },
            { data: 'rate_to_usd', title: 'Rate to USD', render: d => (d && !isNaN(parseFloat(d))) ? parseFloat(d).toFixed(4) : 'N/A' },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-primary" onclick="editRate(${row.id})" title="Edit"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger" onclick="deleteRate(${row.id})" title="Delete"><i class="fas fa-trash"></i></button>
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

    // Show Add Rate Modal
    $('#addRateBtn').on('click', function(e) {
        e.preventDefault();
        $('#addRateForm')[0].reset();
        $('#addRateModal').modal('show');
    });
    // Handle Add Rate Form Submission
    $('#addRateForm').on('submit', function(e) {
        e.preventDefault();
        const form = $(this);
        $.ajax({
            url: '/api/currency-rates',
            type: 'POST',
            data: form.serialize(),
            success: function() {
                $('#addRateModal').modal('hide');
                form[0].reset();
                $('#currencyRatesTable').DataTable().ajax.reload();
                showToast('Rate added successfully');
            },
            error: function(xhr) {
                showToast('Error adding rate', 'error');
            }
        });
    });

    // Update Edit Rate Modal to use same form structure and AJAX
    window.editRate = function(id) {
        $.get(`/api/currency-rates/${id}`, function(data) {
            let html = `<div class="mb-3">
                <label class="form-label">Date</label>
                <input type="date" class="form-control" name="rate_date" value="${data.rate_date ? data.rate_date.substring(0,10) : ''}" required>
            </div>`;
            html += `<div class="mb-3">
                <label class="form-label">Currency</label>
                <select class="form-select" name="currency_code" required>
                    <option value="">Select Currency</option>
                    <option value="CAD" ${data.currency_code === 'CAD' ? 'selected' : ''}>CAD</option>
                    <option value="USD" ${data.currency_code === 'USD' ? 'selected' : ''}>USD</option>
                    <option value="GBP" ${data.currency_code === 'GBP' ? 'selected' : ''}>GBP</option>
                    <option value="FRF" ${data.currency_code === 'FRF' ? 'selected' : ''}>FRF</option>
                    <option value="DEM" ${data.currency_code === 'DEM' ? 'selected' : ''}>DEM</option>
                    <option value="LIR" ${data.currency_code === 'LIR' ? 'selected' : ''}>LIR</option>
                </select>
            </div>`;
            html += `<div class="mb-3">
                <label class="form-label">Rate to USD</label>
                <input type="number" step="0.0001" class="form-control" name="rate_to_usd" value="${data.rate_to_usd ? data.rate_to_usd : ''}" required>
            </div>`;
            $('#editRateBody').html(html);
            $('#editRateModal').modal('show');
            $('#editRateForm').off('submit').on('submit', function(e) {
                e.preventDefault();
                const formData = $(this).serialize();
                $.ajax({
                    url: `/api/currency-rates/${id}`,
                    type: 'PUT',
                    data: formData,
                    success: function() {
                        $('#editRateModal').modal('hide');
                        $('#currencyRatesTable').DataTable().ajax.reload();
                        showToast('Rate updated successfully');
                    },
                    error: function() {
                        showToast('Error updating rate', 'error');
                    }
                });
            });
        });
    };

    // Delete Rate
    window.deleteRate = function(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This will permanently delete the rate.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/api/currency-rates/${id}`,
                    type: 'DELETE',
                    success: function() {
                        table.ajax.reload();
                        showToast('Rate deleted successfully');
                    },
                    error: function() {
                        showToast('Error deleting rate', 'error');
                    }
                });
            }
        });
    };
});
</script>
@endsection 