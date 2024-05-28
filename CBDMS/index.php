<?php
// Include database connection code here
include_once "admin/database/db.php";
session_start();

if (isset($_SESSION['username']) && isset($_SESSION['user_id'])) {
    // User is already logged in
    header('location: admin/index.php'); // Redirect to the home page or wherever you want
    exit(0);
}
// include "admin/include/foradmin.php";
// include "admin/include/forProfile.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form is submitted, process login

    // Your database connection logic here

    // Get input from login form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Perform SQL injection prevention (use prepared statements)
    $username = mysqli_real_escape_string($conn, $username);

    // Query to fetch user details
    $sql = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, check status
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            // Password is correct
            if ($row['status'] === 'active') {
                // User is active, proceed with login
                $_SESSION['username'] = $row['username'];
                $_SESSION['user_id'] = $row['id'];
                // if ($row['type'] === 'admin') {
                header("location: admin/index.php");
                // Redirect to the home page or wherever you want
                //     exit(0);
                // } else {
                //     header('location: admin/index.php'); // Redirect to the home page or wherever you want
                //     exit(0);
                // }
                // header('location: admin/index.php'); // Redirect to the home page or wherever you want
                exit(0);
            } else {
                // User is inactive, redirect with an error
                header('location: index.php?error=inactive');
                exit(0);
            }
        } else {
            // Incorrect password, redirect with an error
            header('location: index.php?error=invalid');
            exit(0);
        }
    } else {
        // User not found, redirect with an error
        header('location: index.php?error=invalid');
        exit(0);
    }

    $stmt->close();
    $conn->close();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="admin/style/stylelogin.css">
    <link rel="stylesheet" href="admin/style/style.css">
    <title>Login</title>
    <link rel="icon" href="admin/image/ksitlogo.PNG">
    <link rel="stylesheet" href="admin/bt/css/bootstrap.css">

</head>

<body style="background-color: rgb(93, 143, 163);margin-top:90px;">
    <!-- <div id="header_bg" class="">
        <header class="">
            <div class="header_l ">
                <a href="index.php"><img src="admin/image/ksitlogo.PNG" alt=""></a>
                <div class="container">
                    <h2>វិទ្យាស្ថានបច្ចេកវិទ្យាកំពង់ស្ពឺ <br> <span>Kampong Speu Institute of Technology</span></h2>
                </div>
            </div>
            <div class="header_r">
                <p>Corn Breeding Data Management System</p>
            </div>
        </header>
    </div> -->
    <div class="wrapper" style="">
        <form action="" method="post">
            <h1 class="m-1">Login</h1>

            <div class="input-box1">

                <!-- <label for="username">Username:</label> -->
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <br>
            <div id="input_group" class="input-box2 ">
                <input type="password" class="" name="password" id="passwordField" placeholder="Password" required>
                <!-- <div class="input-group-append"> -->

                <button type="button" onclick="togglePassword()" id="toggleButton" style="display:none">Show</button>
                <!-- </div> -->
            </div>
            <div class="remember-forget">
                <!-- <div> <a class="float-right" href="">forget password</a></div> -->
                <?php
                ?>
                <!-- <a href="#">Forget Password</a> -->
                <p>
                    <?php
                    if (isset($_GET['error'])) {
                        $error = $_GET['error'];
                        if ($error === 'inactive') {
                            echo "<p class='text-danger'>Your account is inactive. </p>";
                        } elseif ($error === 'invalid') {
                            echo "<p class='text-danger'>Invalid username or password.</p>";
                        }
                    }
                    ?>
                </p>
            </div>
            <input class="btn btn-primary" type="submit" value="Login">
        </form>
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
    </script>
</body>

</html>