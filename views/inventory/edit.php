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

<div class="container mt-5">
    <h1 class="text-center mb-5">Edit Product</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="/inventory/products/update/<?= $product['id'] ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">

        <div class="row g-4">
            <div class="col-md-6">
                <div class="mb-4">
                    <label for="edit-name" class="form-label" id="name-create">Product Name</label>
                    <input type="text" id="create-name" name="name" class="form-control form-control-lg" value="<?= htmlspecialchars($product['name']) ?>" required>
                </div>
                <div class="mb-4">
                    <label for="edit-stocks" class="form-label" id="name-create">Stocks</label>
                    <input type="number" id="stocks" name="stocks" class="form-control form-control-lg" value="<?= htmlspecialchars($product['stocks']) ?>" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-4">
                    <label for="edit-category_id" class="form-label" id="cat-create">Category</label>
                    <select id="category_id" name="category_id" class="form-select form-select-lg" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>" <?= $product['category_id'] == $category['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="edit-price" class="form-label" id="cat-create">Price</label>
                    <input type="text" id="price" name="price" class="form-control form-control-lg" value="<?= htmlspecialchars($product['price']) ?>" required>
                </div>

            </div>
            <div class="mb-4">
                    <label for="edit-description" class="form-label" id="name-created">Description</label>
                    <textarea id="description" name="description" class="form-control form-control-lg" rows="4"><?= htmlspecialchars($product['description']) ?></textarea>
                </div>
                <div class="mb-4">
                    <label for="edit-productImage" class="form-label" id="name-created">Product Image</label>
                    <input type="file" id="productImage" name="productImage" class="form-control form-control-lg" accept="image/*">
                    <?php if (!empty($product['image']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $product['image'])): ?>
                        <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image mt-2">
                    <?php else: ?>
                        <img src="/path/to/default-image.jpg" alt="Default Image" class="product-image mt-2">
                    <?php endif; ?>
                </div>
        </div>

        <!-- Centering the buttons with matching padding -->
        <div class="d-flex justify-content-center mt-5 gap-3">
    <a href="/inventory/products" class="btn btn-secondary btn-lg px-5">Back</a>
    <button id="pro-edit"  type="submit" class="btn btn-primary btn-lg px-5" style="background-color: #FF1493; border: none;">SAVE CHANGES</button>
</div>

    </form>
</div>







