<?php 
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
      }

?>

<div class="full-screen-form-container">
    <form id="createPromotionForm" action="/promotion/store" method="POST">
        <!-- Promotion Name -->
        <div class="promotion">
            <label for="promotionName" class="form-label">Promotion Name</label>
            <input type="text" class="form-control" id="promotionName" name="promotion_name" placeholder="Enter promotion name" required>
        </div>

        <!-- Description -->
        <div class="promotion">
            <label for="promotionDescription" class="form-label">Description</label>
            <textarea class="form-control" id="promotionDescription" name="promotion_description" rows="3" placeholder="Enter promotion description" required></textarea>
        </div>

        <!-- Promotion Code -->
        <div class="promotion">
            <label for="promotionCode" class="form-label">Promotion Code</label>
            <input type="text" class="form-control" id="promotionCode" name="promotion_code" placeholder="Enter promotion code" required>
        </div>

        <!-- Date Range -->
        <div class="date promotion">
            <div class="start-date">
                <label for="startDate" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="startDate" name="start_date" required>
            </div>
            <div class="end-date">
                <label for="endDate" class="form-label">End Date</label>
                <input type="date" class="form-control" id="endDate" name="end_date" required>
            </div>
        </div>

        <!-- Status -->
        <div class="promotion">
            <label for="status" class="form-label" id="statuss">Status</label>
            <select class="form-select-promotion" id="status" name="status" required>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
                <option value="completed">Completed</option>
            </select>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary" id="addpromotions">Save Promotion</button>
    </form>
</div>

