<?php
include "database/db.php";
session_start();

if (isset($_GET['id'])) {
    // Get the user ID from the URL
    $id = $_GET['id'];

    // Prepare the SQL statement
    $sql = "DELETE FROM data WHERE id = ?";
    $stmt = $conn->prepare($sql);

    // Bind parameters and execute the statement
    $stmt->bind_param("i", $id); // Assuming 'id' is an integer
    $stmt->execute();

    // Check if the deletion was successful
    if ($stmt->affected_rows > 0) {
        $_SESSION['status'] = "ការលុប User ជោគជ័យ";
    } else {
        $_SESSION['status'] = "ការលុប User បរាជ័យ";
    }

    // Redirect to another page
    header("location: {$_SERVER['HTTP_REFERER']}");
    exit;
} else {
    echo "Form not submitted"; // Debugging
}
