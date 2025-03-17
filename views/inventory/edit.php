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

<div class="create_product_container">
    <h1 id="h1edit">Edit Product</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form method="POST" action="/inventory/products/update/<?php echo $product['id']; ?>" class="edit-form" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">

        <!-- Left Column -->
        <div class="left-column">
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" id="craete-name" name="name" class="form-control" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>
            <div class="form-group">
                <label for="stocks">Stocks</label>
                <input type="number" id="stocks" name="stocks" class="form-control" value="<?php echo htmlspecialchars($product['stocks']); ?>" required>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" id="price" name="price" class="form-control" value="<?php echo htmlspecialchars($product['price']); ?>" step="0.01" required>
            </div>

            <div class="d-flex gap-3 mt-3" id="btn-edit">
            <a href="/inventory/products" class="btn btn-primary" id="backedit">Back</a>
            <button type="submit" class="btn btn-primary" id="save-change">Save Changes</button>
        </div>
        </div>

        <!-- Right Column -->
        <div class="right-column">
            <div class="form-group">
                <label for="category_id">Category</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>" <?= ($product['category_id'] == $category['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control"><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>
            <div class="form-group">
                <label for="productImage">Product Image</label>
                <input type="file" id="productImage" name="productImage" class="form-control" accept="image/*">
                <?php if (!empty($product['image']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $product['image'])): ?>
                    <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image">
                <?php else: ?>
                    <img src="/path/to/default-image.jpg" alt="Default Image" class="product-image">
                <?php endif; ?>
            </div>
        </div>
    </form>
</div>





