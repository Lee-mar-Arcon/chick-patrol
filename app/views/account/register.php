<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');
$LAVA = lava_instance();

$LAVA->session->flashdata('formData') ? $formData = $LAVA->session->flashdata('formData') : '';
$barangays = array(
   0 => array(
      'id' => 1,
      'name' => 'barangay 1'
   ),
   1 => array(
      'id' => 2,
      'name' => 'barangay 2'
   ),
   2 => array(
      'id' => 3,
      'name' => 'barangay 3'
   ),
)
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
      .error-msg {
         color: firebrick;
         font-weight: bolder;
         font-size: 8pt;
         margin-left: 1rem;
      }

      label {
         color: aliceblue;
         font-size: 9pt;
         margin: 0px;
         margin-left: 1rem;

      }

      .required {
         color: firebrick;
      }

      .section-header {
         font-size: medium;
         color: white;
      }

      select.form-control {
         -webkit-appearance: none;
         appearance: none;
      }

      select.form-control option {
         color: white;
         font-weight: bold;
         background-color: rgb(0 0 0 / 60%);
      }

      select.form-control option:hover {
         color: black;
         font-weight: bold;
         background-color: white;
      }

      input[type="date"]::-webkit-calendar-picker-indicator {
         filter: invert(1);
         /* Inverts the color of the icon */
      }

      .error-message {
         font-weight: bold;
         color: #ff5722;
         background-color: #ffffff14;
         padding: .5rem 1rem;
         margin-bottom: 1.2rem;
         border-radius: 25px;
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
         <form class="row justify-content-start px-4" action="<?= BASE_URL ?>account/handle-register-submit"
            method="post">
            <div class="col-sm-12 col-md-6 offset-md-3">
               <div class="row justify-content-between">
                  <div class="col-12">

                     <?= $LAVA->session->flashdata('errorMessage') ? '<div class="error-message">' .$LAVA->session->flashdata('errorMessage'). '</div>' : '' ?>
                  </div>
                  <div class="form-group pb-1 col">
                     <label for="firstName">First name <span class="required">*</span></label>
                     <input id="firstName" name="firstName" type="text" class="form-control" required
                        value="<?= isset($formData) ? $formData['firstName'] : '' ?>">
                     <!-- <div class="error-msg">Email does not exists</div> -->
                  </div>
                  <div class="form-group pb-1 col">
                     <label for="middleName">Middle name</label>
                     <input id="middleName" name="middleName" type="text" class="form-control"
                        value="<?= isset($formData) ? $formData['middleName'] : '' ?>">
                  </div>
               </div>
            </div>

            <div class="col-sm-12 col-md-6 offset-md-3">
               <div class="row justify-content-between">
                  <div class="form-group pb-1 col">
                     <label for="lastName">Last name <span class="required">*</span></label>
                     <input id="lastName" name="lastName" type="text" class="form-control" required
                        value="<?= isset($formData) ? $formData['lastName'] : '' ?>">
                     <!-- <div class="error-msg">Email does not exists</div> -->
                  </div>
                  <div class="form-group pb-1 col">
                     <label for="contact">Contact number<span class="required">*</span></label>
                     <input id="contact" name="contact" type="text" class="form-control" maxlength="11"
                        pattern="09\d{9}" title="format: 09xxxxxxxxx" required
                        value="<?= isset($formData) ? $formData['contact'] : '' ?>">
                     <!-- <div class="error-msg">Email does not exists</div> -->
                  </div>
               </div>
            </div>

            <div class="col-sm-12 col-md-6 offset-md-3">
               <div class="row justify-content-between">
                  <div class="form-group pb-1 col">
                     <label for="barangay">Baragay <span class="required">*</span></label>
                     <select id="barangay" name="barangay" type="text" class="form-control" required
                        value="<?= isset($formData) ? $formData['barangay'] : '' ?>">
                        <?php foreach ($barangays as $barangay) { ?>
                        <option value="<?= $barangay['id'] ?>"
                           <?= isset($formData) ? ($formData['barangay'] == $barangay['id'] ? 'selected' : '') : '' ?>>
                           <?= $barangay['name'] ?></option>
                        <?php } ?>
                     </select>
                     <!-- <div class="error-msg">Email does not exists</div> -->
                  </div>
                  <div class="form-group pb-1 col">
                     <label for="street">Street <span class="required">*</span></label>
                     <input id="street" name="street" type="text" class="form-control" required
                        value="<?= isset($formData) ? $formData['street'] : '' ?>">
                     <!-- <div class="error-msg">Email does not exists</div> -->
                  </div>
               </div>
            </div>

            <div class="col-sm-12 col-md-6 offset-md-3">
               <div class="row justify-content-between">
                  <div class="form-group pb-1 col">
                     <label for="birthDate">Birthdate <span class="required">*</span></label>
                     <input id="birthDate" name="birthDate" type="date" class="form-control" required
                        value="<?= isset($formData) ? $formData['birthDate'] : '' ?>">
                     <!-- <div class="error-msg">Email does not exists</div> -->
                  </div>
                  <div class="form-group pb-1 col">
                     <label for="sex">Sex <span class="required">*</span></label>
                     <select id="sex" name="sex" type="text" class="form-control" required
                        value="<?= isset($formData) ? $formData['sex'] : '' ?>">
                        <option value="Male"
                           <?= isset($formData) ? ($formData['sex'] == 'Male' ? 'selected' : '') : '' ?>>Male</option>
                        <option value="Female"
                           <?= isset($formData) ? ($formData['sex'] == 'Female' ? 'selected' : '') : '' ?>>Female
                        </option>
                     </select>
                     <!-- <div class="error-msg">Email does not exists</div> -->
                  </div>

                  <div class="form-group pb-1 col-12">
                     <label for="email">Email <span class="required">*</span></label>
                     <input id="email" name="email" type="email" class="form-control"
                        pattern="[a-zA-Z0-9._%+-]+@gmail\.com$" title="Please enter a valid Gmail address"
                        value="<?= isset($formData) ? $formData['email'] : '' ?>" required>
                     <!-- <div class="error-msg">Email does not exists</div> -->
                  </div>
               </div>
               <div class="form-group pb-1 col-12 p-0 mt-3">
                  <button type="submit" class="form-control btn btn-primary submit px-3">Sign In</button>
               </div>
            </div>
         </form>
      </div>
   </section>

   <script src="<?= BASE_URL .  PUBLIC_DIR ?>/account/login/js/jquery.min.js"></script>
   <script src="<?= BASE_URL .  PUBLIC_DIR ?>/account/login/js/popper.js"></script>
   <script src="<?= BASE_URL .  PUBLIC_DIR ?>/account/login/js/bootstrap.min.js"></script>
   <script src="<?= BASE_URL .  PUBLIC_DIR ?>/account/login/js/main.js"></script>
   </script>
</body>

</html>