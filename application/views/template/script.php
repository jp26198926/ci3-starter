<!-- Global Variable -->
<!--[if !IE]> -->
<script src="<?= base_url(); ?>assets/js/jquery-2.1.4.min.js"></script>
<!-- <![endif]-->

<!--[if IE]>
<script src="<?= base_url(); ?>assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
		
<script type="text/javascript">
    if('ontouchstart' in document.documentElement) document.write("<script src='<?= base_url(); ?>assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>
		
		<script src="<?= base_url(); ?>assets/js/popper.min.js"></script>
		<script src="<?= base_url(); ?>assets/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->
		<script src="<?= base_url(); ?>assets/js/jquery-ui.min.js"></script>
		<script src="<?= base_url(); ?>assets/js/bootbox.js"></script>
		<script src="<?= base_url(); ?>assets/js/wizard.min.js"></script>		
		<script src="<?= base_url(); ?>assets/js/multiselect.js"></script>
		<script src="<?= base_url(); ?>assets/js/bootstrap-clockpicker.js"></script>
		<script src="<?= base_url(); ?>assets/js/chosen.jquery.min.js"></script>
		<script src='<?= base_url(); ?>assets/js/table-fixed-header.js'></script>
		
		<!-- <script src='<?= base_url(); ?>assets/js/duplicate_rows.js'></script> -->
		<script src="<?= base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
		<script src="<?= base_url(); ?>assets/js/jquery.dataTables.bootstrap.min.js"></script>
		<script src="<?= base_url(); ?>assets/js/dataTables.buttons.min.js"></script>
		<script src="<?= base_url(); ?>assets/js/buttons.flash.min.js"></script>
		<script src="<?= base_url(); ?>assets/js/buttons.html5.min.js"></script>
		<script src="<?= base_url(); ?>assets/js/buttons.print.min.js"></script>
		<script src="<?= base_url(); ?>assets/js/buttons.colVis.min.js"></script>
		<script src="<?= base_url(); ?>assets/js/dataTables.select.min.js"></script>
		
		
		<!-- ace scripts -->
		<script src="<?= base_url(); ?>assets/js/ace-elements.min.js"></script>
		<script src="<?= base_url(); ?>assets/js/ace.min.js"></script>
		
		<!-- countdown script -->
		<script src="<?= base_url(); ?>assets/js/jquery.plugin.min.js"></script>
		<script src="<?= base_url(); ?>assets/js/jquery.countdown.js"></script>
		
		<!-- custom script by jaypee hindang 
		<script src="<?= base_url(); ?>assets/js/qoutes.js"></script>
		-->
		<script src="<?= base_url(); ?>assets/js/chat.js"></script>
		
		
		
		<script>
			            
            //set default skin
			/*
				#438EB9="no-skin" 	default
				#222A2D="skin-1"	black	
				#C6487E="skin-2"	purple
				#D0D0D0="skin-3"	light	
			*/
			
			var quotes = [];

	function show_quotes(quotes_array) {
		//console.log(randomItem);
		for (var i = 1; i <= 3; i++) {
			var randomItem = quotes_array[Math.floor(Math.random() * quotes_array.length)];
			$(".quotes_msg" + i).text(randomItem.quotes);
			$(".quotes_author" + i).text(randomItem.author);
		}
	}

	$(document).ready(function() {
		//$("#skin-colorpicker").val("#222A2D").trigger("change");
		$.post("<?= base_url(); ?>quotes/get_quotes/20", function(data) {
			quotes = JSON.parse(data);
			show_quotes(quotes);
		});

		setInterval(function() {
			if (quotes.length > 0) {
				show_quotes(quotes);
			}
		}, 10000);
	});
			
			
			$('[data-toggle="tooltip"]').tooltip({html:true});
			$('[data-toggle="popover"]').popover({html:true}); 
			$('.table-fixed-header').fixedHeader();
			
			$(function() {
				$('.clockpicker').clockpicker();
				
				$( ".datepicker" ).datepicker({
					changeMonth: true,
					changeYear: true,
					yearRange: "c-100:c+10",
				});             
				
				$( ".datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd");
				
				//yearpicker
				
				for (i=new Date().getFullYear() + 10; i > 1900; i--){
					$('.yearpicker').append($('<option />').val(i).html(i));
				}
			});
			
			$(document).on('keypress','.numeric', function(e){
				
				if ((e.which < 48 && e.which != 46 && e.which !=45) || e.which > 57) {
					return false;
				}else if (e.which == 46){
					if ($(this).val().indexOf('.') > -1) {
						return false;
					}
				}else if (e.which == 45){ //negative sign
					var occurrence = $(this).val().indexOf('-');
					var cursor = document.getElementById($(this).attr('id')).selectionStart;
					
					if (cursor > 0 || occurrence > -1) {
						return false;
					}
				}
			});
			
			$(document).on('blur','.numeric',function(e){
				e.preventDefault();
				if ($(this).val().length === 0) {
					$(this).val('0.00');
				}
			});
			
			$(document).on('keypress','.numeric_unsigned', function(e){
				
				if ((e.which < 48 && e.which != 46 ) || e.which > 57) {
					return false;
				}else if (e.which == 46){ //decimal point
					if ($(this).val().indexOf('.') > -1) {
						return false;
					}
				}
				
			});
			
			$(document).on('blur','.numeric_unsigned',function(e){
				e.preventDefault();
				if ($(this).val().length === 0) {
					$(this).val('0.00');
				}
			});
            
           	$(document).on('keypress','.numeric_int', function(e){
				
				if ((e.which < 48 && e.which != 46 ) || e.which > 57) {
					return false;
				}
				
			});
			
			$(document).on('blur','.numeric_int',function(e){
				e.preventDefault();
				if ($(this).val().length === 0) {
					$(this).val('0');
				}
			});

			$(document).on('keypress','.numeric_int2', function(e){
				
				if ((e.which < 48 && e.which != 46 ) || e.which > 57) {
					return false;
				}
				
			});
			
			$.widget("ui.tooltip", $.ui.tooltip, {
				options: {
					content: function () {
						return $(this).prop('title');
					}
				}
			});
			
			
			
			$(document).on("keypress",".field_user",function(e){
				if (e.which == 13){
					$("#btn_changepass_save").trigger("click");
				}
			});
			
			
			
			$(document).on("click",".common_changepass",function(e){				
				e.preventDefault();
				
				var id = $(this).attr('id');
				
				if (id){
					$("#modal_changepass").modal();
					
					$(".hidden_user_id").val(id);
					$(".field_user").val("");
					
					$('#modal_changepass').on('shown.bs.modal', function () {
						$('#txt_changepass_currentpassword').trigger('select','focus');
					});
					
				}else{
					bootbox.alert("Error: Critical Error Encountered!");
				}
			});
			
			$(document).on("click","#btn_changepass_save",function(e){
				e.preventDefault();
				
				var id = $(".hidden_user_id").val();
				var current_password = $("#txt_changepass_currentpassword").val();
				var password = $("#txt_changepass_password").val();
				var repassword = $("#txt_changepass_repassword").val();
				
				if (id && current_password && password && repassword){
					if (password == repassword){
						$("#modal_changepass .modal-body").hide();
						$("#modal_changepass .modal_button").hide();
						$("#modal_changepass .modal_error").hide();
						$("#modal_changepass .modal_waiting").show();						
								
						$.post("<?= base_url(); ?>admin_user/changepass_users_global",{	action:1,
																							id:id,
																							current_password:current_password,
																							password:password,
																							repassword:repassword
																						},function(data){
											
							$("#modal_changepass .modal-body").show();
							$("#modal_changepass .modal_button").show();							
							$("#modal_changepass .modal_waiting").hide();			
										
							if(data.indexOf("<!DOCTYPE html>")>-1){
								alert("Error: Session Time-Out, You must login again to continue.");
								location.reload(true);                     
							}else if (data.indexOf("Error: ")>-1){
								$("#modal_changepass .modal_error_msg").text(data);
								$("#modal_changepass .modal_error").stop(true,true).show().delay(15000).fadeOut("slow");
								$("#txt_changepass_currentpassword").focus().select();
							}else{							
								$("#modal_changepass").modal('hide');
								bootbox.alert("Password Changed!");
							}
						});
					}else{
						$("#modal_changepass .modal_error_msg").text("Error: Password does not matched!");
						$("#modal_changepass .modal_error").stop(true,true).show().delay(15000).fadeOut("slow");
						$("#txt_changepass_currentpassword").focus().select();
					}
				}else{
					$("#modal_changepass .modal_error_msg").text("Error: Critical Error Encountered!");
					$("#modal_changepass .modal_error").stop(true,true).show().delay(15000).fadeOut("slow");
					$("#txt_changepass_currentpassword").focus().select();
				}
				
			});
			
			//change pass
			//chat
			
			function chat_messages(chat_id,sender_id, sender_name, msg, dt, photo){
				var d = new Date(dt);
				var template = " <div class='itemdiv dialogdiv'>";
					template +="	<div class='user'>";
					template +="		<img alt='' src='" + photo + "'>";
					template +="	</div>";
					template +="	<div class='body'>";
					template +="		<div class='time'>";
					template +="			<i class='ace-icon fa fa-clock-o'></i>";
					template +="			<span class='green'>" + d + "</span>";
					template +="		</div>";
					template +="		<div class='name'>";
					template +="			<a href='#' id='chat" + chat_id + "'>" + (sender_name + "").toUpperCase() + "</a>";
					template +="		</div>";
					template +="		<div class='text chat_messages' >" + msg + "</div>";
					template +="		<div class='tools'>";
					template +="			<a href='#' class='btn btn-minier btn-info'>";
					template +="				<i class='icon-only ace-icon fa fa-reply'></i>";
					template +="			</a>";
					template +="		</div>";
					template +="	</div>";
					template +=" </div>	";
				
				return template;
			}
			
			function chat_last_message(chat_id,sender_id, sender_name, msg, dt){				
				var template = 	"<img src='<?= base_url(); ?>assets/images/user.png' class='msg-photo' alt='" + sender_name + " Photo'>";
					template += "<span class='msg-body'>";
		            template += "	<span class='msg-title'>";
					template += "		<span class='blue'>" + (sender_name + "").toUpperCase() + ": </span>" + msg;
					template += "	</span>";
					template += "   <span class='msg-time'>";
					template += "		<i class='ace-icon fa fa-clock-o'></i>";
					template += "		<span>" + dt + "</span>";
					template += "	</span>";
					template += "</span>";				
				return template;
			}
			
			
			var websocket = new WebSocket("ws://localhost:8090/clinic/socket/chat_server.php"); 
			
			$(document).ready(function(){
					
				$("#txt_chat_fromdate").val("<?= date('Y-m-d'); ?>");
				
				//setInterval(function() {
					var fromDate = $("#txt_chat_fromdate").val();
					
					$.post("<?= base_url(); ?>chat/get_last_message",{},function(data){
						if(data.indexOf("<!DOCTYPE html>")>-1){
							alert("Error: Session Time-Out, You must login again to continue.");
							location.reload(true);                     
						}else if (data.indexOf("Error: ")>-1) {						
							//bootbox.alert(data);
						}else{
							if (data){
								var msg = JSON.parse(data);
								var result = chat_last_message(msg.id, msg.sender_id, msg.fname, msg.msg, msg.dt);								
								$(".chat_notification").html(result);								
							}
						}
					});
					
					
					$.post("<?= base_url(); ?>chat/get_messages",{fromDate: fromDate},function(data){						
						
						if(data.indexOf("<!DOCTYPE html>")>-1){
							alert("Error: Session Time-Out, You must login again to continue.");
							location.reload(true);                     
						}else if (data.indexOf("Error: ")>-1) {						
							bootbox.alert(data);
						}else{
							var msg_lst = "No Conversation Yet!";
							
							if (data){
								
								var messages = JSON.parse(data);
								
								if (messages.length > 0){
									msg_lst = "";
									
									$.each(messages, function(i, v) {										
										var photo = "<?= base_url(); ?>assets/images/user.png";
										msg_lst += chat_messages(v.chat_id, v.sender_id, v.sender, v.msg, v.dt, photo);										
									});
									
									$(".chat_content").html(msg_lst);	
								}else{
									$(".chat_content").html(msg_lst);	
								}													
							}else{
								$(".chat_content").html(msg_lst);
							}							
						}
					});
					
					
				//}, 1000);
				
				websocket.onmessage = function(event) {
					console.log(event.data);
					if (event.data){
						var Data = JSON.parse(event.data);
						var photo = "<?= base_url(); ?>assets/images/user.png";
						var msg = "";
						
						if (Data.message_type === "chat-msg"){
							var result = chat_last_message(0, 0, Data.chat_user, Data.chat_message, Data.dt);								
							$(".chat_notification").html(result);	
												
							msg = chat_messages(0,0,Data.chat_user, Data.chat_message, Data.dt, photo);
						}else{
							msg = "<div class='alert alert-warning'>" + Data.message + "</div>";
						}
						
						$(".chat_content").append(msg);
						$(".chat_content").animate({ scrollTop: $(".chat_content").prop("scrollHeight")}, 1000);
					}
				};			
				websocket.onopen = function() {
					$(".chat_content").append("<div class='alert alert-success'>Connection is established!</div>");
				};			
				websocket.onerror = function(){
					$(".chat_content").append("<div class='alert alert-danger'>Problem due to some Error!</div>");
				};
				websocket.onclose = function(){
					$(".chat_content").append("<div class='alert alert-warning'>Connection Closed!</div>");
				};
			});
			
			$(document).on("click",".common_chat",function(e){				
				e.preventDefault();
							
				var id = $(this).attr('id');
				var fromDate = $("#txt_chat_fromdate").val();
				
				if (id){
					$("#loading").modal();
					
					$.post("<?= base_url(); ?>chat/get_messages",{fromDate:fromDate},function(data){
						$("#loading").modal("hide");
						
						if(data.indexOf("<!DOCTYPE html>")>-1){
							alert("Error: Session Time-Out, You must login again to continue.");
							location.reload(true);                     
						}else if (data.indexOf("Error: ")>-1) {						
							bootbox.alert(data);
						}else{
							var msg_lst = "No Converssation Yet";	
							
							if (data){
								var messages = JSON.parse(data);
								
								if (messages.length > 0){
									msg_lst = "";
									$.each(messages, function(i, v) {
										var chat_id = v.id;
										var sender_id = v.sender_id;
										var sender = v.sender;
										var msg = v.msg;
										var dt = v.dt;
										var photo = "<?= base_url(); ?>assets/images/user.png";
										msg_lst += chat_messages(chat_id,sender_id, sender, msg, dt, photo);
									});									
									
									$(".chat_content").html(msg_lst);
									$("#modal_chat").modal();
										
									$('#modal_chat').on('shown.bs.modal', function () {									
										$("#txt_chat_msg").focus().select();
										$(".chat_content").animate({ scrollTop: $(".chat_content").prop("scrollHeight")}, 1000);
									});
								}else{
									$(".chat_content").html(msg_lst);
									$("#modal_chat").modal();
								}								
							}else{
								$(".chat_content").html(msg_lst);
								$("#modal_chat").modal();
							}
						}
					});		
				}else{
					bootbox.alert("Error: Critical Error Encountered!");
				}
			});
			
			$(document).on("keypress","#txt_chat_msg",function(e){
				if (e.which == 13 && !e.shiftKey){		
					$("#btn_chat_send").trigger("click");
					return false;
				}
			});
			
			$(document).on("click","#btn_chat_send", function(){
				var user_id = "<?= $uid; ?>";
				var chat_user = "<?= $ufname; ?>";
				var msg = $("#txt_chat_msg").val().trim();
				var dt = "<?= date('Y-m-d H:i:s'); ?>";
				//var fromDate = $("#txt_chat_fromdate").val();
				$("#txt_chat_msg").val("").focus().select();
				
				if (msg){
					var messageJSON = {
						user_id: user_id, //
						chat_user: chat_user,
						chat_message: msg,
						dt:dt
					};					
					websocket.send(JSON.stringify(messageJSON));
				}
			});
			
			$(document).on("change","#txt_chat_fromdate",function(){
				var fromDate = $("#txt_chat_fromdate").val();
				
				if (fromDate){
					$.post("<?= base_url(); ?>chat/get_messages",{fromDate: fromDate},function(data){						
						
						if(data.indexOf("<!DOCTYPE html>")>-1){
							alert("Error: Session Time-Out, You must login again to continue.");
							location.reload(true);                     
						}else if (data.indexOf("Error: ")>-1) {						
							bootbox.alert(data);
						}else{
							var msg_lst = "No Conversation Yet!";
							
							if (data){
								
								var messages = JSON.parse(data);
								
								if (messages.length > 0){
									msg_lst = "";
									
									$.each(messages, function(i, v) {										
										var photo = "<?= base_url(); ?>assets/images/user.png";
										msg_lst += chat_messages(v.chat_id, v.sender_id, v.sender, v.msg, v.dt, photo);										
									});
									
									$(".chat_content").html(msg_lst);	
								}else{
									$(".chat_content").html(msg_lst);	
								}													
							}else{
								$(".chat_content").html(msg_lst);
							}							
						}
					});
				}
			});
			
			
			/*
			$(document).on("click","#btn_chat_send", function(){
				var msg = $("#txt_chat_msg").val().trim();
				var fromDate = $("#txt_chat_fromdate").val();
				$("#txt_chat_msg").val("").focus().select();
				
				if (msg){
					$.post("<?= base_url(); ?>chat/send_message",{msg:msg,fromDate:fromDate},function(data){
						
						if(data.indexOf("<!DOCTYPE html>")>-1){
							alert("Error: Session Time-Out, You must login again to continue.");
							location.reload(true);                     
						}else if (data.indexOf("Error: ")>-1) {						
							bootbox.alert(data);
						}else{
							if (data){
								var messages = JSON.parse(data);
								var msg_lst = "";								
								
								if (messages.length > 0){
									
									$.each(messages, function(i, v) {
										var chat_id = v.chat_id;
										var sender_id = v.sender_id;
										var sender = v.sender;
										var msg = v.msg;
										var dt = v.dt;
										var photo = "<?= base_url(); ?>assets/images/user.png";
										msg_lst += chat_messages(chat_id,sender_id,sender, msg, dt, photo);
									});
								}
								
								$(".chat_content").html(msg_lst);
								$("#txt_chat_msg").val("").focus().select();
								$(".chat_content").animate({ scrollTop: $(".chat_content").prop("scrollHeight")}, 1000);
							}
						}
					});
				}
			});
			*/
			//chat
			//chat
			
		</script>