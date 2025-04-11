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

<div class="edit-product-container">
    <h1 class="edit-product-title text-center">Edit Product</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="edit-product-alert alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="/inventory/update/<?= $product['id'] ?>" method="POST" enctype="multipart/form-data">
        <div class="edit-product-grid">
            <div class="edit-product-column">
                <div class="edit-product-field">
                    <label for="name" class="edit-form-label" id="name-create">Product Name</label>
                    <input type="text" id="create-name" name="name" class="edit-form-control edit-form-control-lg" value="<?= htmlspecialchars($product['name']) ?>" required>
                </div>
                <div class="edit-product-field">
                    <label for="stocks" class="edit-form-label" id="name-create">Stocks</label>
                    <input type="number" id="stocks" name="stocks" class="edit-form-control edit-form-control-lg" value="<?= htmlspecialchars($product['stocks']) ?>" required>
                </div>
                <div class="edit-product-field">
                    <label for="start-date" class="edit-form-label" id="start-date-label">Start Date</label>
                    <input type="date" id="start-date" name="start_date" class="edit-form-control edit-form-control-lg" value="<?= htmlspecialchars($product['start_date']) ?>" required>
                </div>
            </div>

            <div class="edit-product-column">
                <div class="edit-product-field">
                    <label for="category_id" class="edit-form-label" id="cat-create">Category</label>
                    <select id="category_id" name="category_id" class="edit-form-select edit-form-select-lg" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>" <?= $category['id'] == $product['category_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="edit-product-field">
                    <label for="price" class="edit-form-label" id="cat-create">Price</label>
                    <input type="number" id="price" name="price" class="edit-form-control edit-form-control-lg" value="<?= htmlspecialchars($product['price']) ?>" required>
                </div>
                <div class="edit-product-field">
                    <label for="expire-date" class="edit-form-label" id="expire-date-label">Expire Date</label>
                    <input type="date" id="expire-date" name="expire_date" class="edit-form-control edit-form-control-lg" value="<?= htmlspecialchars($product['expire_date']) ?>" required>
                </div>
            </div>
        </div>

        <div class="edit-product-description">
            <label for="description" class="edit-form-label" id="name-created">Description</label>
            <textarea id="description" name="description" class="edit-form-control edit-form-control-lg" rows="4" required><?= htmlspecialchars($product['description']) ?></textarea>
        </div>

        <div class="edit-product-image-upload">
            <label for="productImage" class="edit-form-label" id="name-created">Product Image</label>
            <input type="file" id="productImage" name="productImage" class="edit-form-control edit-form-control-lg" accept="image/*" onchange="showFileName()">
            <small id="fileName" class="text-muted mt-2"></small>
            <div class="edit-product-image-preview">
                <img src="<?= !empty($product['image']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $product['image'])
                                ? '/' . htmlspecialchars($product['image'])
                                : 'https://i.pinimg.com/1200x/69/96/2f/69962f39b03a5ba0e49f4668523b5d61.jpg' ?>"
                    alt="<?= htmlspecialchars($product['name']) ?>"
                    class="product-preview">
                <p class="text-muted"><?= !empty($product['image']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $product['image']) ? 'Current Image' : 'Default Image' ?></p>
            </div>
        </div>

        <div class="edit-product-button text-center">
            <button id="pro-create" type="submit" class="btn btn-primary btn-lg px-5">UPDATE PRODUCT</button>
        </div>
    </form>
</div>


<script>
    function showFileName() {
        const fileInput = document.getElementById('productImage');
        const fileNameDisplay = document.getElementById('fileName');
        if (fileInput.files.length > 0) {
            fileNameDisplay.textContent = `Selected file: ${fileInput.files[0].name}`;
        } else {
            fileNameDisplay.textContent = '';
        }
    }
</script>

