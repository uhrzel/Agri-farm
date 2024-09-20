<?php if ($_settings->chk_flashdata('success')): ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
	</script>
<?php endif; ?>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Production Harvesting</h3>
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
						<col width="15%">
						<col width="10%">
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
						// Join the users and production_harvesting tables
						$qry = $conn->query("SELECT ph.*, u.firstname, u.lastname 
                                             FROM production_harvesting ph 
                                             JOIN users u ON ph.user_id = u.id 
                                             WHERE ph.delete_flag = 0 
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
				targets: [7] // Disable ordering on the last column
			}],
			order: [0, 'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
	})
</script>