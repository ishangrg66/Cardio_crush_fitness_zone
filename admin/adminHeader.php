<?php
session_start();
include_once "db.php";

?>

<!-- nav -->
<nav class="navbar navbar-expand-lg navbar-light px-5" style="background-color: #3B3131;">
    <!-- LOGO Here -->
    <a class="navbar-brand ml-3" href="./index.php">
        <img src="../admin/uploads/weightlifting.png" width="50" alt="Cardio Crush Fitness">
    𝐂𝐚𝐫𝐝𝐢𝐨 𝐂𝐫𝐮𝐬𝐡
    </a>
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0"></ul>

    <div class="user-cart">
        <?php
        if (isset($_SESSION['admin_id'])) {
        ?>
            <a href="" style="text-decoration:none;">
                <i class="fa fa-user mr-5" style="font-size:30px; color:#fff;" aria-hidden="true"></i>
            </a>
        <?php
        } else {
        ?>
            <!-- logout logo -->
            <a href="logout.php" style="text-decoration:none;">
                <i class="fa fa-sign-in mr-5" style="font-size:30px; color:#fff;" aria-hidden="true"></i>
            </a>

        <?php
        } ?>
    </div>
</nav>