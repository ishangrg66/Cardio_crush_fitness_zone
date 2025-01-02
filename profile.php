<?php
session_start();  // Make sure session is started

// Check if the session 'id' exists to ensure the user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

include('dbconnection.php'); // this file connects to the database

$user_id = $_SESSION['id']; // Safe to use since we've checked if it's set

// Fetch user details from the database
$query = "SELECT * FROM user_account WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Fetch current membership details for the user
$membership_query = "SELECT * FROM memberships WHERE id = ? AND end_date >= CURDATE() ORDER BY start_date DESC LIMIT 1";
$membership_stmt = $conn->prepare($membership_query);
$membership_stmt->bind_param("i", $user_id);
$membership_stmt->execute();
$membership_result = $membership_stmt->get_result();
$current_membership = $membership_result->fetch_assoc();

// Calculate membership status (active, expired, or pending)
$membership_status = '';
if ($current_membership) {
    $current_membership_end = new DateTime($current_membership['end_date']);
    $current_date = new DateTime();
    
    // Check if the payment is verified (assuming 'status' is a boolean or a specific string like 'verified')
    if ($current_membership['status'] === 'verified' || $current_membership['status'] === true) {
        // Payment is verified, now check if the membership is still active
        if ($current_date <= $current_membership_end) {
            $membership_status = 'Active';
        } else {
            $membership_status = 'Expired';
        }
    } else {
        // Payment is not verified
        $membership_status = 'Pending Verification';
    }
}



// Check if the form to update user details is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    // Get the updated phone number and date of birth from the form
    $new_phone = $_POST['phone'];
    $new_birthdate = $_POST['birthdate'];

    // Update the user's details in the database
    $update_query = "UPDATE user_account SET phone = ?, birthdate = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ssi", $new_phone, $new_birthdate, $user_id);
    
    if ($update_stmt->execute()) {
        // If the update was successful, reload the page to reflect the changes
        header("Location: profile.php");
        exit();
    } else {
        // If the update failed, show an error message
        $error_message = "Error updating details. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <style>
/* General Reset and Layout */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f4;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

.profile-container {
    width: 100%;
    max-width: 600px; /* Set a max-width for the form */
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    margin: 20px;
}

h2 {
    font-size: 24px;
    color: #333;
    margin-bottom: 15px;
    text-align: center;
    font-weight: bold;
}

.user-details,
.current-membership {
    margin-bottom: 20px;
}

.user-details p,
.current-membership p {
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 8px;
}

strong {
    color: #2c3e50;
}

/* Editable Fields Styling */
.editable {
    display: none;
}

input[type="text"],
input[type="date"] {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-top: 8px;
    margin-bottom: 12px;
}

input[type="text"]:focus,
input[type="date"]:focus {
    border-color: #3498db;
    outline: none;
}

/* Edit Button Styling */
button[type="button"] {
    background-color: #3498db;
    color: #fff;
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    margin-top: 5px;
}

button[type="button"]:hover {
    background-color: #2980b9;
}

button[type="submit"] {
    background-color: #27ae60;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    display: none;
    margin-top: 12px;
}

button[type="submit"]:hover {
    background-color: #2ecc71;
}

button[type="submit"]:active {
    background-color: #27ae60;
}

/* Form Container Styling */
form {
    margin-top: 20px;
}

form div {
    margin-bottom: 20px;
}

form div:last-child {
    margin-bottom: 0;
}

/* Profile Section Styling */
.profile-container h2 {
    text-align: center;
    color: #2c3e50;
    margin-bottom: 20px;
}

.profile-container .user-details p,
.profile-container .current-membership p {
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 12px;
}

/* Error Message Styling */
p[style="color:red;"] {
    color: red;
    font-size: 14px;
    margin-top: 10px;
    text-align: center;
}

    </style>
</head>
<body>
    
    <div class="profile-container">
        <!-- User Details Section -->
        <div class="user-details">
            <h2>User Details</h2>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['f_name'] . " " . $user['l_name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            
            <!-- Phone and Birthdate Fields with Edit Button -->
            <form method="POST" action="profile.php">
                <div>
                    <strong>Phone:</strong> 
                    <span id="phoneDisplay"><?php echo htmlspecialchars($user['phone']); ?></span>
                    <input type="text" id="phoneInput" class="editable" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                    <button type="button" onclick="editField('phone')">Edit</button>
                </div>
                <div>
                    <strong>Birthdate:</strong> 
                    <span id="birthdateDisplay"><?php echo htmlspecialchars($user['birthdate']); ?></span>
                    <input type="date" id="birthdateInput" class="editable" name="birthdate" value="<?php echo htmlspecialchars($user['birthdate']); ?>" required>
                    <button type="button" onclick="editField('birthdate')">Edit</button>
                </div>
                <!-- Save Changes -->
                <button type="submit" name="update" class="editable">Save Changes</button>
            </form>

            <!-- Error Message -->
            <?php if (isset($error_message)): ?>
                <p style="color:red;"><?php echo $error_message; ?></p>
            <?php endif; ?>
        </div>

        <!-- Current Membership Section -->
        <div class="current-membership">
            <h2>Current Membership</h2>
            <?php if ($current_membership): ?>
                <?php
                // Assuming $current_membership['plans_id'] contains the plans_id from the current membership
                $plans_id = $current_membership['plans_id'];

                // Query to fetch the plan name from the plans table
                $query = $conn->prepare("SELECT plan_name FROM plans WHERE plans_id = ?");
                $query->bind_param("i", $plans_id);
                $query->execute();
                $query->bind_result($plan_name);
                $query->fetch();
                $query->close();
                ?>

                <p><strong>Plan Name:</strong> <?php echo htmlspecialchars($plan_name); ?></p>               
                <p><strong>Start Date:</strong> <?php echo htmlspecialchars($current_membership['start_date']); ?></p>
                <p><strong>End Date:</strong> <?php echo htmlspecialchars($current_membership['end_date']); ?></p>
                <p><strong>Status:</strong> <?php echo $membership_status; ?></p>
            <?php else: ?>
                <p>You have no active memberships.</p>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Function to toggle the editable fields
        function editField(field) {
            const displayElement = document.getElementById(field + 'Display');
            const inputElement = document.getElementById(field + 'Input');
            const buttonElement = inputElement.nextElementSibling;
            const saveButton = document.querySelector('button[type="submit"]');

            if (inputElement.classList.contains('editable')) {
                displayElement.style.display = 'none';
                inputElement.style.display = 'inline-block';
                buttonElement.style.display = 'inline-block';
                saveButton.style.display = 'inline-block';
            }
        }
    </script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
