<?php
if (isset($_POST['update'])) {
    $userId = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $status = $_POST['status'];
    $type = $_POST['type'];


    include_once "database/db.php";

    $sql = "UPDATE users SET
            first_name = '$first_name',
            last_name = '$last_name',
            username = '$username',
            email = '$email',
            phone_number = '$phone_number',
            status = '$status',
            type = '$type'
            WHERE id = $userId";

    $conn->query($sql);

    $conn->close();
    header("Location: user.php");
    exit();
}
