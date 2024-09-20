<?php if ($_settings->chk_flashdata('success')): ?>
	<script>
		alert_toast("<?php echo htmlspecialchars($_settings->flashdata('success'), ENT_QUOTES); ?>", 'success');
	</script>
<?php endif; ?>

<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Sanitizers</h3>
	</div>
	<div class="card-body">
		<div class="container-fluid">
			<table class="table table-hover table-striped">
				<colgroup>
					<col width="5%">
					<col width="15%">
					<col width="20%">
					<col width="15%">
					<col width="15%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>User</th>
						<th>Sanitizer Name</th>
						<th>Active Ingredient</th>
						<th>Brand Name</th>
						<th>Expiry Date</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					// Fetch sanitizers data with user details
					$qry = $conn->query("SELECT s.*, u.firstname, u.lastname 
                                         FROM sanitizers s 
                                         JOIN users u ON s.user_id = u.id 
                                         WHERE s.delete_flag = 0 
                                         ORDER BY u.firstname ASC");
					while ($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo htmlspecialchars($row['firstname'] . ' ' . $row['lastname'], ENT_QUOTES); ?></td>
							<td><?php echo htmlspecialchars($row['sanitizer_name'], ENT_QUOTES); ?></td>
							<td><?php echo htmlspecialchars($row['active_ingredient'], ENT_QUOTES); ?></td>
							<td><?php echo htmlspecialchars($row['brand_name'], ENT_QUOTES); ?></td>
							<td><?php echo htmlspecialchars(date('Y-m-d', strtotime($row['expiry_date'])), ENT_QUOTES); ?></td>
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
			order: [0, 'asc']
		});
		$('.dataTable td, .dataTable th').addClass('py-1 px-2 align-middle');
	});
</script>