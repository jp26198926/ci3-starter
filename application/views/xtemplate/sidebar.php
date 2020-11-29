<div id="sidebar" class="sidebar responsive ace-save-state">
	<script type="text/javascript">
		try {
			ace.settings.loadState('sidebar')
		} catch (e) {}
	</script>

	<div class="sidebar-shortcuts" id="sidebar-shortcuts">
		<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
			<button id="<?= $uid; ?>" class="btn btn-success common_chat">
				<i class="ace-icon fa fa-comment"></i>
			</button>
			<a href="<?= base_url(); ?>" class="btn btn-info">
				<i class="ace-icon fa fa-question-circle"></i>
			</a>
			<a href="<?= base_url(); ?>admin_user" class="btn btn-warning">
				<i class="ace-icon fa fa-users"></i>
			</a>
			<a href="<?= base_url(); ?>maintenance_settings" class="btn btn-danger">
				<i class="ace-icon fa fa-cogs"></i>
			</a>
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
		$current_parent_module = "";
		$parent_list = $this->session->userdata[$prefix . '_logged_in'][$prefix . '_parents'];
		$module_list = $this->session->userdata[$prefix . '_logged_in'][$prefix . '_modules'];

		if ($parent_list) {
			foreach ($parent_list as $keyp => $rowp) {
				$parent_id = $rowp->parent_id;
				$parent_name = strtoupper($rowp->parent_name);
				$parent_icon = $rowp->parent_icon;

				$active_open = strtolower($parent_menu) === strtolower($parent_name) ? "active open" : "";

				//print parent
				echo "	<li class='main-menu {$active_open}' >
								<a href='#' class='dropdown-toggle'>
									<i class='menu-icon fa {$parent_icon}'></i>
									<span class='menu-text'>{$parent_name}</span>
									<b class='arrow fa fa-angle-down'></b>
								</a>					
								<b class='arrow'></b>					
								<ul class='submenu'>";

				//print modules	
				foreach ($module_list as $keym => $rowm) {
					$module_name = $rowm->module_name;
					$module_description = ucwords($rowm->module_description);
					$active = strtolower($module) === strtolower($module_name) ? "active" : "";
					$module_link = base_url() . strtolower($module_name);
					$module_parent_id = $rowm->parent_id;

					if (intval($module_parent_id) == intval($parent_id)) {

						echo "	<li class='sub-menu {$active}'>
										<a id='{$module_name}' class='menu-link' href='{$module_link}' >
											<i class='menu-icon fa fa-caret-right'></i>
											{$module_description}
										</a>
										<b class='arrow'></b>
									</li>";
					}
				}

				echo "		</ul>
							</li>";
			}
		}
		?>

	</ul><!-- /.nav-list -->

	<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
		<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
	</div>
</div>