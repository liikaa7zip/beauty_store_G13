<div class="products_container">
    <h1 id="h1-products" class="text-center my-4">Categories List</h1>
    <div class="container mt-4">
        <div class="table-container1 mb-4">
            <div class="table-header d-flex justify-content-between align-items-center">
                <input type="text" id="searchInput1" class="form-control p-2" placeholder="Search for categories...">
                <a href="/categories/create" class="add-category-btn p-2 text-nowrap">
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
                                        <button class="dropdown-toggle" type="button">
                                            &#x22EE; <!-- Vertical Ellipsis -->
                                        </button>
                                        <div class="dropdown-menu">
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