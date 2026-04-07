import { products } from "./data.js";

const container = document.getElementById("js-products-grid");

// check if container exists
if (container) {
  let productsHTML = '';
  products.forEach(product => {
    productsHTML += `
      <div class="product-container">
        <div class="product-image-container">
          <img class="product-image" alt="" src="${product.image}">
        </div> 
        <div style="font-weight:bolder; color:#0d6efd" class="product-name limit-text-to-2-lines">
          ${product.name}
        </div>
        <div class="product-rating-container">
          <a href="#">
            <img class="product-rating-stars" src="${product.rating_stars_url || ''}">
          </a>
          <div class="product-rating-count link-primary">
            ${product.rating_count || 0}
          </div>
        </div>
        <p class=" pr"> &#8358; ${product.price}</p>
        <form>
          <button type="button" class="btn btn-primary add-to-cart-btn" data-id="${product.id}">
            Add to Cart
          </button>
        </form>
      </div>
    `;
  });

  container.innerHTML = productsHTML;
}


let cart = [];
cart = JSON.parse(localStorage.getItem("cart")) || [];

function addToCart(productId) {
  const product = products.find(p => p.id === productId);

  if (!product) return;

  // check if item exists
  const existingItem = cart.find(item => item.id === productId);

  if (existingItem) {
    existingItem.quantity += 1;
  } else {
    cart.push({
      id: product.id,
      name: product.name,
      price: product.price,
      quantity: 1
    });
  }

  // Save to local storage
  localStorage.setItem("cart", JSON.stringify(cart));

  updateCartCount();
  console.log("cart updaed:", cart);

}

document.addEventListener("click", (Event) => {
  if (Event.target.classList.contains("add-to-cart-btn")) {
    const productId = Event.target.dataset.id;
    addToCart(productId);
  }
})

function updateCartCount() {
  const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);

  document.getElementById("cart-count").textContent = totalItems;
}

updateCartCount();

function clearCart() {
  // whipe local storage
  localStorage.removeItem("cart");

  // reset local array
  cart = [];

  // update UI
  updateCartCount();

  console.log("cart has been emptied");

}