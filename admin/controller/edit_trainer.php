<?php
include_once "dbconnect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $trainer_id = $_POST['trainer_id'];
    $trainer_name = htmlspecialchars($_POST['trainer_name']);
    $phone_number = htmlspecialchars($_POST['phone_number']);
    $address = htmlspecialchars($_POST['address']);

    $image = '';
    if (!empty($_FILES['image']['name'])) {
        // Define the uploads directory
        $target_dir = __DIR__ . '/uploads/';
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Create directory if it doesn't exist
        }
        // Sanitize and prepare the file name
        $imageName = preg_replace('/[^a-zA-Z0-9_\.-]/', '', basename($_FILES['image']['name']));
        $target_file = $target_dir . $imageName;

        // Check if the file is a valid image
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check === false) {
            die("Uploaded file is not a valid image.");
        }

        // Restrict file types to JPG, JPEG, and PNG
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
            die("Only JPG, JPEG, and PNG files are allowed.");
        }

        // Move the uploaded file
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            die("Failed to upload the image. Check directory existence and permissions.");
        }

        // Set the image path for storing in the database
        $image = "uploads/" . $imageName;
    }

    // Update query
    $sql = "UPDATE trainers SET trainer_name = ?, phone_number = ?, address = ?";
    $params = [$trainer_name, $phone_number, $address];

    // Include image in the update query only if a new image is uploaded
    if ($image !== '') {
        $sql .= ", image = ?";
        $params[] = $image;
    }

    $sql .= " WHERE trainer_id = ?";
    $params[] = $trainer_id;

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);

    if ($stmt->execute()) {
        echo "Trainer details updated successfully.";
    } else {
        echo "Error updating trainer details: " . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Redirect back to the main page
    header("Location: ../index.php");
    exit;
}
