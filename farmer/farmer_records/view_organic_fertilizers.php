<?php

require_once('../../config.php');
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * from `organic_fertilizers` where id = '{$_GET['id']}' ");
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
    <h3 class="text-center">Orrganic Fertilizers Details</h3>
    <hr>
    <dl>
        <dt class="muted">Type</dt>
        <dd class="pl-4"><?= isset($type) ? $type : "N/A" ?></dd>
        <dt class="muted">Brand</dt>
        <dd class="pl-4"><?= isset($brand) ? $brand : "N/A" ?></dd>
        <dt class="muted">Supplier</dt>
        <dd class="pl-4"><?= isset($supplier) ? $supplier : "N/A" ?></dd>
        <dt class="muted">Crops Applied</dt>
        <dd class="pl-4"><?= isset($crops_applied) ? $crops_applied : "N/A" ?></dd>
        <dt class="muted">Frequency</dt>
        <dd class="pl-4"><?= isset($frequency) ? $frequency : "N/A" ?></dd>
        <dt class="muted">Expiry Date</dt>
        <dd class="pl-4"><?= isset($expiry_date) ? $expiry_date : "N/A" ?></dd>

    </dl>
    <div class="clear-fix mb-3"></div>
    <div class="text-right">
        <button class="btn btn-dark btn-flat btn-sm" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
    </div>
</div>