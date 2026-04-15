<?php
include "../../../config.php";
?>  
<?php
session_start();
error_reporting(0);
if($_SESSION['adminLogin']!=1)
{
    header("location:index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voter Requests — Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <style>
        .table-wrapper {
            width: 100%;
            overflow-x: auto;
            margin-bottom: 2rem;
            animation: fadeInUp 0.5s ease;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <span class="menu-bar" id="show" onclick="showMenu()">&#9776;</span>
            <span class="menu-bar" id="hide" onclick="hideMenu()">&#9776;</span>
            <span class="logo"><i class="fa-solid fa-check-to-slot" style="margin-right:6px;"></i> VoteSystem</span>
            <span class="profile" onclick="showProfile()"><img src="../res/user3.jpg" alt=""><label><?php echo $_SESSION['name']; ?></label></span>
        </div>
        <?php include '../includes/menu.php'; ?>
        <div id="profile-panel">
            <i class="fa-solid fa-circle-xmark" onclick="hidePanel()"></i>
            <div class="dp"><img src="../res/user3.jpg" alt=""></div>
            <div class="info">
                <h2><?php echo $_SESSION['name']; ?></h2>
                <h5>Admin</h5>
            </div>
            <div class="link"><a href="../includes/admin-logout.php" class="del"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a></div>
        </div>
        <div id="main">
            <div class="heading" style="text-align:left; margin:0 0 1.5rem 0;">
                <h1 style="font-size:1.5rem;">Voter Requests</h1>
                <p style="color:var(--text-muted); font-size:0.85rem; margin-top:0.25rem;">Handle mobile number change requests.</p>
            </div>
            
            <div class="table-wrapper">
               <table class="table">
                   <thead>
                        <th>Name</th>
                        <th>ID Name</th>
                        <th>ID Card</th>
                        <th>DOB</th>
                        <th>Old Phone No</th>
                        <th>New Phone No</th>
                        <th>Action</th>               
                   </thead>
                   <tbody>
                          <?php
                          
                          $con=mysqli_connect('localhost','root','','voting');
                      
                          $query="SELECT * FROM phno_change";
                      
                          $data=mysqli_query($con,$query);
                        
                          while($result=mysqli_fetch_assoc($data))
                          {
                            echo "<tr>
                            <td><div class='bold'>".$result['vname']."</div></td>
                            <td>".$result['idname']."</td>
                            <td><a href='../$result[idcard]'><img src='../".$result['idcard']."'></a></td>
                            <td>".$result['dob']."</td>
                            <td>".$result['old_phno']."</td>
                            <td>".$result['new_phno']."</td>
                            <td><a href='voter_req_delete.php?id=$result[id]' class='del' onClick='return delconfirm()'><i class='fa-solid fa-trash-can'></i> Delete</a></td>
                            </tr>";
                          }
                          
                          ?>
                   </tbody>
               </table>
            </div>
        </div>
    </div>
    <script src="../js/script.js"></script>
    <script>
        function delconfirm()
        {
            return confirm('Delete this Voter request?');
        }
    </script>
</body>
</html>