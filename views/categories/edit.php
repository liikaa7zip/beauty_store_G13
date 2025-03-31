<?php
require_once "views/layouts/header.php";
require_once "views/layouts/sidebar.php";
require_once "views/layouts/navbar.php"; 
?>

<div class="container mt-5">
    <h1 class="text-center">Edit Category</h1>
    <form action="/categories/update/<?= $category['id'] ?>" method="POST" class="mt-4">
        <div class="mb-3">
            <label for="category_name" class="form-label">Category Name</label>
            <input type="text" class="form-control" id="category_name" name="category_name" value="<?= htmlspecialchars($category['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="category_description" class="form-label">Category Description</label>
            <textarea class="form-control" id="category_description" name="category_description" rows="4" required><?= htmlspecialchars($category['description']) ?></textarea>
        </div>
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="/categories" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php require_once "views/layouts/footer.php"; ?>