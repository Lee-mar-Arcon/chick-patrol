<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');
$LAVA = lava_instance();
$LAVA->session->flashdata('error') ? $error = $LAVA->session->flashdata('error') : null;
?>
<!doctype html>
<html lang="en">

<head>
   <title><?php echo $pageTitle ?></title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

   <link rel="stylesheet" href="<?= BASE_URL .  PUBLIC_DIR ?>/account/login/css/style.css">
   <style>
      .error-message {
         font-weight: bold;
         color: #ff5722;
         background-color: #ffffff14;
         padding: .5rem 1rem;
         margin-bottom: 1.2rem;
         border-radius: 25px;
      }

      .lds-facebook {
         display: inline-block;
         position: relative;
         width: 40px;
         height: 40px;
      }

      .lds-facebook div {
         display: inline-block;
         position: absolute;
         left: 4px;
         width: 8px;
         background: #00000094;
         animation: lds-facebook 1.2s cubic-bezier(0, 0.5, 0.5, 1) infinite;
      }

      .lds-facebook div:nth-child(1) {
         left: 4px;
         animation-delay: -0.24s;
      }

      .lds-facebook div:nth-child(2) {
         left: 16px;
         animation-delay: -0.12s;
      }

      .lds-facebook div:nth-child(3) {
         left: 28px;
         animation-delay: 0;
      }

      @keyframes lds-facebook {
         0% {
            top: 4px;
            height: 32px;
         }

         50%,
         100% {
            top: 12px;
            height: 16px;
         }
      }
   </style>
</head>

<body class="img" style="background-image: url(<?= BASE_URL .  PUBLIC_DIR ?>/account/login/Images/bg.jpg);">
   <section class="ftco-section">
      <div class="container">
         <div class="row justify-content-center">
            <div class="col-md-6 text-center mb-5">
               <img src="<?= BASE_URL . PUBLIC_DIR ?>/logo.png" alt="" height="150px">
            </div>
         </div>
         <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
               <div class="login-wrap p-0">
                  <h3 class="mb-4 text-center">Reset password </h3>
                  <?= isset($error) ? '<div class="error-message">' . $error . '</div>' : '' ?>
                  <form method="post" action="<?= BASE_URL ?>account/handle_reset_password_submit/<?= $encryptedEmail ?>" class="signin-form">
                     <div class="form-group">
                        <input required type="password" name="password" class="form-control" placeholder="password">
                        <div class="error-msg"></div>
                     </div>
                     <div class="form-group">
                        <input required type="password" name="retype_password" class="form-control" placeholder="retype-password">
                        <div class="error-msg"></div>
                     </div>
                     <div class="form-group">
                        <button id="submit_forgot_password_link" class="form-control btn btn-primary submit px-3">Save</button>
                     </div>
                     <div class="form-group d-flex justify-content-end">
                        <a href="<?= site_url('account/login') ?>" class="me-5">Go to Login</a>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </section>


   <script src="<?= BASE_URL .  PUBLIC_DIR ?>/account/login/js/jquery.min.js"></script>
   <script src="<?= BASE_URL .  PUBLIC_DIR ?>/account/login/js/popper.js"></script>
   <script src="<?= BASE_URL .  PUBLIC_DIR ?>/account/login/js/bootstrap.min.js"></script>
   <script src="<?= BASE_URL .  PUBLIC_DIR ?>/account/login/js/main.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
   <script>
      $('#submit_forgot_password_link').on('click', function() {
         let email = $('#email').val()
         if (email.length == 0) {
            $('#submit_forgot_password_link').html('<span class="text-dark">Enter an email</span>')
         } else {
            $('#email').prop('disabled', true);
            $(this).html('<div class="lds-facebook"><div></div><div></div><div></div></div>')
            $(this).prop('disabled', true)

            axios.get('<?= BASE_URL ?>c_api/send_forgot_password_link/' + email, {
                  params: {}
               })
               .then(function(response) {
                  setTimeout(function() {
                     if (response.data == "User does not exists.") {
                        $('.error-msg').html(response.data);
                        $('#submit_forgot_password_link').html('Get link')
                     } else {
                        if (response.data) {
                           $('.error-msg').html('');
                           $('#submit_forgot_password_link').html('Link sent!')
                        } else {
                           $('.error-msg').html('Link not sent. try again.');
                           $('#submit_forgot_password_link').html('Get link')
                        }
                     }
                     // $('#send_code').prop('disabled', false);
                     // $('.resend-code-btn').prop('disabled', false);
                     // $('.resend-code-btn').html('Resend code')
                  }, 1);
                  $('#email').prop('disabled', false)
                  $('#submit_forgot_password_link').prop('disabled', false)
               })
               .catch(function(error) {
                  console.log(error);
               })
               .finally(function() {
                  // always executed
               });
         }

      })
   </script>
</body>

</html>