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
											<th class="text-center">Action</th>
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

	<div class="modal fade" id="cart-details-modal" tabindex="-1" aria-labelledby="scrollableModalTitle" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
		<div class="modal-dialog modal-md modal-dialog-scrollable" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="scrollableModalTitle">Cart Details</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body fs-5 mx-2">
				</div>
				<div class="modal-footer d-flex justify-content-between">
					<button type="button" id="reject-button" class="float-left btn btn-danger">Reject Order</button>
					<div>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="button" id="approve-button" class="btn btn-primary">Approve Order</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="reject-confirmation-modal" tabindex="-1" aria-labelledby="scrollableModalTitle" data-bs-backdrop="static" style="display: none;" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="scrollableModalTitle">Reject Cart</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body fs-5 mx-2">
					<div class="mb-3">
						<label for="example-textarea" class="form-label text-danger">Rejection Note:</label>
						<textarea class="form-control" id="rejection_note" rows="5"></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" id="submit-reject-button" class="btn btn-primary">Submit</button>
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
	<!-- axios -->
	<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
	<!-- loadash -->
	<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
	<!-- taostr -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<!-- Sweet Alerts js -->
	<script src="<?= BASE_URL . PUBLIC_DIR ?>/admin/assets/libs/sweetalert2/sweetalert2.all.min.js"></script>
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
			showTableLoader()
			handleFetchForApprovalList(q)
		})

		const handleFetchForApprovalList = _.debounce((q) => fetchForApprovalList(q), 1000);

		function fetchForApprovalList(q) {
			showTableLoader()
			let link = '<?= site_url('admin_api/for_approval_index/') ?>';
			axios.get(link + `${q.page}/${q.q}`, {
					/* OPTIONS */
				})
				.then(function(response) {
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
			if (pagination['totalRows'] > 1) {
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
			if (rows.length > 0)
				for (let i = 0; i < rows.length; i++) {
					$('tbody').append(`
					<tr id="${rows[i]['id']}">
						<td>&nbsp;${rows[i]['first_name']}</td>
						<td>${rows[i]['middle_name'] ? rows[i]['middle_name'] : ''}</td>
						<td>${rows[i]['last_name']}</td>
						<td>${rows[i]['email']}</td>
						<td>${rows[i]['contact']}</td>
						<td class="text-center"><span>${rows[i]['for_approval_at']}</span></td>
						<td class="text-center">
							<span class="btn waves-effect waves-dark shadow-lg rounded p-2 show-cart">
								<i class="fas fs-4 fa-eye text-primary m-0 mx-0 p-0"></i>
							</span>	
						</td>
					</tr>`)
				} else {
					$('tbody').append(`
					<tr>
						<td colspan="100">
							<div class="d-flex justify-content-center align-items-center my-5 pt-5 fs-3"><i class="fas fa-shopping-cart"></i> &nbsp No cart for approval.</div>
						</td>
					</tr>`)
				}
		}

		// change page
		$(document).on('click', '.page-link', changePage)

		function changePage() {
			q.page = $(this).attr('data-page')
			handleFetchForApprovalList(q);
		}

		function showTableLoader() {
			$('tbody').html(`
				<tr>
					<td colspan="100">
						<div class="d-flex justify-content-center my-5 pt-5"><i class="mdi mdi-spin mdi-48px mdi-loading"></i></div>
					</td>
				</tr>
			`)
		}

		$(document).on('click', '.show-cart', function() {
			let element = $(this).parent().parent()
			$('#cart-details-modal').modal('show')
			$('#cart-details-modal .modal-body').html('<div class="d-flex justify-content-center my-5 py-5"><i class="mdi mdi-spin mdi-48px mdi-loading"></i></div>')
			$.post('<?= site_url('admin_api/get_cart_details') ?>', {
					id: $(element).attr('id')
				})
				.then(function(response) {
					console.log(response)
					displayCartDetails(response)
					$('#approve-button').attr('data-id', $(element).closest('tr').attr('id'))
				}).fail(function(response) {
					console.log(response)
				})
		})


		function displayCartDetails(cart) {
			let fullname = cart['user']['middle_name'] ? `${cart['user']['first_name']} ${cart['user']['middle_name']} ${cart['user']['last_name']}` : `${cart['user']['first_name']} ${cart['user']['last_name']}`
			$('#cart-details-modal .modal-body').html('')
			let productHTML = ''
			JSON.parse(cart['cart']['products']).forEach(cartProduct => {
				cart['products'].forEach(product => {
					if (cartProduct.id == product['id']) {
						productHTML += `
							<tr>
								<th scope="row">${product['name']}(${cartProduct['quantity']})</th>
								<td>${parseFloat(cartProduct['price']).toFixed(2)} Php</td>
								<td>${(cartProduct['quantity'] * cartProduct['price']).toFixed(2)} Php</td>
							</tr>`
					}
				});
			});
			$('#cart-details-modal .modal-body').append(`
				<div class="text-center fs-4">transaction ID</div>
				<div class="text-center fw-bold pt-1 pb-3">${cart['cart']['id']}</div>
				<div class="fw-normal">${fullname}</div>
				<div class="fw-normal">${cart['user']['email']}</div>
				<div class="fw-normal">${cart['user']['contact']}</div>
				<div class="fw-normal">${cart['user']['barangay_name']}, ${cart['user']['street']}</div>
				<div class="fw-bold pt-4 pb-2">Order List:</div>
				<div class="row justify-content-between">
				<div class="table-responsive">
					<table class="table table-bordered mb-0">
						<thead>
						<tr>
								<th>Product(qty)</th>
								<th>Price</th>
								<th>Total</th>
						</tr>
						</thead>
						<tbody>
							${productHTML}
						</tbody>
					</table>
				</div>
				</div>
				<div class="row justify-content-between">
					<div class="col-6 fw-bold pt-3">Delivery Fee:</div>
					<div class="col-6 fw-bold pt-3 text-end">${parseFloat(cart['cart']['delivery_fee']).toFixed(2)} Php</div>
					<div class="col-6 fw-bold">Grand Total:</div>
					<div class="col-6 fw-bold text-end">${parseFloat(cart['cart']['total']).toFixed(2)} Php</div>
				</div>
				<div class="fw-bold pt-3">Note:</div>
				<div class="fw-normal text-danger">${cart['cart']['note']}</div>
			`)
		}

		$('#approve-button').on('click', function() {
			disableEnableModal('disable')
			$.post('<?= site_url('admin_api/approve_order') ?>', {
					id: $('#approve-button').attr('data-id')
				})
				.then(function(response) {
					console.log(response)
					if (response) {
						$('#approve-button').html('Approve Order')
						toastr.success('Cart approved!')
						$('#cart-details-modal').modal('hide')
						handleFetchForApprovalList(q)
						disableEnableModal('enable')
					} else {
						disableEnableModal('enable')
						toastr.error('Something went wrong. Try again..')
					}
				}).fail(function(response) {
					disableEnableModal('enable')
					toastr.error('Something went wrong. Try again..')
				})
		})

		function disableEnableModal(mode) {
			$('#approve-button').html(mode == 'disable' ? '<i class="mdi mdi-spin mdi-loading"></i>' : 'Approve Order')
			$('.btn-close').attr('disabled', mode == 'disable' ? true : false)
			$('#approve-button').attr('disabled', mode == 'disable' ? true : false)
			$('#approve-button').prev().attr('disabled', mode == 'disable' ? true : false)
			$('#reject-button').attr('disabled', mode == 'disable' ? true : false)
		}

		$('#reject-button').on('click', function() {
			$('#rejection_note').val('')
			$('#reject-confirmation-modal').modal('show')
			$('#cart-details-modal').modal('hide')
		})

		$('#reject-confirmation-modal .btn-close').on('click', function() {
			$('#cart-details-modal').modal('show')
			$('#reject-confirmation-modal').modal('hide')
		})

		$('#submit-reject-button').on('click', function() {
			$('#submit-reject-button').attr('disabled', true)
			$('#reject-confirmation-modal .btn-close').attr('disabled', true)
			let rejectionNote = $('#rejection_note').val()
			let id = $('#approve-button').attr('data-id')
			$.post('<?= site_url('admin_api/reject_order') ?>', {
					id: id,
					rejection_note: rejectionNote
				})
				.then(function(response) {
					console.log(response)
					if (response == 'note is required')
						toastr.error('Rejection note is required!')
					else if (response == 'id is required')
						toastr.error('Cart ID is required!')
					else {
						$('#submit-reject-button').attr('disabled', false)
						$('#reject-confirmation-modal .btn-close').attr('disabled', false)
						toastr.success('Order rejected!')
						$('#reject-confirmation-modal').modal('hide')
						handleFetchForApprovalList(q);
					}
				}).fail(function(response) {
					$('#submit-reject-button').attr('disabled', false)
					$('#reject-confirmation-modal .btn-close').attr('disabled', false)
					$('#reject-confirmation-modal').modal('hide')
					handleFetchForApprovalList(q);
				})
		})
	</script>
</body>

</html>