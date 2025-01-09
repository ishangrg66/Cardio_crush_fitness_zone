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
        echo "<script>
                    alert('Email already exists.');
                    window.location.href='signup.php';
                </script>";
                exit();
    } else {
        // Check if password and confirm password match
        if ($password !== $cpassword) {
            echo "<script>alert('Passwords do not match!');</script>";
        } else {
            // Hash the password before inserting it into the database
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            // Insert the data into the database with the hashed password
            $sql = "INSERT INTO user_account (f_name, l_name, email, phone, birthdate, password) 
                    VALUES ('$fname', '$lname', '$email', '$phone', '$dob', '$hashed_password')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "<script>
                    alert('Registration successful. Please login.');
                    window.location.href='signin.php';
                </script>";
                exit();
            } else {
                echo "<script>alert('Data insertion failed: " . mysqli_error($conn) . "');</script>";
            }
        }
    }
}
?>
