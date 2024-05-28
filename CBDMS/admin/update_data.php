<?php
session_start();
// print_r($_SESSION);
if (!isset($_SESSION['username']) && !isset($_SESSION['user_id'])) {
    header('location: ../index.php');
    exit(0);
}
?>

<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $dataId = $_GET['id'];
    // Rest of your code here
} else {
    die("Invalid data ID");
}

// Assuming you pass the user ID through the URL parameter
include_once "database/db.php";



$stmt = $conn->prepare("SELECT * FROM data WHERE id = ?");
$stmt->bind_param("i", $dataId);
$stmt->execute();
$result = $stmt->get_result();
include "include/foradmin.php";
if ($result->num_rows > 0) {
    $row3 = $result->fetch_assoc();
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>

        <title>Update Data</title>

        <?php include "include/head.php"; ?>
    </head>


    <body>
        <!-- database -->
        <?php include_once "database/db.php" ?>
        <!-- header  -->
        <?php include_once "include/header.php" ?>
        <!-- navigation -->
        <?php include "include/navigation.php"; ?>
        <br>
        <div class="wrappage">
            <div id="add_data">
                <h1 class="float-start">កែទិន្នន័យ</h1>
                <form action="update_data_form.php" method="POST" enctype="multipart/form-data">

                    <table>
                        <tr>
                            <input type="hidden" name="data_id" value="<?php echo $dataId; ?>">
                            <td style="width: 20%;">ពូជទី១</td>
                            <!-- breed1 dropdown -->
                            <td style="width: 30%;">
                                <select style="width: 80%;" class="form-control" name="breed1" id="" required>
                                    <?php
                                    // Perform SELECT query
                                    $sql = "SELECT breed_name FROM breed_name_tb";
                                    $result = $conn->query($sql);

                                    // Check if the query was successful
                                    if ($result) {
                                        // Fetch data and display options for the first dropdown
                                        while ($row = $result->fetch_assoc()) {
                                            // Set the selected option based on the value stored in the database
                                            $selected = ($row['breed_name'] == $row3['breed1']) ? 'selected' : '';
                                            echo '<option value="' . $row['breed_name'] . '" ' . $selected . '>' . $row['breed_name'] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </td>
                            <td style="width: 20%;">អាយុចេញផ្កាឈ្មោល</td>
                            <td style="width: 30%;"><input style="width: 80%;" class="form-control" type="text" name="Male_flowering_age" value="<?php echo $row3['Male_flowering_age']; ?>"></td>
                        </tr>
                        <tr>
                        <tr>
                            <td>ពូជទី២</td>
                            <td style="width: 30%;">
                                <select style="width: 80%;" class="form-control" name="breed2" id="" required>
                                    <?php
                                    // Reset the result set pointer to the beginning
                                    $result->data_seek(0);

                                    // Fetch data and display options for the second dropdown
                                    while ($row = $result->fetch_assoc()) {
                                        // Set the selected option based on the value stored in the database
                                        $selected = ($row['breed_name'] == $row3['breed2']) ? 'selected' : '';
                                        echo '<option value="' . $row['breed_name'] . '" ' . $selected . '>' . $row['breed_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>អាយុចេញផ្កាញី</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="Flowering_age" value="<?php echo $row3['Flowering_age']; ?>"></td>
                        </tr>
                        <tr>
                            <td>ជំនាន់</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="version" value="<?php echo $row3['version']; ?>"></td>
                            <td>គម្លាតអាយុចេញផ្កា</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="Flowering_age_gap" value="<?php echo $row3['Flowering_age_gap']; ?>"></td>
                        </tr>
                        <!-- do or not -->
                        <tr>

                            <td>លេខសម្គាល់</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="code" value="<?php echo $row3['code'];
                                                                                                                ?>"></td>
                            <td>ពណ៌គ្រាប់</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="grain_color" value="<?php echo $row3['grain_color']; ?>"></td>
                        </tr>

                        <tr>
                            <td>កម្ពស់ផ្លែ</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="fruit_height" value="<?php echo $row3['Fruit_height']; ?>"></td>
                            <td>ប្រវែងទងផ្កាឈ្មោល</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="Male_stalk_length" value="<?php echo $row3['Male_stalk_length']; ?>"></td>
                        </tr>
                        <tr>
                            <td>កម្ពស់ដើម</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="Stem_height" value="<?php echo $row3['Stem_height']; ?>"></td>
                            <td>ប្រវែងផ្លែទាំងសំបក</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="Fruit_length_and_skin" value="<?php echo $row3['Fruit_length_and_skin']; ?>"></td>
                        </tr>
                        <tr>
                            <td>ថ្ងៃចេញផ្កាឈ្មោល ៥០%</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="Male_flowering_day" value="<?php echo $row3['Male_flowering_day']; ?>"></td>
                            <td>ថ្ងៃចេញផ្កាញី​​ ៥០%</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="Flower_Day" value="<?php echo $row3['Flower_Day']; ?>"></td>
                        </tr>
                        <tr>
                            <td>ចំនួនទងផ្កា</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="number_of_stalks" value="<?php echo $row3['Number_of_stalks']; ?>"></td>
                            <td>ចំនួនផ្កាឈ្លោល</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="Number_of_chrysanthemums" value="<?php echo $row3['Number_of_chrysanthemums']; ?>"></td>
                        </tr>
                        <tr>
                            <td>មុំស្លឹក</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="Leaf_angle" value="<?php echo $row3['Leaf_angle']; ?>"></td>
                            <td>ភាពមានកន្ទុយលើចុងផ្លែ</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="The_tail_on_the_end_of_the_fruit" value="<?php echo $row3['The_tail_on_the_end_of_the_fruit']; ?>"></td>
                        </tr>
                        <tr>
                            <td>ប្រវែងផ្លែ</td>
                            <td><input style="width: 80%;" style="width: 80%;" class="form-control" type="text" name="Fruit_length" value="<?php echo $row3['Fruit_length']; ?>"></td>
                            <td>ភាពជាប់ផ្លែ</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="Fertility" value="<?php echo $row3['Fertility']; ?>"></td>
                        </tr>
                        <tr>
                            <td>រូបរាងផ្លែ</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="Fruit_appearance" value="<?php echo $row3['Fruit_appearance']; ?>"></td>
                            <td>ទំហំដើម</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="Original_size" value="<?php echo $row3['Original_size']; ?>"></td>
                        </tr>
                        <tr>
                            <td>ប្រវែងគល់ផ្លែ</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="Stem_length" value="<?php echo $row3['Stem_length']; ?>"></td>
                            <td>ប្រព័ន្ធឫស</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="Root_system" value="<?php echo $row3['Root_system']; ?>"></td>
                        </tr>
                        <tr>
                            <td>អត្រាដំណុះ</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="Germination_rate" value="<?php echo $row3['Germination_rate']; ?>"></td>
                            <td>កម្រិតកើត Albino</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="Birth_rate_albino" value="<?php echo $row3['Birth_rate_albino']; ?>"></td>
                        </tr>
                        <tr>
                            <td>កម្រិតបំផ្លាញរបស់ដង្កូវ</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="worm_damage_level" value="<?php echo $row3['worm_damage_level']; ?>"></td>
                            <td>ភាពរឹងមាំ</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="Strength" value="<?php echo $row3['Strength']; ?>"></td>
                        </tr>
                        <tr>
                            <td>គម្លាតអាយុផ្កាញីនិងឈ្មោល</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="age_gap_between_male_and_female_flowers" value="<?php echo $row3['age_gap_between_male_and_female_flowers']; ?>"></td>
                            <td>កើតជំងឺ</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="get_sick" value="<?php echo $row3['get_sick']; ?>"></td>
                        </tr>
                        <tr>
                            <td>កម្រិតការកើតជំងឺ</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="disease_level" value="<?php echo $row3['disease_level']; ?>"></td>
                            <td>ចំនួនដើមរលំ</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="number_of_collapsed_trees" value="<?php echo $row3['number_of_collapsed_trees']; ?>"></td>
                        </tr>
                        <tr>
                            <td>អង្កត់ផ្ចិតផ្លែបកសំបក</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="peeled_fruit_diameter" value="<?php echo $row3['peeled_fruit_diameter']; ?>"></td>
                            <td>ប្រវែងផ្លែបបកសំបក</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="peel_number" value="<?php echo $row3['peel_number']; ?>"></td>
                        </tr>
                        <tr>
                            <td>ចំនួនជួរគ្រាប់ក្នុងមួយផ្លែ</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="number_of_rows_of_seeds_per_fruit" value="<?php echo $row3['number_of_rows_of_seeds_per_fruit']; ?>"></td>
                            <td>ចំនួនគ្រាប់ក្នុងមួយជួរ</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="number_of_bullets_per_rows" value="<?php echo $row3['number_of_bullets_per_rows']; ?>"></td>
                        </tr>

                        <tr>
                            <td>សំបកផ្លែ</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="fruit_peel" value="<?php echo $row3['fruit_peel']; ?>"></td>
                            <td>ទម្ងន់</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="weight" value="<?php echo $row3['weight']; ?>"></td>
                        </tr>
                        <tr>
                            <td>ដង្កូវ</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="worm" value="<?php echo $row3['worm']; ?>"></td>
                            <td>Seeding Vigor</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="seeding_vigor" value="<?php echo $row3['seeding_vigor']; ?>"></td>
                        </tr>
                        <tr>
                            <td>ភាពរឹងមាំរបស់កូន</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="your_child_strength" value="<?php echo $row3['your_child_strength']; ?>"></td>
                            <td>ការរៀងជួររបស់គ្រាប់</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="seed_range_shape" value="<?php echo $row3['seed_range_shape'];
                                                                                                                            ?>"></td>
                        </tr>
                        <tr>
                            <td>ចំនួនឫស</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="Number_of_roots" value="<?php echo $row3['Number_of_roots']; ?>"></td>
                            <td>ប្រវែងចុងស្នៀត(cm)</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="Tip_length" value="<?php echo $row3['Tip_length']; ?>"></td>
                        </tr>

                        <!-- <tr>

                            <td>ពណ៌គ្រាប់</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="grain_color" value="<?php echo $row3['grain_color']; ?>"></td>
                            <td>សរុប</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="sum" value="<?php echo $row3['sum']; ?>"></td>
                        </tr> -->
                        <tr>
                            <!-- <td>ពណ៌គ្រាប់</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="grain_color"></td> -->
                            <td>សរុប</td>
                            <td><input style="width: 80%;" class="form-control" type="text" name="sum" value="<?php echo $row3['sum']; ?>"></td>
                        </tr>
                        <tr>
                            <td>រូបភាព</td>
                            <td colspan="">
                                <input style="width: 80%;" class="form-control" type="file" name="images[]" id="images" multiple accept="image/*" onchange="previewImages(event)">

                            </td>
                            <td></td>
                        </tr>
                    </table>
                    <div id="imagePreview" class="mt-2"></div>
                    <div id="image_edit">
                        <?php
                        $images = $row3['images'];
                        $images = trim($images, ','); // Remove leading and trailing commas
                        $images = explode(',', $images);

                        if (!empty($images)) {
                            foreach ($images as $index => $image) {
                                if (!empty($image)) { // Check if image path is not empty
                                    echo "<div class='mySlides'>
                                        <div id='slide_image'>
                                            <img src='$image' alt=''>
                                        </div>
                                        <div class='d-flex justify-content-center py-2'>
                                            <button class='btn btn-danger remove-image' data-image-id='$index' data-data-id='$dataId'>Remove</button>
                                        </div>
                                    </div>";
                                }
                            }
                        } else {
                            // Handle case where no images are available
                        }

                        ?>
                    </div>


                    <!-- Add new images -->
                    <input type="hidden" name="data_id" value="<?php echo $dataId; ?>">
                    <button style="margin-bottom: 20px;" class="btn btn-success" type="submit" name="update"><i class="fa-solid fa-check me-1"></i>រក្សាទុក</button>
                <?php
            } else {
                die("No data found for ID: $dataId");
            }
            $conn->close();
                ?>
            </div>
        </div>
        <?php
        include "include/footer.php";
        ?>
        <script src="script/dropdpwn.js"></script>
        <script>
            $(document).ready(function() {
                // Function to handle image removal
                $('.remove-image').click(function(event) {
                    event.preventDefault(); // Prevent default behavior of the link/button
                    var imageId = $(this).data('image-id');
                    var dataId = $(this).data('data-id');
                    var confirmation = confirm("Are you sure you want to delete this image?");
                    if (confirmation) {
                        $.ajax({
                            url: 'delete_image.php',
                            method: 'POST',
                            data: {
                                image_id: imageId,
                                data_id: dataId
                            },
                            success: function(response) {
                                try {
                                    var jsonResponse = JSON.parse(response);
                                    if (jsonResponse.success) {
                                        // Remove the image element from the DOM if deletion is successful
                                        $('#image_edit').find('.mySlides').eq(imageId).remove();
                                    } else {
                                        alert("Failed to delete image: " + jsonResponse.message);
                                    }
                                } catch (error) {
                                    console.error("Error parsing JSON response:", error);
                                    alert("An error occurred while processing the response.");
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error("AJAX request error:", status, error);
                                alert("Error occurred while deleting image.");
                            }
                        });
                    }
                });
            });
        </script>
        <script>
            function previewImages(event) {
                var previewContainer = document.getElementById('imagePreview');
                previewContainer.innerHTML = ''; // Clear previous previews

                var files = event.target.files;
                var selectedFiles = Array.from(files); // Convert FileList to array

                for (var i = 0; i < files.length; i++) {
                    var file = files[i];

                    var reader = new FileReader();

                    reader.onload = function(e) {
                        var imageContainer = document.createElement('div');
                        imageContainer.className = 'preview-image-container ';

                        var image = document.createElement('img');
                        image.className = 'preview-image ';
                        image.src = e.target.result;
                        imageContainer.appendChild(image);

                        // Create a div for the button
                        var buttonDiv = document.createElement('div');
                        buttonDiv.className = 'button-container d-flex justify-content-center mt-5'; // You can style this container as needed
                        imageContainer.appendChild(buttonDiv);

                        var removeButton = document.createElement('button');
                        removeButton.className = 'btn btn-danger remove-image-button';
                        removeButton.textContent = 'Remove';
                        removeButton.addEventListener('click', function() {
                            // Remove the image container when the button is clicked
                            imageContainer.remove();
                            // Remove the corresponding file from the selectedFiles array
                            var index = selectedFiles.indexOf(file);
                            selectedFiles.splice(index, 1);
                            // Update the file input element with the updated selected files
                            var newFileList = new DataTransfer();
                            selectedFiles.forEach(function(file) {
                                newFileList.items.add(file);
                            });
                            document.getElementById('images').files = newFileList.files;
                        });
                        buttonDiv.appendChild(removeButton);

                        previewContainer.appendChild(imageContainer);
                    };
                    reader.readAsDataURL(file);
                }
            }
        </script>

    </body>

    </html>