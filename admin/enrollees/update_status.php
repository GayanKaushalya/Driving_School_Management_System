<div class="container-fluid">
    <form action="" id="update_status_form">
        <input type="hidden" name="id" value="<?= isset($_GET['id']) ? $_GET['id'] : "" ?>">

        <div class="form-group">
            <!-- Label for the status dropdown -->
            <label for="status" class="control-label text-navy">Status</label>

            <!-- Dropdown menu to select enrollee status -->
            <select name="status" id="status" class="form-control form-control-border" required>
                <!--Enrollee status options to choose -->
                <option value="0" <?= isset($_GET['status']) && $_GET['status'] == 0 ? "selected" : "" ?>>Pending
                </option>
                <option value="1" <?= isset($_GET['status']) && $_GET['status'] == 1 ? "selected" : "" ?>>Verified
                </option>
                <option value="2" <?= isset($_GET['status']) && $_GET['status'] == 2 ? "selected" : "" ?>>In-Session
                </option>
                <option value="3" <?= isset($_GET['status']) && $_GET['status'] == 3 ? "selected" : "" ?>>Completed
                </option>
                <option value="4" <?= isset($_GET['status']) && $_GET['status'] == 4 ? "selected" : "" ?>>Cancelled
                </option>
            </select>
        </div>
    </form>
</div>

<script>
    $(function() {
        $('#update_status_form').submit(function(e) {
            e.preventDefault();
            start_loader(); // Show loading indicator

            var el = $('<div>');
            el.addClass("pop-msg alert");
            el.hide();

            // AJAX call to submit form data
            $.ajax({
                url: _base_url_ +
                    "classes/Master.php?f=update_status", // Backend endpoint to update status
                url: _base_url_ + "classes/Master.php?f=updt",
                method: "POST",
                data: $(this).serialize(), // Convert form data to URL encoded format
                dataType: "json",
                error: err => {
                    console.log(err);
                    alert_toast("An error occured while saving the data,",
                        "error"); // Show error toast
                    end_loader();
                },
                success: function(resp) {
                    if (resp.status == 'success') {
                        location.reload(); // Reload page if successful
                    } else if (!!resp.msg) {
                        el.addClass("alert-danger") // Show server-side error message if present
                        el.text(resp.msg);
                        _this.prepend(el); // Insert error message at the top of the form
                    } else {
                        el.addClass("alert-danger");
                        el.text("An error occurred due to unknown reason.");
                        _this.prepend(el);
                    }
                    el.show('slow');
                    end_loader();
                }.bind(this)
            })
        })
    })
</script>