<div class="modal fade" id="modal_restore" data-keyboard="false" data-backdrop="static" >
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="blue bigger"><i class='fa fa-download fa-fw'> </i>Restore Database</h4>				
			</div>
			
            <div class="modal-body">
				<div class="row">					
					<div class="col-xs-12">
						<div class="form-group">
							<p class="alert-danger" >Select .sql file to restore</p>
							<div class="col-xs-12">
								<form method="post" id="frm_restore" name="frm_restore" >	
									<input type="file" name="file_restore" id="file_restore" />
								</form>
							</div>
						</div>		
					</div>
				</div>	
            </div>	
			
			<div class="modal-footer">
				<div class="pull-right modal_button">
					<button type="button" id="btn_restore_save" class="btn btn-primary" ><span class='fa fa-upload'></span> Upload </button>
					<button type="button" class="btn btn-danger" data-dismiss="modal" ><span class='fa fa-times'> Close</button>
				</div>
				
				<div  class="pull-left modal_error" style="display:none">
					<div class="alert alert-danger"
						<strong>
							<i class="ace-icon fa fa-times"></i>							
						</strong>
						<span class="modal_error_msg">
							Error: Critical Error Encountered!
						</span>
						
						<br />
					</div>
				</div>
			
				<div  class="pull-left modal_success" style="display:none">
					<div class="alert alert-success"
						<strong>
							<i class="ace-icon fa fa-times"></i>							
						</strong>
						<span class="modal_success_msg">
							Success
						</span>
						
						<br />
					</div>
				</div>
				
				<div class="modal_waiting" style='display:none'>
					<div class="progress">
						<div class="progress-bar progress-bar-primary progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
							Request is being processed... Please wait!
						</div>
					</div>
					
					<div>
						<?php
							$this->load->view('template/qoutes');
						?>
					</div>
				</div>
				  
			</div>
			
        </div>
    </div>
</div>