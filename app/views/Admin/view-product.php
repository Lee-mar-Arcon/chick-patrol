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
    <!-- select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- toastify -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

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
                    <div class="row card">
                        <div class="card-header">
                            <div class="display-6 fw-bold"><?= $product['name'] ?></div>
                            <div class="text-muted fs-4">(<?= $product['inventory_type'] == 'perishable' ? 'Ingredients' : 'Inventory' ?>)</div>
                        </div>
                        <div class="col-sm-12">
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
                                        <div class="py-1">Quantity: <span id="product_available_quantity"><?= $product['quantity'] ?></span></div>
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
                        <?php if ($product['inventory_type'] == 'perishable') : ?>
                            <div class="col-md-9 col-12 bg-white pb-5">
                                <div class="card-header">
                                    <div class="fs-3 fw-bold">Inventory</div>
                                    <div id="ingredient_name_header" class="text-muted fs-4"></div>
                                </div>
                                <div id="ingredient-inventory" class="p-2">
                                </div>
                            </div>
                        <?php endif; ?>
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
    <div class="offcanvas offcanvas-end" tabindex="-1" id="addIngredientQuantityForm" aria-labelledby="addIngredientQuantityLabel">
        <div class="offcanvas-header">
            <h5 class="fs-3 ms-2" id="addIngredientQuantityLabel">Add Ingredient Quantity</h5>
            <button type="button" class="me-1 btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div method="post" action="" id="form" class="offcanvas-body" enctype="multipart/form-data">
            <input type="hidden" id="product_ingredient_id" name="product_ingredient_id">
            <!-- ingredient name -->
            <div class="mb-3 mt-2">
                <label for="product_ingredient_name" class="form-label">Ingredient name</label>
                <input readonly type="text" class="form-control" id="product_ingredient_name" name="product_ingredient_name">
            </div>

            <!-- quantity -->
            <div class="mb-3 mt-2">
                <label for="quantity" class="form-label">Quantity<span class="text-danger"> *</span></label>
                <input type="text" placeholder="quantity" class="form-control" id="quantity" name="quantity">
            </div>

            <!-- expiration_date -->
            <div class="mb-3 mt-2">
                <label for="expiration_date" class="form-label">Expiration date<span class="text-danger"> *</span></label>
                <input type="date" class="form-control" id="expiration_date" name="expiration_date">
            </div>

            <div class="text-end mt-3">
                <button id="submit-add-ingredient-quantity" class="btn btn-primary waves-effect waves-light" type="submit">Submit</button>
            </div>
        </div>
    </div>

    <!-- Add product ingredient offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="addProductIngredientForm" aria-labelledby="addProductIngredientLabel">
        <div class="offcanvas-header">
            <h5 class="fs-3 ms-2" id="addProductIngredientLabel">Add product ingredient</h5>
            <button type="button" class="me-1 btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div method="post" action="" id="form" class="offcanvas-body" enctype="multipart/form-data">
            <input type="hidden" id="product_id" name="product_id">

            <!-- ingredient_id -->
            <div class="mb-3 mt-2">
                <label for="ingredient_id" class="form-label">Ingredient name<span class="text-danger"> *</span></label>
                <select class="form-select" id="ingredient_id" name="ingredient_id">
                </select>
            </div>

            <!-- unit_of_measurement -->
            <div class="mb-3 mt-2">
                <label for="unit_of_measurement" class="form-label">unit of measurement<span class="text-danger"> *</span></label>
                <input type="text" placeholder="unit of measurement" class="form-control" id="unit_of_measurement" name="unit_of_measurement">
            </div>

            <!-- need_quantity -->
            <div class="mb-3 mt-2">
                <label for="need_quantity" class="form-label">needed quantity<span class="text-danger"> *</span></label>
                <input type="text" placeholder="need quantity" class="form-control" id="need_quantity" name="need_quantity">
            </div>

            <div class="text-end mt-3">
                <button id="submit-add-product-ingredient" class="btn btn-primary waves-effect waves-light" type="submit">Submit</button>
            </div>
        </div>
    </div>

    <!-- Add product inventory offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="addProductInventoryForm" aria-labelledby="addProductInventoryLabel">
        <div class="offcanvas-header">
            <h5 class="fs-3 ms-2" id="addProductInventoryLabel">Add product inventory</h5>
            <button type="button" class="me-1 btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <input type="hidden" id="inventory_product_id" value="<?= $product['id'] ?>" name="inventory_product_id">

            <!-- quantity -->
            <div class="mb-3 mt-2">
                <label for="need_quantity" class="form-label">quantity<span class="text-danger"> *</span></label>
                <input type="text" placeholder="need quantity" class="form-control" id="inventory_quantity" name="inventory_quantity">
            </div>

            <!-- expiration_date -->
            <div class="mb-3 mt-2">
                <label for="inventory_expiration_date" class="form-label">Expiration date<span class="text-danger"> *</span></label>
                <input type="date" class="form-control" id="inventory_expiration_date" name="inventory_expiration_date">
            </div>

            <div class="text-end mt-3">
                <button id="submit-add-product-ingredient" class="btn btn-primary waves-effect waves-light" type="submit">Submit</button>
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
    <!-- select 2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- react-toastify -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        const product = <?= json_encode($product) ?>;
        (function() {
            showLoader($('.ingredient-container'))
        })();

        $(document).ready(function() {
            if (product.inventory_type == 'perishable') {
                getProductIngredients()
            } else {
                getProductInventory()
            }
            initSelect2()
            getProductAvailableQuantity()
        })

        function initSelect2() {
            ingredientSelect = $('#ingredient_id')
            ingredientSelect.select2({
                theme: "classic",
                placeholder: 'search ingredient',
                dropdownParent: $('#addProductIngredientForm'),
                ajax: {
                    url: '<?= site_url('Admin_api/search-ingredients') ?>',
                    type: 'POST',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term,
                            productID: product.id
                        }
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        }
                    }
                }
            });
        }

        $(document).on('click', '#add-product-ingredient', function() {
            clearValidationErrors()
            $('#product_id').val(product.id)
        })

        $(document).on('click', '#submit-add-product-ingredient', function() {
            let submitAddProductIngredientElement = $(this)
            submitAddProductIngredientElement.attr('disabled', true)

            $.post('<?= site_url('Admin_api/add_product_ingredient') ?>', {
                product_id: $('#product_id').val(),
                ingredient_id: $('#ingredient_id').val(),
                need_quantity: $('#need_quantity').val(),
                unit_of_measurement: $('#unit_of_measurement').val(),
            }).then(function(response) {
                if (typeof response === 'object') {
                    displayFormErrors(response)
                } else {
                    getProductIngredients()
                    resetForm(['product_id', 'ingredient_id', 'need_quantity', 'unit_of_measurement'])
                    $('#addProductIngredientForm').offcanvas('hide')
                    showToast('product ingredient added', 'success')
                    getProductAvailableQuantity()
                }
                submitAddProductIngredientElement.attr('disabled', false)
            })
        })

        function clearValidationErrors() {
            $('.form-error-message').html('&nbsp;')
        }

        function showToast(message, type, duration = 1500) {
            backgroundColor = '';
            switch (type) {
                case 'success':
                    backgroundColor = 'linear-gradient(to right,  #3ab902, #14ac34)'
                    break;
                case 'info':
                    backgroundColor = 'linear-gradient(to right,  #007d85, #008e97)'
                    break;
                case 'danger':
                    backgroundColor = "linear-gradient(to right, #ac1414, #f12b00)"
                    break;
            }

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

        function showLoader(element) {
            element.html(`
                <div class="d-flex justify-content-center my-5 py-5">
                    <i class="mdi text-primary mdi-spin mdi-loading display-2"></i>
                </div>
            `)
        }

        function getProductInventory() {
            const productID = product.id
            $.post('<?= site_url('Admin_api/get-product-inventory') ?>', {
                productID: productID
            }).then(function(response) {
                console.log(response)
                populateProductInventory(response)
            })
        }

        function getProductIngredients() {
            const productID = product.id
            $.post('<?= site_url('Admin_api/get-product-ingredients') ?>', {
                productID: productID
            }).then(function(response) {
                console.log(response)
                populateIngredientList(response)
            })
        }

        function populateProductInventory(inventory) {
            inventoryList = ''
            for (let i = 0; i < inventory.length; i++) {
                inventoryList += `
                <tr class="align-middle bg-light col-12 mb-2" data-id="${inventory[i]['id']}">
                        <td>${parseFloat(inventory[i]['quantity']).toFixed(2)}</td>
                        <td>${parseFloat(inventory[i]['remaining_quantity']).toFixed(2)}</td>
                        <td>${inventory[i]['added_at']}</td>
                        <td>${inventory[i]['expiration_date']}</td>
                        <td class="text-center">
                            <span data-tippy-content="remove" class="waves-effect waves-light p-1 py-0 me-1 bg-white rounded remove-inventory">
                                <i class="mdi mdi-delete fs-3 text-danger"></i>
                            </span>
                        </td>
                    </tr>`
            }
            $('.ingredient-container').html('')
            $('.ingredient-container').prepend(
                `
            <div class="m-2 d-flex justify-content-end">
                <button id="add-product-inventory" type="button" class="btn btn-primary rounded-pill waves-effect border-none waves-light" data-bs-toggle="offcanvas" data-bs-target="#addProductInventoryForm" aria-controls="offcanvasRight">add inventory</button>
            </div>
            `
            )

            $('.ingredient-container').append(`
            <div class="table-responsive">
                <table class="table table-transparent table-borderless">
                    <thead>
                        <tr>
                            <th scope="col" style="width: 100px;">QTY</th>
                            <th scope="col" style="width: 50px;">Rem QTY</th>
                            <th scope="col" style="width: 150px;">Added at</th>
                            <th scope="col" style="width: 150px;">Expiration date</th>
                            <th scope="col" class="text-center" style="width: 50px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    ${inventoryList}
                    </tbody>
                </table>
            </div>
            `)
            tippy('[data-tippy-content]');
        }

        function populateIngredientList(ingredients) {
            $('.ingredient-container').html('')
            let ingredientList = ''
            for (let i = 0; i < ingredients.length; i++) {
                ingredientList += `
                <tr class="align-middle bg-light col-12 mb-2 ${ingredients[i]['can_make'] == 0 ? 'text-danger': ''}" data-id="${ingredients[i]['id']}">
                        <td scope="row">${ingredients[i]['name']}</td>
                        <td>${ingredients[i]['can_make'] == null ? '0.00' : parseFloat(ingredients[i]['can_make'])}</td>
                        <td>${ingredients[i]['available_quantity'] == null ? '0.00' : parseFloat(ingredients[i]['available_quantity']).toFixed(2)}</td>
                        <td>${parseFloat(ingredients[i]['need_quantity']).toFixed(2)}</td>
                        <td>${ingredients[i]['unit_of_measurement']}</td>
                        <td class="text-center">
                            <span data-tippy-content="Add quantity" class="waves-effect waves-light p-1 py-0 me-1 bg-white rounded add-ingredient-quantity-button" data-bs-toggle="offcanvas" data-bs-target="#addIngredientQuantityForm" aria-controls="offcanvasRight">
                                <i class="mdi mdi-plus-thick fs-3 text-info"></i>
                            </span>
                            <span data-tippy-content="view inventory list" class="waves-effect waves-light p-1 py-0 me-1 bg-white rounded view_ingredient_inventory_list">
                                <i class="mdi mdi-eye fs-3 text-info"></i>
                            </span>
                            <span data-tippy-content="remove" class="waves-effect waves-light p-1 py-0 me-1 bg-white rounded remove-ingredient">
                                <i class="mdi mdi-delete fs-3 text-danger"></i>
                            </span>
                        </td>
                    </tr>`
            }

            $('.ingredient-container').prepend(
                `
            <div class="m-2 d-flex justify-content-end">
                <button id="add-product-ingredient" type="button" class="btn btn-primary rounded-pill waves-effect border-none waves-light" data-bs-toggle="offcanvas" data-bs-target="#addProductIngredientForm" aria-controls="offcanvasRight">add ingredient</button>
            </div>
            `
            )
            $('.ingredient-container').append(`
            <div class="table-responsive">
                <table class="table table-transparent table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col" style="width: 150px;">Can make with</th>
                            <th scope="col" style="width: 150px;">Available Quantity</th>
                            <th scope="col" style="width: 100px;">Need QTY</th>
                            <th scope="col" style="width: 50px;">Unit</th>
                            <th scope="col" class="text-center" style="width: 180px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>` + ingredientList + `</tbody>
                </table>
            </div>
            `)
            tippy('[data-tippy-content]');
        }

        $(document).on('click', '.add-ingredient-quantity-button', function() {
            clearValidationErrors()
            $('#product_ingredient_id').val($(this).closest('tr').attr('data-id'))
            $('#product_ingredient_name').val($(this).closest('tr').children(':first-child').text())
        })

        $('#submit-add-ingredient-quantity').on('click', function() {
            addIngredientQuantity()
        })

        function addIngredientQuantity() {
            $('#submit-add-ingredient-quantity').attr('disabled', true)
            $.post('<?= site_url('Admin_api/add_product_ingredient_quantity') ?>', {
                product_ingredient_id: $('#product_ingredient_id').val(),
                quantity: $('#quantity').val(),
                expiration_date: $('#expiration_date').val(),
            }).then(function(response) {
                if (typeof response === 'object')
                    displayFormErrors(response)
                else {
                    $('#addIngredientQuantityForm').offcanvas('hide')
                    getProductIngredients()
                    resetForm(['product_ingredient_id', 'quantity', 'expiration_date', 'product_ingredient_name'])
                    getProductAvailableQuantity()
                    fetchIngredientInventory(ingredientInventoryParams)
                }

                $('#submit-add-ingredient-quantity').attr('disabled', false)
            })
        }

        function displayFormErrors(formErrors) {
            for (let key in formErrors) {
                if (!$(`#${key}`).parent().children(':last-child').hasClass('form-error-message'))
                    $(`#${key}`).parent().append('<div class="ms-1 text-danger form-error-message">' + formErrors[key] + '</div>')
                else
                    $(`#${key}`).parent().children(':last-child').html(formErrors[key])
            }
        }

        function resetForm(InputIDs) {
            for (let i = 0; i < InputIDs.length; i++) {
                $(`#${InputIDs[i]}`).val(null)
            }
        }

        function getProductAvailableQuantity() {
            $.post('<?= site_url('Admin_api/get_product_available_quantity') ?>', {
                product_id: product.id
            }).then(function(response) {
                console.log('12312')
                $('#product_available_quantity').html(`${parseFloat(response == null ? 0 : response).toFixed(2)}`)
            })
        }

        let ingredientInventoryParams = {
            ingredient_id: '',
            product_id: product.id
        }
        $(document).on('click', '.view_ingredient_inventory_list', function() {
            ingredientInventoryParams.ingredient_id = $(this).closest('tr').attr('data-id')
            scrollTo($("#ingredient_name_header"))
            fetchIngredientInventory(ingredientInventoryParams)
        });

        function fetchIngredientInventory(ingredientInventoryParams) {
            if (ingredientInventoryParams.ingredient_id != '')
                $.post('<?= site_url(('Admin_api/get_ingredient_inventory')) ?>',
                    ingredientInventoryParams
                ).then(function(response) {
                    populateIngredientInventory(response.list)
                    $('#ingredient_name_header').html(response['name'])
                })
        }

        function scrollTo(element) {
            $("html, body").animate({
                scrollTop: element.prev().offset().top
            }, 50);
        }

        function populateIngredientInventory(ingredientInventoryList) {
            $('#ingredient-inventory').html('')
            let inventoryList = ''
            for (let i = 0; i < ingredientInventoryList.length; i++) {
                inventoryList += `
                <tr class="align-middle bg-light col-12 mb-2 " data-id="${ingredientInventoryList[i]['id']}">
                    <td scope="row">${ingredientInventoryList[i]['name']}</td>
                    <td>${parseFloat(ingredientInventoryList[i]['quantity']).toFixed(2)}</td>
                    <td>${parseFloat(ingredientInventoryList[i]['remaining_quantity']).toFixed(2)}</td>
                    <td>${ingredientInventoryList[i]['added_at']}</td>
                    <td>${ingredientInventoryList[i]['expiration_date']}</td>
                    <td class="text-center">
                        <span data-tippy-content="delete" class="waves-effect waves-light p-1 py-0 me-1 bg-white rounded delete-inventory">
                            <i class="mdi mdi-delete fs-3 text-danger"></i>
                        </span>
                    </td>
                </tr>`
            }
            $('#ingredient-inventory').append(`
            <div class="table-responsive">
                <table class="table table-transparent table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col" style="width: 100px;">QTY</th>
                            <th scope="col" style="width: 50px;">Rem QTY</th>
                            <th scope="col" style="width: 150px;">Added at</th>
                            <th scope="col" style="width: 150px;">Expiration date</th>
                            <th scope="col" class="text-center" style="width: 150px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${inventoryList}
                    </tbody>
                </table>
            </div>
            `)
            tippy('[data-tippy-content]');
        }

        $(document).on('click', '.delete-inventory', function() {
            let ingredientID = $(this).closest('tr').attr('data-id')
            Swal.fire({
                title: 'Are you sure you want to delete this ingredient inventory?',
                text: 'Enter your password',
                icon: 'error',
                input: 'password',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                allowOutsideClick: false,
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                preConfirm: function(password) {
                    return deleteIngredientInventory(password, ingredientID);
                }
            }).then((result) => {
                console.log(result.isConfirmed)
                if (result.isConfirmed) {

                }
            });
        })

        function deleteIngredientInventory(password, ingredientID) {
            return new Promise(function(resolve, reject) {
                $.post('<?= site_url('Admin_api/delete-ingredient-inventory') ?>', {
                        password: password,
                        ingredient_id: ingredientID
                    })
                    .then(function(response) {
                        console.log(response)
                        if (response == 'wrong password') {
                            showToast('you entered the wrong password', 'danger')
                            resolve(false)
                        } else if (response == 'invalid ID') {
                            showToast('ID does not exists', 'danger')
                            resolve(false)
                        } else {
                            showToast('Ingredient inventory deletion success.', "success")
                            getProductAvailableQuantity()
                            getProductIngredients()
                            fetchIngredientInventory(ingredientInventoryParams)
                            resolve(true)
                        }
                    })
            })
        }

        $(document).on('click', '.remove-ingredient', function() {
            let ingredientID = $(this).closest('tr').attr('data-id')
            Swal.fire({
                title: 'Are you sure you want to remove this ingredient?',
                text: 'Enter your password',
                icon: 'error',
                input: 'password',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                allowOutsideClick: false,
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                preConfirm: function(password) {
                    console.log(password, ingredientID)
                    return deleteIngredient(password, ingredientID);
                }
            }).then((result) => {
                console.log(result.isConfirmed)
                if (result.isConfirmed) {

                }
            });
        })

        $(document).on('click', '.remove-inventory', function() {
            let inventoryID = $(this).closest('tr').attr('data-id')
            Swal.fire({
                title: 'Are you sure you want to remove this inventory?',
                text: 'Enter your password',
                icon: 'error',
                input: 'password',
                inputAttributes: {
                    autocapitalize: 'off'
                },
                allowOutsideClick: false,
                showCancelButton: true,
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
                preConfirm: function(password) {
                    console.log(password, inventoryID)
                    return deleteInventory(password, inventoryID);
                }
            }).then((result) => {
                console.log(result.isConfirmed)
                if (result.isConfirmed) {

                }
            });
        })

        function deleteInventory(password, inventoryID) {
            return new Promise(function(resolve, reject) {
                $.post('<?= site_url('Admin_api/delete-inventory') ?>', {
                        password: password,
                        inventory_id: inventoryID
                    })
                    .then(function(response) {
                        if (response == 'wrong password') {
                            showToast('you entered the wrong password', 'danger')
                            resolve(false)
                        } else if (response == 'invalid ID') {
                            showToast('ID does not exists', 'danger')
                            resolve(false)
                        } else {
                            showToast('Product inventory deletion success.', "success")
                            getProductAvailableQuantity()
                            getProductInventory()
                            resolve(true)
                        }
                    })
            })
        }

        function deleteIngredient(password, ingredientID) {
            return new Promise(function(resolve, reject) {
                $.post('<?= site_url('Admin_api/delete-ingredient') ?>', {
                        password: password,
                        ingredient_id: ingredientID
                    })
                    .then(function(response) {
                        console.log(response)
                        if (response == 'wrong password') {
                            showToast('you entered the wrong password', 'danger')
                            resolve(false)
                        } else if (response == 'invalid ID') {
                            showToast('ID does not exists', 'danger')
                            resolve(false)
                        } else {
                            showToast('Product ingredient deletion success.', "success")
                            getProductAvailableQuantity()
                            getProductIngredients()
                            resolve(true)
                        }
                    })
            })
        }

        $(document).on('click', '#add-product-inventory', function() {
            resetForm(['inventory_quantity', 'inventory_expiration_date'])
        })
    </script>
</body>

</html>