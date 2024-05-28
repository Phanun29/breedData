<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khmer Text Example</title>
    <style>
        /* Define a custom font that supports Khmer characters */
        @font-face {
            font-family: 'KhmerFont';
            src: url('path_to_your_font/KhmerFont.ttf') format('truetype');
            /* Replace 'path_to_your_font' with the actual path */
        }

        /* Apply the custom font to the entire document */
        body {
            font-family: 'KhmerFont', Arial, sans-serif;
            /* Fallback to Arial or sans-serif if the custom font is not available */
        }
    </style>
</head>

<body>

    <?php
    session_start();
    include "database/db.php";

    // Retrieve filter values
    $filterBreed1 = isset($_POST['filterBreed1']) ? trim($_POST['filterBreed1']) : '';
    $filterBreed2 = isset($_POST['filterBreed2']) ? trim($_POST['filterBreed2']) : '';
    $filterVersion = isset($_POST['version']) ? trim($_POST['version']) : '';

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
    $filterCondition = !empty($filterConditions) ? ' WHERE ' . implode(' AND ', $filterConditions) : '';

    // Construct SQL query
    $sql = "SELECT * FROM data" . $filterCondition . " ORDER BY id DESC";

    // Execute the filtered query to retrieve data
    $result = $conn->query($sql);
    if (!$result) {
        die("Error executing query: " . $conn->error);
    }



    // Create a new HTML table with headers
    $tableHtml = "<table border='1'>
                <thead>
                    <tr>
                    <th>#</th>
                    <th>ពូជទី១</th>
                    <th>ពូជទី២</th>
                    <th>ជំនាន់</th>
                    <th>លេខសម្គល់</th>
                    <th>ចំនួនទងផ្កា</th>
                    <th>កម្ពស់ផ្លែ</th>
                    <th>កម្ពស់ដើម</th>
                    <th>មុំស្លឹក</th>
                    <th>ប្រវែងផ្លែ</th>
                    <th>រូបរាងផ្លែ</th>
                    <th>ប្រវែងគល់ផ្លែ</th>
                    <th>អត្រាដំណុះ</th>
                    <th>កម្រិតបំផ្លាញរបស់ដង្កូវ</th>
                    <th>គម្លាតអាយុផ្កាញីនិងឈ្មោល</th>
                    <th>កម្រិតការកើតជំងឺ</th>
                    <th>អង្កត់ផ្ចិតផ្លែបកសំបក</th>
                    <th>ចំនួនជួរគ្រាប់ក្នុងមួយផ្លែ</th>
                    <th>សំបកផ្លែ</th>
                    <th>ដង្កូវ</th>
                    <th>ភាពរឹងមាំរបស់កូន</th>
                    <th>ចំនួនឫស</th>
                    <th>ថ្ងៃចេញផ្កាឈ្មោល ៥០%</th>
                    <th>ពណ៌គ្រាប់</th>
                    <th>អាយុចេញផ្កាឈ្មោល</th>
                    <th>អាយុចេញផ្កាញី</th>
                    <th>គម្លាតអាយុចេញផ្កា</th>
                    <th>ចំនួនផ្កាឈ្មោល</th>
                    <th>ប្រវែងទងផ្កាឈ្មោល</th>
                    <th>ប្រវែងផ្លែទាំងសំបក</th>
                    <th>ភាពមានកន្ទុយលើចុងផ្លែ</th>
                    <th>ភាពជាប់ផ្លែ</th>
                    <th>ទំហំដើម</th>
                    <th>ប្រព័ន្ធឫស</th>
                    <th>កម្រិតកើត Albino</th>
                    <th>ភាពរឹងមាំ</th>
                    <th>កើតជំងឺ</th>
                    <th>ចំនួនដើមរលំ</th>
                    <th>ប្រវែងផ្លែបបកសំបក</th>
                    <th>ចំនួនគ្រាប់ក្នុងមួយជួរ</th>
                    <th>ទម្ងន់</th>
                    <th>seeding vigor</th>
                    <th>ការរៀងជួររបស់គ្រាប់</th>
                    <th>ប្រវែងចុងស្នៀត(cm)</th>
                    <th>ថ្ងៃចេញផ្កាញី​​ ៥០%</th>
                    <th>សរុប</th>
                    </tr>
                </thead>
                <tbody>";

    if ($result->num_rows > 0) {
        // Loop through each row of data
        $index = 1;
        while ($row = $result->fetch_assoc()) {
            // Append data rows to the table
            $tableHtml .= "<tr>
                        <td>{$index}</td>
                        <td>{$row['breed1']}</td>
                        <td>{$row['breed2']}</td>
                        <td>{$row['version']}</td>
                        <td>{$row['code']}</td>
                        <td>{$row['Number_of_stalks']}</td>
                        <td>{$row['Fruit_height']}</td>
                        <td>{$row['Stem_height']}</td>
                        <td>{$row['Leaf_angle']}</td>
                        <td>{$row['Fruit_length']}</td>
                        <td>{$row['Fruit_appearance']}</td>
                        <td>{$row['Stem_length']}</td>
                        <td>{$row['Germination_rate']}</td>
                        <td>{$row['worm_damage_level']}</td>
                        <td>{$row['age_gap_between_male_and_female_flowers']}</td>
                        <td>{$row['disease_level']}</td>
                        <td>{$row['peeled_fruit_diameter']}</td>
                        <td>{$row['number_of_rows_of_seeds_per_fruit']}</td>
                        <td>{$row['fruit_peel']}</td>
                        <td>{$row['worm']}</td>
                        <td>{$row['your_child_strength']}</td>
                        <td>{$row['Number_of_roots']}</td>
                        <td>{$row['Male_flowering_day']}</td>
                        <td>{$row['grain_color']}</td>
                        <td>{$row['Male_flowering_age']}</td>
                        <td>{$row['Flowering_age']}</td>
                        <td>{$row['Flowering_age_gap']}</td>
                        <td>{$row['Number_of_chrysanthemums']}</td>
                        <td>{$row['Male_stalk_length']}</td>
                        <td>{$row['Fruit_length_and_skin']}</td>
                        <td>{$row['The_tail_on_the_end_of_the_fruit']}</td>
                        <td>{$row['Fertility']}</td>
                        <td>{$row['Original_size']}</td>
                        <td>{$row['Root_system']}</td>
                        <td>{$row['Birth_rate_albino']}</td>
                        <td>{$row['Strength']}</td>
                        <td>{$row['get_sick']}</td>
                        <td>{$row['number_of_collapsed_trees']}</td>
                        <td>{$row['peel_number']}</td>
                        <td>{$row['number_of_bullets_per_rows']}</td>
                        <td>{$row['weight']}</td>
                        <td>{$row['seeding_vigor']}</td>
                        <td>{$row['seed_range_shape']}</td>
                        <td>{$row['Tip_length']}</td>
                        <td>{$row['Flower_Day']}</td>
                        <td>{$row['sum']}</td>

                    </tr>";
            $index++;
        }
    } else {
        $tableHtml .= "<tr><td colspan='41'>No data available</td></tr>";
    }

    $tableHtml .= "</tbody></table>";

    // Export the HTML table to Excel
    header('Content-Type: text/html; charset=utf-8');
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename=data_corn.xls');
    echo $tableHtml;

    // Close the database connection
    $conn->close();
    ?>





</body>

</html>