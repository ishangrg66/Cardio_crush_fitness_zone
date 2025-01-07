<?php
include "dbconnect.php";  // Adjust the path if needed


if (isset($_POST['user_update_submit'])) {
    // Sanitize user inputs
    $first_name = mysqli_real_escape_string($conn, $_POST['f_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['l_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $contact = mysqli_real_escape_string($conn, $_POST['phone']);
    $dob = mysqli_real_escape_string($conn, $_POST['birthdate']);
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    
    // Make sure user_id is passed in the form
    if (isset($_POST['id'])) {
        $user_id = $_POST['id']; // Assuming the user_id is hidden and passed with the form.
    } else {
        // Handle error if user_id is not passed
        echo "Error: User ID is missing.";
        exit();
    }

    include "dbconnect.php";  
    
    // Prepare an update query using prepared statements
    $sql = "UPDATE user_account 
            SET f_name = ?, l_name = ?, email = ?, phone = ?, birthdate = ?, password = ? 
            WHERE id = ?";
    
    // Create a prepared statement
    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind the parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, "ssssssi", $first_name, $last_name, $email, $contact, $dob, $hashed_password, $user_id);
        
        // Execute the statement
        if (mysqli_stmt_execute($stmt)) {
            // Display success message
            $_SESSION['message'] = "User updated successfully!";
            $_SESSION['message_type'] = "success";
            header("Location: ../index.php#viewTotalRegisteredUsers.php"); // Redirect back to the main page
            exit();
        } else {
            // Display error message
            $_SESSION['message'] = "Error updating user: " . mysqli_error($conn);
            $_SESSION['message_type'] = "error";
            header("Location: ../index.php"); // Redirect back to the main page
            exit();
        }
        
        // Close the statement
        mysqli_stmt_close($stmt);
    } else {
        // Display error message for query preparation failure
        $_SESSION['message'] = "Error preparing query: " . mysqli_error($conn);
        $_SESSION['message_type'] = "error";
        header("Location: ../index.php");
        exit();
    }

    // Close the database connection
    mysqli_close($conn);
}
?>
