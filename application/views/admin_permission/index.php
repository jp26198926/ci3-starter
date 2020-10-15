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
											<input id='txt_permission_search' class="form-control " type="text" placeholder='Search' />
											<span class="input-group-btn">
												<button id='btn_permission_search' class="btn btn-sm btn-primary" type="button" title='Search' data-toggle='tooltip'>
													<i class="ace-icon fa fa-search bigger-110"></i>
													Go!
												</button>
												
												<?php
													if ($role_id==1 || $this->custom_function->module_permission("add",$module_permission)){ //admin or has add permission
														echo "	<button id='btn_permission_new' class='btn btn-sm btn-success' type='button' title='New' data-toggle='tooltip'>
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
										<table id="tbl_permission" class="table  table-bordered table-hover table-striped table-fixed-header">
											<thead class="header">
												<tr>										
													<th>OPTION</th>	
													<th>PERMISSION</th>																				
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
				$this->load->view('admin_permission/modal_permission_new');
				$this->load->view('admin_permission/modal_permission_modify');
				
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
			//start permission
			$(document).on("keypress","#txt_permission_search",function(e){
				if (e.which == 13){
					$("#btn_permission_search").trigger("click");
				}
			});
			
			$(document).on('click','#btn_permission_search',function(){
				var mysearch = $('#txt_permission_search').val();
				
				$.get("<?= base_url(); ?>admin_permission/search_permission?search=" + mysearch,function(data){				
					   
						if(data.indexOf("<!DOCTYPE html>")>-1){
							alert("Error: Session Time-Out, You must login again to continue.");
							location.reload(true); 
						}else if (data.indexOf("Error: ")>-1){ 
							alert(data);
							$('#txt_permission_search').trigger('select','focus'); 
						}else{
							if (data){
								$("#tbl_permission tbody").html(data);
							}else{
								$("#tbl_permission tbody").html("<tr><td align='center' colspan='2'>No Record to display</td></tr>");
							}                    
							
							$('[data-toggle="tooltip"]').tooltip({html:true});
						}
					});
				
			});	
			
			$(document).on("click","#btn_permission_new",function(){		
				$('.field_permission').val('');
				$('.modal_error, .modal_waiting').hide();
				$('#modal_permission_new').modal();
		
				$('#modal_permission_new').on('shown.bs.modal', function () {
					$('#txt_permission_name').trigger('select','focus'); 
				});
			});
			
			$(document).on('click','#btn_permission_save',function(){
				var permission_name = $('#txt_permission_name').val();
				
				if (permission_name){
					$('.modal_error, .modal_button').hide();
					$('.modal_waiting').show();
					
					$.post("<?= base_url(); ?>admin_permission/add_permission",{permission_name:permission_name},function(data){
						
						$('.modal_error, .modal_waiting').hide();
						$('.modal_button').show();
		
						if(data.indexOf("<!DOCTYPE html>")>-1){
							alert("Error: Session Time-Out, You must login again to continue.");
							location.reload(true); 
						}else if (data.indexOf("Error: ")>-1){ 
							$("#modal_permission_new .modal_error_msg").text(data);
							$("#modal_permission_new  .modal_error").stop(true,true).show().delay(15000).fadeOut("slow");
							$('#txt_permission_name').trigger('select','focus'); 
						}else{
							if (data){
								$("#tbl_permission tbody").html(data);
							}else{
								$("#tbl_permission tbody").html("<tr><td align='center' colspan='2'>No Record to display</td></tr>");
							}
							
							$("#modal_permission_new").modal('hide');
							$('[data-toggle="tooltip"]').tooltip({html:true});
						}
					});
				}else{
					$("#modal_permission_new .modal_error_msg").text("Error: Permission Name is required!");
					$("#modal_permission_new .modal_error").stop(true,true).show().delay(15000).fadeOut("slow"); 
				}
			});
			
			$(document).on('click','.btn_permission_modify',function(e){
				e.preventDefault();
				
				var id = $(this).attr('id');
				
				if (id){
					$.post("<?= base_url(); ?>admin_permission/info_permission",{id:id},function(data){				
					   
						if(data.indexOf("<!DOCTYPE html>")>-1){
							alert("Error: Session Time-Out, You must login again to continue.");
							location.reload(true); 
						}else if (data.indexOf("Error: ")>-1){ 
							alert(data);                    
						}else{
							data = JSON.parse(data);
							
							$(".hidden_permission_id").val(data.id);
							$("#txt_permission_name_update").val(data.permission);
							
							$("#modal_permission_modify").modal();
							
							$('#modal_permission_modify').on('shown.bs.modal', function () {
								$('#txt_permission_name_update').trigger('select','focus'); 
							});					
						}
					});
				}else{
					alert("Error: Critical Error Encountered!");
				}
			});
			
			$(document).on('click','#btn_permission_update',function(){
				
				var id = $('.hidden_permission_id').val();
				var permission_name = $('#txt_permission_name_update').val();
				
				if (permission_name){
					$('.modal_error, .modal_button').hide();
					$('.modal_waiting').show();
					
					$.post("<?= base_url(); ?>admin_permission/update_permission",{id:id, permission_name:permission_name},function(data){
						
						$('.modal_error, .modal_waiting').hide();
						$('.modal_button').show();
		
						if(data.indexOf("<!DOCTYPE html>")>-1){
							alert("Error: Session Time-Out, You must login again to continue.");
							location.reload(true); 
						}else if (data.indexOf("Error: ")>-1){ 
							
							$("#modal_permission_modify  .modal_error").stop(true,true).show().delay(15000).fadeOut("slow");
							$('#txt_permission_name_update').trigger('select','focus');
							
							if (data.indexOf("Duplicate") > -1){
								$("#modal_permission_modify .modal_error_msg").text("Error: Already in the list!");
							}else{
								$("#modal_permission_modify .modal_error_msg").text(data);
							}
						}else{
							if (data){
								$("#tbl_permission tbody #tr_" + id).html(data);
							}else{
								$("#tbl_permission tbody #tr_" + id).html("<tr><td align='center' colspan='2'>No Record to display</td></tr>");
							}
							
							$("#modal_permission_modify").modal('hide');
							$('[data-toggle="tooltip"]').tooltip({html:true});
						}
					});
				}else{
					$("#modal_permission_modify .modal_error_msg").text("Error: Permission Name is required!");
					$("#modal_permission_modify .modal_error").stop(true,true).show().delay(15000).fadeOut("slow"); 
				}
			});
			//end permission
			
		</script>
	</body>
</html>
