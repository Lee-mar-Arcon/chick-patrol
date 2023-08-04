    <!-- Page Preloder -->
    <div id="preloder">
       <div class="loader"></div>
    </div>

    <!-- Humberger Begin -->
    <div class="humberger__menu__overlay"></div>
    <div class="humberger__menu__wrapper">
       <div class="humberger__menu__logo">
          <a href="#"><img src="<?= BASE_URL ?>public/logo.png" alt="" height="40px"></a>
       </div>
       <div class="humberger__menu__cart">
          <ul>
             <li><a href="<?= site_url('customer/shopping-cart') ?>"><i class="fa fa-shopping-bag"></i> <span></span></a></li>
          </ul>
       </div>
       <div class="humberger__menu__widget">
          <div class="header__top__right__auth">
             <?php if ($user == null) : ?>
                <a href="<?= site_url('account/login') ?>"><i class="fa fa-user"></i> Login</a>
             <?php else : ?>
                <a href="<?= site_url('customer/profile') ?>"><i class="fa fa-user"></i>Profile</a>
                <a style="margin-left: .8rem;" href="<?= site_url('account/login') ?>"><i class="fa fa-arrow-circle-left"></i>Logout</a>
             <?php endif; ?>
          </div>
       </div>
       <nav class="humberger__menu__nav mobile-menu">
          <ul>
             <li class="<?= $pageTitle == '' ? 'active' : '' ?>"><a href="<?= site_url('customer/homepage') ?>">Home</a></li>
             <li class="<?= $pageTitle == '' ? 'active' : '' ?>"><a href="./shop-grid.html">Shop</a></li>
             <li class="<?= $pageTitle == '' ? 'active' : '' ?>"><a href="#">Pages</a>
                <ul class="header__menu__dropdown">
                   <li><a href="./shop-details.html">Shop Details</a></li>
                   <li><a href="./shoping-cart.html">Shoping Cart</a></li>
                   <li><a href="./checkout.html">Check Out</a></li>
                   <li><a href="./blog-details.html">Blog Details</a></li>
                </ul>
             </li>
             <li><a href="./blog.html">Blog</a></li>
             <li><a href="./contact.html">Contact</a></li>
          </ul>
       </nav>
       <div id="mobile-menu-wrap"></div>
       <div class="humberger__menu__contact">
          <ul>
             <li><i class="fa fa-envelope"></i> <?= isset($user['email']) ? $user['email'] : 'You are not logged in' ?></li>
             <!-- <li>Free Shipping for all Order of $99</li> -->
          </ul>
       </div>
    </div>
    <!-- Humberger End -->

    <!-- Header Section Begin -->
    <header class="header">
       <div class="header__top">
          <div class="container">
             <div class="row">
                <div class="col-lg-6 col-md-6">
                   <div class="header__top__left">
                      <ul>
                         <li><i class="fa fa-envelope"></i> <?= isset($user['email']) ? $user['email'] : 'You are not logged in' ?></li>
                         <!-- <li>Free Shipping for all Order of $99</li> -->
                      </ul>
                   </div>
                </div>
                <div class="col-lg-6 col-md-6">
                   <div class="header__top__right">
                      <div class="header__top__right__auth d-flex justify-content-end">
                         <?php if ($user == null) : ?>
                            <a href="<?= site_url('account/login') ?>"><i class="fa fa-user"></i> Login</a>
                         <?php else : ?>
                            <a href="<?= site_url('customer/profile') ?>"><i class="fa fa-user"></i>Profile</a>
                            <a style="margin-left: .8rem;" href="<?= site_url('account/login') ?>"><i class="fa fa-arrow-circle-left"></i>Logout</a>
                         <?php endif; ?>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
       <div class="container">
          <div class="row">
             <div class="col-lg-3">
                <div class="header__logo d-flex justify-content-start">
                   <a href="<?= site_url('customer/homepage') ?>"><img src="<?= BASE_URL ?>public/logo.png" height="40px" alt=""></a>
                </div>
             </div>
             <div class="col-lg-6">
                <nav class="header__menu">
                   <ul>
                      <li class="<?= $pageTitle == 'Home' ? 'active' : '' ?>"><a href="<?= site_url('customer/homepage') ?>">Home</a></li>
                      <li class="<?= $pageTitle == 'Orders' ? 'active' : '' ?>"><a href="<?= site_url('customer/orders') ?>">Orders</a></li>
                      <li class="<?= $pageTitle == '' ? 'active' : '' ?>"><a href="#">Pages</a>
                         <ul class="header__menu__dropdown">
                            <li><a href="./shop-details.html">Shop Details</a></li>
                            <li><a href="./shoping-cart.html">Shoping Cart</a></li>
                            <li><a href="./checkout.html">Check Out</a></li>
                            <li><a href="./blog-details.html">Blog Details</a></li>
                         </ul>
                      </li>
                      <li><a href="./blog.html">Blog</a></li>
                      <li><a href="./contact.html">Contact</a></li>
                   </ul>
                </nav>
             </div>
             <div class="col-lg-3">
                <div class="header__cart">
                   <ul class="m-0">
                      <li class="m-2"><a href="<?= site_url('customer/shopping-cart') ?>"><i class="fa fa-shopping-bag"></i> <span></span></a></li>
                   </ul>
                </div>
             </div>
          </div>
          <div class="humberger__open">
             <i class="fa fa-bars"></i>
          </div>
       </div>
    </header>