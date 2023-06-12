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
                                    <h1 class="display-6 fw-bold">Barangay</h1>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <div class="d-flex justify-content-end me-2 my-3">
                                            <button id="add-barangay" type="button" class="btn btn-primary rounded-pill waves-effect border-none waves-light m-2" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Add</button>
                                        </div>
                                        <table class="table table-hover table-borderless mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th class="text-center" style="width: 120px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($barangays as $barangay) : ?>
                                                    <tr id="<?= $barangay['id'] ?>">
                                                        <td class="align-middle"><?= $barangay['name'] ?></td>
                                                        <td class="text-center">
                                                            <span class="btn waves-effect waves-info p-1 py-0 shadow me-1 edit-barangay" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                                                                <i class="mdi mdi-home-edit fs-3 text-info"></i>
                                                            </span>

                                                            <span class="btn waves-effect waves-info p-1 py-0 shadow me-1">
                                                                <i class="mdi mdi-delete fs-3 text-danger"></i>
                                                            </span>
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

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                </div>
            </footer>
            <!-- end Footer -->

        </div>
    </div>

    <div class="right-bar">

        <div data-simplebar class="h-100">

            <div class="rightbar-title">
                <a href="javascript:void(0);" class="right-bar-toggle float-end">
                    <i class="mdi mdi-close"></i>
                </a>
                <h4 class="font-16 m-0 text-white">Theme Customizer</h4>
            </div>

            <!-- Tab panes -->
            <div class="tab-content pt-0">

                <div class="tab-pane active" id="settings-tab" role="tabpanel">

                    <div class="p-3">
                        <div class="alert alert-warning" role="alert">
                            <strong>Customize </strong> the overall color scheme, Layout, etc.
                        </div>

                        <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Color Scheme</h6>
                        <div class="form-check form-switch mb-1">
                            <input type="checkbox" class="form-check-input" name="layout-color" value="light" id="light-mode-check" checked />
                            <label class="form-check-label" for="light-mode-check">Light Mode</label>
                        </div>

                        <div class="form-check form-switch mb-1">
                            <input type="checkbox" class="form-check-input" name="layout-color" value="dark" id="dark-mode-check" />
                            <label class="form-check-label" for="dark-mode-check">Dark Mode</label>
                        </div>

                        <!-- Width -->
                        <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Width</h6>
                        <div class="form-check form-switch mb-1">
                            <input type="checkbox" class="form-check-input" name="layout-size" value="fluid" id="fluid" checked />
                            <label class="form-check-label" for="fluid-check">Fluid</label>
                        </div>
                        <div class="form-check form-switch mb-1">
                            <input type="checkbox" class="form-check-input" name="layout-size" value="boxed" id="boxed" />
                            <label class="form-check-label" for="boxed-check">Boxed</label>
                        </div>

                        <!-- Menu positions -->
                        <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Menus (Leftsidebar and Topbar) Positon</h6>

                        <div class="form-check form-switch mb-1">
                            <input type="checkbox" class="form-check-input" name="leftbar-position" value="fixed" id="fixed-check" checked />
                            <label class="form-check-label" for="fixed-check">Fixed</label>
                        </div>

                        <div class="form-check form-switch mb-1">
                            <input type="checkbox" class="form-check-input" name="leftbar-position" value="scrollable" id="scrollable-check" />
                            <label class="form-check-label" for="scrollable-check">Scrollable</label>
                        </div>

                        <!-- Left Sidebar-->
                        <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Left Sidebar Color</h6>

                        <div class="form-check form-switch mb-1">
                            <input type="checkbox" class="form-check-input" name="leftbar-color" value="light" id="light" />
                            <label class="form-check-label" for="light-check">Light</label>
                        </div>

                        <div class="form-check form-switch mb-1">
                            <input type="checkbox" class="form-check-input" name="leftbar-color" value="dark" id="dark" checked />
                            <label class="form-check-label" for="dark-check">Dark</label>
                        </div>

                        <div class="form-check form-switch mb-1">
                            <input type="checkbox" class="form-check-input" name="leftbar-color" value="brand" id="brand" />
                            <label class="form-check-label" for="brand-check">Brand</label>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input type="checkbox" class="form-check-input" name="leftbar-color" value="gradient" id="gradient" />
                            <label class="form-check-label" for="gradient-check">Gradient</label>
                        </div>

                        <!-- size -->
                        <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Left Sidebar Size</h6>

                        <div class="form-check form-switch mb-1">
                            <input type="checkbox" class="form-check-input" name="leftbar-size" value="default" id="default-size-check" checked />
                            <label class="form-check-label" for="default-size-check">Default</label>
                        </div>

                        <div class="form-check form-switch mb-1">
                            <input type="checkbox" class="form-check-input" name="leftbar-size" value="condensed" id="condensed-check" />
                            <label class="form-check-label" for="condensed-check">Condensed <small>(Extra Small size)</small></label>
                        </div>

                        <div class="form-check form-switch mb-1">
                            <input type="checkbox" class="form-check-input" name="leftbar-size" value="compact" id="compact-check" />
                            <label class="form-check-label" for="compact-check">Compact <small>(Small size)</small></label>
                        </div>

                        <!-- User info -->
                        <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Sidebar User Info</h6>

                        <div class="form-check form-switch mb-1">
                            <input type="checkbox" class="form-check-input" name="sidebar-user" value="true" id="sidebaruser-check" />
                            <label class="form-check-label" for="sidebaruser-check">Enable</label>
                        </div>


                        <!-- Topbar -->
                        <h6 class="fw-medium font-14 mt-4 mb-2 pb-1">Topbar</h6>

                        <div class="form-check form-switch mb-1">
                            <input type="checkbox" class="form-check-input" name="topbar-color" value="dark" id="darktopbar-check" checked />
                            <label class="form-check-label" for="darktopbar-check">Dark</label>
                        </div>

                        <div class="form-check form-switch mb-1">
                            <input type="checkbox" class="form-check-input" name="topbar-color" value="light" id="lighttopbar-check" />
                            <label class="form-check-label" for="lighttopbar-check">Light</label>
                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- end slimscroll-menu-->
    </div>
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>


    <!-- Off Canvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 class="fs-3" id="offcanvasRightLabel">Offcanvas right</h5>
            <button type="button" class="me-1 btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body">

            <div class="mb-3 mt-2">
                <label for="name" class="form-label">Name<span class="text-danger"> *</span></label>
                <input type="text" parsley-trigger="change" required="" placeholder="Enter Barangay name" class="form-control parsley-error" id="name" data-parsley-id="27" aria-describedby="parsley-id-27">
                <ul class="parsley-errors-list filled" id="parsley-id-27" aria-hidden="false">
                    <li class="parsley-required">This value is required.</li>
                </ul>
            </div>
            <div class="text-end mt-3">
                <button class="btn btn-primary waves-effect waves-light" type="submit">Submit</button>
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
    <script src="<?= BASE_URL . PUBLIC_DIR ?>/admin/assets/libs/tippy.js/tippy.all.min.js"></script>
    <!-- App js -->
    <script src="<?= BASE_URL . PUBLIC_DIR ?>/admin/assets/js/app.min.js"></script>
    <script>
        $('body').attr('data-leftbar-size', 'default').addClass('sidebar-enable')
        $('.toggle-sidebar').on('click', function() {
            $('body').toggleClass('sidebar-enable')
        })

        $('#add-barangay').on('click', function() {
            $('#name').val('')
            $('#offcanvasRightLabel').html('Add new barangay')
        })

        $('.edit-barangay').on('click', function() {
            $('#offcanvasRightLabel').html('Edit barangay')
            $('#name').val($(this).closest('td').prev().html())
            console.log($(this).closest('tr').attr('id'))
        })
    </script>
</body>

</html>