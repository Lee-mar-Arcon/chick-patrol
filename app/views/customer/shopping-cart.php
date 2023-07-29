<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');
$LAVA = lava_instance();
?>

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
</head>

<body>

    <?php include 'components/top-navigation.php' ?>
    <!-- Header Section End -->

    <!-- Hero Section Begin -->
    <section class="shoping-cart spad">
        <div class="container">
            <?php if (count($products)) : ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="shoping__cart__table">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="shoping__product">Products</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($products as $product) : ?>
                                        <tr id="<?= $LAVA->m_encrypt->encrypt($product['id']) ?>">
                                            <td class="shoping__cart__item">
                                                <img height="100px" src="<?= BASE_URL . 'public/images/products/cropped/' . $product['image'] ?>" alt="">
                                                <h5><?= $product['name'] ?></h5>
                                            </td>
                                            <td class="shoping__cart__price">
                                                <span><?= number_format(round($product['price'], 2), 2) ?></span>
                                                <span> Php</span>
                                            </td>
                                            <td class="shoping__cart__quantity">
                                                <div class="quantity" style="user-select: none;">
                                                    <div class="pro-qty">
                                                        <input type="text" style="user-select: none;" readonly value="<?php
                                                                                                                        $cartProducts = json_decode($pendingCart['products']);
                                                                                                                        for ($i = 0; $i < count($cartProducts); $i++) {
                                                                                                                            if ($cartProducts[$i]->id == (int)$product['id']) {
                                                                                                                                echo trim($cartProducts[$i]->quantity);
                                                                                                                                break;
                                                                                                                            }
                                                                                                                        }
                                                                                                                        ?>">
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="shoping__cart__total">
                                                <span>
                                                    <?php
                                                    $cartProducts = json_decode($pendingCart['products']);
                                                    for ($i = 0; $i < count($cartProducts); $i++) {
                                                        if ($cartProducts[$i]->id == (int)$product['id']) {
                                                            echo number_format((round((float)$product['price'] * (float)$cartProducts[$i]->quantity, 2)), 2);
                                                            break;
                                                        }
                                                    }
                                                    ?>
                                                </span>
                                                <span> Php</span>
                                            </td>
                                            <td class="shoping__cart__item__close">
                                                <span class="icon_close"></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-lg-6">
                        <div class="shoping__checkout">
                            <h5>Cart Total</h5>
                            <ul>
                                <li id="deliveryFee">Delivery Fee <span>&nbsp; Php</span> <span><?= number_format($user['delivery_fee'], 2) ?></span></li>
                                <li id="cartTotal">Total <span>&nbsp; Php</span> <span>0.00</span> </li>
                            </ul>
                            <a href="<?= site_url('customer/checkout') ?>" class="primary-btn">PROCEED TO CHECKOUT</a>
                        </div>
                    </div>
                </div>
            <?php else : ?>
                <div class="row">
                    <div class="col-12 text-center h1 col-12 fw-bold text-secondary my-5">
                        <div>
                            Your cart is empty
                        </div>
                        <a href="<?= site_url('customer/homepage') ?>">
                            <button type="button" class="site-btn">Shop Now!</button>
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Footer Section Begin -->
    <footer class="footer spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="footer__about">
                        <div class="footer__about__logo">
                            <a href="./index.html"><img src="<?= BASE_URL ?>public/logo.png" alt=""></a>
                        </div>
                        <ul>
                            <li>Address: 60-49 Road 11378 New York</li>
                            <li>Phone: +65 11.188.888</li>
                            <li>Email: hello@colorlib.com</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-6 offset-lg-1">
                    <div class="footer__widget">
                        <h6>Useful Links</h6>
                        <ul>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">About Our Shop</a></li>
                            <li><a href="#">Secure Shopping</a></li>
                            <li><a href="#">Delivery infomation</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Our Sitemap</a></li>
                        </ul>
                        <ul>
                            <li><a href="#">Who We Are</a></li>
                            <li><a href="#">Our Services</a></li>
                            <li><a href="#">Projects</a></li>
                            <li><a href="#">Contact</a></li>
                            <li><a href="#">Innovation</a></li>
                            <li><a href="#">Testimonials</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12">
                    <div class="footer__widget">
                        <h6>Join Our Newsletter Now</h6>
                        <p>Get E-mail updates about our latest shop and special offers.</p>
                        <form action="#">
                            <input type="text" placeholder="Enter your mail">
                            <button type="submit" class="site-btn">Subscribe</button>
                        </form>
                        <div class="footer__widget__social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-pinterest"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="footer__copyright">
                        <div class="footer__copyright__text">
                            <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                                Copyright &copy;<script>
                                    document.write(new Date().getFullYear());
                                </script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                                <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                        </div>
                        <div class="footer__copyright__payment"><img src="img/payment-item.png" alt=""></div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

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
            updateCartTotal()
        })

        function updateCartBadge() {
            $.post('<?= site_url('customer_api/get_cart_total') ?>', {})
                .then(function(response) {
                    $('.fa-shopping-bag').next().html('0')
                    if (parseInt(response))
                        $('.fa-shopping-bag').next().html(response)
                })
        }

        $('.icon_close').on('click', function() {
            removeProduct($(this).closest('tr').attr('id'), this)
        })

        function removeProduct(id, element) {
            $.post('<?= site_url('customer_api/remove_cart_product') ?>', {
                    id: id
                })
                .then(function(response) {
                    if (response == 'product removed') {
                        Toastify({
                            text: "Product removed",
                            duration: 1500,
                            newWindow: true,
                            close: true,
                            gravity: "bottom",
                            position: "center",
                            stopOnFocus: true,
                            style: {
                                background: "linear-gradient(to right, #14ac34, #3ab902)",
                            },
                        }).showToast();
                        $(element).closest('tr').fadeOut(700, function() {
                            $(element).closest('tr').remove()
                            updateCartBadge()
                            updateCartTotal()
                        })
                    }
                }).fail(function(response) {
                    console.log(response)
                })
        }

        function updateCartTotal() {
            productSubTotals = $(document).find('.shoping__cart__total')
            if (productSubTotals.length == 0) showCartEmpty()
            total = 0
            for (let index = 0; index < productSubTotals.length; index++) {
                total += parseFloat($(productSubTotals[index]).find('span:eq(0)').html().trim())
            }
            total += parseFloat($('#deliveryFee').find('span:eq(1)').html())
            $('#cartTotal').find('span:eq(1)').html(total.toFixed(2))
        }

        function showCartEmpty() {
            $('.shoping-cart').html(`     
                <div class="container">           
                    <div class="row">
                        <div class="col-12 text-center h1 col-12 fw-bold text-secondary my-5">
                            <div>
                                Your cart is empty
                            </div>
                            <a href="<?= site_url('customer/homepage') ?>">
                                <button type="button" class="site-btn">Shop Now!</button>
                            </a>
                        </div>
                    </div>
                </div>`)
        }


        let proQty = $('.pro-qty');
        proQty.prepend('<span class="dec qtybtn">-</span>');
        proQty.append('<span class="inc qtybtn">+</span>');
        $('.qtybtn').on('click', function() {
            let element = $(this)
            $.post('<?= site_url('customer_api/get_max_quantity') ?>', {
                    id: $(element).closest('tr').attr('id')
                })
                .then(function(response) {
                    updateProductTotal($(element), calcNewQuantity($(element), response))
                    updateCartTotal()
                    updateCartProductQuantity($(element))
                }).fail(function(response) {
                    console.log(response)
                })

        })


        function updateCartProductQuantity(element) {
            let newQuantity = $(element).parent().find('input:eq(0)').val()
            $.post('<?= site_url('customer_api/update_cart_product_quantity') ?>', {
                    id: $(element).closest('tr').attr('id'),
                    newQuantity: newQuantity
                })
                .then(function(response) {
                    console.log(response)
                }).fail(function(response) {
                    console.log(response)
                })
        }

        function updateProductTotal(element, quantity) {
            let price = parseFloat($(element).closest('td').prev().find('span:eq(0)').html().trim())
            let newPrice = (price * quantity)
            $(element).closest('td').next().find('span:eq(0)').html(newPrice.toFixed(2))
        }

        function calcNewQuantity(element, maxQuantity) {
            let oldVal = parseFloat($(element).parent().find('input:eq(0)').val())
            let newVal = oldVal;
            if ($(element).hasClass('inc')) {
                if (oldVal < maxQuantity && maxQuantity != null) {
                    newVal = parseFloat($(element).prev().val()) + 1;
                } else {
                    if (maxQuantity == null)
                        newVal = parseFloat($(element).prev().val()) + 1;
                    else {
                        showMaxQuantityReachedToast()
                        newVal = oldVal
                    }
                }
            } else {
                newVal = parseFloat($(element).next().val())
                if (parseFloat($(element).next().val()) != 1)
                    newVal = parseFloat($(element).next().val()) - 1;
            }

            if ($(element).hasClass('inc')) {
                $(element).prev().val(newVal)
            } else {
                $(element).next().val(newVal)
            }
            return newVal
        }

        function updateQuantity(element, maxQuantity) {
            let newVal = 0;
            if ($(element).hasClass('inc'))
                newVal = parseFloat($(element).prev().val()) + 1
            else {
                newVal = parseFloat($(element).next().val())
                if (parseFloat($(element).next().val()) != 1)
                    newVal = parseFloat($(element).next().val()) - 1;
            }
            if ($(element).hasClass('inc')) {
                $(element).prev().val(newVal)
            } else {
                $(element).next().val(newVal)
            }
            return newVal
        }

        function showMaxQuantityReachedToast() {
            Toastify({
                text: "Reached the maximum quantity available",
                duration: 1500,
                newWindow: true,
                close: true,
                gravity: "bottom",
                position: "center",
                stopOnFocus: true,
                style: {
                    background: "linear-gradient(to right, #0d6982, #02768e)",
                },
            }).showToast();
        }
    </script>
</body>

</html>