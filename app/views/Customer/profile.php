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
                           <option <?= ($user['barangay'] == $LAVA->M_encrypt->decrypt($barangay['id'])) ? 'selected' : '' ?> value="<?= $barangay['id'] ?>"><?= $barangay['name'] ?></option>
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
                     <input name="old_password" id="old_password" type="password">
                     <small id="old_password_help_text" class="form-text text-danger help-text"></small>

                  </div>
               </div>

               <!-- new-password -->
               <div class="col-sm-12 col-lg-6">
                  <div class="checkout__input">
                     <label for="new_password">New password<span class="text-danger"> *</span></label>
                     <input disabled name="new_password" id="new_password" type="password">
                     <small id="new_password_help_text" class="form-text text-danger help-text"></small>
                  </div>
               </div>

               <div class="col-sm-12 col-lg-6">
               </div>

               <!-- retype new password -->
               <div class="col-sm-12 col-lg-6">
                  <div class="checkout__input">
                     <label for="retype_new_password">Retype new password<span class="text-danger"> *</span></label>
                     <input disabled name="retype_new_password" id="retype_new_password" type="password">
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


   <div class="modal fade" id="mailNotificationReminder" data-bs-backdrop="" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg rounded" role="document">
         <div class="modal-content border-0 rounded-0 rounded-top">
            <form action="<?= site_url('Admin/Add_Marketer') ?>" method="POST">
               <div class="modal-body p-0">
                  <div class="text-white d-flex justify-content-between m-0 p-3 pb-0 border-0">
                     <div></div>
                     <h5 class="h3 text-dark fw-bold" id="staticBackdropLabel">Mail Changing Reminder</h5>
                     <i class="fas fa-times-circle align-content-center text-dark" data-dismiss="modal" aria-label="Close" style="font-size: 1.5rem; cursor:pointer"></i>
                  </div>
                  <div class="container-fluid p-4 pt-0">
                     <div class="d-flex justify-content-center py-5 my-3">
                        <div class="h4 fw-bold"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; To completely change your account bounded email and for security purpose. We sent an email to your new gmail address to verify that the new email is yours. Please check it before the link expires.</div>
                     </div>
                  </div>
               </div>
         </div>
         <div class="modal-footer border-0 bg-white">
            <!-- <button type="button" class="btn-receive rounded-0 primary-btn border-0" id="">Rate</button> -->
            <button type="button" class="btn-close rounded-0 px-4 py-2 secondary-btn border-0" data-dismiss="modal">Close</button>
         </div>
         </form>
      </div>
   </div>


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

      $('.update-button').on('click', function() {
         let element = $(this)
         element.html('<i class="mdi mdi-spin mdi-loading"></i>').attr('disabled', true)
         $.post('<?= site_url('customer_api/update-account') ?>', {
               first_name: $('#first_name').val(),
               middle_name: $('#middle_name').val(),
               last_name: $('#last_name').val(),
               birth_date: $('#birth_date').val(),
               sex: $('#sex').val(),
               contact: $('#contact').val(),
               barangay: $('#barangay').val(),
               street: $('#street').val(),
               email: $('#email').val(),
               old_password: $('#old_password').val(),
               new_password: $('#new_password').val(),
               new_password: $('#new_password').val(),
               retype_new_password: $('#retype_new_password').val(),
            })
            .then(function(response) {
               console.log(response)
               if (typeof response === 'object' && !Array.isArray(response) && response !== null) {
                  showToast('Some fields are invalid please double check your information.', "linear-gradient(to right, #ac1414, #f12b00)", 3000)
                  showErrors(response)
               } else {
                  $('.help-text').html('')
                  responseValidation(response)
               }
               element.html('update account').attr('disabled', false)
            }).catch(function(error) {
               console.log(error);
               element.html('update account').attr('disabled', false)
            })
      })

      function responseValidation(response) {
         switch (response) {
            case 'new password required':
               showToast('New password is required', "linear-gradient(to right, #ac1414, #f12b00)")
               break;
            case 'old password required':
               showToast('Old password is required', "linear-gradient(to right, #ac1414, #f12b00)")
               break;
            case 'incorrect old password':
               showToast('Incorrect old password', "linear-gradient(to right, #ac1414, #f12b00)")
               break;
            case 'new password must be the same':
               showToast('New Password must be the same', "linear-gradient(to right, #ac1414, #f12b00)")
               break;
            case 'new password must be 8-16 characters.':
               showToast('New password must be 8-16 characters.', "linear-gradient(to right, #ac1414, #f12b00)")
               break;
            case 'email is not a valid Gmail address.':
               showToast('Email is not a valid Gmail address.', "linear-gradient(to right, #ac1414, #f12b00)")
               break;
            case 'sending email failed':
               showToast('Sending changing email verification failed.', "linear-gradient(to right, #ac1414, #f12b00)")
               break;
            case 'mail sent and updated':
               showToast('Sending changing email verification failed.', "linear-gradient(to right,  #3ab902, #14ac34)")
               $('#mailNotificationReminder').modal('show')
               break;
            case true:
               showToast('Profile Updated', "linear-gradient(to right, #3ab902, #14ac34)")
               clearPasswordFields()
               break;
         }
      }

      function showErrors(errors) {
         $('.help-text').html('')
         for (let key in errors) {
            $('#' + key).next().html(errors[key])
         }
      }

      function showToast(message, backgroundColor, duration = 1500) {
         Toastify({
            text: message,
            duration: duration,
            newWindow: true,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
            style: {
               background: backgroundColor,
            },
         }).showToast();
      }

      $('#old_password').on('input', function() {
         if ($(this).val().length == 0) {
            $('#new_password').attr('disabled', true)
            $('#retype_new_password').attr('disabled', true)
            $('#new_password').val('')
            $('#retype_new_password').val('')
         } else {
            $('#new_password').attr('disabled', false)
            $('#retype_new_password').attr('disabled', false)
         }
      })

      function clearPasswordFields() {
         $("#old_password").val('')
         $("#new_password").val('')
         $("#retype_new_password").val('')
      }
   </script>
</body>

</html>