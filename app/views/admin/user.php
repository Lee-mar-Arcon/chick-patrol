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

        #table-loader {
            font-size: 45pt;
            text-align: center;
            height: 60vh;
            color: #0000ff9c;
            background-color: rgba(17, 17, 26, 0.2);
            font-weight: bolder;
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
                                            <th class="text-center">Status</th>
                                            <th class="text-center" style="width: 120px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="align-middle">
                                        <tr class="align-middle rounded m-1">
                                            <th id="table-loader" colspan="100%" scope="row" class="text-center"> <i class="fas fa-spinner fa-spin"></i></th>
                                        </tr>
                                    </tbody>
                                </table>
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
    <!-- axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- Sweet Alerts js -->
    <script src="<?= BASE_URL . PUBLIC_DIR ?>/admin/assets/libs/sweetalert2/sweetalert2.all.min.js"></script>

    <script>
        $('body').attr('data-leftbar-size', 'default').addClass('sidebar-enable')
        $('.toggle-sidebar').on('click', function() {
            $('body').toggleClass('sidebar-enable')
        })

        axios.get('<?= site_url('admin_api/user_index') ?>', {
                /* OPTIONS */
            })
            .then(function(response) {
                console.log(response.data)
                populateTable(response.data)
            })
            .catch(function(error) {
                console.log(error);
            })
            .finally(function() {});

        // function populateTable(users) {
        //     $('tbody').html('')
        //     const keys = ['first_name', 'middle_name', 'last_name', 'email', 'address', 'contact', 'birth_date', 'sex', 'verified_at', 'Status']
        //     for (let i = 0; i < users.length; i++) {
        //         tableTR = $('<tr></tr>').attr('id', users[0]['id'])
        //         let row = $('tbody').append(tableTR)
        //         for (let x = 0; x < keys.length; x++) {
        //             if (keys[x] == 'Status')
        //                 continue
        //             else if (keys[x] != 'address')
        //                 row.append('<td>' + (keys[x] == 'first_name' ? '&nbsp' : '') + users[i][keys[x]] + '</td>')
        //             else
        //                 row.append('<td class="p-2">' + users[i]['barangay_name'] + ', ' + users[i]['street'] + '</td>')
        //         }
        //         var statuBadge = $('<div></div>').addClass(users[i]['is_banned'] ? 'badge text-danger my-1' : 'badge text-success my-1').html(users[i]['is_banned'] ? 'Banned' : 'Active')
        //         var statusTD = $('<td></td>').addClass('text-center')
        //         row.append(statusTD.html(statuBadge))
        //         var banSpan = $('<span></span>').addClass('btn waves-effect waves-dark p-1 py-0 shadow-lg me-1').html('<i class="mdi p-0 mdi-account-reactivate fs-3 text-success"></i>')
        //         var cancelBanSpan = $('<span></span>').addClass('btn waves-effect waves-dark p-1 py-0 shadow-lg me-1').html('<i class="mdi p-0 mdi-account-remove fs-3 text-danger"></i>')
        //         var actionTD = $('<td></td>').addClass('text-center').append(users[i]['is_banned'] ? banSpan : cancelBanSpan)
        //         row.append(actionTD)
        //     }
        // }

        function populateTable(users) {
            $('tbody').html('');
            const keys = ['first_name', 'middle_name', 'last_name', 'email', 'address', 'contact', 'birth_date', 'sex', 'verified_at', 'Status'];

            for (let i = 0; i < users.length; i++) {
                const tableTR = $('<tr></tr>').attr('id', users[i]['id']);
                $('tbody').append(tableTR); // Append the table row to the tbody element

                for (let x = 0; x < keys.length; x++) {
                    if (keys[x] == 'Status') {
                        continue;
                    } else if (keys[x] != 'address') {
                        tableTR.append('<td>' + (keys[x] == 'first_name' ? '&nbsp;' : '') + users[i][keys[x]] + '</td>');
                    } else {
                        tableTR.append('<td class="p-2">' + users[i]['barangay_name'] + ', ' + users[i]['street'] + '</td>');
                    }
                }

                const statuBadge = $('<div></div>').addClass(users[i]['is_banned'] ? 'badge text-danger my-1' : 'badge text-success my-1').html(users[i]['is_banned'] ? 'Banned' : 'Active');
                const statusTD = $('<td></td>').addClass('text-center').append(statuBadge);
                tableTR.append(statusTD);

                const banSpan = $('<span></span>').addClass('btn waves-effect waves-dark p-1 py-0 shadow-lg me-1').html('<i class="mdi p-0 mdi-account-reactivate fs-3 text-success"></i>');
                const cancelBanSpan = $('<span></span>').addClass('btn waves-effect waves-dark p-1 py-0 shadow-lg me-1').html('<i class="mdi p-0 mdi-account-remove fs-3 text-danger"></i>');
                const actionTD = $('<td></td>').addClass('text-center').append(users[i]['is_banned'] ? banSpan : cancelBanSpan);
                tableTR.append(actionTD);
            }
        }


        // show uplift ban account confirmation
        $(document).on('click', '.mdi-account-reactivate', function() {
            id = $(this).closest('tr').attr('id')
            console.log(id)
            Swal.fire({
                title: 'Uplift Ban for this user??',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Reactivate'
            }).then((result) => {
                if (result.isConfirmed) {
                    handleBanAndRestoreUser(id, 'reactivate')
                }
            })
        })

        // show ban account confirmation
        $(document).on('click', '.mdi-account-remove', function() {
            id = $(this).closest('tr').attr('id')
            console.log(id)
            Swal.fire({
                title: 'Ban this user??',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ban'
            }).then((result) => {
                if (result.isConfirmed) {
                    handleBanAndRestoreUser(id, 'ban')
                }
            })
        })

        // form restore and delete submit handler
        function handleBanAndRestoreUser(id, httpMethod) {
            const banUrl = '<?= BASE_URL ?>admin/ban_user';
            const reactivateUrl = '<?= BASE_URL ?>admin/reactivate_user';
            $('body').append($('<div></div>').attr({
                id: 'delete-restore-form'
            }))
            var form = $('<form>');

            form.attr({
                method: 'POST',
                action: httpMethod == 'ban' ? banUrl : reactivateUrl
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
    </script>
</body>

</html>