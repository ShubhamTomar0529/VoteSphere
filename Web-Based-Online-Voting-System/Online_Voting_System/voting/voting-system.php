<?php
error_reporting(0);
session_start();

$otp = $_POST['otp'];
if(isset($_POST['otp'])){
    if ((int)$_SESSION['otp'] == (int)$otp) 
    {
        $_SESSION['userLogin'] = 1;
    } 
    else 
    {
        $_SESSION['error']="Wrong OTP Enter";
        header("location:otpform.php");
        exit();
    }
}

if ($_SESSION['phone'] == null) {
    header("location:index.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Voting System - Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/all.min.css">
</head>

<body style="margin:0; padding:0;">
    <?php include "includes/navbar.php"; ?>
    <div class="container" style="margin-top: 2rem;">
        
        <div class="main" style="text-align: center; padding: 3rem;">
            <div class="dp" style="margin: 0 auto 1rem; width:100px; height:100px; border-radius:50%; overflow:hidden;"><img src="<?php echo $_SESSION['idcard']; ?>" alt="" style="width:100%; height:100%; object-fit: cover;"></div>
            <h1 class="heading">Welcome <?php echo $_SESSION['fname'] . " " . $_SESSION['lname']; ?>!</h1>
            <p>You have successfully logged in to the Online Voting System.</p>

            <div class="box" style="display: block; margin-top: 2rem;">
                <h4 class="heading">Ready to view your ballot?</h4>
                <div class="link1"><a href="ballet.php?start=1" style="font-size: 1.2rem; padding: 10px 30px;">Proceed to Voting Page</a></div>
            </div>
        </div>

    </div>
    
    <script>
        // logout user after 5 minutes of inactivity if they sit on this screen
        setTimeout(() => {
            location.replace("includes/user-logout.php");
        }, 300000);
    </script>
</body>

</html>