<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header("Location: /users/signIn");
    exit();
}
?>

<div class="header m-0 p-0">
    <h1>Promotions</h1>
    <div class="search-container m-0 pb-4">
        <div class="search-bar d-flex justify-content-between align-items-center gap-2">
            <div class="search-input w-100 d-flex align-items-center gap-2">
                <input type="text" class="form-control p-2" id="searchInput" placeholder="Search promotions...">
            </div>
            <a href="/promotion/create" class="btn text-nowrap d-flex align-items-center p-2" id="addPromotionButton">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14" />
                    <path d="M12 5v14" />
                </svg>
                Add New
            </a>
        </div>
    </div>

    <?php if (empty($promotions)): ?>
        <div class="alert alert-info mt-5" role="alert">
            No promotions available at the moment. Please create promotions!
        </div>
    <?php else: ?>
    <?php endif; ?>
</div>
<div class="promotion-container m-0 p-0">
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
                    <span style="color: #ff69b4; font-weight: bold;"><?php
                                                                        $startDate = new DateTime($promotion['start_date']);
                                                                        $endDate = new DateTime($promotion['end_date']);

                                                                        $formattedStartDate = $startDate->format('d-F');
                                                                        $formattedEndDate = $endDate->format('d-F-Y');

                                                                        echo htmlspecialchars($formattedStartDate) . ' to ' . htmlspecialchars($formattedEndDate);
                                                                        ?></span>
                </p>
                <p class="promotion-description d-flex flex-row align-items-center gap-2 mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                        <polyline points="14 2 14 8 20 8" />
                    </svg>
                    <strong>Description:</strong>
                    <span style="color: #ff69b4; font-weight: bold;"><?= htmlspecialchars($promotion['promotion_description']) ?></span>
                </p>
                <p class="promotion-discount d-flex flex-row align-items-center gap-2 mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z" />
                        <line x1="7" y1="7" x2="7.01" y2="7" />
                    </svg>
                    <strong>Discount:</strong>
                    <span style="color: #ff69b4; font-weight: bold;"><?= htmlspecialchars($promotion['discount_percentage']) . '%' ?></span>
                </p>
                <p class="promotion-code d-flex flex-row align-items-center gap-2 mb-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 12V21H4V12M22 12H2M12 2V12M12 2L9 5M12 2L15 5M2 12V3H22V12" />
                    </svg>
                    <strong>Code:</strong>
                    <span style="color: #ff69b4; font-weight: bold;"><?= htmlspecialchars($promotion['promotion_code']) ?></span>
                </p>
                <div class="promotion-footer d-flex flex-row align-items-center gap-2">
                    <span class="promotion-status fw-bold text-white
                        <?= $promotion['status'] === 'completed' ? 'bg-warning' : ($promotion['status'] === 'active' ? 'bg-info' : 'bg-danger') ?>">
                        <?= htmlspecialchars($promotion['status']) ?>
                    </span>
                    <button class="promotion-status fw-bold bg-info border-0" data-bs-toggle="modal" data-bs-target="#confirmModal<?= $promotion['id'] ?>">
                        <i class="fa-brands fa-telegram"></i> Send Promotion
                    </button>
                </div>
            </div>

            <div class="more-options-pro">
                <button class="more-button-pro" >&#x22EE;</button>
                <div class="dropdown-menu-pro">
                    <a href="/promotion/edit/<?= $promotion['id'] ?>" class="edit-button d-flex flex-row align-items-center gap-2 fw-bold">
                        <span class="material-symbols-outlined" id="edit" style="color:pink;">edit</span> Edit
                    </a>
                    <a href="/promotion/delete/<?= $promotion['id'] ?>" class="delete-button d-flex flex-row align-items-center gap-2 fw-bold" data-bs-toggle="modal" data-bs-target="#promotion<?= $promotion['id'] ?>">
                        <span class="material-symbols-outlined" id="delete" style="color:red;">delete</span> Delete
                    </a>
                </div>
            </div>
        </div>
        <div class="modal fade" id="confirmModal<?= $promotion['id'] ?>" tabindex="-1" aria-labelledby="confirmModalLabel<?= $promotion['id'] ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel<?= $promotion['id'] ?>">Confirm Sending Promotion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to send the promotion <strong><?= htmlspecialchars($promotion['promotion_name']) ?></strong> to the customer?
                    </div>
                    <div class="modal-footer">
                        <div class="button d-flex flex-row align-items-center justify-content-between gap-2">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn" style="background: #ff4081; color: white;" data-promotion-id="<?= $promotion['id'] ?>" onclick="sendPromotion(this, event)">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php require 'delete.php'; ?>
    <?php endforeach; ?>
</div>

<script>

document.addEventListener("DOMContentLoaded", function () {
        const cateDropdowns = document.querySelectorAll('.more-options-pro');

        cateDropdowns.forEach(function (dropdown) {
            const toggle = dropdown.querySelector('.more-button-pro');
            const menu = dropdown.querySelector('.dropdown-menu-pro');

            toggle.addEventListener('click', function (e) {
                e.stopPropagation();

                // Close all others
                document.querySelectorAll('.dropdown-menu-pro').forEach(m => {
                    if (m !== menu) m.style.display = 'none';
                });

                // Toggle current
                menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
            });

            document.addEventListener('click', function () {
                menu.style.display = 'none';
            });
        });
    });

    
    function sendPromotion(button, event) {
        event.preventDefault();
        var promotionId = button.getAttribute('data-promotion-id');
        var modal = button.closest('.modal');
        var modalInstance = bootstrap.Modal.getInstance(modal);

        fetch('/promotion/send/' + promotionId, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                button.innerHTML = "Sent";
                button.disabled = true;

                if (data.success) {
                    showAlert(modal, 'Success', data.message, 'success');
                } else {
                    showAlert(modal, 'Error', data.message, 'danger');
                }

                setTimeout(function() {
                    modalInstance.hide();
                }, 2000);
            })
            .catch(error => {
                console.error('Error:', error);
                button.innerHTML = "Sent";
                button.disabled = true;
                showAlert(modal, 'Success', 'The Promotion was sent successfully', 'success');
            });
    }

    function showAlert(modal, title, message, type) {
        var alertContainer = modal.querySelector('.alert-container');
        if (!alertContainer) {
            alertContainer = document.createElement('div');
            alertContainer.classList.add('alert-container');
            modal.querySelector('.modal-body').appendChild(alertContainer);
        }

        alertContainer.innerHTML = '';
        const alertDiv = document.createElement('div');
        alertDiv.classList.add('alert', `alert-${type}`, 'mt-2');
        alertDiv.innerHTML = `<strong>${title}:</strong> ${message}`;
        alertContainer.appendChild(alertDiv);
    }

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