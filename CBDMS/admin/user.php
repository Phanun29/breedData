<?php
session_start();
// print_r($_SESSION);
if (!isset($_SESSION['username']) && !isset($_SESSION['user_id'])) {
    header('location: ../index.php');
    exit(0);
}
include "database/db.php";
include "include/forProfile.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>USER</title>
    <?php include "include/head.php"; ?>

</head>

<body>
    <!-- header  -->
    <?php include_once "include/header.php" ?>
    <?php include "include/foradmin.php"; ?>
    <!-- navigation -->
    <?php include "include/navigation.php"; ?>
    <br>
    <div class="wrappage ">
        <div class="p-2" style="width: 95%;height:60px;">
            <h2 class="float-start">បញ្ជីអ្នកប្រើប្រាស់</h2>
            <!-- <?php if (isset($_SESSION['success_message1'])) : ?>
                <div style="width: 300px;margin-top:10px" class="alert alert-success alert-dismissible fade show float-right p-2 mx-2   d-flex justify-content-center align-items-center" role="alert">
                    <strong><?php echo $_SESSION['success_message1']; ?></strong>
                    <button style="top: -5px;" type="button" class="btn-close p-3 w-1" aria-label="Close" onclick="closeAlert(this)"></button>

                </div>
                <?php unset($_SESSION['success_message1']); ?>
            <?php endif; ?> -->
        </div>
        <div id="add_user" class="container" style="width: 100%;">
            <a class="btn btn-primary float-end" href="add_user.php"><i class="fa-solid fa-plus me-1"></i>បន្ថែម</a>
        </div>
        <div id="list_user" class="container">

            <table class="container" id='table_user'>
                <thead>
                    <tr class="text-center">
                        <th width=50;>#</th>
                        <th width=150;>នាមត្រកូល</th>
                        <th width=150;>នាមខ្លួន</th>
                        <th width=140;>Username</th>
                        <th width=100>User type</th>
                        <th width=220;>Email</th>
                        <th width=200;>លេខទូរស័ព្ទ</th>
                        <th width=100;>Active</th>
                        <th width=110;>សកម្មភាព</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include "database/db.php";

                    $sql = "SELECT * FROM users";
                    $result = $conn->query($sql);
                    $i = 1;

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            echo '<tr class="text-center">';
                            echo '<td>' . $i++ . '</td>';
                            echo '<td>' . $row['first_name'] . '</td>'; // Replace 'name' with your column names
                            echo '<td>' . $row['last_name'] . '</td>'; // Replace 'number' with your column names
                            echo '<td>' . $row['username'] . '</td>'; // Replace 'fromDate' with your column names
                            echo '<td>' . $row['type'] . '</td>';
                            echo '<td>' . $row['email'] . '</td>'; // Replace 'toDate' with your column names
                            echo '<td>' . $row['phone_number'] . '</td>'; // Replace 'becuse' with your column names
                            echo '<td>' . $row['status'] . '</td>';
                            echo "<th><a class= ' btn btn-primary ' href='update_user.php?id={$row['id']}'><i class='fa-solid fa-pen-to-square me-1'></i>កែ</a> </th>";
                            echo '</tr>';
                        }
                    } else {
                        echo "No users in the database.";
                    }

                    $conn->close();

                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <br>
    <?php
    include "include/footer.php";
    ?>
    <script src="script/dropdpwn.js"></script>
</body>

</html>