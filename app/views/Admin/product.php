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
                            <button id="add-product" type="button" class="btn btn-primary rounded-pill waves-effect border-none waves-light" data-bs-toggle="offcanvas" data-bs-target="#productForm" aria-controls="offcanvasRight">Add</button>
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
                                                <button class="dropdown-item option-availability" data-value="1">Selling</button>
                                                <button class="dropdown-item option-availability" data-value="0">Archived</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn-group-vertical row bg-primary rounded text-white text-center fs-6 fw-bold m-0 p-1">
                                        <div class="d-flex justify-content-center bg-primary text-white w-100 px-3 py-1">Category</div>
                                        <button type="button" class="btn bg-white text-dark text-white p-1 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"> <span>All</span> <i class="mdi mdi-chevron-down"></i> </button>
                                        <div class="dropdown-menu">
                                            <button class="dropdown-item option-category" data-id="all">All</button>
                                            <?php foreach ($categories as $category) : ?>
                                                <button style="text-wrap: wrap;" class="dropdown-item option-category" data-id="<?= ucwords($category['id']) ?>">
                                                    <?= ucwords($category['name']) ?>
                                                </button>
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
                                            <th class="text-center">Inventory type</th>
                                            <th class="text-center">Quantity</th>
                                            <th style="width: 130px;">Date added</th>
                                            <th style="width: 130px;">Updated at</th>
                                            <th class="text-center" style="width: 130px;">Selling </th>
                                            <th class="text-center" style="width: 270px;">Action</th>
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
    <div class="offcanvas offcanvas-end" tabindex="-1" id="productForm" aria-labelledby="productFormLabel">
        <div class="offcanvas-header">
            <h5 class="fs-3 ms-2" id="productFormLabel"></h5>
            <button type="button" class="me-1 btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div method="post" action="" id="form" class="offcanvas-body" enctype="multipart/form-data">
            <input type="hidden" id="id" name="id">
            <!-- Image -->
            <label for="example-fileinput" class="form-label text-center fs-3 w-100">Product Image</label>
            <div class="text-center">
                <img src="<?= BASE_URL .  PUBLIC_DIR ?>/images/products/default.png" alt="" id="previewImage" height="150" width="150" class="img-fluid rounded my-2 mb-5">
                <input type="file" id="imageInput" name="imageInput" class="form-control" accept="image/png, image/jpg, image/jpeg">
                <div class="text-danger fs-6 text-start ps-1 validation-error">&nbsp;</div>
            </div>

            <!-- product name -->
            <div class="mb-3 mt-2">
                <label for="name" class="form-label">Product name<span class="text-danger"> *</span></label>
                <input type="text" placeholder="Enter product name" class="form-control" id="name" name="name">
                <div class="text-danger fs-6 text-start ps-1 validation-error">&nbsp;</div>
            </div>

            <!-- category -->
            <div class="mb-3">
                <label for="category" class="form-label">Category<span class="text-danger"> *</span></label>
                <select class="form-select form-select-md" name="category" id="category">
                    <?php foreach ($categoriesForForm as $category) : ?>
                        <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <div class="text-danger fs-6 text-start ps-1 validation-error">&nbsp;</div>
            </div>

            <!-- inventory type -->
            <div class="mb-3">
                <label for="inventory_type" class="form-label">Inventory type<span class="text-danger"> *</span></label>
                <select class="form-select form-select-md" name="inventory_type" id="inventory_type">
                    <option value="perishable" selected>Perishable</option>
                    <option value="durable">Durable goods</option>
                </select>
                <div class="text-danger fs-6 text-start ps-1 validation-error">&nbsp;</div>
            </div>

            <!-- quantity -->
            <div class="mb-3" hidden>
                <label for="quantity" class="form-label">Quantity
                    <span class="text-danger"> *</span>
                </label>
                <input type="number" class="form-control" name="quantity" id="quantity" step="0.01" placeholder="product price">
                <div class="text-danger fs-6 text-start ps-1 validation-error">&nbsp;</div>
            </div>

            <!-- expiration date -->
            <div class="mb-3" hidden>
                <label for="expiration_date" class="form-label">Expiration Date<span class="text-danger"> *</span></label>
                <input type="date" placeholder="Enter product name" class="form-control" id="expiration_date" name="expiration_date">
                <div class="text-danger fs-6 text-start ps-1 validation-error">&nbsp;</div>
            </div>

            <!-- price -->
            <div class="mb-3">
                <label for="price" class="form-label">price<span class="text-danger"> *</span></label>
                <input type="number" class="form-control" name="price" id="price" step="0.01" placeholder="product price">
                <div class="text-danger fs-6 text-start ps-1 validation-error">&nbsp;</div>
            </div>

            <!-- description -->
            <div class="mb-3">
                <label for="description" class="form-label">description<span class="text-danger"> *</span></label>
                <textarea class="form-control" name="description" id="description" rows="12"></textarea>
                <div class="text-danger fs-6 text-start ps-1 validation-error">&nbsp;</div>
            </div>
            <div class="text-end mt-3">
                <button id="submit-form" class="btn btn-primary waves-effect waves-light" type="submit">Submit</button>
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
            console.log(products)
            products = products['products']
            $('tbody').html('');
            const productLink = '<?= BASE_URL ?>/public/images/products/cropped/'
            const viewProductLink = '<?= site_url('admin/view-product') . '/' ?>'
            for (let i = 0; i < products.length; i++) {
                $('tbody').append(
                    `
                    <tr id="${products[i]['id']}">
                        <td>
                            <img src="${productLink +  products[i]['image']}" alt="" height="150" width="150" class="img-fluid rounded product-image" style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#preview-image-modal">
                        </td>
                        <td> ${products[i]['name']} </td>
                        <td>₱ ${parseFloat(products[i]['price']).toFixed(2)} </td>
                        <td> ${products[i]['category_name']} </td>
                        <td class="text-center"> 
                            ${products[i]['inventory_type'] == 'durable' ? 
                                '<span class="text-start badge badge-soft-primary rounded-pill px-1 py-1 ms-2">durable</span>' : 
                                '<span class="text-start badge badge-soft-warning rounded-pill px-1 py-1 ms-2">perishable</span>'} 
                        </td>
                        <td class="text-center"> 
                            ${products[i]['available_quantity'] == null ? 0 : products[i]['available_quantity']} 
                        </td>
                        <td> ${products[i]['date_added']} </td>
                        <td> ${products[i]['updated_at']} </td>
                        <td class="text-center">
                            ${products[i]['selling'] == 1 ? 
                                '<span class="badge badge-soft-success rounded-pill px-1 py-1 ms-2"> Selling </span>' : 
                                '<span class="badge badge-soft-danger rounded-pill px-1 py-1 ms-2"> Archived </span>'}
                        </td>
                        <td class="text-center">
                            <span data-tippy-content="Delete Permanently" class="btn waves-effect waves-dark p-1 py-0 shadow-lg me-1 delete-product">
                                <i class="mdi mdi-delete fs-3 text-danger"></i>
                            </span>
                            <a href="${viewProductLink + products[i]['id']}" data-tippy-content="View product" class="btn waves-effect waves-dark p-1 py-0 shadow-lg me-1">
                                <i class="mdi mdi-eye fs-3 text-info"></i>
                            </a>
                            <span data-tippy-content="${products[i]['selling'] == 1 ? 'archive product' : 'sell product'}" class="btn waves-effect waves-dark p-1 py-0 shadow-lg me-1 sell-archive-product ${products[i]['selling'] ? 'archive-product' : 'sell-product'}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                ${products[i]['selling'] == 1 ? 
                                    '<i class="mdi mdi-tag-off fs-3 text-danger"></i>' :
                                    '<i class="mdi mdi-tag fs-3 text-info"></i>'
                                }    
                            </span>
                            <span data-tippy-content="${products[i]['featured'] == 1 ? 'remove to featured' : 'add to featured'}" class="btn waves-effect waves-dark p-1 py-0 shadow-lg me-1 remove-feature-product ${products[i]['featured'] ? 'remove-featured' : 'add-featured'}" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                ${products[i]['featured'] == 1 ? 
                                    '<i class="mdi mdi-star-remove-outline fs-3 text-danger"></i>' :
                                    '<i class="mdi mdi-star-outline fs-3 text-info"></i>'
                                }    
                            </span>
                            <span data-tippy-content="Edit product" class="btn waves-effect waves-dark p-1 py-0 shadow-lg me-1 edit-product" data-bs-toggle="offcanvas" data-bs-target="#productForm" aria-controls="offcanvasRight">
                                <i class="mdi mdi-circle-edit-outline fs-3 text-info"></i>
                            </span>
                        </td>
                    </tr>
                    `
                );
                $('tbody').append(
                    `
                    <tr>
                        <td class="p-0" colspan="100">
                            <div class="accordion accordion-flush" id="accordion-${products[i]['id']}">
                                <div class="accordion-item bg-light rounded">
                                    <h2 class="accordion-header m-0" id="flush-headingOne">
                                        <button class="accordion-button fw-bold bg-transparent collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-accordion-${products[i]['id']}" aria-expanded="false" aria-controls="flush-accordion-${products[i]['id']}">
                                            Description
                                        </button>
                                    </h2>
                                    <div id="flush-accordion-${products[i]['id']}" class="accordion-collapse bg-light collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordion-${products[i]['id']}" style="">
                                        <div class="accordion-body">
                                            ${products[i]['description']}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    `
                );
            }
            tippy('[data-tippy-content]');
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
            if ($('#croppedImage').length > 0)
                $('#croppedImage').remove();
            const inputText = document.createElement('input');
            inputText.type = 'text';
            inputText.value = dataURL;
            inputText.id = 'croppedImage';
            document.getElementById('form').prepend(inputText);
            $('#croppedImage').prop('readonly', true)
            $('#croppedImage').prop('hidden', true)
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

        // show restore confirmation
        $(document).on('click', '.mdi-delete-restore', function() {
            id = $(this).closest('tr').attr('id')
            Swal.fire({
                title: 'Sell product again?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Restore'
            }).then((result) => {
                if (result.isConfirmed) {
                    handleDeleteRestoreSubmit(id, 'selling')
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






























        $('#add-product').on('click', function() {
            resetForm()
            $('#productFormLabel').addClass('add').removeClass('edit').html('ADD NEW PRODUCT')
            $('#imageInput').attr('required', true)
            $('#inventory_type').attr('disabled', false).parent().attr('hidden', false)
        })

        $(document).on('click', '.edit-product', function() {
            resetForm()
            let productRow = $(this).closest('tr')
            $('#category').val($("#category option:contains('" + productRow.find('td:eq(3)').html().trim() + "')").attr('value'))
            $('#price').val(parseFloat(productRow.find('td:eq(2)').html().trim().substring(1)))
            $('#name').val(productRow.find('td:eq(1)').html().trim())
            $('#description').val(productRow.next().find('.accordion-body:eq(0)').html().trim())
            $('#productFormLabel').addClass('edit').removeClass('add').html('EDIT PRODUCT')
            $('#imageInput').prop('required', false)
            $('#inventory_type').attr('disabled', true).parent().attr('hidden', true)
            $('#id').val($(this).closest('tr').attr('id'))
        });

        $('#inventory_type').on('change', function() {
            toggleQuantityExpirationDate($(this))
        })


        $('#submit-form').on('click', function() {
            if ($('#productFormLabel').hasClass('add'))
                addNewProduct()
            else
                updateProduct()
        })

        function toggleQuantityExpirationDate(inventoryTypeElement) {
            if ($(inventoryTypeElement).val() == 'durable') {
                $('#quantity').attr('required', true).parent().attr('hidden', false)
                $('#expiration_date').attr('required', true).parent().attr('hidden', false)
            } else {
                $('#quantity').attr('required', false).parent().attr('hidden', true)
                $('#expiration_date').attr('required', false).parent().attr('hidden', true)
            }
        }

        function updateProduct() {
            const formData = new FormData();
            formData.append('id', $('#id').val());
            formData.append('name', $('#name').val());
            formData.append('category', $('#category').val());
            formData.append('price', $('#price').val());
            formData.append('description', $('#description').val());
            if (typeof $('#imageInput')[0].files[0] !== 'undefined') {
                formData.append('croppedImage', $('#croppedImage').val());
                formData.append('imageInput', $('#imageInput')[0].files[0]);
            }

            $.ajax({
                url: '<?= site_url('admin_api/product-update') ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response)
                    if (typeof response == 'object') {
                        setValidationErrors(response)
                    } else {
                        showToast('Product updated.', "linear-gradient(to right,  #3ab902, #14ac34)")
                        handleFetchProducts(q)
                        $('#productForm').offcanvas('hide')
                    }
                },
                error: function(xhr, status, error) {
                    console.log("Error:", error);
                }
            });
        }

        function addNewProduct() {
            const formData = new FormData();
            formData.append('name', $('#name').val());
            formData.append('category', $('#category').val());
            formData.append('inventory_type', $('#inventory_type').val());
            formData.append('price', $('#price').val());
            formData.append('croppedImage', $('#croppedImage').val());
            formData.append('description', $('#description').val());
            formData.append('imageInput', $('#imageInput')[0].files[0]);
            if ($('#inventory_type').val() == 'durable') {
                formData.append('expiration_date', $('#expiration_date').val());
                formData.append('quantity', $('#quantity').val());
            }
            $.ajax({
                url: '<?= site_url('admin_api/product_store') ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (typeof response === 'object')
                        setValidationErrors(response)
                    else {
                        resetForm()
                        showToast('Product added successfully.', "linear-gradient(to right,  #3ab902, #14ac34)")
                        handleFetchProducts(q)
                        $('#productForm').offcanvas('hide');
                    }
                }
            });
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
            let previewImage = '<?= BASE_URL .  PUBLIC_DIR ?>/images/products/default.png'
            $('#name').val('')
            $('#price').val('')
            $('#category').val($('#category').find('option:eq(0)').val())
            $('#inventory_type').val($('#inventory_type').find('option:eq(0)').val())
            toggleQuantityExpirationDate($('#inventory_type'))
            $('#description').val('')
            $('#quantity').val('')
            $('#expiration_date').val('')
            $('#previewImage').attr('src', previewImage)
            $('#imageInput').val(null)
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


        $(document).on('click', '.sell-archive-product', function() {
            let productID = $(this).closest('tr').attr('id')
            const mode = $(this).hasClass('sell-product')
            Swal.fire({
                title: mode ? 'Start selling the product?' : 'Are you sure to archive this product?',
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
                    return sellArchiveProduct(password, productID, mode ? 1 : 0);
                }
            }).then((result) => {
                if (result.isConfirmed) {

                }
            });
        })

        function sellArchiveProduct(password, productID, mode) {
            return new Promise(function(resolve, reject) {
                $.post('<?= site_url('admin_api/sell-archive-product') ?>', {
                        password: password,
                        product_id: productID,
                        mode: mode
                    })
                    .then(function(response) {
                        if (response == 'wrong password') {
                            showToast('you entered the wrong password', "linear-gradient(to right, #ac1414, #f12b00)")
                            resolve(false)
                        } else if (response == 'invalid ID') {
                            showToast('ID does not exists', "linear-gradient(to right, #ac1414, #f12b00)")
                            resolve(false)
                        } else {
                            showToast(mode ? 'Started selling the product!.' : 'Product archived', "linear-gradient(to right,  #3ab902, #14ac34)")
                            handleFetchProducts(q)
                            resolve(true)
                        }
                    })
            })
        }
























        $(document).on('click', '.remove-feature-product', function() {
            let productID = $(this).closest('tr').attr('id')
            const mode = $(this).hasClass('add-featured')
            Swal.fire({
                title: mode ? 'Add product to featured?' : 'Remove product to featured?',
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
                    return featureRemoveFeaturedProduct(password, productID, mode ? 1 : 0);
                }
            }).then((result) => {
                if (result.isConfirmed) {

                }
            });
        })

        function featureRemoveFeaturedProduct(password, productID, mode) {
            return new Promise(function(resolve, reject) {
                $.post('<?= site_url('admin_api/feature-remove-feature-product') ?>', {
                        password: password,
                        product_id: productID,
                        mode: mode
                    })
                    .then(function(response) {
                        if (response == 'wrong password') {
                            showToast('you entered the wrong password', "linear-gradient(to right, #ac1414, #f12b00)")
                            resolve(false)
                        } else if (response == 'invalid ID') {
                            showToast('ID does not exists', "linear-gradient(to right, #ac1414, #f12b00)")
                            resolve(false)
                        } else {
                            showToast(mode ? 'Product added to featured!.' : 'Product removed to featured', "linear-gradient(to right,  #3ab902, #14ac34)")
                            handleFetchProducts(q)
                            resolve(true)
                        }
                    })
            })
        }
    </script>
</body>

</html>