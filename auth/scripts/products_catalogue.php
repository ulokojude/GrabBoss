<?php foreach($filteredProducts as $product): ?>
  <div class="product-container">
    <div class="product-image-container">
      <img class="product-image"
        alt="<?php echo htmlspecialchars($product['name']); ?>"
        src="<?php echo $product['image']; ?>"
      >
    </div> 
    <div class="product-name limit-text-to-2-lines" style="color: #333;">
      <?php echo htmlspecialchars($product['name']); ?>
    </div>
    <div class="product-rating-container">
      <a href="#">
        <img class="product-rating-stars"
          src="images/ratings/rating-<?php echo $product['rating'] * 10; ?>.png"
        >
      </a>
      <div class="product-rating-count link-primary">
        <?php echo $product['rating']; ?>
      </div>
    </div>
    <div class="product-price">
      $<?php echo number_format($product['price'], 2); ?>
    </div>
    <a class="view-details-link" href="product-details.php?id=<?php echo $product['id']; ?>">
      View details
    </a>
    <div class="product-spacer"></div>
    <div class="added-to-cart">
      <img src="images/icons/checkmark.png">
      Added
    </div>
    <button 
      class="add-to-cart-button button-primary js-add-to-cart-button"
      data-product-id="<?php echo $product['id']; ?>">
      Add to Cart
    </button>
  </div>
<?php endforeach; ?>