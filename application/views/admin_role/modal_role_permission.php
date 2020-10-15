<!-- bootstrap modal -->
<div id='modal_role_permission' class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="blue bigger"><i class="fa fa-list fa-fw"></i>Module Permission</h4>
				<input type="hidden" class="hidden_role_id" />
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-4">
						<label>Module</label>
						<select id="dd_role_perm_module" class="form-control">
							<?php
							foreach ($module_list as $key => $value) {
								$id = intval($value->id);
								$val = $value->module_name;

								if ($role_id != 1) {
									if ($id == 3 || $id == 4 || $id == 5 || $id == 7) { //permission,module,parent,queue
										continue; //skip
									}
								}

								echo "<option value='{$id}'>{$val}</option>";
							}
							?>
						</select>
					</div>
					<div class="col-sm-4">
						<label>Permission</label>
						<select id="dd_role_perm_permission" class="form-control">
							<?php
							foreach ($permission_list as $key => $value) {
								echo "<option value='{$value->id}'>{$value->permission}</option>";
							}
							?>
						</select>
					</div>
					<div class="col-sm-4">
						<label>&nbsp;</label>

						<?php
						if ($role_id == 1 || $this->custom_function->module_permission("add", $module_permission)) { //admin or has add permission
							echo "	<a id='btn_role_perm_add' class='btn btn-success form-control'>
												<i class='fa fa-plus fa-fw'></i>Add
											</a>";
						}
						?>

					</div>
				</div>
				<hr />
				<div class="row" style="max-height: 290px; overflow-y: scroll;">
					<div class="col-sm-12">
						<table id='tbl_mod_perm' class="table table-striped table-bordered table-responsive" style="font-size: small;">
							<thead>
								<tr>
									<th>OPTION</th>
									<th>MODULE</th>
									<th>PERMISSION</th>
								</tr>
							</thead>
							<tbody>
								<td colspan="3" align="center">No Module</td>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="modal-footer">

				<div class="text-center modal_button">
					<button type="button" class="btn btn-danger" data-dismiss="modal"><span class='fa fa-times'> Close</button>
				</div>

				<div class="pull-left modal_error" style='display:none'>
					<div class="alert alert-danger">
						<strong>
							<i class="ace-icon fa fa-times"></i>
						</strong>
						<span class="modal_error_msg">
							Error: Critical Error Encountered!
						</span>

						<br />
					</div>
				</div>

				<div class="modal_waiting" style='display:none'>
					<div class="progress">
						<div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
							Request is being processed... Please wait!
						</div>
					</div>
				</div>
			</div>


		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->