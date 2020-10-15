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
									</h1>
								</div><!-- /.page-header -->
								
								<div class="row">
									<div class="col-xs-12">
										<div class="row">
											<div class="col-xs-12 text-center">
												<h3 class="header smaller lighter green">Application Buttons</h3>
		
												<p></p>
												<a href="<?= base_url() . 'maintenance_db/backup_db'; ?>" class="btn btn-app btn-primary">
													<i class="ace-icon fa fa-hdd-o bigger-230"></i>
													Backup
												</a>
												
												<a href="#" id="btn_restore" class="btn btn-app btn-warning">
													<i class="ace-icon fa fa-download bigger-230"></i>
													Restore
												</a>
											</div>
										</div>
									</div>
								</div><!-- /.row -->	
									
								<!-- PAGE CONTENT ENDS -->
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<?php
				$this->load->view('maintenance_db/modal_restore');
				//$this->load->view('admin_module/modal_module_modify');
				
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
			//start module
			$(document).on("click","#btn_restore",function(e){
				e.preventDefault();
				
				$("#modal_restore").modal();
			});
			
			$(document).on('click','#btn_restore_save',function(){
				
				var file_selected = $("#file_restore").val();
				
				if (file_selected){
					
					$("#modal_restore .modal-body").hide();
					$("#modal_restore .modal_button").hide();
					$("#modal_restore .modal_error").hide();
					$("#modal_restore .modal_success").hide();
					$("#modal_restore .modal_waiting").show();
					
					var fd = new FormData(document.getElementById("frm_restore"));
																		
					$.ajax({
						url: "<?= base_url() ?>maintenance_db/restore_db",
						type: "POST",
						data: fd,
						enctype: 'multipart/form-data',
						processData: false,  // tell jQuery not to process the data
						contentType: false   // tell jQuery not to set contentType
					}).done(function( data ) {
						
						$("#modal_restore .modal-body").show();
						$("#modal_restore .modal_button").show();							
						$("#modal_restore .modal_waiting").hide();        
								
						if(data.indexOf("<!DOCTYPE html>")>-1){
							alert("Error: Session Time-Out, You must login again to continue.");
							location.reload(true);                     
						}else if (data.indexOf("Error: ")>-1) {
							$("#modal_restore .modal_error_msg").text(data);
							$("#modal_restore .modal_error").stop(true,true).show().delay(15000).fadeOut("slow");	
						}else{
							$('#file_restore').val('');							
							var filename = /([^\\]+)$/.exec(file_selected)[1];
							
							$("#modal_restore .modal_success_msg").text("Successfully uploaded: " + filename);
							$("#modal_restore .modal_success").stop(true,true).show().delay(15000).fadeOut("slow");
							
						}
					});
					return false;
				
				}else{
					$("#modal_restore .modal_error_msg").text("Error: Select a file to upload!");
					$("#modal_restore .modal_error").stop(true,true).show().delay(15000).fadeOut("slow");	
				}
			});
			
			//end module
			
		</script>
	</body>
</html>
