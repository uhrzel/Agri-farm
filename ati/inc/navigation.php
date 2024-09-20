</style>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-green elevation-4 sidebar-no-expand">
  <!-- Brand Logo -->
  <a href="<?php echo base_url ?>ati" class="brand-link bg-gradient-green text-sm">
    <img src="<?php echo validate_image($_settings->info('logo')) ?>" alt="Store Logo" class="brand-image img-circle elevation-3" style="opacity: .8;width: 1.5rem;height: 1.5rem;max-height: unset">
    <span class="brand-text font-weight-light"><?php echo $_settings->info('short_name') ?></span>
  </a>
  <!-- Sidebar -->
  <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-transition os-host-scrollbar-horizontal-hidden">
    <div class="os-resize-observer-host observed">
      <div class="os-resize-observer" style="left: 0px; right: auto;"></div>
    </div>
    <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;">
      <div class="os-resize-observer"></div>
    </div>
    <div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 646px;"></div>
    <div class="os-padding">
      <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
        <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
          <!-- Sidebar user panel (optional) -->
          <div class="clearfix"></div>
          <!-- Sidebar Menu -->
          <nav class="mt-4">
            <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-compact nav-flat nav-child-indent nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">
              <li class="nav-item dropdown">
                <a href="./" class="nav-link nav-home">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>ati/?page=farmer" class="nav-link nav-farmer">
                  <i class="nav-icon fas fa-user-friends"></i>
                  <p>Farmer List</p>
                </a>
              </li>
              <li class="nav-header">Agricultural Products</li>
              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>ati/?page=production" class="nav-link nav-production">
                  <i class="nav-icon fas fa-tractor"></i>
                  <p>Production Harvesting</p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>ati/?page=inorganic" class="nav-link nav-inorganic">
                  <i class="nav-icon fas fa-leaf"></i>
                  <p>Inorganic Fertilizers</p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>ati/?page=organic" class="nav-link nav-organic">
                  <i class="nav-icon fas fa-seedling"></i>
                  <p>Organic Fertilizers</p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>ati/?page=pesticides" class="nav-link nav-pesticides">
                  <i class="nav-icon fas fa-bug"></i>
                  <p>Pesticides</p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>ati/?page=sanitizers" class="nav-link nav-sanitizers">
                  <i class="nav-icon fas fa-spray-can"></i>
                  <p>Sanitizers</p>
                </a>
              </li>
              <li class="nav-header">Documented History</li>
              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>ati/?page=archive" class="nav-link nav-archive">
                  <i class="nav-icon fas fa-archive"></i>
                  <p>Archive</p>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a href="<?php echo base_url ?>ati/?page=history" class="nav-link nav-history">
                  <i class="nav-icon fas fa-history"></i>
                  <p>History</p>
                </a>
              </li>

            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
      </div>
    </div>
    <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
      <div class="os-scrollbar-track">
        <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div>
      </div>
    </div>
    <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden">
      <div class="os-scrollbar-track">
        <div class="os-scrollbar-handle" style="height: 55.017%; transform: translate(0px, 0px);"></div>
      </div>
    </div>
    <div class="os-scrollbar-corner"></div>
  </div>
  <!-- /.sidebar -->
</aside>
<script>
  $(document).ready(function() {

    var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
    /*  console.log("Current page parameter:", page); */
    var pageClass = 'nav-' + page.replace(/\//g, '_');
    /*  console.log("Computed class:", pageClass); */

    $('.nav-link').removeClass('active');
    $('.nav-link.' + pageClass).addClass('active');
    var $activeLink = $('.nav-link.' + pageClass);
    if ($activeLink.length) {
      $activeLink.closest('.nav-treeview').siblings('a').addClass('active');
      $activeLink.closest('.nav-treeview').parent().addClass('menu-open');
    }
    $('.nav-link.active').addClass('bg-gradient-green');
  });
</script>