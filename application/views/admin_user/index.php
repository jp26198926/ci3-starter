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
										<span id="lbl_count" class="badge badge-warning">0</span>
									</small>


									<div class="input-group pull-right" style='width: 15em;'>
										<input id='txt_users_search' class="form-control " type="text" placeholder='Search' />
										<span class="input-group-btn">
											<button id='btn_users_search' class="btn btn-sm btn-primary" type="button" title='Search' data-toggle='tooltip'>
												<i class="ace-icon fa fa-search bigger-110"></i>
												Go!
											</button>

											<?php
											if ($role_id == 1 || $this->custom_function->module_permission("add", $module_permission)) { //admin or has add permission
												echo "	<button id='btn_users_new' class='btn btn-sm btn-success' type='button' title='New' data-toggle='tooltip'>
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
									<div class="table-header clearfix">
										Result List <span id="lbl_result_info" class="badge badge-warning"></span>
										<div class="pull-right" style="padding-right: 0.5em; padding-top: 0.4em;">
											<div class="pull-right tableTools-container"></div>
										</div>
									</div>
									<div>
										<table id="tbl_users" class="table  table-bordered table-hover table-striped table-fixed-header">
											<thead class="header">
												<tr>
													<th>OPTION</th>
													<th>USERNAME</th>
													<th>NAME</th>
													<th>EMAIL</th>
													<th>ROLE</th>
													<th>STATUS</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td align='center' colspan='6'>Use search button to display record</td>
												</tr>
											</tbody>
										</table>
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
		$this->load->view('admin_user/modal_users_new');
		$this->load->view('admin_user/modal_users_modify');
		$this->load->view('admin_user/modal_users_changepass');

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
		var current_row;
		var current_data;
		var current_status_id;
		//functions

		function table_buttons(table, id, status_id = 1) {
			var option = "";

			<?php
			if ($role_id == 1 || $this->custom_function->module_permission("modify", $module_permission)) { //if admin or has permission
			?>
				option += "<button id='" + id + "' class='btn_change_pass btn btn-xs btn-success fa fa-refresh' title='Change Password' data-toggle='tooltip'></button> ";
				option += "<button id='" + id + "' class='btn_users_modify btn btn-xs btn-info fa fa-pencil' title='Modify' data-toggle='tooltip'></button> ";
			<?php
			}
			?>

			if (status_id == 1) {
				<?php if ($role_id == 1 || $this->custom_function->module_permission("delete", $module_permission)) { //if admin or has permission 
				?>
					option += "<button id='" + id + "' class='btn_users_deactivate btn btn-xs btn-danger fa fa-times' title='Deactivate' data-toggle='tooltip'></button>";
				<?php } ?>
			} else {
				<?php if ($role_id == 1 || $this->custom_function->module_permission("activate", $module_permission)) { //if admin or has permission
				?>
					option += "<button id='" + id + "' class='btn_users_activate btn btn-xs btn-warning fa fa-reply' title=''Activate' data-toggle='tooltip'></button>";

				<?php } ?>
			}

			return option;
		}

		function reload_table(table_id, dataSet = []) {
			var myTable =
				$(table_id)
				//.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
				.DataTable({
					destroy: true,
					bAutoWidth: false,
					"aoColumns": [{
							"bSortable": false,
							className: "text-center"
						},
						null,
						null,
						null,
						null,
						null
					],
					data: dataSet,
					"aaSorting": [],
					"rowCallback": function(row, data, index) {
						if (data[6] == 2) { //inactive
							$('td', row).addClass('danger');
						} else {
							$('td', row).removeClass('danger');
						}

					}


					//"bProcessing": true,
					//"bServerSide": true,
					//"sAjaxSource": "http://127.0.0.1/table.php"	,

					//,
					//"sScrollY": "200px",
					//"bPaginate": false,

					//"sScrollX": "100%",
					//"sScrollXInner": "120%",
					//"bScrollCollapse": true,
					//Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
					//you may want to wrap the table inside a "div.dataTables_borderWrap" element

					//"iDisplayLength": 50


					// select: {
					// 	style: 'multi'
					// }
				});

			$.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';

			new $.fn.dataTable.Buttons(myTable, {
				buttons: [
					//   {
					// 	"extend": "colvis",
					// 	"text": "<i class='fa fa-search bigger-110 blue'></i> <span class='hidden'>Show/hide columns</span>",
					// 	"className": "btn btn-white btn-primary btn-bold",
					// 	columns: ':not(:first):not(:last)'
					//   },
					{
						"extend": "copy",
						"text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copy to clipboard</span>",
						"className": "btn btn-white btn-primary btn-bold",
						"title": "Copy",
						"data-toggle": "tooltip"
					},
					{
						"extend": "csv",
						"text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to CSV</span>",
						"className": "btn btn-white btn-primary btn-bold"
					},
					{
						"extend": "excel",
						"text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
						"className": "btn btn-white btn-primary btn-bold"
					},
					{
						"extend": "pdf",
						"text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
						"className": "btn btn-white btn-primary btn-bold"
					},
					{
						"extend": "print",
						"text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span>",
						"className": "btn btn-white btn-primary btn-bold",
						autoPrint: false,
						message: 'This print was produced using the Print button for DataTables'
					}
				]
			});
			myTable.buttons().container().appendTo($('.tableTools-container'));
		}

		function populate_table(table_ref, result_data) {
			var dataSet = [];
			var result_count = result_data.length;

			$.each(result_data, function(index, value) {
				var id = value.id;
				var username = value.username;
				var fullname = value.fullname.toUpperCase();
				var email = value.email;
				var role_name = value.role_name;
				var status_id = parseInt(value.status_id);
				var status = value.status;

				//var option = "";
				var option = table_buttons(table_ref, id, status_id);

				// <?php
					// if ($role_id == 1 || $this->custom_function->module_permission("modify", $module_permission)) { //if admin or has permission
					// 
					?>
				// 	option += "<button id='" + id + "' class='btn_change_pass btn btn-xs btn-success fa fa-refresh' title='Change Password' data-toggle='tooltip'></button> ";
				// 	option += "<button id='" + id + "' class='btn_users_modify btn btn-xs btn-info fa fa-pencil' title='Modify' data-toggle='tooltip'></button> ";
				// <?php
					// }
					// 
					?>

				// if (status_id == 1) {
				// 	<?php if ($role_id == 1 || $this->custom_function->module_permission("delete", $module_permission)) { //if admin or has permission 
							// 	
						?>
				// 		option += "<button id='" + id + "' class='btn_users_deactivate btn btn-xs btn-danger fa fa-times' title='Deactivate' data-toggle='tooltip'></button>";
				// 	<?php } ?>
				// } else {
				// 	<?php if ($role_id == 1 || $this->custom_function->module_permission("activate", $module_permission)) { //if admin or has permission
							// 	
						?>
				// 		option += "<button id='" + id + "' class='btn_users_activate btn btn-xs btn-warning fa fa-reply' title=''Activate' data-toggle='tooltip'></button>";

				// 	<?php } ?>
				// }


				dataSet.push([option, username, fullname, email, role_name, status, status_id, id]);
			});

			$("#lbl_count").text(result_count);
			reload_table(table_ref, dataSet);
		}

		$(document).ready(function() {
			reload_table("#tbl_users");
			$("#btn_users_search").trigger("click");
		});

		//start users
		$(document).on("keypress", "#txt_users_search", function(e) {
			if (e.which == 13) {
				$("#btn_users_search").trigger("click");
			}
		});

		$(document).on('click', '#btn_users_search', function() {
			var mysearch = $('#txt_users_search').val();

			$.get("<?= base_url(); ?>admin_user/search_users?search=" + mysearch, function(data) {

				if (data.indexOf("<!DOCTYPE html>") > -1) {
					alert("Error: Session Time-Out, You must login again to continue.");
					location.reload(true);
				} else if (data.indexOf("Error: ") > -1) {
					bootbox.alert(data);
					$('#txt_users_search').trigger('select', 'focus');
				} else {
					if (data) {
						result_data = JSON.parse(data);
						populate_table("#tbl_users", result_data);
					}

					$('[data-toggle="tooltip"]').tooltip({
						html: true
					});
				}
			});
		});

		$(document).on("click", "#btn_users_new", function() {
			$('.field_users').val('');
			$('.modal_error, .modal_waiting').hide();
			$('#modal_users_new').modal();

			$('#modal_users_new').on('shown.bs.modal', function() {
				$('#txt_users_username').trigger('select', 'focus');
			});
		});

		$(document).on('click', '#btn_users_save', function() {
			var username = $('#txt_users_username').val();
			var password = $('#txt_users_password').val();
			var repassword = $('#txt_users_repassword').val();
			var fname = $('#txt_users_fname').val();
			var mname = $('#txt_users_mname').val();
			var lname = $('#txt_users_lname').val();
			var email = $('#txt_users_email').val();
			var role_id = $("#dd_users_role").val();

			if (username && password && repassword && fname && lname && role_id) {
				if (password == repassword) {

					$('.modal_error, .modal_button').hide();
					$('.modal_waiting').show();

					$.post("<?= base_url(); ?>admin_user/add_users", {
						username: username,
						password: password,
						repassword: repassword,
						fname: fname,
						mname: mname,
						lname: lname,
						email: email,
						role_id: role_id
					}, function(data) {

						$('.modal_error, .modal_waiting').hide();
						$('.modal_button').show();

						if (data.indexOf("<!DOCTYPE html>") > -1) {
							alert("Error: Session Time-Out, You must login again to continue.");
							location.reload(true);
						} else if (data.indexOf("Error: ") > -1) {
							$("#modal_users_new .modal_error_msg").text(data);
							$("#modal_users_new  .modal_error").stop(true, true).show().delay(15000).fadeOut("slow");
							$('#txt_users_username').trigger('select', 'focus');
						} else {
							if (data) {
								result_data = JSON.parse(data);
								populate_table("#tbl_users", result_data);
							}
							// if (data) {
							// 	$("#tbl_users tbody").html(data);
							// } else {
							// 	$("#tbl_users tbody").html("<tr><td align='center' colspan='6'>No Record to display</td></tr>");
							// }

							$("#modal_users_new").modal('hide');
							$('[data-toggle="tooltip"]').tooltip({
								html: true
							});
						}
					});
				} else {
					$("#modal_users_new .modal_error_msg").text("Error: Password does not matched!");
					$("#modal_users_new .modal_error").stop(true, true).show().delay(15000).fadeOut("slow");
				}
			} else {
				$("#modal_users_new .modal_error_msg").text("Error: Fields with * are required!");
				$("#modal_users_new .modal_error").stop(true, true).show().delay(15000).fadeOut("slow");
			}
		});

		$(document).on('click', '.btn_users_modify', function(e) {
			e.preventDefault();

			var id = $(this).attr('id');

			if (id) {
				var table = $('#tbl_users').DataTable();
				current_row = table.row($(this).parents('tr'));
				current_data = current_row.data();

				$.post("<?= base_url(); ?>admin_user/info_users", {
					id: id
				}, function(data) {

					if (data.indexOf("<!DOCTYPE html>") > -1) {
						alert("Error: Session Time-Out, You must login again to continue.");
						location.reload(true);
					} else if (data.indexOf("Error: ") > -1) {
						alert(data);
					} else {
						data = JSON.parse(data);

						$(".hidden_users_id").val(data.id);
						$("#txt_users_username_update").val(data.username);
						$("#txt_users_fname_update").val(data.fname);
						$("#txt_users_mname_update").val(data.mname);
						$("#txt_users_lname_update").val(data.lname);
						$("#txt_users_email_update").val(data.email);
						$("#dd_users_role_update").val(data.role_id);

						$("#modal_users_modify").modal();

						$('#modal_users_modify').on('shown.bs.modal', function() {
							$('#txt_users_username_update').trigger('select', 'focus');
						});
					}
				});
			} else {
				alert("Error: Critical Error Encountered!");
			}
		});

		$(document).on('click', '#btn_users_update', function() {
			var id = $(".hidden_users_id").val();
			var username = $('#txt_users_username_update').val();
			var fname = $('#txt_users_fname_update').val();
			var mname = $('#txt_users_mname_update').val();
			var lname = $('#txt_users_lname_update').val();
			var email = $('#txt_users_email_update').val();
			var role_id = $("#dd_users_role_update").val();
			var role_name = $("#dd_users_role_update option:selected").text();

			if (id) {
				if (username && fname && lname && role_id) {

					$('.modal_error, .modal_button').hide();
					$('.modal_waiting').show();

					$.post("<?= base_url(); ?>admin_user/update_users", {
						id: id,
						username: username,
						fname: fname,
						mname: mname,
						lname: lname,
						email: email,
						role_id: role_id
					}, function(data) {

						$('.modal_error, .modal_waiting').hide();
						$('.modal_button').show();

						if (data.indexOf("<!DOCTYPE html>") > -1) {
							alert("Error: Session Time-Out, You must login again to continue.");
							location.reload(true);
						} else if (data.indexOf("Error: ") > -1) {
							$("#modal_users_modify .modal_error_msg").text(data);
							$("#modal_users_modify  .modal_error").stop(true, true).show().delay(15000).fadeOut("slow");
							$('#txt_users_username_update').trigger('select', 'focus');
						} else {
							current_data[1] = username;
							current_data[2] = lname + ", " + fname + " " + mname;
							current_data[3] = email;
							current_data[4] = role_name;
							current_row.data(current_data).invalidate();
							// if (data) {
							// 	$("#tbl_users tbody #tr_" + id).html(data);
							// } else {
							// 	$("#tbl_users tbody #tr_" + id).html("<tr><td align='center' colspan='6'>No Record to display</td></tr>");
							// }

							$("#modal_users_modify").modal('hide');
							$('[data-toggle="tooltip"]').tooltip({
								html: true
							});
						}
					});

				} else {
					$("#modal_users_modify .modal_error_msg").text("Error: Fields with * are required!");
					$("#modal_users_modify .modal_error").stop(true, true).show().delay(15000).fadeOut("slow");
					$('#txt_users_username_update').trigger('select', 'focus');
				}
			} else {
				$("#modal_users_modify .modal_error_msg").text("Error: Critical Error Encountered!");
				$("#modal_users_modify .modal_error").stop(true, true).show().delay(15000).fadeOut("slow");
				$('#txt_users_username_update').trigger('select', 'focus');
			}
		});

		$(document).on('click', '.btn_users_deactivate', function(e) {
			e.preventDefault();

			var id = $(this).attr('id');
			var status_id = 2; //inactive
			var status = "INACTIVE";

			if (id) {
				var table = $('#tbl_users').DataTable();
				current_row = table.row($(this).parents('tr'));
				current_data = current_row.data();

				bootbox.confirm("Are you sure you want to DEACTIVATE this user?", function(result) {
					if (result) {

						$.post("<?= base_url(); ?>admin_user/update_users_status", {
							id: id,
							status_id: status_id
						}, function(data) {

							if (data.indexOf("<!DOCTYPE html>") > -1) {
								alert("Error: Session Time-Out, You must login again to continue.");
								location.reload(true);
							} else if (data.indexOf("Error: ") > -1) {
								bootbox.alert(data);
							} else {
								current_data[0] = table_buttons("#tbl_users", current_data[7], status_id)
								current_data[5] = status;
								current_data[6] = status_id;
								current_row.data(current_data).invalidate().draw();

								$('[data-toggle="tooltip"]').tooltip({
									html: true
								});
							}
						});
					}
				});
			} else {
				alert("Error: Critical Error Encountered!");
			}
		});

		$(document).on('click', '.btn_users_activate', function(e) {
			e.preventDefault();

			var id = $(this).attr('id');
			var status_id = 1; //active
			var status = "ACTIVE";

			if (id) {
				var table = $('#tbl_users').DataTable();
				current_row = table.row($(this).parents('tr'));
				current_data = current_row.data();

				bootbox.confirm("Are you sure you want to ACTIVATE this user?", function(result) {
					if (result) {

						$.post("<?= base_url(); ?>admin_user/update_users_status", {
							id: id,
							status_id: status_id
						}, function(data) {

							if (data.indexOf("<!DOCTYPE html>") > -1) {
								alert("Error: Session Time-Out, You must login again to continue.");
								location.reload(true);
							} else if (data.indexOf("Error: ") > -1) {
								bootbox.alert(data);
							} else {
								current_data[0] = table_buttons("#tbl_users", current_data[7], status_id)
								current_data[5] = status;
								current_data[6] = status_id;
								current_row.data(current_data).invalidate().draw();

								$('[data-toggle="tooltip"]').tooltip({
									html: true
								});
							}
						});
					}
				});
			} else {
				alert("Error: Critical Error Encountered!");
			}
		});

		$(document).on("click", ".btn_change_pass", function(e) {
			e.preventDefault();

			var id = $(this).attr("id");
			if (id) {
				$(".hidden_users_id").val(id);

				$("#modal_users_changepass").modal();
				$(".field_users").val("");

				$('#modal_users_changepass').on('shown.bs.modal', function() {
					$("#txt_newpass_password").select().focus();
				});
			} else {
				bootbox.alert("Error: Critical Error Encountered!");
			}
		});

		$(document).on("click", "#btn_newpass_save", function() {
			var id = $(".hidden_users_id").val();
			var password = $("#txt_newpass_password").val();
			var repassword = $("#txt_newpass_repassword").val();

			if (id) {
				if (password && repassword) {
					if (password === repassword) {
						$("#modal_users_changepass .modal_button, #modal_users_changepass .modal_error").hide();
						$("#modal_users_changepass .modal_waiting").show();

						$.post("<?= base_url(); ?>admin_user/changepass_users", {
							id: id,
							password: password,
							repassword: repassword
						}, function(data) {

							if (data.indexOf("<!DOCTYPE html>") > -1) {
								alert("Error: Session Time-Out, You must login again to continue.");
								location.reload(true);
							} else if (data.indexOf("Error: ") > -1) {
								$("#modal_users_changepass .modal_error_msg").text(data);
								$("#modal_users_changepass .modal_error").stop(true, true).show().delay(15000).fadeOut("slow");
								$("#txt_newpass_password").select().focus();
							} else {
								$("#modal_users_changepass").modal("hide");
								bootbox.alert(data);
							}
						});

					} else {
						$("#modal_users_changepass .modal_error_msg").text("Error: Password does not match!");
						$("#modal_users_changepass .modal_error").stop(true, true).show().delay(15000).fadeOut("slow");
						$("#txt_newpass_password").select().focus();
					}
				} else {
					$("#modal_users_changepass .modal_error_msg").text("Error: All fields are required!");
					$("#modal_users_changepass .modal_error").stop(true, true).show().delay(15000).fadeOut("slow");
					$("#txt_newpass_password").select().focus();
				}
			} else {
				$("#modal_users_changepass .modal_error_msg").text("Error: Critical Error Encountered!");
				$("#modal_users_changepass .modal_error").stop(true, true).show().delay(15000).fadeOut("slow");
				$("#txt_newpass_password").select().focus();
			}
		});
	</script>
</body>

</html>