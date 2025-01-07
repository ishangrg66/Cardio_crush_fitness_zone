<?php
    include_once "dbconnect.php";
    
    if(isset($_POST['user_submit']))
    {
      //   $user_id = $_POST['id'];
        $first_name = $_POST['f_name'];
        $last_name = $_POST['l_name'];
        $email = $_POST['email'];
        $contact = $_POST['phone'];
        $date_of_birth = $_POST['birthdate'];
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO user_account (f_name, l_name, email, phone, birthdate, password)
        VALUES('$first_name', '$last_name', '$email', '$contact', '$date_of_birth', '$hashed_password')";
        $userInsert = mysqli_query($conn,$query);
 
         if($userInsert)
         { 
           // Redirect back to the same form with a success message
         header("Location: ../index.php?success=New user added");
         exit();
          } else {
         // Redirect back to the same form with an error message
          header("Location: ../index.php ?error= Error adding new user ");
         exit();
    }
}
        
?>