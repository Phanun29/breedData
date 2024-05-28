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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>compare</title>
    <?php include "include/head.php"; ?>


</head>

<body>
    <!-- header  -->
    <?php include_once "include/header.php" ?>
    <!-- navigation -->
    <?php include "include/navigation.php"; ?>
    <br>
    <div class="wrappage ">
        <h2 class="container fload-start ">

        </h2>
        <div class="container pt-3">
            <!-- First filter form -->
            <form id="filterForm1" class="mb-3 float-start" style="width: 50%;">
                <div class="float-start">
                    <div class="float-start mx-2 d-flex justify-content-between" style="font-family: 'Poppins', 'Khmer OS battambang', sans-serif; font-weight: 500;">
                        <div class="float-start mx-2">
                            <select class="form-control" name="filterBreed1A" id="filterBreed1A" required>
                                <?php
                                $sql = "SELECT breed_name FROM breed_name_tb";
                                $result1 = $conn->query($sql);
                                if ($result1 && $result1->num_rows > 0) {
                                    echo '<option value="">ជ្រើសរើស</option>'; // Default option
                                    while ($row1 = $result1->fetch_assoc()) {
                                        echo '<option value="' . $row1['breed_name'] . '">' . $row1['breed_name'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No options available</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="float-end mx-2">
                            <select class="form-control" name="filterBreed1B" id="filterBreed1B" required>
                                <option value="">ជ្រើសរើស</option>
                                <?php
                                $result1->data_seek(0);
                                while ($row1 = $result1->fetch_assoc()) {
                                    echo '<option value="' . $row1['breed_name'] . '">' . $row1['breed_name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mx-2">
                            <input style="width: 100px;" type="number" min="1" name="version1" id="version1" class="form-control" placeholder="ជំនាន់" required>
                        </div>
                        <div class="float-end">
                            <button type="button" id="applyFiltersBtn1" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass me-1"></i>ស្វែងរក</button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Second filter form -->
            <form id="filterForm2" class="mb-3 float-end" style="width: 50%;">
                <div class="float-end">
                    <div class="float-start mx-2 d-flex justify-content-between" style="font-family: 'Poppins', 'Khmer OS battambang', sans-serif; font-weight: 500;">
                        <div class="float-start mx-2">
                            <select class="form-control" name="filterBreed2A" id="filterBreed2A" required>
                                <?php
                                $result1->data_seek(0);
                                if ($result1 && $result1->num_rows > 0) {
                                    echo '<option value="">ជ្រើសរើស</option>';
                                    while ($row1 = $result1->fetch_assoc()) {
                                        echo '<option value="' . $row1['breed_name'] . '">' . $row1['breed_name'] . '</option>';
                                    }
                                } else {
                                    echo '<option value="">No options available</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="float-end mx-2">
                            <select class="form-control" name="filterBreed2B" id="filterBreed2B" required>
                                <option value="">ជ្រើសរើស</option>
                                <?php
                                $result1->data_seek(0);
                                while ($row1 = $result1->fetch_assoc()) {
                                    echo '<option value="' . $row1['breed_name'] . '">' . $row1['breed_name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mx-2">
                            <input style="width: 100px;" type="number" min="1" name="version2" id="version2" class="form-control" placeholder="ជំនាន់" required>
                        </div>
                        <div class="float-end">
                            <button type="button" id="applyFiltersBtn2" class="btn btn-primary"><i class="fa-solid fa-magnifying-glass me-1"></i>ស្វែងរក</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div id="list_user" class="container" style="overflow: auto;">
            <table id='part1Table' class="float-start" style="width: 48%;">
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
                        <!-- <th style="width: 17%;">សកម្មភាព</th> -->
                    </tr>
                </thead>
                <tbody id="tbody1">
                    <?php

                    // Query to retrieve data for the current page
                    $sql = "SELECT * FROM data ORDER BY id DESC  ";
                    $result = $conn->query($sql);
                    $i = 1;;
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

                    ?>


                    <?php
                            echo "</td>";
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="8" class="text-center">No matching records found.</td></tr>';
                    }

                    ?>
                </tbody>
            </table>
            <table id='part2Table' class="float-end" style="width: 48%;">
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

                    </tr>
                </thead>
                <tbody id="tbody2">
                    <?php

                    $sql = "SELECT * FROM data ORDER BY id DESC ";
                    $result = $conn->query($sql);
                    $i = 1;;
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

                    ?>


                    <?php
                            // echo "</td>";
                            echo '</tr>';
                        }
                    } else {
                        echo '<tr><td colspan="8" class="text-center">No matching records found.</td></tr>';
                    }

                    ?>
                </tbody>
            </table>
            <?php
            //  include "include/pagination.php";
            ?>
        </div>
        <div>



        </div>
        <div>
            <canvas id="fruitHeightChart" width="400" height="200"></canvas>
            <canvas id="stemHeightChart" width="400" height="200"></canvas>
            <canvas id="maleFloweringDayChart" width="400" height="200"></canvas>
            <canvas id="flowerDayChart" width="400" height="200"></canvas>
        </div>
    </div>
    <?php
    include "include/footer.php";
    ?>

    <script src="script/get_breed.js"></script>

    <script>
        $(document).ready(function() {
            $("#applyFiltersBtn1").click(function() {
                var numberOfRows = $("#rowsPerPage").val();
                var filterBreed1A = $("#filterBreed1A").val();
                var filterBreed1B = $("#filterBreed1B").val();
                var version1 = $("#version1").val();

                if (filterBreed1A !== '' || filterBreed1B !== '' || version1 !== '') {
                    $.ajax({
                        type: "POST",
                        url: "retrieveData2.php",
                        data: {
                            numberOfRows: numberOfRows,
                            filterBreedA: filterBreed1A,
                            filterBreedB: filterBreed1B,
                            version: version1
                        },
                        success: function(response) {
                            $("#list_user #tbody1").html(response); // Update tbody content
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error:", status, error);
                        }
                    });
                } else {
                    // Optionally, display a message to the user
                    // alert("Please enter a value in at least one filter field.");
                }
            });

            $("#applyFiltersBtn2").click(function() {
                var numberOfRows = $("#rowsPerPage").val();
                var filterBreed2A = $("#filterBreed2A").val();
                var filterBreed2B = $("#filterBreed2B").val();
                var version2 = $("#version2").val();

                if (filterBreed2A !== '' || filterBreed2B !== '' || version2 !== '') {
                    $.ajax({
                        type: "POST",
                        url: "retrieveData2.php",
                        data: {
                            numberOfRows: numberOfRows,
                            filterBreedA: filterBreed2A,
                            filterBreedB: filterBreed2B,
                            version: version2
                        },
                        success: function(response) {
                            $("#list_user #tbody2").html(response); // Update tbody content
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error:", status, error);
                        }
                    });
                } else {
                    // Optionally, display a message to the user
                    // alert("Please enter a value in at least one filter field.");
                }
            });


        });
    </script>
    <script>
        // Function to initialize a single chart
        function initializeChart(canvasId, label) {
            var ctx = document.getElementById(canvasId).getContext('2d');
            return new Chart(ctx, {
                type: 'line',
                data: {
                    labels: [], // Labels for X-axis
                    datasets: [{
                        label: label,
                        data: [], // Actual data for Y-axis
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        // Function to update a single chart with new data
        function updateChart(chart, labels, data) {
            chart.data.labels = labels;
            chart.data.datasets[0].data = data;
            chart.update();
        }

        // Initialize charts
        var chart1 = initializeChart('fruitHeightChart', 'Fruit Height');
        var chart2 = initializeChart('stemHeightChart', 'Stem Height');
        var chart3 = initializeChart('maleFloweringDayChart', 'Male Flowering Day');
        var chart4 = initializeChart('flowerDayChart', 'Flower Day');

        // Function to fetch data and update charts
        function fetchDataAndRenderCharts() {
            // AJAX call to retrieve data from PHP script
            $.ajax({
                type: "POST",
                url: "retrieveData2.php",
                data: {
                    /* Your filter parameters */
                },
                success: function(response) {
                    var data = JSON.parse(response);

                    // Update the HTML table with retrieved data
                    updateTable(data.data);

                    // Update the average values on the page
                    updateAverages(data.averages);

                    // Update the charts with retrieved data
                    updateCharts(data.data);
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", status, error);
                }
            });

            function updateTable(data) {
                // Update your table with the retrieved data
            }

            function updateAverages(averages) {
                // Update your HTML elements with the average values
            }

            function updateCharts(data) {
                // Update your charts with the retrieved data
            }


        }

        // Fetch data and render charts initially
        fetchDataAndRenderCharts();

        // Optionally, you may want to call fetchDataAndRenderCharts() again when filters are applied
    </script>
</body>

</html>