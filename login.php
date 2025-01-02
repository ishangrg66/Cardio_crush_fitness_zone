<?php
session_start(); // Ensure session is started at the very beginning
include 'dbconnection.php';

if (isset($_POST['signIn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        header("Location: signin.php?error=All fields are required.");
        exit;
    }

    // First, check if the email exists in the admins table
    $check_admin_query = "SELECT * FROM admins WHERE email = ?";
    $stmt = $conn->prepare($check_admin_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
          // Admin account found, verify the password (plain text)
          $admin_account = $result->fetch_assoc();

          if ($password === $admin_account['password']) { // Plain text comparison
              // Password is correct for admin
              $_SESSION['admin_id'] = $admin_account['admin_id']; // Store only the admin id in the session
              session_regenerate_id(true); // Regenerate session ID to prevent session fixation
              header("Location: admin/index.php"); // Redirect to admin dashboard
              exit();
          } else {
              header("Location: signin.php?error=Invalid admin password.");
              exit();
          }
    } else {
        // Admin not found, check the user_account table
        $check_user_query = "SELECT * FROM user_account WHERE email = ?";
        $stmt = $conn->prepare($check_user_query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User account found, verify the password
            $user_account = $result->fetch_assoc();

            if (password_verify($password, $user_account['password'])) {
                // Password is correct for user
                $_SESSION['id'] = $user_account['id']; // Store only the user id in the session
                session_regenerate_id(true); // Regenerate session ID to prevent session fixation
                header("Location: home.php"); // Redirect to user homepage
                exit();
            } else {
                header("Location: signin.php?error=Invalid user password.");
                exit();
            }
        } else {
            // No account found with that email
            header("Location: signin.php?error=Invalid email or password.");
            exit();
        }
    }
} else {
    echo "Invalid request.";
    exit();
}
