<?php
include 'db.php';

if (isset($_POST['adminSignIn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email exists
    $check_email_query = "SELECT * FROM admins WHERE email = ?";
    $stmt = $conn->prepare($check_email_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        // Verify the password
        if($password === $admin['password']) {
            // Start a session and redirect to index.php
            session_start();
            $_SESSION['admin_id'] = $admin['id']; // Store admin ID in session
            $_SESSION['admin_email'] = $admin['email']; // Optionally store the email
            header("Location: ../admin/index.php");
            exit();
        } else {
            // Pass error message through the session or redirect back
            $_SESSION['error_message'] = "Login failed: The email or password you entered is incorrect. Please try again.";
            header("Location: ../admin/admin_signin.php");
            exit();
        }
    } else {
        // Pass error message through the session or redirect back
        $_SESSION['error_message'] = "Login failed: No account found with the entered email. Please check your email and try again.";
        header("Location: ../admin/admin_signin.php");
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}
?>
