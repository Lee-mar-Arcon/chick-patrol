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
                                <div>
                                    <!-- <div class="btn-group-vertical row bg-primary rounded text-white text-center fs-6 fw-bold m-0 p-1">
                                        <div class="d-flex justify-content-center bg-primary text-white w-100 px-3 py-1">status</div>
                                        <button type="button" class="btn bg-white text-dark text-white p-1 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"> All <i class="mdi mdi-chevron-down"></i> </button>
                                        <div class="dropdown-menu">
                                            <button class="dropdown-item status">All</button>
                                            <button class="dropdown-item status">Banned</button>
                                            <button class="dropdown-item status">Active</button>
                                        </div>
                                    </div> -->
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
                                            <th style="width: 130px;">Date added</th>
                                            <th style="width: 130px;">Updated at</th>
                                            <th class="text-center" style="width: 120px;">Action</th>
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

            <!-- Image -->
            <label for="example-fileinput" class="form-label text-center fs-3 w-100">Product Image</label>
            <div class="text-center">
                <img src="<?= BASE_URL .  PUBLIC_DIR ?>/images/products/default.png" alt="" id="previewImage" height="150" width="150" class="img-fluid rounded my-2 mb-5">
                <input type="file" id="imageInput" name="imageInput" class="form-control" required accept="image/png, image/jpg, image/jpeg">
            </div>

            <!-- product name -->
            <div class="mb-3 mt-2">
                <label for="name" class="form-label">Product name<span class="text-danger"> *</span></label>
                <input type="text" placeholder="Enter product name" class="form-control" id="name" name="name" required>
            </div>

            <!-- category -->
            <div class="mb-3">
                <label for="category" class="form-label">Category<span class="text-danger"> *</span></label>
                <select class="form-select form-select-md" name="category" id="category" required>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- price -->
            <div class="mb-3">
                <label for="price" class="form-label">price<span class="text-danger"> *</span></label>
                <input required type="number" class="form-control" name="price" id="price" step="0.01" placeholder="product price">
            </div>

            <!-- description -->
            <div class="mb-3">
                <label for="description" class="form-label">description<span class="text-danger"> *</span></label>
                <textarea required class="form-control" name="description" id="description" rows="3"></textarea>
            </div>
            <div class="text-end mt-3">
                <button id="submit-form" class="btn btn-primary waves-effect waves-light" type="submit">Submit</button>
            </div>
        </form>
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
        let q = {
            // status: 'all',
            q: 'all',
            page: 1
        }

        $(document).ready(function() {
            handleFetchProducts(q)
        })

        // handle product request
        const handleFetchProducts = _.debounce(fetchProducts, 1000);

        // product request
        function fetchProducts(q) {
            $('tbody').html('<tr class="align-middle rounded m-1"> <th colspan="100%" scope="row" class="text-center"> <i class="fas fa-spinner fa-spin my-5 fs-1"></i></th></tr>')
            let link = `<?= site_url('admin_api/product_index') ?>/${q.page}/${q.q}/`
            axios.get(link, {
                    /* OPTIONS */
                })
                .then(function(response) {
                    populateTable(response.data)
                    populatePagination(response.data['pagination'])
                    console.log(response)
                })
                .catch(function(error) {
                    console.log(error);
                })
                .finally(function() {});
        }

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
                    console.log('-')
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

        function populateTable(products) {
            products = products['products']
            $('tbody').html('');
            const keys = ['name', 'price', 'category_name', 'updated_at', 'date_added'];
            let imagelink = '<?= BASE_URL . 'public/images/products/cropped/' ?>'
            for (let i = 0; i < products.length; i++) {
                const tableTR = $('<tr></tr>').attr('id', products[i]['id']);
                $('tbody').append(tableTR);
                tableTR.append('<td><img src="' + imagelink + products[i]['image'] + '" alt="" id="previewImage" height="150" width="150" class="img-fluid rounded"></td>')
                for (let x = 0; x < keys.length; x++) {
                    tableTR.append('<td> ' + products[i][keys[x]] + ' </td>')
                }
                tableTR.append(`                                                        
                    <td class="text-center">
                        <span class="btn waves-effect waves-dark p-1 py-0 shadow-lg me-1 edit-category" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                            <i class="mdi mdi-circle-edit-outline fs-3 text-info"></i>
                        </span>
                    </td>`)
                let description = '<div class="mb-3">' + products[i]['description'] + '</div>';
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
                                ${products[i]['description']}
                                </div>
                            </div>
                        </div>
                    </div>
                </td>`));
            }
        }

        // form validation response handler
        const formMessage = '<?= $formMessage ?>'
        switch (formMessage) {
            case '':
                break;
            case 'success':
                toastr.success('New product added.')
                break;
            case 'exists':
                toastr.info('Category already exists.')
                break;
            case 'restored':
                toastr.info('Category restored.')
                break;
            case 'updated':
                toastr.info('Category updated.')
                break;
        }

        // side navigation bar toggle
        $('body').attr('data-leftbar-size', 'default').addClass('sidebar-enable')
        $('.toggle-sidebar').on('click', function() {
            $('body').toggleClass('sidebar-enable')
        })

        // input file click event
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
            $('#cropImageModal').modal('show')
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
                viewMode: 1,
                minContainerWidth: 450,
                minContainerHeight: 500,
                dragMode: 'move',
                toggleDragModeOnDblclick: false,
            })
        }

        // crop image button click event
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
        // add product button
        $('#add-product').on('click', function() {
            resetForm()
        })

        // reset form values
        function resetForm(mod) {
            const addProductLink = '<?= site_url('admin/product_store') ?>'
            $('#form').attr('action', addProductLink)
            $('#offcanvasRightLabel').html('Add new product')
            $('#name').val('')
            $('#imageInput').val('')
            $('#category').val('')
            $('#price').val('')
            $('#description').val('')
            $('#previewImage').attr('src', '<?= BASE_URL .  PUBLIC_DIR ?>/images/products/default.png')
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
    </script>
</body>

</html>