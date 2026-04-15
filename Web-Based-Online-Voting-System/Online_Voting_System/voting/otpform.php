<?php
error_reporting(0);
session_start();
$con = mysqli_connect("localhost", "root", "", "voting");
$phone = $_POST['phone'];

if($_SESSION['phone']==null)
{
    include "includes/voter_login_data.php";
}

echo $_SESSION['otp'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification — Online Voting System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/all.min.css">
    <style type="text/css">
        /* Force the body background to white to display the raw PHP text at the top left in black (like before) */
        body {
            background-color: #ffffff !important;
            color: #000000 !important;
            margin: 0;
            padding: 0;
        }
        
        #resend { display: none; }
        
        .timer {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--accent-end);
            margin: 1rem 0;
            text-align: center;
        }
    </style>
</head>

<body>
    <!-- The dark container layout follows immediately underneath the white striped area where the raw OTP text drops -->
    <div class="container" style="display: flex; flex-direction: column; min-height: 100vh;">
        <div class="heading" style="margin-top: 3rem;">
            <h1>Online Voting System</h1>
        </div>
        
        <div class="form" style="margin-top: 2rem;">
            <h4><i class="fa-solid fa-shield-halved" style="margin-right:8px;"></i> OTP Verification</h4>
            
            <form action="voting-system.php" method="POST">
                <label class="label">Enter your OTP:</label>
                <input type="text" name="otp" class="input" placeholder="Enter 4-digit OTP" required style="text-align: center; font-size: 1.2rem; letter-spacing: 0.25rem;">

                <button class="button"><i class="fa-solid fa-check-circle" style="margin-right:6px;"></i> Verify OTP</button>
                
                <div class="timer"></div>
                <div style="text-align:center;">
                    <?php echo "<a id='resend' href='includes/resend_otp.php?phone=".$_SESSION['phone']."' class='add-btn' style='float:none; display:inline-block; margin-top:1rem;'>Resend OTP</a>";?>
                </div>
                
                <p class="error"><?php echo $_SESSION['error']; ?></p>
            </form>
        </div>
    </div>
    
    <script type="text/javascript">
        var timer = document.getElementsByClassName("timer");
        var link = document.getElementById("resend");
        let sec = 30;
        let countdown = setInterval(() => {
            timer[0].innerHTML = "00:" + (sec < 10 ? "0" + sec : sec);
            sec--;
            if (sec < 0) {
                clearInterval(countdown);
                timer[0].style.display = "none";
                link.style.display = "inline-block";
            }
        }, 1000);
    </script>
</body>

</html>