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
$i = 1;
$totalAverage = 0; // Initialize total average variable

// Variables to store sum of each column
$sumFruitHeight = 0;
$sumStemHeight = 0;
$sumMaleFloweringDay = 0;
$sumFlowerDay = 0;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Increment sum of each column
        $sumFruitHeight += intval($row['Fruit_height']);
        $sumStemHeight += intval($row['Stem_height']);
        $sumMaleFloweringDay += intval($row['Male_flowering_day']);
        $sumFlowerDay += intval($row['Flower_Day']);
        // ... (your existing code to display table rows)
        // Output or log relevant data here
        echo '<tr class="text-center">';
        echo '<td>' . $i++ . '</td>';
        echo '<td>' . $row['breed1'] . '</td>';
        echo '<td>' . $row['breed2'] . '</td>';
        echo '<td>' . $row['version'] . '</td>';
        echo '<td>' . $row['code'] . '</td>';

        echo '<td>' . $row['Fruit_height'] . '</td>';
        echo '<td>' . $row['Stem_height'] . '</td>';
        echo '<td>' . $row['Male_flowering_day'] . '</td>';
        echo '<td>' . $row['Flower_Day'] . '</td>';
        echo '<td>' . $row['Number_of_stalks'] . '</td>';
        echo '<td>' . $row['Leaf_angle'] . '</td>';
        echo '<td>' . $row['Fruit_length'] . '</td>';
        echo '<td>' . $row['Fruit_appearance'] . '</td>';
        echo '<td>' . $row['Stem_length'] . '</td>';
        echo '<td>' . $row['Germination_rate'] . '</td>';
        echo '<td>' . $row['worm_damage_level'] . '</td>';
        echo '<td>' . $row['age_gap_between_male_and_female_flowers'] . '</td>';
        echo '<td>' . $row['disease_level'] . '</td>';
        echo '<td>' . $row['peeled_fruit_diameter'] . '</td>';
        echo '<td>' . $row['number_of_rows_of_seeds_per_fruit'] . '</td>';
        echo '<td>' . $row['fruit_peel'] . '</td>';
        echo '<td>' . $row['worm'] . '</td>';
        echo '<td>' . $row['your_child_strength'] . '</td>';
        echo '<td>' . $row['Number_of_roots'] . '</td>';

        echo '<td>' . $row['grain_color'] . '</td>';
        echo '<td>' . $row['Male_flowering_age'] . '</td>';
        echo '<td>' . $row['Flowering_age'] . '</td>';
        echo '<td>' . $row['Flowering_age_gap'] . '</td>';
        echo '<td>' . $row['Number_of_chrysanthemums'] . '</td>';
        echo '<td>' . $row['Male_stalk_length'] . '</td>';
        echo '<td>' . $row['Fruit_length_and_skin'] . '</td>';
        echo '<td>' . $row['The_tail_on_the_end_of_the_fruit'] . '</td>';
        echo '<td>' . $row['Fertility'] . '</td>';
        echo '<td>' . $row['Original_size'] . '</td>';
        echo '<td>' . $row['Root_system'] . '</td>';
        echo '<td>' . $row['Birth_rate_albino'] . '</td>';
        echo '<td>' . $row['Strength'] . '</td>';
        echo '<td>' . $row['get_sick'] . '</td>';
        echo '<td>' . $row['number_of_collapsed_trees'] . '</td>';
        echo '<td>' . $row['peel_number'] . '</td>';
        echo '<td>' . $row['number_of_bullets_per_rows'] . '</td>';
        echo '<td>' . $row['weight'] . '</td>';
        echo '<td>' . $row['seeding_vigor'] . '</td>';
        echo '<td>' . $row['seed_range_shape'] . '</td>';
        echo '<td>' . $row['Tip_length'] . '</td>';

        echo '<td>' . $row['sum'] . '</td>';
        // echo '<td>' . $row['Stem_height'] . '</td>';
        // echo '<td>' . $row['additional_column1'] . '</td>'; // Output additional column from myTable2
        //  echo '<td>' . $row['additional_column2'] . '</td>'; // Output additional column from myTable2
        //echo "<td><a class='btn btn-primary float-start' href='details.php?id={$row['id']}'><i class='fa-solid fa-eye me-1'></i>លម្អិត</a>";
?>


        <!-- Modal -->
        <!-- <div class="modal fade" id="exampleModal<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">បញ្ជាក់</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        តើអ្នកពិតជាចង់លុបទិន្នន័យមែនទេ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ទេ</button>
                        <a href="delete_data.php?id=<?php echo $row['id'] ?>" class="btn btn-danger">លុប</a>


                    </div>
                </div>
            </div> -->
        <!-- </div> -->
<?php

        echo "  </td>";
        echo '</tr>';
    }
    // Calculate the average of each column
    $numRows = $result->num_rows;
    $averageFruitHeight = $sumFruitHeight / $numRows;
    $averageStemHeight = $sumStemHeight / $numRows;
    $averageMaleFloweringDay = $sumMaleFloweringDay / $numRows;
    $averageFlowerDay = $sumFlowerDay / $numRows;

    // Calculate the average of averages
    $totalAverage = ($averageFruitHeight + $averageStemHeight + $averageMaleFloweringDay + $averageFlowerDay) / 4;

    // Display the total average
    echo '<tr>';
    echo '<td></td>';
    echo '<td></td>';
    echo '<td></td>';
    echo '<td></td>';
    echo '<td colspan="1" class="text-center">Average of Data</td>';
    echo '<td colspan="1">' . number_format($averageFruitHeight, 2) . '</td>';
    echo '<td colspan="1">' . number_format($averageStemHeight, 2) . '</td>';
    echo '<td colspan="1">' . number_format($averageMaleFloweringDay, 2) . '</td>';
    echo '<td colspan="1">' . number_format($averageFlowerDay, 2) . '</td>';
    echo '</tr>';
} else {
    echo '<tr><td colspan="8" class="text-center">No matching records found.</td></tr>';
}


error_log("SQL Query: " . $sql);

$conn->close();
