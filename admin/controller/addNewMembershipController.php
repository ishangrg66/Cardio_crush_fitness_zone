<?php
    include_once "dbconnect.php";
    
    if(isset($_POST['member_submit']))
    {
        $f_id = $_POST['f_name'];
        $l_name = $_POST['l_name'];
        $email = $_POST['email'];
        $contact = $_POST['phone'];
        $dob = $_POST['birthdate'];
        $query = "INSERT INTO user_account
        VALUES('$f_id', '$l_name', '$email', '$contact', '$dob')";
        $memberInsert = mysqli_query($conn,$query);
         if($memberInsert)
         {
            $message = "New member added sucessfully"; 
            echo "<script>alert('$message');</script>";
            header("Location: ../index.php?member=success"); 
         }else
         {
            echo mysqli_error($conn);
            header("Location: ../index.php?member=error");
            exit();
         }
     
    }
        
?>