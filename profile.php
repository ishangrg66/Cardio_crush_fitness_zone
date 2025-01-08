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

// Calculate membership status (active, expired, pending admin verification)
$membership_status = '';
if ($current_membership) {
    $current_membership_end = new DateTime($current_membership['end_date']);
    $current_date = new DateTime();

    // Check if the membership is active, expired, or pending admin verification
    if ($current_membership['status'] === 'active') {
        // Membership is active
        if ($current_date <= $current_membership_end) {
            $membership_status = 'Active';
        } else {
            $membership_status = 'Expired';
        }
    } elseif ($current_membership['status'] === 'pending verification') {
        // Membership is pending admin verification
        $membership_status = 'Pending Admin Verification';
    } else {
        // Membership is expired
        $membership_status = 'Inactive. Wait for admin verification';
    }
} else {
    $membership_status = 'No active membership';
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
    <!-- Styling-->
    <!-- <link rel="stylesheet" href="css/style.css" /> -->

    <!-- FavIcon -->
    <link rel="shortcut icon" href="image/workout (1).png" />

    <!-- RemixIcon -->
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <link
      rel="stylesheet"
      href="https://use.fontawesome.com/releases/v5.15.4/css/all.css"
    />
    <link rel="stylesheet" href="./css/Timetable.css" />
    <title>My Profile</title>
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color:rgb(27, 29, 30);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .profile-container {
            background:rgb(74, 70, 70);
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 600px;
            padding: 20px;
        }

        h2 {
            margin-bottom: 20px;
            color: rgb(255, 255, 255);
            font-size: 26px;
            text-align: center;
            border-bottom: 2px solid hsl(32, 93%, 65%);
            display: inline-block;
            padding-bottom: 5px;
        }

        p {
            font-size: 20px;
            margin: 10px 0;
            color: hsl(17, 92%, 74%);
        }

        strong {
            color: white;
        }

        form {
            margin-top: 15px;
        }

        .editable {
            display: none;
            width: 40%;
            align-items: center
            margin-top: 5px;
            padding: 8px;
            font-size: 14px;
            /* border: 1px solid #ccc; */
            /* border-radius: 5px; */
            outline: none;
            transition: border 0.3s ease;
        }

        /* .editable:focus {
            border: 1px solid #00bcd4;
        } */

        button {
            background-color: hsl(0, 95%, 50%);
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 8px 12px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #008c9e;
        }

        button[type="button"] {
            background-color:rgb(247, 29, 29);
            color: #333;
            text: bold;
            border: 1px solid rgb(247, 29, 29);
            padding: 5px 10px;
            font-size: 12px;
        }

        button[type="button"]:hover {
            background-color: transparent;
            border: 1px solid hsl(32, 93%, 65%); 
            color: white;
        }

        button[type="submit"] {
            display: none;
            margin-top: 20px;
            width: 100%;
        }

        #phoneError, #birthdateError {
            color: red;
            font-size: 14px;
            margin-top: 5px;
            display: none;
        }

        /* Current Membership Section */
        .current-membership {
            margin-top: 30px;
        }

        .current-membership p {
            font-size: 16px;
        }

/* Navigation Bar Styles */
/* General Styling
body {
    margin: 0;
    font-family: 'Arial', sans-serif;
    background-color: #f4f7f9;
} */

.header {
    width: 100%;
    background-color:transparent;
    position: fixed;
    padding: 15px 0;
    top: 0px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    max-width: 1500px;
    margin: 0 auto;
    padding: 0 20px;
}

.nav__logo {
    display: flex;
    align-items: center;
    color: #fff;
    font-size: 20px;
    text-decoration: none;
    font-weight: bold;
}

.nav__logo img {
    width: 40px;
    margin-right: 10px;
}

.nav__menu {
    display: flex;
    align-items: center;
}

.nav__list {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
}

.nav__item {
    margin: 0 20px;
}

.nav__link {
    color: #fff;
    text-decoration: none;
    font-size: 16px;
    padding: 8px 15px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.nav__link:hover,
.nav__link.active-link {
    background-color: #008c9e;
}

.nav__toggle {
    display: none;
    font-size: 30px;
    color: #fff;
    cursor: pointer;
}

.nav__close {
    display: none;
}

/* Mobile View */
@media (max-width: 768px) {
    .nav__menu {
        position: fixed;
        top: 0;
        left: -100%;
        height: 100%;
        background-color: #00bcd4;
        width: 250px;
        flex-direction: column;
        justify-content: space-between;
        padding: 20px;
        transition: 0.3s ease;
    }

    .nav__menu.active {
        left: 0;
    }

    .nav__list {
        flex-direction: column;
        margin-top: 50px;
    }

    .nav__item {
        margin: 15px 0;
    }

    .nav__toggle {
        display: block;
    }

    .nav__close {
        position: absolute;
        display: block;
        top:0.5rem;
        right:1.5rem;
        font-size: 30px;
        color: hsl(0, 95%, 50%);
        cursor: pointer;
    }
}

        /* Responsive Design */
        @media (max-width: 768px) {
            .profile-container {
                width: 100%;
                padding: 15px;
            }

            h2 {
                font-size: 20px;
            }

            p {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
 <!--------------- Header ----------------------->

 <div class="header" id="header">
      <nav class="nav container">
        <a href="#" class="nav__logo">
          <img src="image/workout (1).png" alt="logo" />
          𝐂𝐚𝐫𝐝𝐢𝐨 𝐂𝐫𝐮𝐬𝐡
        </a>

        <div class="nav__menu" id="nav-menu">
          <ul class="nav__list">
            <li class="nav__item">
              <a href="home.php" class="nav__link ">Home</a>
            </li>
            <li class="nav__item">
              <a href="profile.php" class="nav__link active-link">My Profile</a>
            </li>
            <li class="nav__item">
              <a href="logout.php" class="nav__link">Logout</a>
            </li>
          </ul>
          <div class="nav__close" id="nav-close">
            <i class="ri-close-line"></i>
          </div>
        </div>
        <!-- Toggle button -->
        <div class="nav__toggle" id="nav-toggle">
          <i class="ri-menu-fill"></i>
        </div>
      </nav>
    </div>
    <div class="profile-container">
        <!-- User Details Section -->
        <div class="user-details">
            <h2>User Details</h2>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['f_name'] . " " . $user['l_name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>

            <!-- Phone and Birthdate Fields with Edit Button -->
            <form method="POST" action="profile.php" onsubmit="return validateForm()">
                <div>
                    <strong>Phone:</strong>
                    <span id="phoneDisplay"><?php echo htmlspecialchars($user['phone']); ?></span>
                    <input type="text" id="phoneInput" class="editable" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                    <button type="button" onclick="editField('phone')">Edit</button>
                </div>
                <p id="phoneError">Phone number must start with 96, 97, or 98 and be 10 digits long.</p>

                <div>
                    <strong>Birthdate:</strong>
                    <span id="birthdateDisplay"><?php echo htmlspecialchars($user['birthdate']); ?></span>
                    <input type="date" id="birthdateInput" class="editable" name="birthdate" value="<?php echo htmlspecialchars($user['birthdate']); ?>" required>
                    <button type="button" onclick="editField('birthdate')">Edit</button>
                </div>
                <p id="birthdateError">Birthdate must be at least 10 years in the past.</p>

                <!-- Save Changes -->
                <button type="submit" id="saveChanges" name="update">Save Changes</button>
            </form>
        </div>

        <!-- Current Membership Section -->
        <div class="current-membership">
            <h2>Current Membership</h2>
            <?php if ($current_membership): ?>
                <?php
                $plans_id = $current_membership['plans_id'];
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
        function editField(field) {
            const displayElement = document.getElementById(field + 'Display');
            const inputElement = document.getElementById(field + 'Input');
            const saveButton = document.getElementById('saveChanges');

            displayElement.style.display = 'none';
            inputElement.style.display = 'inline-block';
            saveButton.style.display = 'block'; // Show save changes button when any field is edited
        }

        function validateForm() {
            // Phone Validation
            const phoneInput = document.getElementById('phoneInput');
            const phoneError = document.getElementById('phoneError');
            const phoneRegex = /^(96|97|98)\d{8}$/;

            if (!phoneRegex.test(phoneInput.value)) {
                phoneError.style.display = 'block';
                return false;
            } else {
                phoneError.style.display = 'none';
            }

            // Birthdate Validation
            const birthdateInput = document.getElementById('birthdateInput');
            const birthdateError = document.getElementById('birthdateError');
            const selectedDate = new Date(birthdateInput.value);
            const today = new Date();
            const tenYearsAgo = new Date(today.getFullYear() - 10, today.getMonth(), today.getDate());

            if (selectedDate > today || selectedDate > tenYearsAgo) {
                birthdateError.style.display = 'block';
                return false;
            } else {
                birthdateError.style.display = 'none';
            }

            return true;
        }

        document.addEventListener('DOMContentLoaded', () => {
            const birthdateInput = document.getElementById('birthdateInput');
            const today = new Date();
            const maxDate = new Date(today.getFullYear() - 10, today.getMonth(), today.getDate());
            birthdateInput.max = maxDate.toISOString().split('T')[0];
        });

        document.getElementById('nav-toggle').addEventListener('click', function () {
    document.getElementById('nav-menu').classList.add('active');
});

document.getElementById('nav-close').addEventListener('click', function () {
    document.getElementById('nav-menu').classList.remove('active');
});
    </script>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
