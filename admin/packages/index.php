<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Training Packages</title>

	<!-- Style for avatar image to be round and properly sized -->
	<style>
		.img-avatar {
			width: 45px;
			height: 45px;
			object-fit: cover;
			object-position: center center;
			border-radius: 100%;
		}
	</style>
</head>

<body>

	<!-- Card container for displaying the training packages list -->
	<div class="card card-outline card-primary">
		<div class="card-header">
			<h3 class="card-title">List of Training Packages</h3>
			<div class="card-tools">
				<!-- Button to add a new package -->
				<a href="javascript:void(0)" id="create_new" class="btn btn-flat btn-sm btn-primary"><span
						class="fas fa-plus"></span> Add New Package</a>
			</div>
		</div>
		<div class="card-body">
			<div class="container-fluid">
				<div class="container-fluid">

					<!-- Table to display package list -->
					<table class="table table-hover table-striped">
						<colgroup>
							<col width="5%">
							<col width="20%">
							<col width="20%">
							<col width="30%">
							<col width="15%">
							<col width="10%">
						</colgroup>
						<thead>
							<tr>
								<th>#</th>
								<th>Date Created</th>
								<th>Name</th>
								<th>Description</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>

						<tbody>

							<!-- Initialize row number counter for the table-->
							<?php
							$i = 1;
							// Query to retrieve all packages from database ordered by name
							$qry = $conn->query("SELECT * from `package_list`order by `name` asc ");
							while ($row = $qry->fetch_assoc()):

							?>
								<tr>
									<!-- Show row number -->
									<td class="text-center"><?php echo $i++; ?></td>

									<!-- Format and display date created -->
									<td class=""><?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>

									<!-- Capitalize and display name -->
									<td><?php echo ucwords($row['name']) ?></td>

									<!-- Show description -->
									<td class="truncate-1"><?php echo $row['description'] ?></td>

									<!-- Show status badge -->
									<td class="text-center">
										<?php

										// Status of the packages(Active/ Inactive)
										switch ($row['status']) {
											case '1':
												echo "<span class='badge badge-success badge-pill'>Active</span>";
												break;
											case '0':
												echo "<span class='badge badge-secondary badge-pill'>Inactive</span>";
												break;
										}
										?>
									</td>
									<td align="center">

										<button type="button"
											class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon"
											data-toggle="dropdown">
											Action
											<span class="sr-only">Toggle Dropdown</span>
										</button>

										<div class="dropdown-menu" role="menu">
											<!-- View package -->
											<a class="dropdown-item view_data" href="javascript:void(0)"
												data-id="<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span>
												View
											</a>

											<div class="dropdown-divider"></div>
											<!-- Edit package -->
											<a class="dropdown-item edit_data" href="javascript:void(0)"
												data-id="<?php echo $row['id'] ?>"><span
													class="fa fa-edit text-primary"></span>
												Edit
											</a>

											<div class="dropdown-divider"></div>
											<!-- Delete package -->
											<a class="dropdown-item delete_data" href="javascript:void(0)"
												data-id="<?php echo $row['id'] ?>"><span
													class="fa fa-trash text-danger"></span>
												Delete
											</a>
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

	<!-- JavaScript/jQuery/ajax for handling actions -->
	<script>
		$(document).ready(function() {
			// Handle "Add New Package" button click
			$('#create_new').click(function() {
				uni_modal("Package Details", "packages/manage_package.php")
			})

			// Handle edit button click
			$('.edit_data').click(function() {
				uni_modal("Package Details", "packages/manage_package.php?id=" + $(this).attr('data-id'))
			})

			// Handle delete button click
			$('.delete_data').click(function() {
				_conf("Are you sure to delete this Package permanently?", "delete_package", [$(this).attr(
					'data-id')])
			})

			// Handle view button click
			$('.view_data').click(function() {
				uni_modal("Package Details", "packages/view_package.php?id=" + $(this).attr('data-id'))
			})

			// this statement Style table cells
			$('.table td,.table th').addClass('py-1 px-2 align-middle')

			// Initialize DataTables plugin with column 5 (Actions) non-sortable
			$('.table').dataTable({
				columnDefs: [{
					orderable: false,
					targets: 5
				}],
			});
		})

		// Function to handle package deletion
		function delete_package($id) {
			start_loader(); // Display a loading animation
			$.ajax({
				url: _base_url_ + "classes/Master.php?f=delete_package",
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
					// If response is successful, reload the page in real time
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

</body>

</html>