<?php
include 'dbconnection.php';

$show_form = false; // Flag to control form display
$error_message = ""; // Variable to hold error messages

if (isset($_GET['token'])) {
    $token = mysqli_real_escape_string($conn, $_GET['token']);
    $current_time = time();

    // Validate token
    $query = "SELECT * FROM user_account WHERE reset_token='$token' AND token_expiry >= $current_time";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $show_form = true; // Valid token, show form
    } else {
        $error_message = "Invalid or expired token.";
    }
} else {
    $error_message = "No token provided.";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $show_form) {
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $c_password = mysqli_real_escape_string($conn, $_POST['c_password']);

    if ($password === $c_password) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Update password and clear token
        $updateQuery = "UPDATE user_account SET password='$hashed_password', reset_token=NULL, token_expiry=NULL WHERE reset_token='$token'";
        if (mysqli_query($conn, $updateQuery)) {
          echo "<script>
          alert('Password updated successfully.');
          window.location.href = 'signin.php';
        </script>";
            exit();
        } else {
            $error_message = "Error updating password.";
        }
    } else {
        $error_message = "Passwords do not match.";
    }
}
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register Page</title>
    <link
      rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Poppins"
    />
    <style>
      * {
        margin: 0;
        padding: 0;
        font-family: "Poppins", sans-serif;
        box-sizing: border-box;
      }

      body {
        margin: 0;
        padding: 0;
        min-height: 100vh;
        min-width: 100vw;
      }

      .container {
        width: 100%;
        height: 100vh;
        background-position: center;
        background-size: cover;
        display: flex;
        justify-content: center;
        align-items: center;
      }
      .error {
        color: red;
        text-align: center;
        margin-bottom: 10px;
      }

      .form-box {
        width: 90%;
        max-width: 450px;
        min-width: 300px;
        background: white;
        padding: 55px;
        text-align: center;
        border-radius: 10px;
        box-shadow: -2px 2px 15px rgba(0, 0, 0, 0.5);
      }

      .form-box h1 {
        font-size: 25px;
        color: green;
      }
      .form-box h1:hover {
        color: rgb(75, 176, 212);
        transition: 1s;
      }

      .form-box .underline {
        width: 80px;
        height: 3px;
        background-color: green;
        margin: 1px auto 40px auto;
        border-radius: 50px;
        transition: transform 0.5s;
      }
      .form-box .underline:hover {
        background-color: red;
        transition: 0.1s;
      }

      .input-field {
        background: #eaeaea;
        margin: 15px 0;
        border-radius: 10px;
        display: flex;
        align-items: center;
        max-height: 80px;
        transition: max-height 0.5s;
        overflow: hidden;
      }

      .input-field input {
        width: 100%;
        background: transparent;
        border: 0;
        outline: 0;
        padding: 10px 15px;
      }

      form p {
        text-align: left;
        font-size: 15px;
        margin: 10px 0;
      }

      form p a {
        text-decoration: none;
        color: green;
      }

      .btn-field {
        width: 100%;
        display: flex;
        justify-content: center;
        margin-top: 5px;
      }

      .btn-field button {
        width: 45%;
        background: green;
        color: white;
        height: 40px;
        border-radius: 20px;
        border: 0;
        outline: 0;
        cursor: pointer;
      }

      p {
        display: flex;
        justify-content: space-between;
      }
      span {
        height: 2rem;
        padding: 0.125vh;
        font-size: 14px;
      }
    </style>
  </head>

  <body>
    <div class="container">
        <div class="form-box">
            <?php if ($show_form): ?>
                <h1 class="title">Recover Your Account</h1>
                <form method="post">
                    <div class="input-group">
                        <div class="input-field">
                            <input type="password" name="password" placeholder="New Password" required>
                        </div>
                        <div class="input-field">
                            <input type="password" name="c_password" placeholder="Confirm Password" required>
                        </div>
                    </div>
                    <div class="btn-field">
                        <button type="submit">Reset</button>
                    </div>
                </form>
            <?php else: ?>
                <div class="error"><?php echo $error_message; ?></div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
