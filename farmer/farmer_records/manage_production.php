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

                <?php
                // Fetch crops from the database
                $query = "SELECT crops_name FROM crops WHERE delete_flag = 0"; // Adjust query based on your logic
                $result = $conn->query($query); // Assuming $conn is your MySQLi or PDO connection

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $selected = isset($crops) && $crops == $row['crops_name'] ? 'selected' : '';
                        echo "<option value='" . htmlspecialchars($row['crops_name']) . "' $selected>" . htmlspecialchars($row['crops_name']) . "</option>";
                    }
                }
                ?>

                <!-- Static 'Other' option -->
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

            <!-- Dropdown for selecting the number of months -->
            <select id="month_select" name="crop_cycle_month" class="form-control form-control-sm rounded-0 mt-2" onchange="calculateHarvestDate()">
                <option value="">Select Number of Months</option>
                <!-- Generate month options from 1 to 12 -->
                <?php for ($i = 1; $i <= 12; $i++): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?> Month(s)</option>
                <?php endfor; ?>
            </select>

            <!-- Dropdown for selecting the number of days -->
            <select id="day_select" name="crop_cycle_day" class="form-control form-control-sm rounded-0 mt-2" onchange="calculateHarvestDate()">
                <option value="">Select Number of Days</option>
                <!-- Generate day options from 1 to 31 -->
                <?php for ($i = 1; $i <= 31; $i++): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?> Day(s)</option>
                <?php endfor; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="date_planted" class="control-label">Date Planted</label>
            <input type="date" name="date_planted" id="date_planted" class="form-control form-control-sm rounded-0" value="<?php echo isset($date_planted) && $date_planted != '0000-00-00' ? $date_planted : ''; ?>" />
        </div>


        <div class="form-group">
            <label for="date_harvest" class="control-label">Date Harvest</label>
            <input type="date" name="date_harvest" id="date_harvest" class="form-control form-control-sm rounded-0" value="<?php echo isset($date_harvest) && $date_harvest != '0000-00-00' ? $date_harvest : ''; ?>" />
        </div>

        <script>
            function calculateHarvestDate() {
                // Get the selected number of months and days from the correct IDs
                var months = parseInt(document.getElementById('month_select').value) || 0;
                var days = parseInt(document.getElementById('day_select').value) || 0;

                // Create a new Date object for the current date
                var currentDate = new Date();

                // Add the selected number of months and days to the current date
                currentDate.setMonth(currentDate.getMonth() + months); // Add months
                currentDate.setDate(currentDate.getDate() + days); // Add days

                // Format the new date in YYYY-MM-DD format
                var harvestDate = currentDate.toISOString().split('T')[0];

                // Set the harvest date in the date_harvest input field
                document.getElementById('date_harvest').value = harvestDate;


            }
        </script>

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
        <div class="form-group">
            <label for="plat" class="control-label">Plat</label>
            <input type="text" name="plat" id="plat" class="form-control form-control-sm rounded-0" value="<?php echo isset($plat) ? $plat : ''; ?>" />
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