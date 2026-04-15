
<?php
session_start();
error_reporting(0);
if(isset($_SESSION['userLogin']) && $_SESSION['userLogin'] == 1){
    header("location:voting-system.php");
    exit();
}
if(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] == 1){
    header("location:admin/admin-panel.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Voting System</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/all.min.css">
</head>

<body style="margin:0; padding:0;">
    <?php include "includes/navbar.php"; ?>

    <div class="container">
        <div class="heading">
            <h1>Online Voting System</h1>
        </div>
        <div class="form">
            <h4>Voter Login</h4>
            <form action="otpform.php" method="POST">
                <label class="label">Phone Number:</label>
                <input type="text" name="phone" id="" class="input" placeholder="Enter Phone Number" required>

                <button class="button" name="login">Login</button>
                <div class="link1">New user ? <a href="registration.php">Register here</a></div>
                <div class="link1">Change Mobile Number ? <a href="lost_phone.php">Send Request</a></div>
            </form>
            <p class="error"><?php echo $_SESSION['error']; ?></p>
        </div>

    </div>
</body>
</html>