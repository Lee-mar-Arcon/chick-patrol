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

   <section class="featured spad">
      <div class="container">
         <div class="row">
            <div class="col-lg-12">
               <div id="products-list" class="section-title pt-4">
                  <h2>Our Products</h2>
               </div>
               <div class="featured__controls">
                  <ul>
                  </ul>
               </div>
            </div>
         </div>
         <div class="row featured__filter">
            <?php foreach ($categoryProducts as $categoryProduct) { ?>

               <div class="col-lg-3 col-md-4 col-sm-6 mix <?= str_replace(' ', '', $categoryProduct['category_name']) ?>">
                  <div class="featured__item">
                     <div class="featured__item__pic set-bg" data-setbg="<?= BASE_URL . PUBLIC_DIR . '/images/products/cropped/' .  $categoryProduct['image'] ?>">
                        <?= !($categoryProduct['available_quantity'] == 0 || $categoryProduct['available_quantity'] == null) ?
                           '<ul class="featured__item__pic__hover">
                           <li>
                              <a onclick="return false">
                                 <div style="cursor: pointer;" data-id="' . $categoryProduct['id'] . '" class="add-to-cart">
                                    <i class="fa fa-shopping-cart cursor-pointer"></i>
                                 </div>
                              </a>
                           </li>
                           <li>
                              <a href="' . site_url('customer/view-product/') . $categoryProduct['id'] . '">
                                 <div v style="cursor: pointer;" data-id="' . $categoryProduct['id'] . '">
                                    <i class="fa fa-eye cursor-pointer"></i>
                                 </div>
                              </a>
                           </li>
                        </ul>' : ''
                        ?>
                     </div>
                     <div class="featured__item__text">
                        <?= $categoryProduct['available_quantity'] == 0 || $categoryProduct['available_quantity'] == null ? '<h1 class="badge badge-danger">Unavailable</h1>' : '' ?>

                        <h6><a href="#"><?= $categoryProduct['name'] ?></a></h6>
                        <h5>₱ <?= number_format($categoryProduct['price'], 2) ?></h5>
                     </div>
                  </div>
               </div>
            <?php } ?>
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
         $('.set-bg').each(function() {
            var bg = $(this).data('setbg');
            $(this).css('background-image', 'url(' + bg + ')');
         });
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
            gravity: "top",
            position: "right",
            stopOnFocus: true,
            style: {
               background: color,
            },
         }).showToast();
      }
   </script>
</body>

</html>