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
    <title>Manage Voters — Online Voting System</title>
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
        
        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 2rem 0 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--border-subtle);
        }

        .section-header h2 {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--text-primary);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin: 0;
        }
        
        .section-header.verified h2 i {
            color: var(--success);
        }
        
        .section-header.unverified h2 i {
            color: var(--warning);
        }

        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 4px;
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
                <h1 style="font-size:1.5rem;">Voters Information</h1>
                <p style="color:var(--text-muted); font-size:0.85rem; margin-top:0.25rem;">Manage and verify registered voters.</p>
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <a href="../registration.php" class="add-btn"><i class="fa-solid fa-plus"></i> Add New Voter</a>
                <div style="clear:both;"></div>
            </div>

            <!-- Verified Voters -->
            <div class="section-header verified">
                <h2><i class="fa-solid fa-user-check"></i> Verified Voters</h2>
            </div>
            <div class="table-wrapper">
                <table class="table" style="margin-bottom: 0;">
                    <thead>
                            <th>Name</th>
                            <th>Id Number</th>
                            <th>ID Card</th>
                            <th>Institute ID No</th>
                            <th>DOB</th>
                            <th>Gender</th>
                            <th>Phone No</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Action</th>               
                    </thead>
                    <tbody>
                            <?php
                            $con=mysqli_connect('localhost','root','','voting');
                            $query="SELECT * FROM register WHERE verify='yes'";
                            $data=mysqli_query($con,$query);
                            
                            while($result=mysqli_fetch_assoc($data))
                            {
                                if($result['verify']=="yes") {
                                    $verify="none";
                                } else {
                                    $verify="flex";
                                }
                                echo "<tr>
                                <td><div class='bold'>".$result['fname']." ".$result['lname']."</div></td>
                                <td><div style='font-size:0.75rem; color:var(--text-muted);'>".$result['idname']."</div>".$result['idnum']."</td>
                                <td><a href='../$result[idcard]'><img src='../".$result['idcard']."'></a></td>
                                <td>".$result['inst_id']."</td>
                                <td>".$result['dob']."</td>
                                <td><span style='text-transform: capitalize;'>".$result['gender']."</span></td>
                                <td>".$result['phone']."</td>
                                <td>".$result['address']."</td>
                                <td><span style='color:var(--success); font-weight:600;'><i class='fa-solid fa-circle-check'></i> ".$result['status']."</span></td>
                                <td>
                                    <div class='action-buttons'>
                                        <a href='verify_voter.php?vid=$result[id]' style='display:$verify' class='edit verify' onClick='return validconfirm()'><i class='fa-solid fa-check'></i> Verify</a>
                                        <a href='user-update.php?fn=$result[fname]&ln=$result[lname]&idno=$result[idnum]&ph=$result[phone]&ad=$result[address]' class='edit'><i class='fa-solid fa-pen-to-square'></i> Edit</a>
                                        <a href='user-delete.php?ph=$result[phone]&file_path=$result[idcard]' class='del' onClick='return delconfirm()'><i class='fa-solid fa-trash-can'></i> Delete</a>
                                    </div>
                                </td>
                                </tr>";
                            }
                            ?>
                    </tbody>
                </table>
            </div>

            <!-- Not Verified Voters -->
            <div class="section-header unverified">
                <h2><i class="fa-solid fa-user-clock"></i> Not Verified Voters</h2>
            </div>
            <div class="table-wrapper">
                <table class="table" style="margin-bottom: 0;">
                    <thead>
                            <th>Name</th>
                            <th>Id Number</th>
                            <th>ID Card</th>
                            <th>Institute ID No</th>
                            <th>DOB</th>
                            <th>Gender</th>
                            <th>Phone No</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Action</th>               
                    </thead>
                    <tbody>
                            <?php
                            $con=mysqli_connect('localhost','root','','voting');
                            $query="SELECT * FROM register WHERE NOT verify='yes'";
                            $data=mysqli_query($con,$query);
                            
                            while($result=mysqli_fetch_assoc($data))
                            {
                                if($result['verify']=="yes") {
                                    $verify="none";
                                } else {
                                    $verify="flex";
                                }
                                echo "<tr>
                                <td><div class='bold'>".$result['fname']." ".$result['lname']."</div></td>
                                <td><div style='font-size:0.75rem; color:var(--text-muted);'>".$result['idname']."</div>".$result['idnum']."</td>
                                <td><a href='../$result[idcard]'><img src='../".$result['idcard']."'></a></td>
                                <td>".$result['inst_id']."</td>
                                <td>".$result['dob']."</td>
                                <td><span style='text-transform: capitalize;'>".$result['gender']."</span></td>
                                <td>".$result['phone']."</td>
                                <td>".$result['address']."</td>
                                <td><span style='color:var(--text-muted); font-weight:600;'><i class='fa-regular fa-circle'></i> ".$result['status']."</span></td>
                                <td>
                                    <div class='action-buttons'>
                                        <a href='verify_voter.php?vid=$result[id]' class='edit verify' onClick='return validconfirm()' style='display: $verify;'><i class='fa-solid fa-check'></i> Verify</a>
                                        <a href='user-update.php?fn=$result[fname]&ln=$result[lname]&idno=$result[idnum]&ph=$result[phone]&ad=$result[address]' class='edit'><i class='fa-solid fa-pen-to-square'></i> Edit</a>
                                        <a href='user-delete.php?ph=$result[phone]&file_path=$result[idcard]' class='del' onClick='return delconfirm()'><i class='fa-solid fa-trash-can'></i> Delete</a>
                                    </div>
                                </td>
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
            return confirm('Delete this Voter?');
        }

        function validconfirm()
        {
            return confirm('Validate this Voter?');
        }
    </script>
</body>
</html>