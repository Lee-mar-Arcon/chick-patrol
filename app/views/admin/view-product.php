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
                                        <div class="bg-light shadow rounded py-3 px-3 my-2 mx-0">
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
                                            <div class="py-1">Last Updated at: <span><?= date('M d, Y', strtotime($product['updated_at'])) ?></span></div>
                                            <div class="py-1 pt-3">Description: </div>
                                            <div class="py-1 text-justify">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= $product['description'] ?></div>
                                        </div>
                                    </div>
                                    <div class="col-md-9 ">
                                        <div class="shadow-sm rounded py-3 px-3 my-2 ingredient-container">

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

    <!-- Add ingredient quantity offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="addIngredientQuantity" aria-labelledby="addIngredientQuantityLabel">
        <div class="offcanvas-header">
            <h5 class="fs-3 ms-2" id="addIngredientQuantityLabel">Add Ingredient Quantity</h5>
            <button type="button" class="me-1 btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div method="post" action="" id="form" class="offcanvas-body" enctype="multipart/form-data">
            <input type="hidden" id="product_ingredient_id" name="product_ingredient_id">
            <!-- ingredient name -->
            <div class="mb-3 mt-2">
                <label for="product_ingredient_name" class="form-label">Ingredient name<span class="text-danger"> *</span></label>
                <input readonly type="text" class="form-control" id="product_ingredient_name" name="product_ingredient_name">
                <div class="text-danger fs-6 text-start ps-1 validation-error">&nbsp;</div>
            </div>

            <!-- quantity -->
            <div class="mb-3 mt-2">
                <label for="quantity" class="form-label">Quantity<span class="text-danger"> *</span></label>
                <input type="text" placeholder="quantity" class="form-control" id="quantity" name="quantity">
                <div class="text-danger fs-6 text-start ps-1 validation-error">&nbsp;</div>
            </div>

            <!-- expiration_date -->
            <div class="mb-3 mt-2">
                <label for="expiration_date" class="form-label">Expiration date<span class="text-danger"> *</span></label>
                <input type="date" class="form-control" id="expiration_date" name="expiration_date">
                <div class="text-danger fs-6 text-start ps-1 validation-error">&nbsp;</div>
            </div>

            <div class="text-end mt-3">
                <button id="submit-add-ingredient-quantity" class="btn btn-primary waves-effect waves-light" type="submit">Submit</button>
            </div>
        </div>
    </div>

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
    <!-- tippy js -->
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
    <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
    <script>
        const product = <?= json_encode($product) ?>;

        (function() {
            showLoader($('.ingredient-container'))
        })();

        $(document).ready(function() {
            if (product.inventory_type == 'perishable') getProductIngredients()
            else ingredientNotNeededMessage()
        })

        function showLoader(element) {
            element.html(`
                <div class="d-flex justify-content-center my-5 py-5">
                    <i class="mdi text-primary mdi-spin mdi-loading display-2"></i>
                </div>
            `)
        }

        function ingredientNotNeededMessage() {
            $('.ingredient-container').html('')
            $('.ingredient-container').append(`
                <div class="py-5 my-5 fw-bold h2 text-muted text-center">
                    This product does not need any ingredients.
                </div>
            `)
        }

        function getProductIngredients() {
            const productID = product.id
            $.post('<?= site_url('admin_api/get-product-ingredients') ?>', {
                productID: productID
            }).then(function(response) {
                populateIngredientList(response)
            })
        }

        function populateIngredientList(ingredients) {
            $('.ingredient-container').html('')
            let ingredientList = ''
            for (let i = 0; i < ingredients.length; i++) {
                ingredientList += `
                <tr class="align-middle bg-light col-12 mb-2" data-id="${ingredients[i]['id']}">
                        <td scope="row">${ingredients[i]['name']}</td>
                        <td>${ingredients[i]['unit_of_measurement']}</td>
                        <td>${parseFloat(ingredients[i]['quantity']).toFixed(2)}</td>
                        <td>${ingredients[i]['unit_of_measurement']}</td>
                        <td class="text-center">
                            <span data-tippy-content="Add quantity" class="waves-effect waves-light p-1 py-0 me-1 bg-white rounded add-ingredient-quantity-button" data-bs-toggle="offcanvas" data-bs-target="#addIngredientQuantity" aria-controls="offcanvasRight">
                                <i class="mdi mdi-plus-thick fs-3 text-info"></i>
                            </span>
                            <span class="waves-effect waves-light p-1 py-0 me-1 bg-white rounded">
                                <i class="mdi mdi-circle-edit-outline fs-3 text-info"></i>
                            </span>
                        </td>
                    </tr>`
            }
            $('.ingredient-container').append(`
            <div class="table-responsive">
                <table class="table table-transparent table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col" style="width: 150px;">Available Quantity</th>
                            <th scope="col" style="width: 100px;">Need QTY</th>
                            <th scope="col" style="width: 100px;">Unit</th>
                            <th scope="col" class="text-center" style="width: 150px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>` + ingredientList + `</tbody>
                </table>
            </div>
            `)
            tippy('[data-tippy-content]');
        }


        $(document).on('click', '.add-ingredient-quantity-button', function() {
            $('#product_ingredient_id').val($(this).closest('tr').attr('data-id'))
            $('#product_ingredient_name').val($(this).closest('tr').children(':first-child').text())
        })

        $('#submit-add-ingredient-quantity').on('click', function() {
            addIngredientQuantity()
        })

        function addIngredientQuantity() {
            $('#submit-add-ingredient-quantity').attr('disabled', true)
            $.post('<?= site_url('admin_api/add_product_ingredient_quantity') ?>', {
                product_ingredient_id: $('#product_ingredient_id').val(),
                quantity: $('#quantity').val(),
                expiration_date: $('#expiration_date').val(),
            }).then(function(response) {
                if (typeof response === 'object')
                    displayFormErrors(response)
                else {
                    $('#addIngredientQuantity').offcanvas('hide')
                    resetForm(['product_ingredient_id', 'quantity', 'expiration_date', 'product_ingredient_name'])
                }

                $('#submit-add-ingredient-quantity').attr('disabled', false)
            })
        }

        function displayFormErrors(formErrors) {
            for (let key in formErrors) {
                if (!$(`#${key}`).next().hasClass('form-error-message'))
                    $('<div class="ms-1 text-danger form-error-message">' + formErrors[key] + '</div>').insertAfter($(`#${key}`))
                else
                    $(`#${key}`).next().html(formErrors[key])
            }
        }

        function resetForm(InputIDs) {
            for (let i = 0; i < InputIDs.length; i++) {
                $(`#${InputIDs[i]}`).val(null)
            }
        }
    </script>
</body>

</html>