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
                        <div class="col-sm-12 col-lg-6 p-3">
                            <div class="card" style="min-height: 800px;">
                                <div class="card-header bg-primary">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex align-items-center text-white fs-4 fw-bold">
                                            Barangay
                                        </div>
                                        <div>
                                            <input type="text" class="form-control rounded-pill bg-white border-light" placeholder="Search...">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-sm-0 p-md-4">
                                    <div id="barangayChart"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-6 p-3">
                            <div class="card" style="min-height: 800px;">
                                <div class="card-header bg-primary">
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex align-items-center text-white fs-4 fw-bold">
                                            Category
                                        </div>
                                        <div>
                                            <input type="text" class="form-control rounded-pill bg-white border-light" placeholder="Search...">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-sm-0 p-md-4">
                                    <div id="categoryChart"></div>
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
    <!-- apex charts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        $('body').attr('data-leftbar-size', 'default').addClass('sidebar-enable')
        $('.toggle-sidebar').on('click', function() {
            $('body').toggleClass('sidebar-enable')
        })
        $(document).ready(function() {
            fetchChartData(`<?= site_url('admin_api/barangay_chart_data') ?>`, renderBarangayChart)
            fetchChartData(`<?= site_url('admin_api/category_chart_data') ?>`, renderCategoryChart)
        })
        // chart variables

        function fetchChartData(link, renderChart) {
            return axios.get(link, {
                    /* OPTIONS */
                })
                .then(function(response) {
                    renderChart(response.data)
                })
                .catch(function(error) {
                    console.log(error);
                })
                .finally(function(response) {});
        }

        function renderBarangayChart(data) {
            let labels = []
            let series = []
            for (let i = 0; i < data.length; i++) {
                labels.push(data[i]['name'])
                series.push(data[i]['total'])
            }
            barangayOptions = {
                chart: {
                    type: 'donut'
                },
                legend: {
                    position: 'top',
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '45%',
                            labels: {
                                show: true
                            }
                        },
                        labels: {
                            show: true,
                        }
                    }
                },
                series: series,
                labels: labels
            }
            barangayChart = new ApexCharts(document.querySelector("#barangayChart"), barangayOptions);
            barangayChart.render();
        }

        function renderCategoryChart(data) {
            let labels = []
            let series = []
            for (let i = 0; i < data.length; i++) {
                labels.push(data[i]['name'])
                series.push(data[i]['total'])
            }
            var categoryOptions = {
                chart: {
                    type: 'donut'
                },
                legend: {
                    position: 'top',
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '45%',
                            labels: {
                                show: true
                            }
                        },
                        labels: {
                            show: true,
                        }
                    }
                },
                series: series,
                labels: labels
            }
            var categoryChart = new ApexCharts(document.querySelector("#categoryChart"), categoryOptions);
            categoryChart.render();
        }
    </script>
</body>

</html>