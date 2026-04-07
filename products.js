import { products } from "./data";

const container = document.getElementById("main");

products.forEach(product => {
  container.innerHTML += `
    <div class="product-container">
      <div class="product-image-container">
        <img class="product-image" alt="" src="${product.image}">
      </div>
      <p>${product.price}</p> 
      <div class="product-price">
        ${product.name}
      </div>
      <div class="product-spacer"></div>
    </div>`;
});

