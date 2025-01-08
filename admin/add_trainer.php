<?php
// Database connection
include "db.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate the inputs
    $trainer_name = trim($_POST['trainer_name']);
    $phone_number = trim($_POST['phone_number']);
    $address = trim($_POST['address']);
    
    if (empty($trainer_name) || empty($phone_number) || empty($address)) {
        die('All fields are required.');
    }

    // Validate phone number (check if it's 10 digits long and starts with 96, 97, or 98)
    if (!preg_match('/^(96|97|98)\d{8}$/', $phone_number)) {
        die('Please enter a valid 10-digit phone number starting with 96, 97, or 98.');
    }

    // Validate image upload
    if (isset($_FILES['image'])) {
        $image = $_FILES['image'];
        $imageName = $image['name'];
        $imageTmp = $image['tmp_name'];
        $imageSize = $image['size'];
        $imageError = $image['error'];

        // Check if file is an image
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        $imageType = mime_content_type($imageTmp);
        if (!in_array($imageType, $allowedTypes)) {
            echo '<script>alert("Invalid image type. Only JPEG, PNG, JPG allowed.");</script>';
            die();
        }

        // Check for file size (max 5MB)
        if ($imageSize > 5000000) {
            echo '<script>alert("Image size is too large. Maximum allowed size is 5MB.");</script>';
            die();
        }

        // Upload the image
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($imageName);
        if (!move_uploaded_file($imageTmp, $uploadFile)) {
            echo '<script>alert("Error uploading image.");</script>';
            die();
        }

        // Save relative path to the image for web access
        $relativePath = "admin/" . $uploadFile; // Relative path

        // Insert trainer data into the database
        $stmt = $conn->prepare("INSERT INTO trainers (trainer_name, phone_number, address, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $trainer_name, $phone_number, $address, $relativePath);
        
        if ($stmt->execute()) {
            echo '<script>alert("New trainer added successfully");</script>';
            header("Location: index.php?success=New trainer added successfully");
        } else {
            echo '<script>alert("New trainer cannot be added");</script>';
            header("Location: index.php?error=New trainer cannot be added");
        }
    } else {
        die('Image is required.');
    }
}

$conn->close();
?>
