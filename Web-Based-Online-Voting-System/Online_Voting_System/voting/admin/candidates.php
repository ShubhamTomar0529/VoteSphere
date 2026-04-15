<?php
include "../../../config.php";
?>  
<?php
session_start();
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
    <title>Candidates Information — Admin Dashboard</title>
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
        <div id="profile-panel">
            <i class="fa-solid fa-circle-xmark" onclick="hidePanel()"></i>
            <div class="dp"><img src="../res/user3.jpg" alt=""></div>
            <div class="info">
                <h2><?php echo $_SESSION['name']; ?></h2>
                <h5>Admin</h5>
            </div>
            <div class="link"><a href="../includes/admin-logout.php" class="del"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a></div>
        </div>
        <?php include '../includes/menu.php'; ?>
        
        <div id="main">
            <!-- Header Section -->
            <div class="heading" style="text-align:left; margin:0 0 1.5rem 0;">
                <h1 style="font-size:1.5rem;">Candidates Information</h1>
                <p style="color:var(--text-muted); font-size:0.85rem; margin-top:0.25rem;">View and manage all registered candidates.</p>
            </div>
            
            <div style="margin-bottom: 2rem;">
                <a href="cand-register.php" class="add-btn"><i class="fa-solid fa-plus"></i> Add New Candidate</a>
                <div style="clear:both;"></div>
            </div>
            
            <!-- Table Section -->
            <div class="table-wrapper">
               <table class="table" style="margin-bottom: 0;">
                   <thead>
                       <th>Candidate Name</th>
                       <th>Candidate Symbol</th>
                       <th>Symbol Image</th>
                       <th>Position</th>
                       <th>Total Votes</th>
                       <th>Action</th>
                   </thead>
                   <tbody>
                   <?php
                          
                          include "../includes/all-select-data.php";
                        
                          while($result=mysqli_fetch_assoc($can_data))
                          {
                            echo "<tr>
                            <td><div class='bold'>".$result['cname']."</div></td>
                            <td>".$result['symbol']."</td>
                            <td><div style='background:rgba(255,255,255,0.05); padding:4px; border-radius:10px; display:inline-block;'><a href='$result[symphoto]'><img src='".$result['symphoto']."'></a></div></td>
                            <td><span style='color:var(--text-secondary);'>".$result['position_name']."</span></td>
                            <td><span style='font-size:1.1rem; font-weight:700; color:var(--accent-start);'>".$result['tvotes']."</span></td>
                            <td>
                                <div class='action-buttons'>
                                    <a href='cand-update.php?cn=$result[cname]&sy=$result[symbol]&pid=$result[position_id]&ps=$result[position_name]' class='edit'><i class='fa-solid fa-pen-to-square'></i> Edit</a>
                                    <a href='can-delete.php?id=$result[id]' class='del' onClick='return delconfirm()'><i class='fa-solid fa-trash-can'></i> Delete</a>
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
            return confirm('Delete this Candidate?');
        }
    </script>
</body>
</html>