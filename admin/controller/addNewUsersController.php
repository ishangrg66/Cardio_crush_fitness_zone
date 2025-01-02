<?php
    include_once "dbconnect.php";
    
    if(isset($_POST['user_submit']))
    {
        $user_id = $_POST['id'];
        $first_name = $_POST['f_name'];
        $last_name = $_POST['l_name'];
        $email = $_POST['email'];
        $contact = $_POST['phone'];
        $date_of_birth = $_POST['birthdate'];
        $password = $_POST['password'];
        $query = "INSERT INTO user_account
        VALUES('$user_id', '$first_name', '$last_name', '$email', '$contact', '$date_of_birth', '$password')";
        $userInsert = mysqli_query($conn,$query);
 
         if($userInsert)
         {
            $message = "New user added sucessfully"; 
            echo "<script>alert('$message');</script>";
            header("Location: adminView/viewTotalRegisteredUsers.php?success=New user added"); 
            exit();
         }
         else
         {
            echo mysqli_error($conn);
            header("Location: ../index.php?user=error");

         }
     
    }
        
?>