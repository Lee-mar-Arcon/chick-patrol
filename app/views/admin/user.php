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
        }

        thead th:last-child {
            border-top-right-radius: 10px;
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
    <!-- Begin page -->
    <div id="wrapper">
        <?php include 'components/top-navigation.php' ?>
        <?php include 'components/side-navigation.php' ?>

        <div class="content-page">
            <div class="content">

                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            Users
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <thead>
                                        <tr>
                                            <th>First Name</th>
                                            <th>Middle Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>Contact</th>
                                            <th>Birth date</th>
                                            <th>Sex</th>
                                            <th>Date Verified</th>
                                            <th class="text-center" style="width: 120px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach (array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10) as $user) : ?>
                                            <tr class="align-middle rounded m-1">
                                                <th scope="row">1</th>
                                                <td>Mark</td>
                                                <td>Otto</td>
                                                <td>Otto</td>
                                                <td>Otto</td>
                                                <td>Otto</td>
                                                <td>Otto</td>
                                                <td>Otto</td>
                                                <td>@mdo</td>
                                                <td class="text-center">
                                                    <span class="btn waves-effect waves-dark p-1 py-0 shadow-lg me-1" aria-controls="offcanvasRight">
                                                        <i class="mdi mdi-home-edit fs-3 text-info"></i>
                                                    </span>
                                                    <span class="btn waves-effect waves-info p-1 py-0 rounded shadow-lg me-1">
                                                        <i class="mdi mdi-delete fs-3 text-danger"></i> </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?= var_dump($users) ?>

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
    <script>
        $('body').attr('data-leftbar-size', 'default').addClass('sidebar-enable')
        $('.toggle-sidebar').on('click', function() {
            $('body').toggleClass('sidebar-enable')
        })
    </script>
</body>

</html>