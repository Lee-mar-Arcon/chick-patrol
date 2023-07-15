<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');
$LAVA = lava_instance();
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
    <!-- App favicon -->
    <!-- App css -->
    <link href="<?= BASE_URL . PUBLIC_DIR ?>/admin/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />
    <!-- icons -->
    <link href="<?= BASE_URL . PUBLIC_DIR ?>/admin/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- toastr -->
    <link rel="stylesheet" href="<?= BASE_URL . PUBLIC_DIR ?>/libraries/toastr.css">
    <!-- Sweet alert -->
    <link href="<?= BASE_URL . PUBLIC_DIR ?>/admin/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <!-- cropper css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" />

</head>

<!-- body start -->

<body class="loading" data-layout-color="light" data-layout-mode="default" data-layout-size="fluid" data-topbar-color="light" data-leftbar-position="fixed" data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='false'>
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
                                    <h1 class="display-6 fw-bold">Categories</h1>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <div class="d-flex justify-content-end me-2 my-0">
                                            <button id="add-category" type="button" class="btn btn-primary rounded-pill waves-effect border-none waves-light m-2" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Add</button>
                                        </div>
                                        <table class="table table-hover table-borderless mb-0">
                                            <thead>
                                                <tr>
                                                    <th style="width: 150px;"></th>
                                                    <th>Name</th>
                                                    <th style="width: 150px;">Deleted at</th>
                                                    <th class="text-center" style="width: 120px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($categories as $category) : ?>
                                                    <tr id="<?= $category['id'] ?>">
                                                        <td>
                                                            <img src="<?= BASE_URL . 'public/images/category/cropped/' .  $category['image'] ?>" alt="" height="150" width="150" class="img-fluid rounded category-image" style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#preview-image-modal">
                                                        </td>
                                                        <td class="align-middle">
                                                            <span><?= $category['name'] ?></span>
                                                            <?= $category['deleted_at'] ? ' <span class="badge badge-soft-danger rounded-pill px-1 py-1 ms-2">Deleted</span>' : '' ?>
                                                        </td>
                                                        <td class="align-middle">
                                                            <?= $category['deleted_at'] ?
                                                                date('M-d Y h:i:s A', strtotime($category['deleted_at'])) :
                                                                '' ?>
                                                        </td>
                                                        <td class="text-center" style="vertical-align: middle;">
                                                            <div class="btn waves-effect waves-dark p-1 py-0 shadow-lg me-1 edit-category" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                                                <i class="mdi mdi-circle-edit-outline fs-3 text-info"></i>
                                                            </div>
                                                            <div class="btn waves-effect waves-info p-1 py-0 shadow-lg me-1">
                                                                <?= $category['deleted_at'] ?
                                                                    '<i class="mdi mdi-delete-restore fs-3 text-info"></i>' :
                                                                    '<i class="mdi mdi-delete fs-3 text-danger"></i>' ?>
                                                            </div>
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

            <footer class="footer">
                <div class="container-fluid">
                </div>
            </footer>
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

    <!-- Off Canvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 class="fs-3" id="offcanvasRightLabel"></h5>
            <button type="button" class="me-1 btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <form method="post" action="" id="form" class="offcanvas-body" enctype="multipart/form-data">
            <input type="hidden" id="id" name="id">
            <!-- Image -->
            <label for="example-fileinput" class="form-label text-center fs-3 w-100">Category Image</label>
            <div class="text-center">
                <img src="<?= BASE_URL .  PUBLIC_DIR ?>/images/products/default.png" alt="" id="previewImage" height="150" width="150" class="img-fluid rounded my-2 mb-5">
                <input type="file" id="imageInput" required name="imageInput" class="form-control" accept="image/png, image/jpg, image/jpeg, image/webp">
            </div>
            <div class="mb-3 mt-2">
                <label for="name" class="form-label">Name<span class="text-danger"> *</span></label>
                <input type="text" required="" placeholder="Enter category name" class="form-control" id="name" name="name">
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
                        <img alt="" id="categoryImageCanvas" class="img">
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
    <!-- cropper js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script src="<?= BASE_URL ?>node_modules/cropperjs/dist/cropper.min.js"></script>

    <script>
        // form validation response handler
        const formMessage = '<?= $formMessage ?>'
        const formData = JSON.parse('<?= json_encode($formData) ?>')

        switch (formMessage) {
            case '':
                break;
            case 'success':
                toastr.success('New category added.')
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
            case 'upload error':
                toastr.error('Image upload error.')
                break;
        }


        $('body').attr('data-leftbar-size', 'default').addClass('sidebar-enable')
        $('.toggle-sidebar').on('click', function() {
            $('body').toggleClass('sidebar-enable')
        })

        function updateForm(url, formHeader, imageLink = '') {
            $('#form').attr('action', url)
            if (imageLink.length > 0)
                $('#previewImage').attr('src', imageLink)
            else
                $('#previewImage').attr('src', '<?= BASE_URL .  PUBLIC_DIR ?>/images/products/default.png')
            $('#offcanvasRightLabel').html(formHeader)
            // reset input values
            $('#name').val('')
        }

        $('#add-category').on('click', function() {
            $('#imageInput').prop('required', true)
            updateForm('<?= BASE_URL ?>admin/category_store', 'Add new category')
        })

        $('.edit-category').on('click', function() {
            $('#imageInput').prop('required', false)
            $('#offcanvasRightLabel').html('Edit category')
            updateForm('<?= BASE_URL ?>admin/category_update', 'Update category', $(this).closest('td').prev().prev().prev().find('img:eq(0)').attr('src'))
            $('#id').val($(this).closest('tr').attr('id'))
            $('#name').val($(this).closest('td').prev().prev().children('span:first-child').html())
        })

        // show delete confirmation
        $('.mdi-delete').on('click', function() {
            id = $(this).closest('tr').attr('id')
            Swal.fire({
                title: 'Delete category?',
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

        // show restore confirmation
        $('.mdi-delete-restore').on('click', function() {
            id = $(this).closest('tr').attr('id')
            Swal.fire({
                title: 'Restore category?',
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

        // form restore and delete submit handler
        function handleDeleteRestoreSubmit(id, httpMethod) {
            const deleteUrl = '<?= BASE_URL ?>admin/category_destroy';
            const restoreUrl = '<?= BASE_URL ?>admin/category_restore';
            $('body').append($('<div></div>').attr({
                id: 'delete-restore-form'
            }))
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

        // product image input on change event
        $('#imageInput')[0].addEventListener('change', function() {
            $('#staticBackdrop').modal('show');
            let inputImage = document.getElementById('imageInput');
            const previewImage = document.getElementById('previewImage');
            const categoryImageCanvas = document.getElementById('categoryImageCanvas');
            const file = inputImage.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                categoryImageCanvas.src = e.target.result;
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
            cropper = new Cropper(document.getElementById('categoryImageCanvas'), {
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

        $(document).on('click', '.category-image', function() {
            console.log($(this).attr('src'))
            $('#preview-image-label').html($(this).parent().next().html())
            $('#preview-image-modal').find('img:eq(0)').attr('src', $(this).attr('src'))
        })
    </script>
</body>

</html>