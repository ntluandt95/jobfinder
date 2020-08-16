<?php include 'inc/adminheader.php'; ?>
<?php include '../lib/Database.php'; ?>
    
    <?php

	$getid =  $_GET["id"];
	$action =  $_GET["action"];
	$id=$_POST["id"];
	$title=$_POST["title"];
	$description=$_POST["description"];
	$location=$_POST["location"];
	$eid=$_POST["eid"];
	$cid=$_POST["cid"];
	
	if ($action=='add') {
		
		$sql="insert into job values ($id,'$title','$description','$location',$eid,$cid)";
		//echo $sql;
		pg_query($dbhost, $sql);
	}if ($action=='update') {
		
		$sql="update job set job_title='$title', description='$description', location='$location', eid=$eid, cid=$cid WHERE jid=$id";
		//echo $sql;
		pg_query($dbhost, $sql);
	}if ($action=='delete') {
		
		$sql="delete from job where eid=$getid";
		//echo $sql;
		pg_query($dbhost, $sql);
	}
	$result = pg_query($dbhost, "SELECT * FROM job natural join employer");
	$resultemployer = pg_query($dbhost, "SELECT eid,employee_name FROM employer");
	$resultcategory = pg_query($dbhost, "SELECT * FROM category");
	$resulttype = pg_query($dbhost, "SELECT * FROM type");
	$resultskills = pg_query($dbhost, "SELECT * FROM skills");
    //$resultjob_type = pg_query($dbhost,"SELECT * FROM job_type narutal join job where jid=$");
	$employerarray= array();
	$i=0;
	while($rowtemp = pg_fetch_array($resultemployer)){

		$employerarray[$i][0] = $rowtemp[0];
		$employerarray[$i][1] = $rowtemp[1];

		$i=$i+1;
	}



	$categoryarray= array();
	$i=0;
	while($rowtemp1 = pg_fetch_array($resultcategory)){

		$categoryarray[$i][0] = $rowtemp1[0];
		$categoryarray[$i][1] = $rowtemp1[1];

		$i=$i+1;
	}
	$typearray= array();
	$i=0;
	while($rowtemp2 = pg_fetch_array($resulttype)){
		
		$typearray[$i][0] = $rowtemp2[0];
		$typearray[$i][1] = $rowtemp2[1];

		$i=$i+1;
	}

	if (!$result)
	{
		die("Error in query: ".pg_last_error());
	}

	//$query="SELECT * FROM type natural join Job_type where jid=1";

	//$resultjobtype = pg_query($dbhost, $query);
	//$row11 = pg_fetch_array($resultjobtype);
	//echo $row11[1];

	function selectjobtype($dbhost,$jid){
		$query="SELECT * FROM type natural join Job_type where jid=$jid";

		$resultjobtype = pg_query($dbhost, $query);
		
		$array = array();
		$i=0;
		
		if (!$resultjobtype)
		{
			die("Error in query: ".$query);
		}
		while ($row = pg_fetch_array($resultjobtype)) {
			
			$array[$i][0]=$row["jtid"];

			$array[$i][1]=$row["title_name"];
			$i=$i+1;
		}
		return $array;
	}

	
	

	
?>
		  <div class="col-md-10">
  			<div class="content-box-large">
  				<div class="panel-heading">
					<h3>Job Table</h3>
					<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModaladd">Add</button>

								<div class="modal" id="myModaladd">
									  <div class="modal-dialog">
									    <div class="modal-content">

									      <!-- Modal Header -->
									      <form method="POST" action="job.php?action=add">
									      <div class="modal-header">
									        <h4 class="modal-title">Add new Job</h4>
									        <button type="button" class="close" data-dismiss="modal">&times;</button>
									      </div>

									      <!-- Modal body -->
									      <div class="modal-body">
									        	<label>ID:</label>
									        	<input type="text" class="form-control" name="id">
												<div class="form-group">
												<label>Job Title:</label>
												<input type="text" class="form-control" name="title">
												</div>
												<div class="form-group">
												<label>Description:</label>
												<textarea rows="4" cols="50" type="text" class="form-control" name="description"></textarea>
												</div>	
												<div class="form-group">
												<label>Location:</label>
												<input type="text" class="form-control" name="location">
												</div>
												<div class="form-group">
												<label>Employer Name:</label>
												<select name="eid" class="form-control">
									        		

									        		
									        			<?php foreach($employerarray as $val){?>
									        				
									          				<option value="<?php echo $val[0]; ?>"><?php echo $val[1]; ?></option>

									          			<?php }?>

        										</select>
        										<label>Category:</label>
        										<select name="cid" class="form-control">
									        		
									        			<?php foreach($categoryarray as $val){?>
									        				
									          				<option value="<?php echo $val[0]; ?>"><?php echo $val[1]; ?></option>

									          			<?php }?>

        										</select>
        										
												</div>
										  </div>
									      							      
									      <div class="modal-footer">
									      	<input type="submit" name="button" value="ADD" class="btn btn-primary"/>
									        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
									      </div>
									      </form>
									    </div>
									  </div>
									</div>



  				<div class="panel-body">
  					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
						<thead>
							<tr>
								<th>ID</th>
								<th>Job Title</th>
								<th>Location</th>
								<th>Employer Name</th>
								<th>Category</th>
								
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php while ($row = pg_fetch_array($result)){						
								?>
							<tr class="odd gradeX">
								<td><?php echo $row[0] ?></td>
								<td><?php echo $row[2] ?></td>
								<td><?php echo $row[4] ?></td>
								<td><?php echo $row[6] ?></td>
																<td>
									<?php foreach($categoryarray as $val){
															
										if($val[0]==$row[5]){

											echo $val[1];
										}
									}?>
								</td>
								

								<td class="center">
									<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal<?php echo $row[0] ?>">UPDATE</button>
									<div class="modal" id="myModal<?php echo $row[0] ?>">
									  <div class="modal-dialog">
									    <div class="modal-content">

									      <!-- Modal Header -->
									      <form method="POST" action="job.php?action=update">
									      <div class="modal-header">
									        <h4 class="modal-title">Update Job id: <?php echo $row[0] ?></h4>
									        <button type="button" class="close" data-dismiss="modal">&times;</button>
									      </div>

									      <!-- Modal body -->
									      <div class="modal-body">
									        	<label>ID:</label>
									        	<input type="text" class="form-control" name="id" value="<?php echo $row[0] ?>">
												<div class="form-group">
												<label>Job Title:</label>
												<input type="text" class="form-control" name="title" value="<?php echo $row[2] ?>">
												</div>
												<div class="form-group">
												<label>Description:</label>
												<textarea rows="4" cols="50" type="text" class="form-control" name="description" 
												><?php echo $row[3] ?></textarea>
												</div>	
												<div class="form-group">
												<label>Location:</label>
												<input type="text" class="form-control" name="location" value="<?php echo $row[4] ?>">
												</div>
												<div class="form-group">
												<label>Employer Name:</label>
												<select name="eid" class="form-control">

									        			<option value="<?php echo $row[1]; ?>"><?php echo $row[6]; ?></option>
									        			<?php foreach($employerarray as $val){?>
									        				
									          				<option value="<?php echo $val[0]; ?>"><?php echo $val[1]; ?></option>

									          			<?php }?>

        										</select>
        										<label>Category:</label>
        										<select name="cid" class="form-control">
									        			<?php foreach($categoryarray as $val){
									        				if($row[5]==$val[0]){
									        				?>
									        				
									          				<option value="<?php echo $val[0]; ?>"><?php echo $val[1]; ?></option>

									          			<?php }}?>

									        			<?php foreach($categoryarray as $val){?>
									        				
									          				<option value="<?php echo $val[0]; ?>"><?php echo $val[1]; ?></option>

									          			<?php }?>

        										</select>
        										
												</div>
										  </div>

									      <!-- Modal footer -->
									      <div class="modal-footer">
									      	<input type="submit" name="button" value="UPDATE" class="btn btn-primary"/>
									        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
									      </div>
									      </form>
									    </div>
									  </div>
									</div>
									<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModaldelete<?php echo $row[0] ?>">DELETE</button>

									<div class="modal" id="myModaldelete<?php echo $row[0] ?>">
									  <div class="modal-dialog">
									    <div class="modal-content">

									      <!-- Modal Header -->
									      
									      <div class="modal-header">
									        <h4 class="modal-title">Delete employee id: <?php echo $row[0] ?></h4>
									        <button type="button" class="close" data-dismiss="modal">&times;</button>
									      </div>

									      <!-- Modal body -->
									      <div class="modal-body">
									        <h1>Are you sure???
									        </h1>
									        	
											    
											    
											  
									      </div>

									      <!-- Modal footer -->
									      <div class="modal-footer">
									      	<a class="btn btn-danger" href="job.php?action=delete&id=<?php echo $row[0]?>">DELETE</a>
									        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
									      </div>
									      
									    </div>
									  </div>
									</div>
							</tr>
							<?php } 						
							?>		
						</tbody>
					</table>
  				</div>
  			</div>
		  </div>
		</div>
    </div>

   <?php include 'inc/adminfooter.php'; ?> 