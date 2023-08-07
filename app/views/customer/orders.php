<!DOCTYPE html>
<html lang="zxx">

<head>
   <meta charset="UTF-8">
   <meta name="description" content="Ogani Template">
   <meta name="keywords" content="Ogani, unica, creative, html">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">
   <title><?= $pageTitle ?></title>

   <!-- Google Font -->
   <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

   <!-- Css Styles -->
   <link rel="stylesheet" href="<?= BASE_URL ?>public/customer/css/bootstrap.min.css" type="text/css">
   <link rel="stylesheet" href="<?= BASE_URL ?>public/customer/css/font-awesome.min.css" type="text/css">
   <link rel="stylesheet" href="<?= BASE_URL ?>public/customer/css/elegant-icons.css" type="text/css">
   <link rel="stylesheet" href="<?= BASE_URL ?>public/customer/css/nice-select.css" type="text/css">
   <link rel="stylesheet" href="<?= BASE_URL ?>public/customer/css/jquery-ui.min.css" type="text/css">
   <link rel="stylesheet" href="<?= BASE_URL ?>public/customer/css/owl.carousel.min.css" type="text/css">
   <link rel="stylesheet" href="<?= BASE_URL ?>public/customer/css/slicknav.min.css" type="text/css">
   <link rel="stylesheet" href="<?= BASE_URL ?>public/customer/css/style.css" type="text/css">
   <!-- toastify -->
   <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
   <!-- icons -->
   <link href="<?= BASE_URL . PUBLIC_DIR ?>/admin/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
   <style>
      .rounded-top {
         border-top-left-radius: .25rem !important;
         border-top-right-radius: .25rem !important;
      }

      .status-select {
         background-color: #7fad39;
      }

      .action-color {
         color: #7fad39;
      }

      .timeline-steps {
         display: flex;
         justify-content: center;
         flex-wrap: nowrap;
         width: fit-content;
      }

      .timeline-steps .timeline-step {
         align-items: center;
         display: flex;
         flex-direction: column;
         position: relative;
         margin: 0rem 0rem
      }

      @media (min-width:768px) {
         .timeline-steps .timeline-step:not(:last-child):after {
            content: "";
            display: block;
            border-top: .25rem solid #4caf50;
            width: 80%;
            position: absolute;
            left: 6.1rem;
            top: .3125rem
         }

         .timeline-steps .timeline-step:not(:first-child):before {
            content: "";
            display: block;
            border-top: .25rem solid #4caf50;
            width: 80%;
            position: absolute;
            right: 6.1rem;
            top: .3125rem
         }
      }

      .timeline-steps .timeline-content {
         width: 10rem;
         text-align: center
      }

      .timeline-steps .timeline-content .inner-circle {
         border-radius: 1.5rem;
         height: .8rem;
         width: .8rem;
         display: inline-flex;
         align-items: center;
         justify-content: center;
         background-color: #4caf50
      }

      .timeline-inactive {
         background-color: black
      }

      .timeline-steps .timeline-content .inner-circle:before {
         content: "";
         background-color: #4caf50;
         display: inline-block;
         height: 1.5rem;
         width: 1.5rem;
         min-width: 1.5rem;
         border-radius: 6.25rem;
         opacity: .5
      }

      .timeline-steps .timeline-content .inner-circle-inactive {
         border-radius: 1.5rem;
         height: .8rem;
         width: .8rem;
         display: inline-flex;
         align-items: center;
         justify-content: center;
         background-color: gray
      }

      .timeline-inactive {
         background-color: black
      }

      .timeline-steps .timeline-content .inner-circle-inactive:before {
         content: "";
         background-color: gray;
         display: inline-block;
         height: 1.5rem;
         width: 1.5rem;
         min-width: 1.5rem;
         border-radius: 6.25rem;
         opacity: .5
      }
   </style>
</head>

<body>

   <?php include 'components/top-navigation.php' ?>
   <!-- Header Section End -->

   <section class="checkout spad">
      <div class="container px-5">
         <div class="d-flex justify-content-end">
            <div class="mb-3 p-1 status-select rounded">
               <select class="form-select form-select-lg border-0" id="cart-status">
                  <option value="all">All</option>
                  <option value="for acceptance">For Acceptance</option>
                  <option value="rejected">Rejected</option>
                  <option value="on delivery">On Delivery</option>
                  <option value="finished">Finished</option>
                  <option value="canceled">Canceled</option>
               </select>
            </div>
         </div>
         <div class="table-responsive">

            <table class="table table-borderless" id="cart-table">
               <thead>
                  <tr style="background-color: #9aff0047;">
                     <th scope="col">Transaction ID</th>
                     <th scope="col" class="text-center" style="width: 200px;">Date Checked Out</th>
                     <th scope="col" class="text-center" style="width: 120px;">Status</th>
                     <th scope="col" class="text-center" style="width: 100px;">Action</th>
                  </tr>
               </thead>
               <tbody>

               </tbody>
            </table>
         </div>
      </div>
   </section>


   <?php include 'components/footer.php' ?>




   <div class="modal fade" id="viewOrder" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg rounded" role="document">
         <div class="modal-content border-0 rounded-0 rounded-top">
            <div class="modal-body p-0">
               <div class="text-white d-flex justify-content-between m-0 p-3 pb-0 border-0">
                  <div></div>
                  <h5 class="h3 text-dark fw-bold" id="staticBackdropLabel">Order Details</h5>
                  <i class="fas fa-times-circle align-content-center text-dark" data-dismiss="modal" aria-label="Close" style="font-size: 1.5rem; cursor:pointer"></i>
               </div>
               <div class="container-fluid p-4 pt-0">
                  <div class="d-flex justify-content-center py-5 my-3">
                     <div class="timeline-steps aos-init aos-animate" data-aos="fade-up"></div>
                  </div>
               </div>
               <div class="checkout__order m-3"></div>
            </div>
            <div class="modal-footer border-0 d-flex justify-content-between bg-white">
               <button type="button" class="btn rounded-0 btn-danger border-0" style="cursor: pointer;">Cancel Order</button>
               <button type="button" class="btn-close rounded-0 px-4 py-2 secondary-btn border-0" data-dismiss="modal" style="cursor: pointer;">Close</button>
            </div>
         </div>
      </div>
   </div>





   <!-- Js Plugins -->
   <script src="<?= BASE_URL ?>public/customer/js/jquery-3.3.1.min.js"></script>
   <script src="<?= BASE_URL ?>public/customer/js/bootstrap.min.js"></script>
   <script src="<?= BASE_URL ?>public/customer/js/jquery.nice-select.min.js"></script>
   <script src="<?= BASE_URL ?>public/customer/js/jquery-ui.min.js"></script>
   <script src="<?= BASE_URL ?>public/customer/js/jquery.slicknav.js"></script>
   <script src="<?= BASE_URL ?>public/customer/js/mixitup.min.js"></script>
   <script src="<?= BASE_URL ?>public/customer/js/owl.carousel.min.js"></script>
   <script src="<?= BASE_URL ?>public/customer/js/main.js"></script>
   <!-- toastify -->
   <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>


   <script>
      $(document).ready(function() {
         updateCartBadge()
         console.log($('#cart-status').val())
         fetchCartList()
      })

      function updateCartBadge() {
         $.post('<?= site_url('customer_api/get_cart_total') ?>', {})
            .then(function(response) {
               $('.fa-shopping-bag').next().html('0')
               if (parseInt(response))
                  $('.fa-shopping-bag').next().html(response)
            })
      }

      $('#cart-status').on('change', function() {
         fetchCartList()
      })

      function fetchCartList() {
         $.post('<?= site_url('customer_api/get_user_cart') ?>', {
               status: $('#cart-status').val()
            })
            .then(function(response) {
               console.log(response)
               populateTable(response)
            })
      }

      function populateTable(rows) {
         $('#cart-table tbody').html('')
         if (rows.length > 0)
            for (let i = 0; i < rows.length; i++) {
               $('#cart-table tbody').append(`
                  <tr data-id="${rows[i]['id']}">
                     <td scope="row">${rows[i]['id']}</td>
                     <td class="text-center">${rows[i]['for_approval_at']}</td>
                     <td class="text-center">${rows[i]['status']}</td>
                     <td class="text-center"><i class="fas fa-eye action-color" style="cursor: pointer;"></i></td>
                  </tr>
               `)
            }
         else [
            $('#cart-table tbody').append(`
                  <tr>
                     <td colspan="4" class="text-center">No cart available</td>
                  </tr>
               `)
         ]
      }

      $(document).on('click', '.fa-eye', function() {
         let id = $(this).closest('tr').attr('data-id')
         $('#viewOrder').modal('show')

         $.post('<?= site_url('customer_api/get_cart_details') ?>', {
               id: id
            })
            .then(function(response) {
               console.log(response)
               populateOrderModal(response)
            }).fail(function(response) {
               console.log(response)
            })
      })

      function populateOrderModal(cart) {
         let productsTotal = 0;
         let orderListHTML = ''
         cartProducts = JSON.parse(cart['cart']['products']);
         for (let i = 0; i < cartProducts.length; i++) {
            productTotal = cartProducts[i]['price'] * cartProducts[i]['quantity']
            productsTotal += productTotal
            cart['products'].forEach(product => {
               if (product['id'] == cartProducts[i]['id']) {
                  orderListHTML += `<li>${product['name']} <span>₱  ${productTotal.toFixed(2)}</span></li>`
               }
            });
         }

         if (cart['cart']['status'] == 'rejected') {
            $('.timeline-steps').html(
               `
            <div class="timeline-step">
               <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2003">
                  <div class="inner-circle"></div>
                  <p class="h6 mt-3 mb-1">Date Checked Out</p>
                  <p class="h6 text-muted mb-0 mb-lg-0">${cart['cart']['for_approval_at']}</p>
               </div>
            </div>
            <div class="timeline-step">
               <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2004">
                  <div class="inner-circle"></div>
                  <p class="h6 mt-3 mb-1">Date Rejected</p>
                  <p class="h6 text-muted mb-0 mb-lg-0">${cart['cart']['rejected_at']}</p>
               </div>
            </div>
         `)
         } else {
            $('.timeline-steps').html(
               `
               <div class="timeline-step">
                  <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2003">
                     <div class="${cart['cart']['for_approval_at'] == null ? 'inner-circle-inactive' : 'inner-circle'}"></div>
                     <p class="h6 mt-3 mb-1">Date Checked Out</p>
                     <p class="h6 text-muted mb-0 mb-lg-0">${cart['cart']['for_approval_at'] == null ? 'TBA' : cart['cart']['for_approval_at']}</p>
                  </div>
               </div>
               <div class="timeline-step">
                  <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2004">
                     <div class="${cart['cart']['approved_at'] == null ? 'inner-circle-inactive' : 'inner-circle'}"></div>
                     <p class="h6 mt-3 mb-1">Preparing</p>
                     <p class="h6 text-muted mb-0 mb-lg-0">${cart['cart']['approved_at'] == null ? 'TBA' : cart['cart']['approved_at']}</p>
                  </div>
               </div>
               <div class="timeline-step">
                  <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2005">
                     <div class="${cart['cart']['on_delivery_at'] == null ? 'inner-circle-inactive' : 'inner-circle'}"></div>
                     <p class="h6 mt-3 mb-1">On Delivery</p>
                     <p class="h6 text-muted mb-0 mb-lg-0">${cart['cart']['on_delivery_at'] == null ? 'TBA' : cart['cart']['on_delivery_at']}</p>
                  </div>
               </div>
               <div class="timeline-step">
                  <div class="timeline-content" data-toggle="popover" data-trigger="hover" data-placement="top" title="" data-content="And here's some amazing content. It's very engaging. Right?" data-original-title="2010">
                     <div class="${cart['cart']['received_at'] == null ? 'inner-circle-inactive' : 'inner-circle'}"></div>
                     <p class="h6 mt-3 mb-1">Date Received</p>
                     <p class="h6 text-muted mb-0 mb-lg-0">${cart['cart']['received_at'] == null ? 'TBA' : cart['cart']['received_at']}</p>
                  </div>
               </div>
            `)
         }

         $('.checkout__order').html(`
            <div class="row">
               <div class="col-6">
                  <h4 class="border-0">Your Order</h4>
               </div>
               <div class="col-6 mb-1 d-flex justify-content-end">
                  <h4 id="ordId" class="border-0">#${cart['cart']['id']}</h4>
               </div>
            </div>
            <div class="checkout__order__products">Products <span>Total</span></div>
            <ul>
               ${orderListHTML}
            </ul>
            <div class="checkout__order__subtotal border-0 pb-0 pt-4">Subtotal <span id="sub">₱ ${productsTotal.toFixed(2)}</span></div>
            <div class="checkout__order__subtotal border-0 p-0">Delivery Fee <span id="shipping">₱ ${parseFloat(cart['cart']['delivery_fee']).toFixed(2)}</span></div>
            <div class="checkout__order__subtotal border-0 pt-0 pb-3">Grand Total <span class="text-danger" id="total">₱ ${parseFloat(cart['cart']['total']).toFixed(2)}</span></div>
         `)

         if (cart['cart']['status'] == "for approval") {
            $('.modal-footer').children(':first-child').attr('data-id', cart['cart']['id'])
            $('.modal-footer').children(':first-child').attr('hidden', false)
         } else {
            $('.modal-footer').children(':first-child').attr('data-id', '')
            $('.modal-footer').children(':first-child').attr('hidden', true)
         }
      }

      $('.modal-footer').children(':first-child').on('click', function() {
         const cartID = $(this).attr('data-id')
         $.post('<?= site_url('customer_api/cancel_order') ?>', {
               cartID: cartID
            })
            .then(function(response) {
               if (!response == 0) {
                  fetchCartList()
                  $('#viewOrder').modal('hide')
                  showToast('Order Cancelled Successfully', "linear-gradient(to right, #0d6982, #02768e)")
               } else
                  showToast('Something went wrong.', "linear-gradient(to right, #ac1414, #f12b00)")
            })
      })

      function showToast(message, color) {
         Toastify({
            text: message,
            duration: 1500,
            newWindow: true,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
            style: {
               background: color,
            },
         }).showToast();
      }
   </script>
</body>

</html>