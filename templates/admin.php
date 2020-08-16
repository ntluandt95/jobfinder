<?php include 'inc/adminheader.php'; ?>
<?php include '../lib/Database.php'; ?>
    
    <?php

	$getid =  $_GET["id"];
	$action =  $_GET["action"];
	$id=$_POST["id"];
	$name=$_POST["name"];
	$phone=$_POST["phone"];
	$address=$_POST["address"];
	$email=$_POST["email"];
	$array = array($id,$name,$phone,$address,$email);
	if ($action=='add') {
		
		$sql="insert into Employer values ($id,'$name','$phone','$address','$email')";
		//echo $sql;
		pg_query($dbhost, $sql);
	}if ($action=='update') {
		
		$sql="update Employer set employee_name='$name', phone_number='$phone', address='$address', email='$email' WHERE eid=$id";
		//echo $sql;
		pg_query($dbhost, $sql);
	}if ($action=='delete') {
		
		$sql="delete from employer where eid=$getid";
		//echo $sql;
		pg_query($dbhost, $sql);
	}
	$result = pg_query($dbhost, "SELECT * FROM employer");
	
        // If the $result variable is not defined, there was an error in the query
	if (!$result)
	{
		die("Error in query: ".pg_last_error());
	}

	

	
?>
		  <div class="col-md-10">
  			<div class="content-box-large">
  				<div class="panel-heading">
					<h3>Employer Table</h3>
					<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModaladd">Add</button>

								<div class="modal" id="myModaladd">
									  <div class="modal-dialog">
									    <div class="modal-content">

									      <!-- Modal Header -->
									      <form method="POST" action="admin.php?action=add">
									      <div class="modal-header">
									        <h4 class="modal-title">Add employee</h4>
									        <button type="button" class="close" data-dismiss="modal">&times;</button>
									      </div>

									      <!-- Modal body -->
									      <div class="modal-body">
									        	<label>ID:</label>
									        	<input type="text" class="form-control" name="id">
												<div class="form-group">
												<label>Employee Name:</label>
												<input type="text" class="form-control" name="name">
												</div>
												<div class="form-group">
												<label>Phone Number:</label>
												<input type="text" class="form-control" name="phone">
												</div>
												<div class="form-group">
												<label>Address:</label>
												<input type="text" class="form-control" name="address">
												</div>
												<div class="form-group">
												<label>Email:</label>
												<input type="email" class="form-control" name="email">
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
								<th>Employee Name</th>
								<th>Phone Number</th>
								<th>Address</th>
								<th>Email</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<?php while ($row = pg_fetch_array($result)){						
								?>
							<tr class="odd gradeX">
								<td><?php echo $row[0] ?></td>
								<td><?php echo $row[1] ?></td>
								<td><?php echo $row[2] ?></td>
								<td><?php echo $row[3] ?></td>
								<td><?php echo $row[4] ?></td>
								<td class="center">
									<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal<?php echo $row[0] ?>">UPDATE</button>
									<div class="modal" id="myModal<?php echo $row[0] ?>">
									  <div class="modal-dialog">
									    <div class="modal-content">

									      <!-- Modal Header -->
									      <form method="POST" action="admin.php?action=update">
									      <div class="modal-header">
									        <h4 class="modal-title">Update employee id: <?php echo $row[0] ?></h4>
									        <button type="button" class="close" data-dismiss="modal">&times;</button>
									      </div>

									      <!-- Modal body -->
									      <div class="modal-body">
									        
									        	<input type="hidden" class="form-control" name="id" value="<?php echo $row[0] ?>">
											    <div class="form-group">
											      <label>Employee Name:</label>
											      <input type="text" class="form-control" name="name" value="<?php echo $row[1] ?>">
											    </div>
											    <div class="form-group">
											      <label>Phone Number:</label>
											      <input type="text" class="form-control" name="phone" value="<?php echo $row[2] ?>">
											    </div>
											    <div class="form-group">
											      <label>Address:</label>
											      <input type="text" class="form-control" name="address" value="<?php echo $row[3] ?>">
											    </div>
											    <div class="form-group">
											      <label>Email:</label>
											      <input type="email" class="form-control" name="email" value="<?php echo $row[4] ?>">
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
									      	<a class="btn btn-danger" href="admin.php?action=delete&id=<?php echo $row[0]?>">DELETE</a>
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