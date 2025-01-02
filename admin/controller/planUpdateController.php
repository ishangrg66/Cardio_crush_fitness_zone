<?php

    include_once "dbconnect.php";

    $plan_id=$_POST['record'];
    $plan_name= $_POST['record'];
    $plan_price= $_POST['record'];
    $plan_validity= $_POST['record'];
      
    $query = "UPDATE plans
    SET plan_id = '$plan_id', plan_name = '$plan_name', plan_price = '$plan_price', plan_validity = '$plan_validity'
    WHERE plan_id = '$plan_id'";

    $updatePlan = mysqli_query($conn,$query);

    if($updatePlan){
        echo"Plan Updated";
    }
    else{
        echo"Not able to update";
    }
?>