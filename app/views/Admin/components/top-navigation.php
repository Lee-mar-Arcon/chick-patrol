<!-- Topbar Start -->
<div class="navbar-custom">
   <ul class="list-unstyled topnav-menu float-end mb-0">
      <li class="dropdown d-inline-block d-lg-none">
         <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
            <i class="fe-search noti-icon"></i>
         </a>
         <div class="dropdown-menu dropdown-lg dropdown-menu-end p-0">
            <form class="p-3">
               <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
            </form>
         </div>
      </li>

      <li class="dropdown notification-list topbar-dropdown">
         <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown" href="" role="button" aria-haspopup="false" aria-expanded="false">
            <img src="<?= BASE_URL . PUBLIC_DIR ?>/logo.png" alt="user-image" class="rounded-circle">
            <span class="pro-user-name ms-1">
               Administrator <i class="mdi mdi-chevron-down"></i>
            </span>
         </a>
         <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
            <!-- item-->
            <div class="dropdown-header noti-title">
               <h6 class="text-overflow m-0">Welcome !</h6>
            </div>

            <!-- item-->
            <a href="<?= site_url('admin/profile')?>" class="dropdown-item notify-item">
               <i class="fe-user"></i>
               <span>My Account</span>
            </a>

            <div class="dropdown-divider"></div>

            <!-- item-->
            <a href="<?= site_url('account/login') ?>" class="dropdown-item notify-item">
               <i class="fe-log-out"></i>
               <span>Logout</span>
            </a>

         </div>
      </li>

   </ul>

   <!-- LOGO -->
   <div class="logo-box">
      <a href="<?= site_url('admin/dashboard') ?>" class="logo logo-light text-center">
         <span class="logo-sm">
            <img src="<?= BASE_URL . PUBLIC_DIR ?>/logo.png" alt="" height="22">
         </span>
         <span class="logo-lg">
            <img src="<?= BASE_URL . PUBLIC_DIR ?>/logo.png" alt="" height="16">
         </span>
      </a>
      <a href="<?= site_url('admin/dashboard') ?>" class="logo logo-dark text-center">
         <span class="logo-sm">
            <img src="<?= BASE_URL . PUBLIC_DIR ?>/logo.png" alt="" height="22">
         </span>
         <span class="logo-lg">
            <img src="<?= BASE_URL . PUBLIC_DIR ?>/logo.png" alt="" height="80">
         </span>
      </a>
   </div>

   <ul class="list-unstyled topnav-menu topnav-menu-left mb-0">
      <li>
         <button class="button-menu-mobile toggle-sidebar disable-btn waves-effect">
            <i class="fe-menu"></i>
         </button>
      </li>

      <li>
         <h4 class="page-title-main"><?= $breadCrumb ?></h4>
      </li>

   </ul>

   <div class="clearfix"></div>

</div>
<!-- end Topbar -->