<!-- Sidebar -->
<div class="sidebar" id="mySidebar">
    <div class="side-header">
        <!-- <img src="../admin/uploads/assets/images/logo-no-background.png" width="150"  alt="Cardio Crush">  -->
        <!-- <h5 style="margin-top:10px;">Hello Admin</h5> -->
    </div>

    <hr style="border:1px solid; background-color:rgb(229, 19, 19); border-color:#3B3131;">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
    <a href="./index.php"><i class="fa fa-home"></i> Dashboard</a>
    <a href="#viewTotalRegisteredUsers.php" onclick="showTotalRegisteredUsers()"><i class="fa fa-th-large"></i> View Registration</a>
    <a href="#viewNewMembership" onclick="showNewMembership()"><i class="fa fa-th"></i> Membership</a>
    <a href="#viewTrainers" onclick="showTrainers(event)"><i class="fa fa-list"></i> Trainers</a>
    <a href="#viewPlans" onclick="showPlans()"><i class="fa fa-users"></i> Plans</a>

</div>

<div id="main">
    <button class="openbtn" onclick="openNav()"><i class="fa fa-home"></i></button>
</div>