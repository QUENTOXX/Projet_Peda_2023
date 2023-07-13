var cartItems = [];

function addItemToCart(itemName, itemPrice, itemImage) {
  var item = {
    name: itemName,
    price: itemPrice,
    image: itemImage
  };
  cartItems.push(item);
}

function displayCartItems() {
  var cartItemsDiv = document.getElementById("cart-items");
  cartItemsDiv.innerHTML = "";

  for (var i = 0; i < cartItems.length; i++) {
    var item = cartItems[i];
    var itemDiv = document.createElement("div");
    itemDiv.classList.add("cart-item");
    itemDiv.innerHTML = `
      <img src="${item.image}">
      <div class="cart-item-info">
        <div class="cart-item-name">${item.name}</div>
        <div class="cart-item-price">$${item.price}</div>
      </div>
    `;
    cartItemsDiv.appendChild(itemDiv);
  }

  updateCartTotal();
}

function updateCartTotal() {
  var total = 0;
  for (var i = 0; i < cartItems.length; i++) {
    total += cartItems[i].price;
  }
  var cartTotalDiv = document.getElementById("cart-total");
  cartTotalDiv.innerHTML = "Total: $" + total;
}

// Récupérer les paramètres d'URL et ajouter l'article au panier
var urlParams = new URLSearchParams(window.location.search);
var itemName = urlParams.get('nom');
var itemPrice = parseInt(urlParams.get('prix'));
var itemImage = urlParams.get('image');

if (itemName && itemPrice && itemImage) {
  addItemToCart(itemName, itemPrice, itemImage);
}

// Afficher le panier
displayCartItems();