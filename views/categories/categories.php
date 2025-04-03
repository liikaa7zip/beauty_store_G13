

<div class="products_container">
    <h1 id="h1-products" class="text-center my-4">Categories List</h1>
    <div class="container mt-4">
        <div class="table-container mb-4">
            <div class="table-header d-flex justify-content-between align-items-center overflow-hidden">
                <input type="text" id="searchInput" class="form-control w-50" placeholder="Search for categories..." onkeyup="searchProducts()">
                <a href="/categories/create" class="add-category-btn">
                    <i class="fas fa-plus me-2"></i>Add Category
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <?php if (!empty($categories)) : ?>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th style="width: 30%;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="categoryTableBody">
                        <?php foreach ($categories as $index => $category) : ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= $category['name'] ?></td>
                                <td><?= $category['description'] ?></td>
                                <td class="d-flex justify-content-around">
                                    <div class="dropdown">
                                        <button class="drop btn btn btn-sm" onclick="toggleDropdown(this)">
                                            <span class="material-symbols-outlined">more_horiz</span>
                                        </button>
                                        <div class="dropdown-content" style="display: none;">
                                            <a href="/categories/edit/<?= $category['id'] ?>">
                                                <span class="material-symbols-outlined" id="edit-pro">border_color</span> Edit
                                            </a>
                                            <a href="/categories/delete/<?= $category['id'] ?>" onclick="return confirmDelete(event);">
                                                <span class="material-symbols-outlined" id="delete-pro">delete</span> Delete
                                            </a>
                                            <a href="/inventory/product/category/<?= $category['id'] ?>">
                                                <span class="material-symbols-outlined" id="view-pro">visibility</span> View
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
        </div>
    <?php endforeach; ?>
    </tbody>
    </table>

<?php else : ?>
    <div class="col-12 text-center">
        <p class="text-muted">No categories available. Please add a new category.</p>
    </div>
<?php endif; ?>
    </div>
</div>
</div>
<script>
    function searchCategories() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#categoryTableBody tr');

        rows.forEach(row => {
            const name = row.cells[1].textContent.toLowerCase();
            const description = row.cells[2].textContent.toLowerCase();
            if (name.includes(input) || description.includes(input)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>
