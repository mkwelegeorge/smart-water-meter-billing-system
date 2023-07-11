<?php

if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT b.*, concat(c.lastname, ', ', c.firstname,' ', coalesce(c.middlename)) as `name` FROM billing_list b inner join client_list c on b.client_id = c.id where b.id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }else{
        echo '<script> alert("Billing ID is invalid."); location.replace("./?page=billings");</script>';
    }
}else{
    echo '<script> alert("Billing ID is required."); location.replace("./?page=billings");</script>';
}
?>
<div class="mx-0 py-5 px-3 mx-ns-4 bg-gradient-primary">
	<h3><b>Billing Details</b></h3>
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
					<div class="container-fluid" id="printout">
						<div class="row">
							<div class="col-lg-4 col-md-5 col-sm-12 col-xs-12 py-3 font-weight-bolder border">Reading Date</div>
							<div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 py-3 border"><?= isset($reading_date) ? date("Y-m-d", strtotime($reading_date)) : '' ?></div>
							<div class="col-lg-4 col-md-5 col-sm-12 col-xs-12 py-3 font-weight-bolder border">Client Name</div>
							<div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 py-3 border"><?= isset($name) ? $name : '' ?></div>
							<div class="col-lg-4 col-md-5 col-sm-12 col-xs-12 py-3 font-weight-bolder border">Reading</div>
							<div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 py-3 border"><?= isset($reading) ? format_num($reading) : '' ?></div>
							<div class="col-lg-4 col-md-5 col-sm-12 col-xs-12 py-3 font-weight-bolder border">Previous</div>
							<div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 py-3 border"><?= isset($previous) ? format_num($previous) : '' ?></div>
							<div class="col-lg-4 col-md-5 col-sm-12 col-xs-12 py-3 font-weight-bolder border">Rate per Cubic Meter (m<sup>3</sup>)</div>
							<div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 py-3 border"><?= isset($rate) ? $rate : '' ?></div>
							<div class="col-lg-4 col-md-5 col-sm-12 col-xs-12 py-3 font-weight-bolder border">Total Amount</div>
							<div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 py-3 border"><?= isset($total) ? number_format($total) : '' ?></div>
							<div class="col-lg-4 col-md-5 col-sm-12 col-xs-12 py-3 font-weight-bolder border">Due Date</div>
							<div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 py-3 border"><?= isset($due_date) ? date("Y-m-d", strtotime($due_date)) : '' ?></div>
							<div class="clear-fix my-1"></div>
							<div class="col-lg-4 col-md-5 col-sm-12 col-xs-12 py-3 font-weight-bolder border">Status</div>
							<div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 py-3 border">
								<?php
									$status = isset($status) ? $status : 0 ;
									switch($status){
										case 0:
											echo '<span class="badge badge-secondary bg-gradient-secondary text-sm px-3 rounded-pill">Pending</span>';
											break;
										case 1:
											echo '<span class="badge badge-success bg-gradient-success text-sm px-3 rounded-pill">Paid</span>';
											break;
									}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="card-footer py-1 text-center">
				<button class="btn btn-light btn-sm bg-gradient-light border rounded-0" type="button" id="print"><i class="fa fa-print"></i> Print</button>
				<a class="btn btn-primary btn-sm bg-gradient-primary rounded-0" href="./?page=billings/manage_billing&id=<?= isset($id) ? $id :'' ?>"><i class="fa fa-edit"></i> Edit</a>
				<button class="btn btn-danger btn-sm bg-gradient-danger rounded-0" type="button" id="delete-data"><i class="fa fa-trash"></i> Delete</button>
				<a class="btn btn-light btn-sm bg-gradient-light border rounded-0" href="./?page=billings"><i class="fa fa-angle-left"></i> Back to List</a>
			</div>
		</div>
	</div>
</div>
<noscript id="print-header">
	<div>
		<div class="d-flex w-100 align-items-center">
			<div class="col-2 text-center">
				<img src="<?= validate_image($_settings->info('logo')) ?>" alt="" class="img-thumbnail rounded-circle" style="width:5em;height:5em;object-fit:cover;object-position:center center;">
			</div>
			<div class="col-8">
				<div style="line-height:1em">
					<h4 class="text-center"><?= $_settings->info('name') ?></h4>
					<h3 class="text-center">Billing Statement</h3>
				</div>
			</div>
		</div>
		<hr>
	</div>
</noscript>
<script>
	
	$(document).ready(function(){
        $('#delete-data').click(function(){
			_conf("Are you sure to delete this billing permanently?","delete_billing",['<?= isset($id) ? $id : '' ?>'])
		})
		$('#print').click(function(){
			var h = $('head').clone()
			var p = $('#printout').clone()
			var ph = $($('noscript#print-header').html()).clone()

			var nw = window.open('', '_blank','width='+($(window).width() * .80)+',height='+($(window).height() * .90)+',left='+($(window).width() * .1)+',top='+($(window).height() * .05))
					 nw.document.querySelector("head").innerHTML = h.html()
					 nw.document.querySelector("body").innerHTML = ph[0].outerHTML + p[0].outerHTML
					 nw.document.close()

					 start_loader()
					 setTimeout(() => {
						 nw.print()
						 setTimeout(() => {
							nw.close()
							end_loader() 
						 }, 300);
					 }, 300);
		})
	})
    function delete_billing($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_billing",
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
					location.replace("./?page=billings");
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>