<?php if ($_settings->chk_flashdata('success')): ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
    </script>
<?php endif; ?>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Production and Harvesting Records</h3>
        <div class="card-tools">
            <a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span> Create New</a>
        </div>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="container-fluid">
                <table class="table table-hover table-striped">
                    <colgroup>
                        <col width="5%">
                        <col width="15%">
                        <col width="20%">
                        <col width="15%">
                        <col width="15%">
                        <col width="10%">
                        <col width="15%">
                        <col width="15%">
                        <col width="10%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Crops</th>
                            <th>Crop Cycle</th>
                            <th>Date Planted</th>
                            <th>Date of Harvest</th>
                            <th>Hectarage</th>
                            <th>Estimated Harvest</th>
                            <th>Location</th>
                            <th>Plat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;

                        $user_id = isset($_SESSION['userdata']['id']) ? $_SESSION['userdata']['id'] : null;

                        // Adjust query to select from production_harvesting table
                        $qry = $conn->query("SELECT * FROM `production_harvesting` WHERE `user_id` = {$user_id} AND `delete_flag` = 0 ORDER BY `id` DESC");
                        while ($row = $qry->fetch_assoc()):

                        ?>
                            <tr>
                                <td class="text-center"><?php echo $i++; ?></td>
                                <td><?php echo htmlspecialchars($row['crops']); ?></td>
                                <td><?php echo htmlspecialchars($row['crop_cycle']); ?></td>
                                <td><?php echo date("F j, Y", strtotime($row['date_planted'])); ?></td>
                                <td><?php echo date("F j, Y", strtotime($row['date_harvest'])); ?></td>
                                <td><?php echo htmlspecialchars($row['hectarage']); ?></td>
                                <td><?php echo htmlspecialchars($row['harvest_kg']); ?></td>
                                <td><?php echo htmlspecialchars($row['location']); ?></td>
                                <td><?php echo htmlspecialchars($row['plat']); ?></td>
                                <td align="center">
                                    <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                        Action
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                        <a class="dropdown-item view_data" href="javascript:void(0)" data-id="<?php echo $row['id']; ?>"><span class="fa fa-eye text-dark"></span> View</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item edit_data" href="javascript:void(0)" data-id="<?php echo $row['id']; ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id']; ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
                                        <a class="dropdown-item archive_btn" href="javascript:void(0)" data-id="<?php echo $row['id']; ?>"><span class="fa fa-archive text-success"></span> Archive</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.delete_data').click(function() {
            console.log($(this).attr('data-id')); // Check if the correct ID is retrieved

            _conf("Are you sure to delete this Production and Harvesting permanently?", "delete_production", [$(this).attr('data-id')])
        })
        $('#create_new').click(function() {
            uni_modal("<i class='fa fa-plus'></i> Add New Production", "farmer_records/manage_production.php")
        })
        $('.view_data').click(function() {
            uni_modal("<i class='fa fa-eye'></i> Production and Harvesting Details", "farmer_records/view_production.php?id=" + $(this).attr('data-id'))
        })
        $('.edit_data').click(function() {
            uni_modal("<i class='fa fa-edit'></i> Update Production and Harvesting Details", "farmer_records/manage_production.php?id=" + $(this).attr('data-id'))
        })
        $('.table').dataTable({
            columnDefs: [{
                orderable: false,
                targets: [4, 5]
            }],
            order: [0, 'asc']
        });
        $('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')

        $('.archive_btn').click(function() {
            var id = $(this).attr('data-id');
            console.log(id); // Debug: Check if ID is captured correctly
            if (confirm('Are you sure you want to archive this record?')) {
                $.ajax({
                    url: 'farmer_records/archive_production_harvesting.php',
                    method: 'POST',
                    data: {
                        id: id
                    },
                    success: function(resp) {
                        console.log(resp); // Debug: Check server response
                        if (resp == 1) {
                            alert_toast("Record archived successfully", 'success');
                            setTimeout(function() {
                                location.reload();
                            }, 1500);
                        } else {
                            alert_toast("Failed to archive the record: " + resp, 'error'); // Display error message
                        }
                    }
                });
            }
        });
    })

    function delete_production($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_production",
            method: "POST",
            data: {
                id: $id
            },
            dataType: "json",
            error: err => {
                console.log(err)
                alert_toast("An error occured.", 'error');
                end_loader();
            },
            success: function(resp) {
                if (typeof resp == 'object' && resp.status == 'success') {
                    location.reload();
                } else {
                    alert_toast("An error occured.", 'error');
                    end_loader();
                }
            }
        })
    }
</script>