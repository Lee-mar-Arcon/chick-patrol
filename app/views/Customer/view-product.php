<?php
$LAVA = lava_instance();
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
   <meta charset="UTF-8">
   <meta name="description" content="Ogani Template">
   <meta name="keywords" content="Ogani, unica, creative, html">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title><?= $pageTitle ?></title>

   <!-- Google Font -->
   <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

   <!-- Css Styles -->
   <link rel="stylesheet" href="<?= BASE_URL ?>public/customer/css/bootstrap.min.css" type="text/css">
   <link rel="stylesheet" href="<?= BASE_URL ?>public/customer/css/font-awesome.min.css" type="text/css">
   <link rel="stylesheet" href="<?= BASE_URL ?>public/customer/css/elegant-icons.css" type="text/css">
   <link rel="stylesheet" href="<?= BASE_URL ?>public/customer/css/nice-select.css" type="text/css">
   <link rel="stylesheet" href="<?= BASE_URL ?>public/customer/css/jquery-ui.min.css" type="text/css">
   <link rel="stylesheet" href="<?= BASE_URL ?>public/customer/css/owl.carousel.min.css" type="text/css">
   <link rel="stylesheet" href="<?= BASE_URL ?>public/customer/css/slicknav.min.css" type="text/css">
   <link rel="stylesheet" href="<?= BASE_URL ?>public/customer/css/style.css" type="text/css">
   <!-- toastify -->
   <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
   <!-- icons -->
   <link href="<?= BASE_URL . PUBLIC_DIR ?>/admin/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>

<body>

   <?php include 'components/top-navigation.php' ?>
   <!-- Header Section End -->
   <section class="product-details spad">
      <div class="container">
         <div class="row">
            <div class="col-lg-6 col-md-6">
               <div class="product__details__pic">
                  <div class="product__details__pic__item">
                     <img class="product__details__pic__item--large" src="<?= BASE_URL . 'public/images/products/cropped/' .  $product['image'] ?>" alt="">
                  </div>
               </div>
            </div>
            <div class="col-lg-6 col-md-6">
               <div class="product__details__text">
                  <div class="product__details__price">₱ <?= number_format($product['price'], 2) ?></div>
                  <p><?= $product['description'] ?></p>
                  <div class="d-flex justify-content-end">
                     <a href="" onclick="return false" class="primary-btn add-to-cart" data-id="<?= $product['id'] ?>">ADD TO CART</a>
                  </div>
                  <ul>
                     <li><b>Availability</b> <span class="available-quantity">In Stock</span></li>
                     <li><b>Category</b> <span><?= $product['category_name'] ?></span></li>
                  </ul>
               </div>
            </div>

         </div>
      </div>
   </section>

   <section class="related-product">
      <div class="container">
         <div class="row">
            <div class="col-lg-12">
               <div class="section-title related__product__title">
                  <h2>Related Product</h2>
               </div>
            </div>
         </div>
         <div class="row">

            <?php if (count($relatedProducts)) : ?>
               <?php foreach ($relatedProducts as $relatedProduct) : ?>
                  <div class="col-lg-3 col-md-4 col-sm-6">
                     <div class="product__item">
                        <div class="product__item__pic set-bg" data-setbg="<?= BASE_URL . 'public/images/products/cropped/' .  $relatedProduct['image'] ?>" style="background-image: url(&quot;<?= BASE_URL . 'public/images/products/cropped/' .  $relatedProduct['image'] ?>&quot;);">
                           <ul class="product__item__pic__hover">
                              <li>
                                 <a onclick="return false">
                                    <div style="cursor: pointer;" data-id="<?= $relatedProduct['id'] ?>" class="add-to-cart">
                                       <i class="fa fa-shopping-cart cursor-pointer"></i>
                                    </div>
                                 </a>
                              </li>
                              <li>
                                 <a href="<?= site_url('customer/view-product/' . $relatedProduct['id']) ?>">
                                    <div v style="cursor: pointer;" data-id="<?= $relatedProduct['id'] ?>">
                                       <i class="fa fa-eye cursor-pointer"></i>
                                    </div>
                                 </a>
                              </li>
                           </ul>
                        </div>
                        <div class="product__item__text">
                           <h6><a href="#"><?= $relatedProduct['name'] ?></a></h6>
                           <h5>₱ <?= number_format($relatedProduct['price'], 2) ?></h5>
                        </div>
                     </div>
                  </div>
               <?php endforeach; ?>
            <?php else : ?>
               <div class="h3 col-12 text-muted py-5 fw-bold text-center">no related products</div>
            <?php endif; ?>
         </div>
      </div>
   </section>
   <?php include 'components/footer.php' ?>





   <!-- Js Plugins -->
   <script src="<?= BASE_URL ?>public/customer/js/jquery-3.3.1.min.js"></script>
   <script src="<?= BASE_URL ?>public/customer/js/bootstrap.min.js"></script>
   <script src="<?= BASE_URL ?>public/customer/js/jquery.nice-select.min.js"></script>
   <script src="<?= BASE_URL ?>public/customer/js/jquery-ui.min.js"></script>
   <script src="<?= BASE_URL ?>public/customer/js/jquery.slicknav.js"></script>
   <script src="<?= BASE_URL ?>public/customer/js/mixitup.min.js"></script>
   <script src="<?= BASE_URL ?>public/customer/js/owl.carousel.min.js"></script>
   <script src="<?= BASE_URL ?>public/customer/js/main.js"></script>
   <!-- toastify -->
   <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>


   <script>
      $(document).ready(function() {
         updateCartBadge()
         getProductAvailableQuantity()
      })

      function updateCartBadge() {
         $.post('<?= site_url('customer_api/get_cart_total') ?>', {})
            .then(function(response) {
               $('.fa-shopping-bag').next().html('0')
               if (parseInt(response))
                  $('.fa-shopping-bag').next().html(response)
            })
      }

      const isLoggedIn = <?= $user == null ? 0 : 1 ?>;
      $(document).on('click', '.add-to-cart', function() {
         AddToCart($(this))
      })

      function AddToCart(element) {
         // not logged in toast
         if (!isLoggedIn) {
            // showToast("Log in first!", "linear-gradient(to right, #0d6982, #02768e)")
            window.location.replace("<?= site_url('account/login') ?>");
         } else {
            let id = element.attr('data-id')
            $.post('<?= site_url('customer_api/add_to_cart') ?>', {
                  id: id,
                  quantity: element.prev().find('input:eq(0)').val()
               })
               .then(function(response) {
                  console.log(response)
                  // show error if product exists
                  if (response == 'product exists')
                     showToast("Product already in cart!", "linear-gradient(to right, #ac1414, #f12b00)")
                  updateCartBadge()

                  // show toast if product added
                  if (response == 'product added')
                     showToast("Product added!", "linear-gradient(to right, #14ac34, #3ab902)")
               }).catch(function(error) {
                  console.log(error);
               })
         }
      }

      function showToast(message, color) {
         Toastify({
            text: message,
            duration: 1500,
            newWindow: true,
            close: true,
            gravity: "bottom",
            position: "center",
            stopOnFocus: true,
            style: {
               background: color,
            },
         }).showToast();
      }

      function getProductAvailableQuantity() {
         $.post('<?= site_url('customer_api/get_product_available_quantity') ?>', {
               product_id: '<?= $product['id'] ?>'
            })
            .then(function(response) {
               console.log(response)
               $('.available-quantity').html(parseFloat(response).toFixed(2))

            }).fail(function(response) {
               console.log(response)
            })
      }
   </script>
</body>

</html>