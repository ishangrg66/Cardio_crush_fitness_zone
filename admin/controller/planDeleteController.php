<?php

include_once "dbconnect.php";

$plan_id=$_POST['record'];
$query="DELETE FROM plans where plans_id='$plan_id'";

$data=mysqli_query($conn,$query);

if($data){
    echo"Plan Deleted";
}
else{
    echo"Not able to delete";
}

?>