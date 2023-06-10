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
      .error-msg {
         color: firebrick;
         font-weight: bolder;
         font-size: 8pt;
         margin-left: 1rem;
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
                  <form action="#" class="signin-form">
                     <div class="form-group">
                        <input type="email" class="form-control" placeholder="Email" required>
                        <div class="error-msg">Email does not exists</div>
                     </div>
                     <div class="form-group m-0">
                        <input id="password-field" type="password" class="form-control" placeholder="Password" required>
                        <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                     </div>
                     <div class="form-group d-flex justify-content-between mb-5">
                        <div class="error-msg">Wrong password</div>
                        <a href="<?= site_url('account/forgot-password') ?>">Forgot Password</a>
                     </div>
                     <div class="form-group">
                        <button type="submit" class="form-control btn btn-primary submit px-3">Sign In</button>
                     </div>
                  </form>
                  <h6 class="mb-4 text-center">Dont have an account yet? <a href="<?= site_url('account/register') ?>">&nbsp; <span>click here.</span></a></h6>
               </div>
            </div>
         </div>
      </div>
   </section>

   <script src="<?= BASE_URL .  PUBLIC_DIR ?>/account/login/js/jquery.min.js"></script>
   <script src="<?= BASE_URL .  PUBLIC_DIR ?>/account/login/js/popper.js"></script>
   <script src="<?= BASE_URL .  PUBLIC_DIR ?>/account/login/js/bootstrap.min.js"></script>
   <script src="<?= BASE_URL .  PUBLIC_DIR ?>/account/login/js/main.js"></script>

</body>

</html>