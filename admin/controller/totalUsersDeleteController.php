<?php

    include_once "dbconnect.php";
    
    $user_id=$_POST['record'];
    $query="DELETE FROM user_account where id='$user_id'";

    $data=mysqli_query($conn,$query);

    if($data){
        echo"User Deleted";
    }
    else{
        echo"Not able to delete";
    }
    
?>