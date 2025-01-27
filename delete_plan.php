<?php
session_start();
include('dbconnection.php');

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Delete the user's current membership
    $delete_query = "DELETE FROM memberships WHERE id = ? AND end_date >= CURDATE()";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        header("Location: profile.php?message=Membership deleted successfully.");
        exit();
    } else {
        $error = "Error deleting membership. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Membership</title>
</head>

<body>
    <h2>Delete Membership</h2>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
    <form method="POST">
        <p>Are you sure you want to delete your current membership?</p>
        <button type="submit">Yes, Delete Membership</button>
        <a href="profile.php">Cancel</a>
    </form>
</body>

</html>