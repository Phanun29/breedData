<?php
// Define the current page URL
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="navigation">
    <div class="nav_bg">
        <div class="menu">
            <a href="index.php" <?php if ($current_page === 'index.php') echo 'class="active"'; ?>>HOME</a>
            <a href="breed.php" <?php if ($current_page === 'breed.php') echo 'class="active"'; ?>>DATA BREEDING</a>
            <a href="compare.php" <?php if ($current_page === 'compare.php') echo 'class="active"'; ?>>DATA COMPARE</a>
            <a href="add_data.php" <?php if ($current_page === 'add_data.php') echo 'class="active"'; ?>>ADD DATA BREEDING</a>
            <?php
            // Check if the user type is admin
            if ($userType === 'admin') {
            ?>

                <a href="user.php" <?php if ($current_page === 'user.php') echo 'class="active"'; ?>>USER</a>';
            <?php
            }
            ?>
        </div>
        <div class="search">
            <div class="float-start d-flex justify-content-center">
                <p style="line-height: 3;margin-right: 10px;">
                    <?php //echo $rowp['last_name'] 
                    ?> <span class="px-0"></span><?php // echo  $rowp['first_name']; 
                                                    ?>
                </p>
            </div>
            <div id="dropdown" class="float-end">
                <button class="dropbtn overflow-hidden d-flex justify-content-center">
                    <i class="fa-regular fa-user"></i>
                    <?php
                    // $images = explode(',', $rowp['images']);
                    // // Check if there is at least one image
                    // if (!empty($images[0])) {
                    //     echo "<img src='{$images[0]}' alt='Profile Image' onclick='uploadImage()'>";
                    // } else {
                    //     echo "<img id=' profile-image' src='image/ksitlogo.png' alt='Profile Image' onclick='uploadImage()'>";
                    // }
                    ?>
                </button>
                <div id="dropdown-content">
                    <a href='profile.php?id=<?php echo $_SESSION['user_id']; ?>' onclick="viewProfile()"><i class="fa-regular fa-user me-1"></i>Profile</a>
                    <a href="logout.php" onclick="logout()"><i class="fa-solid fa-arrow-right-from-bracket me-1"></i>Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>