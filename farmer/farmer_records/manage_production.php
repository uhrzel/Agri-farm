<?php
require_once('../../config.php');
if (isset($_GET['id']) && $_GET['id'] > 0) {
    $qry = $conn->query("SELECT * FROM `production_harvesting` WHERE id = '{$_GET['id']}'");
    if ($qry->num_rows > 0) {
        foreach ($qry->fetch_assoc() as $k => $v) {
            $$k = $v;
        }
    }
}
?>
<div class="container-fluid">
    <form action="" id="harvest-form">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="form-group">
            <label for="crops" class="control-label">Crops</label>
            <select id="crops" name="crops" class="form-control form-control-sm rounded-0" onchange="toggleCustomCropInput()">
                <option value="">Select Crop</option>
                <option value="Sweet Pepper(Emperor F1)" <?php echo isset($crops) && $crops == 'Sweet Pepper(Emperor F1)' ? 'selected' : ''; ?>>Sweet Pepper(Emperor F1)</option>
                <option value="Ampalaya(Galaxy F1)" <?php echo isset($crops) && $crops == 'Ampalaya(Galaxy F1)' ? 'selected' : ''; ?>>Ampalaya(Galaxy F1)</option>
                <option value="Hot Pepper(Vulcan F1)" <?php echo isset($crops) && $crops == 'Hot Pepper(Vulcan F1)' ? 'selected' : ''; ?>>Hot Pepper(Vulcan F1)</option>
                <option value="Eggplant(Calixto F1)" <?php echo isset($crops) && $crops == 'Eggplant(Calixto F1)' ? 'selected' : ''; ?>>Eggplant(Calixto F1)</option>
                <option value="String Beans(Makisig F1)" <?php echo isset($crops) && $crops == 'String Beans(Makisig F1)' ? 'selected' : ''; ?>>String Beans(Makisig F1)</option>
                <option value="Hot Pepper(Lava F1)" <?php echo isset($crops) && $crops == 'Hot Pepper(Lava F1)' ? 'selected' : ''; ?>>Hot Pepper(Lava F1)</option>
                <option value="Sweet Corn(Sweet Supreme)" <?php echo isset($crops) && $crops == 'Sweet Corn(Sweet Supreme)' ? 'selected' : ''; ?>>Sweet Corn(Sweet Supreme)</option>
                <option value="Other" <?php echo isset($crops) && $crops == 'Other' ? 'selected' : ''; ?>>Other</option>
            </select>
        </div>
        <div id="customCropContainer" class="form-group" style="display: none;">
            <label for="customCrop" class="control-label">Please specify the crop:</label>
            <input type="text" id="customCrop" name="customCrop" class="form-control form-control-sm rounded-0" value="<?php echo isset($crops) && $crops == 'Other' ? $crops : ''; ?>">
        </div>

        <script>
            function toggleCustomCropInput() {
                const selectElement = document.getElementById('crops');
                const customCropContainer = document.getElementById('customCropContainer');
                if (selectElement.value === 'Other') {
                    customCropContainer.style.display = 'block';
                } else {
                    customCropContainer.style.display = 'none';
                }
            }
        </script>

        <div class="form-group">
            <label for="crop_cycle" class="control-label">Crop Cycle</label>
            <input type="text" name="crop_cycle" id="crop_cycle" class="form-control form-control-sm rounded-0" value="<?php echo isset($crop_cycle) ? $crop_cycle : ''; ?>" />
        </div>
        <div class="form-group">
            <label for="date_planted" class="control-label">Date Planted</label>
            <input type="date" name="date_planted" id="date_planted" class="form-control form-control-sm rounded-0" value="<?php echo isset($date_planted) && $date_planted != '0000-00-00' ? $date_planted : ''; ?>" />
        </div>
        <div class="form-group">
            <label for="date_harvest" class="control-label">Date Harvest</label>
            <input type="date" name="date_harvest" id="date_harvest" class="form-control form-control-sm rounded-0" value="<?php echo isset($date_harvest) && $date_harvest != '0000-00-00' ? $date_harvest : ''; ?>" />
        </div>
        <div class="form-group">
            <label for="hectarage" class="control-label">Hectarage</label>
            <input type="text" name="hectarage" id="hectarage" class="form-control form-control-sm rounded-0" value="<?php echo isset($hectarage) ? $hectarage : ''; ?>" />
        </div>
        <div class="form-group">
            <label for="harvest_kg" class="control-label">Estimated Harvest (kg)</label>
            <input type="text" name="harvest_kg" id="harvest_kg" class="form-control form-control-sm rounded-0" value="<?php echo isset($harvest_kg) ? $harvest_kg : ''; ?>" />
        </div>
        <div class="form-group">
            <label for="location" class="control-label">Location</label>
            <input type="text" name="location" id="location" class="form-control form-control-sm rounded-0" value="<?php echo isset($location) ? $location : ''; ?>" />
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        $('#harvest-form').submit(function(e) {
            e.preventDefault();
            var _this = $(this);
            $('.err-msg').remove();
            start_loader();
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_production_harvesting",
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