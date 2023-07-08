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
                            <div class="d-flex justify-content-between align-items-center my-3">
                                <div>
                                    <input type="text" class="form-control rounded-pill border-primary" placeholder="Search..." id="user-search">
                                </div>
                                <div>
                                    <div class="btn-group-vertical row bg-primary rounded text-white text-center fs-6 fw-bold m-0 p-1">
                                        <div class="d-flex justify-content-center bg-primary text-white w-100 px-3 py-1">status</div>
                                        <button type="button" class="btn bg-white text-dark text-white p-1 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"> All <i class="mdi mdi-chevron-down"></i> </button>
                                        <div class="dropdown-menu">
                                            <button class="dropdown-item status">All</button>
                                            <button class="dropdown-item status">Banned</button>
                                            <button class="dropdown-item status">Active</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
    <!-- loadash -->
    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>

    <script>
        let q = {
            status: 'all',
            q: 'all',
            page: 1
        }

        $(document).ready(function() {
            handleFetchUsers(q)
        })

        // side navigation toggle
        $('body').attr('data-leftbar-size', 'default').addClass('sidebar-enable')
        $('.toggle-sidebar').on('click', function() {
            $('body').toggleClass('sidebar-enable')
        })

        // status option event
        $('.status').on('click', statusOptionUpdate)


        function fetchUsers(q) {
            $('tbody').html('<tr class="align-middle rounded m-1"> <th colspan="100%" scope="row" class="text-center"> <i class="fas fa-spinner fa-spin my-5 fs-1"></i></th></tr>')
            let link = `<?= site_url('admin_api/user_index') ?>/${q.page}/${q.status}/${q.q}/`
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

        function populateTable(users) {
            users = users['users']
            $('tbody').html('');
            const keys = ['first_name', 'middle_name', 'last_name', 'email', 'address', 'contact', 'birth_date', 'sex', 'verified_at', 'Status'];

            for (let i = 0; i < users.length; i++) {
                const tableTR = $('<tr></tr>').attr('id', users[i]['id']);
                $('tbody').append(tableTR); // Append the table row to the tbody element

                for (let x = 0; x < keys.length; x++) {
                    if (keys[x] == 'Status') {
                        continue;
                    } else if (keys[x] != 'address') {
                        tableTR.append('<td>' + (keys[x] == 'first_name' ? '&nbsp;' : '') + (users[i][keys[x]] == null ? '<span class="text-danger">NOT VERIFIED</span>' : users[i][keys[x]]) + '</td>');
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

        // handle users list request 
        const handleFetchUsers = _.debounce(fetchUsers, 1000);
        $('#user-search').on('input', function() {
            q.q = $(this).val() == '' ? 'all' : $(this).val().trim()
            q.page = 1
            if (/^\s*$/.test($(this).val()))
                q.q = 'all'
            handleFetchUsers(q);
        })

        // update status option value
        function statusOptionUpdate() {
            q.page = 1
            switch ($(this).html()) {
                case 'All':
                    $(this).parent().prev().html(' All <i class="mdi mdi-chevron-down"></i> ')
                    q.status = 'all'
                    break;
                case 'Banned':
                    $(this).parent().prev().html(' Banned <i class="mdi mdi-chevron-down"></i> ')
                    q.status = '0'
                    break;
                case 'Active':
                    $(this).parent().prev().html(' Active <i class="mdi mdi-chevron-down"></i> ')
                    q.status = '1'
                    break;
                default:
                    break;
            }
            handleFetchUsers(q)
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

        // change page
        $(document).on('click', '.page-link', changePage)

        function changePage() {
            q.page = $(this).attr('data-page')
            handleFetchUsers(q);
        }
    </script>
</body>

</html>