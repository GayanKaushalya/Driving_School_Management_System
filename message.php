<!-- Hide the Footer Section of the Uni Modal -->
<style>
    #uni_modal .modal-footer {
        display: none;
    }
</style>

<!-- Main Container for the Enrollment Confirmation Message -->
<div class="container">
    <!-- Success Message -->
    <p>Your Driving School Enrollment has successfully submitted and will confirm you as soon as we sees your application.

        <!-- If registration number is passed in URL (GET method), display it -->
        <?php if (isset($_GET['reg_no'])): ?>
            Your registration # is <b><?= $_GET['reg_no'] ?></b>.
        <?php endif; ?>
        Thank you!

    </p>

    <!-- Close Button aligned to the right -->
    <div class="text-right">
        <button class="btn btn-sm btn-flat btn-dark" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
    </div>
</div>