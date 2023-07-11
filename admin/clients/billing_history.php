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
	<h3><b><?= isset($code) ? $code : '' ?> - <?= isset($name) ? $name : '' ?></b></h3>
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
            <div class="card-header">
                <h5 class="card-title">Client Billing History</h5>
            </div>
			<div class="card-body">
				<div class="container-fluid">
                    <table class="table table-hover table-striped table-bordered" id="list">
                        <colgroup>
                            <col width="5%">
                            <col width="10%">
                            <col width="10%">
                            <col width="10%">
                            <col width="10%">
                            <col width="10%">
                            <col width="10%">
                            <col width="10%">
                            <col width="15%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Reading Date</th>
                                <th>Due Date</th>
                                <th>Current Reading</th>
                                <th>Previous Reading</th>
                                <th>Consumption</th>
                                <th>Rate (m<sup>3</sup>)</th>
                                <th>Status</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($id)): ?>
                            <?php 
                            $i = 1;
                                $qry = $conn->query("SELECT b.*, c.code , concat(c.lastname, ', ', c.firstname, ' ', coalesce(c.middlename,'')) as `name` from `billing_list` b inner join client_list c on b.client_id = c.id where c.id = '{$id}' order by unix_timestamp(`reading_date`) desc, `name` asc ");
                                while($row = $qry->fetch_assoc()):
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++; ?></td>
                                    <td><?php echo date("Y-m-d",strtotime($row['reading_date'])) ?></td>
                                    <td><?php echo date("Y-m-d",strtotime($row['due_date'])) ?></td>
                                    <td class="text-right"><?= number_format($row['reading']) ?></td>
                                    <td class="text-right"><?= number_format($row['previous']) ?></td>
                                    <td class="text-right"><?php echo format_num($row['reading'] - $row['previous']) ?></td>
                                    <td class="text-right"><?= format_num($row['rate']) ?></td>
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
                                    <td class="text-right"><?php echo format_num($row['total']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
				</div>
			</div>
			<div class="card-footer py-1 text-center">
				<a class="btn btn-light btn-sm bg-gradient-light border rounded-0" href="./?page=clients/view_client&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-angle-left"></i> Back </a>
			</div>
		</div>
	</div>
</div>
<script>
	
	$(document).ready(function(){
        $('.table').dataTable({
			columnDefs: [
					{ orderable: false, targets: [4] }
			],
			order:[0,'asc']
		});
	})
    
</script>