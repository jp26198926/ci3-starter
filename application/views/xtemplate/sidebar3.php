            <div id="sidebar" class="sidebar                  responsive                    ace-save-state">
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
					<li class="main-menu">
						<a id='main' class='menu-link' href="#">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> DASHBOARD </span>
						</a>
						<b class="arrow"></b>
					</li>
					
					<!-- File201 -->
					<li class="main-menu <?= $parent_menu==='file 201' ? 'active open' : ''; ?>" >
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-users"></i>
							<span class="menu-text">
								FILE 201
							</span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="sub-menu <?= $module==='f_file201' ? 'active':''; ?>">
								<a id='f_file201' class='menu-link' href="<?= base_url(); ?>f_file201" >
									<i class="menu-icon fa fa-caret-right"></i>
									Employee
								</a>
								<b class="arrow"></b>
							</li>
							
							<li class="sub-menu <?= $module==='f_dept' ? 'active':''; ?>">
								<a id='f_dept' class='menu-link' href="<?= base_url(); ?>f_dept" >
									<i class="menu-icon fa fa-caret-right"></i>
									Department
								</a>
								<b class="arrow"></b>
							</li>
							
							<li class="sub-menu <?= $module==='f_costcentre' ? 'active':''; ?>">
								<a id='f_costcentre' class='menu-link' href="<?= base_url(); ?>f_costcentre" >
									<i class="menu-icon fa fa-caret-right"></i>
									Costcentre / Division
								</a>
								<b class="arrow"></b>
							</li>
							
							<li class="sub-menu">
								<a class='menu-link' href="#">
									<i class="menu-icon fa fa-caret-right"></i>
									Manning Report
								</a>
								<b class="arrow"></b>
							</li>
							
							<li class="sub-menu">
								<a class='menu-link' href="#">
									<i class="menu-icon fa fa-caret-right"></i>
									CV Generator
								</a>
								<b class="arrow"></b>
							</li>
							
						</ul>
					</li>					
					
					<!-- Timekeeping -->
					<li class="main-menu <?= $parent_menu==='timekeeping' ? 'active open' : ''; ?>" >
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-calendar"></i>
							<span class="menu-text">
								TIMEKEEPING
							</span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="sub-menu <?= $module==='tk_terminal' ? 'active':''; ?>">
								<a id='tk_terminal' class='menu-link' href="<?= base_url(); ?>tk_terminal" >
									<i class="menu-icon fa fa-caret-right"></i>
									Terminal Location
								</a>
								<b class="arrow"></b>
							</li>
							
							<li class="sub-menu <?= $module==='tk_schedule' ? 'active':''; ?>">
								<a id='schedule' class='menu-link' href="<?= base_url(); ?>tk_schedule" >
									<i class="menu-icon fa fa-caret-right"></i>
									Schedule
								</a>
								<b class="arrow"></b>
							</li>
							
							<li class="sub-menu <?= $module==='tk_setschedule' ? 'active':''; ?>">
								<a id='setschedule' class='menu-link' href="<?= base_url(); ?>tk_setschedule" >
									<i class="menu-icon fa fa-caret-right"></i>
									Set Schedule
								</a>
								<b class="arrow"></b>
							</li>
							
							<li class="sub-menu <?= $module==='tk_timelog' ? 'active':''; ?>">
								<a id='timelog' class='menu-link' href="<?= base_url(); ?>tk_timelog">
									<i class="menu-icon fa fa-caret-right"></i>
									Time Log
								</a>
								<b class="arrow"></b>
							</li>
							
							<li class="sub-menu <?= $module==='tk_timesheet' ? 'active':''; ?>">
								<a id='timesheet' class='menu-link' href="<?= base_url(); ?>tk_timesheet">
									<i class="menu-icon fa fa-caret-right"></i>
									Timesheet
								</a>
								<b class="arrow"></b>
							</li>
							
						</ul>
					</li>					
				
					<!-- Payroll -->
					<li class="main-menu <?= $parent_menu==='payroll' ? 'active open' : ''; ?>" >
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-envelope"></i>
							<span class="menu-text">
								PAYROLL
							</span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="sub-menu <?= $module==='pay_emp_details' ? 'active':''; ?>" >
								<a id='emp_details' class='menu-link' href="<?= base_url(); ?>pay_emp_details">
									<i class="menu-icon fa fa-caret-right"></i>
									Emp Details
								</a>
								<b class="arrow"></b>
							</li>
							
							<li class="sub-menu <?= $module==='pay_group' ? 'active':''; ?>" >
								<a id='group' class='menu-link' href="<?= base_url(); ?>pay_group">
									<i class="menu-icon fa fa-caret-right"></i>
									Group
								</a>
								<b class="arrow"></b>
							</li>
							
							<li class="sub-menu <?= $module==='pay_parameter' ? 'active':''; ?>" >
								<a id='parameter' class='menu-link' href="<?= base_url(); ?>pay_parameter">
									<i class="menu-icon fa fa-caret-right"></i>
									Parameter
								</a>
								<b class="arrow"></b>
							</li>
							
							<li class="sub-menu <?= $module==='pay_cutoff' ? 'active':''; ?>" >
								<a id='cutoff' class='menu-link' href="<?= base_url(); ?>pay_cutoff">
									<i class="menu-icon fa fa-caret-right"></i>
									Cut-Off Period
								</a>
								<b class="arrow"></b>
							</li>
							
							<li class="sub-menu <?= $module==='pay_ale' ? 'active':''; ?>" >
								<a id='pay_ale' class='menu-link' href="<?= base_url(); ?>pay_ale">
									<i class="menu-icon fa fa-caret-right"></i>
									ALE
								</a>
								<b class="arrow"></b>
							</li>
							
							<li class="sub-menu <?= $module==='pay_finishpay' ? 'active':''; ?>" >
								<a id='pay_finishpay' class='menu-link' href="<?= base_url(); ?>pay_finishpay">
									<i class="menu-icon fa fa-caret-right"></i>
									Finish Pay
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
					</li>
					
					<!-- Payroll Report -->
					<li class="main-menu <?= $parent_menu==='payroll report' ? 'active open' : ''; ?>" >
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-list"></i>
							<span class="menu-text">
								PAYROLL REPORT
							</span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="sub-menu <?= $module==='report_tax' ? 'active':''; ?>" >
								<a id='repot_tax' class='menu-link' href="<?= base_url(); ?>report_tax">
									<i class="menu-icon fa fa-caret-right"></i>
									TAX Report
								</a>
								<b class="arrow"></b>
							</li>	
							
							<li class="sub-menu <?= $module==='report_nasfund' ? 'active':''; ?>" >
								<a id='repot_nasfund' class='menu-link' href="<?= base_url(); ?>report_nasfund">
									<i class="menu-icon fa fa-caret-right"></i>
									NASFUND Report
								</a>
								<b class="arrow"></b>
							</li>
							
							<li class="sub-menu <?= $module==='report_ncsl' ? 'active':''; ?>" >
								<a id='repot_ncsl' class='menu-link' href="<?= base_url(); ?>report_ncsl">
									<i class="menu-icon fa fa-caret-right"></i>
									NCSL Report
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
					</li>
					
					<!-- Bank details -->
					<li class="main-menu <?= $parent_menu==='bank details' ? 'active open' : ''; ?>" >
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-bank"></i>
							<span class="menu-text">
								BANK DETAILS
							</span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="sub-menu <?= $module==='bank' ? 'active':''; ?>">
								<a id='bank' class='menu-link' href="<?= base_url(); ?>bank" >
									<i class="menu-icon fa fa-caret-right"></i>
									Bank
								</a>
								<b class="arrow"></b>
							</li>
							<li class="sub-menu <?= $module==='bank_company' ? 'active':''; ?>">
								<a id='bank_company' class='menu-link' href="<?= base_url(); ?>bank_company" >
									<i class="menu-icon fa fa-caret-right"></i>
									Company
								</a>
								<b class="arrow"></b>
							</li>
							<li class="sub-menu <?= $module==='bank_employee' ? 'active':''; ?>">
								<a id='bank_employee' class='menu-link' href="<?= base_url(); ?>bank_employee" >
									<i class="menu-icon fa fa-caret-right"></i>
									Employee
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
					</li>
					
					<!-- Cash Advance -->
					<li class="main-menu <?= $parent_menu==='cash advance' ? 'active open' : ''; ?>" >
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-money"></i>
							<span class="menu-text">
								CASH ADVANCE
							</span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="sub-menu <?= $module==='ca_management' ? 'active':''; ?>" >
								<a id='ca_management' class='menu-link' href="<?= base_url(); ?>ca_management">
									<i class="menu-icon fa fa-caret-right"></i>
									Management
								</a>
								<b class="arrow"></b>
							</li>
							
							<li class="sub-menu <?= $module==='ca_national' ? 'active':''; ?>" >
								<a id='ca_national' class='menu-link' href="<?= base_url(); ?>ca_national">
									<i class="menu-icon fa fa-caret-right"></i>
									National
								</a>
								<b class="arrow"></b>
							</li>
							
							<li class="sub-menu">
								<a class='menu-link' href="#">
									<i class="menu-icon fa fa-caret-right"></i>
									Report
								</a>
								<b class="arrow"></b>
							</li>
							
						</ul>
					</li>					
					
					<!-- Emergency Money -->
					<li class="main-menu <?= $parent_menu==='emergency money' ? 'active open' : ''; ?>" >
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-plus-square"></i>
							<span class="menu-text">
								EMERGENCY MONEY
							</span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="sub-menu <?= $module==='em' ? 'active':''; ?>" >
								<a id='em' class='menu-link' href="<?= base_url(); ?>em">
									<i class="menu-icon fa fa-caret-right"></i>
									EM Record
								</a>
								<b class="arrow"></b>
							</li>
							
							<li class="sub-menu">
								<a class='menu-link' href="#">
									<i class="menu-icon fa fa-caret-right"></i>
									Report
								</a>
								<b class="arrow"></b>
							</li>
							
						</ul>
					</li>
				
				
					<!-- Uniform -->
					<li class="main-menu">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-male"></i>
							<span class="menu-text">
								UNIFORM
							</span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="sub-menu">
								<a class='menu-link' href="#">
									<i class="menu-icon fa fa-caret-right"></i>
									Issuance
								</a>
								<b class="arrow"></b>
							</li>
							
							<li class="sub-menu">
								<a class='menu-link' href="#">
									<i class="menu-icon fa fa-caret-right"></i>
									Report
								</a>
								<b class="arrow"></b>
							</li>
							
						</ul>
					</li>
					
					<!-- Leave Maintenance -->
					<li class="main-menu <?= $parent_menu==='leave' ? 'active open' : ''; ?>" >
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-smile-o"></i>
							<span class="menu-text">
								LEAVE
							</span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="sub-menu <?= $module==='leave_type' ? 'active':''; ?>">
								<a id='leave_type' class='menu-link' href="<?= base_url(); ?>leave_type" >
									<i class="menu-icon fa fa-caret-right"></i>
									Type
								</a>
								<b class="arrow"></b>
							</li>
							<li class="sub-menu <?= $module==='leave' ? 'active':''; ?>">
								<a id='leave' class='menu-link' href="<?= base_url(); ?>leave" >
									<i class="menu-icon fa fa-caret-right"></i>
									Leave Record
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
					</li>
					
					<!-- Case Maintenance -->
					<li class="main-menu <?= $parent_menu==='case details' ? 'active open' : ''; ?>" >
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-legal"></i>
							<span class="menu-text">
								CASE DETAILS
							</span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="sub-menu <?= $module==='cases' ? 'active':''; ?>">
								<a id='cases' class='menu-link' href="<?= base_url(); ?>cases" >
									<i class="menu-icon fa fa-caret-right"></i>
									Case
								</a>
								<b class="arrow"></b>
							</li>							
						</ul>
					</li>
					
					<!-- Accountability -->					
					<li class="main-menu <?= $parent_menu==='accountability' ? 'active open' : ''; ?>" >
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-wrench"></i>
							<span class="menu-text">
								ACCOUNTABILITY
							</span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="sub-menu <?= $module==='accountability' ? 'active':''; ?>">
								<a id='accountability' class='menu-link' href="<?= base_url(); ?>accountability" >
									<i class="menu-icon fa fa-caret-right"></i>
									Record
								</a>
								<b class="arrow"></b>
							</li>							
						</ul>
					</li>
					
					
					<!-- Embarkation -->
					<li class="main-menu">
						<a class='menu-link' href="#">
							<i class="menu-icon fa fa-empire"></i>
							<span class="menu-text"> EMBARKATION </span>
						</a>
						<b class="arrow"></b>
					</li>
				
						
					<!-- Administration -->
					<li class="main-menu <?= $parent_menu==='administration' ? 'active open' : ''; ?>" >
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-gear"></i>
							<span class="menu-text">
								ADMINISTRATION
							</span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="sub-menu <?= $module==='admin_user' ? 'active':''; ?>">
								<a id='admin_user' class='menu-link' href="<?= base_url(); ?>admin_user" >
									<i class="menu-icon fa fa-caret-right"></i>
									User Account
								</a>
								<b class="arrow"></b>
							</li>	
							
							<li class="sub-menu <?= $module==='admin_role' ? 'active':''; ?>">
								<a id='admin_role' class='menu-link' href="<?= base_url(); ?>admin_role" >
									<i class="menu-icon fa fa-caret-right"></i>
									Role
								</a>
								<b class="arrow"></b>
							</li>	
							
							<li class="sub-menu <?= $module==='admin_permission' ? 'active':''; ?>">
								<a id='admin_permission' class='menu-link' href="<?= base_url(); ?>admin_permission" >
									<i class="menu-icon fa fa-caret-right"></i>
									Permission
								</a>
								<b class="arrow"></b>
							</li>	
							
							<li class="sub-menu <?= $module==='admin_module' ? 'active':''; ?>">
								<a id='admin_module' class='menu-link' href="<?= base_url(); ?>admin_module" >
									<i class="menu-icon fa fa-caret-right"></i>
									Module
								</a>
								<b class="arrow"></b>
							</li>	
							
						</ul>
					</li>	
					
					<!-- Logs -->
					<li class="main-menu">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-list"></i>
							<span class="menu-text">
								LOGS
							</span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="sub-menu">
								<a class='menu-link' href="#">
									<i class="menu-icon fa fa-caret-right"></i>
									Login History
								</a>
								<b class="arrow"></b>
							</li>

							<li class="sub-menu">
								<a class='menu-link' href="#">
									<i class="menu-icon fa fa-caret-right"></i>
									Transaction Log
								</a>
								<b class="arrow"></b>
							</li>	
						</ul>
					</li>
					
				
				</ul><!-- /.nav-list -->

				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>
			</div>