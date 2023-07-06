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
</head>

<!-- body start -->

<body class="loading" data-layout-color="light" data-layout-mode="default" data-layout-size="fluid" data-topbar-color="light" data-leftbar-position="fixed" data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='false'>
    <div id="wrapper">
        <?php include 'components/top-navigation.php' ?>
        <?php include 'components/side-navigation.php' ?>
        <div class="content-page">
            <div class="content">
                <div class="container-fluid">
                    content here

                    <button id="add-product" type="button" class="btn btn-primary rounded-pill waves-effect border-none waves-light m-2" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Add</button>
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
        <form method="post" action="" id="form" class="offcanvas-body">

            <!-- Image -->
            <label for="example-fileinput" class="form-label text-center fs-3 w-100">Product Image</label>
            <div class="text-center">
                <img src="<?= BASE_URL .  PUBLIC_DIR ?>/images/products/default.png" alt="" id="previewImage" height="150" width="150" class="img-fluid rounded my-2 mb-5">
                <input type="file" id="imageInput" class="form-control" required>
            </div>

            <!-- product name -->
            <div class="mb-3 mt-2">
                <label for="name" class="form-label">Product name<span class="text-danger"> *</span></label>
                <input type="text" placeholder="Enter product name" class="form-control" id="name" name="name" required>
            </div>

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
                <input type="number" class="form-control" name="price" id="price" placeholder="product price">
            </div>
            <!-- description -->
            <div class="mb-3">
                <label for="description" class="form-label">description<span class="text-danger"> *</span></label>
                <textarea class="form-control" name="description" id="description" rows="3"></textarea>
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
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
    <script>
        $('body').attr('data-leftbar-size', 'default').addClass('sidebar-enable')
        $('.toggle-sidebar').on('click', function() {
            $('body').toggleClass('sidebar-enable')
        })

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

        // init cropper
        let cropper;

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

        $('#cropImageButton').on('click', function() {
            let canvas = cropper.getCroppedCanvas();
            canvas = compressImage(canvas, 300, 300);
            const dataURL = canvas.toDataURL();
            const blob = dataURLtoBlob(dataURL);
            const file = new File([blob], 'cropped.jpg', {
                type: 'image/jpeg'
            });
            const previewImage = document.getElementById('previewImage');
            previewImage.src = URL.createObjectURL(file);
        });

        function passCroppedPhoto() {
            if (!cropper)
                return;
            let canvas = cropper.getCroppedCanvas();
            canvas = compressImage(canvas, 300, 300);
            const dataURL = canvas.toDataURL();
            const blob = dataURLtoBlob(dataURL);
            const file = new File([blob], 'cropped.jpg', {
                type: 'image/jpeg'
            });
            const previewImage = document.getElementById('previewImage');
            previewImage.src = URL.createObjectURL(file);
            return file;
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

        function uploadImage(file) {
            const formData = new FormData();
            formData.append('croppedImage', file);
            fetch('/admin_api/upload_image', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    return response.json();
                })
                .then(data => {
                    console.log(data);
                })
                .catch(error => {
                    console.error('Error uploading file:', error);
                });
        }

        // submit form
        $('#submit-form').on('click', function() {
            uploadImage(passCroppedPhoto());
        })

        // add product button
        $('#add-product').on('click', function() {
            resetForm()
        })

        function resetForm() {
            $('#offcanvasRightLabel').html('Add new product')
            $('#name').val('')
            $('#imageInput').val('')
            $('#category').val('')
            $('#price').val('')
            $('#description').val('')
            $('#previewImage').attr('src', '<?= BASE_URL .  PUBLIC_DIR ?>/images/products/default.png')
        }
    </script>
</body>

</html>