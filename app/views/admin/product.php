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
    <!-- toastr -->
    <link rel="stylesheet" href="<?= BASE_URL . PUBLIC_DIR ?>/libraries/toastr.css">
    <!-- Sweet alert -->
    <link href="<?= BASE_URL . PUBLIC_DIR ?>/admin/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
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
                            <button id="add-product" type="button" class="btn btn-primary rounded-pill waves-effect border-none waves-light" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Add</button>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center my-3">
                                <div>
                                    <input type="text" class="form-control rounded-pill border-primary" placeholder="Search..." id="product-search">
                                </div>
                                <div class="d-flex justify-content-center">
                                    <div class="me-2">
                                        <div class="btn-group-vertical row bg-primary rounded text-white text-center fs-6 fw-bold m-0 p-1">
                                            <div class="d-flex justify-content-center bg-primary text-white w-100 px-3 py-1">Availability</div>
                                            <button type="button" class="btn bg-white text-dark text-white p-1 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"> <span>All</span> <i class="mdi mdi-chevron-down"></i> </button>
                                            <div class="dropdown-menu">
                                                <button class="dropdown-item option-availability" data-value="all">All</button>
                                                <button class="dropdown-item option-availability" data-value="1">Available</button>
                                                <button class="dropdown-item option-availability" data-value="0">Unavailable</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn-group-vertical row bg-primary rounded text-white text-center fs-6 fw-bold m-0 p-1">
                                        <div class="d-flex justify-content-center bg-primary text-white w-100 px-3 py-1">Category</div>
                                        <button type="button" class="btn bg-white text-dark text-white p-1 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"> <span>All</span> <i class="mdi mdi-chevron-down"></i> </button>
                                        <div class="dropdown-menu">
                                            <button class="dropdown-item option-category" data-id="all">All</button>
                                            <?php foreach ($categories as $category) : ?>
                                                <button class="dropdown-item option-category" data-id="<?= ucwords($category['id']) ?>"><?= ucwords($category['name']) ?></button>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 100px;"></th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Category</th>
                                            <th>Quantity(pcs)</th>
                                            <th style="width: 130px;">Date added</th>
                                            <th style="width: 130px;">Updated at</th>
                                            <th class="text-center" style="width: 130px;">available</th>
                                            <th class="text-center" style="width: 180px;">Action</th>
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
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 class="fs-3 ms-2" id="offcanvasRightLabel"></h5>
            <button type="button" class="me-1 btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <form method="post" action="" id="form" class="offcanvas-body" enctype="multipart/form-data">
            <input type="hidden" id="id" name="id">
            <!-- Image -->
            <label for="example-fileinput" class="form-label text-center fs-3 w-100">Product Image</label>
            <div class="text-center">
                <img src="<?= BASE_URL .  PUBLIC_DIR ?>/images/products/default.png" alt="" id="previewImage" height="150" width="150" class="img-fluid rounded my-2 mb-5">
                <input type="file" id="imageInput" name="imageInput" class="form-control" accept="image/png, image/jpg, image/jpeg">
            </div>

            <!-- product name -->
            <div class="mb-3 mt-2">
                <label for="name" class="form-label">Product name<span class="text-danger"> *</span></label>
                <input type="text" placeholder="Enter product name" class="form-control" id="name" name="name">
            </div>

            <!-- category -->
            <div class="mb-3">
                <label for="category" class="form-label">Category<span class="text-danger"> *</span></label>
                <select class="form-select form-select-md" name="category" id="category">
                    <?php foreach ($categoriesForForm as $category) : ?>
                        <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- inventory type -->
            <div class="mb-3">
                <label for="inventory-type" class="form-label">Inventory type<span class="text-danger"> *</span></label>
                <select class="form-select form-select-md" name="inventory-type" id="inventory-type">
                    <option value="perishable" selected>Perishable</option>
                    <option value="durable">Durable goods</option>
                </select>
            </div>

            <!-- price -->
            <div class="mb-3">
                <label for="price" class="form-label">price<span class="text-danger"> *</span></label>
                <input type="number" class="form-control" name="price" id="price" step="0.01" placeholder="product price">
            </div>

            <!-- description -->
            <div class="mb-3">
                <label for="description" class="form-label">description<span class="text-danger"> *</span></label>
                <textarea class="form-control" name="description" id="description" rows="12"></textarea>
            </div>
            <div class="text-end mt-3">
                <button id="submit-form" class="btn btn-primary waves-effect waves-light" type="submit">Submit</button>
            </div>
        </form>
    </div>

    <!-- Off Canvas for quantity update -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="edit-quantity-offcanvas" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 class="fs-3 ms-2" id="edit-quantity-offcanvasLabel">Update product quantity</h5>
            <button type="button" class="me-1 btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <input type="hidden" id="update_id" name="id">

            <!-- inventory type -->
            <div class="mb-3">
                <label for="inventory-type" class="form-label">Inventory type<span class="text-danger"> *</span></label>
                <select class="form-select form-select-md" name="update_inventory_type" id="update_inventory_type">
                    <option value="perishable" selected>Perishable</option>
                    <option value="durable">Durable goods</option>
                </select>
            </div>

            <!-- quantity -->
            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity
                    <span class="text-danger"> *</span>
                </label>
                <input data-toggle="tooltip" data-placement="top" title="Tooltip Content" type="number" class="form-control" required name="update_quantity" id="update_quantity" step="0.01" placeholder="product price">
            </div>

            <!-- price -->
            <div class="mb-3">
                <label for="price" class="form-label">price<span class="text-danger"> *</span></label>
                <input type="number" class="form-control" name="update_price" id="update_price" step="0.01" placeholder="product price">
            </div>

            <div class="text-end mt-3">
                <button id="updateSubmitForm" class="btn btn-primary waves-effect waves-light" type="submit">Submit</button>
            </div>
        </div>
    </div>

    <!-- crop image modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Crop Image</h5>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-center">
                        <img alt="" id="productImageCanvas" class="img">
                    </div>
                    <div>
                        <div id="croppedImage"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="cropImageButton" class="btn btn-primary">Crop</button>
                </div>
            </div>
        </div>
    </div>

    <!-- image preview modal -->
    <div id="preview-image-modal" class="modal fade" tabindex="-1" aria-labelledby="standard-modalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="preview-image-label"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex justify-content-center">
                    <img class="img-fluid" src="" alt="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div id="available-unavailable-form"></div>
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
    <!-- taostr -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Sweet Alerts js -->
    <script src="<?= BASE_URL . PUBLIC_DIR ?>/admin/assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
    <!-- loadash -->
    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
    <!-- axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        // form response data 
        const formMessage = '<?= $formMessage ?>'
        const formErrors = JSON.parse('<?= json_encode($formErrors) ?>')
        const formData = JSON.parse('<?= json_encode($formData) ?>')

        // side navigation bar toggle
        $('body').attr('data-leftbar-size', 'default').addClass('sidebar-enable')
        $('.toggle-sidebar').on('click', function() {
            $('body').toggleClass('sidebar-enable')
        })

        $(document).ready(function() {
            handleFetchProducts(q)

            // form validation response handler
            switch (formMessage) {
                case 'failed':
                    // populate form with formData
                    $("#add-product").click();
                    $('#name').val(formData.name)
                    $('#price').val(formData.price)
                    $('#description').val(formData.description)
                    displayErrors()
                    break;
                case 'success':
                    toastr.success('New product added.')
                    break;
                case 'add exists':
                    toastr.error('Product name already exists.')
                    $("#add-product").click();
                    formErrors.name = 'name already exists'
                    $('#name').val(formData.name)
                    $('#price').val(formData.price)
                    $('#description').val(formData.description)
                    displayErrors()
                    break;
                case 'update exists':
                    toastr.error('Product name already exists.')
                    formErrors.name = 'name already exists'
                    $('#offcanvasRight').offcanvas('show');
                    $('#form').attr('action', '<?= site_url('admin/product_update') ?>')
                    $('#id').val(formData.id)
                    $('#name').val(formData.name)
                    $('#price').val(formData.price)
                    $('#description').val(formData.description)
                    displayErrors()
                    break;
                case 'updated':
                    toastr.info('Product updated.')
                    break;
                case 'available':
                    toastr.success('Product made available.')
                    break;
                case 'unavailable':
                    toastr.info('Product made unavailable.')
                    break;
            }
        })

        // Query data
        let q = {
            availability: 'all',
            category: 'all',
            q: 'all',
            page: 1
        }

        // handle product list request
        const handleFetchProducts = _.debounce(fetchProducts, 1000);

        // product request
        function fetchProducts(q) {
            $('tbody').html('<tr class="align-middle rounded m-1"> <th colspan="100%" scope="row" class="text-center"> <i class="fas fa-spinner fa-spin my-5 fs-1"></i></th></tr>')
            let link = `<?= site_url('admin_api/product_index') ?>/${q.page}/${q.q}/${q.category}/${q.availability}`
            axios.get(link, {
                    /* OPTIONS */
                })
                .then(function(response) {
                    populateTable(response.data)
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
        function populateTable(products) {
            products = products['products']
            $('tbody').html('');
            const keys = ['name', 'price', 'category_name', 'quantity', 'date_added', 'updated_at'];
            let imagelink = '<?= BASE_URL . 'public/images/products/cropped/' ?>'
            for (let i = 0; i < products.length; i++) {
                const tableTR = $('<tr></tr>').attr('id', products[i]['id']);
                $('tbody').append(tableTR);
                tableTR.append('<td><img src="' + imagelink + products[i]['image'] + '" alt="" height="150" width="150" class="img-fluid rounded product-image" style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#preview-image-modal"></td>')
                for (let x = 0; x < keys.length; x++) {
                    if (keys[x] == 'quantity')
                        if (products[i][keys[x]] == null)
                            tableTR.append('<td> ' + '<span class="text-start badge badge-soft-primary rounded-pill px-1 py-1 ms-2">perishable</span>' + ' </td>')
                    else
                        tableTR.append('<td> ' + products[i][keys[x]] + ' </td>')
                    else
                        tableTR.append('<td> ' + products[i][keys[x]] + ' </td>')
                }

                // available
                tableTR.append(
                    '<td class="text-center">' +
                    (products[i]['available'] ? '<span class="badge badge-soft-success rounded-pill px-1 py-1 ms-2">Available   </span>' : '<span class="badge badge-soft-danger rounded-pill px-1 py-1 ms-2">Deleted</span>') +
                    '</td>'
                )
                // action
                const isAvailableClass = products[i]['available'] ? 'make-product-available' : 'make-product-unavailable'
                const isAvailableIcon = !products[i]['available'] ? '<i class="mdi mdi-delete-restore fs-3 text-info"></i>' : '<i class="mdi mdi-delete fs-3 text-danger"></i>'
                tableTR.append(`                                                        
                    <td class="text-center">
                        <span class="btn waves-effect waves-dark p-1 py-0 shadow-lg me-1 ${isAvailableClass}">
                            ${isAvailableIcon}
                        </span>
                        <span class="btn waves-effect waves-dark p-1 py-0 shadow-lg me-1 edit-quantity" data-bs-toggle="offcanvas" data-bs-target="#edit-quantity-offcanvas" aria-controls="edit-quantity-offcanvas">
                            <i class="mdi mdi-package fs-3 text-info"></i>
                        </span>
                        <span class="btn waves-effect waves-dark p-1 py-0 shadow-lg me-1 edit-product" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                            <i class="mdi mdi-circle-edit-outline fs-3 text-info"></i>
                        </span>
                    </td>`)

                // table row for description
                $('tbody').append($('<tr></tr>').append(`
                <td class="p-0" colspan="100">                         
                    <div class="accordion accordion-flush" id="accordion-${products[i]['id']}">
                        <div class="accordion-item bg-light rounded">
                            <h2 class="accordion-header m-0" id="flush-headingOne">
                                <button class="accordion-button collapsed fw-bold  bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#flush-accordion-${products[i]['id']}" aria-expanded="true" aria-controls="flush-accordion-${products[i]['id']}">
                                    Description
                                </button>
                            </h2>
                            <div id="flush-accordion-${products[i]['id']}" class="accordion-collapse collapse bg-light" aria-labelledby="flush-headingOne" data-bs-parent="#accordion-${products[i]['id']}">
                                <div class="accordion-body">
                                &emsp; &emsp; ${products[i]['description']}
                                </div>
                            </div>
                        </div>
                    </div>
                </td>`));
            }
        }

        // product image input on change event
        $('#imageInput')[0].addEventListener('change', function() {
            $('#staticBackdrop').modal('show');
            let inputImage = document.getElementById('imageInput');
            const previewImage = document.getElementById('previewImage');
            const productImageCanvas = document.getElementById('productImageCanvas');
            const file = inputImage.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                productImageCanvas.src = e.target.result;
                initializeCropper();
            };
            reader.readAsDataURL(file);
        });

        // inititialize cropper
        let cropper

        function initializeCropper() {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            cropper = new Cropper(document.getElementById('productImageCanvas'), {
                aspectRatio: 1 / 1,
                viewMode: 0,
                minContainerWidth: 450,
                minContainerHeight: 500,
                dragMode: 'move',
                toggleDragModeOnDblclick: false,
            })
        }

        // compress image, pass to preview and make new input for base64 image
        $('#cropImageButton').on('click', function() {
            let canvas = cropper.getCroppedCanvas();
            canvas = compressImage(canvas, 500, 500);
            const dataURL = canvas.toDataURL();
            const blob = dataURLtoBlob(dataURL);
            const file = new File([blob], 'cropped.jpg', {
                type: 'image/jpeg'
            });
            const previewImage = document.getElementById('previewImage');
            previewImage.src = URL.createObjectURL(file);
            addCroppedImageInput(dataURL)
            $('#staticBackdrop').modal('hide')
        });

        // add input for cropped image
        function addCroppedImageInput(dataURL) {
            // deletes the input if exists
            if ($('input[name="croppedImage"]').length > 0)
                $('input[name="croppedImage"]').remove();
            const inputText = document.createElement('input');
            inputText.type = 'text';
            inputText.value = dataURL;
            inputText.name = 'croppedImage';
            document.getElementById('form').prepend(inputText);
            $('input[name="croppedImage"]').prop('readonly', true)
            $('input[name="croppedImage"]').prop('hidden', true)
        }

        // add product button event
        $('#add-product').on('click', function() {
            resetForm('add', this)
        })

        // edit product button event
        $(document).on('click', '.edit-product', function() {
            resetForm('update', this);
        });

        // reset form values
        function resetForm(mode, element = null) {
            $('.form-error-message').remove()
            const addProductLink = '<?= site_url('admin/product_store') ?>'
            const updateProductLink = '<?= site_url('admin/product_update') ?>'
            let previewImage = '<?= BASE_URL .  PUBLIC_DIR ?>/images/products/default.png'
            let imageInputRequired = true
            let name = ''
            let price = null;
            let category = $('#category option:first').val();
            let description = ''
            if (mode == 'add') {
                $('#offcanvasRightLabel').html('Add new product')
                $('#form').attr('action', addProductLink)
                $('#inventory-type').attr('disabled', false)
                $('#inventory-type').val('perishable')
                if ($('#inventory-type').parent().next().find('#quantity').attr('id') == 'quantity') {
                    $('#inventory-type').parent().next().remove()
                }
            } else {
                $('#form').attr('action', updateProductLink)
                $('#offcanvasRightLabel').html('Update product')
                // set inventory type value
                inventoryType = parseFloat($(element).closest('td').prev().prev().prev().prev().html().trim())
                if (isNaN(inventoryType))
                    $('#inventory-type').val('perishable')
                else {
                    $('#inventory-type').val('durable')
                    // add new quantity input
                    if ($('#inventory-type').parent().next().find('#quantity').attr('id') == 'quantity')
                        $('#inventory-type').parent().next().remove()
                    $('#inventory-type').parent().after($('<div class="mb-3"><label for="quantity" class="form-label">Quantity<span class="text-danger"> *</span></label><input style="cursor:not-allowed" disabled type="number" class="form-control" required name="quantity" value="' + $(element).closest('td').prev().prev().prev().prev().html().trim() + '" id="quantity" step="0.01" placeholder="product price"></div>'))
                }
                $('#inventory-type').attr('disabled', true)

                name = $(element).closest('td').prev().prev().prev().prev().prev().prev().prev().html().trim()
                price = $(element).closest('td').prev().prev().prev().prev().prev().prev().html().trim()
                category = $(element).closest('td').prev().prev().prev().prev().prev().html().trim()
                category = $('#category option').map(function() {
                    if ($(this).html() == category)
                        return $(this).val()
                }).get();
                description = $(element).closest('tr').next().children('td').find('div.accordion-body').html().trim();
                previewImage = $(element).closest('tr').find('td:eq(0)').find('img:eq(0)').prop('src')
                imageInputRequired = false
            }
            $('#id').val($(element).closest('tr').attr('id'))
            $('#name').val(name)
            $('#price').val(price)
            $('#category').val(category)
            $('#description').val(description)
            $('#previewImage').attr('src', previewImage)
            $('#imageInput').prop('required', imageInputRequired)
        }

        // compress cropped image
        function compressImage(image, maxWidth, maxHeight) {
            const canvas = document.createElement('canvas');
            const context = canvas.getContext('2d');
            let width = image.width;
            let height = image.height;
            if (width > height) {
                if (width > maxWidth) {
                    height *= maxWidth / width;
                    width = maxWidth;
                }
            } else {
                if (height > maxHeight) {
                    width *= maxHeight / height;
                    height = maxHeight;
                }
            }
            canvas.width = width;
            canvas.height = height;
            context.drawImage(image, 0, 0, width, height);
            return canvas;
        }

        // Helper function to convert a data URL to a Blob object
        function dataURLtoBlob(dataURL) {
            const parts = dataURL.split(';base64,');
            const contentType = parts[0].split(':')[1];
            const raw = window.atob(parts[1]);
            const rawLength = raw.length;
            const uInt8Array = new Uint8Array(rawLength);
            for (let i = 0; i < rawLength; ++i) {
                uInt8Array[i] = raw.charCodeAt(i);
            }
            return new Blob([uInt8Array], {
                type: contentType
            });
        }

        // change page
        $(document).on('click', '.page-link', changePage)

        function changePage() {
            q.page = $(this).attr('data-page')
            handleFetchProducts(q);
        }

        // search product
        $('#product-search').on('input', function() {
            q.q = $(this).val() == '' ? 'all' : $(this).val().trim()
            q.page = 1
            if (/^\s*$/.test($(this).val()))
                q.q = 'all'
            handleFetchProducts(q);
        })

        // category option event
        $(document).on('click', '.option-category', function() {
            q.category = $(this).attr('data-id')
            $(this).parent().prev().find('span:eq(0)').html($(this).html())
            q.page = 1
            handleFetchProducts(q)
        })


        $('.option-availability').on('click', function() {
            q.availability = $(this).attr('data-value')
            $(this).parent().prev().find('span:eq(0)').html($(this).html())
            q.page = 1
            handleFetchProducts(q)
        })

        // add form error
        function displayErrors() {
            for (let key in formErrors)
                $('<div class="ms-1 text-danger form-error-message">' + formErrors[key] + '</div>').insertAfter($(`#${key}`))
        }

        // show restore confirmation
        $(document).on('click', '.mdi-delete-restore', function() {
            id = $(this).closest('tr').attr('id')
            Swal.fire({
                title: 'Make product available again?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Restore'
            }).then((result) => {
                if (result.isConfirmed) {
                    handleDeleteRestoreSubmit(id, 'available')
                }
            })
        })

        // show delete confirmation
        $(document).on('click', '.mdi-delete', function() {
            id = $(this).closest('tr').attr('id')
            Swal.fire({
                title: 'Make product unavaialble??',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Continue'
            }).then((result) => {
                if (result.isConfirmed) {
                    handleDeleteRestoreSubmit(id, 'unavailable')
                }
            })
        })

        // form restore and delete submit handler
        function handleDeleteRestoreSubmit(id, httpMethod) {
            const unavailableUrl = '<?= BASE_URL ?>admin/product_unavailable';
            const availableUrl = '<?= BASE_URL ?>admin/product_available';

            var form = $('<form>');

            form.attr({
                method: 'POST',
                action: httpMethod == 'unavailable' ? unavailableUrl : availableUrl
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
            $('#available-unavailable-form').append(form);
            form.append(submitBtn);
            form.submit();
        }

        $(document).on('click', '.product-image', function() {
            $('#preview-image-label').html($(this).parent().next().html())
            $('#preview-image-modal').find('img:eq(0)').attr('src', $(this).attr('src'))
        })

        // let updateQuantityOffcanvas = 0
        $('#inventory-type, #update_inventory_type').on('change', function() {
            let element = "#" + $(this).attr('id')
            let updateQuantityOffcanvas = parseFloat($('#' + $('#update_id').val()).find('td:eq(4)').html())
            quantityId = $(this).attr('id') == 'inventory-type' ? 'quantity' : 'update_quantity'
            if ($(element).val() == 'perishable') {
                $('#update_quantity').parent().prop('hidden', true)
            } else {
                $('#update_quantity').parent().prop('hidden', false)
            }
            $('#update_quantity').val(updateQuantityOffcanvas)
        })


        $(document).on('click', '.edit-quantity', function() {
            $('.form-error-message').remove()
            const id = $(this).closest('tr').attr('id')
            const quantity = parseFloat($(this).closest('tr').find('td:eq(4)').html())
            const price = parseFloat($(this).closest('tr').find('td:eq(2)').html())
            $('#update_price').val(price)
            $('#update_inventory_type').val(isNaN(quantity) ? 'perishable' : 'durable')

            $('#update_id').val(id)
            // if isNaN is true, the product is perishable good
            if (isNaN(quantity)) {
                $('#update_quantity').parent().prop('hidden', true)
                $('#update_quantity').val(price)
            } else {
                $('#update_quantity').parent().prop('hidden', false)
                $('#update_quantity').val(quantity)
            }
        })

        $('#updateSubmitForm').on('click', function() {
            const id = $('#update_id').val()
            const inventoryType = $('#update_inventory_type').val()
            const quantity = inventoryType == 'durable' ? $('#update_quantity').val() : 0;
            const price = $('#update_price').val()
            updateInventoryRequest(id, inventoryType, quantity, price)
        })

        function updateInventoryRequest(id, inventoryType, quantity, price) {
            $.post('<?= site_url('admin_api/update-inventory') ?>', {
                    update_id: id,
                    update_inventory_type: inventoryType,
                    update_quantity: quantity,
                    update_price: price
                })
                .then(function(response) {
                    console.log(response)
                    // Success: Handle the response
                    if (response.status == 'success') {
                        Swal.fire({
                            title: 'Product update success',
                            text: "",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Understood!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '<?= site_url('admin/product') ?>'
                            }
                        })
                    } else {
                        $('.form-error-message').remove()
                        for (let key in response.errors) {
                            if (response.errors.hasOwnProperty(key)) {
                                $('<div class="ms-1 text-danger form-error-message">' + response.errors[key] + '</div>').insertAfter($(`#${key}`))
                            }
                        }
                    }
                })
        }
    </script>
</body>

</html>