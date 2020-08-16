
<?php include 'inc/header.php'; ?>

<?php include '../lib/Database.php'; ?> 

<?php

	$id =  $_GET["id"];
	$result = pg_query($dbhost, "SELECT * FROM job natural join employer where jid=$id");
	$result1= pg_query($dbhost, "SELECT type.title_name FROM job_type natural join type where jid=$id");
	$result2= pg_query($dbhost, "SELECT skill_name FROM skills natural join Job_skills where jid=$id");
        // If the $result variable is not defined, there was an error in the query
	if (!$result)
	{
		die("Error in query: ".pg_last_error());
	}

	$row = pg_fetch_array($result);

	
?>

<h2 class="page-header"><?php echo $row[2];?> (<?php echo $row[4];?>) </h2>
<small>Posted By <?php echo $row[6];?></small>
<hr>
<p class="lead"><?php echo $row[3];?></p>
<ul class="list-group">
	<li class="list-group-item">
		<strong>Employer:</strong>
		<?php echo $row[6];?>
	</li>
	<li class="list-group-item">
		<strong>Job Type:</strong>
		<?php 

		while ($row1 = pg_fetch_array($result1)){

			echo $row1[0]. ', ';

		}
		?>
	</li>
	<li class="list-group-item">
		<strong>Skills required:</strong>
		<?php 

		while ($row2 = pg_fetch_array($result2)){

			echo $row2[0], ', ';

		}
		?>
	</li>
	<li class="list-group-item">
		<strong>Phone Number:</strong>
		<?php echo $row[7];?>
	</li>
	<li class="list-group-item">
		<strong>Email:</strong>
		<?php echo $row[9];?>
	</li>
</ul>
</br></br>
<a href="index.php">Go back</a>
<?php include 'inc/footer.php'; ?>