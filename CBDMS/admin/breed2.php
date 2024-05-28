<?php
session_start();
// print_r($_SESSION);
if (!isset($_SESSION['username']) && !isset($_SESSION['user_id'])) {
    header('location: ../index.php');
    exit(0);
}

include "database/db.php";
include "include/forProfile.php";
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

// Assuming you have stored user information in the session during login,
// you can fetch additional information such as the user's type from the database.
$user_id = $_SESSION['user_id'];

// Query to fetch user details including the type
$userQuery = "SELECT type FROM users WHERE id = $user_id";
$userResult = $conn->query($userQuery);

if ($userResult->num_rows > 0) {
    $userRow = $userResult->fetch_assoc();
    $userType = $userRow['type'];
} else {
    // Handle case where user details are not found
    // For example, redirect the user to the login page or display an error message
}
include_once "include/foradmin.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>DATA</title>
    <?php include "include/head.php"; ?>
    <script src="https://unpkg.com/tableexport.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    <!-- header  -->
    <?php include_once "include/header.php" ?>
    <!-- navigation -->
    <?php include "include/navigation.php"; ?>
    <br>
    <div class="wrappage ">
        <h2 class="container fload-start ">

            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#home">list data</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#menu1">list breed</a>
                </li>

            </ul>
        </h2>
        <div class="tab-content">
            <div id="home" class="container tab-pane active"><br>
                <div class="container pt-3" id="datafilter">
                    <form id="filters" class=" ">
                        <div class="float-start">
                            <button type="button" id="exportButton" class="btn btn-primary" onclick="exportToExcel()">Export to Excel</button>

                        </div>
                        <div class="float-end">
                            <div>
                                <div class="float-start mx-2 d-flex justify-content-between" style="font-family: 'Quicksand', 'Khmer OS siemreap', sans-serif; font-weight: 500;">
                                    <!-- Inside your form in the HTML -->
                                    <div class="float-start mx-2">
                                        <select class="form-control" name="filterBreed1" id="filterBreed1" required>
                                            <?php
                                            // Perform SELECT query
                                            $sql = "SELECT breed_name FROM breed_name_tb";
                                            $result1 = $conn->query($sql);
                                            // Check if the query was successful
                                            if ($result1 && $result1->num_rows > 0) {
                                                // Fetch data and display options for the first dropdown
                                                echo '<option value="">Please Select</option>'; // Default option
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
                                        <select class="form-control " name="filterBreed2" id="filterBreed2" required>
                                            <option value="">Please Select</option>
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
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="list_user" class="container">
                    <table id='myTable' class="container">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 5%;">#</th>
                                <th style="width: 10%;">ពូជទី១</th>
                                <th style="width: 10%;">ពូជទី២</th>
                                <th style="width: 10%;">ជំនាន់</th>
                                <th style="width: 10%;">ចំនួនទងផ្កា</th>
                                <th style="width: 10%;">កម្ពស់ផ្លែ</th>
                                <th style="width: 10%;">កម្ពស់ដើម</th>
                                <th style="width: 17%;">សកម្មភាព</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = $startIndex;;
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr class="text-center">';
                                    echo '<td>' . $i++ . '</td>';
                                    echo '<td>' . $row['breed1'] . '</td>';
                                    echo '<td>' . $row['breed2'] . '</td>';
                                    echo '<td>' . $row['version'] . '</td>';
                                    echo '<td>' . $row['Number_of_stalks'] . '</td>';
                                    echo '<td>' . $row['Fruit_height'] . '</td>';
                                    echo '<td>' . $row['Stem_height'] . '</td>';
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
            <div id="menu1" class="container tab-pane fade"><br>
                <div id="list_user" class="container">
                    <table id='table_user' class="mt-5" style="width: 50%;">
                        <thead>
                            <tr class="text-center">
                                <th style="width: 15%;">#</th>
                                <th style="width: 45%;">ឈ្មោះពូជ</th>
                                <th style="width: 40%;">សកម្មភាព</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php



                            $sql = "SELECT * FROM breed_name_tb ORDER BY id DESC";
                            $result = $conn->query($sql);
                            $i = 1;
                            if ($result->num_rows > 0) {
                                while ($row1 = $result->fetch_assoc()) {
                                    echo '<tr class="text-center">';
                                    echo '<td>' . $i++ . '</td>';
                                    echo '<td>' . $row1['breed_name'] . '</td>'; // 
                                    echo "<th class='p-1' >         
                                <button type='button' class='btn btn-primary float-start px-4' onclick='openUpdateModal({$row1['id']}, \"{$row1['breed_name']}\")' data-id='{$row1['id']}'><i class='fa-solid fa-pen-to-square me-1'></i>កែ</button>
                                <form  style='width: 100%;'   action='delete_breed.php' method='post'>
                                    <input type='hidden' name='breed_id' value='{$row1['id']}'>
                                    <button class='btn btn-danger float-end px-4' type='submit' name='delete' // onclick='return confirm(\"Are you sure you want to delete this breed?\")'><i class='fa-solid fa-trash me-1'></i>លុប</button>
                                </form></div> </th>";
                                    echo '</tr>';
                                }
                            } else {
                                // echo "No data in the database.";
                            }

                            $conn->close();

                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- add breed -->
                <div class="modal" id="myModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h4 class="modal-title">Insert Breed Name</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <!-- Modal Body -->
                            <div class="modal-body">
                                <form id="insertForm" action="insert_data.php" method="POST">
                                    <div class="form-group">
                                        <label for="name">breed name:</label>
                                        <input type="text" class="form-control" id="name" name="breed_name" required>

                                    </div>
                                    <!-- Your additional form fields for inserting data -->
                                    <button type="button" class="btn btn-success" onclick="insertData()"><i class="fa-solid fa-check me-1"></i>SAVE</button>
                                    <!-- <input type="button" class="btn btn-success" onclick="insertData()" value="Insert" required>  -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Updated Modal for Update -->
                <div class="modal" id="updateModal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Update Breed Name</h4>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <form id="updateForm">
                                    <div class="form-group">
                                        <label for="updatedName">Update breed name:</label>
                                        <input type="text" class="form-control" id="updatedName" name="updated_breed_name" required>

                                    </div>
                                    <input type="hidden" id="update_id" name="update_id" value="">
                                    <button type="button" class="btn btn-success" onclick="updateData()">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="menu2" class="container tab-pane fade"><br>
                <h3>Menu 2</h3>
                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium,
                    totam rem aperiam.</p>
            </div>
        </div>
    </div>
    <?php
    include "include/footer.php";
    ?>
    <script>
        function exportToExcel() {
            // Create a new HTML table with only the relevant columns
            var exportTable = document.createElement('table');
            var exportTableBody = document.createElement('tbody');

            // Add table headers
            var headerRow = document.createElement('tr');
            headerRow.innerHTML = '<th>Breed 1</th>' +
                '<th>Breed 2</th>' +
                '<th>Male Flowering Age</th>' +
                '<th>Flowering Age</th>' +
                '<th>Version</th>' +
                '<th>Flowering Age Gap</th>' +
                '<th>Number of Stalks</th>' +
                '<th>Number of Chrysanthemums</th>' +
                '<th>Fruit Height</th>' +
                '<th>Male Stalk Length</th>' +
                '<th>Stem Height</th>' +
                '<th>Fruit Length and Skin</th>' +
                '<th>Leaf Angle</th>' +
                '<th>The Tail on the End of the Fruit</th>' +
                '<th>Fruit Length</th>' +
                '<th>Fertility</th>' +
                '<th>Fruit Appearance</th>' +
                '<th>Original Size</th>' +
                '<th>Stem Length</th>' +
                '<th>Root System</th>';
            exportTableBody.appendChild(headerRow);

            // Add table row with form data
            var dataRow = document.createElement('tr');
            dataRow.innerHTML = '<td>' + '<?php echo $breed1; ?>' + '</td>' +
                '<td>' + '<?php echo $breed2; ?>' + '</td>' +
                '<td>' + '<?php echo $Male_flowering_age; ?>' + '</td>' +
                '<td>' + '<?php echo $Flowering_age; ?>' + '</td>' +
                '<td>' + '<?php echo $version; ?>' + '</td>' +
                '<td>' + '<?php echo $Flowering_age_gap; ?>' + '</td>' +
                '<td>' + '<?php echo $number_of_stalks; ?>' + '</td>' +
                '<td>' + '<?php echo $Number_of_chrysanthemums; ?>' + '</td>' +
                '<td>' + '<?php echo $fruit_height; ?>' + '</td>' +
                '<td>' + '<?php echo $Male_stalk_length; ?>' + '</td>' +
                '<td>' + '<?php echo $Stem_height; ?>' + '</td>' +
                '<td>' + '<?php echo $Fruit_length_and_skin; ?>' + '</td>' +
                '<td>' + '<?php echo $Leaf_angle; ?>' + '</td>' +
                '<td>' + '<?php echo $The_tail_on_the_end_of_the_fruit; ?>' + '</td>' +
                '<td>' + '<?php echo $Fruit_length; ?>' + '</td>' +
                '<td>' + '<?php echo $Fertility; ?>' + '</td>' +
                '<td>' + '<?php echo $Fruit_appearance; ?>' + '</td>' +
                '<td>' + '<?php echo $Original_size; ?>' + '</td>' +
                '<td>' + '<?php echo $Stem_length; ?>' + '</td>' +
                '<td>' + '<?php echo $Root_system; ?>' + '</td>';
            exportTableBody.appendChild(dataRow);

            exportTable.appendChild(exportTableBody);

            // Create a Blob object containing the HTML table
            var blob = new Blob(['\ufeff', exportTable.outerHTML], {
                type: 'application/vnd.ms-excel'
            });

            // Create a link element to download the Blob
            var url = URL.createObjectURL(blob);
            var a = document.createElement("a");
            a.href = url;
            a.download = "data.xlsx";
            document.body.appendChild(a);
            a.click();

            // Cleanup
            setTimeout(function() {
                document.body.removeChild(a);
                window.URL.revokeObjectURL(url);
            }, 0);
        }
    </script>
    <script src="script/add_breed.js"></script>
    <script src="script/update_breed.js"></script>
    <script src="script/get_breed.js"></script>
    <script src="script/update_row.js"></script>
    <script src="script/filter.js"></script>
    <script>
        function updateNumberedButtons(totalPages, currentPage) {
            var buttonsContainer = $(".pagination");

            buttonsContainer.empty(); // Clear existing buttons

            buttonsContainer.append(
                `<li class="page-item ${currentPage === 1 ? "disabled" : ""}">
                <a class="page-link" href="#" aria-label="Previous" onclick="goToPage(${currentPage - 1})">
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
                `<li class="page-item ${currentPage === totalPages ? "disabled" : ""}">
                <a class="page-link" href="#" aria-label="Next" onclick="goToPage(${currentPage + 1})">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>`
            );
        }

        function goToPage(page) {

            // Perform the navigation or update content based on the target page
            console.log("Go to page", targetPage);
            // For now, you can use window.location.href to navigate to the URL with the selected page parameter
            // window.location.href = `your_page.php?page=${targetPage}`;

            // Update the current page and pagination buttons

        }
    </script>
    <script>
        function setDeleteParams(id, page) {
            // Set the id and page parameters in hidden form fields
            document.getElementById('deleteId').value = id;
            document.getElementById('deletePage').value = page;
        }
    </script>



</body>

</html>