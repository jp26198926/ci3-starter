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
			try {
				ace.settings.loadState('main-container')
			} catch (e) {}
		</script>

		<?php
		$this->load->view('template/sidebar.php');
		?>

		<div class="main-content">
			<div class="main-content-inner">

				<div class="page-content">
					<?php
					$this->load->view('template/ace-settings.php');
					?>

					<div class="row">
						<div id='page_content' class="col-xs-12">
							<!-- PAGE CONTENT BEGINS -->
							<div class="page-header">
								<h1>
									Dashboard
								</h1>
							</div><!-- /.page-header -->

							<div class="row">
								<div class="col-sm-10">
									<h2 class="text-primary text-center">
										<i class="fa fa-info-circle fa-2x"></i>
										If you are using this system for the first time,
										Please follow the <b class="text-danger">INITIAL SETUP</b> below to have a good user experience.
									</h2>
								</div>
								<div class="col-sm-10 text-center">
									<img src="<?= base_url(); ?>assets/images/initial_settings.png" width="90%" />
								</div>
							</div>

							<!-- PAGE CONTENT ENDS -->
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- /.page-content -->
			</div>
		</div><!-- /.main-content -->

		<?php
		//include('layout/footer.php');
		$this->load->view('template/footer.php');
		?>

		<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
			<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
		</a>
	</div><!-- /.main-container -->

	<!-- basic scripts -->
	<?php
	//include('layout/script.php');
	$this->load->view('template/loading');
	$this->load->view('template/script');

	?>

	<!-- inline scripts related to this page -->
	<script>
		$(document).ready(function() {
			//$("#loading").modal();
		});


		$("#main").trigger("click");

		$(document).on("click", "#btn_common_password_update", function(e) {
			e.preventDefault();

			var id = $(".hidden_user_id").val();
			var oldpassword = $("#txt_common_oldpassword_update").val();
			var password = $("#txt_common_password_update").val();
			var repassword = $("#txt_common_password_update").val();

			if (id && oldpassword && password && repassword) {
				if (password == repassword) {
					$("#modal_password .modal-body").hide();
					$("#modal_password .modal_button").hide();
					$("#modal_password .modal_error").hide();
					$("#modal_password .modal_waiting").show();

					$.post("model/db_user_common.php", {
						action: 1,
						id: id,
						oldpassword: oldpassword,
						password: password,
						repassword: repassword
					}, function(data) {

						$("#modal_password .modal-body").show();
						$("#modal_password .modal_button").show();
						$("#modal_password .modal_waiting").hide();

						if (data.indexOf("<!DOCTYPE html>") > -1) {
							alert("Error: Session Time-Out, You must login again to continue.");
							location.reload(true);
						} else if (data.indexOf("Error: ") > -1) {
							$("#modal_password .modal_error_msg").text(data);
							$("#modal_password .modal_error").stop(true, true).show().delay(15000).fadeOut("slow");
							$("#txt_common_oldpassword_update").focus().select();
						} else {
							$("#modal_password").modal('hide');
							bootbox.alert("Password Changed!");
						}
					});
				} else {
					$("#modal_password .modal_error_msg").text("Error: Password does not matched!");
					$("#modal_password .modal_error").stop(true, true).show().delay(15000).fadeOut("slow");
					$("#txt_common_oldpassword_update").focus().select();
				}
			} else {
				$("#modal_password .modal_error_msg").text("Error: Critical Error Encountered!");
				$("#modal_password .modal_error").stop(true, true).show().delay(15000).fadeOut("slow");
				$("#txt_common_oldpassword_update").focus().select();
			}

		});

		$(document).on("click", ".common_changepass", function(e) {
			e.preventDefault();

			var id = $(this).attr('id');
			if (id) {
				$("#modal_password .modal-body").show();
				$("#modal_password .modal_button").show();
				$("#modal_password .modal_waiting").hide();
				$("#modal_password .modal_error").hide();
				$("#modal_password").modal();

				$(".hidden_user_id").val(id);
				$(".field_user").val("");
			} else {
				bootbox.alert("Error: Critical Error Encountered!");
			}
		});

		$('#modal_password').on('shown.bs.modal', function() {
			$('#txt_common_oldpassword_update').trigger('select', 'focus');
		});
	</script>
</body>

</html>