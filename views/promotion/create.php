<div class="modal fade" id="promotionModal" tabindex="-1" aria-labelledby="promotionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold d-flex align-items-center gap-2" id="promotionModalLabel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14" />
                        <path d="M12 5v14" />
                    </svg>
                    Add New Promotion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <form id="createPromotionForm" action="/promotion/store" method="POST">
                    <!-- Promotion Name -->
                    <div class="mb-3">
                        <label for="promotionName" class="form-label fw-bold">Promotion Name</label>
                        <input type="text" class="form-control" id="promotionName" name="promotion_name" placeholder="Enter promotion name" required>
                    </div>

                    <!-- Description -->
                    <div class="mb-3">
                        <label for="promotionDescription" class="form-label fw-bold">Description</label>
                        <textarea class="form-control" id="promotionDescription" name="promotion_description" rows="3" placeholder="Enter promotion description" required></textarea>
                    </div>

                    <!-- Promotion Code -->
                    <div class="mb-3">
                        <label for="promotionCode" class="form-label fw-bold">Promotion Code</label>
                        <input type="text" class="form-control" id="promotionCode" name="promotion_code" placeholder="Enter promotion code" required>
                    </div>

                    <!-- Date Range -->
                    <div class="row mb-3">
                        <div class="col">
                            <label for="startDate" class="form-label fw-bold">Start Date</label>
                            <input type="date" class="form-control" id="startDate" name="start_date" required>
                        </div>
                        <div class="col">
                            <label for="endDate" class="form-label fw-bold">End Date</label>
                            <input type="date" class="form-control" id="endDate" name="end_date" required>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                        <label for="status" class="form-label fw-bold">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                </form>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="createPromotionForm" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                        <path d="M17 21v-8H7v8" />
                        <path d="M7 3v5h8" />
                    </svg>
                    Save Promotion
                </button>
            </div>
        </div>
    </div>
</div>
