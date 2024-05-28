<div class="navigation">
    <div class="nav_bg">
        <div class="menu">
            <a href="index.php" class="nav-link <?php echo ($currentPage === 'home') ? 'active' : ''; ?>">HOME</a>
            <a href="breed.php" class="nav-link <?php echo ($currentPage === 'data') ? 'active' : ''; ?>">DATA</a>
            <a href="add_data.php" class="nav-link <?php echo ($currentPage === 'add_data') ? 'active' : ''; ?>">ADD DATA</a>
            <?php
            // Check if the user type is admin
            if ($userType === 'admin') {
                echo '<a href="user.php" class="nav-link ' . (($currentPage === 'user') ? 'active' : '') . '">USER</a>';
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

                    ?></button>
                <div id="dropdown-content">
                    <a href='profile.php?id=<?php echo $_SESSION['user_id']; ?>' onclick="viewProfile()"><i class="fa-regular fa-user me-1"></i>Profile</a>
                    <a href="logout.php" onclick="logout()"><i class="fa-solid fa-arrow-right-from-bracket me-1"></i>Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>
