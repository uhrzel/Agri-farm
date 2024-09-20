<?php if ($_settings->chk_flashdata('success')): ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
    </script>
<?php endif; ?>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">Archiving documents</h3>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="container-fluid">
                <table class="table table-hover table-striped">
                    <colgroup>
                        <col width="5%">
                        <col width="15%">
                        <col width="15%">
                        <col width="15%">
                        <col width="10%">
                        <col width="10%">
                        <col width="10%">
                        <col width="5%">
                        <col width="5%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>User</th>
                            <th>Crops</th>
                            <th>Crop Cycle</th>
                            <th>Date Planted</th>
                            <th>Date Harvested</th>
                            <th>Hectarage</th>
                            <th>Harvest (kg)</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        // Fetch active production harvesting entries
                        $qry = $conn->query("SELECT ph.*, u.firstname, u.lastname 
                                             FROM production_harvesting ph 
                                             JOIN users u ON ph.user_id = u.id 
                                             WHERE ph.delete_flag = 1 
                                             ORDER BY u.firstname ASC");
                        while ($row = $qry->fetch_assoc()):
                        ?>
                            <tr>
                                <td class="text-center"><?php echo $i++; ?></td>
                                <td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
                                <td><?php echo $row['crops']; ?></td>
                                <td><?php echo $row['crop_cycle']; ?></td>
                                <td><?php echo $row['date_planted']; ?></td>
                                <td><?php echo $row['date_harvest']; ?></td>
                                <td><?php echo $row['hectarage']; ?></td>
                                <td><?php echo $row['harvest_kg']; ?></td>

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
        $('.table').dataTable({
            columnDefs: [{
                orderable: false,
                targets: [8] // Disable ordering on the actions column
            }],
            order: [0, 'asc']
        });
        $('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle');

        // Handle the Archive button click
        $('.archive-btn').click(function() {
            var id = $(this).attr('data-id');
            console.log(id); // Debug: Check if ID is captured correctly
            if (confirm('Are you sure you want to archive this record?')) {
                $.ajax({
                    url: 'production/archive_production_harvesting.php',
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
    });
</script>


<script>
    $(document).ready(function() {

        $('.view_data').click(function() {
            uni_modal("<i class='fa fa-eye'></i> Category Details", "farmer/view_farmer.php?id=" + $(this).attr('data-id'))
        })


    })
</script>