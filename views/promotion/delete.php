<div class="modal fade" id="promotion<?= $promotion['id'] ?>" tabindex="-1" aria-labelledby="deletePromotionModalLabel<?= $promotion['id'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold d-flex align-items-center g-2" id="deletePromotionModalLabel<?= $promotion['id'] ?>">
                    <span class="material-symbols-outlined text-danger me-2">warning</span>
                    Delete Promotion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <p class="lead mb-3">
                    Are you sure you want to delete the promotion
                    <strong>"<?= htmlspecialchars($promotion['promotion_name']); ?>"</strong>?
                </p>
                <p class="text-muted mb-0">
                    This action cannot be undone. All data related to this promotion will be permanently deleted.
                </p>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer d-flex justify-content-center">
                <form action="/promotion/delete/<?= $promotion['id'] ?>" method="POST" class="w-100">
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="/promotion/delete/<?= $promotion['id']; ?>" method="post">
                            <button type="submit" class="btn btn-danger d-flex align-items-center gap-2 justify-content-center">
                                <span class="material-symbols-outlined">delete</span>
                                Delete
                            </button>
                        </form>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>