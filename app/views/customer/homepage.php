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
    <!-- swiperjs -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <style>
        .swiper {
            background-image: url('<?= BASE_URL . 'public/images/carousel banner.jpg' ?>');
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>

<body>

    <?php include 'components/top-navigation.php' ?>

    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-12 p-0 py-5">
                    <div class="row mx-4">
                        <div class="col-12">
                        </div>
                        <div class="col-sm-12 col-md-3">
                            <div class="d-flex justify-content-center">
                                <div class="hero__search__phone">
                                    <div class="hero__search__phone__icon">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <div class="hero__search__phone__text">
                                        <h5>0911-111-1111</h5>
                                        <span>support 24/7 time</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hero__search__form col-sm-12 col-md-9">
                            <form action="#">
                                <input id="product-search" type="text" placeholder="What do yo u need?">
                                <a href="#" onclick="scrollToElement('products-list'); return false;"><button type="submit" class="site-btn" id="search-product-button">SEARCH</button></a>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-12 p-0 rounded">
                    <div class="swiper rounded">
                        <div class="swiper-wrapper">
                            <?php $featuredProducts = [1, 2, 3, 4, 5];
                            foreach ($featuredProducts as $featureProduct) { ?>
                                <div class="swiper-slide">
                                    <div class="row">
                                        <h3 class="text-center text-white col-12 pt-5 pb-0 fw-bold col-12"><?= $featureProduct . ' label' ?></h3>
                                        <div class="col-12">
                                            <div class="d-flex justify-content-center">
                                                <img width="300px" height="300px" src="https://chick-patrol.test/public/images/category/cropped/2044bf96fac1777639a48de6a75006bfa616d7be.png" class="align-self-centermt-0 pt-0" alt="...">
                                            </div>
                                        </div>
                                        <div class="col-12 d-flex justify-content-center pb-4">
                                            <button type="submit" class="site-btn">Add to Cart</button>
                                        </div>
                                        <div class="px-4 mx-4 text-justify text-white pb-5">
                                            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ice cream is a popular frozen dessert enjoyed by people of all ages. It is made by combining ingredients such as milk, cream, sugar, and flavorings, which are then churned and frozen to create a smooth and creamy texture. Various flavors, such as vanilla, chocolate, strawberry, and many more, are added to give ice cream its distinct taste. Additional ingredients like fruits, nuts, chocolate chips, or cookie pieces can be mixed in for added texture and flavor.</p>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-prev text-white"></div>
                        <div class="swiper-button-next text-white"></div>
                        <div class="swiper-scrollbar"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section Begin -->
    <section class="categories">
        <div class="container">
            <div class="row">
                <div class="categories__slider owl-carousel">
                    <?php foreach ($categories as $category) : ?>
                        <div class="col-lg-3 p-0">
                            <div class="categories__item mx-2 set-bg bg-light" data-setbg="<?= BASE_URL . PUBLIC_DIR . '/images/category/cropped/' . $category['image'] ?>">
                                <h5 class="rounded"><a href="#" class="bg-white border-2"><?= $category['name'] ?></a></h5>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Section Begin -->
    <section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div id="products-list" class="section-title pt-4">
                        <h2>Our Products</h2>
                    </div>
                    <div class="featured__controls">
                        <ul>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row featured__filter">

            </div>
        </div>
    </section>
    <!-- Featured Section End -->


    <?php if (count($newestProducts == null ? 0 : $newestProducts) > 0) : ?>
        <!-- newest products Begin -->
        <section class="categories">
            <div class="container">
                <div class="row">
                    <div class="section-title pt-0 mt-0 col-12">
                        <h2>Our Newest Products</h2>
                    </div>
                    <div class="categories__slider owl-carousel">
                        <?php foreach ($newestProducts as $newestProduct) : ?>
                            <div class="col-lg-3 p-0">
                                <div class="featured__item">
                                    <div class="featured__item__pic set-bg" data-setbg="<?= BASE_URL ?>public/images/products/cropped/<?= $newestProduct['image'] ?>">
                                        <?php if (($newestProduct['available_quantity'] > 0)) : ?>
                                            <ul class="featured__item__pic__hover">
                                                <li>
                                                    <a onclick="return false">
                                                        <div style="cursor: pointer;" data-id="<?= $newestProduct['id'] ?>" class="add-to-cart">
                                                            <i class="fa fa-shopping-cart cursor-pointer"></i>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?= site_url('customer/view-product/') . $newestProduct['id'] ?>">
                                                        <div v="" style="cursor: pointer;" data-id="<?= $newestProduct['id'] ?>">
                                                            <i class="fa fa-eye cursor-pointer"></i>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                    <div class="featured__item__text">
                                        <?= !($newestProduct['available_quantity'] > 0) ? '<h1 class="badge badge-danger">Unavailable</h1>' : '' ?>'
                                        <h6><a href="#"><?= $newestProduct['name'] ?></a></h6>
                                        <h5>₱ <?= number_format($newestProduct['price'], 2) ?></h5>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- newest products End -->
    <?php endif; ?>

    <?php if (count($topSelling) > 0) : ?>
        <!-- top selling Begin -->
        <section class="categories">
            <div class="container">
                <div class="row">
                    <div class="section-title pt-0 mt-0 col-12">
                        <h2>Our Newest Products</h2>
                    </div>
                    <div class="categories__slider owl-carousel">
                        <?php foreach ($topSelling as $topSellingProduct) : ?>
                            <div class="col-lg-3 p-0">
                                <div class="featured__item">
                                    <div class="featured__item__pic set-bg" data-setbg="<?= BASE_URL ?>public/images/products/cropped/<?= $topSellingProduct['image'] ?>">
                                        <?php if (($topSellingProduct['available_quantity'] > 0)) : ?>
                                            <ul class="featured__item__pic__hover">
                                                <li>
                                                    <a onclick="return false">
                                                        <div style="cursor: pointer;" data-id="<?= $topSellingProduct['id'] ?>" class="add-to-cart">
                                                            <i class="fa fa-shopping-cart cursor-pointer"></i>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?= site_url('customer/view-product/') . $topSellingProduct['id'] ?>">
                                                        <div v="" style="cursor: pointer;" data-id="<?= $topSellingProduct['id'] ?>">
                                                            <i class="fa fa-eye cursor-pointer"></i>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        <?php endif; ?>
                                    </div>
                                    <div class="featured__item__text">
                                        <?= !($topSellingProduct['available_quantity'] > 0) ? '<h1 class="badge badge-danger">Unavailable</h1>' : '' ?>'
                                        <h6><a href="#"><?= $topSellingProduct['name'] ?></a></h6>
                                        <h5>₱ <?= number_format($topSellingProduct['price'], 2) ?></h5>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- top selling End -->
    <?php endif; ?>


    <!-- Banner Begin -->
    <div class="banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="img/banner/banner-1.jpg" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="img/banner/banner-2.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner End -->

    <!-- Latest Product Section Begin -->
    <section class="latest-product spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Latest Products</h4>
                        <div class="latest-product__slider owl-carousel">
                            <div class="latest-prdouct__slider__item">
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-1.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-2.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-3.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                            </div>
                            <div class="latest-prdouct__slider__item">
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-1.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-2.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-3.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Review Products</h4>
                        <div class="latest-product__slider owl-carousel">
                            <div class="latest-prdouct__slider__item">
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-1.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-2.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-3.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                            </div>
                            <div class="latest-prdouct__slider__item">
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-1.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-2.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                                <a href="#" class="latest-product__item">
                                    <div class="latest-product__item__pic">
                                        <img src="img/latest-product/lp-3.jpg" alt="">
                                    </div>
                                    <div class="latest-product__item__text">
                                        <h6>Crab Pool Security</h6>
                                        <span>$30.00</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Latest Product Section End -->

    <!-- Blog Section Begin -->
    <section class="from-blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title from-blog__title">
                        <h2>From The Blog</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic">
                            <img src="img/blog/blog-1.jpg" alt="">
                        </div>
                        <div class="blog__item__text">
                            <ul>
                                <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                                <li><i class="fa fa-comment-o"></i> 5</li>
                            </ul>
                            <h5><a href="#">Cooking tips make cooking simple</a></h5>
                            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic">
                            <img src="img/blog/blog-2.jpg" alt="">
                        </div>
                        <div class="blog__item__text">
                            <ul>
                                <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                                <li><i class="fa fa-comment-o"></i> 5</li>
                            </ul>
                            <h5><a href="#">6 ways to prepare breakfast for 30</a></h5>
                            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <div class="blog__item">
                        <div class="blog__item__pic">
                            <img src="img/blog/blog-3.jpg" alt="">
                        </div>
                        <div class="blog__item__text">
                            <ul>
                                <li><i class="fa fa-calendar-o"></i> May 4,2019</li>
                                <li><i class="fa fa-comment-o"></i> 5</li>
                            </ul>
                            <h5><a href="#">Visit the clean farm in the US</a></h5>
                            <p>Sed quia non numquam modi tempora indunt ut labore et dolore magnam aliquam quaerat </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->

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
    <!-- swiperjs -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    <script>
        const swiper = new Swiper('.swiper', {
            direction: 'horizontal',
            loop: true,
            autoHeight: true,
            loop: true,

            // If we need pagination
            pagination: {
                el: '.swiper-pagination',
            },

            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

            // And if we need scrollbar
            scrollbar: {
                el: '.swiper-scrollbar',
            },
        });


        $(document).ready(function() {
            updateCartBadge()
            getAvailableCategories()
        })

        const isLoggedIn = <?= $user == null ? 0 : 1 ?>;
        $(document).on('click', '.add-to-cart', function() {
            AddToCart($(this))
        })

        function AddToCart(element) {
            // not logged in toast
            if (!isLoggedIn) {
                showToast("Log in first!", "linear-gradient(to right, #0d6982, #02768e)")
            } else {
                let id = element.attr('data-id')
                $.post('<?= site_url('customer_api/add_to_cart') ?>', {
                        id: id,
                    })
                    .then(function(response) {
                        console.log(response)
                        // show error if product exists
                        if (response == 'product exists')
                            showToast("Product already in cart!", "linear-gradient(to right, #ac1414, #f12b00)")
                        updateCartBadge()

                        // show toast if product added
                        if (response == 'product added')
                            showToast("Product added!", "linear-gradient(to right, #14ac34, #3ab902)")
                    }).catch(function(error) {
                        console.log(error);
                    })
            }
        }

        function showToast(message, color) {
            Toastify({
                text: message,
                duration: 1500,
                newWindow: true,
                close: true,
                gravity: "bottom",
                position: "center",
                stopOnFocus: true,
                style: {
                    background: color,
                },
            }).showToast();
        }

        function updateCartBadge() {
            $.post('<?= site_url('customer_api/get_cart_total') ?>', {})
                .then(function(response) {
                    $('.fa-shopping-bag').next().html('0')
                    if (parseInt(response))
                        $('.fa-shopping-bag').next().html(response)
                })
        }

        function getAvailableCategories() {
            $.post('<?= site_url('customer_api/get_available_categories') ?>', {})
                .then(function(response) {
                    populateCategoriesFilter(response)
                    getProducts()
                })
        }

        function populateCategoriesFilter(categoryList) {
            $('.featured__controls ul').html('')
            $('.featured__controls ul').append(`
                <li class="active" data-filter="*">All</li>
            `)
            categoryList.forEach(category => {
                $('.featured__controls ul').append(`
                    <li data-filter=".${category['name'].replace(' ', '')}">${category['name']}</li>
                `)
            });
        }

        function scrollToElement(elementId) {
            const element = document.getElementById(elementId);
            if (element) {
                element.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        }

        var mixer = null;

        function initMixitup() {
            if (mixer)
                mixer.destroy()
            mixer = mixitup('.featured__filter', {
                selectors: {
                    target: '.mix'
                },
                animation: {
                    duration: 500
                }
            });
            const buttons = document.querySelectorAll('.featured__controls ul li');
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    const filterValue = button.getAttribute('data-filter');
                    const sortValue = button.getAttribute('data-sort');
                    mixer.filter(filterValue);
                    if (sortValue) {
                        mixer.sort(sortValue);
                    }
                });
            });
        }

        function getProducts() {
            $.post('<?= site_url('customer_api/get_products') ?>', {
                    q: $('#product-search').val()
                })
                .then(function(response) {
                    console.log(response)
                    populateProductsList(response)
                    initMixitup()
                })
        }

        function populateProductsList(products) {
            $('.featured__filter').html('')
            const productLink = '<?= BASE_URL . PUBLIC_DIR . '/images/products/cropped/' ?>'
            const viewProductLink = '<?= site_url('customer/view-product/') ?>'
            products.forEach(product => {
                $('.featured__filter').append(`
                <div class="col-lg-3 col-md-4 col-sm-6 mix ${product['category_name'].replace(' ', '')}">
                    <div class="featured__item">
                        <div class="featured__item__pic set-bg" data-setbg="${productLink + product['image']}">
                        ${!(product['available_quantity'] == 0 || product['available_quantity'] == null) ?
                            `<ul class="featured__item__pic__hover">
                                <li>
                                    <a onclick="return false">
                                        <div style="cursor: pointer;" data-id="${product['id']}" class="add-to-cart">
                                            <i class="fa fa-shopping-cart cursor-pointer"></i>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="${viewProductLink + product['id']}">
                                        <div v style="cursor: pointer;" data-id="${product['id']}">
                                            <i class="fa fa-eye cursor-pointer"></i>
                                        </div>
                                    </a>
                                </li>
                            </ul>` : ''
                        }
                        </div>
                        <div class="featured__item__text">
                        ${product['available_quantity'] == 0 || product['available_quantity'] == null  ? '<h1 class="badge badge-danger">Unavailable</h1>' : ''}

                            <h6><a href="#">${product['name']}</a></h6>
                            <h5>₱ ${parseFloat(product['price']).toFixed(2)}</h5>
                        </div>
                    </div>
                </div>
                `)
            });

            $('.set-bg').each(function() {
                var bg = $(this).data('setbg');
                $(this).css('background-image', 'url(' + bg + ')');
            });
        }

        $(document).on('click', '.featured__controls ul li', function() {
            $('.featured__controls ul li').removeClass('active')
            $(this).addClass('active')
        })

        $('#search-product-button').on('click', function() {
            getAvailableCategories()
        })
    </script>
</body>

</html>