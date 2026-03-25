

// $(document).ready(function(){
//   // Add to cart button
//   $(".js-add-to-cart-button").click(function(){
//     var button = $(this);
//     var productId = button.data("product-id");
//     $.post("cart_add.php", {product_id: productId}, function(res){
//       //show added message
//       button.siblings(".added-to-cart").fadeIn().delay(1000).fadeOut();
//       //update cart quantity in header
//       $.get("cart_quantity.php", function(data){
//         $(".js-cart-quantity").text(data);
//       }, "json");
//     });
//     // Load cart quantity on page load
//     $.get("cart_quantity.php", function(data){
//       $(".js-cart-quantity").text(data);
//     });
//   });
// });