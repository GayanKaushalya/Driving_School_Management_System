<style>
/* Style sheet for the user image*/
.img-avatar {
    width: 45px;
    height: 45px;
    object-fit: cover;
    /* Ensures image covers the container without going out of the container */
    object-position: center center;
    /* Centers the image inside the container */
    border-radius: 100%;
}
</style>

<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Enrollees</h3>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <div class="container-fluid">
                <table class="table table-hover table-striped">
                    <colgroup>
                        <!--This part defines relative column widths -->
                        <col width="5%">
                        <col width="15%">
                        <col width="10%">
                        <col width="25%">
                        <col width="20%">
                        <col width="10%">
                        <col width="10%">
                    </colgroup>
                    <thead>
                        <tr>
                            <!-- Table headers -->
                            <th>#</th>
                            <th>Date Created</th>
                            <th>Reg. No</th>
                            <th>Fullname</th>
                            <th>Package</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
						$i = 1;
						$qry = $conn->query("SELECT e.*,CONCAT(lastname, ', ', firstname,' ',middlename) as fullname,p.name from `enrollee_list` e inner join package_list p on e.package_id = p.id order by e.`status` asc,unix_timestamp(e.`date_created`)");
						while ($row = $qry->fetch_assoc()):

						?>
                        <tr>
                            <!-- Display row number -->
                            <td class="text-center"><?php echo $i++; ?></td>

                            <!-- Format and display date -->
                            <td class=""><?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>

                            <!-- Display registration number -->
                            <td><?php echo ($row['reg_no']) ?></td>

                            <!-- Display full name with first letters capitalized -->
                            <td><?php echo ucwords($row['fullname']) ?></td>

                            <!-- Display package name -->
                            <td><?php echo ($row['name']) ?></td>

                            <!-- Display status -->
                            <td class="text-center">
                                <?php
									switch ($row['status']) {
										case '1':
											// Verified badge
											echo "<span class='badge badge-primary badge-pill'>Verified</span>";
											break;
										case '2':
											// In-session badge
											echo "<span class='badge badge-warning badge-pill'>In-Session</span>";
											break;
										case '3':
											// Completed badge
											echo "<span class='badge badge-success badge-pill'>Completed</span>";
											break;
										case '3':
											// Canceled badge
											echo "<span class='badge badge-danger badge-pill'>Cancelled</span>";
											break;
										case '0':
											// Pending badge
											echo "<span class='badge badge-light badge-pill text-dark border'>Pending</span>";
											break;
									}
									?>
                            </td>
                            <!-- Action dropdown menu -->
                            <td align="center">
                                <button type="button"
                                    class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon"
                                    data-toggle="dropdown">
                                    Action
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <div class="dropdown-menu" role="menu">
                                    <!-- View details link -->
                                    <a class="dropdown-item"
                                        href="./?page=enrollees/view_details&id=<?php echo $row['id'] ?>"><span
                                            class="fa fa-eye text-dark"></span> View</a>

                                    <div class="dropdown-divider"></div>

                                    <a class="dropdown-item edit_data"
                                        href="./?page=enrollees/Update_Enrolles&id=<?php echo $row['id'] ?>"
                                        data-id="<?= $row['id'] ?>">
                                        <span class="fa fa-edit text-primary"></span> Edit
                                    </a>

                                    <div class="dropdown-divider"></div>

                                    <!-- Delete action link -->
                                    <a class="dropdown-item delete_data" href="javascript:void(0)"
                                        data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span>
                                        Delete</a>
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
    // Confirm before verifying an enrollee
    $('.verified').click(function() {
        _conf("Are you sure to verify this enrollee Request?", "verified", [$(this).attr('data-id')])
    })

    // Confirm before deleting an enrollee
    $('.delete_data').click(function() {
        _conf("Are you sure to delete this enrollee permanently?", "delete_enrollee", [$(this).attr(
            'data-id')])
    })

    // Open view modal for enrollee
    $('.view_data').click(function() {
        uni_modal("enrollee Details", "enrollees/view_enrollee.php?id=" + $(this).attr('data-id'),
            "large")
    })
    $('.table td,.table th').addClass('py-1 px-2 align-middle')
    $('.table').dataTable({
        columnDefs: [{
            orderable: false,
            targets: 5
        }],
    });
})

// Function to delete enrollee via AJAX
function delete_enrollee($id) {
    start_loader(); // Show loading animation
    $.ajax({
        url: _base_url_ +
            "classes/Master.php?f=delete_enrollment", // Backend code to delete enrollee from the database
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

$('.edit_data').click(function() {
    var id = $(this).attr('data-id');
    uni_modal("Edit Enrollee", "enrollees/update_enrollee.php?id=" + id, 'md');
});
</script>