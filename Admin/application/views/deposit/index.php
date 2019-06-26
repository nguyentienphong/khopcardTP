

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
<section class="content">

      <!-- SELECT2 EXAMPLE -->
      <div class="box box-danger">
        <!--div class="box-header with-border">

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
          </div>
        </div-->
        <!-- /.box-header -->
        <div class="box-body">
          <div class="row">
        <div class="col-md-12 col-xs-12">
          
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
		 
            <form class="form-horizontal" role="form" action="" method="post" enctype="multipart/form-data">
              <div class="box-body">

                <div class="row">
					
					<div class="form-group">
						<div class="col-md-4">
							<label class="col-sm-2 control-label" for="partner_name">User</label>
							<select class="form-control" name="id">
								<option value="">Chọn user</option>
								<?php foreach ($user_list as $k => $v): ?>
								<option value="<?php echo $v->id; ?>" <?php if (isset($_POST['id']) && $_POST['id'] == $v->id ) echo 'selected' ; ?>><?php echo $v->username ?></option>
								<?php endforeach ?>
							</select>
						</div>
						
						<div class="col-md-4">
							<label class="col-sm-2 control-label" for="partner_name">Loại</label>
							<select class="form-control" name="type">
								<option value="">Chọn loại</option>
								<option value="1" <?php if (isset($_POST['type']) && $_POST['type'] == '1') echo 'selected' ; ?>>Cộng tiền</option>
								<option value="2" <?php if (isset($_POST['type']) && $_POST['type'] == '2') echo 'selected' ; ?>>Trừ tiền</option>
							</select>
						</div>
						
					</div>
					<div class="form-group">
						<div class="col-md-4">
							<label class="col-sm-2 control-label" for="amount" style="white-space: nowrap;">Số tiền</label>
							<input class="form-control change_currency" name="amount" value="<?php echo set_value('amount'); ?>">
						</div>
						
						<div class="col-lg-6 col-md-4">
							<label class="col-sm-2 control-label" for="description" >Ghi chú</label>
							<textarea maxlength="100" class="form-control" name="message" rows="3" placeholder="Enter ..."></textarea>
						</div>
						
					</div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Save & Close</button>
              </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!-- col-md-12 -->
      </div>
          <!-- /.row -->
        </div>
        <!-- /.box-body -->
       
      </div>
      <!-- /.box -->

    </section>
	
<script>
$(document).ready(function () {
	$('body').on('keyup','.change_currency',function(){
    
        var $input = $(this);
            value = $input.val();
			newnumb = value.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",");
			
        $input.val(newnumb);
    });
	
});
</script>