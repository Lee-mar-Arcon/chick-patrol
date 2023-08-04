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
   <style>
      .help-text {
         height: .80rem;
      }
   </style>
</head>

<body>

   <?php include 'components/top-navigation.php' ?>
   <!-- Header Section End -->

   <section class="checkout spad">
      <div class="container">
         <div class="p-3">
            <div class="row">
               <div class="h3 col-12 mb-3">Basic Information</div>
               <!-- first name -->
               <div class="col-sm-12 col-lg-6">
                  <div class="checkout__input">
                     <label for="first_name">First Name<span class="text-danger"> *</span></label>
                     <input value="<?= $user['first_name'] ?>" name="first_name" id="first_name" type="text">
                     <small id="first_name_help_text" class="form-text text-danger help-text"></small>
                  </div>
               </div>

               <!-- middle name -->
               <div class="col-sm-12 col-lg-6">
                  <div class="checkout__input">
                     <label for="middle_name">Middle Name</label>
                     <input value="<?= $user['middle_name'] ?>" name="middle_name" id="middle_name" type="text">
                     <small id="middle_name_help_text" class="form-text text-danger help-text"></small>
                  </div>
               </div>

               <!-- last name -->
               <div class="col-sm-12 col-lg-6">
                  <div class="checkout__input">
                     <label for="last_name">Last Name<span class="text-danger"> *</span></label>
                     <input value="<?= $user['last_name'] ?>" name="last_name" id="last_name" type="text">
                     <small id="last_name_help_text" class="form-text text-danger help-text"></small>
                  </div>
               </div>

               <!-- birth date -->
               <div class="col-sm-12 col-lg-6">
                  <div class="checkout__input">
                     <label for="birth_date">Birthdate<span class="text-danger"> *</span></label>
                     <input value="<?= $user['birth_date'] ?>" name="birth_date" id="birth_date" type="date">
                     <small id="birth_date_help_text" class="form-text text-danger help-text"></small>
                  </div>
               </div>

               <!-- sex -->
               <div class="col-sm-12 col-lg-6 mb-3">
                  <label for="sex">Sex<span class="text-danger"> *</span></label>
                  <div class="checkout__input">
                     <select name="sex" id="sex">
                        <option value="Female" <?= $user['sex'] == 'Female' ? 'selected' : '' ?>>Female</option>
                        <option value="Male" <?= $user['sex'] != 'Female' ? 'selected' : '' ?>>Male</option>
                     </select>
                  </div>
                  <small id="sex_help_text" class="form-text text-danger help-text"></small>
               </div>

               <!-- contact number -->
               <div class="col-sm-12 col-lg-6">
                  <div class="checkout__input">
                     <label for="contact">Contact Number<span class="text-danger"> *</span></label>
                     <input value="<?= $user['contact'] ?>" name="contact" id="contact" type="text">
                     <small id="contact_help_text" class="form-text text-danger help-text"></small>
                  </div>
               </div>

               <div class="h3 col-12 mt-5 mb-3">Address</div>
               <!-- barangay -->
               <div class="col-sm-12 col-lg-6 mb-3">
                  <label for="barangay">Barangay<span class="text-danger"> *</span></label>
                  <div class="checkout__input">
                     <select name="barangay" id="barangay">
                        <?php foreach ($barangays as $barangay) : ?>
                           <option <?= ($user['barangay'] == $LAVA->m_encrypt->decrypt($barangay['id'])) ? 'selected' : '' ?> value="<?= $barangay['id'] ?>"><?= $barangay['name'] ?></option>
                        <?php endforeach; ?>
                     </select>
                  </div>
                  <small id="barangay_help_text" class="form-text text-danger help-text"></small>
               </div>

               <!-- street -->
               <div class="col-sm-12 col-lg-6">
                  <div class="checkout__input">
                     <label for="street">Street<span class="text-danger"> *</span></label>
                     <input value="<?= $user['street'] ?>" name="street" id="street" type="text">
                     <small id="street_help_text" class="form-text text-danger help-text"></small>
                  </div>
               </div>

               <!-- email address -->
               <div class="col-sm-12 col-lg-6">
                  <div class="checkout__input">
                     <label for="email">Email<span class="text-danger"> *</span></label>
                     <input value="<?= $user['email'] ?>" name="email" id="email" type="text">
                     <small id="email_help_text" class="form-text text-danger help-text"></small>
                  </div>
               </div>

               <div class="h3 col-12 mt-5 mb-3">Password</div>

               <!-- password -->
               <div class="col-sm-12 col-lg-6">
                  <div class="checkout__input">
                     <label for="old_password">Password<span class="text-danger"> *</span></label>
                     <input name="old_password" id="old_password" type="text">
                     <small id="old_password_help_text" class="form-text text-danger help-text"></small>

                  </div>
               </div>

               <!-- new-password -->
               <div class="col-sm-12 col-lg-6">
                  <div class="checkout__input">
                     <label for="new_password">New password<span class="text-danger"> *</span></label>
                     <input name="new_password" id="new_password" type="text">
                     <small id="new_password_help_text" class="form-text text-danger help-text"></small>
                  </div>
               </div>

               <div class="col-sm-12 col-lg-6">
               </div>

               <!-- password -->
               <div class="col-sm-12 col-lg-6">
                  <div class="checkout__input">
                     <label for="retype_new_password">Retype new password<span class="text-danger"> *</span></label>
                     <input name="retype_new_password" id="retype_new_password" type="text">
                     <small id="retype_new_password_help_text" class="form-text text-danger help-text"></small>
                  </div>
               </div>
            </div>
            <div class="d-flex justify-content-end">   
               <button type="submit" class="site-btn update-button">Update Account</button>
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
   <!-- toastify -->
   <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>


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