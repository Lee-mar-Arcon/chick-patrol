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
                    <button id="add-category" type="button" class="btn btn-primary rounded-pill waves-effect border-none waves-light m-2" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Add</button>
                    <div>
                        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR6xqv6D-Y1xtgjbNFj2Nn7cxozx326y2ijjZLpyVWnJQ&s" alt="" id="productImageCanvas" class="img">
                        <button id="cropImageButton">crop</button>
                    </div>
                    <div>
                        <div id="croppedImage"></div>
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
            <h5 class="fs-3" id="offcanvasRightLabel"></h5>
            <button type="button" class="me-1 btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <form method="post" action="" id="form" class="offcanvas-body">
            <input type="hidden" id="id" name="id">



            <label for="example-fileinput" class="form-label text-center w-100 mb-2">Product Image</label>
            <div class="text-center">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR6xqv6D-Y1xtgjbNFj2Nn7cxozx326y2ijjZLpyVWnJQ&s" alt="" id="previewImage" class="img-fluid rounded mb-3">
                <input type="file" id="imageInput" class="form-control">
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
            let inputImage = document.getElementById('imageInput');
            const previewImage = document.getElementById('previewImage');
            const productImageCanvas = document.getElementById('productImageCanvas');
            const file = inputImage.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;
                productImageCanvas.src = e.target.result;
                initializeCropper();
            };
            reader.readAsDataURL(file);
        });

        let cropper;
        // init cropper
        function initializeCropper() {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }

            cropper = new Cropper(document.getElementById('productImageCanvas'), {
                aspectRatio: 1 / 1,
                viewMode: 1,
            });
        }

        $('#cropImageButton').on('click', function() {
            uploadImage(passCroppedPhoto());
        });

        function passCroppedPhoto() {
            if (!cropper) {
                return;
            }

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

            // Make a POST request to the server to upload the file
            fetch('/admin_api/upload_image', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    // Handle the response from the server
                    return response.json(); // Assuming the response is JSON
                })
                .then(data => {
                    // Log the response data in the console
                    console.log(data);
                })
                .catch(error => {
                    // Handle any errors
                    console.error('Error uploading file:', error);
                });

        }
    </script>
</body>

</html>