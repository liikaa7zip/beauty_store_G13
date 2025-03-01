<div class="header-container">
    <h1 class="h1stock">Promotion</h1>
    <div class="header-controls">
        <div class="search-container">
            <input type="text" id="searchProducts" placeholder="Search products...">
            <span class="material-symbols-outlined search-icon">search</span>
        </div>
        <div class="excel-controls">
            <button class="excel-btn add-btn" id="addNewBtn">
                <span class="material-symbols-outlined">add</span>
                Add New
            </button>
        </div>
    </div>
</div>

<section id="promotion-list">
    <table class=" align-middle">
        <thead class="text-center ">
            <tr>
                <th>Start - End Date</th>
                <th>Promotion Name</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($promotions as $promotion): ?>
                <tr>
                    <td><?= htmlspecialchars($promotion['start_date']) ?> - <?= htmlspecialchars($promotion['end_date']) ?></td>
                    <td><?= htmlspecialchars($promotion['promotion_name']) ?></td>
                    <td><?= htmlspecialchars($promotion['promotion_description']) ?></td>
                    <td class="action-buttons">
                        <a href="#" aria-label="Edit Promotion">
                            <span class="material-symbols-outlined edit-icon">border_color</span>
                        </a>
                        <a href="#" aria-label="Delete Promotion">
                            <span class="material-symbols-outlined delete-icon">delete</span>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>
