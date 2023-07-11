<?php

if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `client_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>
<div class="mx-0 py-5 px-3 mx-ns-4 bg-gradient-primary">
	<h3><b><?= isset($id) ? "Update Client Details - ".(isset($code) ? $code : '') : "Create New Client" ?></b></h3>
</div>
<style>
	img#cimg{
      max-height: 15em;
      width: 100%;
      object-fit: scale-down;
    }
</style>
<div class="row justify-content-center" style="margin-top:-2em;">
	<div class="col-lg-10 col-md-11 col-sm-11 col-xs-11">
		<div class="card rounded-0 shadow">
			<div class="card-body">
				<div class="container-fluid">
					<div class="container-fluid">
						<form action="" id="client-form">
							<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
							<div class="form-group mb-3">
								<label for="category_id" class="control-label">Category</label>
								<select name="category_id" id="category_id" class="form-control form-control-sm rounded-0" required="required">
									<option value="" <?= !isset($category_id) ? 'selected' : '' ?> disabled></option>
									<?php 
									$category_qry = $conn->query("SELECT * FROM `category_list` where delete_flag = 0 and `status` = 1 ".(isset($category_id) && is_numeric($category_id) ? " or id != '{$category_id}' " : '')." ");
									while($row = $category_qry->fetch_assoc()):
									?>
									<option value="<?=  $row['id'] ?>" <?= isset($category_id) && $category_id == $row['id'] ? "selected" : '' ?>><?= $row['name'] ?></option>
									<?php endwhile; ?>
								</select>
							</div>
							<div class="form-group mb-3">
								<label for="firstname" class="control-label">First Name</label>
								<input type="text" class="form-control form-control-sm rounded-0" id="firstname" name="firstname" required="required" value="<?= isset($firstname) ? $firstname : '' ?>"/>
							</div>
							<div class="form-group mb-3">
								<label for="middlename" class="control-label">Middle Name</label>
								<input type="text" class="form-control form-control-sm rounded-0" id="middlename" name="middlename" placeholder="optional" value="<?= isset($middlename) ? $middlename : '' ?>"/>
							</div>
							<div class="form-group mb-3">
								<label for="lastname" class="control-label">Last Name</label>
								<input type="text" class="form-control form-control-sm rounded-0" id="lastname" name="lastname" required value="<?= isset($lastname) ? $lastname : '' ?>"/>
							</div>
							<div class="form-group mb-3">
								<label for="contact" class="control-label">Contact #</label>
								<input type="text" class="form-control form-control-sm rounded-0" id="contact" name="contact" required value="<?= isset($contact) ? $contact : '' ?>"/>
							</div>
							<div class="form-group mb-3">
								<label for="address" class="control-label">Address</label>
								<textarea rows="3" class="form-control form-control-sm rounded-0" id="address" name="address" required="required"><?= isset($address) ? $address : '' ?></textarea>
							</div>
							<div class="form-group p-0 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-3">
								<label for="meter_code" class="control-label">Meter Code</label>
								<input type="text" class="form-control form-control-sm rounded-0" id="meter_code" name="meter_code" value="<?= isset($meter_code) ? $meter_code : '' ?>" required="required">
							</div>
							<div class="form-group p-0 col-lg-6 col-md-6 col-sm-12 col-xs-12 mb-3">
								<label for="first_reading" class="control-label">First Reading</label>
								<input type="text" class="form-control form-control-sm rounded-0" id="first_reading" name="first_reading" value="<?= isset($first_reading) ? $first_reading : '' ?>" required="required">
							</div>
							<div class="form-group">
								<label for="status" class="control-label">Status</label>
								<select name="status" id="status" class="form-control form-control-sm rounded-0" required>
								<option value="1" <?php echo isset($status) && $status == 1 ? 'selected' : '' ?>>Active</option>
								<option value="2" <?php echo isset($status) && $status == 2 ? 'selected' : '' ?>>Inactive</option>
								</select>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="card-footer py-1 text-center">
				<button class="btn btn-primary btn-sm bg-gradient-primary rounded-0" form="client-form"><i class="fa fa-save"></i> Save</button>
				<a class="btn btn-light btn-sm bg-gradient-light border rounded-0" href="./?page=clients"><i class="fa fa-angle-left"></i> Cancel</a>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#category_id').select2({
			placeholder:"Please Select Here",
			containerCssClass:'form-control form-control-sm rounded-0'
		})
		$('#client-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_client",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.href = "./?page=clients/view_client&id="+resp.aid
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body, .modal").scrollTop(0)
                            end_loader()
                    }else{
						alert_toast("An error occured",'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
		})

	})
</script>