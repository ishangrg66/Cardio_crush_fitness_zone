<?php

    include_once "dbconnect.php";
    
    $member_id=$_POST['record'];
    $query="DELETE FROM memberships where member_id='$member_id'";

    $data=mysqli_query($conn,$query);

    if($data){
        echo"Member Deleted";
    }
    else{
        echo"Not able to delete";
    }
    
?>