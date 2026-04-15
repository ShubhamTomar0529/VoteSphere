<?php
include "../../../config.php";
?>  
<?php

$fn  =$_GET['fn'];
$ln  =$_GET['ln'];
$idno=$_GET['idno'];
$ph  =$_GET['ph'];
$ad  =$_GET['ad'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information Update — Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/all.min.css">
</head>
<body style="margin:0; padding:0;">
    <?php include "../includes/navbar.php"; ?>
   <div class="container" style="min-height: 100vh; padding-top: 3rem;">
        <div class="heading">
            <h1>Online Voting System</h1>
        </div>
        
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form">
                <h4><i class="fa-solid fa-pen-to-square" style="margin-right:8px;"></i> User Information Update</h4>
                
                <label class="label">Firstname:</label>
                <input type="text" name="fname" id="" class="input" value="<?php echo htmlspecialchars($fn); ?>">

                <label class="label">Lastname:</label>
                <input type="text" name="lname" id="" class="input" value="<?php echo htmlspecialchars($ln); ?>">

                <label class="label">ID No:</label>
                <input type="text" name="idnum" value="<?php echo htmlspecialchars($idno); ?>" class="input">

                <label class="label">Phone Number:</label>
                <input type="text" name="phone" class="input" value="<?php echo htmlspecialchars($ph); ?>">

                <label class="label">Address:</label>
                <input type="text" name="address" class="input" value="<?php echo htmlspecialchars($ad); ?>">

                <button class="button" name="update"><i class="fa-solid fa-floppy-disk" style="margin-right:6px;"></i> Save Updates</button>
            </div>
        </form>
   </div> 

   <?php
   
    if(isset($_POST['update']))
    {
        $fname=$_POST['fname'];
        $lname=$_POST['lname'];
        $email=$_POST['email'];
        $address=$_POST['address'];
        $idnum=$_POST['idnum'];
        $phone=$_POST['phone'];
        $con=mysqli_connect("localhost","root","","voting");

        $query1="UPDATE applyforvoting SET phone='$phone' WHERE phone='$ph'";
        $query2="UPDATE register SET fname='$fname',lname='$lname',email='$email',idnum='$idnum',phone='$phone',address='$address' WHERE phone='$ph'";

        $data1=mysqli_query($con,$query1);
        $data2=mysqli_query($con,$query2);

        if($data1)
        {
            echo "<script>location.replace('voters.php');</script>";
        }
    }
   
   ?>
</body>
</html>