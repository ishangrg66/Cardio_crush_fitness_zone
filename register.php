<?php
include 'dbconnection.php';
if (isset($_POST['signUp'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // Verifying unique email address
    $verify_query = mysqli_query($conn, "SELECT email FROM user_account WHERE email='$email'");
    if (mysqli_num_rows($verify_query) != 0) {
        echo "Email already exists!";
    } else {
        // Check if password and confirm password match
        if ($password !== $cpassword) {
            echo "Passwords do not match!";
        } else {
            // Hash the password before inserting it into the database
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Insert the data into the database with the hashed password
            $sql = "INSERT INTO user_account (f_name, l_name, email, phone, birthdate, password) 
                    VALUES ('$fname', '$lname', '$email', '$phone', '$dob', '$hashed_password')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                header('Location: signin.php?success=Registration successful. Please login');
                exit();
            } else {
                die("<br>Data has not been inserted due to " . mysqli_error($conn));
            }
        }
    }
}
?>
