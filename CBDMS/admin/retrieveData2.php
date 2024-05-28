<?php
// retrieveData.php
session_start();
include "database/db.php";

// Retrieve filter values
$filterBreed1 = trim($_POST['filterBreed1']);
$filterBreed2 = trim($_POST['filterBreed2']);
$filterVersion = trim($_POST['version']); // Assuming the input field for version is named 'version'

// Build filter conditions
$filterConditions = [];

if (!empty($filterBreed1)) {
    $filterConditions[] = "breed1 = '$filterBreed1'";
}

if (!empty($filterBreed2)) {
    $filterConditions[] = "breed2 = '$filterBreed2'";
}

if (!empty($filterVersion)) {
    $filterConditions[] = "version = '$filterVersion'";
}

// Combine filter conditions using AND
$filterCondition = !empty($filterConditions) ? ' AND ' . implode(' AND ', $filterConditions) : '';

// Construct SQL query
$sql = "SELECT * FROM data WHERE 1 $filterCondition";



//echo "SQL Query: " . $sql . "<br>";

$result = $conn->query($sql);

if (!$result) {
    die("Error in query: " . $conn->error);
}
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div id='MyCard'>";
        echo "<a href='detail2.php?id={$row['id']}'>";
        echo "<div class='overflow-hidden'>";

        // Check if there are images for the current record
        $images = explode(',', $row['images']);
        if (!empty($images[0])) {
            echo "<img src='{$images[0]}' alt='Image'>";
        } else {
            echo "<div class='d-flex justify-content-center pt-3'>No Image</div>";
        }

        echo '</div>';
        echo "<p>{$row['breed1']}<span class='p-2'>{$row['breed2']} {$row['version']}</span></p>";
        echo '</a>';
        echo '</div>';
    }
} else {
    echo "No_Data in the database.";
}


error_log("SQL Query: " . $sql);

$conn->close();
