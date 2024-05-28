<?php
session_start();

if (!isset($_SESSION['username']) && !isset($_SESSION['user_id'])) {
    header('location: ../index.php');
    exit(0);
}

// Include the database connection script
include_once "database/db.php";
include "include/forProfile.php";

// Function to change the user's password
function changePassword($userId, $currentPassword, $newPassword)
{
    // Check the connection
    global $conn;
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL query to select user's current password hash
    $sql = "SELECT password FROM users WHERE id = $userId";
    $result = $conn->query($sql);

    // Check if any rows were returned
    if ($result === false || $result->num_rows == 0) {
        // Handle the case when the user is not found
        die("User not found");
    }

    // Fetch the user's current password hash
    $row = $result->fetch_assoc();
    $currentHashedPassword = $row['password'];

    // Verify if the current password matches the one stored in the database
    if (password_verify($currentPassword, $currentHashedPassword)) {
        // Hash the new password
        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Prepare and execute the SQL query to update the user's password
        $updateSql = "UPDATE users SET password = '$hashedNewPassword' WHERE id = $userId";
        if ($conn->query($updateSql) === TRUE) {
            // Password updated successfully
            return true;
        } else {
            // Error updating password
            return false;
        }
    } else {
        // Current password provided is incorrect
        return false;
    }
}

// Check if the 'id' key is set in the $_GET superglobal
if (!isset($_GET['id'])) {
    // Handle the case when 'id' is not provided in the URL
    die("User ID is missing");
}

// Get the user ID from the URL parameter
$userId = $_GET['id'];

// Fetch user data from the database
$sql = "SELECT * FROM users WHERE id = $userId";
$result = $conn->query($sql);

// Check if user data was fetched successfully
if ($result === false || $result->num_rows == 0) {
    // Handle the case when user data is not found
    die("User not found");
}

// Fetch user data
$row = $result->fetch_assoc();

// Check if the form was submitted for updating user information
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change_password'])) {
    // Get the current password, new password, and confirm password from the form
    $currentPassword = $_POST['current_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Verify if the new password matches the confirm password
    if ($newPassword === $confirmPassword) {
        // Attempt to change the password
        $passwordChanged = changePassword($userId, $currentPassword, $newPassword);
        if ($passwordChanged) {
            $_SESSION['password_change_message'] = 'Password changed successfully.';
        } else {
            $_SESSION['password_change_false'] = 'Invalid current password. Please try again.';
        }
    } else {
        // New password and confirm password do not match
        $_SESSION['password_change_error_message'] = 'New password and confirm password do not match.';
    }

    // Redirect back to the same page to display the alert message
    header('Location: ' . $_SERVER['PHP_SELF'] . '?id=' . $userId);
    exit();
}
include "include/foradmin.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>edit</title>
    <?php include "include/head.php"; ?>
    <style>
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
            cursor: pointer;
        }
    </style>

<body>
    <!-- header  -->
    <?php include_once "include/header.php" ?>
    <!-- navigation -->
    <?php include "include/navigation.php"; ?>
    <br>
    <div class="wrappage">
        <!-- <a class=" btn btn-primary  " href="user.php">BACK</a> -->
        <a class=" btn btn-primary" style="width: 100px;" href='profile.php?id=<?php echo $_SESSION['user_id']; ?>' onclick="viewProfile()">ថយក្រោយ</a>
        <button type="button" id="changePasswordBtn" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
            ប្តូរពាក្សសម្ងាត់
        </button>
        <!-- Display password change message, if any -->
        <?php if (isset($_SESSION['password_change_message'])) : ?>
            <div style="width: 300px;" class="alert alert-success alert-dismissible fade show float-right p-2  m-4 d-flex justify-content-center align-items-center" role="alert">
                <strong><?php echo $_SESSION['password_change_message']; ?></strong>
                <button style="top: -5px;" type="button" class="btn-close p-3 w-1" aria-label="Close" onclick="closeAlert(this)"></button>
            </div>
            <?php unset($_SESSION['password_change_message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['password_change_error_message'])) : ?>
            <div class="alert alert-danger alert-dismissible fade show float-right p-2 m-4 d-flex justify-content-center align-items-center" style="width: 450px;" role="alert">
                <strong><?php echo $_SESSION['password_change_error_message']; ?></strong>
                <button style="top: -5px;" type="button" class="btn-close p-3 w-1" aria-label="Close" onclick="closeAlert(this)"></button>
            </div>
            <?php unset($_SESSION['password_change_error_message']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['password_change_false'])) : ?>
            <div class="alert alert-danger alert-dismissible fade show float-right p-2 m-4 d-flex justify-content-center align-items-center" style="width: 450px;" role="alert">
                <strong><?php echo $_SESSION['password_change_false']; ?></strong>
                <button style="top: -5px;" type="button" class="btn-close p-3 w-1" aria-label="Close" onclick="closeAlert(this)"></button>
            </div>
            <?php unset($_SESSION['password_change_false']); ?>
        <?php endif; ?>
        <script>
            function closeAlert(button) {
                button.parentElement.classList.remove('show');
                button.parentElement.classList.add('hide');
            }
        </script>


        <h2 class="container">កែ</h2>
        <!-- <div id="add_user" class="container">
            <a class="btn btn-primary float-end" href="#">ADD USER</a>
        </div> -->
        <div id="list_user" class="container">
            <form action="update_profile_form.php" class="float-start" method="POST" enctype="multipart/form-data">
                <table id="table_add_user" class="float-start" style="width:70%;">
                    <tr>
                        <td>
                            <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                            <label class="form-label" for="first_name">នាមត្រកូល</label>
                            <input class="form-control" type="text" name="first_name" value="<?php echo $row['first_name']; ?>">
                        </td>
                        <td>
                            <label class="form-label" for="last_name">នាមខ្លួន</label>
                            <input class="form-control" type="text" name="last_name" value="<?php echo $row['last_name']; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label class="form-label" for="username">Username:</label>
                            <input class="form-control" type="text" name="username" value="<?php echo $row['username']; ?>" required>
                        </td>
                        <td>
                            <label class="form-label" for="email">Email:</label>
                            <input class="form-control" type="email" name="email" value="<?php echo $row['email']; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label class="form-label" for="phone_number">លេខទូរស័ព្ទ</label>
                            <input class="form-control" type="text" name="phone_number" value="<?php echo $row['phone_number']; ?>"><br>
                        </td>

                        <td>
                            <!-- <label class="form-label" for="status">Status:</label><br>
                            <select class="form-control" name="status" required>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select><br> -->

                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button class="btn btn-success" type="submit" name="update"><i class="fa-solid fa-check me-1"></i>រក្សាទុក</button>
                        </td>
                        <td>

                        </td>
                    </tr>
                </table>
                <div id="image_profile" class="float-end d-flex justify-content-center image_profile">
                    <div class="profile-container" id="image_profile1" class="d-flex justify-content-center">
                        <?php
                        $images = explode(',', $row['images']);
                        // Check if there is at least one image
                        if (!empty($images[0])) {
                            echo "<img src='{$images[0]}' id='profile-image' alt='Profile Image' onclick='uploadImage()'>";
                        } else {
                            echo "<img id='profile-image' src='image/ksitlogo.png' alt='Profile Image' onclick='uploadImage()'>";
                        }
                        ?>
                    </div>
                    <input type="file" id="file-input" style="display: none;" name="images" accept="image/*">
                </div>
            </form>
        </div>
    </div>
    <br>
    <?php
    include "include/footer.php";
    ?>
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">ការប្ដូរពាក្យសម្ងាត់</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <form action="" method="POST" onsubmit="return checkPasswordMatch();">
                        <div class="form-group" id="show_hide">
                            <label for="current_password">ពាក្យសម្ងាត់បច្ចុប្បន្ន<span class="text-danger">*</span></label>
                            <div id="show_password" class="d-flex justify-content-between">
                                <input class="" type="password" id="passwordField" name="current_password" required>
                                <button type="button" onclick="togglePassword()" id="toggleButton" style="display:none">Show</button>
                            </div>
                        </div>

                        <div class="form-group" id="show_hide">
                            <label for="new_password">ពាក្យសម្ងាត់ថ្មី<span class="text-danger">*</span></label>
                            <div id="show_password" class="d-flex justify-content-between">
                                <input class="" type="password" id="passwordField2" name="new_password" required>
                                <button type="button" onclick="togglePassword2()" id="toggleButton2" style="display:none">Show</button>
                            </div>
                        </div>

                        <div class="form-group" id="show_hide">
                            <label class="" for="confirm_password">បញ្ជាក់ពាក្យសម្ងាត់ថ្មិ<span class="text-danger">*</span></label>
                            <div id="show_password" class="d-flex justify-content-between">
                                <input class="" type="password" id="passwordField3" name="confirm_password" required>
                                <button type="button" onclick="togglePassword3()" id="toggleButton3" style="display:none">Show</button>
                            </div>
                        </div>


                        <button class="btn btn-success" type="submit" name="change_password">យល់ព្រម</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="script/dropdpwn.js"></script>
    <!-- Your HTML code -->

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
        function togglePassword() {
            var passwordField = document.getElementById("passwordField");
            var toggleButton = document.getElementById("toggleButton");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleButton.textContent = "Hide";
            } else {
                passwordField.type = "password";
                toggleButton.textContent = "Show";
            }
        }

        // Show the button only if the input field is not empty
        document.getElementById("passwordField").addEventListener("input", function() {
            var toggleButton = document.getElementById("toggleButton");
            toggleButton.style.display = (this.value.trim() !== "") ? "block" : "none";
        });

        function togglePassword2() {
            var passwordField = document.getElementById("passwordField2");
            var toggleButton = document.getElementById("toggleButton2");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleButton.textContent = "Hide";
            } else {
                passwordField.type = "password";
                toggleButton.textContent = "Show";
            }
        }

        // Show the button only if the input field is not empty
        document.getElementById("passwordField2").addEventListener("input", function() {
            var toggleButton = document.getElementById("toggleButton2");
            toggleButton.style.display = (this.value.trim() !== "") ? "block" : "none";
        });


        function togglePassword3() {
            var passwordField = document.getElementById("passwordField3");
            var toggleButton = document.getElementById("toggleButton3");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleButton.textContent = "Hide";
            } else {
                passwordField.type = "password";
                toggleButton.textContent = "Show";
            }
        }

        // Show the button only if the input field is not empty
        document.getElementById("passwordField3").addEventListener("input", function() {
            var toggleButton = document.getElementById("toggleButton3");
            toggleButton.style.display = (this.value.trim() !== "") ? "block" : "none";
        });
    </script>
    <script>
        // Function to open the update modal with the existing dataa
        function openUpdateModal(id, currentName) {
            // Set the current breed name in the input field
            $("#updatedName").val(currentName);

            // Set the ID of the record being updated in the hidden field
            $("#update_id").val(id);

            // Show the update modal
            $("#updateModal").modal("show");
        }

        // Function to update data
    </script>

</body>

</html>