<?php
include "../../config.php";
?>  
<?php

    error_reporting(0);
    session_start();

    if($_SESSION['userLogin']!=1)
    {
        header("location:index.php");
        exit();
    }

    include "includes/all-select-data.php";
    $user_id = $_SESSION['id'];
    
    $voted_any = false;

    while($pos_result=mysqli_fetch_assoc($pos_data))
    {
        $pos_id=$pos_result['id'];
        // The radio button names are pos_<id>
        $input_name = "pos_".$pos_id;
        
        if (isset($_POST[$input_name])) {
            $can_id = $_POST[$input_name];
            
            // Check if user already voted for this position
            $check_vote_query = "SELECT * FROM votes WHERE user_id='$user_id' AND position_id='$pos_id'";
            $check_vote = mysqli_query($con, $check_vote_query);
            
            if (mysqli_num_rows($check_vote) == 0) {
                // Insert into votes table (trigger auto-increments candidate tvotes)
                $insert_vote = "INSERT INTO votes (user_id, position_id, candidate_id) VALUES ('$user_id', '$pos_id', '$can_id')";
                if (mysqli_query($con, $insert_vote)) {
                    $voted_any = true;
                }
            }
        }
    }

    // Update voter status in the database
    if ($voted_any) {
        $update_status = "UPDATE register SET status='voted' WHERE id='$user_id'";
        mysqli_query($con, $update_status);
        $_SESSION['status'] = 'voted';
    }

    // Go back to the ballot page to show updated progress
    echo "<script>
            location.href='ballet.php?start=1'
        </script>
    ";

?>