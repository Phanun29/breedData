<?php
// Include your database connection file
include_once "database/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $breed_name = $_POST['breed_name'];

    // Perform INSERT query
    $sql = "INSERT INTO breed_name_tb (breed_name) VALUES ('$breed_name')";
    if ($conn->query($sql) === TRUE) {
        echo "Data inserted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
