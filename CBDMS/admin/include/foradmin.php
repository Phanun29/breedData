<?php
// Assuming you have stored user information in the session during login,
// you can fetch additional information such as the user's type from the database.
$user_id = $_SESSION['user_id'];

// Query to fetch user details including the type
$userQuery = "SELECT type FROM users WHERE id = $user_id";
$userResult = $conn->query($userQuery);

if ($userResult->num_rows > 0) {
    $userRow = $userResult->fetch_assoc();
    $userType = $userRow['type'];
} else {
    // Handle case where user details are not found
    // For example, redirect the user to the login page or display an error message
}
