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
   <style>
      .status-select {
         background-color: #7fad39;
      }

      .action-color {
         color: #7fad39;
      }
   </style>
</head>

<body>

   <?php include 'components/top-navigation.php' ?>
   <!-- Header Section End -->

   <section class="checkout spad">
      <div class="container px-5">
         <div class="d-flex justify-content-end">
            <div class="mb-3 p-1 status-select rounded">
               <select class="form-select form-select-lg border-0" id="cart-status">
                  <option value="all">All</option>
                  <option value="for acceptance">For Acceptance</option>
                  <option value="rejected">Rejected</option>
                  <option value="on delivery">On Delivery</option>
                  <option value="finished">Finished</option>
               </select>
            </div>
         </div>
         <div class="table-responsive">

            <table class="table table-borderless" id="cart-table">
               <thead>
                  <tr style="background-color: #9aff0047;">
                     <th scope="col">Transaction ID</th>
                     <th scope="col" class="text-center" style="width: 200px;">Date Checked Out</th>
                     <th scope="col" class="text-center" style="width: 120px;">Status</th>
                     <th scope="col" class="text-center" style="width: 100px;">Action</th>
                  </tr>
               </thead>
               <tbody>

               </tbody>
            </table>
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
         console.log($('#cart-status').val())
         fetchCartList()
      })

      function updateCartBadge() {
         $.post('<?= site_url('customer_api/get_cart_total') ?>', {})
            .then(function(response) {
               $('.fa-shopping-bag').next().html('0')
               if (parseInt(response))
                  $('.fa-shopping-bag').next().html(response)
            })
      }

      $('#cart-status').on('change', function() {
         fetchCartList()
      })

      function fetchCartList() {
         $.post('<?= site_url('customer_api/get_user_cart') ?>', {
               status: $('#cart-status').val()
            })
            .then(function(response) {
               console.log(response)
               populateTable(response)
            })
      }

      function populateTable(rows) {
         $('#cart-table tbody').html('')
         if (rows.length > 0)
            for (let i = 0; i < rows.length; i++) {
               $('#cart-table tbody').append(`
                  <tr>
                     <td scope="row">${rows[i]['id']}</td>
                     <td class="text-center">${rows[i]['for_approval_at']}</td>
                     <td class="text-center">${rows[i]['status']}</td>
                     <td class="text-center"><i class="fas fa-eye action-color" style="cursor: pointer;"></i></td>
                  </tr>
               `)
            }
         else [
            $('#cart-table tbody').append(`
                  <tr>
                     <td colspan="4" class="text-center">No cart available</td>
                  </tr>
               `)
         ]
      }
   </script>
</body>

</html>