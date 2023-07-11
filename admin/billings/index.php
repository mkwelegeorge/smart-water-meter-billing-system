
<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<div class="card card-outline rounded-0 card-navy">
	<div class="card-header">
		<h3 class="card-title">List of Bill</h3>
		<div class="card-tools">
			<a href="./?page=billings/manage_billing" id="create_new" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>
		</div>
	</div>
	<div class="card-body">
        <div class="container-fluid">
			<table class="table table-hover table-striped table-bordered" id="list">
				<colgroup>
					<col width="5%">
					<col width="10%">
					<col width="25%">
					<col width="15%">
					<col width="20%">
					<col width="10%">
					<col width="15%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Reading Date</th>
						<th>Client</th>
						<th>Amount</th>
						<th>Due Date</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						$qry = $conn->query("SELECT b.*, c.code , concat(c.lastname, ', ', c.firstname, ' ', coalesce(c.middlename,'')) as `name` from `billing_list` b inner join client_list c on b.client_id = c.id order by unix_timestamp(`reading_date`) desc, `name` asc ");
						while($row = $qry->fetch_assoc()):
					?>
						<tr>
							<td class="text-center"><?php echo $i++; ?></td>
							<td><?php echo date("Y-m-d",strtotime($row['reading_date'])) ?></td>
							<td><?php echo $row['code'] ." - ".$row['name'] ?></td>
							<td><?php echo format_num($row['total']) ?></td>
							<td><?php echo date("Y-m-d",strtotime($row['due_date'])) ?></td>
							<td class="text-center">
								<?php
								switch($row['status']){
									case 0:
										echo '<span class="badge badge-secondary  bg-gradient-secondary  text-sm px-3 rounded-pill">Pending</span>';
										break;
									case 1:
										echo '<span class="badge badge-success bg-gradient-success text-sm px-3 rounded-pill">Paid</span>';
										break;
								}
								?>
                            </td>
							<td align="center">
								 <button type="button" class="btn btn-flat p-1 btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
				                    <a class="dropdown-item view_data" href="./?page=billings/view_billing&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-dark"></span> View</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item edit_data" href="./?page=billings/manage_billing&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
				                  </div>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this billing permanently?","delete_billing",[$(this).attr('data-id')])
		})
		$('.table').dataTable({
			columnDefs: [
					{ orderable: false, targets: [4] }
			],
			order:[0,'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
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
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>