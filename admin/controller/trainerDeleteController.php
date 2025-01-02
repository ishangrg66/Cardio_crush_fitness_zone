<?php

    include_once "dbconnect.php";
    
    $trainer_id=$_POST['record'];
    $query="DELETE FROM trainers where trainer_id='$trainer_id'";

    $data=mysqli_query($conn,$query);

    if($data){
        echo"Trainer Deleted";
    }
    else{
        echo"Not able to delete";
    }
    
?>