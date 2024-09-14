<?php
require_once('../../config.php');
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * FROM `sanitizers` WHERE id = '{$_GET['id']}'");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
    }
}
?>
<div class="container-fluid">
    <form action="" id="sanitizers-form">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">

        <!-- Sanitizer Name -->
        <div class="form-group">
            <label for="sanitizer_name" class="control-label">Sanitizer Name</label>
            <input type="text" name="sanitizer_name" id="sanitizer_name" class="form-control form-control-sm rounded-0" value="<?php echo isset($sanitizer_name) ? $sanitizer_name : ''; ?>" />
        </div>

        <!-- Active Ingredient -->
        <div class="form-group">
            <label for="active_ingredient" class="control-label">Active Ingredient</label>
            <input type="text" name="active_ingredient" id="active_ingredient" class="form-control form-control-sm rounded-0" value="<?php echo isset($active_ingredient) ? $active_ingredient : ''; ?>" />
        </div>

        <!-- Brand Name -->
        <div class="form-group">
            <label for="brand_name" class="control-label">Brand Name</label>
            <input type="text" name="brand_name" id="brand_name" class="form-control form-control-sm rounded-0" value="<?php echo isset($brand_name) ? $brand_name : ''; ?>" />
        </div>

        <!-- Intended Use -->
        <div class="form-group">
            <label for="intended_use" class="control-label">Intended Use</label>
            <input type="text" name="intended_use" id="intended_use" class="form-control form-control-sm rounded-0" value="<?php echo isset($intended_use) ? $intended_use : ''; ?>" />
        </div>

        <!-- Frequency -->
        <div class="form-group">
            <label for="frequency" class="control-label">Frequency</label>
            <input type="text" name="frequency" id="frequency" class="form-control form-control-sm rounded-0" value="<?php echo isset($frequency) ? $frequency : ''; ?>" />
        </div>

        <!-- Expiry Date -->
        <div class="form-group">
            <label for="expiry_date" class="control-label">Expiry Date</label>
            <input type="date" name="expiry_date" id="expiry_date" class="form-control form-control-sm rounded-0" value="<?php echo isset($expiry_date) && $expiry_date != '0000-00-00' ? $expiry_date : ''; ?>" />
        </div>
    </form>


</div>
<script>
    $(document).ready(function() {
        $('#sanitizers-form').submit(function(e) {
            e.preventDefault();
            var _this = $(this);
            $('.err-msg').remove();
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_sanitizer",
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
                    console.log(resp);
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