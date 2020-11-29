<div id="sidebar" class="sidebar responsive ace-save-state">
     <script type="text/javascript">
		try{ace.settings.loadState('sidebar')}catch(e){}
	</script>

	<div class="sidebar-shortcuts" id="sidebar-shortcuts">
		<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
			<button class="btn btn-success">
				<i class="ace-icon fa fa-comment"></i>
			</button>
			<button class="btn btn-info">
				<i class="ace-icon fa fa-question-circle"></i>
			</button>
			<button class="btn btn-warning">
				<i class="ace-icon fa fa-users"></i>
			</button>
			<button class="btn btn-danger">
				<i class="ace-icon fa fa-cogs"></i>
			</button>
		</div>
		<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
			<span class="btn btn-success"></span>
			<span class="btn btn-info"></span>
			<span class="btn btn-warning"></span>
			<span class="btn btn-danger"></span>
		</div>
	</div><!-- /.sidebar-shortcuts -->

	<ul class="nav nav-list">
		<li class='main-menu'>
			<a id='main' class='menu-link' href='<?= base_url(); ?>'>
				<i class='menu-icon fa fa-tachometer'></i>
				<span class='menu-text'> DASHBOARD </span>
			</a>
			<b class='arrow'></b>
		</li>
					
		<?php
			$current_parent_module="";
			$module_list = $this->session->userdata[$prefix . '_logged_in'][$prefix . '_modules'];
						
			if ($module_list){
				foreach($module_list as $key => $row){
					$module_name = $row->module_name;
					$module_description = ucwords($row->module_description);
					$module_parent = strtoupper($row->parent_module);
					$module_icon = $row->module_icon;
					$active_open = strtolower($parent_menu)===strtolower($module_parent) ? "active open" : "";
					$active = strtolower($module)===strtolower($module_name) ? "active" : "";
					$module_link = base_url() . strtolower($module_name) ;
								
					if ($module_parent !== strtoupper($current_parent_module)){
									
									if ($current_parent_module !== ""){
										//close the parent menu tag
										echo "		</ul>
												</li>";
									}
									
									//print parent menu
									echo "	<li class='main-menu {$active_open}' >
												<a href='#' class='dropdown-toggle'>
													<i class='menu-icon fa {$module_icon}'></i>
													<span class='menu-text'>
														{$module_parent}
													</span>
													<b class='arrow fa fa-angle-down'></b>
												</a>					
												<b class='arrow'></b>					
												<ul class='submenu'>";
									
									//print 1st module
									echo "	<li class='sub-menu {$active}'>
												<a id='{$module_name}' class='menu-link' href='{$module_link}' >
													<i class='menu-icon fa fa-caret-right'></i>
														{$module_description}
												</a>
												<b class='arrow'></b>
											</li>";
									
									$current_parent_module = $module_parent;
									
								}else{
									//print next module
									echo "	<li class='sub-menu {$active}'>
												<a id='{$module_name}' class='menu-link' href='{$module_link}' >
													<i class='menu-icon fa fa-caret-right'></i>
														{$module_description}
												</a>
												<b class='arrow'></b>
											</li>";
								}
							}
						}
					?>
				
				</ul><!-- /.nav-list -->

				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>
			</div>