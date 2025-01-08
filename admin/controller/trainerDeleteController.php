<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'dbconnect.php'; // Include database connection

    $trainer_id = intval($_POST['trainer_id']);
    
    // SQL query to delete the trainer
    $sql = "DELETE FROM trainers WHERE trainer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $trainer_id);

    if ($stmt->execute()) {
        echo '<script>alert("Trainer deleted successfully");</script>';
        header("Location: ../index.php");
    } else {
        echo '<script>alert("Error deleting trainer");</script>';
        header("Location: ../index.php?error=Error deleting trainer");
    }

    $stmt->close();
    $conn->close();
}
?>
