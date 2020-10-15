<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title> <?= $app_title; ?> </title>

		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		
		<?php
			$this->load->view('template/style');
		?>
		
	</head>

	<body class="no-skin">
		
		<?php
			//include('layout/loading.php');
			//include('layout/modal_password.php');		
			
			$this->load->view('template/header');			
			
		?>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<?php
				$this->load->view('template/sidebar');
			?>

			<div class="main-content">
				<div class="main-content-inner">
				
					<div class="page-content">
						<?php
							$this->load->view('template/ace-settings');
						?>

						<div class="row">
							<div id='page_content' class="col-xs-12">
								<!-- PAGE CONTENT BEGINS -->								
								<div class="page-header">
									<h1>
										<?= ucwords($parent_menu); ?>
										<small>
											<i class="ace-icon fa fa-angle-double-right"></i>
											<?= $page_name; ?>
										</small>
										
										
										<div class="input-group pull-right" style='width: 15em;'>											
											<input id='txt_role_search' class="form-control " type="text" placeholder='Search' />
											<span class="input-group-btn">
												<button id='btn_role_search' class="btn btn-sm btn-primary" type="button" title='Search' data-toggle='tooltip'>
													<i class="ace-icon fa fa-search bigger-110"></i>
													Go!
												</button>
												
												<?php
													if ($role_id==1 || $this->custom_function->module_permission("add",$module_permission)){ //admin or has add permission
														echo "	<button id='btn_role_new' class='btn btn-sm btn-success' type='button' title='New' data-toggle='tooltip'>
																	<i class='ace-icon fa fa-plus bigger-110'></i>
																</button>";
													}
												?>
												
												
											</span>
										</div>
									</h1>
								</div><!-- /.page-header -->
								
								<div class="row">
									<div class="col-xs-12">
										<table id="tbl_role" class="table  table-bordered table-hover table-striped table-fixed-header">
											<thead class="header">
												<tr>										
													<th>OPTION</th>	
													<th>ROLE NAME</th>																				
												</tr>
											</thead>                
											<tbody>
												<tr><td align='center' colspan='2'>Use search button to display record</td></tr>								
											</tbody>
										</table>
									</div>
								</div><!-- /.row -->	
									
								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<?php
				$this->load->view('admin_role/modal_role_new');
				$this->load->view('admin_role/modal_role_modify');
				$this->load->view('admin_role/modal_role_permission');
				
				$this->load->view('template/footer');
				$this->load->view('template/loading');				
			?>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- basic scripts -->
		<?php
			$this->load->view('template/script');
		?>
		
		<!-- inline scripts related to this page -->
		<script>
			//default
			$(document).ready(function(){
				$("#btn_role_search").trigger("click");
			});
			
			//start role
			$(document).on("keypress","#txt_role_search",function(e){
				if (e.which == 13){
					$("#btn_role_search").trigger("click");
				}
			});
			
			$(document).on('click','#btn_role_search',function(){
				var mysearch = $('#txt_role_search').val();
				
				$.get("<?= base_url(); ?>admin_role/search_role?search=" + mysearch,function(data){				
					   
					if(data.indexOf("<!DOCTYPE html>")>-1){
						alert("Error: Session Time-Out, You must login again to continue.");
						location.reload(true); 
					}else if (data.indexOf("Error: ")>-1){ 
						bootbox.alert(data);
						$('#txt_role_search').trigger('select','focus'); 
					}else{
						if (data){
							$("#tbl_role tbody").html(data);
						}else{
							$("#tbl_role tbody").html("<tr><td align='center' colspan='2'>No Record to display</td></tr>");
						}                    
							
						$('[data-toggle="tooltip"]').tooltip({html:true});
					}
				});				
			});	
			
			$(document).on("click","#btn_role_new",function(){		
				$('.field_role').val('');
				$('.modal_error, .modal_waiting').hide();
				$('#modal_role_new').modal();
		
				$('#modal_role_new').on('shown.bs.modal', function () {
					$('#txt_role_name').trigger('select','focus'); 
				});
			});
			
			$(document).on('click','#btn_role_save',function(){
				var role_name = $('#txt_role_name').val();
				
				if (role_name){
					$('.modal_error, .modal_button').hide();
					$('.modal_waiting').show();
					
					$.post("<?= base_url(); ?>admin_role/add_role",{role_name:role_name},function(data){
						
						$('.modal_error, .modal_waiting').hide();
						$('.modal_button').show();
		
						if(data.indexOf("<!DOCTYPE html>")>-1){
							alert("Error: Session Time-Out, You must login again to continue.");
							location.reload(true); 
						}else if (data.indexOf("Error: ")>-1){ 
							$("#modal_role_new .modal_error_msg").text(data);
							$("#modal_role_new  .modal_error").stop(true,true).show().delay(15000).fadeOut("slow");
							$('#txt_role_name').trigger('select','focus'); 
						}else{
							if (data){
								$("#tbl_role tbody").html(data);
							}else{
								$("#tbl_role tbody").html("<tr><td align='center' colspan='2'>No Record to display</td></tr>");
							}
							
							$("#modal_role_new").modal('hide');
							$('[data-toggle="tooltip"]').tooltip({html:true});
						}
					});
				}else{
					$("#modal_role_new .modal_error_msg").text("Error: Role Name is required!");
					$("#modal_role_new .modal_error").stop(true,true).show().delay(15000).fadeOut("slow"); 
				}
			});
			
			$(document).on('click','.btn_role_modify',function(e){
				e.preventDefault();
				
				var id = $(this).attr('id');
				
				if (id){
					$.post("<?= base_url(); ?>admin_role/info_role",{id:id},function(data){				
					   
						if(data.indexOf("<!DOCTYPE html>")>-1){
							alert("Error: Session Time-Out, You must login again to continue.");
							location.reload(true); 
						}else if (data.indexOf("Error: ")>-1){ 
							alert(data);                    
						}else{
							data = JSON.parse(data);
							
							$(".hidden_role_id").val(data.id);
							$("#txt_role_name_update").val(data.role_name);
							
							$("#modal_role_modify").modal();
							
							$('#modal_role_modify').on('shown.bs.modal', function () {
								$('#txt_role_name_update').trigger('select','focus'); 
							});					
						}
					});
				}else{
					alert("Error: Critical Error Encountered!");
				}
			});
			
			$(document).on('click','#btn_role_update',function(){
				
				var id = $('.hidden_role_id').val();
				var role_name = $('#txt_role_name_update').val();
				
				if (role_name){
					$('.modal_error, .modal_button').hide();
					$('.modal_waiting').show();
					
					$.post("<?= base_url(); ?>admin_role/update_role",{id:id, role_name:role_name},function(data){
						
						$('.modal_error, .modal_waiting').hide();
						$('.modal_button').show();
		
						if(data.indexOf("<!DOCTYPE html>")>-1){
							alert("Error: Session Time-Out, You must login again to continue.");
							location.reload(true); 
						}else if (data.indexOf("Error: ")>-1){ 
							$("#modal_role_modify .modal_error_msg").text(data);
							$("#modal_role_modify  .modal_error").stop(true,true).show().delay(15000).fadeOut("slow");
							$('#txt_role_name_update').trigger('select','focus'); 
						}else{
							if (data){
								$("#tbl_role tbody #tr_" + id).html(data);
							}else{
								$("#tbl_role tbody #tr_" + id).html("<tr><td align='center' colspan='2'>No Record to display</td></tr>");
							}
							
							$("#modal_role_modify").modal('hide');
							$('[data-toggle="tooltip"]').tooltip({html:true});
						}
					});
				}else{
					$("#modal_role_modify .modal_error_msg").text("Error: Role Name is required!");
					$("#modal_role_modify .modal_error").stop(true,true).show().delay(15000).fadeOut("slow"); 
				}
			});	
			//end role
			
			//start mod_perm
			$(document).on('click','.btn_role_permission',function(e){
				e.preventDefault();
				var role_id = $(this).attr('id');
				
				if (role_id){
					$.post("<?= base_url(); ?>admin_role/show_mod_perm",{role_id: role_id},function(data){				
						if(data.indexOf("<!DOCTYPE html>")>-1){
							alert("Error: Session Time-Out, You must login again to continue.");
							location.reload(true); 
						}else if (data.indexOf("Error: ")>-1){ 
							$("#modal_role_permission .modal_error_msg").text(data);
							$("#modal_role_permission  .modal_error").stop(true,true).show().delay(15000).fadeOut("slow");					
							
						}else{
							if (data){
								$("#tbl_mod_perm tbody").html(data);
							}else{
								$("#tbl_mod_perm tbody").html("<tr><td align='center' colspan='3'>No Record to display</td></tr>");
							}						
								
							$('[data-toggle="tooltip"]').tooltip({html:true});
							
							$(".hidden_role_id").val(role_id);
							$('#modal_role_permission').modal();
						}                
					});			
					
				}else{
					alert("Error: Critical Error Encountered!");
				}
				
			});
			
			$(document).on('click','#btn_role_perm_add',function(){
				var role_id = $(".hidden_role_id").val();
				var module_id = $("#dd_role_perm_module").val();
				var permission_id = $("#dd_role_perm_permission").val();
				
				if (role_id){		
					if (module_id && permission_id){
						$('.modal_error, .modal_button').hide();
						$('.modal_waiting').show();
						
						$.post("<?= base_url(); ?>admin_role/add_mod_perm",{role_id, module_id, permission_id},function(data){
							
							$('.modal_error, .modal_waiting').hide();
							$('.modal_button').show();
			
							if(data.indexOf("<!DOCTYPE html>")>-1){
								alert("Error: Session Time-Out, You must login again to continue.");
								location.reload(true); 
							}else if (data.indexOf("Error: ")>-1){ 
								
								$("#modal_role_permission  .modal_error").stop(true,true).show().delay(15000).fadeOut("slow");
								if (data.indexOf("Duplicate") > -1){
									$("#modal_role_permission .modal_error_msg").text("Error: Already in the list!");
								}else{
									$("#modal_role_permission .modal_error_msg").text(data);
								}
							}else{
								if (data){
									$("#tbl_mod_perm tbody").html(data);
								}else{
									$("#tbl_mod_perm tbody").html("<tr><td align='center' colspan='3'>No Record to display</td></tr>");
								}						
								
								$('[data-toggle="tooltip"]').tooltip({html:true});
							}
						});
					}else{
						$("#modal_role_permission .modal_error_msg").text("Error: Module and Permission is required!");
						$("#modal_role_permission .modal_error").stop(true,true).show().delay(15000).fadeOut("slow"); 
					}
				}else{
					$("#modal_role_permission .modal_error_msg").text("Error: Critical Error Encountered!");
					$("#modal_role_permission .modal_error").stop(true,true).show().delay(15000).fadeOut("slow"); 
				}
			});
			
			$(document).on('click','.btn_mod_perm_remove',function(e){
				e.preventDefault();
				var id = $(this).attr('id');
				
				if (id){
					$('.modal_error, .modal_button').hide();
					$('.modal_waiting').show();
						
					$.post("<?= base_url(); ?>admin_role/delete_mod_perm",{id:id},function(data){
							
						$('.modal_error, .modal_waiting').hide();
						$('.modal_button').show();
			
						if(data.indexOf("<!DOCTYPE html>")>-1){
							alert("Error: Session Time-Out, You must login again to continue.");
							location.reload(true); 
						}else if (data.indexOf("Error: ")>-1){ 						
							$("#modal_role_permission  .modal_error").stop(true,true).show().delay(15000).fadeOut("slow");
							$("#modal_role_permission .modal_error_msg").text(data);
						}else{
							$("#tbl_mod_perm tbody #tr_" + id).hide();					
						}
					});
				}else{
					$("#modal_role_permission .modal_error_msg").text("Error: Critical Error Encountered!");
					$("#modal_role_permission .modal_error").stop(true,true).show().delay(15000).fadeOut("slow"); 
				}
			});
			//end mod_perm
			
			
			
			
			
		</script>
	</body>
</html>
