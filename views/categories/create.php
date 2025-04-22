<h1 class="category-title">Create New Category</h1>
<form action="/categories/store" method="POST" class="category-container" enctype="multipart/form-data">
    <label for="category_name" class="category-label">Category Name:</label>
    <input type="text" id="category_name" name="category_name" class="category-input" required>

    <label for="category_description" class="category-label">Category Description:</label>
    <textarea id="category_description" name="category_description" class="category-textarea" required></textarea>

    <div class="button-group">
        <a href="/categories" class="category-cancel" style="text-decoration: none;">Back</a>
        <button type="submit" class="category-submit">Create Category</button>
    </div>
</form>

<div id="uniqueSuccessModal" class="unique-modal">
    <div class="unique-modal-content">
        <p>Category created successfully!</p>
        <button id="uniqueCloseModal">OK</button>
    </div>
</div>


