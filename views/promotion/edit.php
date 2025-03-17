<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="full-screen-form-container">
    <form id="createPromotionForm" action="/promotion/update/<?= $promotion['id'] ?>" method="POST">
        <div class="promotion">
            <label for="promotionName" class="form-label">Promotion Title</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($promotion['promotion_name']) ?>" id="promotionName" name="promotion_name" placeholder="Enter promotion name" required>
        </div>

        <div class="promotion">
            <label for="promotionDescription" class="form-label">Promotion Description</label>
            <textarea class="form-control m-0" id="promotionDescription" name="promotion_description" rows="3" placeholder="Enter promotion description" required><?= htmlspecialchars($promotion['promotion_description']) ?> </textarea>
        </div>

        <div class="promotion">
            <label for="promotionCode" class="form-label">Discount Code</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($promotion['promotion_code']) ?>" id="promotionCode" name="promotion_code" placeholder="Enter promotion code" required>
        </div>

        <div class="date promotion">
            <div class="start-date">
                <label for="startDate" class="form-label">Start Date</label>
                <input type="text" class="form-control datepicker " value="<?= htmlspecialchars($promotion['start_date']) ?>" id="startDate" name="start_date" placeholder="Select start date" required>
            </div>
            <div class="end-date">
                <label for="endDate" class="form-label">End Date</label>
                <input type="text" class="form-control datepicker" id="endDate" value="<?= htmlspecialchars($promotion['end_date']) ?>" name="end_date" placeholder="Select end date" required>
            </div>
        </div>

        <div class="promotion">
            <label for="validationCustom04" class="form-label">Promotion Status</label>
            <select class="form-select-promotion p-lg-18" id="validationCustom04" name="status" required>
                <option value="active" <?= ($promotion['status'] == 'active') ? 'selected' : '' ?>>Active</option>
                <option value="inactive" <?= ($promotion['status'] == 'inactive') ? 'selected' : '' ?>>Inactive</option>
                <option value="completed" <?= ($promotion['status'] == 'completed') ? 'selected' : '' ?>>Completed</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Promotion</button>
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
