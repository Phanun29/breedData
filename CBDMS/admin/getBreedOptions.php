<?php
// getBreedOptions.php
include "database/db.php";

$sql = "SELECT breed_name FROM breed_name_tb";
$result = $conn->query($sql);

$options = "";
while ($row = $result->fetch_assoc()) {
    $options .= '<option value="' . $row['breed_name'] . '">' . $row['breed_name'] . '</option>';
}

echo $options;
$conn->close();
?>
