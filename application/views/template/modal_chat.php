<!-- bootstrap modal -->
<div id='modal_chat' class="modal fade" tabindex="-1" users="dialog">
	<div class="modal-dialog modal-lg" users="document">
	    <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="blue bigger">
					<i class='fa fa-comment fa-fw'></i> Chat Conversation
					<small>
						| Showing messages from:
						<input type="text" id="txt_chat_fromdate" class="input-sm text-center datepicker" value="<?= date('Y-m-d'); ?>" readonly />
					</small>
				</h4>
			</div>
			<div class="modal-body">
				<div class="dialogs ace-scroll">
					<div class="scroll-content chat_content" style="max-height: 300px; overflow-y:scroll;">
						
						
					</div>
				</div>
	      	</div>
	      	<div class="modal-footer">
	        	<div class="form-actions">
					<div class="input-group">
						<textarea id="txt_chat_msg" placeholder="Type your message here ..."  class="form-control" name="message"></textarea>
						<span class="input-group-btn">
							<button id="btn_chat_send" class="btn btn-lg btn-info no-radius" type="button">
								<i class="ace-icon fa fa-send"></i>
								Send
							</button>
						</span>
					</div>
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