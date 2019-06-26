

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
			<div class="box-header with-border">
					<?php $validError = validation_errors(); ?>
					<?php if(!empty($validError)): ?>
					<div class="alert alert-warning alert-dismissible" role="alert">
						<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<?php echo $validError; ?>
					  </div>
					<?php endif; ?>

			</div>
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

					 
						<form role="form" action="<?php base_url('quan-ly-tai-khoan-dai-ly/them-moi') ?>" method="post">
							<div class="box-body">
								<div class="row">
								
									<div class="col-md-6">
										<div class="form-group">
											<label for="username">Username</label>
											<input type="text" class="form-control" id="username" name="username" value="<?php echo set_value('username'); ?>" placeholder="Username" autocomplete="off">
										</div>
									</div>
									
									<div class="col-md-6">
										<div class="form-group">
											<label for="phone">Phone</label>
											<input type="text" class="form-control" id="phone" name="phone" value="<?php echo set_value('phone'); ?>" placeholder="phone" autocomplete="off">
										</div>
									</div>
									
									<div class="col-md-6">
										<div class="form-group">
											<label for="password">Password</label>
											<input type="text" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off">
										</div>
									</div>
								
									<div class="col-md-6">
										<div class="form-group">
											<label for="fullname">Full name</label>
											<input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo set_value('fullname'); ?>" placeholder="Full name" autocomplete="off">
										</div>
									</div>
									
									<div class="col-md-6">
										<div class="form-group">
											<label for="cpassword">Confirm password</label>
											<input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm Password" autocomplete="off">
										</div>
									</div>
								
									<div class="col-md-6">
										<div class="form-group">
											<label for="email">Email</label>
											<input type="email" class="form-control" id="email" name="email" value="<?php echo set_value('email'); ?>" placeholder="Email" autocomplete="off">
										</div>
									</div>
								
								</div>
							
							
							</div>
							<!-- /.box-body -->

							<div class="box-footer">
								<button type="submit" class="btn btn-primary">Save & Close</button>
								<a href="<?php echo base_url('quan-ly-tai-khoan-dai-ly') ?>" class="btn btn-warning">Back</a>
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
		   
		  <!-- /.box -->

	</section>
</div>