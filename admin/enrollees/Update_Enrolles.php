<?php
require_once('../config.php');
$db = new DBConnection();
$conn = $db->conn;

$id = $_GET['id'];
$qry = $conn->query("SELECT * FROM enrollee_list WHERE id = $id");
if ($qry->num_rows > 0) {
    $row = $qry->fetch_assoc();
}
?>

<form id="update-enrollee-form">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">
    <div class="form-group">
        <label>First Name</label>
        <input type="text" name="firstname" value="<?= $row['firstname'] ?>" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Middle Name (optional)</label>
        <input type="text" name="middlename" value="<?= $row['middlename'] ?>" class="form-control">
    </div>
    <div class="form-group">
        <label>Last Name</label>
        <input type="text" name="lastname" value="<?= $row['lastname'] ?>" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Address</label>
        <textarea name="address" class="form-control" required><?= $row['address'] ?></textarea>
    </div>
    <div class="form-group">
        <label>Telephone</label>
        <input type="text" name="contact" value="<?= $row['contact'] ?>" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" value="<?= $row['email'] ?>" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Training Package</label>
        <select name="package_id" class="form-control" required>
            <?php
            $packages = $conn->query("SELECT * FROM package_list");
            while ($pkg = $packages->fetch_assoc()):
            ?>
            <option value="<?= $pkg['id'] ?>" <?= $pkg['id'] == $row['package_id'] ? 'selected' : '' ?>>
                <?= $pkg['name'] ?>
            </option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="text-right">
        <button class="btn btn-primary" type="submit">Update</button>
    </div>
</form>

<script>
$('#update-enrollee-form').submit(function(e) {
    e.preventDefault();
    start_loader();
    $.ajax({
        url: '../classes/Master.php?f=update_enrollee',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        error: function(err) {
            console.log(err);
            alert_toast("An error occurred", 'error');
            end_loader();
        },
        success: function(resp) {
            if (resp.status == 'success') {
                alert_toast("Enrollee Details Updated successfully", 'success');
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                alert_toast("Failed to update", 'error');
                end_loader();
            }
        }
    });
});
</script>