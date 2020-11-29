<?php						
    $this->load->view('template/modal_changepass');
	$this->load->view('template/modal_chat');	
?>
		
<div id="navbar" class="navbar navbar-default          ace-save-state">
	<div class="navbar-container ace-save-state" id="navbar-container">
		<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
			<span class="sr-only">Toggle sidebar</span>

			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
					
		</button>

		<div class="navbar-header pull-left">
			<a href="main.php" class="navbar-brand">
				<small>							
					<?= $app_title . " " . $app_version; ?>
				</small>
			</a>
		</div>

		<div class="navbar-buttons navbar-header pull-right" role="navigation">
			<ul class="nav ace-nav">
				
				<!-- 2020-05-01 -->
				<li class="light-blue dropdown-modal">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#">
						<i class="ace-icon fa fa-comment icon-animated-vertical"></i>
						<span class="badge badge-warning">!</span>
					</a>
				
					<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
						<li class="dropdown-header">
							<i class="ace-icon fa fa-comment"></i>
							Last Message
						</li>
				
						<li class="dropdown-content ace-scroll" style="position: relative;">
							<div class="scroll-track" style="display: none;">
								<div class="scroll-bar"></div>
							</div>
							<div class="scroll-content" style="max-height: 200px;">
								<ul class="dropdown-menu dropdown-navbar">
									<li>
										<a href="#" id="<?= $uid; ?>" class="clearfix common_chat chat_notification">
											<p>No Message</p>
										</a>
									</li>
									<li class="dropdown-footer">
										<a id="<?= $uid; ?>" class="common_chat" href="#">
											See all messages
											<i class="ace-icon fa fa-arrow-right"></i>
										</a>
									</li>
								</ul>
							</div>
						</li>
					</ul>
				</li>
		
				<!-- 2020-05-01 -->
				
				<li class="light-blue dropdown-modal">
					<a data-toggle="dropdown" href="#" class="dropdown-toggle">
						<img class="nav-user-photo" src="<?= base_url(); ?>assets/images/user.png" alt="User's Photo" />
						<span class="user-info">
							<small>Welcome,</small>									
							<?= $ufname; ?>
						</span>
						<i class="ace-icon fa fa-caret-down"></i>
					</a>
					<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
						<li>
							<a id="<?= $uid; ?>" class="common_changepass" href="#">
								<i class="ace-icon fa fa-key"></i>
								Change Password
							</a>
						</li>
						<li class="divider"></li>						
						<li>
							<a href="<?= base_url(); ?>authentication/logout">
								<i class="ace-icon fa fa-power-off"></i>
								Logout
							</a>
						</li>
					</ul>
				</li>
			</ul>
		</div>
	</div><!-- /.navbar-container -->
</div>
		
		
		