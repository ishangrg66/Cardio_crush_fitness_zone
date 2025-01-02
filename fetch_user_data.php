<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'cardiocrush');

if (isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];

    $query = $conn->prepare("SELECT * FROM user_account WHERE id = ?");
    $query->bind_param("i", $userId);
    $query->execute();
    $result = $query->get_result();

    $user = $result->fetch_assoc();

    $plansQuery = $conn->prepare("SELECT * FROM plans WHERE user_id = ?");
    $plansQuery->bind_param("i", $userId);
    $plansQuery->execute();
    $plansResult = $plansQuery->get_result();

    $plans = [];
    while ($plan = $plansResult->fetch_assoc()) {
        $plans[] = $plan;
    }

    echo json_encode([
        'fname' => $user['f_name'],
        'lname' => $user['l_name'],
        'email' => $user['email'],
        'phone' => $user['phone'],
        'dob' => $user['dob'],
        'plans' => $plans,
    ]);
}
?>
