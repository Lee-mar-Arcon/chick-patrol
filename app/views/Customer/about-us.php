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
   <!-- icons -->
   <link href="<?= BASE_URL . PUBLIC_DIR ?>/admin/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
   <!-- leaflet -->
   <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
</head>

<body>

   <?php include 'components/top-navigation.php' ?>
   <!-- Header Section End -->

   <section class="featured spad">
      <div class="container">
         <div class="row">
            <div class="col-12">
               <div id="products-list" class="section-title pt-5">
                  <h2>About Us</h2>
               </div>
               <div style="line-height: 2rem; text-align: justify;">
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Chix Patrol Diners began at 2021 with the help of its founder, Marc Sonny Timbang. It is located at 2nd Floor Tarlac Capitol Center, Macabulos Drive, Barangay San Roque, City of Tarlac, Tarlac, Philippines. Chix Patrol Diners is a vibrant culinary haven that delights diners with its fusion of contemporary and classic flavors. Nestled in the heart of a bustling city, the restaurant's warm and inviting ambiance sets the stage for an unforgettable dining experience. Renowned for its innovative approach to poultry, Chix Patrol Diners elevates chicken to new heights, offering a diverse menu that caters to a wide range of palates. From mouthwatering grilled dishes to indulgent comfort food, each plate is a symphony of textures and tastes that reflect the culinary expertise of the chefs. With attentive service and an eclectic decor that seamlessly blends rustic charm with modern aesthetics, Chix Patrol Diners is a destination where food enthusiasts gather to savor both tradition and innovation in every delectable bite.
               </div>
            </div>
            <div class="col-12">
               <div id="products-list" class="section-title pt-4">
                  <h2>Our Location</h2>
               </div>
            </div>
            <div class="col-lg-12">
               <div id="map" style="max-width: auto; height: 500px"></div>
            </div>
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
   <!-- leaflet -->
   <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

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

      var map = L.map('map').setView([15.481381, 120.589081], 40);
      L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
         attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
      }).addTo(map);
      L.marker([15.481381, 120.589081]).addTo(map)
         .bindPopup('Chixp patrol')
         .openPopup();
   </script>
</body>

</html>