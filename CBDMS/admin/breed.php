<?php
session_start();
// Redirect to login page if user is not logged in
if (!isset($_SESSION['username']) && !isset($_SESSION['user_id'])) {
    header('location: ../index.php');
    exit(0);
}
include "database/db.php";
include "include/foradmin.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>DATA</title>
    <?php include "include/head.php"; ?>
    <script src="https://unpkg.com/tableexport.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.0/xlsx.full.min.js"></script>
    <style>
        @font-face {
            font-family: 'KhmerFont';
            src: url('path/to/khmer-font.ttf') format('truetype');
        }
    </style>
</head>

<body>
    <!-- header  -->
    <?php include_once "include/header.php" ?>
    <!-- navigation -->
    <?php include "include/navigation.php"; ?>
    <br>
    <div class="wrappage ">
        <h2 class="container fload-start ">
            <a class="text-decoration-underline  p-1 text-dark nav-item" href="breed.php">បញ្ជីទិន្នន័យ</a>
            <a class="text-decoration-none nav-item" href="list_breed.php">បញ្ជីពូជ</a>
        </h2>
        <div class="container pt-3">
            <form id="" class=" ">
                <div class="float-start">
                    <button type="button" id="exportButton" class="btn btn-primary" onclick="exportToExcel()">Export <i class="fa-solid fa-download"></i></button>
                    <!-- <a href="excel.php" class="btn btn-primary">Export to Excel</a> -->
                    <button type="button" id="exportButton" class="btn btn-primary" onclick="window.location.href='export_to_excel.php'">Export All <i class="fa-solid fa-download"></i></button>
                </div>
                <div class="float-end">
                    <div>
                        <div class="float-start mx-2 d-flex justify-content-between" style="font-family: 'Poppins', 'Khmer OS battambang', sans-serif; font-weight: 500;">
                            <div class="float-start mx-2">
                                <select class="form-control" name="filterBreedA" id="filterBreedA" required>
                                    <?php
                                    // Perform SELECT query
                                    $sql = "SELECT breed_name FROM breed_name_tb";
                                    $result1 = $conn->query($sql);
                                    // Check if the query was successful
                                    if ($result1 && $result1->num_rows > 0) {
                                        // Fetch data and display options for the first dropdown
                                        echo '<option value="">ជ្រើសរើស</option>'; // Default option
                                        while ($row1 = $result1->fetch_assoc()) {
                                            echo '<option value="' . $row1['breed_name'] . '">' . $row1['breed_name'] . '</option>';
                                        }
                                    } else {
                                        // If no data is retrieved or an error occurs, display a default option
                                        echo '<option value="">No options available</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="float-end">
                                <select class="form-control " name="filterBreedB" id="filterBreedB" required>
                                    <option value="">ជ្រើសរើស</option>
                                    <?php
                                    // Reset the result set pointer to the beginning
                                    $result1->data_seek(0);
                                    // Fetch data and display options for the second dropdown
                                    while ($row1 = $result1->fetch_assoc()) {
                                        echo '<option value="' . $row1['breed_name'] . '">' . $row1['breed_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mx-2">

                                <input style="width: 100px;" type="number" min="1" name="version" id="version" class="form-control" placeholder="ជំនាន់">
                            </div>
                        </div>

                        <div class="float-end">

                            <button type="button" id="applyFiltersBtn" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass me-1"></i>ស្វែងរក</button>
                            <!-- <button type="button" id="applyFiltersBtn1" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass me-1"></i>ស្វែងរក</button> -->
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div id="list_user" class="container" style="overflow: auto;">
            <table id='myTable' class="container">
                <thead>
                    <tr class="text-center">
                        <th style="width: 4%;">#</th>
                        <th style="width: 10%;">ពូជទី១</th>
                        <th style="width: 10%;">ពូជទី២</th>
                        <th style="width: 5%;">ជំនាន់</th>
                        <th style="width: 8%;">កម្ពស់ផ្លែ</th>
                        <th style="width: 8%;">កម្ពស់ដើម</th>
                        <th style="width: 10%;">ថ្ងៃចេញផ្កាញី​ ៥០%</th>
                        <th style="width: 10%;">ថ្ងៃចេញផ្កាឈ្មោល​ ៥០%</th>
                        <th style="width: 17%;">សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Constants for pagination
                    $rowsPerPage = 10; // Adjust as needed
                    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
                    // Calculate the offset for the current page
                    $offset = ($currentPage - 1) * $rowsPerPage;
                    // Adjust offset to reflect the correct range of items for the current page
                    $startIndex = $offset + 1;
                    // $endIndex = min($offset + $rowsPerPage, $totalRecords);
                    // Query to get the total number of records
                    $totalRecordsQuery = "SELECT COUNT(*) as total FROM data";
                    $totalRecordsResult = $conn->query($totalRecordsQuery);
                    $totalRecords = $totalRecordsResult->fetch_assoc()['total'];
                    // Calculate total pages
                    $totalPages = ceil($totalRecords / $rowsPerPage);
                    // Query to retrieve data for the current page
                    $sql = "SELECT * FROM data ORDER BY id DESC LIMIT $offset, $rowsPerPage";
                    $result = $conn->query($sql);
                    $i = $startIndex;;
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr class="text-center">';
                            echo '<td>' . $i++ . '</td>';
                            echo '<td>' . $row['breed1'] . '</td>';
                            echo '<td>' . $row['breed2'] . '</td>';
                            echo '<td>' . $row['version'] . '</td>';
                            echo '<td>' . $row['Fruit_height'] . '</td>';
                            echo '<td>' . $row['Stem_height'] . '</td>';
                            echo '<td>' . $row['Male_flowering_day'] . '</td>';
                            echo '<td>' . $row['Flower_Day'] . '</td>';
                            echo "<td><a class='btn btn-primary text-white float-start px-3' href='details.php?id={$row['id']}'><i class='fa-solid fa-eye me-1'></i>លម្អិត</a>
                                   ";
                    ?>
                            <button type="button" class='btn btn-danger float-end px-4' data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $row['id'] ?>" onclick="setDeleteParams(<?php echo $row['id'] ?>, <?php echo $currentPage ?>)">
                                <i class="fa-solid fa-trash-can"></i>លុប
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal<?php echo $row['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                </div>
                            </div>
                    <?php
                            echo "</td>";
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="8" class="text-center">No matching records found.</td></tr>';
                    }
                    //  $conn->close()
                    ?>
                </tbody>
            </table>
            <table id='myTable1' class="container" style="display:none;overflow:auto;">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>ពូជទី១</th>
                        <th>ពូជទី២</th>
                        <th>ជំនាន់</th>
                        <th>លេខសម្គាល់</th>
                        <th>កម្ពស់ផ្លែ</th>
                        <th>កម្ពស់ដើម</th>
                        <th>ថ្ងៃចេញផ្កាឈ្មោល ៥០%</th>
                        <th>ថ្ងៃចេញផ្កាញី​​ ៥០%</th>
                        <th>ចំនួនទងផ្កា</th>
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

                        <th>សរុប</th>
                    </tr>
                </thead>
                <tbody id="tbody2">
                    <?php
                    // Constants for pagination
                    $rowsPerPage = 10; // Adjust as needed
                    $currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;
                    // Calculate the offset for the current page
                    $offset = ($currentPage - 1) * $rowsPerPage;
                    // Adjust offset to reflect the correct range of items for the current page
                    $startIndex = $offset + 1;
                    // $endIndex = min($offset + $rowsPerPage, $totalRecords);
                    // Query to get the total number of records
                    $totalRecordsQuery = "SELECT COUNT(*) as total FROM data";
                    $totalRecordsResult = $conn->query($totalRecordsQuery);
                    $totalRecords = $totalRecordsResult->fetch_assoc()['total'];
                    // Calculate total pages
                    $totalPages = ceil($totalRecords / $rowsPerPage);
                    // Query to retrieve data for the current page
                    $sql = "SELECT * FROM data ORDER BY id DESC LIMIT $offset, $rowsPerPage";
                    $result = $conn->query($sql);
                    $i = $startIndex;;
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr class="text-center">';
                            echo '<td>' . $i++ . '</td>';
                            echo '<td>' . $row['breed1'] . '</td>';
                            echo '<td>' . $row['breed2'] . '</td>';
                            echo '<td>' . $row['version'] . '</td>';
                            echo '<td>' . $row['code'] . '</td>';
                            echo '<td>' . $row['Number_of_stalks'] . '</td>';
                            echo '<td>' . $row['Fruit_height'] . '</td>';
                            echo '<td>' . $row['Stem_height'] . '</td>';
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
                            echo '<td>' . $row['Male_flowering_day'] . '</td>';
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
                            echo '<td>' . $row['Flower_Day'] . '</td>';
                            echo '<td>' . $row['sum'] . '</td>';
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="8" class="text-center">No matching records found.</td></tr>';
                    }
                    $conn->close()
                    ?>
                </tbody>
            </table>
            <div id="paginationSection">
                <div class="d-flex justify-content-center mt-3">
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item <?php echo $currentPage == 1 ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only"></span>
                                </a>
                            </li>

                            <?php
                            for ($i = 1; $i <= $totalPages; $i++) {
                                echo '<li class="page-item ' . ($i == $currentPage ? 'active' : '') . '">';
                                echo '<a class="page-link" href="?page=' . $i . '">' . $i . '</a>';
                                echo '</li>';
                            }
                            ?>

                            <li class="page-item <?php echo $currentPage == $totalPages ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only"></span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>


    <?php
    include "include/footer.php";
    ?>

    <script src="script/export_excel.js"></script>
    <script src="script/get_breed.js"></script>
    <script src="script/update_row.js"></script>
    <!-- <script src="script/filter.js"></script> -->
    <script src="script/pagination.js"></script>
    <script src="script/filtercopy1.js"></script>
</body>

</html>