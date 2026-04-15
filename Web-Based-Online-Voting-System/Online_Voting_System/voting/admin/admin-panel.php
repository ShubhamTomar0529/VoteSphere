<?php
include "../../../config.php";
?>  
<?php

    error_reporting(0);
    session_start();
    include "../includes/all-select-data.php";

    if($_SESSION['adminLogin']!=1)
    {
        header("location:index.php");
    }

    $voter_voted_query="SELECT DISTINCT user_id FROM votes";
    $voter_voted_data=mysqli_query($con,$voter_voted_query);
    
    $voter_voted=mysqli_num_rows($voter_voted_data);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin Dashboard — Online Voting System. Manage voters, candidates, positions, and view live results.">
    <title>Admin Dashboard — Online Voting System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/all.min.css">
    <script src="../js/chart.js"></script>
    <style>
        /* Dashboard-specific overrides */
        .dashboard-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .dashboard-stats .info-box {
            flex: 1;
            min-width: 220px;
            float: none;
            margin: 0;
        }

        .dashboard-section-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 2rem 0 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--border-subtle);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dashboard-section-title i {
            color: var(--accent-start);
        }

        .charts-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 1.25rem;
        }

        .charts-grid .result {
            flex: 1;
            min-width: 380px;
            float: none;
            margin: 0;
        }

        @media (max-width: 768px) {
            .dashboard-stats .info-box {
                min-width: 100%;
            }
            .charts-grid .result {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <span class="menu-bar" id="show" onclick="showMenu()">&#9776;</span>
            <span class="menu-bar" id="hide" onclick="hideMenu()">&#9776;</span>
            <span class="logo"><i class="fa-solid fa-check-to-slot" style="margin-right:6px;"></i> VoteSystem</span>
            <span class="profile" onclick="showProfile()"><img src="../res/user3.jpg" alt=""><?php echo $_SESSION['name']; ?></span>
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
            <!-- Page Title -->
            <div class="heading" style="text-align:left; margin:0 0 1.5rem 0;">
                <h1 style="font-size:1.5rem;">Dashboard Overview</h1>
                <p style="color:var(--text-muted); font-size:0.85rem; margin-top:0.25rem; -webkit-text-fill-color: var(--text-muted);">Welcome back, <?php echo $_SESSION['name']; ?>. Here's your system summary.</p>
            </div>

            <!-- Stat Cards -->
            <div class="dashboard-stats">
                <div class="info-box" id="box1">
                    <h1><?php echo $_SESSION["total_voters"]; ?></h1>
                    <h3>Total Voters</h3>
                    <a href="voters.php">More Info <i class="fa-solid fa-circle-arrow-right"></i></a>
                </div>
                <div class="info-box" id="box2">
                    <h1><?php echo $_SESSION["total_cand"]; ?></h1>
                    <h3>Candidates</h3>
                    <a href="candidates.php">More Info <i class="fa-solid fa-circle-arrow-right"></i></a>
                </div>
                <div class="info-box" id="box3">
                    <h1><?php echo $_SESSION["total_position"]; ?></h1>
                    <h3>Positions</h3>
                    <a href="position.php">More Info <i class="fa-solid fa-circle-arrow-right"></i></a>   
                </div>
                <div class="info-box" id="box4">
                    <h1><?php echo $voter_voted; ?></h1>
                    <h3>Voters Voted</h3>
                    <a href="#">More Info <i class="fa-solid fa-circle-arrow-right"></i></a>
                </div>
            </div>

            <!-- Voting Tally Charts -->
            <div class="dashboard-section-title"><i class="fa-solid fa-chart-column"></i> Voting Tally</div>
            <div class="result-box">
                <div class="charts-grid">
                <?php
                    $i=0;
                    while($i<$total_pos)
                    {
                        echo '
                        <div class="result"><canvas class="myChart"></canvas></div>
                        ';
                        $i++;
                    }
                ?>
                </div>
            </div>
            </div>
        </div>
    <script>
        var ctx = [];
        var myChart = [];
        <?php
            include "../includes/candidate_result.php";
        ?>

        // Override Chart.js defaults for dark theme
        if (typeof Chart !== 'undefined') {
            Chart.defaults.color = '#94a3b8';
            Chart.defaults.borderColor = 'rgba(148, 163, 184, 0.1)';
            Chart.defaults.font.family = "'Inter', sans-serif";
        }
 </script>
<script src="../js/script.js"></script>
</body>
</html>