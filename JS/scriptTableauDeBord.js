document.addEventListener('DOMContentLoaded', function () {
    const quantityInputs = document.querySelectorAll('.quantity-input');
    const updateButtons = document.querySelectorAll('.update-button');

    quantityInputs.forEach((input, index) => {
        input.addEventListener('input', function () {
            const currentQuantity = parseInt(input.getAttribute('data-current-quantity'));
            const newQuantity = parseInt(input.value);
            updateButtons[index].disabled = (newQuantity === currentQuantity);
        });
    });
});

