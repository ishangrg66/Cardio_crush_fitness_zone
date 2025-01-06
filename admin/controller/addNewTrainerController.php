<?php
    include_once "dbconnect.php";
    
    if(isset($_POST['trainer_submit']))
    {
        $trainer_id = $_POST['trainer_id'];
        $trainer_name = $_POST['trainer_name'];
        $image_name = $_FILES['image']['name'];
        $image_tmp =$_FILES['image']['tmp_name'];
        move_uploaded_file($image_tmp,"images/".$image_name);
        $contact = $_POST['contact'];
        $address = $_POST['address'];

        $query = "INSERT INTO trainers
        VALUES('$trainer_id', '$trainer_name', '$image_name','$contact','$address')";
        $trainerInsert = mysqli_query($conn,$query);
 
         if($trainerInsert)
         {
            $message = "New trainer added sucessfully"; 
            echo "<script>alert('$message');</script>";
            header("Location: adminView/viewTrainers.php?trainer=success"); 
         }
         else
         {
            echo mysqli_error($conn);
            header("Location: ../index.php?trainer=error");

         }
     
    }
        
?>