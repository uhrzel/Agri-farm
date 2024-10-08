<?php

require_once('../../config.php');
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * from `production_harvesting` where id = '{$_GET['id']}' ");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
    }
}
?>
<style>
    #uni_modal .modal-footer {
        display: none !important;
    }
</style>
<div class="container-fluid">
    <h3 class="text-center">Product Harvesting Details</h3>
    <hr>
    <dl>
        <dt class="muted">Crops</dt>
        <dd class="pl-4"><?= isset($crops) ? $crops : "N/A" ?></dd>
        <dt class="muted">Crops cycle</dt>
        <dd class="pl-4"><?= isset($crop_cycle) ? $crop_cycle : "N/A" ?></dd>
        <dt class="muted">Variety</dt>
        <dd class="pl-4"><?= isset($variety) ? $variety : "N/A" ?></dd>
        <dt class="muted">Date Planted</dt>
        <dd class="pl-4"><?= isset($date_planted) ? $date_planted : "N/A" ?></dd>
        <dt class="muted">Date Harvested</dt>
        <dd class="pl-4"><?= isset($date_harvest) ? $date_harvest : "N/A" ?></dd>
        <dt class="muted">Hectarage</dt>
        <dd class="pl-4"><?= isset($hectarage) ? $hectarage : "N/A" ?></dd>
        <dt class="muted">Area</dt>
        <dd class="pl-4"><?= isset($area) ? $area : "N/A" ?></dd>
        <dt class="muted">Estimated Harvest (kg)</dt>
        <dd class="pl-4"><?= isset($harvest_kg) ? $harvest_kg : "N/A" ?></dd>
        <dt class="muted">Location</dt>
        <dd class="pl-4"><?= isset($location) ? $location : "N/A" ?></dd>
        <dt class="muted">Plat</dt>
        <dd class="pl-4"><?= isset($plat) ? $plat : "N/A" ?></dd>

    </dl>
    <div class="clear-fix mb-3"></div>
    <div class="text-right">
        <button class="btn btn-dark btn-flat btn-sm" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
    </div>
</div>