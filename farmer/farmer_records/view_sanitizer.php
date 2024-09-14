<?php

require_once('../../config.php');
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * from `sanitizers` where id = '{$_GET['id']}' ");
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
    <h3 class="text-center">Sanitizer Details</h3>
    <hr>
    <dl>
        <dt class="muted">Sanitizer</dt>
        <dd class="pl-4"><?= isset($sanitizer_name) ? $sanitizer_name : "N/A" ?></dd>
        <dt class="muted">Active Ingredient</dt>
        <dd class="pl-4"><?= isset($active_ingredient) ? $active_ingredient : "N/A" ?></dd>
        <dt class="muted">Brand Name</dt>
        <dd class="pl-4"><?= isset($brand_name) ? $brand_name : "N/A" ?></dd>
        <dt class="muted">Intended Use </dt>
        <dd class="pl-4"><?= isset($intended_use) ? $intended_use : "N/A" ?></dd>
        <dt class="muted">Frequency of Use</dt>
        <dd class="pl-4"><?= isset($frequency) ? $frequency : "N/A" ?></dd>
        <dt class="muted">Expiry Date</dt>
        <dd class="pl-4"><?= isset($expiry_date) ? $expiry_date : "N/A" ?></dd>
    </dl>
    <div class="clear-fix mb-3"></div>
    <div class="text-right">
        <button class="btn btn-dark btn-flat btn-sm" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
    </div>
</div>