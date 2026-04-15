<?php

    session_start();
    error_reporting(0);
    date_default_timezone_set('Asia/Kolkata');
    if($_SESSION['userLogin']!=1)
    {
        header("location:index.php");
    }
    include "includes/all-select-data.php";

    $start=$_GET['start'];

    // Global redirects removed, handled dynamically in the voting list.
    
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
    <style>
        .table
        {
            margin-top: 1rem;
        }
        .button
        {
            width: 15rem;
            margin: auto;
            margin-top: 1rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body style="margin:0; padding:0;">
    <?php include "includes/navbar.php"; ?>
    <div class="container" style="margin-top: 2rem;">
    <div class="heading"><h1>Online Voting System</h1></div>
    <div class="header">
            <span class="logo">Voting System</span>
            <span class="profile" onclick="showProfile()"><img src="<?php echo $_SESSION['idcard']; ?>" alt=""><label><?php echo$_SESSION['fname']." ".$_SESSION['lname'];?></label></span>
        </div>
        <div id="profile-panel">
            <i class="fa-solid fa-circle-xmark" onclick="hidePanel()"></i>
            <div class="dp"><img src="<?php echo $_SESSION['idcard'];?>" alt=""></div>
            <div class="info">
                <h2><?php echo$_SESSION['fname']." ".$_SESSION['lname'];?></h2>
            </div>
            <div class="link"><a href="includes/user-logout.php" class="del"><i class="fa-solid fa-arrow-right-from-bracket"></i> Logout</a></div>
        </div>
        <div class="main">
            <table class="table">
                <thead>
                    <th>Vote</th>
                    <th>Voting Symbol</th>
                    <th>Candidate Name</th>
                    <th>position</th>
                </thead>
                <tbody>
                    <form action="cal_vote.php" method="POST">
                <?php 
                    $user_id = $_SESSION['id'];
                    $unvoted_positions = 0;
                    while($pos_result=mysqli_fetch_assoc($pos_data))
                    {
                        $position_id = $pos_result['id'];
                        $title = $pos_result['title'];
                        $start_time = strtotime($pos_result['start_datetime']);
                        $end_time = strtotime($pos_result['end_datetime']);
                        $current_time = time();

                        $vote_check_query = "SELECT * FROM votes WHERE user_id='$user_id' AND position_id='$position_id'";
                        $vote_check_data = mysqli_query($con, $vote_check_query);
                        $has_voted = mysqli_num_rows($vote_check_data) > 0;

                        echo "<tr><td colspan='4'><h2>".$pos_result['position_name']."</h2><p style='color:gray;'>$title</p></td></tr>";
                        $query="SELECT * FROM candidate WHERE position_id='$position_id'";
                        $data=mysqli_query($con,$query);

                        if ($current_time < $start_time) {
                            echo "<tr><td colspan='4' style='text-align:center; color:#ff9800; font-weight:bold; padding: 1rem;'>Voting not started (Opens: ".$pos_result['start_datetime'].")</td></tr>";
                        } elseif ($current_time > $end_time) {
                            echo "<tr><td colspan='4' style='text-align:center; color:#f44336; font-weight:bold; padding: 1rem;'>Voting closed (Ended: ".$pos_result['end_datetime'].")</td></tr>";
                        } else {
                            if ($has_voted) {
                                $voted_data = mysqli_fetch_assoc($vote_check_data);
                                $voted_cand_id = $voted_data['candidate_id'];
                                
                                while($result=mysqli_fetch_assoc($data))
                                {
                                    if($result['id'] == $voted_cand_id) {
                                        echo "
                                        <tr>
                                            <td>
                                                <span style='color:green;font-weight:bold;'>Voted</span>
                                            </td>
                                                <td>
                                                    <div class='symbol'>
                                                        <a href='admin/".$result['symphoto']."'><img src='admin/".$result['symphoto']."'></a>
                                                        <div class='bold'>".$result['symbol']."</div>
                                                    </div>
                                                </td>
                                                <td class='large-font'>".$result['cname']."</td>
                                                <td class='large-font'>".$pos_result['position_name']."</td>
                                        </tr>";
                                    } else {
                                         echo "<tr style='opacity:0.5;'>
                                            <td><input type='radio' disabled></td>
                                            <td><div class='symbol'>
                                                        <a href='admin/".$result['symphoto']."'><img src='admin/".$result['symphoto']."'></a>
                                                        <div class='bold'>".$result['symbol']."</div>
                                                    </div></td>
                                            <td class='large-font'>".$result['cname']."</td>
                                            <td class='large-font'>".$pos_result['position_name']."</td>
                                            </tr>";
                                    }
                                }
                            } else {
                                $unvoted_positions++;
                                while($result=mysqli_fetch_assoc($data))
                                {
                                    echo "
                                    <tr>
                                        <td>
                                            <input type='radio' name='pos_".$position_id."' value='".$result['id']."' class='vote'>
                                            <label class='check'>&#10004;</label>
                                        </td>
                                            <td>
                                                <div class='symbol'>
                                                    <a href='admin/".$result['symphoto']."'><img src='admin/".$result['symphoto']."'></a>
                                                    <div class='bold'>".$result['symbol']."</div>
                                                </div>
                                            </td>
                                            <td class='large-font'>".$result['cname']."</td>
                                            <td class='large-font'>".$pos_result['position_name']."</td>
                                    </tr>";
                                }
                            }
                        }
                    }
                ?>
                <?php if($unvoted_positions > 0) { ?>
                <tr><td colspan="4"><button class="button" name="vote">Vote</button></td></tr>
                <?php } else { ?>
                <tr><td colspan="4"><h3 style="text-align:center;color:green;padding:1rem;">You have completed voting for all positions.</h3></td></tr>
                <?php } ?>
                </form>
                </tbody>
            </table>
        </div>
    </div>
   <script>
        //logout user after 5 minutes
        setTimeout(() => {
            location.replace("includes/user-logout.php");
        }, 300000);

    </script>
    <script src="js/script.js"></script>
</body>
</html>