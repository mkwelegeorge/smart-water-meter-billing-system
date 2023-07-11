<?php
require_once('./../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * FROM category_list where id = '{$_GET['id']}' and delete_flag = 0");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }else{
        echo '<script> alert("Category ID is invalid."); location.replace("./?page=category");</script>';
    }
}else{
    echo '<script> alert("Category ID is required."); location.replace("./?page=category");</script>';
}
?>
<style>
	#uni_modal .modal-footer{
		display:none;
	}
</style>
<div class="container-fluid">
	<dl>
		<dt class="text-muted">Name</dt>
		<dd class="h5 pl-4"><?= $name ?></dd>
		<dt class="text-muted">Status</dt>
		<td class="pl-4">
		<?php
			$status = isset($status) ? $status : 0;
			switch($status){
				case 1:
					echo '<span class="badge badge-primary bg-gradient-primary text-sm px-3 rounded-pill"> Active</span>';
					break;
				case 2:
					echo '<span class="badge badge-danger bg-gradient-danger text-sm px-3 rounded-pill"> Inactive</span>';
					break;
			}
		?>
		</td>
	</dl>
</div>
<div class="text-right py-3">
	<button class="btn btn-primary-light btn-sm bg-gradient-light border" type="button" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
</div>