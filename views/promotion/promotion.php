<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect if not logged in
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

    <!-- Add New Button -->
    <a href="/promotion/create" class="btn btn-primary" id="addNewButton">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M5 12h14" />
            <path d="M12 5v14" />
        </svg>
        Add New
    </a>
</div>




    
</div>

<div class="promotion-container">
    <?php foreach ($promotions as $promotion): ?>
        <div class="promotion-card">
            <div class="promotion-header"><?= htmlspecialchars($promotion['promotion_name']) ?></div>
            <div class="promotion-details">
                <strong>Date:</strong> <?= htmlspecialchars($promotion['start_date']) ?> - <?= htmlspecialchars($promotion['end_date']) ?><br>
                <strong>Description:</strong> <?= htmlspecialchars($promotion['promotion_description']) ?><br>
                <strong>Code:</strong> <span style="color: #ff69b4; font-weight: bold;"><?= htmlspecialchars($promotion['promotion_code']) ?></span><br>
                <span class="promotion-status 
                    <?= $promotion['status'] === 'completed' ? 'bg-warning' : ($promotion['status'] === 'active' ? 'bg-info' : 'bg-danger') ?>">
                    <?= htmlspecialchars($promotion['status']) ?>
                </span>
            </div>

            <!-- More options button -->
            <div class="more-options">
                <button class="more-button" onclick="toggleDropdown(this)">&#x22EE;</button> <!-- Three dots -->
                <div class="dropdown-menu">
                    <a href="/promotion/edit/<?= $promotion['id'] ?>" class="edit-button">✏️ Edit</a>
                    <a href="/promotion/delete/<?= $promotion['id'] ?>" class="delete-button" onclick="return confirm('Are you sure you want to delete this promotion?')">🗑️ Delete</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>



<script>
function toggleDropdown(button) {
    var dropdown = button.nextElementSibling; // Get the dropdown content
    dropdown.style.display = "block"; // Show the dropdown

    // Close dropdown if clicking outside
    document.addEventListener("click", function (event) {
        // Check if the click was outside the button or dropdown
        if (!button.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.style.display = "none";
        }
    });
}

</script>


