<?php
session_start();

if (!isset($_SESSION['username']) && !isset($_SESSION['user_id'])) {
    header('location: ../index.php');
    exit(0);
}

// Include the database connection script
include_once "database/db.php";
include "include/forProfile.php";


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
    // Get the new password and confirm password from the form
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Verify if the new password matches the confirm password
    if ($newPassword === $confirmPassword) {
        // Hash the new password
        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Prepare and execute the SQL query to update the user's password
        $updateSql = "UPDATE users SET password = '$hashedNewPassword' WHERE id = $userId";
        if ($conn->query($updateSql) === TRUE) {
            // Password updated successfully
            $_SESSION['password_change_message'] = 'Password changed successfully.';
        } else {
            // Error updating password
            $_SESSION['password_change_error_message'] = 'Error occurred while changing password.';
        }
    } else {
        // New password and confirm password do not match
        $_SESSION['password_change_error_message'] = 'New password and confirm password do not match.';
    }

    // Redirect back to the same page to display the alert message
    header('Location: ' . $_SERVER['PHP_SELF'] . '?id=' . $userId);
    exit();
}

if (isset($_POST['update'])) {
    $userId = $_POST['user_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $status = $_POST['status'];
    $type = $_POST['type'];


    include_once "database/db.php";

    $sql = "UPDATE users SET
            first_name = '$first_name',
            last_name = '$last_name',
            username = '$username',
            email = '$email',
            phone_number = '$phone_number',
            status = '$status',
            type = '$type'
            WHERE id = $userId";

    if ($conn->query($sql) === TRUE) {
        // Successful insertion
        $_SESSION['success_message1'] = "បន្ថែមទិន្នន័យបានជោគជ័យ.";
        header('Location: user.php');
        exit();
    } else {
        // Display the SQL error
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // $conn->close();
}

?>



<!DOCTYPE html>
<html lang="en">

<head>

    <title>edit</title>
    <?php
    include "include/head.php";
    include "include/forProfile.php";
    include "include/foradmin.php";
    ?>

</head>

<body>
    <!-- header  -->
    <?php include_once "include/header.php" ?>
    <!-- navigation -->
    <?php include "include/navigation.php"; ?>
    <br>
    <div class="wrappage">
        <a class=" btn btn-primary w-5" style="width: 100px;" href="user.php">ថយក្រោយ</a>
        <button type="button" id="changePasswordBtn" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
            ប្ដូរពាក្យសម្ងាត់
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

            <form action="" method="post">
                <table id="table_add_user">
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
                            <input class="form-control" type="text" name="phone_number" value="<?php echo $row['phone_number']; ?>">
                        </td>

                        <td>
                            <label class="form-label" for="status">Active</label><br>
                            <select class="form-control" name="status" required>
                                <option value="Active" <?php echo ($row['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                                <option value="Inactive" <?php echo ($row['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                            </select>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label class="form-label" for="type">User Type<span class="text-danger"></span></label>
                            <select name="type" id="" class="form-control" required>
                                <option value="admin" <?php echo ($row['type'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                <option value="user" <?php echo ($row['type'] == 'user') ? 'selected' : ''; ?>>User</option>
                            </select><br>
                        </td>
                        <td>

                        </td>
                    </tr>
                    <tr>
                        <td>
                            <button class="btn btn-success" type="submit" name="update" style="width: 150px;"><i class="fa-solid fa-check me-1"></i>រក្សាទុក</button>
                        </td>
                        <td>

                        </td>
                    </tr>
                </table>
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
                            <label for="new_password">ពាក្យសម្ងាត់ថ្មី<span class="text-danger">*</span></label>
                            <div id="show_password" class="d-flex justify-content-between">
                                <input class="" type="password" id="passwordField" name="new_password" required>
                                <button type="button" onclick="togglePassword()" id="toggleButton" style="display:none">Show</button>
                            </div>
                        </div>

                        <div class="form-group" id="show_hide">
                            <label class="" for="confirm_password">បញ្ជាក់ពាក្យសម្ងាត់ថ្មី<span class="text-danger">*</span></label>
                            <div id="show_password" class="d-flex justify-content-between">
                                <input class="" type="password" id="passwordField2" name="confirm_password" required>
                                <button type="button" onclick="togglePassword2()" id="toggleButton2" style="display:none">Show</button>
                            </div>
                        </div>


                        <button class="btn btn-success" type="submit" name="change_password">យល់ព្រម</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

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
    </script>
    <script>
        function openModal() {
            $('#myModal').modal('show');
        }

        function resetPassword() {
            var newPassword = $('#new_password').val();
            var confirmPassword = $('#confirm_password').val();

            if (newPassword !== confirmPassword) {
                alert('Passwords do not match. Please try again.');
                return false;
            }

            // If passwords match, proceed with form submission
            return true;
        }
    </script>

    <script>
        function openModal() {
            $('#myModal').modal('show');
        }

        function insertData() {
            // Get form data
            var formData = $('#insertForm').serialize();
            console.log('FormData:', formData); // Log the serialized form data
            var breedName = $('#name').val();

            // Check if breed name is empty
            if (breedName.trim() === '') {
                alert('Please enter a breed name.');
                return; // Do not proceed with the submission
            }

            // AJAX request to insert data
            $.ajax({
                type: 'POST',
                url: 'reset_password.php', // PHP script to handle data insertion
                data: formData,
                success: function(response) {
                    console.log('AJAX Response:', response);
                    // Handle the response (e.g., display success message)


                    alert(response);
                    // Close the modal
                    $('#myModal').modal('hide');
                    location.reload();
                }
            });
        }
    </script>
    <script src="script/dropdpwn.js"></script>
</body>

</html>