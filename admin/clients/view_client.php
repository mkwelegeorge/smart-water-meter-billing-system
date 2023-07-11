<?php

if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT *, concat(lastname, ', ', firstname,' ', coalesce(middlename,'')) as `name` FROM client_list where id = '{$_GET['id']}' and delete_flag = 0");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }else{
        echo '<script> alert("Client ID is invalid."); location.replace("./?page=clients");</script>';
    }
}else{
    echo '<script> alert("Client ID is required."); location.replace("./?page=clients");</script>';
}
?>
<div class="mx-0 py-5 px-3 mx-ns-4 bg-gradient-primary">
	<h3><b>Client Details</b></h3>
</div>
<style>
	img#cimg{
      max-height: 15em;
      object-fit: scale-down;
    }
</style>
<div class="row justify-content-center" style="margin-top:-2em;">
	<div class="col-lg-10 col-md-11 col-sm-11 col-xs-11">
		<div class="card rounded-0 shadow">
			<div class="card-body">
				<div class="container-fluid">
					<div class="container-fluid">
						<div class="row">
							<div class="col-lg-4 col-md-5 col-sm-12 col-xs-12 py-3 font-weight-bolder border">Code</div>
							<div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 py-3 border"><?= isset($code) ? $code : '' ?></div>
							<div class="col-lg-4 col-md-5 col-sm-12 col-xs-12 py-3 font-weight-bolder border">Client Name</div>
							<div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 py-3 border"><?= isset($name) ? $name : '' ?></div>
							<div class="col-lg-4 col-md-5 col-sm-12 col-xs-12 py-3 font-weight-bolder border">Contact #</div>
							<div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 py-3 border"><?= isset($contact) ? $contact : '' ?></div>
							<div class="col-lg-4 col-md-5 col-sm-12 col-xs-12 py-3 font-weight-bolder border">Address</div>
							<div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 py-3 border"><?= isset($address) ? $address : '' ?></div>
							<div class="col-lg-4 col-md-5 col-sm-12 col-xs-12 py-3 font-weight-bolder border">Meter Code</div>
							<div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 py-3 border"><?= isset($meter_code) ? $meter_code : '' ?></div>
							<div class="col-lg-4 col-md-5 col-sm-12 col-xs-12 py-3 font-weight-bolder border">Meter First Reading</div>
							<div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 py-3 border"><?= isset($first_reading) ? $first_reading : '' ?></div>
							<div class="col-lg-4 col-md-5 col-sm-12 col-xs-12 py-3 font-weight-bolder border">Date Created</div>
							<div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 py-3 border"><?= isset($date_created) ? date("F d, Y", strtotime($date_created)) : '' ?></div>
							<div class="clear-fix my-1"></div>
							<div class="col-lg-4 col-md-5 col-sm-12 col-xs-12 py-3 font-weight-bolder border">Status</div>
							<div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 py-3 border">
								<?php
									$status = isset($status) ? $status : 0 ;
									switch($status){
										case 1:
											echo '<span class="badge badge-primary bg-gradient-primary text-sm px-3 rounded-pill">Active</span>';
											break;
										case 2:
											echo '<span class="badge badge-danger bg-gradient-danger text-sm px-3 rounded-pill">Inactive</span>';
											break;
									}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer py-1 text-center">
				<a class="btn btn-light btn-sm bg-gradient-light border rounded-0" href="./?page=clients/billing_history&id=<?= isset($id) ? $id :'' ?>"><i class="fa fa-table"></i> Billing History</a>
				<a class="btn btn-primary btn-sm bg-gradient-primary rounded-0" href="./?page=clients/manage_client&id=<?= isset($id) ? $id :'' ?>"><i class="fa fa-edit"></i> Edit</a>
				<button class="btn btn-danger btn-sm bg-gradient-danger rounded-0" type="button" id="delete-data"><i class="fa fa-trash"></i> Delete</button>
				<a class="btn btn-light btn-sm bg-gradient-light border rounded-0" href="./?page=clients"><i class="fa fa-angle-left"></i> Back to List</a>
			</div>
		</div>
	</div>
</div>
<script>
	
	$(document).ready(function(){
        $('#delete-data').click(function(){
			_conf("Are you sure to delete this client permanently?","delete_client",['<?= isset($id) ? $id : '' ?>'])
		})
	})
    function delete_client($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_client",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.replace("./?page=clients");
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>