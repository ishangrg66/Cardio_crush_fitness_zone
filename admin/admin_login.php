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

    // $_COOKIE(username)

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        // Verify the password
        if($password === $admin['password']) {
            // Start a session and redirect to index.php
            session_start();
            $_SESSION['admin_id'] = $admin; // Store admin info in the session
            header("Location: ../admin/index.php");
            exit();
        } else {
            echo "Login unsuccessful: Incorrect email or password.";
            exit();
        }
    } else {
        echo "Login unsuccessful: Credentials did not match.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}
?>
