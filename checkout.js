import { products } from "./data";

let cart = JSON.parse(localStorage.getItem("cart")) || [];


const cartContainer = document.getElementById("b_p");
const totalPrice = document.getElementById("cart-count");

function renderCheckout() {
  if (cart.lenght === 0) {
    count_pro.innerHTML = `<p>Your cart is empty. <a href="g_products.html">Go shopping!</a></p>`;
    totalContainer.textContent = `N 0`;
    return;
  }

  let cartHTML = '';
  let totalPrice = 0;

  cart.forEach(product => {
    // Calculate total for this item
    const itemTotal = item.price * item.quantity;
    totalPrice += itemTotal;

    cartHTML += `
    <hr>
    <div class="d-flex align-items-center mb-3 order-card">
      <img src="/images/hero.jpeg" class="me-3" alt="">
      <div class="flex-group-1">
        <p class="mb-1 h6 h6">${product.name}</p>
        <small>&#8358; ${product.price}</small><br>
        <div class="h6">
          quty() <a href="" class="text-decoration-none remove-item">-</a>
          |<a href="" class="text-decoration-none">+</a> 
        </div>
      </div>
    </div>`
  });

  cartContainer.innerHTML = cartHTML;
  totalPrice.innerHTML = `&#8358; ${totalPrice}`;
}

// Initialise Render
renderCheckout();

// Hndle remmoving items
document.addEventListener("click", (Event) => {
  if (Event.target.classList.contains("remove-item")) {
    const productId = Event.target.dataset.id;
    // filter out item
    cart = cart.filter(item => item.id != productId);

    // Update local storage
    localStorage.setItem("cart", JSON.stringify(cart));

    // Re-dra the UI
    renderCheckout();
  }
})
