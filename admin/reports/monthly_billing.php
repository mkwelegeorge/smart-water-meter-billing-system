
<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<?php
$month = isset($_GET['month']) ? $_GET['month'] : date("Y-m");
?>
<div class="card card-outline rounded-0 card-navy">
	<div class="card-header">
		<h3 class="card-title">Monthly Billing Report</h3>
	</div>
	<div class="card-body">
        <div class="container-fluid">
            <fieldset class="border mb-4">
                <legend class="mx-3 w-auto">Filter</legend>
                <div class="container-fluid py-2 px-3">
                    <form action="" id="filter-form">
                        <div class="row align-items-end">
                            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                <div class="form-group m-0">
                                    <label for="month" class="control-label">Filter Month</label>
                                    <input type="month" id="month" name="month" value="<?= date("Y-m",strtotime($month."-1")) ?>" class="form-control form-control-sm rounded-0" required>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                                <button class="btn btn-primary bg-gradient-primary rounded-0"><i class="fa fa-filter"></i> Filter</button>
                                <button class="btn btn-light bg-gradient-light rounded-0 border" type="button" id="print"><i class="fa fa-print"></i> Print</button>
                            </div>
                        </div>
                    </form>
                </div>
            </fieldset>
        </div>
        <div class="container-fluid" id="printout">
			<table class="table table-hover table-striped table-bordered" id="report-tbl">
                <colgroup>
                    <col width="5%">
                    <col width="10%">
                    <col width="10%">
                    <col width="15%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                    <col width="10%">
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Reading Date</th>
                        <th>Due Date</th>
                        <th>Client</th>
                        <th>Reading</th>
                        <th>Consumption</th>
                        <th>Rate (m<sup>3</sup>)</th>
                        <th>Status</th>
                        <th>Amount</th>
                    </tr>
                </thead>
				<tbody>
					<?php 
					$i = 1;
						$qry = $conn->query("SELECT b.*, c.code , concat(c.lastname, ', ', c.firstname, ' ', coalesce(c.middlename,'')) as `name` from `billing_list` b inner join client_list c on b.client_id = c.id where date_format(b.reading_date, '%Y-%m') = '{$month}' order by unix_timestamp(`reading_date`) desc, `name` asc ");
						while($row = $qry->fetch_assoc()):
					?>
						 <tr>
                            <td class="text-center"><?php echo $i++; ?></td>
                            <td><?php echo date("Y-m-d",strtotime($row['reading_date'])) ?></td>
                            <td><?php echo date("Y-m-d",strtotime($row['due_date'])) ?></td>
                            <td>
                                <div style="line-height:1em">
                                    <div><?= format_num($row['code']) ?></div>
                                    <div><?= ($row['name']) ?></div>
                                </div>
                            </td>
                            <td>
                                <div style="line-height:1em">
                                    <div><small class="text-muter">Previous: </small><?= format_num($row['previous']) ?></div>
                                    <div><small class="text-muter">Current: </small><?= format_num($row['reading']) ?></div>
                                </div>
                            </td>
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
                    <?php if($qry->num_rows <= 0): ?>
                        <tr>
                            <th class="text-center" colspan="9">No data</th>
                        </tr>
                        ]
                    <?php endif; ?>
				</tbody>
			</table>
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
					<h3 class="text-center">Monthly Billing Report</h3>
                    <div class="text-center">as of</div>
                    <h4 class="text-center"><?= date("F, Y",strtotime($month."-1"))  ?></h4>
				</div>
			</div>
		</div>
		<hr>
	</div>
</noscript>
<script>
	$(document).ready(function(){
		$('#report-tbl td,#report-tbl th').addClass('py-1 px-2 align-middle')
        $('#filter-form').submit(function(e){
            e.preventDefault()
            location.href = './?page=reports/monthly_billing&'+$(this).serialize()
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
</script>