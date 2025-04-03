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
    'original_price' => '',
    'description' => '',
    'image' => ''
];
?>

<div class="product-form-container">
    <h1 class="form-heading">Create Product</h1>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-alert"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form action="/inventory/create" method="POST" enctype="multipart/form-data">
        <div class="form-main-layout">
            <!-- Left Section: Product Image -->
            <div class="image-section">
                <div class="form-group">
                    <label for="prod-image" class="form-label">Product Image</label>
                    <div class="image-upload-container" id="image-upload-container">
                        <input type="file" id="prod-image" name="productImage" class="form-input visually-hidden" accept="image/*">
                        <div class="upload-area" id="upload-area">
                            <div class="upload-placeholder">
                                <svg class="upload-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m-7-7h14" />
                                </svg>
                                <p class="upload-text">Drag & Drop or Click to Upload</p>
                                <p class="upload-subtext">Supports JPG, PNG, up to 5MB</p>
                            </div>
                            <div class="image-preview-box" id="image-preview-box">
                                <img id="preview-img" src="<?= !empty($product['image']) && file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $product['image'])
                                    ? htmlspecialchars($product['image'])
                                    : 'https://i.pinimg.com/1200x/69/96/2f/69962f39b03a5ba0e49f4668523b5d61.jpg' ?>"
                                    alt="Product Image" class="preview-img">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Section: All Inputs -->
            <div class="inputs-section">
                <div class="form-layout">
                    <div class="form-section">
                        <div class="form-group">
                            <label for="prod-name" class="form-label">Product Name</label>
                            <input type="text" id="prod-name" name="name" class="form-input" value="<?= htmlspecialchars($product['name']) ?>" required>
                        </div>

                        <div class="form-group price-field">
                            <label for="prod-origin-price" class="form-label">Original Price</label>
                            <input type="number" id="prod-origin-price" name="original_price" class="form-input" value="<?= htmlspecialchars($product['original_price'] ?? '') ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="prod-start-date" class="form-label">Start Date</label>
                            <input type="date" id="prod-start-date" name="start_date" class="form-input" value="<?= htmlspecialchars($product['start_date']) ?>" required>
                        </div>
                    </div>

                    <div class="form-section">
                        <div class="form-group">
                            <label for="prod-category" class="form-label">Category</label>
                            <select id="prod-category" name="category_id" class="form-select" required>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>" <?= $category['id'] == $product['category_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($category['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group price-field">
                            <label for="prod-price" class="form-label">Sale Price</label>
                            <input type="number" id="prod-price" name="price" class="form-input" value="<?= htmlspecialchars($product['price']) ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="prod-expire-date" class="form-label">Expire Date</label>
                            <input type="date" id="prod-expire-date" name="expire_date" class="form-input" value="<?= htmlspecialchars($product['expire_date']) ?>" required>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                            <label for="prod-stocks" class="form-label">Stocks</label>
                            <input type="number" id="prod-stocks" name="stocks" class="form-input" value="<?= htmlspecialchars($product['stocks']) ?>" required>
                        </div>

                <div class="form-group full-width">
                    <label for="prod-description" class="form-label">Description</label>
                    <textarea id="prod-description" name="description" class="form-textarea" rows="5" required><?= htmlspecialchars($product['description']) ?></textarea>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button id="create-prod-btn" type="submit" class="btn-primary">Create Product</button>
        </div>
    </form>
</div>


<script>
    document.addEventListener('DOMContentLoaded', () => {
    const imageInput = document.getElementById('prod-image');
    const uploadArea = document.getElementById('upload-area');
    const imagePreviewBox = document.getElementById('image-preview-box');
    const previewImg = document.getElementById('preview-img');
    const uploadPlaceholder = uploadArea.querySelector('.upload-placeholder');

    // Ensure the upload area is clickable
    uploadArea.addEventListener('click', (e) => {
        e.preventDefault();
        imageInput.click();
    });

    // Handle file selection
    imageInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (file) {
            displayImage(file);
        }
    });

    // Drag and Drop Events
    uploadArea.addEventListener('dragover', (event) => {
        event.preventDefault();
        uploadArea.classList.add('dragover');
    });

    uploadArea.addEventListener('dragleave', () => {
        uploadArea.classList.remove('dragover');
    });

    uploadArea.addEventListener('drop', (event) => {
        event.preventDefault();
        uploadArea.classList.remove('dragover');
        const file = event.dataTransfer.files[0];
        if (file) {
            imageInput.files = event.dataTransfer.files;
            displayImage(file);
        }
    });

    // Function to display the image
    function displayImage(file) {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImg.src = e.target.result;
                imagePreviewBox.classList.add('active');
                uploadPlaceholder.style.display = 'none';
            };
            reader.readAsDataURL(file);
        }
    }

    // Initial check for existing image
    if (previewImg.src && !previewImg.src.includes('placeholder')) {
        imagePreviewBox.classList.add('active');
        uploadPlaceholder.style.display = 'none';
    }
});
</script>