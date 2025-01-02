<?php
    include_once "dbconnect.php";

    $member_id=$_POST['record'];
    $member_name= $_POST['record'];
    $email= $_POST['record'];
    $contact= $_POST['record'];
      
    $query = "UPDATE memberships
    SET member_id = '$member_id', member_name = '$member_name', email = '$email', contact = '$contact'
    WHERE member_id = '$member_id'";

    $updateNewMember = mysqli_query($conn,$query);

    if($updateNewMember){
        echo"New Member Updated";
    }
    else{
        echo"Not able to update";
    }
?>