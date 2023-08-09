<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?= $pageTitle ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <!-- App css -->
    <link href="<?= BASE_URL . PUBLIC_DIR ?>/admin/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <!-- icons -->
    <link href="<?= BASE_URL . PUBLIC_DIR ?>/admin/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" />
    <link rel="stylesheet" href="<?= BASE_URL ?>node_modules/cropperjs/dist/cropper.css">
    <!-- Sweet alert -->
    <link href="<?= BASE_URL . PUBLIC_DIR ?>/admin/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- toastify -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <style>
        table {
            border-collapse: separate;
            border-spacing: 0;
        }

        thead {
            background-color: #71b6f94d;
        }

        thead th:first-child {
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        thead th:last-child {
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        tbody tr:hover {
            background-color: rgba(255, 255, 255, .6);
            box-shadow: rgba(17, 17, 26, 0.2) 0px 0px 5px;
            transition: all 0.2s;
        }
    </style>
</head>

<!-- body start -->

<body class="loading" data-layout-color="light" data-layout-mode="default" data-layout-size="fluid" data-topbar-color="light" data-leftbar-position="fixed" data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='false'>
    <div id="wrapper">
        <?php include 'components/top-navigation.php' ?>
        <?php include 'components/side-navigation.php' ?>
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>Products</div>
                            <button id="add-ingredient" type="button" class="btn btn-primary rounded-pill waves-effect border-none waves-light" data-bs-toggle="offcanvas" data-bs-target="#ingredientForm" aria-controls="offcanvasRight">Add</button>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center my-3">
                                <div>
                                    <input type="text" class="form-control rounded-pill border-primary" placeholder="Search..." id="ingredients-search">
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th style="width: 150px;">Unit of measure</th>
                                            <th class="text-center" style="width: 230px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="align-middle">
                                    </tbody>
                                </table>
                                <nav class="justify-content-end d-flex pt-4 mx-4 p-2">
                                    <ul class="pagination pagination-rounded">

                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                </div>
            </footer>
        </div>
    </div>

    <?php include 'components/right-navigation.php' ?>

    <!-- Off Canvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="ingredientForm" aria-labelledby="ingredientFormLabel">
        <div class="offcanvas-header">
            <h5 class="fs-3 ms-2" id="ingredientFormLabel"></h5>
            <button type="button" class="me-1 btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div method="post" action="" id="form" class="offcanvas-body" enctype="multipart/form-data">
            <input type="hidden" id="id" name="id">

            <!-- ingredient name -->
            <div class="mb-3 mt-2">
                <label for="name" class="form-label">Ingredient name<span class="text-danger"> *</span></label>
                <input type="text" placeholder="Enter ingredient name" class="form-control" id="name" name="name">
                <div class="text-danger fs-6 text-start ps-1 validation-error">&nbsp;</div>
            </div>

            <!-- unit_of_measurement -->
            <div class="mb-3">
                <label for="unit_of_measurement" class="form-label">unit_of_measurement
                    <span class="text-danger"> *</span>
                </label>
                <input type="number" class="form-control" name="unit_of_measurement" id="unit_of_measurement" step="0.01" placeholder="product price">
                <div class="text-danger fs-6 text-start ps-1 validation-error">&nbsp;</div>
            </div>

            <div class="text-end mt-3">
                <button id="submit-form" class="btn btn-primary waves-effect waves-light" type="submit">Submit</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script src="<?= BASE_URL ?>node_modules/cropperjs/dist/cropper.min.js"></script>
    <!-- Sweet Alerts js -->
    <script src="<?= BASE_URL . PUBLIC_DIR ?>/admin/assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
    <!-- loadash -->
    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
    <!-- axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- toastify -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <!-- tippy js -->
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.min.js"></script>
    <script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.js"></script>
    <script>
        // side navigation bar toggle
        $('body').attr('data-leftbar-size', 'default').addClass('sidebar-enable')
        $('.toggle-sidebar').on('click', function() {
            $('body').toggleClass('sidebar-enable')
        })

        $(document).ready(function() {
            handleFetchIngredients(q)
        })

        // Query data
        let q = {
            q: 'all',
            page: 1
        }

        // handle ingredients list request
        const handleFetchIngredients = _.debounce(fetchIngredients, 1000);

        // ingredients request
        function fetchIngredients(q) {
            $('tbody').html('<tr class="align-middle rounded m-1"> <th colspan="100%" scope="row" class="text-center"> <i class="fas fa-spinner fa-spin my-5 fs-1"></i></th></tr>')
            let link = `<?= site_url('admin_api/ingredients_index') ?>/${q.page}/${q.q}`
            axios.get(link, {
                    /* OPTIONS */
                })
                .then(function(response) {
                    console.log(response.data['ingredients'])
                    populateTable(response.data['ingredients'])
                    populatePagination(response.data['pagination'])
                })
                .catch(function(error) {
                    console.log(error);
                })
                .finally(function() {});
        }

        // render pagination links
        function populatePagination(pagination) {
            $('.pagination').html('')
            // current page
            $('.pagination').append(
                $('<li></li>').addClass('page-item active')
                .append($('<div></div>').addClass('page-link').css('cursor', 'pointer').attr('data-page', 1).html(pagination['currentPage']))
            )
            // pages
            for (let page = 1; page <= pagination['totalPage']; page++) {
                if (pagination['currentPage'] == page) {
                    currentPage = page;
                    previousPages = currentPage - 1;
                    addedPage = 0;
                    while (addedPage < 3) {
                        if (previousPages >= 1)
                            $('.pagination').prepend(
                                $('<li></li>').addClass('page-item')
                                .append($('<div></div>').addClass('page-link').css('cursor', 'pointer').attr('data-page', previousPages).html(previousPages))
                            )
                        previousPages--
                        addedPage++
                    }
                    addedPage = 0
                    nextPages = currentPage + 1;
                    while (addedPage < 3) {
                        if (nextPages <= pagination['totalPage'])
                            $('.pagination').append(
                                $('<li></li>').addClass('page-item')
                                .append($('<div></div>').addClass('page-link').css('cursor', 'pointer').attr('data-page', nextPages).html(nextPages))
                            )
                        nextPages++
                        addedPage++
                    }
                }
            }
            // jump to first page
            $('.pagination').prepend(
                $('<li></li>').addClass('page-item')
                .append($('<div></div>').addClass('page-link').css('cursor', 'pointer').attr('data-page', 1).html('«&nbsp&nbspfirst'))
            )
            // jump to last page
            $('.pagination').append(
                $('<li></li>').addClass('page-item')
                .append($('<div></div>').addClass('page-link').css('cursor', 'pointer').attr('data-page', pagination['totalPage']).html('last&nbsp&nbsp»'))
            )
        }

        // render product list to table
        function populateTable(ingredients) {
            $('tbody').html('');

            for (let i = 0; i < ingredients.length; i++) {
                console.log(ingredients[i]['name'])
                $('tbody').append(
                    `
                    <tr id="${ingredients[i]['id']}">
                        <td> ${ingredients[i]['name']} </td>
                        <td class="text-center"> ${ingredients[i]['unit_of_measurement']} </td>
                        <td class="text-center">
                            <span data-tippy-content="Delete Permanently" class="btn waves-effect waves-dark p-1 py-0 shadow-lg me-1 delete-product">
                                <i class="mdi mdi-delete fs-3 text-danger"></i>
                            </span>
                        </td>
                    </tr>
                    `
                );
            }
            tippy('[data-tippy-content]');
        }

        // change page
        $(document).on('click', '.page-link', changePage)

        function changePage() {
            q.page = $(this).attr('data-page')
            handleFetchIngredients(q);
        }

        // search ingredients
        $('#ingredients-search').on('input', function() {
            q.q = $(this).val() == '' ? 'all' : $(this).val().trim()
            q.page = 1
            if (/^\s*$/.test($(this).val()))
                q.q = 'all'
            handleFetchIngredients(q);
        })

        // add form error
        // function displayErrors() {
        //     for (let key in formErrors)
        //         $('<div class="ms-1 text-danger form-error-message">' + formErrors[key] + '</div>').insertAfter($(`#${key}`))
        // }

        $('#add-ingredient').on('click', function() {
            $('#ingredientFormLabel').html('ADD NEW INGREDIENT')
            resetForm()
        })

        $(document).on('click', '.edit-ingredient', function() {
            $('#ingredientFormLabel').html('EDIT INGREDIENT')
            resetForm()
        });

        $('#submit-form').on('click', function() {
            addNewIngredient()
        })

        function addNewIngredient() {
            $.post('<?= site_url('admin_api/add-ingredient') ?>', {
                    name: $('#name').val(),
                    unit_of_measurement: $('#unit_of_measurement').val()
                })
                .then(function(response) {
                    console.log(response)
                })
        }

        function clearValidationErrors() {
            $('.validation-error').html('&nbsp;')
        }

        function setValidationErrors(errors) {
            clearValidationErrors()
            for (const key in errors) {
                if (Object.hasOwnProperty.call(errors, key)) {
                    $('#' + key).next().html(errors[key]);
                }
            }
        }
        // add form error
        // function displayErrors() {
        //     for (let key in formErrors)
        //         $('<div class="ms-1 text-danger form-error-message">' + formErrors[key] + '</div>').insertAfter($(`#${key}`))
        // }

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

        function resetForm() {
            clearValidationErrors()
            $('#name').val('')
            $('#unit_of_measurement').val('')
        }

        $(document).on('click', '.delete-product', function() {
            let productID = $(this).closest('tr').attr('id')

            Swal.fire({
                title: 'Are you sure you want to delete this Product?',
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
                    return deleteProduct(password, productID);
                }
            }).then((result) => {
                console.log(result.isConfirmed)
                if (result.isConfirmed) {

                }
            });
        })

        function deleteProduct(password, productID) {
            return new Promise(function(resolve, reject) {
                $.post('<?= site_url('admin_api/delete-product') ?>', {
                        password: password,
                        productID: productID
                    })
                    .then(function(response) {
                        console.log(response)
                        if (response == 'wrong password') {
                            showToast('you entered the wrong password', "linear-gradient(to right, #ac1414, #f12b00)")
                            resolve(false)
                        } else if (response == 'invalid ID') {
                            showToast('ID does not exists', "linear-gradient(to right, #ac1414, #f12b00)")
                            resolve(false)
                        } else {
                            showToast('Product deletion success.', "linear-gradient(to right,  #3ab902, #14ac34)")
                            handleFetchProducts(q)
                            resolve(true)
                        }
                    })
            })
        }
    </script>
</body>

</html>