<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="full-screen-form-container">
    
    <form id="createPromotionForm" action="/promotion/store" method="POST">
    <h1>Create promotions</h1>
        <div class="promotion">
            <label for="promotionName" class="form-label">Promotion Title</label>
            <input type="text" class="form-control" id="promotionName" name="promotion_name" placeholder="Enter the promotion title" required>
            <div class="invalid-feedback">Promotion title is required.</div>
        </div>



        <div class="promotion">
            <label for="promotionDescription" class="form-label">Discount Percentage</label>
            <input type="number" class="form-control" id="discountPercentage" name="discount_percentage" placeholder="Enter the discount percentage" required>
            <div class="invalid-feedback">Please provide the discount percentage.</div>
        </div>

        <div class="promotion">
            <label for="promotionCode" class="form-label">Discount Code</label>
            <input type="text" class="form-control" id="promotionCode" name="promotion_code" placeholder="Enter a unique discount code" required>
            <div class="invalid-feedback">Discount code is required.</div>
        </div>

        <div class="date promotion">
            <div class="start-date">
                <label for="startDate" class="form-label">Start Date</label>
                <input type="text" class="form-control datepicker" id="startDate" name="start_date" placeholder="Select the start date" required>
                <div class="invalid-feedback">Please select a valid start date.</div>
            </div>
            <div class="end-date">
                <label for="endDate" class="form-label">End Date</label>
                <input type="text" class="form-control datepicker" id="endDate" name="end_date" placeholder="Select the end date" required>
                <div class="invalid-feedback">End date must be after the start date.</div>
            </div>
        </div>

        <div class="promotion">
            <label for="validationCustom04" class="form-label">Promotion Status</label>
            <select class="form-select-promotion p-lg-18" id="validationCustom04" name="status" required>
                <option selected disabled value="">Select the promotion status...</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="completed">Completed</option>
            </select>
        </div>

        <div class="button-group">
            <button type="submit" class="btn btn-primary-pro">Create Promotion</button>
            <a href="/promotion" class="btn btn-cancel-pro">Cancel</a>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
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

        function validateField(field) {
            if (!field.val()) {
                field.addClass('is-invalid');
                field.siblings('.invalid-feedback').show();
            } else {
                field.removeClass('is-invalid').addClass('is-valid');
                field.siblings('.invalid-feedback').hide();
            }
        }

        $('#promotionName, #promotionDescription, #promotionCode, #startDate, #endDate, #validationCustom04').on('blur', function() {
            validateField($(this));
        });

        $('#createPromotionForm').on('submit', function(event) {
            let valid = true;

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

        $('#promotionName, #promotionDescription, #promotionCode, #validationCustom04').on('input change', function() {
            validateField($(this));
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
