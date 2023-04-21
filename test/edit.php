<?php

include "db_config.php"; // Using database connection file here

$id = $_GET['id']; // get id through query string

$qry = mysqli_query($db,"select * from project where id='$id'"); // select query

$data = mysqli_fetch_array($qry); // fetch data

if(isset($_POST['submit'])) // when click on Update button
{
    $project_status = $_POST['project_status'];
	
    $edit = mysqli_query($db,"update project set project_status='$project_status' where id='$id'");
	
    if($edit)
    {
        mysqli_close($db); // Close connection
        header("admin.php"); // redirect
        exit;
    }
    else
    {
        echo mysqli_error();
    }    	
}
?>

<h3>Update Data</h3>

<form method="POST" action="">
    <input type="text" name="project_status" value="<?php echo $data['project_status'] ?>" placeholder="In review" Required>
  <input type="submit" name="submit" value="submit">
</form>