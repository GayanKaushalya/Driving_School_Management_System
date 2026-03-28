<?php
// Include the configuration file (for database connection)
require_once('../../config.php');

// Check if an 'id' is provided in the URL
if (isset($_GET['id'])) {

    // SQL query to get the package data based on the ID
    $qry = $conn->query("SELECT * FROM `package_list` where id = '{$_GET['id']}'");

    // If a package is found
    if ($qry->num_rows > 0) {
        $res = $qry->fetch_array(); // Fetch the result as an array
        foreach ($res as $k => $v) {
            if (!is_numeric($k))
                $$k = $v;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View_Package</title>
    <style>
        /* This Statement Hide the modal footer inside a popup model*/
        #uni_modal .modal-footer {
            display: none !important;
        }
    </style>
</head>

<body>

    <!-- Container for displaying package details -->
    <div class="container-fluid">
        <dl>
            <!-- Display Package Name -->
            <dt class="text-muted">Name</dt>
            <dd class='pl-4 fs-4 fw-bold'><?= isset($name) ? $name : '' ?></dd>

            <!-- Display Package Description -->
            <dt class="text-muted">Description</dt>
            <dd class='pl-4'>
                <p class=""><small><?= isset($description) ? $description : '' ?></small></p>
            </dd>

            <!-- Display Training Duration -->
            <dt class="text-muted">Training Duration</dt>
            <dd class='pl-4 fs-4 fw-bold'><?= isset($training_duration) ? ($training_duration) : '' ?></dd>

            <!-- Display Package Cost with 2 decimal places -->
            <dt class="text-muted">Cost</dt>
            <dd class='pl-4 fs-4 fw-bold'><?= isset($cost) ? number_format($cost, 2) : '' ?></dd>


            <!-- Display Package Status -->
            <dt class="text-muted">Status</dt>
            <dd class='pl-4'>
                <?php
                // Package Status
                if (isset($status)):
                    switch ($status) {
                        case '1':
                            echo "<span class='badge badge-success badge-pill'>Active</span>";
                            break;
                        case '0':
                            echo "<span class='badge badge-secondary badge-pill'>Inactive</span>";
                            break;
                    }
                endif;
                ?>
            </dd>
        </dl>

        <!-- Close Button -->
        <div class="col-12 text-right">
            <button class="btn btn-flat btn-sm btn-dark" type="button" data-dismiss="modal"><i class="fa fa-times"></i>
                Close
            </button>
        </div>
    </div>
</body>

</html>