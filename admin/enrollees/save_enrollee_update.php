<?php

$db = new DBConnection();
$conn = $db->conn;

extract($_POST);

$update = $conn->query("UPDATE enrollee_list SET 
    firstname = '$firstname',
    middlename = '$middlename',
    lastname = '$lastname',
    address = '$address',
    contact = '$contact',
    email = '$email',
    package_id = '$package_id'
    WHERE id = $id
");

if ($update) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'failed']);
}