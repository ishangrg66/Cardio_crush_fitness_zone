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
            error_log("Password verification failed for email: $email");
            header("Location: signin.php?error=Invalid user password.");
            exit();
        }
    } else {
        // No account found with that email
        error_log("No account found for email: $email");
        header("Location: signin.php?error=Invalid email or password.");
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}
