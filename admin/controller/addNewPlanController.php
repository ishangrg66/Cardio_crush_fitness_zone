<?php
    include_once "dbconnect.php";
    
    if(isset($_POST['plan_submit']))
    {
        $plans_id = $_POST['plans_id'];
        $plan_name = $_POST['plan_name'];
        $description = $_POST['description'];
        $duration = $_POST['duration'];
        $price = $_POST['price'];
        $query = "INSERT INTO plans
        VALUES('$plans_id', '$plan_name', '$description', '$duration', '$price')";
        $planInsert = mysqli_query($conn,$query);
 
         if($planInsert)
         {
            $message = "New plan added sucessfully"; 
            echo "<script>alert('$message');</script>";
            header("Location: ../index.php?plan=success"); 
         }
         else
         {
            echo mysqli_error($conn);
            header("Location: ../index.php?plan=error");

         }
     
    }
        
?>