<?php
    include_once "dbconnect.php";

        $user_id = $_POST['record'];
        $first_name = $_POST['record'];
        $middle_name = $_POST['record'];
        $last_name = $_POST['record'];
        $email = $_POST['record'];
        $contact = $_POST['record'];
        $date_of_birth = $_POST['record'];
        $password = $_POST['record'];
      
    $query = "UPDATE user_account
    SET id = '$user_id', f_name = '$first_name', l_name = '$last_name', email = '$email', phone = '$contact' birthdate = '$date_of_birth', password = '$password'
    WHERE id = '$user_id'";

    $updateUser = mysqli_query($conn,$query);

    if($updateUser){
        echo"User Updated";
    }
    else{
        echo"Not able to update";
    }
?>