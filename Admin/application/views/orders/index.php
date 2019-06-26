
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1><?php echo $page_title; ?></h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><?php echo $page_title; ?></li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

        <?php if($this->session->flashdata('success')): ?>
          <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('success'); ?>
          </div>
        <?php elseif($this->session->flashdata('error')): ?>
          <div class="alert alert-error alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $this->session->flashdata('error'); ?>
          </div>
        <?php endif; ?>
		
		<?php $validError = validation_errors(); ?>
		<?php if(!empty($validError)): ?>
		<div class="alert alert-warning alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo $validError; ?>
          </div>
		<?php endif; ?>

		<div class="box box-danger">
			<div class="box-header with-border">
				<form class="form-horizontal" name="inputform" action="" method="get" >
					<div class="form-group">
						<label class="col-sm-1 control-label">Fromdate</label>
						<div class="col-sm-3">
							<input readonly class="form-control" name="fromDate" type="text" value="<?php if(isset($_GET["fromDate"])) echo $_GET["fromDate"] ?>" id="datepicker" autocomplete="off">
						</div>
						
						<label class="col-sm-1 control-label">Todate</label>
						<div class="col-sm-3">
							<input readonly class="form-control" name="toDate" type="text" value="<?php if(isset($_GET["toDate"])) echo $_GET["toDate"] ?>" id="datepicker1" autocomplete="off">
						</div>
						
						
					</div>
					<div class="form-group">
						<!--label class="col-sm-1 control-label">Reqid</label>
						<div class="col-sm-3">
							<input class="form-control" name="requestId" type="text" value="">
						</div>
						
						<label class="col-sm-1 control-label">Serial</label>
						<div class="col-sm-3">
							<input class="form-control" name="serial" type="text" value="">
						</div-->
						
						<label class="col-sm-1 control-label">Status</label>
						<div class="col-sm-3">
							<select class="form-control" name="slFinalStatus">
								<option value="" <?php echo isset($_GET["slFinalStatus"]) && $_GET["slFinalStatus"] == "0" ? "selected" : "" ?>>Chọn trạng thái</option> 
								<option value="00" <?php echo isset($_GET["slFinalStatus"]) && $_GET["slFinalStatus"] == "00" ? "selected" : "" ?>>Thành công</option>
								<option value="99" <?php echo isset($_GET["slFinalStatus"]) && $_GET["slFinalStatus"] == "99" ? "selected" : "" ?>>Pending</option>
								<option value="-1" <?php echo isset($_GET["slFinalStatus"]) && $_GET["slFinalStatus"] == "-1" ? "selected" : "" ?>>Thất bại</option>
							</select>
						</div>
					</div>
					
				
				<input class="btn btn-primary" type="submit" name="submit" value='Tìm kiếm' class="button">
				<input class="btn btn-success" type="submit" name="export" value="Xuất Excel">
				</form>
			</div>
			<div class="box-body">
			
				<?php if (isset($results) && !empty($results)) { ?>
					<h4>Tổng số đơn hàng: <?php echo $total_records; ?></h4>
					<table id="manageTable" class="table table-bordered table-striped" style="width: 100%;overflow-x: auto;white-space: nowrap;">
						<thead>
							<tr>
								<th>Id</th>
								<th>Username</th>
								<th>Amount</th>
								<th>Loại đơn hàng</th>
								<th>Loại nạp hộ</th>
								<th>Ghép thẻ</th>
								<th>Mệnh giá nhỏ nhất</th>
								<th>Ngày tạo đơn</th>
								<th>Trạng thái đơn hàng</th>
								<th>Ghi chú</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($results as $data) { ?>
								<tr>
									<td><?php echo $data['id'] ?></td>
									<td><?php echo $data['username'] ?></td>
									<td><?php echo number_format($data['amount']) ?></td>
									<td><?php echo $data['services_code'] ?></td>
									<td><?php echo $data['account_type_code'] ?></td>
									<td><?php echo $data['join_card'] ?></td>
									<td><?php echo $data['price_min'] ?></td>
									<td><?php echo $data['created_date'] ?></td>
									<td><?php echo $data['status'] ?></td>
									<td><?php echo $data['note'] ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				<?php } else { ?>
					<div>No data found.</div>
				<?php } ?>
	
				<?php if (isset($links)) { ?>
					<div class="box-footer clearfix">
						<?php echo $links ?>
					</div>
				<?php } ?>
            </div>
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<script type="text/javascript">
$( function() {
    $( "#datepicker" ).datepicker({ format: 'dd-mm-yyyy', todayHighlight: true, autoclose: true });
    $( "#datepicker1" ).datepicker({ format: 'dd-mm-yyyy', todayHighlight: true, autoclose: true });
	var fromDate = new Date();
	fromDate.setDate(fromDate.getDate() - 2);
	var fromDay = fromDate.getDate();
	var fromMonth = fromDate.getMonth() + 1;
	if (fromDay < 10) {
		fromDay = '0' + fromDay;
	}
	if(fromMonth < 10){
		fromMonth = '0' + fromMonth;
	}
	if($( "#datepicker" ).val() == ''){
		$('#datepicker').val((fromDay) + '-' + fromMonth + '-' + fromDate.getFullYear());
	}
	
	var today = new Date();
	var month = today.getMonth() + 1;
	var date = today.getDate();
	
	if (date < 10) {
		date = '0' + date;
	}
	if(month < 10){
		month = '0' + month;
	}
	if($( "#datepicker1" ).val() == ''){
		$('#datepicker1').val(date + '-' + month + '-' + today.getFullYear());
	}
} );

</script>