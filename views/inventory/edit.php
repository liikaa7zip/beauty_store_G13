
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
        <form action="edit.php?id=<?= htmlspecialchars($product['id']) ?>" method="POST" class="card p-3">
            <p class="display-5">Edit Product</p>
            <p>Check and update product information</p>

            <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">

            <div class="form-group my-2">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" value="<?= htmlspecialchars($product['name']) ?>" name="name" id="name" class="form-control" required>
            </div>

            <div class="form-group my-2">
                <label for="stocks" class="form-label">Stock</label>
                <input type="number" value="<?= htmlspecialchars($product['stocks']) ?>" name="stocks" id="stocks" class="form-control" required>
            </div>

            <div class="form-group my-2">
                <label for="category_id" class="form-label">Category</label>
                <input type="text" value="<?= htmlspecialchars($product['category_id']) ?>" name="category_id" id="category_id" class="form-control" required>
            </div>

            <div class="form-group my-2">
                <label for="status" class="form-label">Status</label>
                <textarea name="status" id="status" class="form-control"><?= htmlspecialchars($product['status']) ?></textarea>
            </div>

            <div class="d-flex gap-3 mt-3">
                <a href="inventory/stock.php" class="btn btn-outline-secondary w-100">Back</a>
                <button type="submit" class="btn btn-primary w-100">Save Changes</button>
            </div>
        </form>
    </div>
</body>
</html>