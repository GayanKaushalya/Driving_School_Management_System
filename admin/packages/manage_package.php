<?php
require_once('../../config.php'); // Include configuration and database connection

if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM `package_list` where id = '{$_GET['id']}'"); // Retrive package data by ID
    if ($qry->num_rows > 0) {
        $res = $qry->fetch_array();
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
    <title>Manage_Package</title>
</head>

<body>

    <!-- Package Form -->
    <div class="container-fluid">
        <form action="" id="package-form">

            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">

            <!-- Package Name Field -->
            <div class="form-group">
                <label for="name" class="control-label">Package Name</label>
                <input type="text" name="name" id="name" class="form-control form-control-border"
                    placeholder="Package Name" value="<?php echo isset($name) ? $name : '' ?>" required>
            </div>

            <!-- Package Description Field -->
            <div class="form-group">
                <label for="description" class="control-label">Description</label>
                <textarea rows="3" name="description" id="description" class="form-control form-control-border"
                    placeholder="Write the Package descrtion here."
                    required><?php echo isset($description) ? $description : '' ?></textarea>
            </div>

            <!-- Training Duration Field -->
            <div class="form-group">
                <label for="training_duration" class="control-label">Training Duration</label>
                <input type="text" name="training_duration" id="training_duration"
                    class="form-control form-control-border" placeholder="Package Name"
                    value="<?php echo isset($training_duration) ? $training_duration : '' ?>" required>
            </div>

            <!-- Package Cost Field -->
            <div class="form-group">
                <label for="cost" class="control-label">Package Cost</label>
                <input type="number" name="cost" id="cost" class="form-control form-control-border text-right"
                    placeholder="Package Cost" value="<?php echo isset($cost) ? $cost : 0 ?>" required>
            </div>

            <!-- Package Status Field -->
            <div class="form-group">
                <label for="" class="control-label">Status</label>
                <select name="status" id="status" class="form-control form-control-border" required>
                    <option value="1" <?= isset($status) && $status == 1 ? "selected" : "" ?>>Active</option>
                    <option value="0" <?= isset($status) && $status == 0 ? "selected" : "" ?>>Inactive</option>
                </select>
            </div>
        </form>
    </div>


    <!-- JavaScript/jQuery/ ajax for handling actions -->
    <script>
        $(function() {
            // When the form is submitted
            $('#uni_modal #package-form').submit(function(e) {
                e.preventDefault();
                var _this = $(this)
                $('.pop-msg').remove()
                var el = $('<div>')
                el.addClass("pop-msg alert")
                el.hide()
                start_loader();

                // Send AJAX request to save the package
                $.ajax({
                    url: _base_url_ + "classes/Master.php?f=save_package",
                    data: new FormData($(this)[0]),
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                    type: 'POST',
                    dataType: 'json',

                    // If there's an error in the request
                    error: err => {
                        console.log(err)
                        alert_toast("An error occured", 'error'); // Show error
                        end_loader(); // Stop loading spinner
                    },

                    // If the request is successful
                    success: function(resp) {
                        if (resp.status == 'success') {
                            location.reload(); // Reload page to reflect changes
                        } else if (!!resp.msg) {
                            // Show error message if available
                            el.addClass("alert-danger")
                            el.text(resp.msg)
                            _this.prepend(el)
                        } else {
                            // Show a generic error if no message provided
                            el.addClass("alert-danger")
                            el.text("An error occurred due to unknown reason.")
                            _this.prepend(el)
                        }
                        el.show('slow')
                        end_loader();
                    }
                })
            })
        })
    </script>
</body>

</html>