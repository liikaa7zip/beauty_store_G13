<div class="products_container">
    <h1 id="h1-products" class="text-center my-4">Categories List</h1>
    <div class="container mt-4">
        <div class="table-container1 mb-4">
            <div class="table-header d-flex justify-content-between align-items-center">
                <input type="text" id="searchInput" class="form-control p-2" placeholder="Search for categories...">
                <a href="/categories/create" class="add-category-btn p-2 text-nowrap">
                    <i class="fas fa-plus me-2"></i>Add Category
                </a>
            </div>
        </div>
        <div class="table-responsive">
            <?php if (!empty($categories)) : ?>
                <table class="table-emp table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Action</th> <!-- Ensure "Action" column is right-aligned -->
                        </tr>
                    </thead>
                    <tbody id="categoryTableBody">
                        <?php foreach ($categories as $index => $category) : ?>
                            <tr>
                                <td style="text-align: center;"><?= $index + 1 ?></td> <!-- Center-align ID -->
                                <td><?= $category['name'] ?></td>
                                <td><?= $category['description'] ?></td>
                                <td class="d-flex justify-content-end"> <!-- Right-align "Action" column -->
                                    <div class="dropdown-cate">
                                        <button class="dropdown-toggle-cate" type="button">
                                            &#x22EE; <!-- Vertical Ellipsis -->
                                        </button>
                                        <div class="dropdown-menu-cate">
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
    document.addEventListener("DOMContentLoaded", function () {
        const cateDropdowns = document.querySelectorAll('.dropdown-cate');

        cateDropdowns.forEach(function (dropdown) {
            const toggle = dropdown.querySelector('.dropdown-toggle-cate');
            const menu = dropdown.querySelector('.dropdown-menu-cate');

            toggle.addEventListener('click', function (e) {
                e.stopPropagation();

                // Close all others
                document.querySelectorAll('.dropdown-menu-cate').forEach(m => {
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

    // Search functionality for Categories Table
    document.getElementById("searchInput").addEventListener("keyup", function () {
        let input = this.value.toLowerCase();
        let rows = document.querySelectorAll("#categoryTableBody tr");

        rows.forEach(function (row) {
            let categoryName = row.cells[1].textContent.toLowerCase(); // Category column
            let description = row.cells[2].textContent.toLowerCase(); // Description column

            if (categoryName.includes(input) || description.includes(input)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
</script>