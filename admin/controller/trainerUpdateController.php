<?php
    include_once "dbconnect.php";

    $trainer_id=$_POST['record'];
    $trainer_name= $_POST['record'];
    $email= $_POST['record'];
    $contact= $_POST['record'];
      
    $query = "UPDATE plans
    SET trainer_id = '$trainer_id', trainer_name = '$trainer_name', image = '$image', phone_number = '$contact'
    WHERE trainer_id = '$trainer_id'";

    $updatePlan = mysqli_query($conn,$query);

    if($updatePlan){
        echo"Trainer Updated";
    }
    else{
        echo"Not able to update";
    }
?>