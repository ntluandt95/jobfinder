   <?php include 'inc/adminheader.php'; ?>
<?php include '../lib/Database.php'; ?>
    
    <?php

	$getid =  $_GET["id"];
	$action =  $_GET["action"];

	$tid=$_POST["tid"];
	$jobid=$_POST["jid"];
	$jid=$_GET["jid"];
	if ($action=='add') {
		
		$sql="insert into Job_type values (default,$jid,$tid)";
		
		pg_query($dbhost, $sql);
	}if ($action=='update') {
		
		$sql="update skills set skill_name='$name' WHERE sid=$id";
		//echo $sql;
		pg_query($dbhost, $sql);
	}if ($action=='delete') {
		
		$sql="delete from Job_type where jtid=$getid";
		//echo $sql;
		pg_query($dbhost, $sql);
	}
	
	
        // If the $result variable is not defined, there was an error in the query
	

	function selectjobtype($dbhost,$jid){
		if ($jid==0) {
			$query="SELECT * FROM type natural join Job_type natural join job";
		}
		else{
			$query="SELECT * FROM type natural join Job_type natural join job where jid=$jid";
		}
		return pg_query($dbhost, $query);
	}
	if(!isset($_POST["jid"])){
		$jobid=-1;
	}
	$result = selectjobtype($dbhost,$jobid);
	$resultjob = pg_query($dbhost, "SELECT jid,job_title FROM job");
	$resulttype = pg_query($dbhost, "SELECT * from Type");
	if (!$result)
	{
		die("Error in query: ".pg_last_error());
	}
	
?>
		  <div class="col-md-10">
  			<div class="content-box-large">
  				<div class="panel-heading">
					<h3>Job_Type Table</h3>
					<form method="POST" action="jobtype.php">
						<table>
							<tr>
							    <th>
							    	<select name="jid" class="form-control">
										<?php while ($rowjob = pg_fetch_array($resultjob)){?>
											
											<option value="<?php echo $rowjob[0]; ?>"><?php echo $rowjob[1]; ?></option>

										<?php }?>

			        				</select>
							    </th>
							    <th>
							    	<input type="submit" name="button" value="SELECT" class="btn btn-primary"/>
							    </th>
							    <th>
							    	<?php 
										if($jobid!=-1){
									?>
									<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModaladd">Add</button>
									<?php }?>
							    </th>
							  </tr>
						</table>
						
        				

					</form>
					
								<div class="modal" id="myModaladd">
									  <div class="modal-dialog">
									    <div class="modal-content">

									      <!-- Modal Header -->
									      <form method="POST" action="jobtype.php?action=add&jid=<?php echo $jobid ?>">
									      <div class="modal-header">
									        <h4 class="modal-title">Add Job Type</h4>
									        <button type="button" class="close" data-dismiss="modal">&times;</button>
									      </div>

									      <!-- Modal body -->
									      <div class="modal-body">									        	
												<label>Type:</label>
												<select name="tid" class="form-control">
														<?php while ($rowtype = pg_fetch_array($resulttype)){?>
															
															<option value="<?php echo $rowtype["tid"]; ?>"><?php echo $rowtype["title_name"]; ?></option>

														<?php }?>

							        				</select>
												
												
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
								<th>Job ID</th>
								<th>Job Title</th>
								<th>Type ID</th>
								<th>Type Name</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php while ($row = pg_fetch_array($result)){						
								?>
							<tr class="odd gradeX">
								<td><?php echo $row["jtid"] ?></td>
								<td><?php echo $row["jid"] ?></td>
								<td><?php echo $row["job_title"] ?></td>
								<td><?php echo $row["tid"] ?></td>
								<td><?php echo $row["title_name"] ?></td>
								
								
								<td class="center">
									
									<div class="modal" id="myModal<?php echo $row[0] ?>">
									  <div class="modal-dialog">
									    <div class="modal-content">

									      <!-- Modal Header -->
									      <form method="POST" action="skills.php?action=update">
									      <div class="modal-header">
									        <h4 class="modal-title">Update skills id: <?php echo $row[0] ?></h4>
									        <button type="button" class="close" data-dismiss="modal">&times;</button>
									      </div>

									      <!-- Modal body -->
									      <div class="modal-body">
									        
									        	<input type="hidden" class="form-control" name="id" value="<?php echo $row[0] ?>">
											    <div class="form-group">
											      <label>skills Name:</label>
											      <input type="text" class="form-control" name="name" value="<?php echo $row[1] ?>">
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
									        <h4 class="modal-title">Delete skills id: <?php echo $row[0] ?></h4>
									        <button type="button" class="close" data-dismiss="modal">&times;</button>
									      </div>

									      <!-- Modal body -->
									      <div class="modal-body">
									        <h1>Are you sure???
									        </h1>
									        	
											    
											    
											  
									      </div>

									      <!-- Modal footer -->
									      <div class="modal-footer">
									      	<a class="btn btn-danger" href="jobtype.php?action=delete&id=<?php echo $row[0]?>">DELETE</a>
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