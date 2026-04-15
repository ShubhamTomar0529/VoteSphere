<?php
include __DIR__ . "/../../../config.php";
?>  
<?php
error_reporting(0);
date_default_timezone_set('Asia/Kolkata');
$con = mysqli_connect("localhost","root","","voting");

// candidate data
$can_query="SELECT candidate.*, can_position.position_name FROM candidate LEFT JOIN can_position ON candidate.position_id = can_position.id";
$can_data=mysqli_query($con,$can_query);
$_SESSION["total_cand"]=mysqli_num_rows($can_data);
$total_cand=mysqli_num_rows($can_data);

// user register data
$voter_query="SELECT * FROM register";
$voter_data=mysqli_query($con,$voter_query);
$_SESSION["total_voters"]=mysqli_num_rows($voter_data);

// candidate position data
$pos_query="SELECT * FROM can_position";
$pos_data=mysqli_query($con,$pos_query);
$_SESSION["total_position"]=mysqli_num_rows($pos_data);
$total_pos=mysqli_num_rows($pos_data);

?>