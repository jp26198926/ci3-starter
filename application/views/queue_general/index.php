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
		
		<style>
			.btn-file {
				position: relative;
				overflow: hidden;
			}
			.btn-file input[type=file] {
				position: absolute;
				top: 0;
				right: 0;
				min-width: 100%;
				min-height: 100%;
				font-size: 100px;
				text-align: right;
				filter: alpha(opacity=0);
				opacity: 0;
				background: red;
				cursor: inherit;
				display: block;
			}
		</style>
		
	</head>

	<body class="no-skin">
		
		<?php
			$this->load->view('template/header');
		?>

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container');}catch(e){}
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
										<table id="tbl_list" class="table  table-bordered table-hover table-striped table-fixed-header" style="font-size: 200%;">
											<thead class="header">
												<tr>
													<th class='text-center '>TRANSACTION</th>
													<th class='text-center '>LOCATION</th>
													<th class='text-center '>CALLER</th>
													<th class='text-center '>QUEUE</th>
												</tr>                                      
											</thead>
											<tbody >
												<tr>
													<tr><td colspan='4' class='text-center '> No one in queue </td></tr>
												</tr>																	  
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
				$("#paging").trigger("click");
				var play_audio = new Audio("<?= base_url(); ?>assets/audio/paging.mp3");
				$("#btn_search").trigger("click");
				
				setInterval(function() {
					
					$.post("<?= base_url(); ?>queue_general/search",{mysearch:""},function(data){
						//$("#loading").modal('hide');
						if(data.indexOf("<!DOCTYPE html>")>-1){
							alert("Error: Session Time-Out, You must login again to continue.");
							location.reload(true);                     
						}else if (data.indexOf("Error: ")>-1) {						
							//bootbox.alert(data);
						}else{
							var tbl_data = "<tr><td colspan='4' align='center'>No One in Queue</td></tr>";
							
							
							if (data){
								var has_calling = 0;
								tbl_data = "";
								
								data = JSON.parse(data);
								
								$.each(data, function(i, v) {
									//var id = v.id;
									var trans_no = v.trans_no;
									var caller = v.caller ? v.caller.toUpperCase() : "";
									var status = v.status;
									var status_id = v.status_id;
									var queue_status_id = v.queue_status_id;
									var location = "";
									
									switch(parseInt(queue_status_id)){
										case 2: //Calling
											tbl_data += "<tr class='danger'>";
											has_calling = 1;
											break;
										case 3: //Serving
											tbl_data += "<tr class='success'>";
											break;
										default:
											tbl_data += "<tr>";											
									}
								
									switch(parseInt(status_id)){
										case 3: //for payment
											location = "Cashier";
											break;
										case 4: //for laboratory
											location = "Laboratory";
											break;
										case 5: //waiting result
											location = "Triage";
											break;
										case 6: //consultation
											location = "Doctor's Office";
											break;
										case 8: //paid
											location = "Pharmacy";
											break;
										case 9: //for checkup
											location = "Doctor's Office";
											break;
										default:							
											location = "";
									}
									
									tbl_data += "	<td align='center'>" + trans_no + "</td>";
									tbl_data += "	<td align='center'>" + location + "</td>";
									tbl_data += "	<td align='center'>" + caller + "</td>";
									tbl_data += "	<td align='center'>" + status + "</td>";					
									tbl_data += "</tr>";
								});
								
								try{								
									//play_audio.pause();																						
									
									if (parseInt(has_calling) > 0){
										play_audio.play();
									}else{
										play_audio.pause();
									}
								}catch(err){								
									play_audio.pause();								
								}
							}
							
							$("#tbl_list tbody").html(tbl_data);
							$('[data-toggle="tooltip"]').tooltip({html:true});
						}
					});
					
				}, 1000);
			});
			//end default
						
		</script>
	</body>
</html>
