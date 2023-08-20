<!-- Page Preloder -->
<div id="preloder">
   <div class="loader"></div>
</div>

<!-- Humberger Begin -->
<div class="humberger__menu__overlay"></div>
<div class="humberger__menu__wrapper">
   <div class="humberger__menu__logo d-flex justify-content-center">
      <a href="<?= site_url('customer/homepage') ?>"><img src="<?= BASE_URL ?>public/logo.png" alt="" height="120px"></a>
   </div>
   <div class="humberger__menu__cart">
      <ul>
         <?php if (isset($user)) : ?>
            <li class="m-2"><a href="<?= site_url('customer/shopping-cart') ?>"><i class="fa fa-shopping-bag"></i> <span></span></a></li>
         <?php endif; ?>
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
         <li class="<?= $pageTitle == 'Home' ? 'active' : '' ?>"><a href="<?= site_url('customer/homepage') ?>">Home</a></li>
         <?php if ($user != null) { ?>
            <li class="<?= $pageTitle == 'Orders' ? 'active' : '' ?>"><a href="<?= site_url('customer/orders') ?>">Orders</a></li>
         <?php } ?>
         <li class="<?= $pageTitle == '' ? 'active' : '' ?>"><a href="<?= site_url('customer/foods') ?>">Foods</a>
         <li class="<?= $pageTitle == '' ? 'active' : '' ?>"><a href="<?= site_url('customer/about-us') ?>">About us</a>
      </ul>
   </nav>
   <div id="mobile-menu-wrap"></div>
   <div class="humberger__menu__contact">
      <ul>
         <li><i class="fa fa-envelope"></i> <?= isset($user['email']) ? $user['email'] : 'email' ?></li>
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
                     <li><i class="fa fa-envelope"></i> <?= isset($user['email']) ? $user['email'] : 'email' ?></li>
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
      <div class="d-flex justify-content-between">
         <div class="">
            <div class="header__logo d-flex justify-content-center pt-4">
               <a href="<?= site_url('customer/homepage') ?>"><img src="<?= BASE_URL ?>public/logo.png" width="140px" alt=""></a>
            </div>
         </div>
         <div class=" align-self-end">
            <nav class="header__menu pb-3">
               <ul>
                  <li class="<?= $pageTitle == 'Home' ? 'active' : '' ?>"><a href="<?= site_url('customer/homepage') ?>">Home</a></li>
                  <?php if ($user != null) { ?>
                     <li class="<?= $pageTitle == 'Orders' ? 'active' : '' ?>"><a href="<?= site_url('customer/orders') ?>">Orders</a></li>
                  <?php } ?>
                  <li class="<?= $pageTitle == '' ? 'active' : '' ?>"><a href="<?= site_url('Customer/foods') ?>">Foods</a>
                  <li class="<?= $pageTitle == '' ? 'active' : '' ?>"><a href="<?= site_url('Customer/about-us') ?>">About us</a>
               </ul>
            </nav>
         </div>
         <div class="header__cart align-self-end">
            <ul class="m-0">
               <?php if (isset($user)) : ?>
                  <li style="width: 140px;"><a href="<?= site_url('customer/shopping-cart') ?>"><i class="fa fa-shopping-bag"></i> <span></span></a></li>
               <?php else : ?>
                  <li style="width: 140px;"></li>
               <?php endif; ?>
            </ul>
         </div>

         <div class="humberger__open">
            <i class="fa fa-bars"></i>
         </div>
      </div>
   </div>
</header>