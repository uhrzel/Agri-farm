<?php if ($_settings->chk_flashdata('success')): ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success');
	</script>
<?php endif; ?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Pesticides</h3>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<table class="table table-hover table-striped">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="10%">
					<col width="15%">
					<col width="15%">
					<col width="10%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>User</th>
						<th>Type</th>
						<th>Active Ingredient</th>
						<th>Brand Name</th>
						<th>Crops Applied</th>
						<th>Target Pest</th>
						<th>Expiry Date</th>
						<!-- 				<th>Actions</th> -->
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					// Fetch pesticides data with user details
					$qry = $conn->query("SELECT p.*, u.firstname, u.lastname 
                                         FROM pesticides p 
                                         JOIN users u ON p.user_id = u.id 
                                         WHERE p.delete_flag = 0 
                                         ORDER BY u.firstname ASC");
					while ($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
							<td><?php echo $row['type']; ?></td>
							<td><?php echo $row['active_ingredient']; ?></td>
							<td><?php echo $row['brand_name']; ?></td>
							<td><?php echo $row['crops_applied']; ?></td>
							<td><?php echo $row['target_pest']; ?></td>
							<td><?php echo $row['expiry_date']; ?></td>
							<!-- <td>
							
								<button type="button" class="btn btn-danger btn-sm archive-btn" data-id="<?php echo $row['id']; ?>">Archive</button>
							</td> -->
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('.table').dataTable({
			columnDefs: [{
				orderable: false,
				targets: [7] // Disable ordering on the last column
			}],
			order: [0, 'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
		// Handle the Archive button click
		$('.archive-btn').click(function() {
			var id = $(this).attr('data-id');
			console.log(id); // Debug: Check if ID is captured correctly
			if (confirm('Are you sure you want to archive this record?')) {
				$.ajax({
					url: 'pesticides/archive_pesticides.php',
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