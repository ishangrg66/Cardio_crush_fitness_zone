<?php
include('dbconnection.php');
session_start();
error_log('Session ID: ' . $_SESSION['id']);
error_log('POST data: ' . print_r($_POST, true));
error_log('File data: ' . print_r($_FILES, true));

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['buy_plan'])) {
    $user_id = $_SESSION['id'];  // Assuming the user is logged in
    if (!$user_id) {
        echo "<script>alert('User not logged in.'); window.history.back();</script>";
        exit;
    }

    $plan_id = $_POST['plans_id'];
    $start_date = $_POST['start_date'];

    error_log('Plans ID: ' . $_POST['plans_id']);
    error_log('Start Date: ' . $_POST['start_date']);

    // Check if the selected plan exists in the 'plans' table
    $plan_check_query = $conn->prepare("SELECT COUNT(*) FROM plans WHERE plans_id = ?");
    $plan_check_query->bind_param("i", $plan_id);
    $plan_check_query->execute();
    $plan_check_query->bind_result($plan_exists);
    $plan_check_query->fetch();
    $plan_check_query->close();  // Close the result set

    if ($plan_exists == 0) {
        echo "<script>alert('Invalid plan selected.'); window.history.back();</script>";
        exit;
    }

    // Fetch plan details including price
    $plan_query = $conn->prepare("SELECT plans_id, plan_name, price, duration FROM plans WHERE plans_id = ?");
    $plan_query->bind_param("i", $plan_id);
    $plan_query->execute();
    $plan_result = $plan_query->get_result();

    if ($plan_result->num_rows > 0) {
        $plan = $plan_result->fetch_assoc();
        $price = $plan['price'];  // Get the price from the selected plan
        $duration = $plan['duration'];

        // Calculate the end date based on the duration and start date
        $end_date = date('Y-m-d', strtotime("+$duration months", strtotime($start_date)));
       
        // Handle file upload (payment proof)
        if (isset($_FILES["payment_proof"])) {
            $file_error = $_FILES["payment_proof"]["error"];
            
            if ($file_error != UPLOAD_ERR_OK) {
                $error_message = '';
                switch ($file_error) {
                    case UPLOAD_ERR_INI_SIZE:
                        $error_message = "The uploaded file exceeds the upload_max_filesize directive in php.ini.";
                        break;
                    case UPLOAD_ERR_FORM_SIZE:
                        $error_message = "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.";
                        break;
                    case UPLOAD_ERR_PARTIAL:
                        $error_message = "The uploaded file was only partially uploaded.";
                        break;
                    case UPLOAD_ERR_NO_FILE:
                        $error_message = "No file was uploaded.";
                        break;
                    case UPLOAD_ERR_NO_TMP_DIR:
                        $error_message = "Missing a temporary folder.";
                        break;
                    case UPLOAD_ERR_CANT_WRITE:
                        $error_message = "Failed to write file to disk.";
                        break;
                    case UPLOAD_ERR_EXTENSION:
                        $error_message = "A PHP extension stopped the file upload.";
                        break;
                    default:
                        $error_message = "Unknown upload error.";
                        break;
                }
                echo "<script>alert('File upload error: $error_message'); window.history.back();</script>";
                exit;
            } else {
                // File upload is successful, proceed with the code
                $target_dir = $_SERVER['DOCUMENT_ROOT'] . "/cardiocrush-master/admin/payment_proofs/";
                $payment_proof = $target_dir . basename($_FILES["payment_proof"]["name"]);
                
                // Log the target path to verify it's correct
                error_log('Target Directory: ' . $target_dir);
                error_log('Payment Proof Path: ' . $payment_proof);

                if (move_uploaded_file($_FILES["payment_proof"]["tmp_name"], $payment_proof)) {
                    // Insert membership record into memberships table
                    $membership_query = $conn->prepare(
                        "INSERT INTO memberships (id, plans_id, start_date, end_date, status, payment_status, payment_proof) 
                        VALUES (?, ?, ?, ?, 'inactive', 'pending', ?)");
                     $membership_query->bind_param("iisss", $user_id, $plan_id, $start_date, $end_date, $payment_proof);


                    if ($membership_query->execute()) {
                        $membership_id = $conn->insert_id;  // Get the inserted membership ID

                        // Now insert the payment record into payments table
                        $payment_query = $conn->prepare(
                            "INSERT INTO payments (membership_id, amount, payment_proof) VALUES (?, ?, ?)"
                        );
                        $payment_query->bind_param("ids", $membership_id, $price, $payment_proof);

                        if ($payment_query->execute()) {
                            // Get the payment_id from the insert query
                             $payment_id = $conn->insert_id;
                            // Redirect to home page after successful payment submission
                            echo "<script>alert('Payment submitted successfully. Awaiting admin verification.'); window.location.href='home.php';</script>";
                        } else {
                            echo "<script>alert('Failed to record payment. Try again.'); window.history.back();</script>";
                        }
                    } else {
                        echo "<script>alert('Failed to create membership. Try again.'); window.history.back();</script>";
                    }
                } else {
                    echo "<script>alert('Failed to move uploaded file.'); window.history.back();</script>";
                    exit;
                }
            }
        } else {
            echo "<script>alert('No file uploaded.'); window.history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('Plan details not found.'); window.history.back();</script>";
        exit;
    }
}
?>
