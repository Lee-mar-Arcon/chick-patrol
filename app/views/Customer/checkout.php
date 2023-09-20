<?php
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
                           <div class="row pb-4">
                              <label for="payment_method" class="col-12">Payment Method: </label>
                              <select name="payment_method" class="col-12" id="payment_method">
                                 <option value="COD">COD</option>
                                 <option value="ONLINE">ONLINE</option>
                              </select>
                              <div class="col-12 mt-4" id="paypal-container" hidden>
                                 <div id="paypal-button-container"></div>
                                 <p id="result-message"></p>
                              </div>
                           </div>
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
   <script src="https://www.paypal.com/sdk/js?client-id=AT4kJk_h3TXbvu-4Dzgb_2ofugcaKpUSt8GYso-wA3K7jUnQJg-mxqr4-jldmtJFR9izTRbd5crkVSY_&currency=PHP"></script>
   <script>
      let userPaid = false
      let order_id = ''
      let accessToken = ''
      $.ajax({
         url: 'https://api-m.sandbox.paypal.com/v1/oauth2/token',
         type: 'POST',
         headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
            'Authorization': 'Basic ' + btoa('AbBa8TRqKhlMQpRwD6KzQmmks-Oz9X_wNClnqXZw9HerwJK82hOLiZfEE0DmyKhDXTKQwom6ixJrmdjx:EHxtClx0mHWgzbYT7oEb1hfkQfvx7K-a2Hi50t2cT4ifyYAAaqd6rqY5bjFtjgIyUjxOqsgxtbXkWtot')
         },
         data: {
            'grant_type': 'client_credentials'
         },
         success: function(response) {
            // Handle the response here
            console.log(response.access_token);
            accessToken = response.access_token
            haha(response.access_token)
         },
         error: function(error) {
            console.error('Failed to get Access Token:', error);
         }
      });

      function haha(accessToken) {
         const payload = {
            intent: "CAPTURE",
            purchase_units: [{
               amount: {
                  currency_code: "PHP",
                  value: "<?= $total + $user['delivery_fee'] ?>",
               },
            }, ],
         };

         $.ajax({
            url: 'https://api-m.sandbox.paypal.com/v2/checkout/orders',
            type: "POST",
            contentType: "application/json",
            headers: {
               Authorization: "Bearer " + accessToken
            },
            data: JSON.stringify(payload),
            success: function(response) {
               order_id = response.id
            },
            error: function(xhr, status, error) {
               console.error(error);
            }
         });
      }

      $(document).ready(function() {
         updateCartBadge()
         $('.nice-select').css('z-index', 10000)
      })

      function updateCartBadge() {
         $.post('<?= site_url('customer_api/get_cart_total') ?>', {})
            .then(function(response) {
               $('.fa-shopping-bag').next().html('0')
               if (parseInt(response))
                  $('.fa-shopping-bag').next().html(response)
            })
      }
      $("#payment_method").on('change', function() {
         if ($(this).val() === 'COD') {
            $('#paypal-container').attr('hidden', true)
         } else {
            $('#paypal-container').attr('hidden', false)
         }
      })

      // app js
      window.paypal
         .Buttons({
            async createOrder() {
               try {
                  if (order_id) {
                     return order_id;
                  } else {
                     const errorDetail = orderData?.details?.[0];
                     const errorMessage = errorDetail ?
                        `${errorDetail.issue} ${errorDetail.description} (${orderData.debug_id})` :
                        JSON.stringify(orderData);

                     throw new Error(errorMessage);
                  }
               } catch (error) {
                  console.error(error);
                  resultMessage(`Could not initiate PayPal Checkout...<br><br>${error}`);
               }
            },

            async onApprove(data, actions) {
               try {
                  $.ajax({
                     url: `https://api-m.sandbox.paypal.com/v2/checkout/orders/${order_id}/capture`,
                     type: "POST",
                     contentType: "application/json",
                     headers: {
                        Authorization: `Bearer ${accessToken}`,
                        // Uncomment one of these to force an error for negative testing (in sandbox mode only). Documentation:
                        // https://developer.paypal.com/tools/sandbox/negative-testing/request-headers/
                        // "PayPal-Mock-Response": '{"mock_application_codes": "INSTRUMENT_DECLINED"}'
                        // "PayPal-Mock-Response": '{"mock_application_codes": "TRANSACTION_REFUSED"}'
                        // "PayPal-Mock-Response": '{"mock_application_codes": "INTERNAL_SERVER_ERROR"}'
                     },
                     success: function(response) {
                        let orderData = response
                        console.log(orderData)
                        const errorDetail = orderData?.details?.[0];
                        if (errorDetail?.issue === "INSTRUMENT_DECLINED") {
                           // (1) Recoverable INSTRUMENT_DECLINED -> call actions.restart()
                           // recoverable state, per https://developer.paypal.com/docs/checkout/standard/customize/handle-funding-failures/
                           return actions.restart();
                        } else if (errorDetail) {
                           // (2) Other non-recoverable errors -> Show a failure message
                           throw new Error(`${errorDetail.description} (${orderData.debug_id})`);
                        } else if (!orderData.purchase_units) {
                           throw new Error(JSON.stringify(orderData));
                        } else {
                           userPaid = true
                           $('.nice-select').attr('hidden', true)
                           // (3) Successful transaction -> Show confirmation or thank you message
                           // Or go to another URL:  actions.redirect('thank_you.html');
                           const transaction =
                              orderData?.purchase_units?.[0]?.payments?.captures?.[0] ||
                              orderData?.purchase_units?.[0]?.payments?.authorizations?.[0];
                           resultMessage(
                              `Transaction ${transaction.status}: ${transaction.id}`,
                           );
                           console.log(
                              "Capture result",
                              orderData,
                              JSON.stringify(orderData, null, 2),
                           );
                        }

                     },
                     error: function(jqXHR, textStatus, errorThrown) {
                        // Handle errors here
                        console.error("Failed to capture order:", errorThrown);
                     }
                  });

               } catch (error) {
                  console.error(error);
                  resultMessage(
                     `Sorry, your transaction could not be processed...<br><br>${error}`,
                  );
               }
            },
         })
         .render("#paypal-button-container");

      // Example function to show a result to the user. Your site's UI library can be used instead.
      function resultMessage(message) {
         const container = document.querySelector("#result-message");
         container.innerHTML = message;
      }
   </script>
   <script src="<?= BASE_URL ?>public/paypal/app.js"></script>
</body>

</html>