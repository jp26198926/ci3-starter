<!-- bootstrap modal -->
	<div id='modal_users_modify' class="modal fade" tabindex="-1" users="dialog">
		<div class="modal-dialog" users="document">
	    	<div class="modal-content">
	      		<div class="modal-header"> 
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="blue bigger"><i class='fa fa-pencil fa-fw'></i> Modify User</h4>					<input type="hidden" class="hidden_users_id" />
	      		</div>
	      		<div class="modal-body">	        		
	        		<div class="row" style="margin-bottom: 0.5em;">
				        <div class="col-sm-12">
				            <label>Username *</label>
				            <input type="text" id="txt_users_username_update" class="field_users form-control" />
				        </div>
				    </div>
					<div class="row" style="margin-bottom: 0.5em;">
				        <div class="col-sm-4">
				            <label>First Name *</label>
				            <input type="text" id="txt_users_fname_update" class="field_users form-control" />
				        </div>
						<div class="col-sm-4">
				            <label>Middle Name</label>
				            <input type="text" id="txt_users_mname_update" class="field_users form-control" />
				        </div>
						<div class="col-sm-4">
				            <label>Last Name * </label>
				            <input type="text" id="txt_users_lname_update" class="field_users form-control" />
				        </div>
				    </div>
					<div class="row" style="margin-bottom: 0.5em;">
				        <div class="col-sm-6">
				            <label>Email</label>
				            <input type="text" id="txt_users_email_update" class="field_users form-control" />
				        </div>
						<div class="col-sm-6">
				            <label>Role *</label>
							<select id="dd_users_role_update" class="form-control">
								<?php
									foreach($role_list as $key => $value){
										echo "<option value='{$value->id}'>{$value->role_name}</option>";
									}
								?>
							</select>
				        </div>						
				    </div>
	        		
	      		</div>
	      		<div class="modal-footer">
	        		
	      			<div class="pull-right modal_button">
						<button type="button" id="btn_users_update" class="btn btn-info" ><span class='fa fa-check'></span> Save </button>
						<button type="button" class="btn btn-danger" data-dismiss="modal" ><span class='fa fa-times'> Cancel</button>
					</div>
					
					<div  class="pull-left modal_error" style='display:none'>
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
							<div class="progress-bar progress-bar-info progress-bar-striped active" users="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
								Request is being processed... Please wait!
							</div>
						</div>
					</div>
	      		</div>


	    	</div><!-- /.modal-content -->
	  	</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->