<?php
$conn = new mysqli('localhost', 'root', '', 'cropsystem');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
