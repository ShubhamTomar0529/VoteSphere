<?php
include "../../../config.php";
?>  
<?php
    session_start();
    error_reporting(0);
    $_SESSION["adminLogin"]=0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin Login — Online Voting System. Secure administrative access.">
    <title>Admin Login — Online Voting System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <style>
        .admin-login-wrapper {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .admin-login-wrapper .form {
            margin-bottom: 2rem;
        }

        .admin-login-icon {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent-start), var(--accent-end));
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem auto;
            font-size: 1.5rem;
            color: white;
            box-shadow: 0 0 30px var(--accent-glow);
        }
    </style>
</head>
<body style="margin:0; padding:0;">
    <?php include "../includes/navbar.php"; ?>
   <div class="container">
        <div class="admin-login-wrapper">
            <div class="form">
                <div class="admin-login-icon"><i class="fa-solid fa-user-shield"></i></div>
                <h4>Admin Login</h4>
                <form action="admin_welcome.php" method="POST">
                    <label class="label"><i class="fa-solid fa-envelope" style="margin-right:4px; font-size:0.75rem;"></i> Email Id:</label>
                    <input type="email" name="email" class="input" placeholder="Enter Email id" required>

                    <label class="label"><i class="fa-solid fa-lock" style="margin-right:4px; font-size:0.75rem;"></i> Password:</label>
                    <input type="password" name="password" class="input" placeholder="Enter Password" required>

                    <button class="button" name="login">Login</button>
                </form>
                <p class="error"><?php echo $_SESSION['error']; ?></p>
            </div>
        </div>
   </div>
</body>
</html>