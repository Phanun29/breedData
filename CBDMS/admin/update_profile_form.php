<?php
session_start();

if (isset($_POST['update'])) {
    // Retrieve other form data
    $userId = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];

    // Handle file upload
    $images = $_FILES['images'];

    // Check if a file is selected
    if ($images['name']) {
        // Check if the uploaded file is an image
        $check = getimagesize($images["tmp_name"]);
        if ($check === false) {
            echo "File is not an image.";
            exit();
        }

        $target_dir = "uploads/";
        $target_file = $target_dir . basename($images["name"]);

        // Check file size and type (optional)
        if ($images["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            exit();
        }

        // Move uploaded file to the target directory
        if (!move_uploaded_file($images["tmp_name"], $target_file)) {
            echo "Sorry, there was an error uploading your file.";
            exit();
        }

        // Update the profile picture path only if a new image is uploaded
        $imageUpdateQuery = ", images = '$target_file'";
    } else {
        // If no file is uploaded, set the target file to empty
        $imageUpdateQuery = "";
    }

    include_once "database/db.php";

    // Update user information including the profile picture path
    $sql = "UPDATE users SET
            first_name = '$first_name',
            last_name = '$last_name',
            username = '$username',
            email = '$email',
            phone_number = '$phone_number'
            $imageUpdateQuery
            WHERE id = $userId";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['success_message'] = "Profile updated successfully.";
    } else {
        $_SESSION['error_message'] = "Error updating user profile: " . $conn->error;
    }

    $conn->close();
    header("Location: profile.php?id=" . $userId);
    exit();
}
