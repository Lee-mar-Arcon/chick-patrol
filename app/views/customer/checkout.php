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
   <!-- leaflet -->
   <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
</head>

<body>

   <?php include 'components/top-navigation.php' ?>
   <!-- Header Section End -->

   <section class="checkout spad">
      <div class="container">
         <?php if ($cartProducts) { ?>
            <div class="checkout__form">
               <h4>Billing Details</h4>
               <form action="<?= site_url('customer/place_order') ?>" method="post">
                  <input type="hidden" id="location" name="location">
                  <div class="row">
                     <div class="col-lg-7 col-md-5">
                        <div class="row">
                           <div class="col-lg-6">
                              <div class="checkout__input">
                                 <p>Fist Name<span>*</span></p>
                                 <input type="text" value="<?= $user['first_name'] ?>" readonly>
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class="checkout__input">
                                 <p>Last Name<span>*</span></p>
                                 <input type="text" value="<?= $user['last_name'] ?>" readonly>
                              </div>
                           </div>
                        </div>
                        <div class="checkout__input">
                           <p>Barangay<span>*</span></p>
                           <input type="text" value="<?= $user['barangay_name'] ?>" readonly>
                        </div>
                        <div class="checkout__input">
                           <p>Street<span>*</span></p>
                           <input type="text" placeholder="Street Address" class="checkout__input__add" value="<?= $user['street'] ?>" readonly>
                        </div>
                        <div class="checkout__input">
                           <p>Exact Location Note <span>*</span></p>
                           <textarea placeholder="Enter where you want to exactly get your order." name="note" id="note" cols="auto" rows="5"></textarea>
                           <?= isset($errors['note']) != null ? '<div style="color: red;">' . $errors['note'] . '</div>' : '' ?>
                        </div>
                        <div class="row">
                           <div class="col-lg-6">
                              <div class="checkout__input">
                                 <p>Phone<span>*</span></p>
                                 <input type="text" value="<?= $user['contact'] ?>" readonly>
                              </div>
                           </div>
                           <div class="col-lg-6">
                              <div class="checkout__input">
                                 <p>Email<span>*</span></p>
                                 <input type="text" value="<?= $user['email'] ?>" readonly>
                              </div>
                           </div>
                           <div class="col-lg-12 mb-3">
                              <div class="checkout__input">
                                 <p>Location <span>*</span></p>
                                 <div class="bg-dark" style="height: 500px;" id="map"></div>
                                 <?= isset($errors['location']) != null ? '<div style="color: red;">' . $errors['location'] . '</div>' : '' ?>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-5 col-md-7">
                        <div class="checkout__order">
                           <h4>Your Order</h4>
                           <div class="checkout__order__products">Products (quantity) <span>Total</span></div>
                           <ul>
                              <!-- the total variable is for the total in the bottom of the foreach -->
                              <?php $total = 0;
                              foreach ($cartProducts as $product) : ?>
                                 <?php $productQuantity = 0;
                                 foreach (json_decode($cart['products']) as $cartProduct) {
                                    if ($cartProduct->id == $product['id']) {
                                       $productQuantity = $cartProduct->quantity;
                                       break;
                                    }
                                 }
                                 ?>
                                 <li><?= $product['name'] . '&nbsp; (' . $productQuantity . ')' ?> <span>Php <?= $total += number_format(($productQuantity * $product['price']), 2) ?></span></li>
                              <?php endforeach; ?>

                           </ul>
                           <div class="checkout__order__subtotal">Deliver fee <span>&nbsp;Php</span> <span><?= number_format($user['delivery_fee'], 2) ?></span></div>
                           <div class="checkout__order__total">Total <span>Php&nbsp; <?= number_format($total + $user['delivery_fee'], 2) ?></span></div>
                           <button type="submit" class="site-btn">PLACE ORDER</button>
                        </div>
                     </div>
                  </div>
               </form>
            </div>
         <?php } else { ?>
            <div class="row">
               <div class="col-12 text-center h1 col-12 fw-bold text-secondary my-5">
                  <div>
                     Your cart is empty
                  </div>
                  <a href="<?= site_url('customer/homepage') ?>">
                     <button type="button" class="site-btn">Shop Now!</button>
                  </a>
               </div>
            </div>
         <?php } ?>
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
   <!-- leaflet -->
   <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
   <script src="<?= BASE_URL ?>public/leaflet/leafletjs_code.js"></script>


   <script>
      $(document).ready(function() {
         updateCartBadge()
      })

      function updateCartBadge() {
         $.post('<?= site_url('customer_api/get_cart_total') ?>', {})
            .then(function(response) {
               $('.fa-shopping-bag').next().html('0')
               if (parseInt(response))
                  $('.fa-shopping-bag').next().html(response)
            })
      }
   </script>
</body>

</html>