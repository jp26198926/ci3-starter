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
											<input id='txt_module_search' class="form-control " type="text" placeholder='Search' />
											<span class="input-group-btn">
												<button id='btn_module_search' class="btn btn-sm btn-primary" type="button" title='Search' data-toggle='tooltip'>
													<i class="ace-icon fa fa-search bigger-110"></i>
													Go!
												</button>
												
												<?php
													if ($role_id==1 || $this->custom_function->module_permission("add",$module_permission)){ //admin or has add permissioin
														echo "	<button id='btn_module_new' class='btn btn-sm btn-success' type='button' title='New' data-toggle='tooltip'>
																	<i class='ace-icon fa fa-plus bigger-110'></i>
																</button>	";
													}
												?>
											</span>
										</div>
									</h1>
								</div><!-- /.page-header -->
								
								<div class="row">
									<div class="col-xs-12">
										<table id="tbl_module" class="table  table-bordered table-hover table-striped table-fixed-header">
											<thead class="header">
												<tr>										
												<th>OPTION</th>	
												<th>MODULE NAME</th>
												<th>DESCRIPTION</th>												
												<th>PARENT MODULE</th>
											</tr>
											</thead>                
											<tbody>
												<tr><td align='center' colspan='4'>Use search button to display record</td></tr>								
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
				$this->load->view('admin_module/modal_module_new');
				$this->load->view('admin_module/modal_module_modify');
				
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
				$("#btn_module_search").trigger("click");
			});
			
			//start module			
			$(document).on("keypress","#txt_module_search",function(e){
				if (e.which == 13){
					$("#btn_module_search").trigger("click");
				}
			});
			
			$(document).on('click','#btn_module_search',function(){
				var mysearch = $('#txt_module_search').val();
				
				$.get("<?= base_url(); ?>admin_module/search_module?search=" + mysearch,function(data){				
					   
						if(data.indexOf("<!DOCTYPE html>")>-1){
							alert("Error: Session Time-Out, You must login again to continue.");
							location.reload(true); 
						}else if (data.indexOf("Error: ")>-1){ 
							alert(data);
							$('#txt_module_search').trigger('select','focus'); 
						}else{
							if (data){
								$("#tbl_module tbody").html(data);
							}else{
								$("#tbl_module tbody").html("<tr><td align='center' colspan='4'>No Record to display</td></tr>");
							}                    
							
							$('[data-toggle="tooltip"]').tooltip({html:true});
						}
					});
				
			});	
			
			$(document).on("click","#btn_module_new",function(){		
				$('.field_module').val('');
				$('.modal_error, .modal_waiting').hide();
				$('#modal_module_new').modal();
		
				$('#modal_module_new').on('shown.bs.modal', function () {
					$('#txt_module_name').trigger('select','focus'); 
				});
			});
			
			$(document).on('click','#btn_module_save',function(){
				var module_name = $('#txt_module_name').val();
				var module_description = $('#txt_module_description').val();
				//var module_icon = $('#txt_module_icon').val();
				//var module_parent = $('#txt_module_parent').val();
				var parent_id = $("#txt_parent_id").val();
				
				if (module_name && module_description){
					$('.modal_error, .modal_button').hide();
					$('.modal_waiting').show();
					
					$.post("<?= base_url(); ?>admin_module/add_module",{
																		  module_name:module_name,
																		  module_description:module_description,
																		  parent_id:parent_id
																		},function(data){
						
						$('.modal_error, .modal_waiting').hide();
						$('.modal_button').show();
		
						if(data.indexOf("<!DOCTYPE html>")>-1){
							alert("Error: Session Time-Out, You must login again to continue.");
							location.reload(true); 
						}else if (data.indexOf("Error: ")>-1){ 
							$("#modal_module_new .modal_error_msg").text(data);
							$("#modal_module_new  .modal_error").stop(true,true).show().delay(15000).fadeOut("slow");
							$('#txt_module_name').trigger('select','focus'); 
						}else{
							if (data){
								$("#tbl_module tbody").html(data);
							}else{
								$("#tbl_module tbody").html("<tr><td align='center' colspan='4'>No Record to display</td></tr>");
							}
							
							$("#modal_module_new").modal('hide');
							$('[data-toggle="tooltip"]').tooltip({html:true});
						}
					});
				}else{
					$("#modal_module_new .modal_error_msg").text("Error: Module Name is required!");
					$("#modal_module_new .modal_error").stop(true,true).show().delay(15000).fadeOut("slow"); 
				}
			});
			
			$(document).on('click','.btn_module_modify',function(e){
				e.preventDefault();
				
				var id = $(this).attr('id');
				
				if (id){
					$.post("<?= base_url(); ?>admin_module/info_module",{id:id},function(data){				
					   
						if(data.indexOf("<!DOCTYPE html>")>-1){
							alert("Error: Session Time-Out, You must login again to continue.");
							location.reload(true); 
						}else if (data.indexOf("Error: ")>-1){ 
							alert(data);                    
						}else{
							data = JSON.parse(data);
							
							$(".hidden_module_id").val(data.id);
							$("#txt_module_name_update").val(data.module_name);
							$("#txt_module_description_update").val(data.module_description);
							//$("#txt_module_icon_update").val(data.module_icon);
							//$("#txt_module_parent_update").val(data.parent_module);
							$("#txt_parent_id_update").val(data.parent_id);
							
							$("#modal_module_modify").modal();
							
							$('#modal_module_modify').on('shown.bs.modal', function () {
								$('#txt_module_name_update').trigger('select','focus'); 
							});					
						}
					});
				}else{
					alert("Error: Critical Error Encountered!");
				}
			});
			
			$(document).on('click','#btn_module_update',function(){
				
				var id = $('.hidden_module_id').val();
				var module_name = $('#txt_module_name_update').val();
				var module_description = $('#txt_module_description_update').val();
				//var module_icon = $('#txt_module_icon_update').val();
				//var module_parent = $('#txt_module_parent_update').val();
				var parent_id = $('#txt_parent_id_update').val();
				
				if (module_name && parent_id){
					$('.modal_error, .modal_button').hide();
					$('.modal_waiting').show();
					
					$.post("<?= base_url(); ?>admin_module/update_module",{id:id, module_name:module_name,
																			 module_description:module_description,
																			 parent_id:parent_id
																			},function(data){
						
						$('.modal_error, .modal_waiting').hide();
						$('.modal_button').show();
		
						if(data.indexOf("<!DOCTYPE html>")>-1){
							alert("Error: Session Time-Out, You must login again to continue.");
							location.reload(true); 
						}else if (data.indexOf("Error: ")>-1){ 
							$("#modal_module_modify .modal_error_msg").text(data);
							$("#modal_module_modify  .modal_error").stop(true,true).show().delay(15000).fadeOut("slow");
							$('#txt_module_name_update').trigger('select','focus'); 
						}else{
							if (data){
								$("#tbl_module tbody #tr_" + id).html(data);
							}else{
								$("#tbl_module tbody #tr_" + id).html("<tr><td align='center' colspan='4'>No Record to display</td></tr>");
							}
							
							$("#modal_module_modify").modal('hide');
							$('[data-toggle="tooltip"]').tooltip({html:true});
						}
					});
				}else{
					$("#modal_module_modify .modal_error_msg").text("Error: Fields with red asterisk (*) are required!");
					$("#modal_module_modify .modal_error").stop(true,true).show().delay(15000).fadeOut("slow"); 
				}
			});
			//end module
			
		</script>
	</body>
</html>
