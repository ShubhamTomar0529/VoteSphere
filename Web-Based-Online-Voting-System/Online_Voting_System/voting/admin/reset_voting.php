<?php
include "../../../config.php";
?>  
<?php

$con=mysqli_connect("localhost","root","","voting");

$rst_cand_query = "UPDATE candidate SET tvotes=0";
$rst_cand_data = mysqli_query($con,$rst_cand_query);

$rst_votes_query = "DELETE FROM votes";
mysqli_query($con,$rst_votes_query);

$rst_voter_query = "UPDATE register SET status='not voted'";
$rst_voter_data = mysqli_query($con,$rst_voter_query);

if($rst_voter_data)
{
    echo "<script>

            alert('voting reseted!')
            history.back()

           </script>

    ";
}


?>