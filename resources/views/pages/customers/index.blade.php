@extends('layouts.app')

@section('title', 'Customers')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Customers Management</h2>
            <p class="text-muted mb-0">Manage customer information and contact details</p>
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
            <i class="fas fa-plus me-2"></i>Add New Customer
        </button>
    </div>

    <!-- Customers Table -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-users me-2"></i>
                Customers List
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="customersTable" class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Primary Email</th>
                            <th>Phone Numbers</th>
                            <th>Address</th>
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

<!-- Add Customer Modal -->
<div class="modal fade" id="addCustomerModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>Add New Customer
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="addCustomerForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required>
                                <div class="invalid-feedback">Please provide the first name.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required>
                                <div class="invalid-feedback">Please provide the last name.</div>
                            </div>
                        </div>
                    </div>
                    
                    <h6 class="mb-3">Contact Information</h6>
                    
                    <!-- Email Addresses -->
                    <div class="mb-3">
                        <label class="form-label">Email Addresses</label>
                        <div id="emailContainer">
                            <div class="email-row mb-2">
                                <div class="input-group">
                                    <input type="email" class="form-control" name="emails[]" placeholder="Enter email address">
                                    <button type="button" class="btn btn-outline-secondary add-email" title="Add another email">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Phone Numbers -->
                    <div class="mb-3">
                        <label class="form-label">Phone Numbers</label>
                        <div id="phoneContainer">
                            <div class="phone-row mb-2">
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="tel" class="form-control phone-input" name="phones[0][full_number]" placeholder="Enter phone number">
                                        <input type="hidden" name="phones[0][country_code]" class="country-code">
                                        <input type="hidden" name="phones[0][area_code]" class="area-code">
                                        <input type="hidden" name="phones[0][local_number]" class="local-number">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-secondary add-phone" title="Add another phone">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Fax Numbers -->
                    <div class="mb-3">
                        <label class="form-label">Fax Numbers</label>
                        <div id="faxContainer">
                            <div class="fax-row mb-2">
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="tel" class="form-control fax-input" name="faxes[0][full_number]" placeholder="Enter fax number">
                                        <input type="hidden" name="faxes[0][country_code]" class="country-code">
                                        <input type="hidden" name="faxes[0][area_code]" class="area-code">
                                        <input type="hidden" name="faxes[0][local_number]" class="local-number">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-secondary add-fax" title="Add another fax">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <h6 class="mb-3">Address Information</h6>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="street" class="form-label">Street Address <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="street" name="address[street]" required>
                                <div class="invalid-feedback">Please provide the street address.</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="city" name="address[city]" required>
                                <div class="invalid-feedback">Please provide the city.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="state" class="form-label">State/Province <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="state" name="address[state_or_province]" required>
                                <div class="invalid-feedback">Please provide the state or province.</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="postal_code" class="form-label">Postal Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="postal_code" name="address[postal_code]" required>
                                <div class="invalid-feedback">Please provide the postal code.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="country" name="address[country]" required>
                                <div class="invalid-feedback">Please provide the country.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Save Customer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Customer Modal -->
<div class="modal fade" id="editCustomerModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-edit me-2"></i>Edit Customer
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editCustomerForm">
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_first_name" name="first_name" required>
                                <div class="invalid-feedback">Please provide the first name.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_last_name" name="last_name" required>
                                <div class="invalid-feedback">Please provide the last name.</div>
                            </div>
                        </div>
                    </div>
                    
                    <h6 class="mb-3">Contact Information</h6>
                    
                    <!-- Email Addresses -->
                    <div class="mb-3">
                        <label class="form-label">Email Addresses</label>
                        <div id="editEmailContainer">
                            <div class="email-row mb-2">
                                <div class="input-group">
                                    <input type="email" class="form-control" name="emails[]" placeholder="Enter email address">
                                    <button type="button" class="btn btn-outline-secondary add-edit-email" title="Add another email">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Phone Numbers -->
                    <div class="mb-3">
                        <label class="form-label">Phone Numbers</label>
                        <div id="editPhoneContainer">
                            <div class="phone-row mb-2">
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="tel" class="form-control phone-input" name="phones[0][full_number]" placeholder="Enter phone number">
                                        <input type="hidden" name="phones[0][country_code]" class="country-code">
                                        <input type="hidden" name="phones[0][area_code]" class="area-code">
                                        <input type="hidden" name="phones[0][local_number]" class="local-number">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-secondary add-edit-phone" title="Add another phone">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Fax Numbers -->
                    <div class="mb-3">
                        <label class="form-label">Fax Numbers</label>
                        <div id="editFaxContainer">
                            <div class="fax-row mb-2">
                                <div class="row">
                                    <div class="col-md-10">
                                        <input type="tel" class="form-control fax-input" name="faxes[0][full_number]" placeholder="Enter fax number">
                                        <input type="hidden" name="faxes[0][country_code]" class="country-code">
                                        <input type="hidden" name="faxes[0][area_code]" class="area-code">
                                        <input type="hidden" name="faxes[0][local_number]" class="local-number">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-secondary add-edit-fax" title="Add another fax">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <h6 class="mb-3">Address Information</h6>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="edit_street" class="form-label">Street Address <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_street" name="address[street]" required>
                                <div class="invalid-feedback">Please provide the street address.</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_city" class="form-label">City <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_city" name="address[city]" required>
                                <div class="invalid-feedback">Please provide the city.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_state" class="form-label">State/Province <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_state" name="address[state_or_province]" required>
                                <div class="invalid-feedback">Please provide the state or province.</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_postal_code" class="form-label">Postal Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_postal_code" name="address[postal_code]" required>
                                <div class="invalid-feedback">Please provide the postal code.</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_country" class="form-label">Country <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit_country" name="address[country]" required>
                                <div class="invalid-feedback">Please provide the country.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Customer
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Customer Modal -->
<div class="modal fade" id="viewCustomerModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-eye me-2"></i>Customer Details
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Personal Information</h6>
                        <div class="mb-2">
                            <strong>Name:</strong> <span id="view_name"></span>
                        </div>
                        <div class="mb-2">
                            <strong>Email Addresses:</strong>
                            <div id="view_emails"></div>
                        </div>
                        <div class="mb-2">
                            <strong>Phone Numbers:</strong>
                            <div id="view_phones"></div>
                        </div>
                        <div class="mb-2">
                            <strong>Fax Numbers:</strong>
                            <div id="view_faxes"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>Address Information</h6>
                        <div class="mb-2">
                            <strong>Street:</strong> <span id="view_street"></span>
                        </div>
                        <div class="mb-2">
                            <strong>City:</strong> <span id="view_city"></span>
                        </div>
                        <div class="mb-2">
                            <strong>State/Province:</strong> <span id="view_state"></span>
                        </div>
                        <div class="mb-2">
                            <strong>Postal Code:</strong> <span id="view_postal_code"></span>
                        </div>
                        <div class="mb-2">
                            <strong>Country:</strong> <span id="view_country"></span>
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
    // Check if IntlTelInput is loaded
    if (typeof window.intlTelInput === 'undefined') {
        console.warn('IntlTelInput plugin not loaded. Check if the script is properly included.');
    } else {
        console.log('IntlTelInput plugin loaded successfully');
    }
    
    initializeCustomersTable();
    initializeContactFormHandlers();
    initializeAllPhoneInputs();
    
    // Add customer form submission
    $('#addCustomerForm').on('submit', function(e) {
        e.preventDefault();
        if (validateForm('#addCustomerForm')) {
            $.ajax({
                url: '/api/customers',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#addCustomerModal').modal('hide');
                    clearForm('#addCustomerForm');
                    resetContactContainers();
                    $('#customersTable').DataTable().ajax.reload();
                    showToast('Customer added successfully');
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach(function(key) {
                            if (key.includes('.')) {
                                $('[name="' + key + '"]').addClass('is-invalid');
                                $('[name="' + key + '"]').next('.invalid-feedback').text(errors[key][0]);
                            } else {
                                $('#' + key).addClass('is-invalid');
                                $('#' + key).next('.invalid-feedback').text(errors[key][0]);
                            }
                        });
                    } else {
                        showToast('Error adding customer', 'error');
                    }
                }
            });
        }
    });
    
    // Edit customer form submission
    $('#editCustomerForm').on('submit', function(e) {
        e.preventDefault();
        if (validateForm('#editCustomerForm')) {
            const id = $('#edit_id').val();
            $.ajax({
                url: '/api/customers/' + id,
                type: 'PUT',
                data: $(this).serialize(),
                success: function(response) {
                    $('#editCustomerModal').modal('hide');
                    $('#customersTable').DataTable().ajax.reload();
                    showToast('Customer updated successfully');
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach(function(key) {
                            if (key.includes('.')) {
                                $('[name="' + key + '"]').addClass('is-invalid');
                                $('[name="' + key + '"]').next('.invalid-feedback').text(errors[key][0]);
                            } else {
                                $('#edit_' + key).addClass('is-invalid');
                                $('#edit_' + key).next('.invalid-feedback').text(errors[key][0]);
                            }
                        });
                    } else {
                        showToast('Error updating customer', 'error');
                    }
                }
            });
        }
    });
    
    // Clear form validation on modal close
    $('.modal').on('hidden.bs.modal', function() {
        clearForm('#addCustomerForm');
        clearForm('#editCustomerForm');
        resetContactContainers();
    });
});

function initializePhoneInput(input) {
    // Check if intlTelInput is available
    if (typeof window.intlTelInput === 'undefined') {
        console.warn('IntlTelInput plugin not loaded, using fallback input');
        // Fallback to simple input with country code dropdown
        const fallbackHtml = `
            <div class="row">
                <div class="col-md-3">
                    <select class="form-select country-select">
                        <option value="+1">+1 (US/CA)</option>
                        <option value="+44">+44 (UK)</option>
                        <option value="+33">+33 (FR)</option>
                        <option value="+49">+49 (DE)</option>
                        <option value="+39">+39 (IT)</option>
                        <option value="+81">+81 (JP)</option>
                        <option value="+86">+86 (CN)</option>
                        <option value="+91">+91 (IN)</option>
                    </select>
                </div>
                <div class="col-md-9">
                    <input type="tel" class="form-control" placeholder="Enter phone number">
                </div>
            </div>
        `;
        input.replaceWith(fallbackHtml);
        return;
    }
    
    console.log('Initializing IntlTelInput for:', input[0]);
    
    try {
        const iti = window.intlTelInput(input[0], {
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            separateDialCode: true,
            preferredCountries: ['us', 'ca', 'gb'],
            formatOnDisplay: true,
            autoHideDialCode: false,
            autoPlaceholder: 'polite'
        });
        
        // Store the instance for later use
        input.data('iti', iti);
        
        // Update hidden fields when input changes
        input.on('input', function() {
            const iti = $(this).data('iti');
            if (iti) {
                const countryCode = iti.getSelectedCountryData().dialCode;
                const fullNumber = iti.getNumber();
                
                // Set the full number in the visible input field
                $(this).val(fullNumber);
                
                // Parse the number to get area code and local number
                const phoneNumber = iti.getNumber(intlTelInputUtils.numberType.NATIONAL);
                const parts = phoneNumber.replace(/\s+/g, '').split(/[()-]/).filter(part => part.length > 0);
                
                let areaCode = '';
                let localNumber = '';
                
                if (parts.length >= 2) {
                    areaCode = parts[0];
                    localNumber = parts.slice(1).join('');
                } else if (parts.length === 1) {
                    localNumber = parts[0];
                }
                
                // Update hidden fields
                $(this).siblings('.country-code').val('+' + countryCode);
                $(this).siblings('.area-code').val(areaCode);
                $(this).siblings('.local-number').val(localNumber);
            }
        });
        
        // Also update on country change
        input.on('countrychange', function() {
            const iti = $(this).data('iti');
            if (iti) {
                const fullNumber = iti.getNumber();
                $(this).val(fullNumber);
            }
        });
    } catch (error) {
        console.error('Error initializing IntlTelInput:', error);
        // Fallback to simple input with country code dropdown
        const fallbackHtml = `
            <div class="row">
                <div class="col-md-3">
                    <select class="form-select country-select">
                        <option value="+1">+1 (US/CA)</option>
                        <option value="+44">+44 (UK)</option>
                        <option value="+33">+33 (FR)</option>
                        <option value="+49">+49 (DE)</option>
                        <option value="+39">+39 (IT)</option>
                        <option value="+81">+81 (JP)</option>
                        <option value="+86">+86 (CN)</option>
                        <option value="+91">+91 (IN)</option>
                    </select>
                </div>
                <div class="col-md-9">
                    <input type="tel" class="form-control" placeholder="Enter phone number">
                </div>
            </div>
        `;
        input.replaceWith(fallbackHtml);
    }
}

function initializeAllPhoneInputs() {
    // Initialize all phone inputs
    $('.phone-input').each(function() {
        if (!$(this).data('iti')) {
            initializePhoneInput($(this));
        }
    });
    
    // Initialize all fax inputs
    $('.fax-input').each(function() {
        if (!$(this).data('iti')) {
            initializePhoneInput($(this));
        }
    });
}

function initializeContactFormHandlers() {
    // Add email handlers
    $(document).on('click', '.add-email', function() {
        addEmailRow('#emailContainer');
    });
    
    $(document).on('click', '.add-edit-email', function() {
        addEmailRow('#editEmailContainer');
    });
    
    // Add phone handlers
    $(document).on('click', '.add-phone', function() {
        addPhoneRow('#phoneContainer');
    });
    
    $(document).on('click', '.add-edit-phone', function() {
        addPhoneRow('#editPhoneContainer');
    });
    
    // Add fax handlers
    $(document).on('click', '.add-fax', function() {
        addFaxRow('#faxContainer');
    });
    
    $(document).on('click', '.add-edit-fax', function() {
        addFaxRow('#editFaxContainer');
    });
    
    // Remove row handlers
    $(document).on('click', '.remove-row', function() {
        $(this).closest('.email-row, .phone-row, .fax-row').remove();
    });
    
    // Handle manual country code selection
    $(document).on('change', '.country-select', function() {
        const countryCode = $(this).val();
        const phoneInput = $(this).siblings('.phone-input, .fax-input');
        const currentNumber = phoneInput.val();
        
        // Update the full number with country code
        if (currentNumber) {
            phoneInput.val(countryCode + ' ' + currentNumber);
        }
        
        // Update hidden fields
        $(this).siblings('.country-code').val(countryCode);
    });
    
    // Handle phone/fax input changes
    $(document).on('input', '.phone-input, .fax-input', function() {
        const countrySelect = $(this).siblings('.country-select');
        const countryCode = countrySelect.val();
        const number = $(this).val();
        
        // Update hidden fields
        $(this).siblings('.country-code').val(countryCode);
        
        // Simple parsing for area code and local number
        const cleanNumber = number.replace(/\D/g, '');
        if (cleanNumber.length >= 10) {
            const areaCode = cleanNumber.substring(0, 3);
            const localNumber = cleanNumber.substring(3);
            $(this).siblings('.area-code').val(areaCode);
            $(this).siblings('.local-number').val(localNumber);
        }
    });
}

function addEmailRow(container) {
    const emailCount = $(container + ' .email-row').length;
    const newRow = `
        <div class="email-row mb-2">
            <div class="input-group">
                <input type="email" class="form-control" name="emails[]" placeholder="Enter email address">
                <button type="button" class="btn btn-outline-danger remove-row" title="Remove email">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
    `;
    $(container).append(newRow);
}

function addPhoneRow(container) {
    const phoneCount = $(container + ' .phone-row').length;
    const newRow = `
        <div class="phone-row mb-2">
            <div class="row">
                <div class="col-md-10">
                    <input type="tel" class="form-control phone-input" name="phones[${phoneCount}][full_number]" placeholder="Enter phone number">
                    <input type="hidden" name="phones[${phoneCount}][country_code]" class="country-code">
                    <input type="hidden" name="phones[${phoneCount}][area_code]" class="area-code">
                    <input type="hidden" name="phones[${phoneCount}][local_number]" class="local-number">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-danger remove-row" title="Remove phone">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    $(container).append(newRow);
    
    // Initialize IntlInputPhone for the new phone input
    const newPhoneInput = $(container + ' .phone-row:last-child .phone-input');
    initializePhoneInput(newPhoneInput);
}

function addFaxRow(container) {
    const faxCount = $(container + ' .fax-row').length;
    const newRow = `
        <div class="fax-row mb-2">
            <div class="row">
                <div class="col-md-10">
                    <input type="tel" class="form-control fax-input" name="faxes[${faxCount}][full_number]" placeholder="Enter fax number">
                    <input type="hidden" name="faxes[${faxCount}][country_code]" class="country-code">
                    <input type="hidden" name="faxes[${faxCount}][area_code]" class="area-code">
                    <input type="hidden" name="faxes[${faxCount}][local_number]" class="local-number">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-danger remove-row" title="Remove fax">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
        </div>
    `;
    $(container).append(newRow);
    
    // Initialize IntlInputPhone for the new fax input
    const newFaxInput = $(container + ' .fax-row:last-child .fax-input');
    initializePhoneInput(newFaxInput);
}

function resetContactContainers() {
    // Reset email containers
    $('#emailContainer').html(`
        <div class="email-row mb-2">
            <div class="input-group">
                <input type="email" class="form-control" name="emails[]" placeholder="Enter email address">
                <button type="button" class="btn btn-outline-secondary add-email" title="Add another email">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
    `);
    
    // Reset phone containers
    $('#phoneContainer').html(`
        <div class="phone-row mb-2">
            <div class="row">
                <div class="col-md-10">
                    <input type="tel" class="form-control phone-input" name="phones[0][full_number]" placeholder="Enter phone number">
                    <input type="hidden" name="phones[0][country_code]" class="country-code">
                    <input type="hidden" name="phones[0][area_code]" class="area-code">
                    <input type="hidden" name="phones[0][local_number]" class="local-number">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-secondary add-phone" title="Add another phone">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    `);
    
    // Reset fax containers
    $('#faxContainer').html(`
        <div class="fax-row mb-2">
            <div class="row">
                <div class="col-md-10">
                    <input type="tel" class="form-control fax-input" name="faxes[0][full_number]" placeholder="Enter fax number">
                    <input type="hidden" name="faxes[0][country_code]" class="country-code">
                    <input type="hidden" name="faxes[0][area_code]" class="area-code">
                    <input type="hidden" name="faxes[0][local_number]" class="local-number">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-secondary add-fax" title="Add another fax">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    `);
    
    // Initialize IntlInputPhone for the reset containers
    initializeAllPhoneInputs();
}

function initializeCustomersTable() {
    $('#customersTable').DataTable({
        ajax: {
            url: '/api/customers',
            dataSrc: 'data'
        },
        columns: [
            { data: 'id' },
            { 
                data: null,
                render: function(data) {
                    return data.first_name + ' ' + data.last_name;
                }
            },
            { 
                data: 'contact_infos',
                render: function(data) {
                    if (data && data.length > 0) {
                        const emails = data.filter(contact => contact.type === 'email');
                        return emails.length > 0 ? emails[0].value : 'N/A';
                    }
                    return 'N/A';
                }
            },
            { 
                data: 'contact_infos',
                render: function(data) {
                    if (data && data.length > 0) {
                        const phones = data.filter(contact => contact.type === 'phone');
                        if (phones.length > 0) {
                            return phones.map(phone => 
                                `${phone.country_code} (${phone.area_code}) ${phone.local_number}`
                            ).join('<br>');
                        }
                    }
                    return 'N/A';
                }
            },
            { 
                data: 'mailing_address',
                render: function(data) {
                    if (data) {
                        return data.city + ', ' + data.state_or_province + ', ' + data.country;
                    }
                    return 'N/A';
                }
            },
            {
                data: 'id',
                orderable: false,
                searchable: false,
                render: function(data) {
                    return `
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-sm btn-info" onclick="viewCustomer(${data})" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-primary" onclick="editCustomer(${data})" title="Edit">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteCustomer(${data})" title="Delete">
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

function viewCustomer(id) {
    $.get('/api/customers/' + id, function(data) {
        $('#view_name').text(data.first_name + ' ' + data.last_name);
        
        // Display emails
        const emails = data.contact_infos ? data.contact_infos.filter(contact => contact.type === 'email') : [];
        if (emails.length > 0) {
            $('#view_emails').html(emails.map(email => `<div>${email.value}</div>`).join(''));
        } else {
            $('#view_emails').html('<div class="text-muted">No email addresses</div>');
        }
        
        // Display phones
        const phones = data.contact_infos ? data.contact_infos.filter(contact => contact.type === 'phone') : [];
        if (phones.length > 0) {
            $('#view_phones').html(phones.map(phone => 
                `<div>${phone.country_code} (${phone.area_code}) ${phone.local_number}</div>`
            ).join(''));
        } else {
            $('#view_phones').html('<div class="text-muted">No phone numbers</div>');
        }
        
        // Display faxes
        const faxes = data.contact_infos ? data.contact_infos.filter(contact => contact.type === 'fax') : [];
        if (faxes.length > 0) {
            $('#view_faxes').html(faxes.map(fax => 
                `<div>${fax.country_code} (${fax.area_code}) ${fax.local_number}</div>`
            ).join(''));
        } else {
            $('#view_faxes').html('<div class="text-muted">No fax numbers</div>');
        }
        
        if (data.mailing_address) {
            $('#view_street').text(data.mailing_address.street);
            $('#view_city').text(data.mailing_address.city);
            $('#view_state').text(data.mailing_address.state_or_province);
            $('#view_postal_code').text(data.mailing_address.postal_code);
            $('#view_country').text(data.mailing_address.country);
        } else {
            $('#view_street').text('N/A');
            $('#view_city').text('N/A');
            $('#view_state').text('N/A');
            $('#view_postal_code').text('N/A');
            $('#view_country').text('N/A');
        }
        
        $('#view_created').text(new Date(data.created_at).toLocaleString());
        $('#view_updated').text(new Date(data.updated_at).toLocaleString());
        $('#viewCustomerModal').modal('show');
    });
}

function editCustomer(id) {
    $.get('/api/customers/' + id, function(data) {
        $('#edit_id').val(data.id);
        $('#edit_first_name').val(data.first_name);
        $('#edit_last_name').val(data.last_name);
        
        // Populate emails
        const emails = data.contact_infos ? data.contact_infos.filter(contact => contact.type === 'email') : [];
        $('#editEmailContainer').empty();
        if (emails.length > 0) {
            emails.forEach((email, index) => {
                const emailRow = `
                    <div class="email-row mb-2">
                        <div class="input-group">
                            <input type="email" class="form-control" name="emails[]" value="${email.value}" placeholder="Enter email address">
                            ${index === 0 ? '<button type="button" class="btn btn-outline-secondary add-edit-email" title="Add another email"><i class="fas fa-plus"></i></button>' : '<button type="button" class="btn btn-outline-danger remove-row" title="Remove email"><i class="fas fa-minus"></i></button>'}
                        </div>
                    </div>
                `;
                $('#editEmailContainer').append(emailRow);
            });
        } else {
            addEmailRow('#editEmailContainer');
        }
        
        // Populate phones
        const phones = data.contact_infos ? data.contact_infos.filter(contact => contact.type === 'phone') : [];
        $('#editPhoneContainer').empty();
        if (phones.length > 0) {
            phones.forEach((phone, index) => {
                const fullNumber = phone.country_code + phone.area_code + phone.local_number;
                const phoneRow = `
                    <div class="phone-row mb-2">
                        <div class="row">
                            <div class="col-md-10">
                                <input type="tel" class="form-control phone-input" name="phones[${index}][full_number]" value="${fullNumber}" placeholder="Enter phone number">
                                <input type="hidden" name="phones[${index}][country_code]" class="country-code" value="${phone.country_code}">
                                <input type="hidden" name="phones[${index}][area_code]" class="area-code" value="${phone.area_code}">
                                <input type="hidden" name="phones[${index}][local_number]" class="local-number" value="${phone.local_number}">
                            </div>
                            <div class="col-md-2">
                                ${index === 0 ? '<button type="button" class="btn btn-outline-secondary add-edit-phone" title="Add another phone"><i class="fas fa-plus"></i></button>' : '<button type="button" class="btn btn-outline-danger remove-row" title="Remove phone"><i class="fas fa-minus"></i></button>'}
                            </div>
                        </div>
                    </div>
                `;
                $('#editPhoneContainer').append(phoneRow);
            });
        } else {
            addPhoneRow('#editPhoneContainer');
        }
        
        // Populate faxes
        const faxes = data.contact_infos ? data.contact_infos.filter(contact => contact.type === 'fax') : [];
        $('#editFaxContainer').empty();
        if (faxes.length > 0) {
            faxes.forEach((fax, index) => {
                const fullNumber = fax.country_code + fax.area_code + fax.local_number;
                const faxRow = `
                    <div class="fax-row mb-2">
                        <div class="row">
                            <div class="col-md-10">
                                <input type="tel" class="form-control fax-input" name="faxes[${index}][full_number]" value="${fullNumber}" placeholder="Enter fax number">
                                <input type="hidden" name="faxes[${index}][country_code]" class="country-code" value="${fax.country_code}">
                                <input type="hidden" name="faxes[${index}][area_code]" class="area-code" value="${fax.area_code}">
                                <input type="hidden" name="faxes[${index}][local_number]" class="local-number" value="${fax.local_number}">
                            </div>
                            <div class="col-md-2">
                                ${index === 0 ? '<button type="button" class="btn btn-outline-secondary add-edit-fax" title="Add another fax"><i class="fas fa-plus"></i></button>' : '<button type="button" class="btn btn-outline-danger remove-row" title="Remove fax"><i class="fas fa-minus"></i></button>'}
                            </div>
                        </div>
                    </div>
                `;
                $('#editFaxContainer').append(faxRow);
            });
        } else {
            addFaxRow('#editFaxContainer');
        }
        
        if (data.mailing_address) {
            $('#edit_street').val(data.mailing_address.street);
            $('#edit_city').val(data.mailing_address.city);
            $('#edit_state').val(data.mailing_address.state_or_province);
            $('#edit_postal_code').val(data.mailing_address.postal_code);
            $('#edit_country').val(data.mailing_address.country);
        }
        
        // Initialize phone inputs after populating the form
        setTimeout(() => {
            initializeAllPhoneInputs();
        }, 100);
        
        $('#editCustomerModal').modal('show');
    });
}

function deleteCustomer(id) {
    confirmDelete('/api/customers/' + id, '#customersTable');
}
</script>
@endsection 