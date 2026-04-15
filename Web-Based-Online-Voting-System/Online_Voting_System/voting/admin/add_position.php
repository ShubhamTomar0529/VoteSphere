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
    <title>Online Voting System</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
   <div class="container">
        <div class="heading"><h1>Online Voting System</h1></div>
        <div class="form">
            <h4>Add Positions</h4>
            <form action="" method="POST">
                <label class="label">Position Name:</label>
                <input type="text" name="position" class="input" placeholder="Enter position" required>

                <label class="label">Voting Title:</label>
                <input type="text" name="title" class="input" placeholder="Enter Title (e.g. Chairman Election 2026)" required>

                <label class="label">Start Time:</label>
                <input type="datetime-local" name="start_time" class="input" required>

                <label class="label">End Time:</label>
                <input type="datetime-local" name="end_time" class="input" required>

                <button class="button" name="add">Add</button>
            </form>
        </div>
   </div>
</body>
</html>

<?php
    $con=mysqli_connect("localhost","root","","voting");

    if(isset($_POST['add']))
    {

        $pos_name=$_POST['position'];
        $title=$_POST['title'];
        $start=$_POST['start_time'];
        $end=$_POST['end_time'];
        $query="INSERT INTO can_position (position_name, title, start_datetime, end_datetime) VALUES ('$pos_name', '$title', '$start', '$end')";
        $data=mysqli_query($con,$query);

        if($data)
        {
            echo "
            <script>
                alert('position added successfully')
                location.href='position.php'
            </script>";
        }
        else
        {
            echo "
            <script>
                alert('position already added !')
                history.back()
            </script>";
        }
    }
?>