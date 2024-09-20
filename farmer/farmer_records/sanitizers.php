<?php if ($_settings->chk_flashdata('success')): ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
    </script>
<?php endif; ?>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Sanitizers Records</h3>
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
                            <th>Sanitizers</th>
                            <th>Active Ingredient</th>
                            <th>Brand Name</th>
                            <th>Intended Use</th>
                            <th>Frequency Use</th>
                            <th>Expiry Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $user_id = isset($_SESSION['userdata']['id']) ? $_SESSION['userdata']['id'] : null;
                        // Adjust query to select from production_harvesting table
                        $qry = $conn->query("SELECT * FROM `sanitizers` where  `user_id` = {$user_id} AND delete_flag = 0  ORDER BY `id` DESC");
                        while ($row = $qry->fetch_assoc()):
                            // Format the harvest date range if needed
                            /*  $harvest_date = $row['date_planted'] . ' to ' . $row['date_harvest']; */
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $i++; ?></td>
                                <td><?php echo htmlspecialchars($row['sanitizer_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['active_ingredient']); ?></td>
                                <td><?php echo htmlspecialchars($row['brand_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['intended_use']); ?></td>
                                <td><?php echo htmlspecialchars($row['frequency']); ?></td>
                                <td><?php echo htmlspecialchars($row['expiry_date']); ?></td>
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

            _conf("Are you sure to delete this Sanitizer Record Permanently?", "delete_sanitizer", [$(this).attr('data-id')])
        })
        $('#create_new').click(function() {
            uni_modal("<i class='fa fa-plus'></i> Add New Sanitizer", "farmer_records/manage_sanitizer.php")
        })
        $('.view_data').click(function() {
            uni_modal("<i class='fa fa-eye'></i> Sanitizer Details", "farmer_records/view_sanitizer.php?id=" + $(this).attr('data-id'))
        })
        $('.edit_data').click(function() {
            uni_modal("<i class='fa fa-edit'></i> Update Sanitizer Details", "farmer_records/manage_sanitizer.php?id=" + $(this).attr('data-id'))
        })
        $('.table').dataTable({
            columnDefs: [{
                orderable: false,
                targets: [4, 5]
            }],
            order: [0, 'asc']
        });
        $('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
    })

    function delete_sanitizer($id) {
        start_loader();
        $.ajax({
            url: _base_url_ + "classes/Master.php?f=delete_sanitizer",
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