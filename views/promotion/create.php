<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>

<div class="full-screen-form-container">
    <form id="createPromotionForm" action="/promotion/store" method="POST">
        <!-- Promotion Name -->
        <div class="promotion">
            <label for="promotionName" class="form-label">Promotion Title</label>
            <input type="text" class="form-control" id="promotionName" name="promotion_name" placeholder="Enter the promotion title" required>
            <div class="invalid-feedback">Promotion title is required.</div>
        </div>

        <!-- Description -->
        <div class="promotion">
            <label for="promotionDescription" class="form-label">Promotion Description</label>
            <textarea class="form-control m-0" id="promotionDescription" name="promotion_description" rows="3" placeholder="Provide a brief description of the promotion" required></textarea>
            <div class="invalid-feedback">Please provide a promotion description.</div>
        </div>

        <!-- Promotion Code -->
        <div class="promotion">
            <label for="promotionCode" class="form-label">Discount Code</label>
            <input type="text" class="form-control" id="promotionCode" name="promotion_code" placeholder="Enter a unique discount code" required>
            <div class="invalid-feedback">Discount code is required.</div>
        </div>

        <!-- Date Range -->
        <div class="date promotion">
            <div class="start-date">
                <label for="startDate" class="form-label">Promotion Start Date</label>
                <input type="text" class="form-control datepicker " id="startDate" name="start_date" placeholder="Select the start date" required>
                <div class="invalid-feedback">Please select a valid start date.</div>
            </div>
            <div class="end-date">
                <label for="endDate" class="form-label">Promotion End Date</label>
                <input type="text" class="form-control datepicker" id="endDate" name="end_date" placeholder="Select the end date" required>
                <div class="invalid-feedback">End date must be after the start date.</div>
            </div>
        </div>
        <div class="col-md-12">
            <label for="validationCustom04" class="form-label " id="statuss">Promotion Status</label>
            <select class="form-select-promotion p-lg-18" id="validationCustom04" required>
                <option selected disabled value="">Select the promotion status...</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="completed">Completed</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary" id="addpromotions">Create Promotion</button>
    </form>
</div>
<script>
    $(document).ready(function() {
    // Initialize datepicker for start and end dates
    $('#startDate').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
        startDate: new Date()
    }).on('changeDate', function(selected) {
        var minEndDate = new Date(selected.date);
        minEndDate.setDate(minEndDate.getDate() + 1);
        $('#endDate').datepicker('setStartDate', minEndDate);

        // Remove error if a valid date is selected
        validateField($('#startDate'));
    });

    $('#endDate').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
        startDate: new Date()
    }).on('changeDate', function() {
        validateField($('#endDate'));
    });

    // Function to show or hide error messages
    function validateField(field) {
        if (!field.val()) {
            field.addClass('is-invalid');
            field.siblings('.invalid-feedback').show();
        } else {
            field.removeClass('is-invalid').addClass('is-valid');
            field.siblings('.invalid-feedback').hide();
        }
    }

    // Validate fields on blur (when the user moves away)
    $('#promotionName, #promotionDescription, #promotionCode, #startDate, #endDate, #validationCustom04').on('blur', function() {
        validateField($(this));
    });

    // Form validation on submit
    $('#createPromotionForm').on('submit', function(event) {
        let valid = true;

        // Validate all required fields
        $('#promotionName, #promotionDescription, #promotionCode, #startDate, #endDate, #validationCustom04').each(function() {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                $(this).siblings('.invalid-feedback').show();
                valid = false;
            } else {
                $(this).removeClass('is-invalid').addClass('is-valid');
                $(this).siblings('.invalid-feedback').hide();
            }
        });

        // Validate end date must be after start date
        if ($('#endDate').val() && $('#endDate').val() <= $('#startDate').val()) {
            $('#endDate').addClass('is-invalid');
            $('#endDate').siblings('.invalid-feedback').text('End date must be after the start date.').show();
            valid = false;
        }

        if (!valid) {
            event.preventDefault();
            event.stopPropagation();
        }

        $(this).addClass('was-validated');
    });

    // Hide error messages when user starts typing/selecting
    $('#promotionName, #promotionDescription, #promotionCode, #validationCustom04').on('input change', function() {
        validateField($(this));
    });
});


</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">