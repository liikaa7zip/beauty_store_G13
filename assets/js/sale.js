document.addEventListener('DOMContentLoaded', function() {
    const saleProductInput = document.getElementById('sale-product');
    const saleQuantityInput = document.getElementById('sale-quantity');
    const productStockInput = document.getElementById('product-stock');

    saleProductInput.addEventListener('change', updateStock);
    saleQuantityInput.addEventListener('input', updateStock);

    function updateStock() {
        const selectedOption = document.querySelector(`#magicHouses option[value="${saleProductInput.value}"]`);
        const stock = selectedOption ? selectedOption.getAttribute('data-stock') : 0;
        const quantity = saleQuantityInput.value;

        if (quantity > stock) {
            alert('Insufficient stock available.');
            saleQuantityInput.value = stock;
        }

        const remainingStock = stock - quantity;
        productStockInput.value = remainingStock;
    }
});
