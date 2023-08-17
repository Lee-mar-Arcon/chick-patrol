<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');
$LAVA = lava_instance();

// form validation response data
$LAVA->session->flashdata('formMessage') ? $formMessage = $LAVA->session->flashdata('formMessage') : $formMessage = null;
$LAVA->session->flashdata('formData') ? $formData = $LAVA->session->flashdata('formData') : $formData = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?= $pageTitle ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App css -->
    <link href="<?= BASE_URL . PUBLIC_DIR ?>/admin/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <!-- icons -->
    <link href="<?= BASE_URL . PUBLIC_DIR ?>/admin/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- toastify -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <!-- Sweet alert -->
    <link href="<?= BASE_URL . PUBLIC_DIR ?>/admin/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />


</head>

<!-- body start -->

<body class="loading" data-layout-color="light" data-layout-mode="default" data-layout-size="fluid" data-topbar-color="light" data-leftbar-position="fixed" data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='false'>
    <!-- Begin page -->
    <div id="wrapper">
        <?php include 'components/top-navigation.php' ?>
        <?php include 'components/side-navigation.php' ?>

        <div class="content-page">
            <div class="content">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h3 class="">Basic Information</h3>

                                <div class="row">
                                    <!-- first_name  -->
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <label for="first_name" class="form-label">First Name <span class="text-danger"> *</span></label>
                                        <input value="<?= $user['first_name'] ?>" type="text" name="first_name" id="first_name" class="form-control">
                                        <span class="help-block text-danger ms-1"><small></small></span>
                                    </div>

                                    <!-- middle name -->
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <label for="middle_name" class="form-label">Middle Name</label>
                                        <input value="<?= $user['middle_name'] ?>" type="text" name="middle_name" id="middle_name" class="form-control">
                                        <span class="help-block text-danger ms-1"><small></small></span>
                                    </div>

                                    <!-- last_name -->
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <label for="last_name" class="form-label">Last Name <span class="text-danger"> *</span></label>
                                        <input value="<?= $user['last_name'] ?>" type="text" name="last_name" id="last_name" class="form-control">
                                        <span class="help-block text-danger ms-1"><small></small></span>
                                    </div>

                                    <!-- birth_date -->
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="birth_date" class="form-label">Date <span class="text-danger"> *</span></label>
                                            <input value="<?= $user['birth_date'] ?>" class="form-control" id="birth_date" type="date" name="birth_date">
                                            <span class="help-block text-danger ms-1"><small></small></span>
                                        </div>
                                    </div>

                                    <!-- sex -->
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="sex" class="form-label">Sex <span class="text-danger"> *</span></label>
                                            <select class="form-select" id="sex">
                                                <option <?= $user['sex'] != 'Female' ? 'selected' : '' ?> value="Male">Male</option>
                                                <option <?= $user['sex'] == 'Female' ? 'selected' : '' ?> value="Female">Female</option>
                                            </select>
                                            <span class="help-block text-danger ms-1"><small></small></span>
                                        </div>
                                    </div>

                                    <!-- contact -->
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <label for="contact" class="form-label">Contact <span class="text-danger"> *</span></label>
                                        <input value="<?= $user['contact'] ?>" type="text" name="contact" id="contact" class="form-control">
                                        <span class="help-block text-danger ms-1"><small></small></span>
                                    </div>
                                </div>

                                <h3 class="">Address</h3>
                                <div class="row">
                                    <!-- barangay -->
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="mb-3">
                                            <label for="barangay" class="form-label">Barangay <span class="text-danger"> *</span></label>
                                            <select class="form-select" id="barangay">
                                                <?php foreach ($barangays as $barangay) :  ?>
                                                    <option <?= $user['barangay'] == $LAVA->M_encrypt->decrypt($barangay['id']) ? 'selected' : '' ?> value="<?= $barangay['id'] ?>"><?= $barangay['name'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <span class="help-block text-danger ms-1"><small></small></span>
                                        </div>
                                    </div>

                                    <!-- street -->
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <label for="street" class="form-label">Street <span class="text-danger"> *</span></label>
                                        <input value="<?= $user['street'] ?>" type="text" name="street" id="street" class="form-control">
                                        <span class="help-block text-danger ms-1"><small></small></span>
                                    </div>

                                    <!-- email -->
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <label for="email" class="form-label">Email <span class="text-danger"> *</span></label>
                                        <input value="<?= $user['email'] ?>" type="email" name="email" id="email" class="form-control">
                                        <span class="help-block text-danger ms-1"><small></small></span>
                                    </div>
                                </div>

                                <h3 class="">Password</h3>

                                <div class="row">
                                    <!-- old_password -->
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <label for="old_password" class="form-label">Old Password <span class="text-danger"> *</span></label>
                                        <input type="password" name="old_password" id="old_password" class="form-control">
                                        <span class="help-block text-danger ms-1"><small></small></span>
                                    </div>

                                    <!-- new_password -->
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <label for="new_password" class="form-label">New Password <span class="text-danger"> *</span></label>
                                        <input disabled type="password" name="new_password" id="new_password" class="form-control">
                                        <span class="help-block text-danger ms-1"><small></small></span>
                                    </div>

                                    <!-- retype_new_password -->
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <label for="retype_new_password" class="form-label">Retype New Password <span class="text-danger"> *</span></label>
                                        <input disabled type="password" name="retype_new_password" id="retype_new_password" class="form-control">
                                        <span class="help-block text-danger ms-1"><small></small></span>
                                    </div>

                                    <div class="col-12 d-flex justify-content-end">

                                        <button type="button" class="btn btn-success waves-effect waves-light update-button">Update Account</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
            </div>
        </footer>

    </div>


    <div class="modal fade" id="mailNotificationReminder" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Mail Changing Reminder</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; To completely change your account bounded email and for security purpose. We sent an email to your new gmail address to verify that the new email is yours. Please check it before the link expires.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <?php include 'components/right-navigation.php' ?>
    <!-- Vendor -->
    <script src="<?= BASE_URL . PUBLIC_DIR ?>/admin/assets/libs/jquery/jquery.min.js"></script>
    <script src="<?= BASE_URL . PUBLIC_DIR ?>/admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= BASE_URL . PUBLIC_DIR ?>/admin/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="<?= BASE_URL . PUBLIC_DIR ?>/admin/assets/libs/node-waves/waves.min.js"></script>
    <script src="<?= BASE_URL . PUBLIC_DIR ?>/admin/assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
    <script src="<?= BASE_URL . PUBLIC_DIR ?>/admin/assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
    <script src="<?= BASE_URL . PUBLIC_DIR ?>/admin/assets/libs/feather-icons/feather.min.js"></script>
    <!-- App js -->
    <script src="<?= BASE_URL . PUBLIC_DIR ?>/admin/assets/js/app.min.js"></script>
    <!-- Sweet Alerts js -->
    <script src="<?= BASE_URL . PUBLIC_DIR ?>/admin/assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
    <!-- toastify -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
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
                        $('.help-block').html('')
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
            $('.help-block').html('')
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

        function clearPasswordFields() {
            $("#old_password").val('')
            $("#new_password").val('').attr('disabled', true)
            $("#retype_new_password").val('').attr('disabled', true)
        }
    </script>
</body>

</html>