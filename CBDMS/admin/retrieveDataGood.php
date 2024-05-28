<?php
session_start();
// Redirect to login page if user is not logged in
if (!isset($_SESSION['username']) && !isset($_SESSION['user_id'])) {
    header('location: ../index.php');
    exit(0);
}

include "database/db.php";
include "include/foradmin.php";

// Check if filter parameters are set
if (isset($_POST['filterBreed1']) && isset($_POST['filterBreed2']) && isset($_POST['version'])) {
    // Get filter values
    $filterBreed1 = $_POST['filterBreed1'];
    $filterBreed2 = $_POST['filterBreed2'];
    $version = $_POST['version'];

    // Prepare and execute the query
    $sql = "SELECT * FROM data WHERE breed1 = '$filterBreed1' AND breed2 = '$filterBreed2' AND version = $version ORDER BY id DESC";
    $result = $conn->query($sql);

    // Check if data is available
    if ($result && $result->num_rows > 0) {
        // Initialize variables to store HTML content for part 1 and part 2 tables
        $part1HTML = "";
        $part2HTML = "";

        // Loop through the results and generate HTML for each table
        while ($row = $result->fetch_assoc()) {
            // Generate HTML for part 1 table
            $i = 1;;
            $a = 1;;
            $part1HTML .= "<tr class='text-center'>";
            // Add table row content here for part 1
            $part1HTML .= "<td class='text-center'>" . $i++ . "</td>";
            $part1HTML .= "<td class='text-center'>" . $row['breed1'] . "</td>";
            $part1HTML .= "<td class='text-center'>" . $row['breed2'] . "</td>";
            $part1HTML .= "<td class='text-center'>" . $row['version'] . "</td>";
            $part1HTML .= "<td class='text-center'>" . $row['Fruit_height'] . "</td>";
            $part1HTML .= "<td class='text-center'>" . $row['Stem_height'] . "</td>";
            $part1HTML .= "<td class='text-center'>" . $row['Male_flowering_day'] . "</td>";
            $part1HTML .= "<td class='text-center'>" . $row['Flower_Day'] . "</td>";
            $part1HTML .= "<td class='text-center'>" . $row['sum'] . "</td>";
            $part1HTML .= "</tr>";

            // Generate HTML for part 2 table
            $part2HTML .= "<tr class='text-center'>";
            $part2HTML .= "<td class='text-center'>" . $a++ . "</td>";
            $part2HTML .= "<td class='text-center'>" . $row['breed1'] . "</td>";
            $part2HTML .= "<td class='text-center'>" . $row['breed2'] . "</td>";
            $part2HTML .= "<td class='text-center'>" . $row['version'] . "</td>";
            $part2HTML .= "<td class='text-center'>" . $row['Fruit_height'] . "</td>";
            $part2HTML .= "<td class='text-center'>" . $row['Stem_height'] . "</td>";
            $part2HTML .= "<td class='text-center'>" . $row['Male_flowering_day'] . "</td>";
            $part2HTML .= "<td class='text-center'>" . $row['Flower_Day'] . "</td>";
            $part2HTML .= "<td class='text-center'>" . $row['sum'] . "</td>";
            // Add table row content here for part 2
            $part2HTML .= "</tr>";
        }

        // Send JSON response with HTML content for both tables
        echo json_encode(array("part1HTML" => $part1HTML, "part2HTML" => $part2HTML));
    } else {
        // If no data matches the filter criteria, send a message
        echo json_encode(array("error" => "No matching records found."));
    }
} else {
    // If filter parameters are not set, send an error message
    echo json_encode(array("error" => "Filter parameters not set."));
}
?>
<script>
    $(document).ready(function() {
        $("#applyFiltersBtn").click(function() {
            var filterBreed1 = $("#filterBreed1").val();
            var filterBreed2 = $("#filterBreed2").val();
            var filterVersion = $("#version").val();
            console.log("filterBreed1:", filterBreed1);
            console.log("filterBreed2:", filterBreed2);
            console.log("version:", filterVersion);

            $.ajax({
                type: "POST",
                url: "retrieveData2.php",
                data: {
                    filterBreed1: filterBreed1,
                    filterBreed2: filterBreed2,
                    version: filterVersion
                },
                success: function(response) {
                    try {
                        // Try to parse the JSON response
                        var data = JSON.parse(response);

                        // Check if there's an error message
                        if (data.error) {
                            // Display error message
                            $("#list_user").html("<p class='text-center'>" + data.error + "</p>");
                        } else {
                            // Update the HTML content of the tables
                            $("#myTable tbody").html(data.part1HTML);
                            $("#myTable1 tbody").html(data.part2HTML);
                        }
                    } catch (error) {
                        // Handle parsing error
                        console.error("Error parsing JSON:", error);
                    }
                },

                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                }
            });
        });
    });
</script>