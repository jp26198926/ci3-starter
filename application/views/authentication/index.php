<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title> <?= $app_code; ?> </title>

		<meta name="description" content="User login page" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

		<?php
			$this->load->view('template/style');
		?>
	</head>

	<body class="login-layout">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h1>
									<!--
									<i class="ace-icon fa fa-leaf green"></i>
									<span class="red">Ace</span>
									-->
									<span class="white" id="id-text2"><b><?= $app_code; ?></b></span>
								</h1>
								<h4 class="blue" id="id-company-text">version <?= $app_version; ?> </h4>
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header blue lighter bigger text-center">												
												<strong>Please Enter Your Information</strong>
												<br />
												<span id='local_ip' class='text-center'></span>
											</h4>

											<div class="space-6"></div>

											<form>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input id='txt_login_username' type="text" class="form-control" placeholder="Username" />
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input id='txt_login_password' type="password" class="form-control" placeholder="Password" />
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>

													<div class="space"></div>

													<div class="clearfix">
														
														<div class="login_button text-center">
															<button id='btn_login' type="button" class="width-35  btn btn-sm btn-primary">
																<i class="ace-icon fa fa-key"></i>
																<span class="bigger-110">Login</span>
															</button>
														</div>
														
														<div  class="login_error text-center" style='display:none'>
															<div class="alert alert-danger"
																<strong>
																	<i class="ace-icon fa fa-times"></i>																	
																</strong>
																<span class="login_error_msg">
																	Critical Error Encountered!
																</span>
																
																<br />
															</div>
														</div>
														
														<div class="login_waiting text-center" style='display:none'>
															<div class="progress">
																<div class="progress-bar progress-bar-primary progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%">
																	Validating your credential... Please wait!
																</div>
															</div
															
														</div>
														
													</div>

													<div class="space-4"></div>
												</fieldset>
											</form>
																						
										</div><!-- /.widget-main -->

										<div class="toolbar clearfix">
											<div>
												<a id="link_forgot" href="#" data-target="#forgot-box" class="forgot-password-link">
													<i class="ace-icon fa fa-arrow-left"></i>
													I forgot my password
												</a>
											</div>
											
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.login-box -->

								<div id="forgot-box" class="forgot-box widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header red lighter bigger">
												<i class="ace-icon fa fa-key"></i>
												Retrieve Password
											</h4>

											<div class="space-6"></div>
											<p>
												Enter your email and to receive instructions
											</p>

											<form>
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input id='txt_login_email' type="email" class="form-control" placeholder="Email" />
															<i class="ace-icon fa fa-envelope"></i>
														</span>
													</label>

													<div class="clearfix">
														<button id='btn_login_sendmail' type="button" class="width-35 pull-right btn btn-sm btn-danger">
															<i class="ace-icon fa fa-lightbulb-o"></i>
															<span class="bigger-110">Send Me!</span>
														</button>
													</div>
												</fieldset>
											</form>
										</div><!-- /.widget-main -->

										<div class="toolbar center">
											<a id="link_backto_login" href="#" data-target="#login-box" class="back-to-login-link">
												Back to login
												<i class="ace-icon fa fa-arrow-right"></i>
											</a>
										</div>
									</div><!-- /.widget-body -->
								</div><!-- /.forgot-box -->
								
							</div><!-- /.position-relative -->

							<div class="navbar-fixed-top align-right">
								<br />
								&nbsp;
								<a id="btn-login-dark" href="#">Dark</a>
								&nbsp;
								<span class="blue">/</span>
								&nbsp;
								<a id="btn-login-blur" href="#">Blur</a>
								&nbsp;
								<span class="blue">/</span>
								&nbsp;
								<a id="btn-login-light" href="#">Light</a>
								&nbsp; &nbsp; &nbsp;
							</div>
						</div>
					</div><!-- /.col -->
				</div><!-- /.row -->
			</div><!-- /.main-content -->
		</div><!-- /.main-container -->

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script src="<?= base_url(); ?>assets/js/jquery-2.1.4.min.js"></script>	
		<!-- <![endif]-->

		<!--[if IE]>
		<script src="<?= base_url(); ?>assets/js/jquery-1.11.3.min.js"></script>
		<![endif]-->
		
		<script src="<?= base_url(); ?>assets/js/bootstrap.min.js"></script>
		<script src="<?= base_url(); ?>assets/js/bootbox.js"></script>
		
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?= base_url(); ?>assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
				$(document).on('click', '.toolbar a[data-target]', function(e) {
				   e.preventDefault();
				   var target = $(this).data('target');
				   $('.widget-box.visible').removeClass('visible');//hide others
				   $(target).addClass('visible');//show target
				});
			});
			
						
			//you don't need this, just used for changing background
			jQuery(function($) {
			 $('#btn-login-dark').on('click', function(e) {
				$('body').attr('class', 'login-layout');
				$('#id-text2').attr('class', 'white');
				$('#id-company-text').attr('class', 'blue');
				
				e.preventDefault();
			 });
			 $('#btn-login-light').on('click', function(e) {
				$('body').attr('class', 'login-layout light-login');
				$('#id-text2').attr('class', 'grey');
				$('#id-company-text').attr('class', 'blue');
				
				e.preventDefault();
			 });
			 $('#btn-login-blur').on('click', function(e) {
				$('body').attr('class', 'login-layout blur-login');
				$('#id-text2').attr('class', 'white');
				$('#id-company-text').attr('class', 'light-blue');
				
				e.preventDefault();
			 });
			 
			});
			
			$(document).ready(function(){				
				//$('#btn-login-dark').trigger('click');
				$('#btn-login-blur').trigger('click');
				$('#txt_login_username').trigger('select','focus');
			});
			
			$(document).on('keypress','#txt_login_username, #txt_login_password',function(e){
				if (e.which==13){
					$('#btn_login').trigger('click');
				}
			});
			
			$(document).on('click','#btn_login',function(e){
				e.preventDefault();			
				
				
				var u = $("#txt_login_username").val();
				var p = $("#txt_login_password").val();
				var local_ip = $("#local_ip").text();
				
				if (u && p) {
					
					$('#txt_login_username, #txt_login_password').attr('disabled','disabled');
					$('.login_button, .login_error, .forgot-password-link').hide();
					$('.login_waiting').show();
					
					$.post("<?= base_url(); ?>authentication/authenticate",{username: u, password: p, local_ip:local_ip},function(data){						
						if (data.indexOf("Error:")>-1) {
							$("#txt_login_username, #txt_login_password").val("");
							$('#txt_login_username, #txt_login_password').removeAttr('disabled');
							$('.login_button,.forgot-password-link').show();							
							$('.login_waiting').hide();							
							
							$("#txt_login_username").trigger('select','focus');
							$(".login_error_msg").text(data);
							$(".login_error").stop(true,true).show().delay(15000).fadeOut("slow");
						}else{
							
							window.location = "<?= base_url(); ?>";
							
						}						
					});
				}else{
					$("#txt_login_username").trigger('select','focus');
					$(".login_error_msg").text("Error: Login Failed!, Try Again.");
					$(".login_error").stop(true,true).show().delay(15000).fadeOut("slow");
				}
				
				
			});
			
			
			$(document).on("click","#btn_login_sendmail",function(){
				var email = $("#txt_login_email").val();
				if (email){
					$.post("<?= base_url(); ?>authentication/forgot_password",{email:email},function(data){						
						if (data.indexOf("Error:")>-1) {
							bootbox.alert(data);
						}else{
							$("#txt_login_email").val("");
							bootbox.alert("Request has been sent!");
							$("#link_backto_login").trigger("click");						
						}						
					});
				}else{
					bootbox.alert("Error: Please enter your email!");
				}
			});
			
			// NOTE: window.RTCPeerConnection is "not a constructor" in FF22/23
			var RTCPeerConnection = /*window.RTCPeerConnection ||*/ window.webkitRTCPeerConnection || window.mozRTCPeerConnection;
			
			if (RTCPeerConnection) (function () {
				var rtc = new RTCPeerConnection({iceServers:[]});
				if (1 || window.mozRTCPeerConnection) {      // FF [and now Chrome!] needs a channel/stream to proceed
					rtc.createDataChannel('', {reliable:false});
				}
				
				rtc.onicecandidate = function (evt) {
					// convert the candidate to SDP so we can run it through our general parser
					// see https://twitter.com/lancestout/status/525796175425720320 for details
					if (evt.candidate) grepSDP("a="+evt.candidate.candidate);
				};
				rtc.createOffer(function (offerDesc) {
					grepSDP(offerDesc.sdp);
					rtc.setLocalDescription(offerDesc);
				}, function (e) { console.warn("offer failed", e); });
				
				
				var addrs = Object.create(null);
				addrs["0.0.0.0"] = false;
				function updateDisplay(newAddr) {
					if (newAddr in addrs) return;
					else addrs[newAddr] = true;
					var displayAddrs = Object.keys(addrs).filter(function (k) { return addrs[k]; });					
					document.getElementById('local_ip').textContent = displayAddrs.join(" or perhaps ") || "n/a";
				}
				
				function grepSDP(sdp) {
					var hosts = [];
					sdp.split('\r\n').forEach(function (line) { // c.f. http://tools.ietf.org/html/rfc4566#page-39
						if (~line.indexOf("a=candidate")) {     // http://tools.ietf.org/html/rfc4566#section-5.13
							var parts = line.split(' '),        // http://tools.ietf.org/html/rfc5245#section-15.1
								addr = parts[4],
								type = parts[7];
							if (type === 'host') updateDisplay(addr);
						} else if (~line.indexOf("c=")) {       // http://tools.ietf.org/html/rfc4566#section-5.7
							var parts = line.split(' '),
								addr = parts[2];
							updateDisplay(addr);
						}
					});
				}
			})(); else {
				//document.getElementById('local_ip').innerHTML = "<code>ifconfig | grep inet | grep -v inet6 | cut -d\" \" -f2 | tail -n1</code>";
				//document.getElementById('local_ip').nextSibling.textContent = "In Chrome and Firefox your IP should display automatically, by the power of WebRTCskull.";
			}
			
		</script>
	</body>
</html>
