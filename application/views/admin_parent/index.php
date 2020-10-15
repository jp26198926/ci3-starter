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
											<input id='txt_parent_search' class="form-control " type="text" placeholder='Search' />
											<span class="input-group-btn">
												<button id='btn_parent_search' class="btn btn-sm btn-primary" type="button" title='Search' data-toggle='tooltip'>
													<i class="ace-icon fa fa-search bigger-110"></i>
													Go!
												</button>
												
												<?php
													if ($role_id==1 || $this->custom_function->module_permission("add",$module_permission)){ //admin or has add permissioin
														echo "	<button id='btn_parent_new' class='btn btn-sm btn-success' type='button' title='New' data-toggle='tooltip'>
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
										<table id="tbl_parent" class="table  table-bordered table-hover table-striped table-fixed-header">
											<thead class="header">
												<tr>										
												<th>OPTION</th>	
												<th>PARENT NAME</th>
												<th>DESCRIPTION</th>
												<th>ICON</th>
												<th>ORDER</th>
											</tr>
											</thead>                
											<tbody>
												<tr><td align='center' colspan='5'>Use search button to display record</td></tr>								
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
				$this->load->view('admin_parent/modal_parent_new');
				$this->load->view('admin_parent/modal_parent_modify');
				
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
			$(document).ready(function(){
				$("#btn_parent_search").trigger("click");
			});
			
			//start module
			$(document).on("keypress","#txt_parent_search",function(e){
				if (e.which == 13){
					$("#btn_parent_search").trigger("click");
				}
			});
			
			$(document).on('click','#btn_parent_search',function(){
				var mysearch = $('#txt_parent_search').val();
				
				$.get("<?= base_url(); ?>admin_parent/search_parent?search=" + mysearch,function(data){				
					   
						if(data.indexOf("<!DOCTYPE html>")>-1){
							alert("Error: Session Time-Out, You must login again to continue.");
							location.reload(true); 
						}else if (data.indexOf("Error: ")>-1){ 
							alert(data);
							$('#txt_parent_search').trigger('select','focus'); 
						}else{
							if (data){
								$("#tbl_parent tbody").html(data);
							}else{
								$("#tbl_parent tbody").html("<tr><td align='center' colspan='5'>No Record to display</td></tr>");
							}                    
							
							$('[data-toggle="tooltip"]').tooltip({html:true});
						}
					});
				
			});	
			
			$(document).on("click","#btn_parent_new",function(){		
				$('.field_parent').val('');
				$('.modal_error, .modal_waiting').hide();
				$('#modal_parent_new').modal();
		
				$('#modal_parent_new').on('shown.bs.modal', function () {
					$('#txt_parent_name').trigger('select','focus'); 
				});
			});
			
			$(document).on('click','#btn_parent_save',function(){
				var parent_name = $('#txt_parent_name').val();
				var parent_description = $('#txt_parent_description').val();
				var parent_icon = $('#txt_parent_icon').val();
				var parent_order = $('#txt_parent_order').val();
				
				if (parent_name && parent_description && parent_order){
					$('.modal_error, .modal_button').hide();
					$('.modal_waiting').show();
					
					$.post("<?= base_url(); ?>admin_parent/add_parent",{
																		  parent_name:parent_name,
																		  parent_description:parent_description,
																		  parent_icon:parent_icon,
																		  parent_order:parent_order
																		},function(data){
						
						$('.modal_error, .modal_waiting').hide();
						$('.modal_button').show();
		
						if(data.indexOf("<!DOCTYPE html>")>-1){
							alert("Error: Session Time-Out, You must login again to continue.");
							location.reload(true); 
						}else if (data.indexOf("Error: ")>-1){ 
							$("#modal_parent_new .modal_error_msg").text(data);
							$("#modal_parent_new  .modal_error").stop(true,true).show().delay(15000).fadeOut("slow");
							$('#txt_parent_name').trigger('select','focus'); 
						}else{
							if (data){
								$("#tbl_parent tbody").html(data);
							}else{
								$("#tbl_parent tbody").html("<tr><td align='center' colspan='5'>No Record to display</td></tr>");
							}
							
							$("#modal_parent_new").modal('hide');
							$('[data-toggle="tooltip"]').tooltip({html:true});
						}
					});
				}else{
					$("#modal_parent_new .modal_error_msg").text("Error: Module Name is required!");
					$("#modal_parent_new .modal_error").stop(true,true).show().delay(15000).fadeOut("slow"); 
				}
			});
			
			$(document).on('click','.btn_parent_modify',function(e){
				e.preventDefault();
				
				var id = $(this).attr('id');
				
				if (id){
					$.post("<?= base_url(); ?>admin_parent/info_parent",{id:id},function(data){				
					   
						if(data.indexOf("<!DOCTYPE html>")>-1){
							alert("Error: Session Time-Out, You must login again to continue.");
							location.reload(true); 
						}else if (data.indexOf("Error: ")>-1){ 
							alert(data);                    
						}else{
							data = JSON.parse(data);
							
							$(".hidden_parent_id").val(data.parent_id);
							$("#txt_parent_name_update").val(data.parent_name);
							$("#txt_parent_description_update").val(data.parent_description);
							$("#txt_parent_icon_update").val(data.parent_icon);
							$("#txt_parent_order_update").val(data.parent_order);
							
							$("#modal_parent_modify").modal();
							
							$('#modal_parent_modify').on('shown.bs.modal', function () {
								$('#txt_parent_name_update').trigger('select','focus'); 
							});					
						}
					});
				}else{
					alert("Error: Critical Error Encountered!");
				}
			});
			
			$(document).on('click','#btn_parent_update',function(){
				
				var id = $('.hidden_parent_id').val();
				var parent_name = $('#txt_parent_name_update').val();
				var parent_description = $('#txt_parent_description_update').val();
				var parent_icon = $('#txt_parent_icon_update').val();
				var parent_order = $('#txt_parent_order_update').val();
				
				if (parent_name){
					$('.modal_error, .modal_button').hide();
					$('.modal_waiting').show();
					
					$.post("<?= base_url(); ?>admin_parent/update_parent",{id:id, parent_name:parent_name,
																			 parent_description:parent_description,
																			 parent_icon:parent_icon,
																			 parent_order:parent_order
																			},function(data){
						
						$('.modal_error, .modal_waiting').hide();
						$('.modal_button').show();
		
						if(data.indexOf("<!DOCTYPE html>")>-1){
							alert("Error: Session Time-Out, You must login again to continue.");
							location.reload(true); 
						}else if (data.indexOf("Error: ")>-1){ 
							$("#modal_parent_modify .modal_error_msg").text(data);
							$("#modal_parent_modify  .modal_error").stop(true,true).show().delay(15000).fadeOut("slow");
							$('#txt_parent_name_update').trigger('select','focus'); 
						}else{
							if (data){
								$("#tbl_parent tbody #tr_" + id).html(data);
							}else{
								$("#tbl_parent tbody #tr_" + id).html("<tr><td align='center' colspan='5'>No Record to display</td></tr>");
							}
							
							$("#modal_parent_modify").modal('hide');
							$('[data-toggle="tooltip"]').tooltip({html:true});
						}
					});
				}else{
					$("#modal_parent_modify .modal_error_msg").text("Error: Module Name is required!");
					$("#modal_parent_modify .modal_error").stop(true,true).show().delay(15000).fadeOut("slow"); 
				}
			});
			//end module
			
		</script>
	</body>
</html>
