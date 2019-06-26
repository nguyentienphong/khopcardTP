
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
					
						<label class="col-sm-1 control-label">Tên tài khoản</label>
						<div class="col-sm-3">
							<input class="form-control" name="username" type="text" value="<?php echo set_value('username') ?>" autocomplete="off">
						</div>
						
					</div>
					
				<input class="btn btn-primary" type="submit" name="submit" value='Tìm kiếm' class="button">
				
				</form>
			</div>
			<div class="box-body">
			
				<?php if (isset($results) && !empty($results)) { ?>
				<div style="overflow-x: auto;">
					<h4 style="float:left">Tổng số tài khoản: <?php echo $total_records; ?></h4>
					<a href="<?php echo base_url('quan-ly-tai-khoan-dai-ly/them-moi'); ?>" class="btn btn-success pull-right">Thêm mới</a>
					<table id="manageTable" class="table table-bordered table-striped" style="width: 100%;overflow-x: auto;white-space: nowrap;">
						<thead>
							<tr>
								<th>User Name</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Full name</th>
								<th>Balance</th>
								<th>Trạng thái</th>
								<th>Thao tác</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($results as $data) { ?>
								<tr>
									<td><?php echo $data->username ?></td>
									<td><?php echo $data->email ?></td>
									<td><?php echo $data->phone ?></td>
									<td><?php echo $data->fullname ?></td>
									<td><?php echo number_format($data->balance) ?></td>
									<td><?php
										switch($data->active){
											case '1' : echo "Đang hoạt động";
											break;
											case '2' : echo "Đang khóa";
											break;
										}
									?>
									</td>
									<td>
										<a class="btn btn-info btn-sm" data-widget="Edit" data-toggle="tooltip" title="Edit" href="<?php echo base_url('quan-ly-tai-khoan-dai-ly/chinh-sua/') . $data->id; ?>">
										  <i class="fa fa-edit"></i></a>
										<?php if($data->active == '1'): ?>
										<a type="button" class="btn btn-danger btn-sm locknlock" data-user_status="<?php echo $data->active ?>"  data-user_id="<?php echo $data->id ?>" data-user_name="<?php echo $data->username ?>" data-target="#lock-unlock" data-toggle="modal" data-widget="Khóa tài khoản" data-toggle="tooltip" title="Khóa tài khoản">
										   
										  <i class="fa fa-lock"></i></a>
										<?php endif; ?>
										
										<?php if($data->active == '2'): ?>
										<a type="button" class="btn btn-warning btn-sm locknlock" data-user_status="<?php echo $data->active ?>"  data-user_id="<?php echo $data->id ?>" data-user_name="<?php echo $data->username ?>" data-target="#lock-unlock" data-toggle="modal" data-widget="Mở khóa tài khoản" data-toggle="tooltip" title="Mở khóa tài khoản">
										  <i class="fa fa-unlock"></i></a>
										<?php endif; ?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
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


	<div class="modal fade" id="lock-unlock" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel"></h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<h5>Bạn có chắc chắn muốn <i class="modal-title"></i> : <b id="user_name"></b></h5>
		  </div>
		  <div class="modal-footer">
			<form action="<?php echo base_url('quan-ly-tai-khoan-dai-ly/khoa-tai-khoan/') ?>" method="post">
				<input name="user_id" type="hidden" value="">
				<input name="user_status" type="hidden" value="">
				
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Đồng ý</button>
			</form>
		  </div>
		</div>
	  </div>
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
	
	$(document).on('click','.locknlock',function(){
		var widget = $(this).data("widget");
		var user_id = $(this).data("user_id");
		var user_name = $(this).data("user_name");
		var user_status = $(this).data("user_status");
		$('.modal-title').html(widget);
		$('#user_name').html(user_name);
		$("input[name='user_id']").val(user_id);
		$("input[name='user_status']").val(user_status);
	});
} );

</script>