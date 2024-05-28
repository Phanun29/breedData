<?php
session_start();
// print_r($_SESSION);
if (!isset($_SESSION['username']) && !isset($_SESSION['user_id'])) {
    header('location: ../index.php');
    exit(0);
}
// Constants for pagination
include_once "database/db.php";


$rowsPerPage = 12; // Adjust as needed
$currentPage = isset($_GET['page']) ? intval($_GET['page']) : 1;

// Calculate the offset for the current page
$offset = ($currentPage - 1) * $rowsPerPage;

// Query to get the total number of records
$totalRecordsQuery = "SELECT COUNT(*) as total FROM data";
$totalRecordsResult = $conn->query($totalRecordsQuery);
$totalRecords = $totalRecordsResult->fetch_assoc()['total'];

// Calculate total pages
$totalPages = ceil($totalRecords / $rowsPerPage);

// Query to retrieve data for the current page
$sql = "SELECT * FROM data ORDER BY id DESC LIMIT $offset, $rowsPerPage";
$result = $conn->query($sql);
include_once "include/foradmin.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>HOME</title>
    <?php include "include/head.php"; ?>



</head>

<body class="">
    <!-- database -->
    <?php include_once "database/db.php" ?>
    <!-- header  -->
    <?php include_once "include/header.php" ?>
    <!-- navigation -->
    <?php include_once "include/navigation.php" ?>

    <br>
    <div class="wrappage " id="wrappage">
        <div class="" id="filter_card">
            <form id="" class=" ">
                <div class="">
                    <div class="float-start"></div>
                    <div class="float-end d-flex justify-centent-between ml-12" style="width: 477px;">
                        <!-- Inside your form in the HTML -->
                        <div class="" style="width: 158px;">
                            <select class="form-control" name="filterBreed1" id="filterBreed1" required>
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
                        <div class=" mx-2" style="width: 158px;">
                            <select class="form-control " name="filterBreed2" id="filterBreed2" required>
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
                        <div class="">
                            <input style="width: 100px;" type="number" min="1" name="version" id="version" class="form-control" placeholder="ជំនាន់">
                        </div>
                        <div class="ms-2" style="width: 133px;">
                            <button type="button" id="applyFiltersBtn" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass me-1"></i>ស្វែងរក</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div id="parent_page">
            <div class="pic_breed container">
                <?php
                // Check if there are rows in the result set
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div id='MyCard'>";
                        // echo "<a href='detail2.php?id={$row['id']}.{$_SESSION['user_id']}'>";
                        echo "<a href='detail2.php?id={$row['id']}'>";

                        echo "<div class='overflow-hidden'>";

                        // Check if there are images for the current record
                        $images = explode(',', $row['images']);
                        if (!empty($images[0])) {
                            echo "<img src='{$images[0]}' alt='Image'>";
                        } else {
                            echo "<div class='d-flex justify-content-center pt-3'>គ្មានរូបភាព</div>";
                        }

                        echo '</div>';
                        echo "<p>{$row['breed1']} <span>x</span><span class='p-2'>{$row['breed2']} {$row['version']}</span></p>";
                        echo '</a>';
                        echo '</div>';
                    }
                } else {
                    echo "No Data in the database.";
                }
                ?>
            </div>
        </div>
        <div class="d-flex justify-content-center container mb-4" id="child_page">
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
    <br>
    <?php
    include "include/footer.php";
    ?>
    <script src="script/filter_copy.js"></script>
    <script>
        function updateNumberedButtons(totalPages, currentPage) {
            var buttonsContainer = $(".pagination");

            buttonsContainer.empty(); // Clear existing buttons

            buttonsContainer.append(
                `<li class="page-item">
            <a class="page-link" href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
                <span class="sr-only">Previous</span>
            </a>
        </li>`
            );

            for (var i = 1; i <= totalPages; i++) {
                buttonsContainer.append(
                    `<li class="page-item ${i === currentPage ? "active" : ""}">
                <a class="page-link" href="#" onclick="goToPage(${i})">${i}</a>
            </li>`
                );
            }

            buttonsContainer.append(
                `<li class="page-item">
            <a class="page-link" href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                <span class="sr-only">Next</span>
            </a>
        </li>`
            );
        }
    </script>

</body>

</html>