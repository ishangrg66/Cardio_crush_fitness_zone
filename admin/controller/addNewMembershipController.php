<?php
    include_once "dbconnect.php";
    
    if(isset($_POST['member_submit']))
    {
        $member_id = $_POST['member_id'];
        $member_name = $_POST['member_name'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $query = "INSERT INTO memberships
        VALUES('$member_id', '$member_name', '$email', '$contact')";
        $memberInsert = mysqli_query($conn,$query);
 
         if($memberInsert)
         {
            $message = "New member added sucessfully"; 
            echo "<script>alert('$message');</script>";
            header("Location: ../index.php?member=success"); 
         }
         else
         {
            echo mysqli_error($conn);
            header("Location: ../index.php?member=error");

         }
     
    }
        
?>