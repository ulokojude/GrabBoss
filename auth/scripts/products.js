document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.querySelector('#searchInput');
  const searchButton = document.querySelector( '#searchButton' );
  // Handle search button click
  searchButton.addEventListener('click', (e) => {
    e.preventDefault();
    performSearch();
  });
  // Handle enter key in search_input
  searchInput.addEventListener('keypress', (e) => {
    if (e.key === 'Enter') {
      e.preventDefault();
      performSearch();
    }
  });
  
  function performSearch() {
    const query = searchInput.value.trim();
    if (query) {
      window.location.href = `products.php?search=${ encodeURIComponent(query) }`;
    } else {
      window.location.href = 'products.php';
    }
    //performSearch();
  }
});

$(document).ready(function(){
  // Add to cart button
  $(".js-add-to-cart-button").click(function(){
    var button = $(this);
    var productId = button.data("product-id");
    $.post("cart_add.php", {product_id: productId}, function(res){
      //show added message
      button.siblings(".added-to-cart").fadeIn().delay(1000).fadeOut();
      //update cart quantity in header
      $.get("cart_quantity.php", function(data){
        $(".js-cart-quantity").text(data);
      }, "json");
    });
    // Load cart quantity on page load
    $.get("cart_quantity.php", function(data){
      $(".js-cart-quantity").text(data);
    });
  });
});