<div class="header">
    <h1>Promotions</h1>
    <div class="search-bar">
        <div class="search-input">
            <input type="text" id="searchInput" placeholder="Search promotions...">
            <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8" />
                <path d="m21 21-4.3-4.3" />
            </svg>
        </div>
        <!-- Add New Button -->
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#promotionModal">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14" />
                <path d="M12 5v14" />
            </svg>
            Add New
        </button>

        <!-- Create Promotion Modal -->
        <?php require "create.php" ?>
    </div>
</div>

<!-- Mobile Cards -->
<div class="mobile-cards">
    <?php foreach ($promotions as $promotion): ?>
        <div class="card">
            <div class="card-header1">
                <h2><?= htmlspecialchars($promotion['promotion_name']) ?></h2>
                <span class="badge 
                        <?php
                        if ($promotion['status'] === 'completed') {
                            echo 'bg-warning';
                        } elseif ($promotion['status'] === 'active') {
                            echo 'bg-info';
                        } elseif ($promotion['status'] === 'inactive') {
                            echo 'bg-danger';
                        }
                        ?>
                            ">
                    <?= htmlspecialchars($promotion['status']) ?>
                </span>
            </div>
            <div class="card-content">
                <div class="info-row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                        <line x1="16" x2="16" y1="2" y2="6" />
                        <line x1="8" x2="8" y1="2" y2="6" />
                        <line x1="3" x2="21" y1="10" y2="10" />
                    </svg>
                    <span><?= htmlspecialchars($promotion['start_date'], ENT_QUOTES, 'UTF-8') ?> - <?= htmlspecialchars($promotion['end_date'], ENT_QUOTES, 'UTF-8') ?></span>
                </div>
                <div class="info-row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z" />
                        <line x1="7" y1="7" x2="7.01" y2="7" />
                    </svg>
                    <span><?= htmlspecialchars($promotion['promotion_code']) ?></span>
                </div>
                <div class="info-row">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                        <polyline points="14 2 14 8 20 8" />
                    </svg>
                    <span><?= htmlspecialchars($promotion['promotion_description']) ?></span>
                </div>
            </div>
            <div class="card-actions">
                <a href="#" aria-label="Edit Promotion" class="action-button edit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                    </svg>
                </a>
                <button type="button" class="action-button delete" data-bs-toggle="modal" data-bs-target="#promotion1<?= $promotion['id'] ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 6h18" />
                        <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                        <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                    </svg>
                </button>
            </div>
            <div class="modal fade" id="promotion1<?= $promotion['id'] ?>" tabindex="-1" aria-labelledby="deletePromotionModalLabel<?= $promotion['id'] ?>" aria-hidden="true">
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
                            <form action="/promotion/delete?id=<?= $promotion['id'] ?>" method="POST" class="w-100">
                                <div class="d-flex gap-2">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger d-flex align-items-center gap-2 justify-content-center">
                                        <span class="material-symbols-outlined">delete</span>
                                        Delete
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php endforeach; ?>
</div>

<!-- Desktop Table -->
<div class="desktop-table">
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Promotion</th>
                <th>Description</th>
                <th>Code</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($promotions as $promotion): ?>
                <tr>
                    <td><?= htmlspecialchars($promotion['start_date'], ENT_QUOTES, 'UTF-8') ?> - <?= htmlspecialchars($promotion['end_date'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($promotion['promotion_name']) ?></td>
                    <td><?= htmlspecialchars($promotion['promotion_description']) ?></td>
                    <td><?= htmlspecialchars($promotion['promotion_code']) ?></td>
                    <td>
                        <span class="badge 
                        <?php
                        if ($promotion['status'] === 'completed') {
                            echo 'bg-warning';
                        } elseif ($promotion['status'] === 'active') {
                            echo 'bg-info';
                        } elseif ($promotion['status'] === 'inactive') {
                            echo 'bg-danger';
                        }
                        ?>
                            ">
                            <?= htmlspecialchars($promotion['status']) ?>
                        </span>
                    </td>
                    <td>
                        <div class="table-actions">
                            <a href="#" aria-label="Edit Promotion" class="action-button edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                                </svg>
                            </a>
                            <button type="button" class="action-button delete" data-bs-toggle="modal" data-bs-target="#promotion<?= $promotion['id'] ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 6h18" />
                                    <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                    <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                </svg>
                            </button>
                        </div>
                    </td>
                    <?php require "delete.php" ?>
                </tr>

            <?php endforeach; ?>
        </tbody>
    </table>
</div>