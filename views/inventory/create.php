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
    <h1 id="h1create">Create Product</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="/inventory/create" method="POST" class="create-form" enctype="multipart/form-data">
        <!-- Left Column -->
        <div class="left-column">
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" id="craete-name" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="stocks">Stocks</label>
                <input type="number" id="stocks" name="stocks" class="form-control" required>
            </div>
            <label for="price">Price</label>
            <input type="text" id="price" name="price" value="<?= htmlspecialchars($product['price']) ?>" required />
            <button type="submit" class="btn btn-primary" id="create-btn">Create Product</button>
        </div>

        <!-- Right Column -->
        <div class="right-column">
            <div class="form-group">
                <label for="category_id">Category</label>
                <select id="category_id" name="category_id" class="form-control" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="productImage">Product Image</label>
                <input type="file" id="productImage" name="productImage" class="form-control" accept="uplaods/">
            </div>
        </div>
    </form>
</div>

