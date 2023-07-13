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
									</div>
								</div>
								<div class="card-body p-sm-0 p-md-4">
									<div id="categoryChart"></div>
								</div>
							</div>
						</div>
						<div class="col-sm-12 col-lg-6 p-3">
							<div class="card" style="min-height: 800px;">
								<div class="card-header bg-primary">
									<div class="d-flex justify-content-between">
										<div class="d-flex align-items-center text-white fs-4 fw-bold">
											Delivery fee price History
										</div>
										<div class="d-flex">
											<span class="form-control d-flex align-items-center p-0 ps-2 me-1">
												<span class="p-0">Year:</span>
												<input class="form-control border-0 m-0" style="width: 80px;" id="barangay-search-year" type="number" step="1" value="<?= date('Y') ?>">
											</span>
											<div class="dropdown">
												<input class="text-start btn btn-light dropdown-toggle" type="text" style="cursor:text" id="barangay-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" placeholder="search barangay">
												<div class="dropdown-menu" style="cursor: pointer;">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="card-body p-sm-0 p-md-4">
									<div id="delivery-fee-history"></div>
								</div>
							</div>
						</div>











						<div class="col-sm-12 col-lg-6 p-3">
							<div class="card" style="min-height: 800px;">
								<div class="card-header bg-primary">
									<div class="d-flex justify-content-between">
										<div class="d-flex align-items-center text-white fs-4 fw-bold">
											Product price History
										</div>
										<div class="d-flex">
											<span class="form-control d-flex align-items-center p-0 ps-2 me-1">
												<span class="p-0">Month:</span>
												<input class="form-control border-0 m-0" style="width: 120px;" id="product-search-month" type="month" step="1" value="<?= date('Y-m') ?>">
											</span>
											<div class="dropdown">
												<input class="text-start btn btn-light dropdown-toggle" type="text" style="cursor:text" id="product-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" placeholder="search product" aria-expanded="false">
												<div class="dropdown-menu" style="cursor: pointer;">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="card-body p-sm-0 p-md-4">
									<div id="product-price-history"></div>
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
	<!-- loadash -->
	<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
	<script>
		$('body').attr('data-leftbar-size', 'default').addClass('sidebar-enable')
		$('.toggle-sidebar').on('click', function() {
			$('body').toggleClass('sidebar-enable')
		})
		$(document).ready(function() {

			setTimeout(function() {
				handleFetchSearch('product', '')
			}, 2000)
			handleFetchSearch('barangay', '')
			fetchChartData(`<?= site_url('admin_api/barangay_chart_data') ?>`, renderBarangayChart)
			fetchChartData(`<?= site_url('admin_api/category_chart_data') ?>`, renderCategoryChart)
		})
		// chart variables
		let DeliveryFeeHistoryOptions = {}
		let DeliveryFeeHistoryChart = ''
		let productPriceHistoryOptions = {}
		let productPriceHistoryChart = ''

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

		function renderDeliveryFeeHistory(data) {
			let labels = []
			let series = []
			for (let i = 0; i < data.length; i++) {
				labels.push(data[i]['name'])
				series.push(data[i]['fee'])
			}

			DeliveryFeeHistoryOptions = {
				series: [{
					name: "",
					data: series
				}],
				title: {
					text: '',
					align: 'left'
				},
				chart: {
					height: 350,
					type: 'line',
					zoom: {
						enabled: false
					},
				},
				dataLabels: {
					enabled: false
				},
				stroke: {
					width: [5, 7, 5],
					curve: 'straight',
					dashArray: [0, 8, 5]
				},
				legend: {
					tooltipHoverFormatter: function(val, opts) {
						return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
					}
				},
				markers: {
					size: 0,
					hover: {
						sizeOffset: 6
					}
				},
				xaxis: {
					categories: [],
				},
				tooltip: {
					y: [{
							title: {
								formatter: function(val) {
									return val
								}
							}
						},
						{
							title: {
								formatter: function(val) {
									return val + " per session"
								}
							}
						},
						{
							title: {
								formatter: function(val) {
									return val;
								}
							}
						}
					]
				},
				grid: {
					borderColor: '#f1f1f1',
				}
			};

			DeliveryFeeHistoryChart = new ApexCharts(document.querySelector("#delivery-fee-history"), DeliveryFeeHistoryOptions);
			DeliveryFeeHistoryChart.render();
		}


		// product price history chart render
		function productPriceHistory(data) {
			let labels = []
			let series = []
			for (let i = 0; i < data.length; i++) {
				labels.push(data[i]['name'])
				series.push(data[i]['fee'])
			}

			productPriceHistoryOptions = {
				series: [{
					name: "",
					data: series
				}],
				title: {
					text: '',
					align: 'left'
				},
				chart: {
					height: 350,
					type: 'line',
					zoom: {
						enabled: false
					},
				},
				dataLabels: {
					enabled: false
				},
				stroke: {
					width: [5, 7, 5],
					curve: 'straight',
					dashArray: [0, 8, 5]
				},
				legend: {
					tooltipHoverFormatter: function(val, opts) {
						return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
					}
				},
				markers: {
					size: 0,
					hover: {
						sizeOffset: 6
					}
				},
				xaxis: {
					categories: [],
				},
				tooltip: {
					y: [{
							title: {
								formatter: function(val) {
									return val
								}
							}
						},
						{
							title: {
								formatter: function(val) {
									return val + " per session"
								}
							}
						},
						{
							title: {
								formatter: function(val) {
									return val;
								}
							}
						}
					]
				},
				grid: {
					borderColor: '#f1f1f1',
				}
			};

			productPriceHistoryChart = new ApexCharts(document.querySelector("#product-price-history"), DeliveryFeeHistoryOptions);
			productPriceHistoryChart.render();
		}

		$('#barangay-search-dropdown').on('input', function() {
			handleFetchSearch('barangay', $(this).val())
		})

		$('#product-search-dropdown').on('input', function() {
			handleFetchSearch('product', $(this).val())
		})

		$(document).on('click', '.dropdown-item', function() {
			$(this).parent().prev().val($(this).html()).attr('data-id', $(this).attr('data-id'))
			if ($(this).parent().prev().attr('id').indexOf('barangay') == 0)
				handleFetchHistory('barangay', $(this).attr('data-id'), $('#barangay-search-year').val())
			else
				handleFetchHistory('product', $(this).attr('data-id'), $('#product-search-month').val())
		})

		const handleFetchSearch = _.debounce((table, q) => fetchSearch(table, q), 1000);
		const handleFetchHistory = _.debounce((table, id, date) => fetchHistory(table, id, date), 1000);

		function fetchSearch(table, q = '') {
			let barangayLink = `<?= site_url('admin_api/barangay_search') ?>/${q}`
			let productLink = `<?= site_url('admin_api/product_search') ?>/${q}`
			axios.get(table == 'barangay' ? barangayLink : productLink, {
					/* OPTIONS */
				})
				.then(function(response) {
					populateDropdown(response.data, table)
					if (table == 'barangay') {
						renderDeliveryFeeHistory([])
						handleFetchHistory('barangay', $('#barangay-search-dropdown').next().find('.dropdown-item:eq(0)').attr('data-id'), $('#barangay-search-year').val())
					} else {
						productPriceHistory([])	
						handleFetchHistory('product', $('#product-search-dropdown').next().find('.dropdown-item:eq(0)').attr('data-id'), $('#product-search-month').val())
					}

				})
				.catch(function(error) {
					console.log(error);
				})
				.finally(function() {});
		}

		function populateDropdown(data, searchbar) {
			let searchbarId = '#';
			if (searchbar == 'barangay')
				searchbarId += 'barangay-search-dropdown'
			else
				searchbarId += 'product-search-dropdown'
			let dropdownListContainer = $(searchbarId).next()
			dropdownListContainer.html('')
			for (let i = 0; i < data.length; i++)
				dropdownListContainer.append(`<div data-id="${data[i]['id']}" class="dropdown-item">${data[i]['name']}</div>`)
		}

		function fetchHistory(table, id, date) {
			console.log(date)
			let barangayLink = `<?= site_url('admin_api/delivery_fee_history') ?>/${id}/${date}`
			let productLink = `<?= site_url('admin_api/product_price_history') ?>/${id}/${date}`
			axios.get(table == 'barangay' ? barangayLink : productLink, {
					/* OPTIONS */
				})
				.then(function(response) {
					let history = response.data['history']
					series = []
					categories = []
					if (table == 'barangay') {
						for (let i = 0; i < history.length; i++) {
							series.push(history[i]['delivery_fee'])
							categories.push(history[i]['added_at'])
						}
						DeliveryFeeHistoryChart.updateOptions({
							series: [{
								name: "Delivery fee",
								data: series
							}],
							xaxis: {
								categories: categories,
							},
							title: {
								text: response.data['barangay']['name'],
							},
						})
					} else {
						console.log(response.data)
						for (let i = 0; i < history.length; i++) {
							series.push(history[i]['price'])
							categories.push(history[i]['added_at'])
						}
						productPriceHistoryChart.updateOptions({
							series: [{
								name: "Price",
								data: series
							}],
							xaxis: {
								categories: categories,
							},
							title: {
								text: response.data['product']['name'],
							},
						})
					}
				})
				.catch(function(error) {
					console.log(error);
				})
				.finally(function() {});
		}

		$('#barangay-search-year').on('change', function() {
			handleFetchHistory('barangay', $('#barangay-search-dropdown').attr('data-id'), $('#barangay-search-year').val())
		})

		$('#product-search-month').on('change', function() {
			handleFetchHistory('product', $('#product-search-dropdown').attr('data-id'), $('#product-search-month').val())
		})
	</script>
</body>

</html>