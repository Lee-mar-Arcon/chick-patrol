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
    <!-- toastr -->
    <link rel="stylesheet" href="<?= BASE_URL . PUBLIC_DIR ?>/libraries/toastr.css">
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

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header">
                                    <h1 class="display-6 fw-bold">Barangay</h1>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <div class="d-flex justify-content-end me-2 my-3">
                                            <button id="add-barangay" type="button" class="btn btn-primary rounded-pill waves-effect border-none waves-light m-2" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Add</button>
                                        </div>
                                        <table class="table table-hover table-borderless mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th style="width: 150px;">Deleted at</th>
                                                    <th class="text-center" style="width: 120px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($barangays as $barangay) : ?>
                                                    <tr id="<?= $barangay['id'] ?>">
                                                        <td class="align-middle">
                                                            <span><?= $barangay['name'] ?></span>
                                                            <?= $barangay['deleted_at'] ? ' <span class="badge badge-soft-danger rounded-pill px-1 py-1 ms-2">Deleted</span>' : '' ?>
                                                        </td>
                                                        <td class="align-middle">
                                                            <?= $barangay['deleted_at'] ?
                                                                date('M-d Y h:i:s A', strtotime($barangay['deleted_at'])) :
                                                                '' ?></td>
                                                        <td class="text-center">
                                                            <span class="btn waves-effect waves-dark p-1 py-0 shadow me-1 edit-barangay" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                                                <i class="mdi mdi-home-edit fs-3 text-info"></i>
                                                            </span>

                                                            <span class="btn waves-effect waves-info p-1 py-0 shadow me-1">
                                                                <?= $barangay['deleted_at'] ?
                                                                    '<i class="mdi mdi-delete-restore fs-3 text-info"></i>' :
                                                                    '<i class="mdi mdi-delete fs-3 text-danger"></i>' ?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
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
    </div>

    <?php include 'components/right-navigation.php' ?>

    <!-- Off Canvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 class="fs-3" id="offcanvasRightLabel">Offcanvas right</h5>
            <button type="button" class="me-1 btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <form method="post" action="" id="form" class="offcanvas-body">
            <input type="hidden" id="id" name="id">
            <div class="mb-3 mt-2">
                <label for="name" class="form-label">Name<span class="text-danger"> *</span></label>
                <input type="text" required="" placeholder="Enter Barangay name" class="form-control" id="name" name="name">
            </div>
            <div class="text-end mt-3">
                <button id="submit-form" class="btn btn-primary waves-effect waves-light" type="submit">Submit</button>
            </div>
        </form>
    </div>

    <div id="delete-restore-form"></div>
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
    <!-- taostr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Sweet Alerts js -->
    <script src="<?= BASE_URL . PUBLIC_DIR ?>/admin/assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
    <script>
        // form validation response handler
        const formMessage = '<?= $formMessage ?>'
        const formData = JSON.parse('<?= json_encode($formData) ?>')

        switch (formMessage) {
            case '':
                break;
            case 'success':
                toastr.success('New barangay added.')
                break;
            case 'restored':
                toastr.info('Barangay restored.')
                break;
            case 'updated':
                toastr.info('Barangay updated.')
                break;
            case 'deleted':
                toastr.info('Barangay deleted.')
                break;
            default:
                const url = '<?= BASE_URL ?>admin/barangay_store'
                $('#form').attr('action', url)
                $('#add-barangay').click()
                $('#name').val(formData.name)
                $('<div class="ms-1 text-danger form-error-message">' + formMessage + '</div>').insertAfter('#name')
                break;
        }

        // add barangay form
        $('#add-barangay').on('click', function() {
            $('.form-error-message').remove()
            const url = '<?= BASE_URL ?>admin/barangay_store'
            $('#form').attr('action', url)
            $('#name').val('')
            $('#offcanvasRightLabel').html('Add new barangay')
        })

        // edit barangay form
        $('.edit-barangay').on('click', function() {
            $('.form-error-message').remove()
            const url = '<?= BASE_URL ?>admin/barangay_update'
            $('#form').attr('action', url)
            $('#offcanvasRightLabel').html('Edit barangay')
            $('#offcanvasRightLabel').html('Edit barangay')
            $('#name').val($(this).closest('td').prev().prev().find('span:first').html())
            $('#id').val($(this).closest('tr').attr('id'))
        })

        // show restore confirmation
        $('.mdi-delete-restore').on('click', function() {
            id = $(this).closest('tr').attr('id')
            Swal.fire({
                title: 'Restore barangay?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Restore'
            }).then((result) => {
                if (result.isConfirmed) {
                    handleDeleteRestoreSubmit(id, 'restore')
                }
            })
        })

        // show delete confirmation
        $('.mdi-delete').on('click', function() {
            id = $(this).closest('tr').attr('id')
            Swal.fire({
                title: 'Delete barangay?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    handleDeleteRestoreSubmit(id, 'destroy')
                }
            })
        })

        // form restore and delete submit handler
        function handleDeleteRestoreSubmit(id, httpMethod) {
            const deleteUrl = '<?= BASE_URL ?>admin/barangay_destroy';
            const restoreUrl = '<?= BASE_URL ?>admin/barangay_restore';

            var form = $('<form>');

            form.attr({
                method: 'POST',
                action: httpMethod == 'destroy' ? deleteUrl : restoreUrl
            });

            var idInput = $('<input>').attr({
                type: 'text',
                name: 'id',
                placeholder: 'Enter your username',
                value: id
            });
            form.append(idInput);
            var submitBtn = $('<input>').attr({
                type: 'submit',
                value: 'Submit'
            });
            $('#delete-restore-form').append(form);
            form.append(submitBtn);
            form.submit();
        }


        // let isEditForm = false;
        // $('body').attr('data-leftbar-size', 'default').addClass('sidebar-enable')
        // $('.toggle-sidebar').on('click', function() {
        //     $('body').toggleClass('sidebar-enable')
        // })



        // let id = null;



        // $('#submit-form').on('click', function() {
        //     if (!isEditForm) {
        //         handleRequest('<?= BASE_URL ?>admin_api/barangay_store', {
        //             name: $('#name').val(),
        //         }, 'store', $(this))
        //     } else {
        //         handleRequest('<?= BASE_URL ?>admin_api/barangay_update', {
        //             name: $('#name').val(),
        //             id: id
        //         }, 'update')
        //     }
        // })

        // function handleRequest(url, data, requestType, element) {
        //     element.html('<i class="fas fa-spinner fa-spin mx-2"></i>')
        //     axios.post(url, data)
        //         .then(function(response) {
        //             if (requestType == 'store') {
        //                 if (response.data == 'success')
        //                     show_notification('success', 'New barangay added!')
        //                 else if (response.data == 'Name already exists')
        //                     show_notification('error', 'Barangay already exists.')
        //             }
        //             if (requestType == 'update') {
        //                 if (response.data == 'success')
        //                     show_notification('success', 'Barangay updated.')
        //                 else if (response.data == 'Name already exists')
        //                     show_notification('error', 'Barangay already exists.')
        //             }
        //             element.html('Submit')
        //             console.log(response.data)
        //         })
        //         .catch(function(error) {
        //             console.log(error);
        //         });
        // }

        // function show_notification(type, message) {
        //     if (type == 'success')
        //         toastr['success'](message)
        //     else if (type == 'error')
        //         toastr['error'](message)
        //     toastr.options = {
        //         "closeButton": false,
        //         "debug": false,
        //         "newestOnTop": true,
        //         "progressBar": false,
        //         "positionClass": "toast-top-right",
        //         "preventDuplicates": true,
        //         "onclick": null,
        //         "showDuration": "300",
        //         "hideDuration": "1000",
        //         "timeOut": "5000",
        //         "extendedTimeOut": "1000",
        //         "showEasing": "swing",
        //         "hideEasing": "linear",
        //         "showMethod": "fadeIn",
        //         "hideMethod": "fadeOut"
        //     }
        // }
    </script>
</body>

</html>