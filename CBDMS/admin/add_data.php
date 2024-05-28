<?php
session_start();
// print_r($_SESSION);
if (!isset($_SESSION['username']) && !isset($_SESSION['user_id'])) {
    header('location: ../index.php');
    exit(0);
}


include_once "database/db.php";
include "include/foradmin.php";



if (isset($_POST['submit'])) {
    $breed1 = $_POST['breed1'];
    $breed2 = $_POST['breed2'];
    $Male_flowering_age = $_POST['Male_flowering_age'];
    $breed2e = $_POST['breed2'];
    $Flowering_age = $_POST['Flowering_age'];
    $version = $_POST['version'];
    $Flowering_age_gap = $_POST['Flowering_age_gap'];
    $number_of_stalks = $_POST['number_of_stalks'];
    $Number_of_chrysanthemums = $_POST['Number_of_chrysanthemums'];
    $fruit_height = $_POST['fruit_height'];
    $Male_stalk_length = $_POST['Male_stalk_length'];
    $Stem_height = $_POST['Stem_height'];
    $Fruit_length_and_skin = $_POST['Fruit_length_and_skin'];
    $Leaf_angle = $_POST['Leaf_angle'];
    $The_tail_on_the_end_of_the_fruit = $_POST['The_tail_on_the_end_of_the_fruit'];
    $Fruit_length = $_POST['Fruit_length'];
    $Fertility = $_POST['Fertility'];
    $Fruit_appearance = $_POST['Fruit_appearance'];
    $Original_size = $_POST['Original_size'];
    $Stem_length = $_POST['Stem_length'];
    $Root_system = $_POST['Root_system'];

    $Germination_rate = $_POST['Germination_rate'];
    $Birth_rate_albino = $_POST['Birth_rate_albino'];
    $worm_damage_level = $_POST['worm_damage_level'];
    $Strength = $_POST['Strength'];
    $age_gap_between_male_and_female_flowers = $_POST['age_gap_between_male_and_female_flowers'];
    $get_sick = $_POST['get_sick'];
    $disease_level = $_POST['disease_level'];
    $number_of_collapsed_trees = $_POST['number_of_collapsed_trees'];
    $peeled_fruit_diameter = $_POST['peeled_fruit_diameter'];
    $peel_number = $_POST['peel_number'];
    $number_of_rows_of_seeds_per_fruit = $_POST['number_of_rows_of_seeds_per_fruit'];
    $number_of_bullets_per_rows = $_POST['number_of_bullets_per_rows'];
    $seed_range_shape = $_POST['seed_range_shape'];
    $sum = $_POST['sum'];
    $grain_color = $_POST['grain_color'];
    $fruit_peel = $_POST['fruit_peel'];
    $weight = $_POST['weight'];
    $worm = $_POST['worm'];
    $seeding_vigor = $_POST['seeding_vigor'];
    $your_child_strength = $_POST['your_child_strength'];

    $Number_of_roots = $_POST['Number_of_roots'];
    $Tip_length = $_POST['Tip_length'];
    $Male_flowering_day = $_POST['Male_flowering_day'];
    $Flower_Day = $_POST['Flower_Day'];
    $code = $_POST['code'];

    $uploadDir = 'uploads/';
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }
    $uploadedFiles = [];
    $allowedTypes = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF]; // Define allowed image types
    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        if ($_FILES['images']['error'][$key] !== UPLOAD_ERR_OK) {
            // echo "Error uploading file: " . $_FILES['images']['error'][$key];
            continue; // Skip to the next iteration if there's an error
        }

        // Process the file normally
        $file_name = $_FILES['images']['name'][$key];
        $file_tmp = $_FILES['images']['tmp_name'][$key];
        $uploadPath = $uploadDir . $file_name;

        // Move the uploaded file to the destination directory
        if (move_uploaded_file($file_tmp, $uploadPath)) {
            $uploadedFiles[] = $uploadPath;

            // Check the image type after successful upload
            $imageType = exif_imagetype($uploadPath);
            if (!in_array($imageType, $allowedTypes)) {
                // Remove the invalid file if it doesn't match the allowed image types
                unlink($uploadPath);
                echo "Invalid image type for file: " . $_FILES['images']['name'][$key];
                continue; // Skip to the next iteration
            }
        } else {
            echo "Error uploading file: " . $_FILES['images']['error'][$key];
        }
    }



    $imagePaths = implode(',', $uploadedFiles);

    // Prepare and execute SQL query to insert data into the database
    $sql = "INSERT INTO data (breed1, breed2, version, Number_of_stalks, Fruit_height,	Stem_height,Leaf_angle,Fruit_length,Fruit_appearance,Stem_length,Male_flowering_age
    ,Flowering_age,Flowering_age_gap,Number_of_chrysanthemums,Male_stalk_length,Fruit_length_and_skin,The_tail_on_the_end_of_the_fruit,Fertility,Original_size,Root_system,images,Germination_rate,Birth_rate_albino,worm_damage_level,
    Strength,age_gap_between_male_and_female_flowers,get_sick,disease_level,number_of_collapsed_trees,peeled_fruit_diameter,peel_number,number_of_rows_of_seeds_per_fruit,number_of_bullets_per_rows,seed_range_shape,sum
    ,grain_color,fruit_peel,weight,worm,seeding_vigor,your_child_strength,Number_of_roots,Tip_length,Male_flowering_day,Flower_Day,code) 
    VALUES ('$breed1', '$breed2', '$version', '$number_of_stalks', '$fruit_height','$Stem_height ','$Leaf_angle', '$Fruit_length' , '$Fruit_appearance','$Stem_length'
    ,'$Male_flowering_age','$Flowering_age','$Flowering_age_gap','$Number_of_chrysanthemums', '$Male_stalk_length','$Fruit_length_and_skin',  '$The_tail_on_the_end_of_the_fruit'
    ,'$Fertility','$Original_size','$Root_system','$imagePaths','$Germination_rate' ,'$Birth_rate_albino','$worm_damage_level','$Strength','$age_gap_between_male_and_female_flowers'
    ,'$get_sick','$disease_level','$number_of_collapsed_trees','$peeled_fruit_diameter','$peel_number','$number_of_rows_of_seeds_per_fruit','$number_of_bullets_per_rows','$seed_range_shape','$sum'
    ,'$grain_color','$fruit_peel','$weight','$worm','$seeding_vigor','$your_child_strength','$Number_of_roots','$Tip_length','$Male_flowering_day','$Flower_Day','$code')";


    if ($conn->query($sql) === TRUE) {
        // Successful insertion
        $_SESSION['success_message'] = "បន្ថែមទិន្នន័យបានជោគជ័យ.";
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit();
    } else {
        // Display the SQL error
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>add data</title>
    <?php include "include/head.php";
    ?>
</head>

<body>
    <!-- database -->
    <?php  ?>
    <!-- header  -->
    <?php include_once "include/header.php"; ?>
    <!-- navigation -->
    <?php include "include/navigation.php"; ?>

    <br>
    <div class="wrappage">
        <div id="add_data">
            <h1 class="float-start">បន្ថែមទិន្នន័យ</h1>
            <!-- <button type="button" class="btn btn-primary float-end mx-5" data-toggle="modal" data-target="#myModal">
                <i class="fa-solid fa-plus me-1"></i>បន្ថែមពូជ
            </button> -->
            <?php if (isset($_SESSION['success_message'])) : ?>
                <div style="width: 300px;" class="alert alert-success alert-dismissible fade show float-right p-2   d-flex justify-content-center align-items-center" role="alert">
                    <strong><?php echo $_SESSION['success_message']; ?></strong>
                    <button style="top: -5px;" type="button" class="btn-close p-3 w-1" aria-label="Close" onclick="closeAlert(this)"></button>

                </div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

            <input type="hidden" id="update_id" name="update_id" value="">
            <form action="" method="POST" enctype="multipart/form-data">
                <table>

                    <tr>
                        <td style="width: 20%;">ពូជទី១<span class="text-danger">*</span></td>
                        <td style="width: 30%;">

                            <select style="width: 80%;" class="form-control" name="breed1" id="" required>
                                <option value="">ជ្រើសរើស</option>
                                <?php
                                // Perform SELECT query
                                $sql = "SELECT breed_name FROM breed_name_tb";
                                $result = $conn->query($sql);

                                // Check if the query was successful
                                if ($result) {
                                    // Fetch data and display options for the first dropdown
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . $row['breed_name'] . '">' . $row['breed_name'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </td>
                        <td style="width: 20%;">អាយុចេញផ្កាឈ្មោល</td>
                        <td style="width: 30%;"><input style="width: 80%;" class="form-control" type="text" name="Male_flowering_age"></td>
                    </tr>
                    <tr>
                        <td>ពូជទី២<span class="text-danger">*</span></td>
                        <td style="width: 30%;">

                            <select style="width: 80%;" class="form-control" name="breed2" id="" required>
                                <option value="">ជ្រើសរើស</option>

                                <?php
                                // Reset the result set pointer to the beginning
                                $result->data_seek(0);

                                // Fetch data and display options for the second dropdown
                                while ($row = $result->fetch_assoc()) {

                                    echo '<option value="' . $row['breed_name'] . '">' . $row['breed_name'] . '</option>';
                                }

                                ?>
                            </select>
                        </td>
                        <td>អាយុចេញផ្កាញី</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="Flowering_age"></td>
                    </tr>
                    <tr>
                        <td>ជំនាន់<span class="text-danger">*</span></td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="version" required></td>
                        <td>គម្លាតអាយុចេញផ្កា</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="Flowering_age_gap"></td>
                    </tr>
                    <!-- do or not -->
                    <tr>

                        <td>លេខសម្គាល់</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="code"></td>
                        <td>ពណ៌គ្រាប់</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="grain_color"></td>
                    </tr>

                    <tr>
                        <td>កម្ពស់ផ្លែ</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="fruit_height"></td>
                        <td>ប្រវែងទងផ្កាឈ្មោល</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="Male_stalk_length"></td>
                    </tr>
                    <tr>
                        <td>កម្ពស់ដើម</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="Stem_height"></td>
                        <td>ប្រវែងផ្លែទាំងសំបក</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="Fruit_length_and_skin"></td>
                    </tr>
                    <tr>
                        <td>ថ្ងៃចេញផ្កាឈ្មោល ៥០%</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="Male_flowering_day"></td>
                        <td>ថ្ងៃចេញផ្កាញី​​ ៥០%</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="Flower_Day"></td>
                    </tr>
                    <tr>
                        <td>ចំនួនទងផ្កា</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="number_of_stalks"></td>
                        <td>ចំនួនផ្កាឈ្មោល</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="Number_of_chrysanthemums"></td>
                    </tr>
                    <tr>
                        <td>មុំស្លឹក</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="Leaf_angle"></td>
                        <td>ភាពមានកន្ទុយលើចុងផ្លែ</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="The_tail_on_the_end_of_the_fruit"></td>
                    </tr>
                    <tr>
                        <td>ប្រវែងផ្លែ</td>
                        <td><input style="width: 80%;" style="width: 80%;" class="form-control" type="text" name="Fruit_length"></td>
                        <td>ភាពជាប់ផ្លែ</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="Fertility"></td>
                    </tr>
                    <tr>
                        <td>រូបរាងផ្លែ</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="Fruit_appearance"></td>
                        <td>ទំហំដើម</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="Original_size"></td>
                    </tr>
                    <tr>
                        <td>ប្រវែងគល់ផ្លែ</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="Stem_length"></td>
                        <td>ប្រព័ន្ធឫស</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="Root_system"></td>
                    </tr>

                    <!-- new -->
                    <tr>
                        <td>អត្រាដំណុះ</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="Germination_rate"></td>
                        <td>កម្រិតកើត Albino</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="Birth_rate_albino"></td>
                    </tr>
                    <tr>
                        <td>កម្រិតបំផ្លាញរបស់ដង្កូវ</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="worm_damage_level"></td>
                        <td>ភាពរឹងមាំ</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="Strength"></td>
                    </tr>
                    <tr>
                        <td>គម្លាតអាយុផ្កាញីនិងឈ្មោល</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="age_gap_between_male_and_female_flowers"></td>
                        <td>កើតជំងឺ(Seuthern Rast)</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="get_sick"></td>
                    </tr>
                    <tr>
                        <td>កម្រិតការកើតជំងឺ</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="disease_level"></td>
                        <td>ចំនួនដើមរលំ</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="number_of_collapsed_trees"></td>
                    </tr>
                    <tr>
                        <td>អង្កត់ផ្ចិតផ្លែបកសំបក</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="peeled_fruit_diameter"></td>
                        <td>ប្រវែងផ្លែបបកសំបក</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="peel_number"></td>
                    </tr>
                    <tr>
                        <td>ចំនួនជួរគ្រាប់ក្នុងមួយផ្លែ</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="number_of_rows_of_seeds_per_fruit"></td>
                        <td>ចំនួនគ្រាប់ក្នុងមួយជួរ</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="number_of_bullets_per_rows"></td>
                    </tr>

                    <tr>
                        <td>សំបកផ្លែ</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="fruit_peel"></td>
                        <td>ទម្ងន់</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="weight"></td>
                    </tr>
                    <tr>
                        <td>ដង្កូវ</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="worm"></td>
                        <td>Seeding Vigor</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="seeding_vigor"></td>
                    </tr>
                    <tr>
                        <td>ភាពរឹងមាំរបស់កូន</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="your_child_strength"></td>
                        <td>ការរៀងជួររបស់គ្រាប់</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="seed_range_shape"></td>
                    </tr>
                    <tr>
                        <td>ចំនួនឫស</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="Number_of_roots"></td>
                        <td>ប្រវែងចុងស្នៀត(cm)</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="Tip_length"></td>
                    </tr>

                    <!-- <tr>
                        <td>ពណ៌គ្រាប់</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="grain_color"></td>
                        <td>សរុប</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="sum"></td>
                    </tr> -->
                    <tr>
                        <!-- <td>ពណ៌គ្រាប់</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="grain_color"></td> -->
                        <td>សរុប</td>
                        <td><input style="width: 80%;" class="form-control" type="text" name="sum"></td>
                    </tr>
                    <tr>
                        <td>រូបភាព<span class="text-danger"></span></td>
                        <td> <input style="width: 80%;" class="form-control" type="file" name="images[]" id="images" multiple accept="image/*" onchange="previewImages(event)">

                        </td>


                    </tr>

                </table>
                <div id="imagePreview"></div>
                <!-- <div id="image_edit">
                </div> -->


                <button class="btn btn-success" type="submit" name="submit"><i class="fa-solid fa-check me-1"></i>រក្សាទុក</button>
            </form>


        </div>
    </div>


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


    <?php
    include "include/footer.php";
    ?>

    <script src="script/add_breed.js"></script>
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
                    image.className = 'preview-image';
                    image.src = e.target.result;
                    imageContainer.appendChild(image);

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
                    imageContainer.appendChild(removeButton);

                    previewContainer.appendChild(imageContainer);
                };

                reader.readAsDataURL(file);
            }
        }

        function closeAlert(button) {
            button.parentElement.classList.remove('show');
            button.parentElement.classList.add('hide');
        }
    </script>



</body>

</html>