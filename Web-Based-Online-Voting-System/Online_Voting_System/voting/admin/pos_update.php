<?php
include "../../../config.php";
?>  
<?php
$id=$_GET['id'];
$con=mysqli_connect("localhost","root","","voting");
$fetch_query="SELECT * FROM can_position WHERE id='$id'";
$fetch_data=mysqli_query($con,$fetch_query);
$result=mysqli_fetch_assoc($fetch_data);
$psnm = $result['position_name'];
$title = $result['title'];
$start = date('Y-m-d\TH:i', strtotime($result['start_datetime']));
$end = date('Y-m-d\TH:i', strtotime($result['end_datetime']));
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Voting System</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
   <div class="container">
        <div class="heading"><h1>Online Voting System</h1></div>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form">
                <h4>Candidate Position Update</h4>

                <label class="label">Candidate Position:</label>
                <input type="text" name="position" id="" class="input" value="<?php echo $psnm; ?>" required>

                <label class="label">Voting Title:</label>
                <input type="text" name="title" class="input" value="<?php echo $title; ?>" required>

                <label class="label">Start Time:</label>
                <input type="datetime-local" name="start_time" class="input" value="<?php echo $start; ?>" required>

                <label class="label">End Time:</label>
                <input type="datetime-local" name="end_time" class="input" value="<?php echo $end; ?>" required>

                <button class="button" name="update">Update</button>
            </div>
        </form>
   </div> 

   <?php
   
    if(isset($_POST['update']))
    {
        $position=$_POST['position'];
        $title=$_POST['title'];
        $start=$_POST['start_time'];
        $end=$_POST['end_time'];
        $query="UPDATE can_position SET position_name='$position', title='$title', start_datetime='$start', end_datetime='$end' where id='$id'";

        $data=mysqli_query($con,$query);

        if($data)
        {
            echo "
                <script>
                    alert('position update succefully!')
                    location.href='position.php'
                </script>
            ";
        }
    }
   
   ?>