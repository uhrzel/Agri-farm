<?php
require_once('../../config.php');
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * FROM `organic_fertilizers` WHERE id = '{$_GET['id']}'");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
    }
}
?>
<div class="container-fluid">
    <form action="" id="inorganic-fertilizer-form">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">

        <!-- Fertilizer Type -->
        <div class="form-group">
            <label for="type" class="control-label">Fertilizer Type</label>
            <input type="text" name="type" id="type" class="form-control form-control-sm rounded-0" value="<?php echo isset($type) ? $type : ''; ?>" required />
        </div>

        <!-- Fertilizer Brand -->
        <div class="form-group">
            <label for="brand" class="control-label">Brand</label>
            <input type="text" name="brand" id="brand" class="form-control form-control-sm rounded-0" value="<?php echo isset($brand) ? $brand : ''; ?>" required />
        </div>

        <!-- Supplier -->
        <div class="form-group">
            <label for="supplier" class="control-label">Supplier</label>
            <input type="text" name="supplier" id="supplier" class="form-control form-control-sm rounded-0" value="<?php echo isset($supplier) ? $supplier : ''; ?>" required />
        </div>

        <!-- Crops Applied -->
        <div class="form-group">
            <label for="crops_applied" class="control-label">Crops Applied (e.g., 100 liters or 500 ml)</label>
            <div class="input-group">
                <!-- Input for amount -->
                <input type="text" name="crops_applied_amount" id="crops_applied_amount" class="form-control form-control-sm rounded-0" value="<?php echo isset($crops_applied_amount) ? $crops_applied_amount : ''; ?>" placeholder="Enter amount" required />

                <!-- Dropdown for unit -->
                <select name="crops_applied_unit" id="crops_applied_unit" class="form-control form-control-sm rounded-0" required>
                    <option value="liters" <?php echo (isset($crops_applied_unit) && $crops_applied_unit == 'liters') ? 'selected' : ''; ?>>Liters</option>
                    <option value="ml" <?php echo (isset($crops_applied_unit) && $crops_applied_unit == 'ml') ? 'selected' : ''; ?>>ml</option>
                </select>
            </div>
        </div>

        <!-- Frequency of Application -->
        <div class="form-group">
            <label for="frequency" class="control-label">Frequency of Application</label>
            <input type="text" name="frequency" id="frequency" class="form-control form-control-sm rounded-0" value="<?php echo isset($frequency) ? $frequency : ''; ?>" required />
        </div>

        <!-- Expiry Date -->
        <div class="form-group">
            <label for="expiry_date" class="control-label">Expiry Date</label>
            <input type="date" name="expiry_date" id="expiry_date" class="form-control form-control-sm rounded-0" value="<?php echo isset($expiry_date) && $expiry_date != '0000-00-00' ? $expiry_date : ''; ?>" required />
        </div>

    </form>

</div>
<script>
    $(document).ready(function() {
        $('#inorganic-fertilizer-form').submit(function(e) {
            e.preventDefault();
            var _this = $(this);
            $('.err-msg').remove();
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_organic_fertilizers",
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
                error: err => {
                    console.log(err);
                    alert_toast("An error occurred", 'error');
                    end_loader();
                },
                success: function(resp) {
                    if (typeof resp == 'object' && resp.status == 'success') {
                        location.reload();
                    } else if (resp.status == 'failed' && !!resp.msg) {
                        var el = $('<div>');
                        el.addClass("alert alert-danger err-msg").text(resp.msg);
                        _this.prepend(el);
                        el.show('slow');
                        $("html, body").animate({
                            scrollTop: _this.closest('.container-fluid').offset().top
                        }, "fast");
                        end_loader();
                    } else {
                        alert_toast("An error occurred", 'error');
                        end_loader();
                        console.log(resp);
                    }
                }
            });
        });
    });
</script>