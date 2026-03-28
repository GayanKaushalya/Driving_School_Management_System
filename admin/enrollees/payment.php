<div class="container-fluid">
    <!-- Payment form for enrollee -->
    <form action="" id="save_payment">
        <input type="hidden" name="enrollee_id" value="<?= isset($_GET['id']) ? $_GET['id'] : "" ?>">

        <!-- Display the current balance -->
        <div class="form-group">
            <center><span class="text-center">Balance</span></center>
            <h3 class="text-center">
                <b><?= isset($_GET["balance"]) ? number_format($_GET["balance"], 2) : "0.00" ?></b>
                <!-- Shows balance in 2 decimal places; defaults to 0.00 if not set -->
            </h3>
        </div>

        <!-- Input for amount to be paid -->
        <div class="form-group">
            <label for="amount" class="control-label text-navy">Amount</label>
            <input type="number"
                name="amount"
                max="<?= isset($_GET["balance"]) ? ($_GET["balance"]) : 0 ?>"
                id="amount"
                class="form-control form-control-border border-navy text-right" required>
            <!-- Maximum value is set to current balance -->
        </div>

        <div class="form-group">
            <label for="remarks" class="control-label text-navy">Remarks</label>
            <textarea rows="2"
                name="remarks"
                id="remarks"
                class="form-control form-control-border border-navy text-right" required>
            </textarea>
        </div>
    </form>
</div>

<script>
    $(function() {
        $('#save_payment').submit(function(e) {
            e.preventDefault()
            start_loader()
            var el = $('<div>')
            el.addClass("pop-msg alert")
            el.hide()
            $.ajax({
                url: _base_url_ + "classes/Master.php?f=save_payment",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                error: err => {
                    console.log(err)
                    alert_taost("An error occured while saving the data,", "error")
                    end_loader()
                },
                success: function(resp) {
                    if (resp.status == 'success') {
                        location.reload() // Reload page if successful
                    } else if (!!resp.msg) {
                        el.addClass("alert-danger") // Show error with message from backend
                        el.text(resp.msg)
                        _this.prepend(el) // Add error alert to top of form
                    } else {
                        el.addClass("alert-danger")
                        el.text("An error occurred due to unknown reason.")
                        _this.prepend(el)
                    }
                    el.show('slow') // Fade in the error alert
                    end_loader();
                }
            })
        })
    })
</script>