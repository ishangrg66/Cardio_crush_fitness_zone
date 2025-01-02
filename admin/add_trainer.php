<?php
// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'cardiocrush';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate the inputs
    $trainer_name = trim($_POST['trainer_name']);
    $phone_number = trim($_POST['phone_number']);
    $address = trim($_POST['address']);
    
    if (empty($trainer_name) || empty($phone_number) || empty($address)) {
        die('All fields are required.');
    }

    // Validate phone number (check if it's 10 digits long and starts with 96 or 97 or 98)
    if (!preg_match('/^(96|97|98)\d{8}$/', $phone_number)) {
        die('Please enter a valid 10-digit phone number starting with 96 or 97, or 98.');
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
            die('Invalid image type. Only JPEG, PNG, JPG allowed.');
        }

        // Check for file size (max 5MB)
        if ($imageSize > 5000000) {
            die('Image size is too large. Maximum allowed size is 5MB.');
            location("header:add_trainer_form.php?error=image size is too large. Max size is 5MB");
            exit();
        }

        // Upload the image
        $uploadDir = 'uploads/';
        $uploadFile = $uploadDir . basename($imageName);
        if (!move_uploaded_file($imageTmp, $uploadFile)) {
            die('Error uploading image.');
        }

        // Save relative path to the image for web access
        $relativePath = "admin/" . $uploadFile; // Relative path

        // Insert trainer data into the database
        $stmt = $conn->prepare("INSERT INTO trainers (trainer_name, phone_number, address, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $trainer_name, $phone_number, $address, $relativePath);
        
        if ($stmt->execute()) {
            header("Location:add_trainer_form.php?success=New trainer added successfully");
        } else {
            header("Location:add_trainer_form.php?error=New trainer cannot be added");
        }
    } else {
        die('Image is required.');
    }
}

$conn->close();
?>
