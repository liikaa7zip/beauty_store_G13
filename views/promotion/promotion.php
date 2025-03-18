<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: /users/signIn");
    exit();
}
?>

<div class="header">
    <h1>Promotions</h1>
    <div class="search-container">
        <div class="search-bar">
            <div class="search-input">
                <input type="text" id="searchInput" placeholder="Search promotions...">
                <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
            </div>
        </div>

        <a href="/promotion/create" class="btn btn-primary" id="addNewButton">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M5 12h14" />
                <path d="M12 5v14" />
            </svg>
            Add New
        </a>
    </div>

    <?php if (empty($promotions)): ?>
        <div class="alert alert-info mt-5" role="alert">
            No promotions available at the moment. Please create promotions!
        </div>
    <?php else: ?>
    <?php endif; ?>
</div>
<div class="promotion-container grid">
    <?php foreach ($promotions as $promotion): ?>
        <div class="promotion-card">
            <div class="promotion-header"><?= htmlspecialchars($promotion['promotion_name']) ?></div>
            <div class="promotion-details">
                <p class="promotion-code d-flex flex-row align-items-center gap-2 mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                        <line x1="16" x2="16" y1="2" y2="6" />
                        <line x1="8" x2="8" y1="2" y2="6" />
                        <line x1="3" x2="21" y1="10" y2="10" />
                    </svg>
                    <strong>Date:</strong>
                    <?php
                    $startDate = new DateTime($promotion['start_date']);
                    $endDate = new DateTime($promotion['end_date']);

                    $formattedStartDate = $startDate->format('d-F');
                    $formattedEndDate = $endDate->format('d-F-Y');

                    echo htmlspecialchars($formattedStartDate) . ' to ' . htmlspecialchars($formattedEndDate);
                    ?>
                </p>
                <p class="promotion-description d-flex flex-row align-items-center gap-2 mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                        <polyline points="14 2 14 8 20 8" />
                    </svg>
                    <strong>Description:</strong>
                    <?= htmlspecialchars($promotion['promotion_description']) ?>
                </p>
                <p class="promotion-code d-flex flex-row align-items-center gap-2 mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z" />
                        <line x1="7" y1="7" x2="7.01" y2="7" />
                    </svg>
                    <strong>Code:</strong>
                    <span style="color: #ff69b4; font-weight: bold;"><?= htmlspecialchars($promotion['promotion_code']) ?></span>
                </p>
                <span class="promotion-status fw-bold text-white
                    <?= $promotion['status'] === 'completed' ? 'bg-warning' : ($promotion['status'] === 'active' ? 'bg-info' : 'bg-danger') ?>">
                    <?= htmlspecialchars($promotion['status']) ?>
                </span>
            </div>

            <div class="more-options">
                <button class="more-button" onclick="toggleDropdown(this)">&#x22EE;</button>
                <div class="dropdown-menu">
                    <a href="/promotion/edit/<?= $promotion['id'] ?>" class="edit-button d-flex flex-row align-items-center gap-2 fw-bold">
                        <span class="material-symbols-outlined" id="edit">edit</span> Edit
                    </a>
                    <a href="/promotion/delete/<?= $promotion['id'] ?>" class="delete-button d-flex flex-row align-items-center gap-2 fw-bold" data-bs-toggle="modal" data-bs-target="#promotion<?= $promotion['id'] ?>">
                        <span class="material-symbols-outlined" id="delete">delete</span> Delete
                    </a>
                </div>
            </div>
        </div>
        <?php require_once 'views/promotion/delete.php'; ?>
    <?php endforeach; ?>
</div>

<script>
    function toggleDropdown(button) {
        var dropdown = button.nextElementSibling;
        dropdown.style.display = "block";

        document.addEventListener("click", function(event) {
            if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.style.display = "none";
            }
        });
    };

    document.getElementById('searchInput').addEventListener('input', function() {
        const searchQuery = this.value.toLowerCase();
        const promotionCards = document.querySelectorAll('.promotion-card');
        const clearButton = document.getElementById('clearSearchButton');

        promotionCards.forEach(card => {
            const promotionName = card.querySelector('.promotion-header').textContent.toLowerCase();
            const promotionDescription = card.querySelector('.promotion-description').textContent.toLowerCase();
            const promotionCode = card.querySelector('.promotion-code').textContent.toLowerCase();

            if (promotionName.includes(searchQuery) || promotionDescription.includes(searchQuery) || promotionCode.includes(searchQuery)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });

        if (searchQuery.trim() !== '') {
            clearButton.style.display = 'block';
        } else {
            clearButton.style.display = 'none';
        }
    });
</script>
