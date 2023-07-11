<div>
  <h1>Welcome to <?php echo $_settings->info('name') ?> </h1>
  <button onclick='turnOn()'>Pump on</button>
  <button onClick='turnOff()'>Pump Off</button>
</div>
<hr>
<style>
  #site-cover {
    width:100%;
    height:40em;
    object-fit: cover;
    object-position:center center;
  }
</style>
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-gradient-secondary elevation-1"><i class="fas fa-th-list"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Categories</span>
          <span class="info-box-number">
            <?php 
              $categorys = $conn->query("SELECT * FROM category_list where delete_flag = 0 ")->num_rows;
              echo format_num($categorys);
            ?>
            <?php ?>
          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-gradient-success elevation-1"><i class="fas fa-users"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Total Clients</span>
          <span class="info-box-number">
            <?php 
              $clients = $conn->query("SELECT * FROM client_list where `delete_flag` = 0")->num_rows;
              echo format_num($clients);
            ?>
            <?php ?>
          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
      <div class="info-box">
        <span class="info-box-icon bg-gradient-danger elevation-1"><i class="fas fa-file-invoice"></i></span>
        <div class="info-box-content">
          <span class="info-box-text">Pending Bills</span>
          <span class="info-box-number">
            <?php 
              $billings = $conn->query("SELECT * FROM billing_list where `status` = 0")->num_rows;
              echo format_num($billings);
            ?>
            <?php ?>
          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
</div>
<hr>
<center>
  <img src="<?= validate_image($_settings->info('cover')) ?>" alt="<?= validate_image($_settings->info('logo')) ?>" id="site-cover" class="img-fluid w-100">
</center>
<script>
function turnOn() {
  fetch('http://localhost:3000/pump/1')
    .then(res => console.log(res.data));
}
function turnOff(){
  fetch('http://localhost:3000/pump/0')
    .then(res => console.log(res.data));
}
</script>