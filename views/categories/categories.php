<!-- Modal for adding a category -->
<div id="category-modal" class="category-modal" style="display:none;">
    <div class="modal-content">
        <h3>Create New Category</h3>
        <form action="/inventory/create" method="POST">
            <label for="category-name">Category Name:</label>
            <input type="text" id="category-name" name="category_name" required>

            <label for="category-description">Category Description:</label>
            <textarea id="category-description" name="category_description" required></textarea>

            <div class="modal-buttons">
                <button type="submit" class="btn-primary">Create Category</button>
                <button type="button" onclick="hideModal()" class="btn-secondary">Cancel</button>
            </div>
        </form>
    </div>
</div>