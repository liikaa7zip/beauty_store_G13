<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="promotion-form-wrapper">
    <h1>Edit Promotions</h1>
    <form id="createPromotionForm" action="/promotion/update/<?= $promotion['id'] ?>" method="POST">
        <div class="form-group-promo">
            <label for="promotionName" class="label-promo">Promotion Title</label>
            <input type="text" class="input-promo" value="<?= htmlspecialchars($promotion['promotion_name']) ?>" id="promotionName" name="promotion_name" placeholder="Enter promotion name" required>
        </div>

        <div class="form-group-promo">
            <label for="promotionDescription" class="label-promo">Promotion Description</label>
            <textarea class="textarea-promo" id="promotionDescription" name="promotion_description" rows="3" placeholder="Enter promotion description" required><?= htmlspecialchars($promotion['promotion_description']) ?></textarea>
        </div>

        <div class="form-group-promo">
            <label for="discountPercentage" class="label-promo">Discount Percentage</label>
            <input type="number" class="input-promo" value="<?= htmlspecialchars($promotion['discount_percentage']) ?>" id="discountPercentage" name="discount_percentage" placeholder="Enter the discount percentage" required>
            <div class="feedback-promo">Please provide the discount percentage.</div>
        </div>

        <div class="form-group-promo">
            <label for="promotionCode" class="label-promo">Discount Code</label>
            <input type="text" class="input-promo" value="<?= htmlspecialchars($promotion['promotion_code']) ?>" id="promotionCode" name="promotion_code" placeholder="Enter promotion code" required>
        </div>

        <div class="form-dates-promo">
            <div class="date-group-promo">
                <label for="startDate" class="label-promo">Start Date</label>
                <input type="text" class="input-promo datepicker" value="<?= htmlspecialchars($promotion['start_date']) ?>" id="startDate" name="start_date" placeholder="Select start date" required>
            </div>
            <div class="date-group-promo">
                <label for="endDate" class="label-promo">End Date</label>
                <input type="text" class="input-promo datepicker" id="endDate" value="<?= htmlspecialchars($promotion['end_date']) ?>" name="end_date" placeholder="Select end date" required>
            </div>
        </div>

        <div class="form-group-promo">
            <label for="validationCustom04" class="label-promo">Promotion Status</label>
            <select class="select-promo" id="validationCustom04" name="status" required>
                <option value="active" <?= ($promotion['status'] == 'active') ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= ($promotion['status'] == 'inactive') ? 'selected' : '' ?>>Inactive</option>
                <option value="completed" <?= ($promotion['status'] == 'completed') ? 'selected' : '' ?>>Completed</option>
            </select>
        </div>

        <div class="form-buttons-promo">
            <button type="submit" class="btn-submit-promo">Update Promotion</button>
            <a href="/promotion" class="btn-cancel-promo">Cancel</a>
        </div>
    </form>
</div>


<script>
    $(document).ready(function() {
        $('#startDate').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });

        $('#endDate').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });

        $('#createPromotionForm').on('submit', function(event) {
            if (!this.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            $(this).addClass('was-validated');
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
