<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /users/signIn");
    exit();
}

// Initialize $product to avoid undefined variable warnings
$product = $product ?? [
    'name' => '',
    'price' => '',
    'stocks' => '',
    'start_date' => '',
    'category_id' => '',
    'status' => '',
    'expire_date' => '',
    'description' => '',
    'image' => ''
];
?>

<div class="container mt-5">
    <h1 class="text-center mb-5">Create Product</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="/inventory/create" method="POST" enctype="multipart/form-data">
        <div class="row g-4">
            <div class="col-md-6">
                <div class="mb-4">
                    <label for="name" class="form-label" id="name-create">Product Name</label>
                    <input type="text" id="create-name" name="name" class="form-control form-control-lg" value="<?= htmlspecialchars($product['name']) ?>" required>
                </div>
                <div class="mb-4">
                    <label for="stocks" class="form-label" id="name-create">Stocks</label>
                    <input type="number" id="stocks" name="stocks" class="form-control form-control-lg" value="<?= htmlspecialchars($product['stocks']) ?>" required>
                </div>
                <div class="mb-4">
                    <label for="start-date" class="form-label" id="start-date-label">Start-date</label>
                    <input type="date" id="start-date" name="start_date" class="form-control form-control-lg" value="<?= htmlspecialchars($product['start_date']) ?>" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-4">
                    <label for="category_id" class="form-label" id="cat-create">Category</label>
                    <select id="category_id" name="category_id" class="form-select form-select-lg" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>" <?= $category['id'] == $product['category_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="price" class="form-label" id="cat-create">Price</label>
                    <input type="number" id="price" name="price" class="form-control form-control-lg" value="<?= htmlspecialchars($product['price']) ?>" required>
                </div>
                <div class="mb-4">
                    <label for="expire-date" class="form-label" id="expire-date-label">Expire-date</label>
                    <input type="date" id="expire-date" name="expire_date" class="form-control form-control-lg" value="<?= htmlspecialchars($product['expire_date']) ?>" required>
                </div>
            </div>
            <div class="mb-4">
                    <label for="description" class="form-label" id="name-created">Description</label>
                    <textarea id="description" name="description" class="form-control form-control-lg" rows="4" required><?= htmlspecialchars($product['description']) ?></textarea>
                </div>
                <div class="mb-4">
                    <label for="productImage" class="form-label" id="name-created">Product Image</label>
                    <input type="file" id="productImage" name="productImage" class="form-control form-control-lg" accept="image/*">
                    <?php if (!empty($product['image']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $product['image'])): ?>
                        <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image-preview">
                    <?php endif; ?>
                </div>
        </div>
        
        <div class="text-center mt-5">
            <button id="pro-create" type="submit" class="btn btn-primary btn-lg px-5" style="background-color: #FF1493; border: none;">CREATE PRODUCT</button>
        </div>
    </form>
</div>

<style>
.form-label {
    font-weight: 500;
    margin-bottom: 0.5rem;
    color: #444;
}

.form-control, .form-select {
    border: 1px solid #ddd;
    padding: 0.75rem;
    border-radius: 8px;
    background-color: #fff;
}

.form-control:focus, .form-select:focus {
    border-color: #FF1493;
    box-shadow: 0 0 0 0.2rem rgba(255, 20, 147, 0.25);
}

.btn-primary:hover {
    background-color: #FF1493 !important;
    opacity: 0.9;
}
</style>

