<!doctype html>
<html lang="en">

<head>
   <title><?php echo $pageTitle ?></title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

   <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

   <link rel="stylesheet" href="<?= BASE_URL .  PUBLIC_DIR ?>/account/login/css/style.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
   <style>
      .resend-code-btn {
         font-size: 10pt;
         padding: 2px 6px;
         border-radius: 1.1rem;
         border: none;
         color: #000000db;
         font-weight: bold;
         background-color: #ffe4c475;
         transition: background-color 0.3s ease;
         min-width: 100px;
      }

      .resend-code-btn:hover {
         background-color: #ffe4c4a3;
      }

      .resend-code-btn:focus {
         outline: none;
      }

      .error-msg {
         color: firebrick;
         font-weight: bolder;
         font-size: 8pt;
         margin-left: 1rem;
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

      input[type="number"]::-webkit-inner-spin-button,
      input[type="number"]::-webkit-outer-spin-button {
         -webkit-appearance: none;
         margin: 0;
      }

      input[type="number"] {
         -moz-appearance: textfield;
         /* Firefox */
      }
   </style>
</head>

<body class="img" style="background-image: url(<?= BASE_URL .  PUBLIC_DIR ?>/account/login/images/bg.jpg);">
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
                  <div class="form-group m-0 mb-5">
                     <input id="verification_code" max="999999" type="number" class="form-control text-center" placeholder="verification code" required>
                  </div>
                  <div class="form-group">
                     <button id="send_code" type="button" class="form-control btn btn-primary submit px-3">Submit
                        code</button>
                  </div>
                  <div class="d-flex justify-content-end">
                     <button class="resend-code-btn py-1">Resend code</button>
                  </div>
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
      $('#send_code').on('click', function() {
         $('#send_code').html('<div class="lds-facebook"><div></div><div></div><div></div></div>')
         $('.resend-code-btn').prop('disabled', true);
         $('#send_code').prop('disabled', true);
         if ($('#verification_code').val().length == 0) {
            $('#send_code').html('<span class="text-danger fw-bold">Enter a code.</span>')
            $('.resend-code-btn').prop('disabled', false);
            $('#send_code').prop('disabled', false);
         } else if ($('#verification_code').val().length != 6) {
            $('#send_code').html('<span class="text-danger fw-bold">Enter a valid 6-digit code.</span>')
            $('.resend-code-btn').prop('disabled', false);
            $('#send_code').prop('disabled', false);
         } else
            axios.get('<?= BASE_URL ?>' + 'c_api/verify_code/' + '<?= $email ?>/' + $('#verification_code').val(), {
               params: {}
            })
            .then(function(response) {
               setTimeout(function() {
                  console.log(response.data)
                  if (response.data == '1') {
                     window.location.href = "<?= BASE_URL ?>account/login";
                  } else {
                     $('#send_code').html('<span class="text-danger fw-bold">Incorrect 6-digit code.</span>')
                     $('.resend-code-btn').prop('disabled', false);
                     $('#send_code').prop('disabled', false);
                  }
               }, 1000);
            })
            .catch(function(error) {
               console.log(error);
            })
            .finally(function() {
               // always executed
            });

      })

      $(document).ready(function() {
         axios.get('<?= BASE_URL ?>' + 'c_api/resend_code/' + '<?= $email ?>', {
            params: {}
         })
      })

      $('.resend-code-btn').on('click', function() {
         $('#send_code').prop('disabled', true);
         $('.resend-code-btn').prop('disabled', true);
         $('.resend-code-btn').html('<i class="py-1 fas fa-spinner fa-spin"></i>')
         axios.get('<?= BASE_URL ?>' + 'c_api/resend_code/' + '<?= $email ?>', {
               params: {}
            })
            .then(function(response) {
               setTimeout(function() {
                  console.log(response)
                  $('#send_code').prop('disabled', false);
                  $('.resend-code-btn').prop('disabled', false);
                  $('.resend-code-btn').html('Resend code')
               }, 1000);
            })
            .catch(function(error) {
               console.log(error);
            })
            .finally(function() {
               // always executed
            });
      })
   </script>

</body>

</html>