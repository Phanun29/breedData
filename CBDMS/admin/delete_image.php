<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['user_id'])) {
    header('location: ../index.php');
    exit();
}

// Check if the request method is POST and required parameters are set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['image_id']) && isset($_POST['data_id'])) {
    $imageId = $_POST['image_id'];
    $dataId = $_POST['data_id'];

    // Include database connection
    include_once "database/db.php";

    // Fetch the image paths from the database
    $sql = "SELECT images FROM data WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $dataId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imagePaths = explode(',', $row['images']);

        // Remove the specified image path
        if (isset($imagePaths[$imageId])) {
            $deletedImagePath = $imagePaths[$imageId];

            // Remove the image path from the array
            unset($imagePaths[$imageId]);

            // Update the images column in the database with the updated image paths
            $updatedImagePaths = implode(',', $imagePaths);
            $updateSql = "UPDATE data SET images = ? WHERE id = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("si", $updatedImagePaths, $dataId);
            $updateStmt->execute();

            // Check if the update was successful
            if ($updateStmt->affected_rows > 0) {
                // Delete the image file from the server
                if (file_exists($deletedImagePath)) {
                    unlink($deletedImagePath);
                }
                // Return success response
                echo json_encode(["success" => true]);
                exit();
            }
        }
    }
}

// Return failure response if deletion failed
echo json_encode(["success" => false]);
