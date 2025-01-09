<?php
include 'dbconnection.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// Load Composer's autoloader
require 'vendor/autoload.php';

if(isset($_POST['sendmail'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $emailquery = "SELECT * FROM user_account WHERE email='$email'";
    $query = mysqli_query($conn, $emailquery);

    $emailcount = mysqli_num_rows($query);

    if($emailcount > 0){
        $token = bin2hex(random_bytes(16));
        $expiry = time() + 120; // Token valid for 2 minutes

        // Update the reset token and expiry in the user_account table
        $updateTokenQuery = "UPDATE user_account SET reset_token='$token', token_expiry='$expiry' WHERE email='$email'";
        mysqli_query($conn, $updateTokenQuery);

        $reset_link = "http://localhost/cardiocrush-master/reset_password.php?token=$token";

        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'scilentknight512@gmail.com';
            $mail->Password   = 'baac alwo thsc utlp';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;

            // Recipients
            $mail->setFrom('scilentknight512@gmail.com', 'No-reply');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Reset Password';
            $mail->Body    = "Click <a href='$reset_link'>here</a> to reset your password.";
            $mail->AltBody = "Copy and paste this link in your browser to reset your password: $reset_link";

            $mail->send();
            echo "<script>alert('Message has been sent');
                            window.location.href = 'reset_password.php'</script>";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "No user found with this email.";
    }
}
?>
