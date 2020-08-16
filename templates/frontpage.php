
<?php include 'inc/header.php'; ?>

<?php include '../lib/Database.php'; ?>

<?php 
	
	
	$category =  $_POST["category"];

	if (isset($_POST['category']) && $category!=0) {
		$sql = "SELECT jid, job_title, description FROM job WHERE cid=$category";
	}else{
	$sql = "SELECT jid, job_title, description FROM job";
}
        // Run the SQL query
	$result = pg_query($dbhost, $sql);
	$resultcategory = pg_query($dbhost, "SELECT * FROM category");
	
        // If the $result variable is not defined, there was an error in the query
	if (!$result)
	{
		die("Error in query: ".pg_last_error());
	}


	
?>


      <div class="jumbotron">
        <h1 class="display-3">Find A Job</h1>
        <form method="POST" action="index.php">
        	<select name="category" class="form-control">
        		<option value="0"> Choose Category</option>
        			<?php while ($row = pg_fetch_array($resultcategory)){?>
        				
          				<option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>

          			<?php } 
				pg_free_result($resultcategory);?>

        	</select>
        </br>
        	<input type="submit" class="btn btn-lg btn-success" value="FIND">
        </form>
      </div>

<?php while ($row = pg_fetch_array($result)){?>
      <div class="row marketing">
        <div class="col-md-10">
          <h4><?php echo $row[1]; ?></h4>
          <p><?php echo $row[2]; ?></p>

          
        </div>
        <div class="col-md-2">
        	<a class="btn btn-default" href="job.php?id=<?php echo $row[0]?>">View</a>
        </div>
      </div>
<?php } 
// Free the result from memory
	pg_free_result($result);

	// Close the database connection
	pg_close($dbhost);
?>
      

        
        
      

      

<?php include 'inc/footer.php'; ?>