function updateTotalPrice() {
    const cartItems = document.getElementsByClassName('cart-item');
    let total = 0;

    for (let i = 0; i < cartItems.length; i++) {
        const item = cartItems[i];
        const priceElement = item.querySelector('.item-details p');
        const price = parseFloat(priceElement.innerText.split(':')[1].trim().replace('$', ''));
        const quantity = parseFloat(item.querySelector('.item-quantity').value);

        total += price * quantity;
    }

    document.getElementById('cart-total').innerText = 'Total: $' + total.toFixed(2);
}

const quantityInputs = document.getElementsByClassName('item-quantity');
for (let i = 0; i < quantityInputs.length; i++) {
    quantityInputs[i].addEventListener('change', updateTotalPrice);
}

const removeButtons = document.getElementsByClassName('remove-button');
for (let i = 0; i < removeButtons.length; i++) {
    removeButtons[i].addEventListener('click', function () {
        this.closest('li').remove();
        updateTotalPrice();
    });
}

function goToCheckout() {
    window.location.href = "/projet_pedago/php/checkout.php";
}

function goBackToCart() {
    window.location.href = "/projet_pedago/php/Panier.php";
}
