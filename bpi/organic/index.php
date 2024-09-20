<?php if ($_settings->chk_flashdata('success')): ?>
	<script>
		alert_toast("<?php echo $_settings->flashdata('success') ?>", 'success')
	</script>
<?php endif; ?>

<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Organic Fertilizers</h3>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<table class="table table-hover table-striped">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="15%">
					<col width="15%">
					<col width="15%">
					<col width="10%">
					<col width="10%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>User</th>
						<th>Type</th>
						<th>Brand</th>
						<th>Supplier</th>
						<th>Crops Applied</th>
						<th>Frequency</th>
						<th>Expiry Date</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					// Fetch and join users and inorganic_fertilizers table
					$qry = $conn->query("SELECT f.*, u.firstname, u.lastname 
                                         FROM organic_fertilizers f 
                                         JOIN users u ON f.user_id = u.id 
                                         WHERE f.delete_flag = 0 
                                         ORDER BY u.firstname ASC");
					while ($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo $row['firstname'] . ' ' . $row['lastname']; ?></td>
							<td><?php echo $row['type']; ?></td>
							<td><?php echo $row['brand']; ?></td>
							<td><?php echo $row['supplier']; ?></td>
							<td><?php echo $row['crops_applied']; ?></td>
							<td><?php echo $row['frequency']; ?></td>
							<td><?php echo $row['expiry_date']; ?></td>
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
				targets: [7] // Disable ordering on the expiry date column
			}],
			order: [0, 'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
	})
</script>