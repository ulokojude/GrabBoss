import { products } from "data";

const container = document.getElementById("js-products-grid");

products.forEach(product => {
  container.innerHTML += `
    <div class="product-container">
      <div class="product-image-container">
        <img class="product-image" alt="" src="${product.image}">
      </div> 
      <div style="font-weight:bolder; color:#0d6efd" class="product-name limit-text-to-2-lines" style="color: #333;">
        ${product.name}
      </div>
      <div class="product-rating-container">
        <a href="#">
          <img class="product-rating-stars"
            src="${product}"
          >
        </a>
        <div class="product-rating-count link-primary">
          ${product.rating_count}
        </div>
      </div>

      <p class=" pr">
        &#8358; ${product.price}
      </p>

      <form>
        <button class="btn btn-primary" name="add_to_cart" type="submit">
          Add to Cart
        </button>
      </form>
    </div>
  `;
});

