<?php
session_start();
// print_r($_SESSION);
if (!isset($_SESSION['username']) && !isset($_SESSION['user_id'])) {
    header('location: ../index.php');
    exit(0);
}
?>
<?php
$userId = isset($_GET['id']) ? $_GET['id'] : null;

if ($userId === null) {
    // Handle the case where 'id' is not provided in the URL
    echo "User ID is missing!";
    exit(0);
}

include_once "database/db.php";
include "include/forProfile.php";

$sql = "SELECT * FROM users WHERE id = $userId";
$result = $conn->query($sql);

if ($result === false) {
    die("Error in SQL query: " . $conn->error);
}

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    die("User not found");
}
include "include/foradmin.php";
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>


    <title>Profile</title>
    <?php include "include/head.php" ?>

    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->

    <style>
        /* Add these styles to your existing CSS or create a new file */
        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .popup-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
        }

        .profile-container {
            position: relative;
            /* width: 150px;
            height: 150px; */
            overflow: hidden;
            /* border-radius: 50%; */
        }

        .profile-container img {
            /* width: 100%;
            height: 100%; */
            object-fit: cover;
            /* cursor: pointer; */
        }
    </style>

<body>
    <!-- header  -->
    <?php include_once "include/header.php" ?>
    <!-- navigation -->
    <?php include "include/navigation.php"; ?>
    <br>
    <div class="wrappage">
        <!-- <a class=" btn btn-primary p-6 " href="user.php">BACK</a> -->
        <div>
            <div style="width: 30%;">
                <p class="h2 container float-start">PROFILE</p>
            </div>
            <?php if (isset($_SESSION['success_message'])) : ?>
                <div style="width: 300px;" class="alert alert-success alert-dismissible fade show float-end   d-flex justify-content-center align-items-center" role="alert">
                    <strong><?php echo $_SESSION['success_message']; ?></strong>
                    <button style="top: 4px;" type="button" class="btn-close p-3 w-1" aria-label="Close" onclick="closeAlert(this)"></button>
                </div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['error_message'])) : ?>
                <div style="width: 300px;" class="alert alert-success alert-dismissible fade show float-right  d-flex justify-content-center align-items-center" role="alert">
                    <strong><?php echo $_SESSION['error_message']; ?></strong>
                    <button style="top: 4px;" type="button" class="btn-close p-3 w-1" aria-label="Close" onclick="closeAlert(this)"></button>
                </div>
                <?php unset($_SESSION['error_message']); ?>
            <?php endif; ?>
        </div>
        <!-- Add this button inside the form -->


        <!-- <button class="btn btn-primary" onclick="openPasswordResetPopup(<?php //echo $row['id']; 
                                                                                ?>)">Reset Password</button> -->

        <!-- <div id="add_user" class="container">
            <a class="btn btn-primary float-end" href="#">ADD USER</a>
        </div> -->
        <div id="list_user" class="container">

            <form action="update_user_form.php" method="post" class="float-start" style="width: 70%;">
                <table id="table_add_user">

                    <tr>
                        <td>
                            <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                            <label class="form-label" for="first_name">នាមត្រកូល</label>
                            <!-- <input class="form-control" type="text" name="first_name" value="<?php // echo $row['first_name']; 
                                                                                                    ?>" required><br> -->
                            <p class="form-control"><?php echo $row['first_name']; ?></p>
                        </td>
                        <td>
                            <label class="form-label" for="last_name">នាមខ្លួន</label>
                            <!-- <input class="form-control"  type="text" name="last_name" value="<?php //echo $row['last_name']; 
                                                                                                    ?>" required><br> -->
                            <p class="form-control"><?php echo $row['last_name']; ?></p>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label class="form-label" for="username">Username:</label>
                            <!-- <input class="form-control"  type="text" name="username" value="<?php //echo $row['username']; 
                                                                                                    ?>" required><br> -->
                            <p class="form-control"><?php echo $row['username']; ?></p>
                        </td>
                        <td>
                            <label class="form-label" for="email">Email:</label>
                            <!-- <input class="form-control"  type="email" name="email" value="<?php //echo $row['email']; 
                                                                                                ?>" required><br> -->
                            <p class="form-control"><?php echo $row['email']; ?></p>
                        </td>
                    </tr>

                    <tr>
                        <td>

                            <label class="form-label" for="phone_number">លេខទូរស័ព្ទ</label>
                            <!-- <input class="form-control"  type="text" name="phone_number" value="<?php //echo $row['phone_number']; 
                                                                                                        ?>" required><br>-->
                            <p class="form-control"><?php echo $row['phone_number']; ?> </p>
                        </td>

                        <td>
                            <!-- <label class="form-label" for="type">User Type<span class="text-danger"></span></label>
                            <p class="form-control"><?php echo $row['type']; ?> </p> -->
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <a class=' btn btn-primary ' href='update_profile.php?id=<?php echo $row['id'] ?>'><i class="fa-solid fa-pen-to-square me-1"></i>កែ Profile</a>
                            <!-- <button class="btn btn-primary" type="submit" name="update">Update</button> -->
                        </td>
                        <td>

                        </td>
                    </tr>
                </table>
            </form>
            <div id="image_profile" class="float-end d-flex justify-content-center">
                <div class="profile-container" id="border_image">
                    <!-- <img id="profile-image" src="image/ksitlogo.PNG" alt="Profile Image" onclick="uploadImage()"> -->
                    <?php

                    $images = explode(',', $row['images']);
                    // Check if there is at least one image
                    if (!empty($images[0])) {
                        echo "<img src='{$images[0]}' alt='Profile Image' onclick='uploadImage()'>";
                    } else {
                        echo "<img id=' profile-image' src='image/ksitlogo.PNG' alt='Profile Image' onclick='uploadImage()'>";
                    }

                    ?>
                </div>




            </div>
        </div>
    </div>


    <br>
    <?php
    include "include/footer.php";
    ?>
    <!-- Add this div at the end of your HTML body -->
    <div id="passwordResetPopup" class="popup">
        <div class="popup-content">
            <span class="close" onclick="closePasswordResetPopup()">&times;</span>
            <h2>Reset Password</h2>
            <!-- Add your password reset form here -->
            <form action="reset_password.php" method="post">
                <!-- Add this hidden input field -->
                <input type="hidden" name="user_id" id="userIdInput" value="">

                <label for="new_password">New Password:</label>
                <input type="password" name="new_password" required>
                <button type="submit" name="reset_password">Reset Password</button>
            </form>
        </div>
    </div>

    <script src="script/dropdpwn.js"></script>
    <script>
        function closeAlert(button) {
            // Find the parent element of the button, which is the alert div
            var alertDiv = button.closest('.alert');
            // Hide the alert by removing the 'show' class
            alertDiv.classList.remove('show');
        }
    </script>
    <script>
        function uploadImage() {
            document.getElementById('file-input').click();
        }

        document.getElementById('file-input').addEventListener('change', function() {
            const file = this.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    document.getElementById('profile-image').src = e.target.result;
                }

                reader.readAsDataURL(file);
            }
        });
    </script>
    <script>
        // Add these functions to your existing JavaScript or create a new file
        // Update this function in your existing JavaScript or create a new file
        function openPasswordResetPopup(userId) {
            document.getElementById('passwordResetPopup').style.display = 'block';

            // Set the user ID in a hidden input field inside the pop-up form
            document.getElementById('userIdInput').value = userId;
        }
    </script>
</body>

</html>