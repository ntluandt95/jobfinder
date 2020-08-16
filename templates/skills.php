  <?php include 'inc/adminheader.php'; ?>
<?php include '../lib/Database.php'; ?>
    
    <?php

	$getid =  $_GET["id"];
	$action =  $_GET["action"];
	$id=$_POST["id"];
	$name=$_POST["name"];
	
	$array = array($id,$name,$phone,$address,$email);
	if ($action=='add') {
		
		$sql="insert into skills values ($id,'$name')";
		//echo $sql;
		pg_query($dbhost, $sql);
	}if ($action=='update') {
		
		$sql="update skills set skill_name='$name' WHERE sid=$id";
		//echo $sql;
		pg_query($dbhost, $sql);
	}if ($action=='delete') {
		
		$sql="delete from skills where sid=$getid";
		//echo $sql;
		pg_query($dbhost, $sql);
	}
	$result = pg_query($dbhost, "SELECT * FROM skills");
	
        // If the $result variable is not defined, there was an error in the query
	if (!$result)
	{
		die("Error in query: ".pg_last_error());
	}

	

	
?>
		  <div class="col-md-10">
  			<div class="content-box-large">
  				<div class="panel-heading">
					<h3>Skills Table</h3>
					<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModaladd">Add</button>

								<div class="modal" id="myModaladd">
									  <div class="modal-dialog">
									    <div class="modal-content">

									      <!-- Modal Header -->
									      <form method="POST" action="skills.php?action=add">
									      <div class="modal-header">
									        <h4 class="modal-title">Add skills</h4>
									        <button type="button" class="close" data-dismiss="modal">&times;</button>
									      </div>

									      <!-- Modal body -->
									      <div class="modal-body">
									        	<label>ID:</label>
									        	<input type="text" class="form-control" name="id">
												<div class="form-group">
												<label>skills Name:</label>
												<input type="text" class="form-control" name="name">
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
								<th>skills Name</th>
								
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php while ($row = pg_fetch_array($result)){						
								?>
							<tr class="odd gradeX">
								<td><?php echo $row[0] ?></td>
								<td><?php echo $row[1] ?></td>
								
								<td class="center">
									<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal<?php echo $row[0] ?>">UPDATE</button>
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
									      	<a class="btn btn-danger" href="skills.php?action=delete&id=<?php echo $row[0]?>">DELETE</a>
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