<?php

if(isset($_POST['plan_submit'])){
    $plan_id = $_POST['plans_id'];
    $plan_name = $_POST['plan_name'];
    $plan_price = $_POST['price'];
    $plan_validity = $_POST['plan_validity'];
}

include_once "db.php";
$sql = "UPDATE plans
SET plan_id = '$plan_id', plan_name = '$plan_name', plan_price = '$plan_price', plan_validity = '$plan_validity'
WHERE plan_id = '$plan_id'";
$result = mysqli_query($conn, $sql);
if($result){
    echo "Plan Updated.";
};

?>