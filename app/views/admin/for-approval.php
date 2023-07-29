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
					<div class="card">
						<div class="card-header">
							For Approval Orders
						</div>
						<div class="card-body">
							<div class="d-flex justify-content-start align-items-center my-3">
								<div>
									<input type="text" class="form-control rounded-pill border-primary" placeholder="Search..." id="search">
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
											<th>Contact</th>
											<th class="text-center">Date Checked Out</th>
										</tr>
									</thead>
									<tbody class="align-middle">
										<!-- <tr id="a2RuaUtyRHpvYXpKRVNpemlJdEZHZUw0TlpYYm82VzRtbDFhalE9PQ">
											<td>&nbsp;asdasd</td>
											<td>Alexandra Rodriguez</td>
											<td>Macdonald</td>
											<td>fohen@gmail.com</td>
											<td class="p-2">Lumangbayan, Commodi voluptas est</td>
											<td>09721231232</td>
											<td>1994-05-31</td>
											<td>Female</td>
											<td><span class="text-danger">NOT VERIFIED</span></td>
										</tr> -->
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
	<!-- apex charts -->
	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<!-- axios -->
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
	<!-- loadash -->
	<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
	<script>
		let q = {
			q: 'all',
			page: 1
		}
		$('body').attr('data-leftbar-size', 'default').addClass('sidebar-enable')
		$('.toggle-sidebar').on('click', function() {
			$('body').toggleClass('sidebar-enable')
		})

		$(document).ready(function() {
			handleFetchForApprovalList(q)
		})

		const handleFetchForApprovalList = _.debounce((q) => fetchForApprovalList(q), 1000);

		function fetchForApprovalList(q) {
			let link = '<?= site_url('admin_api/for_approval_index/') ?>';
			console.log(link + `${q.page}/${q.q}`)
			axios.get(link + `${q.page}/${q.q}`, {
					/* OPTIONS */
				})
				.then(function(response) {
					console.log(response)
					populateTable(response.data['forApprovalList'])
					populatePagination(response.data['pagination'])
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

		$('#search').on('input', function() {
			q.q = $(this).val() == '' ? 'all' : $(this).val().trim()
			q.page = 1
			if (/^\s*$/.test($(this).val()))
				q.q = 'all'
			handleFetchForApprovalList(q)
		})

		function populateTable(rows) {
			$('tbody').html('')
			for (let i = 0; i < rows.length; i++) {
				$('tbody').append(`
					<tr id="${rows[i]['id']}">
						<td>&nbsp;${rows[i]['first_name']}</td>
						<td>${rows[i]['middle_name']}</td>
						<td>${rows[i]['last_name']}</td>
						<td>${rows[i]['email']}</td>
						<td>${rows[i]['contact']}</td>
						<td class="text-center"><span>${rows[i]['for_approval_at']}</span></td>
					</tr>`)
			}
		}

		// change page
		$(document).on('click', '.page-link', changePage)
		function changePage() {
			q.page = $(this).attr('data-page')
			handleFetchForApprovalList(q);
		}
	</script>
</body>

</html>