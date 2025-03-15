<?php if (isset($_SESSION['error'])): ?>
    <p style="color: red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
    <p style="color: green;"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
<?php endif; ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid w-50 mt-3">
        <form method="POST" action="/inventory/products/update/<?php echo $product['id']; ?>" class="card p-3">
            <p class="display-5">Edit Product</p>
            <p>Check and update product information</p>

            <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">

            <div class="form-group my-2">
            <label for="name">Product Name:</label>
            <input type="text" name="name" id="name" value="<?php echo $product['name']; ?>" required><br>
            </div>

            <div class="form-group my-2">
            <label for="description">Description:</label>
            <textarea name="description" id="description"><?php echo $product['description']; ?></textarea><br>
            </div>

            <div class="form-group my-2">
            <label for="price">Price:</label>
            <input type="number" name="price" id="price" value="<?php echo $product['price']; ?>" step="0.01" required><br>
            </div>

            <div class="form-group my-2">
            <label for="category_id">Category ID:</label>
            <input type="number" name="category_id" id="category_id" value="<?php echo $product['category_id']; ?>" required><br>
            </div>

            <div class="form-group my-2">
            <label for="stocks">Stock Quantity:</label>
            <input type="number" name="stocks" id="stocks" value="<?php echo $product['stocks']; ?>"><br>
            </div>

            <div class="form-group my-2">
            <label for="status">Status:</label>
    <select name="status" id="status">
        <option value="instock" <?php if ($product['status'] == 'instock') echo 'selected'; ?>>In Stock</option>
        <option value="low-stock" <?php if ($product['status'] == 'low-stock') echo 'selected'; ?>>Low Stock</option>
    </select><br>
            </div>

            <div class="d-flex gap-3 mt-3">
                <a href="inventory/stock.php" class="btn btn-outline-secondary w-100">Back</a>
                <button type="submit" class="btn btn-primary w-100">Save Changes</button>
            </div>
        </form>
    </div>


    
</body>
</html>