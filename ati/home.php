<h1 class="text-center my-4">Welcome to <?php echo $_settings->info('name') ?></h1>
<hr>

<div class="row text-center">

  <div class="col-12 col-sm-6 col-md-4 mb-4">
    <div class="info-box shadow-sm">
      <span class="info-box-icon elevation-1" style="background-color: #7d9aa0;">
        <?php $icon = "fas fa-table"; ?>
        <i class="<?php echo $icon; ?>"></i>
      </span>
      <div class="info-box-content">
        <span class="info-box-text">Total Farmers</span>
        <span class="info-box-number">
          <?php
          // Query to count total farmers
          $totalFarmers = $conn->query("SELECT COUNT(*) as total FROM users WHERE type = 2")->fetch_assoc()['total'];
          echo number_format($totalFarmers);
          ?>
        </span>
      </div>

    </div>
  </div>

  <div class="col-12 col-sm-6 col-md-4 mb-4">
    <div class="info-box shadow-sm">
      <span class="info-box-icon elevation-1" style="background-color: #8dbf81;">
        <?php $icon = "fas fa-leaf"; ?>
        <i class="<?php echo $icon; ?>"></i>
      </span>

      <div class="info-box-content">
        <span class="info-box-text">Product Harvesting</span>
        <span class="info-box-number">
          <?php
          // Query to count total farmers
          $totalProductionharvesting = $conn->query("SELECT COUNT(*) as total FROM production_harvesting where delete_flag = 0")->fetch_assoc()['total'];
          echo number_format($totalProductionharvesting);
          ?>
        </span>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-md-4 mb-4">
    <div class="info-box shadow-sm">
      <span class="info-box-icon elevation-1" style="background-color: #ebe2dd;">
        <?php $icon = "fas fa-flask"; ?>
        <i class="<?php echo $icon; ?>"></i>
      </span>

      <div class="info-box-content">
        <span class="info-box-text">Inorganic Fertilizers</span>
        <span class="info-box-number">
          <?php
          // Query to count total farmers
          $totalInorganic = $conn->query("SELECT COUNT(*) as total FROM inorganic_fertilizers where delete_flag = 0")->fetch_assoc()['total'];
          echo number_format($totalInorganic);
          ?>
        </span>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-md-4 mb-4">
    <div class="info-box shadow-sm">
      <span class="info-box-icon elevation-1" style="background-color: #cbbeb5;">
        <?php $icon = "fas fa-seedling"; ?>
        <i class="<?php echo $icon; ?>"></i>
      </span>

      <div class="info-box-content">
        <span class="info-box-text">Organic Fertilizers</span>
        <span class="info-box-number">
          <?php
          // Query to count total farmers
          $totalOrganic = $conn->query("SELECT COUNT(*) as total FROM organic_fertilizers where delete_flag = 0")->fetch_assoc()['total'];
          echo number_format($totalOrganic);
          ?>
        </span>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-md-4 mb-4">
    <div class="info-box shadow-sm">
      <span class="info-box-icon elevation-1" style="background-color: #bbbbbb;">
        <?php $icon = "fas fa-user-friends"; ?>
        <i class="<?php echo $icon; ?>"></i>
      </span>

      <div class="info-box-content">
        <span class="info-box-text">Pesticides</span>
        <span class="info-box-number">
          <?php
          // Query to count total farmers
          $totalpesticides = $conn->query("SELECT COUNT(*) as total FROM pesticides where delete_flag = 0")->fetch_assoc()['total'];
          echo number_format($totalpesticides);
          ?>
        </span>
      </div>
    </div>
  </div>

  <div class="col-12 col-sm-6 col-md-4 mb-4">
    <div class="info-box shadow-sm">
      <span class="info-box-icon elevation-1" style="background-color: #bbbbbb;">
        <?php $icon = "fas fa-hand-sparkles"; ?>
        <i class="<?php echo $icon; ?>"></i>
      </span>

      <div class="info-box-content">
        <span class="info-box-text">Sanitizers</span>
        <span class="info-box-number">
          <?php
          // Query to count total farmers
          $totalSanitizers = $conn->query("SELECT COUNT(*) as total FROM sanitizers where delete_flag = 0")->fetch_assoc()['total'];
          echo number_format($totalSanitizers);
          ?>
        </span>
      </div>
    </div>
  </div>

</div>

<div class="container">
  <?php
  $files = array();
  $fopen = scandir(base_app . 'uploads/banner');
  foreach ($fopen as $fname) {
    if (in_array($fname, array('.', '..'))) continue;
    $files[] = validate_image('uploads/banner/' . $fname);
  }
  ?>
  <div id="tourCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
    <div class="carousel-inner h-100">
      <?php foreach ($files as $k => $img): ?>
        <div class="carousel-item h-100 <?php echo $k == 0 ? 'active' : '' ?>">
          <img class="d-block w-100 h-100" style="object-fit:contain" src="<?php echo $img ?>" alt="">
        </div>
      <?php endforeach; ?>
    </div>
    <a class="carousel-control-prev" href="#tourCarousel" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#tourCarousel" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>