<!-- bootstrap modal -->
	<div id='modal_role_new' class="modal fade" tabindex="-1" role="dialog">
	  	<div class="modal-dialog" role="document">
	    	<div class="modal-content">
	      		<div class="modal-header">	        		
	        		<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="blue bigger"><i class="fa fa-plus fa-fw"></i>New Role</h4>	     
	      		</div>
	      		<div class="modal-body">	        		
	        			<div class="row" style="margin-bottom: 0.5em;">
				            <div class="col-sm-12">
				              	<label>Role Name</label>
				              	<input type="text" name="txt_role_name" id="txt_role_name" class="field_role form-control" />
				            </div>				            
				        </div>
				    
	      		</div>
	      		<div class="modal-footer">
	        		
	      			<div class="pull-right modal_button">
						<button type="button" id="btn_role_save" class="btn btn-info" ><span class='fa fa-check'></span> Save </button>
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
							<div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
								Request is being processed... Please wait!
							</div>
						</div>
					</div>
	      		</div>


	    	</div><!-- /.modal-content -->
	  	</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->