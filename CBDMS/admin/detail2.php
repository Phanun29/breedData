<?php
session_start();
// print_r($_SESSION);
if (!isset($_SESSION['username']) && !isset($_SESSION['user_id'])) {
    header('location: ../index.php');
    exit(0);
}
?>
<?php

include_once "database/db.php";
include "include/foradmin.php";
$dataId = $_GET['id'];
$sql = "SELECT * FROM data WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $dataId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    die("data not found");
}
$conn->close();


?>
<!DOCTYPE html>
<html lang="en">

<head>

    <title>details</title>
    <?php include "include/head.php";
    ?>

</head>
<style>
    .slideshow-container {
        max-width: 800px;
        position: relative;
        margin: auto;
        width: 500px;
        height: 600px;
    }

    .mySlides {
        display: none;
    }

    img {
        width: 100%;
    }

    .button-container {
        text-align: center;
        margin-top: 10px;

    }

    .prev,
    .next {
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
    }

    #tableDetails tr {
        height: 40px;
    }
</style>

<body>
    <!-- header  -->
    <?php include_once "include/header.php" ?>
    <!-- navigation -->
    <?php include "include/navigation.php"; ?>
    <br>
    <div class="wrappage ">
        <a id="btn_back" class="btn btn-primary mx-5 my-3 me-0 mb-0" href="index.php">ថយក្រោយ</a>
        <a class='btn btn-primary mx-5 my-3 ms-0 mb-0' href='update_data.php?id=<?php echo $row['id']; ?>'><i class="fa-solid fa-pen-to-square me-1"></i>កែ</a>

        <div id="table_data" class="container">
            <table class="container" id="tableDetails">
                <tr>
                    <td>ពូជទី១</td>
                    <input type="hidden" name="user_id" value="<?php echo $dataId; ?>">
                    <td><?php echo $row['breed1']; ?></td>
                    <td>អាយុចេញផ្កាឈ្មោល</td>
                    <td><?php echo $row['Male_flowering_age']; ?></td>
                </tr>
                <tr>
                    <td>ពូជទី២</td>
                    <td><?php echo $row['breed2']; ?></td>
                    <td>អាយុចេញផ្កាញី</td>
                    <td><?php echo $row['Flowering_age']; ?></td>
                </tr>
                <tr>
                    <td>ជំនាន់</td>
                    <td><?php echo $row['version']; ?></td>
                    <td>គម្លាតអាយុចេញផ្កា</td>
                    <td><?php echo $row['Flowering_age_gap']; ?></td>
                </tr>
                <tr>

                    <td>លេខសម្គាល់</td>
                    <td><?php echo $row['code'];
                        ?></td>
                    <td>ពណ៌គ្រាប់</td>
                    <td><?php echo $row['grain_color']; ?></td>
                </tr>

                <tr>
                    <td>កម្ពស់ផ្លែ</td>
                    <td><?php echo $row['Fruit_height']; ?></td>
                    <td>ប្រវែងទងផ្កាឈ្មោល</td>
                    <td><?php echo $row['Male_stalk_length']; ?></td>
                </tr>
                <tr>
                    <td>កម្ពស់ដើម</td>
                    <td><?php echo $row['Stem_height']; ?></td>
                    <td>ប្រវែងផ្លែទាំងសំបក</td>
                    <td><?php echo $row['Fruit_length_and_skin']; ?></td>
                </tr>
                <tr>
                    <td>ថ្ងៃចេញផ្កាឈ្មោល ៥០%</td>
                    <td><?php echo $row['Male_flowering_day']; ?></td>
                    <td>ថ្ងៃចេញផ្កាញី​​ ៥០%</td>
                    <td><?php echo $row['Flower_Day']; ?></td>
                </tr>
                <tr>
                    <td>ចំនួនទងផ្កា</td>
                    <td><?php echo $row['Number_of_stalks']; ?></td>
                    <td>ចំនួនផ្កាឈ្លោល</td>
                    <td><?php echo $row['Number_of_chrysanthemums']; ?></td>
                </tr>
                <tr>
                    <td>មុំស្លឹក</td>
                    <td><?php echo $row['Leaf_angle']; ?></td>
                    <td>ភាពមានកន្ទុយលើចុងផ្លែ</td>
                    <td><?php echo $row['The_tail_on_the_end_of_the_fruit']; ?></td>
                </tr>
                <tr>
                    <td>ប្រវែងផ្លែ</td>
                    <td><?php echo $row['Fruit_length']; ?></td>
                    <td>ភាពជាប់ផ្លែ</td>
                    <td><?php echo $row['Fertility']; ?></td>
                </tr>
                <tr>
                    <td>រូបរាងផ្លែ</td>
                    <td><?php echo $row['Fruit_appearance']; ?></td>
                    <td>ទំហំដើម</td>
                    <td><?php echo $row['Original_size']; ?></td>
                </tr>
                <tr>
                    <td>ប្រវែងគល់ផ្លែ</td>
                    <td><?php echo $row['Stem_length']; ?></td>
                    <td>ប្រព័ន្ធឫស</td>
                    <td><?php echo $row['Root_system']; ?></td>
                </tr>
                <tr>
                    <td>អត្រាដំណុះ</td>
                    <td><?php echo $row['Germination_rate']; ?></td>
                    <td>កម្រិតកើត Albino</td>
                    <td><?php echo $row['Birth_rate_albino']; ?></td>
                </tr>
                <tr>
                    <td>កម្រិតបំផ្លាញរបស់ដង្កូវ</td>
                    <td><?php echo $row['worm_damage_level']; ?></td>
                    <td>ភាពរឹងមាំ</td>
                    <td><?php echo $row['Strength']; ?></td>
                </tr>
                <tr>
                    <td>គម្លាតអាយុផ្កាញីនិងឈ្មោល</td>
                    <td><?php echo $row['age_gap_between_male_and_female_flowers']; ?></td>
                    <td>កើតជំងឺ</td>
                    <td><?php echo $row['get_sick']; ?></td>
                </tr>
                <tr>
                    <td>កម្រិតការកើតជំងឺ</td>
                    <td><?php echo $row['disease_level']; ?></td>
                    <td>ចំនួនដើមរលំ</td>
                    <td><?php echo $row['number_of_collapsed_trees']; ?></td>
                </tr>
                <tr>
                    <td>អង្កត់ផ្ចិតផ្លែបកសំបក</td>
                    <td><?php echo $row['peeled_fruit_diameter']; ?></td>
                    <td>ប្រវែងផ្លែបបកសំបក</td>
                    <td><?php echo $row['peel_number']; ?></td>
                </tr>
                <tr>
                    <td>ចំនួនជួរគ្រាប់ក្នុងមួយផ្លែ</td>
                    <td><?php echo $row['number_of_rows_of_seeds_per_fruit']; ?></td>
                    <td>ចំនួនគ្រាប់ក្នុងមួយជួរ</td>
                    <td><?php echo $row['number_of_bullets_per_rows']; ?></td>
                </tr>

                <tr>
                    <td>សំបកផ្លែ</td>
                    <td><?php echo $row['fruit_peel']; ?></td>
                    <td>ទម្ងន់</td>
                    <td><?php echo $row['weight']; ?></td>
                </tr>
                <tr>
                    <td>ដង្កូវ</td>
                    <td><?php echo $row['worm']; ?></td>
                    <td>Seeding Vigor</td>
                    <td><?php echo $row['seeding_vigor']; ?></td>
                </tr>
                <tr>
                    <td>ភាពរឹងមាំរបស់កូន</td>
                    <td><?php echo $row['your_child_strength']; ?></td>
                    <td>ការរៀងជួររបស់គ្រាប់</td>
                    <td><?php echo $row['seed_range_shape']; ?></td>

                </tr>
                <tr>
                    <td>ចំនួនឫស</td>
                    <td><?php echo $row['Number_of_roots']; ?></td>
                    <td>ប្រវែងចុងស្នៀត(cm)</td>
                    <td><?php echo $row['Tip_length']; ?></td>
                </tr>

                <!-- <tr>

                    <td>ពណ៌គ្រាប់</td>
                    <td><?php echo $row['grain_color']; ?></td>
                    <td>សរុប</td>
                    <td><?php echo $row['sum']; ?></td>
                </tr> -->
                <tr>

                    <!-- <td>ពណ៌គ្រាប់</td>
                    <td><?php echo $row['grain_color']; ?></td> -->
                    <td>សរុប</td>
                    <td><?php echo $row['sum']; ?></td>
                </tr>
            </table>
            <?php
            $images = explode(',', $row['images']);
            $imageCount = count($images);
            if ($imageCount > -1) {
                echo "<div id='image'>";
                echo "<div id='image_slider' class='slideshow-container overflow-hidden d-flex'>";
                foreach ($images as $index => $image) {
                    if (!empty($image)) { // Check for empty image paths
                        echo "<div class='mySlides'>
                                <img src='$image' alt=''>
                            </div>";
                    }
                }
                echo "</div>";
                echo "<div id='numbering' class='d-flex justify-content-center'>
                        <p id='imageCount'>Image $imageCount of $imageCount</p>
                    </div>";
                echo "<div style='overflow: hidden;' class='button-container m-3'>
                        <button class='prev' onclick='prevSlide()'>Previous</button>
                        <button class='next' onclick='nextSlide()'>Next</button>
                    </div>";
                echo "</div>"; // close #image div
            } else {
                echo "<div id='image' style='display:none;'></div>";
            }
            ?>

        </div>
    </div>
    </div>
    <br>


    <?php
    include "include/footer.php";
    ?>
    <div id="imageModal" class="modal">
        <span class="close">&times;</span>
        <div class="modal-content">
            <img id="expandedImg" />
        </div>
    </div>
    <script>
        // JavaScript for slideshow controls and numbering

        let slideIndex = 0;

        // Function to show slides
        function showSlides() {
            let i;
            let slides = document.getElementsByClassName('mySlides');
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = 'none';
            }
            if (slideIndex >= slides.length) {
                slideIndex = 0;
            }
            if (slideIndex < 0) {
                slideIndex = slides.length - 1;
            }
            slides[slideIndex].style.display = 'block';

            // Update image count
            document.getElementById('imageCount').textContent = 'Image ' + (slideIndex + 1) + ' of ' + slides.length;
        }

        // Function to move to the next slide
        function nextSlide() {
            slideIndex++;
            showSlides();
        }

        // Function to move to the previous slide
        function prevSlide() {
            slideIndex--;
            showSlides();
        }

        // Automatically show slides
        showSlides();
    </script>
    <script>
        // JavaScript for image modal

        var modal = document.getElementById('imageModal');

        // Get the image and insert it inside the modal
        var img = document.getElementById('expandedImg');

        // Function to handle click on image and open modal
        $('img').on('click', function() {
            modal.style.display = "block";
            img.src = this.src;
        });

        // Function to close modal when clicking outside of the image
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        };

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        };
    </script>
    <script src="script/numbering_image.js"></script>
</body>

</html>