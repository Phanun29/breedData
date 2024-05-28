<?php
// Include your database connection file
include_once "database/db.php";
if (isset($_POST['update_id'])) {

    $updated_breed_name = $_POST['updated_breed_name'];
    $update_id = $_POST['update_id'];
    error_log('Received POST data: ' . print_r($_POST, true));
    // Perform UPDATE query
    $sql = "UPDATE breed_name_tb SET breed_name='$updated_breed_name' WHERE id=$update_id";
    if ($conn->query($sql) === TRUE) {
       echo "Breed updated successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    echo "Error: Update ID is not set.";
}
