
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <?php 
			$ci =& get_instance();
			$uri = $ci->uri->segment(1); 
			
			$group_id = $ci->session->userdata('group_id');
			
		?>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
		
		<li <?php echo ($uri != null && $uri == 'quan-ly-don-hang') ? 'class="active"' : '' ?>>
			<a href="<?php echo base_url('quan-ly-don-hang/') ?>">
				<i class="fa fa-shopping-cart"></i> <span>Quản lý đơn hàng</span>
			</a>
		</li>
		
		<!--li class="treeview <?php echo ($uri != null && in_array($uri, array('cong-tien-dai-ly', 'tru-tien-dai-ly'))) ? 'active' : '' ?>">
			<a href="#">
				<i class="fa fa-list"></i> <span>Cộng từ tiền đại lý</span>
				<span class="pull-right-container">
				  <i class="fa fa-angle-left pull-right"></i>
				</span>
			</a>
			
			<ul class="treeview-menu" style="">
				<li class="<?php echo ($uri != null && $uri == 'cong-tien-dai-ly') ? 'active' : '' ?>"><a href="<?php echo base_url('cong-tien-dai-ly/') ?>"><i class="fa fa-gg"></i> <span>Cộng tiền</span></a></li>
				<li class="<?php echo ($uri != null && $uri == 'tru-tien-dai-ly') ? 'active' : '' ?>"><a href="<?php echo base_url('tru-tien-dai-ly/') ?>"><i class="fa fa-gg"></i> Từ tiền</a></li>
				
			</ul>
			
		</li-->
		
		<li <?php echo ($uri != null && $uri == 'cong-tien-dai-ly') ? 'class="active"' : '' ?>>
			<a href="<?php echo base_url('cong-tien-dai-ly/') ?>">
				<i class="fa fa-dollar"></i> <span>Cộng từ tiền đại lý</span>
			</a>
		</li>
		
		<li <?php echo ($uri != null && $uri == 'quan-ly-tai-khoan-dai-ly') ? 'class="active"' : '' ?>>
			<a href="<?php echo base_url('quan-ly-tai-khoan-dai-ly/') ?>">
				<i class="fa fa-users"></i> <span>Quản lý tài khoản đại lý</span>
			</a>
		</li>
		
		<li <?php echo ($uri != null && $uri == 'doi-mat-khau') ? 'class="active"' : '' ?>>
			<a href="<?php echo base_url('doi-mat-khau/') ?>">
				<i class="fa fa-reorder"></i> <span>Đổi mật khẩu</span>
			</a>
		</li>

        <!-- user permission info -->
        <li><a href="<?php echo base_url('auth/logout') ?>"><i class="glyphicon glyphicon-log-out"></i> <span>Logout</span></a></li>

      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>