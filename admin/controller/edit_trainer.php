<?php
include_once "dbconnect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $trainer_id = $_POST['trainer_id'];
    $trainer_name = htmlspecialchars($_POST['trainer_name']);
    $phone_number = htmlspecialchars($_POST['phone_number']);
    $address = htmlspecialchars($_POST['address']);

    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['image']['name']);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is an image
        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check === false) {
            die("File is not an image.");
        }

        // Allow certain file formats
        if (!in_array($imageFileType, ['jpg', 'png', 'jpeg'])) {
            die("Only JPG, JPEG, and PNG files are allowed.");
        }

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            die("There was an error uploading the file.");
        }
        $image = $target_file;
    }

    $sql = "UPDATE trainers SET trainer_name = ?, phone_number = ?, address = ?";
    $params = [$trainer_name, $phone_number, $address];

    if ($image !== '') {
        $sql .= ", image = ?";
        $params[] = $image;
    }

    $sql .= " WHERE trainer_id = ?";
    $params[] = $trainer_id;

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);

    if ($stmt->execute()) {
        echo "Trainer details updated successfully.";
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: ../index.php");
    exit;
}
?>
