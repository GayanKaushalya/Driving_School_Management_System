<!-- CSS styling for avatar images (round and fixed size) -->
<style>
	.img-avatar {
		width: 45px;
		height: 45px;
		object-fit: cover;
		object-position: center center;
		border-radius: 100%;
		/* this css ststement makes the image circular */
	}
</style>

<?php
// Get the current date and a date one week ago
$from = date("Y-m-d", strtotime(date("Y-m-d") . " -1 week"));
$to = date("Y-m-d");
?>

<!-- Main card container for payment reports -->
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Payment Reports</h3> <!-- Report title -->
	</div>

	<div class="card-body">
		<div class="container-fluid">
			<!-- Filter form to select date range -->
			<form action="" id="filter-data">
				<div class="row align-items-end">

					<!-- From Date -->
					<div class="col-md-4">
						<div class="form-group">
							<label for="from" class="control-label">From</label>
							<input type="date" name="from" id="from" value="<?= $from ?>"
								class="form-control form-control-border border-navy">
						</div>
					</div>

					<!-- To Date -->
					<div class="col-md-4">
						<div class="form-group">
							<label for="to" class="control-label">To</label>
							<input type="date" name="to" id="to" value="<?= $to ?>"
								class="form-control form-control-border border-navy">
						</div>
					</div>

					<!-- Filter and Print Buttons -->
					<div class="col-md-4">
						<div class="form-group">
							<button class="btn btn-primary btn-flat">
								<i class="fa fa-filter"></i>
								Filter
							</button>
							<button class="btn btn-success btn-flat" type="button" id="print">
								<iclass="fa fa-print"></i>
									Print
							</button>
						</div>
					</div>
				</div>
			</form>

			<!-- Table to display the payment report -->
			<div id="outprint">
				<table class="table table-hover table-striped">
					<colgroup>
						<col width="5%">
						<col width="25%">
						<col width="25%">
						<col width="25%">
						<col width="20%">
					</colgroup>

					<thead>
						<tr>
							<th class="text-center">#</th>
							<th>DateTime</th>
							<th>Reg. No</th>
							<th>Fullname</th>
							<th class="text-right">Amount</th>
						</tr>
					</thead>

					<tbody>
						<?php
						$i = 1;
						// SQL query to get payment records and enrollee data
						$qry = $conn->query("SELECT p.*,e.reg_no,CONCAT(e.lastname, ', ', e.firstname,' ',e.middlename) as fullname 
						from `enrollee_list` e 
						inner join payment_list p on p.enrollee_id = e.id 
						order by unix_timestamp(e.`date_created`) asc");

						// Display each payment record as a row
						while ($row = $qry->fetch_assoc()):
						?>
							<tr>
								<td class="text-center"><?php echo $i++; ?></td>

								<!-- Payment date/time -->
								<td class=""><?php echo date("Y-m-d H:i", strtotime($row['date_created'])) ?></td>

								<!-- Registration number -->
								<td><?php echo ($row['reg_no']) ?></td>

								<!-- Full name -->
								<td><?php echo ucwords($row['fullname']) ?></td>

								<!-- Amount paid -->
								<td class="text-right"><?php echo number_format($row['amount'], 2) ?></td>
							</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- JavaScript for Print Functionality -->
<script>
	$(document).ready(function() {

		// Add padding and vertical alignment to all table cells
		$('.table td,.table th').addClass('py-1 px-2 align-middle')

		// When Print button is clicked
		$('#print').click(function() {
			var _h = $("head").clone()
			var _p = $('#outprint').clone() // Copy the content to print
			var el = $("<div>")
			start_loader()

			// Append all script tags from the original page
			$('script').each(function() {
				if (_h.find('script[src="' + $(this).attr('src') + '"]').length <= 0) {
					_h.append($(this).clone())
				}
			})


			// Prepare the date range label for the report
			var ao = "";
			if ("<?= $from ?>" == "<?= $to ?>") {
				ao = "as of <?= date("M d, Y", strtotime($from)) ?>"
			} else {
				ao = "as of <?= (date("M d, Y", strtotime($from))) . ' - ' . (date("M d, Y", strtotime($to)))  ?>"
			}

			// stsatement to Set the print view title
			_h.find('title').text("Payment Report - Print View")

			// Add header content to the print view
			_p.prepend("<hr class='border-navy bg-navy'>")
			_p.prepend(
				"<div class='mx-5 py-4'><h1 class='text-center'><?= $_settings->info("name") ?></h1>" +
				"<h5 class='text-center'>Enrollees' Payments Report</h5><h5 class='text-center'>" + ao +
				"</h5></div>")
			_p.prepend("<img src='<?= validate_image($_settings->info('logo')) ?>' id='print-logo' />")

			// Combine head and content in a new element
			el.append(_h)
			el.append(_p)

			// Open a new popup browser window to print the report
			var nw = window.open("", "_blank", "height=800,width=1200,left=200")
			nw.document.write(el.html()) // Write the print content
			nw.document.close()

			// Wait a short time and then trigger the browser print
			setTimeout(() => {
				nw.print()
				setTimeout(() => {
					nw.close() // Close the window after printing
					end_loader() // Hide loading indicator
				}, 300);
			}, 300)
		})
	})
</script>