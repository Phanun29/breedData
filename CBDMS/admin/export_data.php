

<?php
include "database/db.php";

// Database query for CSV export
$sql = "SELECT * FROM data"; // Replace 'your_table' with your actual table name
$result = $conn->query($sql);

// Set headers for download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="data_export.csv"');

// Create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// Define column headers
$headers = array(
    '#',
    'Breed 1',
    'Breed 2',
    'ជំនាន់',
    'Male Flowering Age',
    'Flowering Age',
    'Flowering Age Gap',
    'Number of Stalks',
    'Number of Chrysanthemums',
    'Fruit Height',
    'Male Stalk Length',
    'Stem Height',
    'Fruit Length and Skin',
    'Leaf Angle',
    'The Tail on the End of the Fruit',
    'Fruit Length',
    'Fertility',
    'Fruit Appearance',
    'Original Size',
    'Stem Length',
    'Root System',
    'Germination rate',
    'Birth rate albino',
    'worm damage level',
    'Strength',
    'age gap between male and female flowers',
    'get sick',
    'disease level',
    'number of collapsed trees',
    'peeled fruit diameter',
    'peel number',
    'number of rows of seeds per fruit',
    'number of bullets per rows',
    'seed range shape',
    'fruit appreaance',
    'grain color',
    'fruit peel',
    'weight',
    'worm',
    'seeding vigor',
    'your child strength'
);

// Write the column headers to the CSV file
fputcsv($output, $headers);

// Write data rows to the CSV file
$index = 1;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Construct the data row array
        $rowData = array(
            $index++,
            $row['breed1'],
            $row['breed2'],
            $row['version'],
            $row['Male_flowering_age'],
            $row['Flowering_age'],
            $row['Flowering_age_gap'],
            $row['Number_of_stalks'],
            $row['Number_of_chrysanthemums'],
            $row['Fruit_height'],
            $row['Male_stalk_length'],
            $row['Stem_height'],
            $row['Fruit_length_and_skin'],
            $row['Leaf_angle'],
            $row['The_tail_on_the_end_of_the_fruit'],
            $row['Fruit_length'],
            $row['Fertility'],
            $row['Fruit_appearance'],
            $row['Original_size'],
            $row['Stem_length'],
            $row['Root_system'],
            $row['Germination_rate'],
            $row['Birth_rate_albino'],
            $row['worm_damage_level'],
            $row['Strength'],
            $row['age_gap_between_male_and_female_flowers'],
            $row['get_sick'],
            $row['disease_level'],
            $row['number_of_collapsed_trees'],
            $row['peeled_fruit_diameter'],
            $row['peel_number'],
            $row['number_of_rows_of_seeds_per_fruit'],
            $row['number_of_bullets_per_rows'],
            $row['seed_range_shape'],
            $row['fruit_appreaance'],
            $row['grain_color'],
            $row['fruit_peel'],
            $row['weight'],
            $row['worm'],
            $row['seeding_vigor'],
            $row['your_child_strength']
        );
        // Write the data row to the CSV file
        fputcsv($output, $rowData);
    }
}

// Close the file pointer
fclose($output);

// Close the database connection
$conn->close();