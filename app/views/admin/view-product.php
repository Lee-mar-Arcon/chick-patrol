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
                                    <div class="display-6 fw-bold"><?= $product['name'] ?></div>
                                    <div class="text-muted fs-4">(Ingredients)</div>
                                </div>
                                <div class="card-body row flex-sm-row-reverse">
                                    <div class="col-md-3">
                                        <div class="bg-light rounded py-3 px-3 my-2 mx-0">
                                            <div class="d-flex flex-column justify-content-center">
                                                <div class="h4 text-center"><?= $product['name'] ?></div>
                                                <img src="<?= BASE_URL ?>public/images/products/cropped/<?= $product['image'] ?>" alt="" id="previewImage" height="150" width="150" class="img-fluid align-self-center rounded my-2 mb-2">
                                            </div>
                                            <div class="py-1">Price: ₱ <span><?= number_format($product['price'], 2) ?></span></div>
                                            <div class="py-1">Category: <span><?= $product['category_name'] ?></span></div>
                                            <div class="py-1">Inventory Type:
                                                <span><?= $product['inventory_type'] == 'perishable' ?
                                                            '<span class="text-start badge badge-soft-warning rounded-pill px-1 py-1 ms-2">perishable</span>' :
                                                            '<span class="text-start badge badge-soft-primary rounded-pill px-1 py-1 ms-2">durable</span>'
                                                        ?>
                                                </span>
                                            </div>
                                            <div class="py-1">Quantity: <span><?= $product['quantity'] ?></span></div>
                                            <div class="py-1">Date added: <span><?= date('M d, Y', strtotime($product['date_added'])) ?></span></div>
                                            <div class="py-1">Last Updated at: : <span><?= date('M d, Y', strtotime($product['updated_at'])) ?></span></div>
                                            <div class="py-1 pt-3">Description: : </div>
                                            <div class="py-1 text-justify">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $product['description'] ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="bg-light rounded py-3 px-3 my-2">
                                            <?php if ($product['inventory_type'] == 'durable') : ?>
                                                <div class="py-5 my-5 fw-bold h2 text-muted text-center">
                                                    This product does not have any ingredients.
                                                </div>
                                            <?php endif; ?>
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
                console.log(formMessage)
                $('#name').val(formData.name)
                $('#delivery_fee').val(formData.delivery_fee)
                let inputElement = '#' + ((formMessage == 'Delivery fee is required.') ? 'delivery_fee' : 'name')
                console.log(inputElement)
                $('<div class="ms-1 text-danger form-error-message">' + formMessage + '</div>').insertAfter(inputElement)
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
            let delivery_fee = parseFloat($(this).closest('td').prev().prev().prev().prev().html().replace(/,/g, ""))
            $('#delivery_fee').val(delivery_fee)
            $('#name').val($(this).closest('td').prev().prev().prev().prev().prev().find('span:first').html())
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
                    handleDeleteRestoreSubmit(id, 'continue')
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
    </script>
</body>

</html>