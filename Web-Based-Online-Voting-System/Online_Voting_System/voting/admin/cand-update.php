<?php
include "../../../config.php";
?>  
<?php
$cn=$_GET['cn'];
$sy=$_GET['sy'];
$pid=$_GET['pid'];
$ps=$_GET['ps'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Candidate — Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/all.min.css">
</head>
<body style="margin:0; padding:0;">
    <?php include "../includes/navbar.php"; ?>
   <div class="container" style="min-height: 100vh; padding-top: 3rem;">
        <div class="heading"><h1>Online Voting System</h1></div>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form">
                <h4><i class="fa-solid fa-user-pen" style="margin-right:8px;"></i> Candidate Information Update</h4>
                
                <label class="label">Candidate Name:</label>
                <input type="text" name="cname" id="" class="input" value="<?php echo htmlspecialchars($cn); ?>">

                <label class="label">Candidate Symbol Name:</label>
                <input type="text" name="symbol" id="" class="input" value="<?php echo htmlspecialchars($sy); ?>">
                
                <label class="label">Candidate Position:</label>
                <select name="position" class="input">
                    <?php
                    
                    include "../includes/all-select-data.php";

                    echo "<option value='".htmlspecialchars($pid)."'>".htmlspecialchars($ps)." (already selected)</option>";
                    while($result=mysqli_fetch_assoc($pos_data))
                    {
                        echo "<option value='".$result['id']."'>".$result['position_name']."</option>";
                    }
                    
                    ?>
                </select>

                <button class="button" name="update"><i class="fa-solid fa-floppy-disk" style="margin-right:6px;"></i> Update</button>
            </div>
        </form>
   </div> 

   <?php
   
    if(isset($_POST['update']))
    {
        $cname=$_POST['cname'];
        $symbol=$_POST['symbol'];
        $position_id=$_POST['position'];

        $query="UPDATE candidate SET cname='$cname',symbol='$symbol',position_id='$position_id' where symbol='$sy'";

        $data=mysqli_query($con,$query);

        if($data)
        {
            echo "<script>
                    alert('Candidate updated successfully')
                    location.replace('candidates.php')
                </script>";
        }
    }
   
   ?>
</body>
</html>