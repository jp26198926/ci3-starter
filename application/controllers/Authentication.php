<?php
defined('BASEPATH') or die("No direct script access allowed");

class Authentication extends CI_Controller
{
	protected $default_error = "Error: Critical Error Encountered!";
	protected $app_code = "";
	protected $app_name = "";
	protected $app_title = "";
	protected $app_version = "";
	protected $company_address = "";
	protected $company_contact = "";
	protected $prefix; //check or update app_details table in db for session_prefix field
	//email config
	protected $protocol;
	protected $smtp_crypto;
	protected $smtp_host;
	protected $smtp_user;
	protected $smtp_pass;
	protected $smtp_port;
	//timer
	protected $timer_countdown;
	protected $gst_percent;



	function __construct()
	{
		parent::__construct();

		date_default_timezone_set("Pacific/Port_Moresby");

		$this->load->model('app_details_m', 'ad');
		$this->load->model('app_version_m', 'av');
		$this->load->model('authentication_m', 'a');

		try {
			$av = $this->av->get_latest();
			$ad = $this->ad->get_details();

			if ($av) {
				$this->app_version = $av->version_no;
			}

			if ($ad) {
				$this->app_code = strtoupper($ad->company_code);
				$this->app_name = $ad->company_name;
				$this->app_title = strtoupper($ad->company_code) . " - " . $ad->company_name;
				$this->company_address = $ad->company_address;
				$this->company_contact = $ad->company_contact;
				$this->prefix = $ad->session_prefix;
				$this->protocol = $ad->email_protocol;
				$this->smtp_crypto = $ad->smtp_crypto;
				$this->smtp_host = $ad->smtp_host;
				$this->smtp_user = $ad->smtp_user;
				$this->smtp_pass = $ad->smtp_pass;
				$this->smtp_port = $ad->smtp_port;
				$this->timer_countdown = $ad->timer_countdown;
				$this->gst_percent = $ad->gst_percent;
			}
		} catch (Exception $ex) {
			echo $ex;
		}
	}

	function index()
	{
		if (isset($this->session->userdata[$this->prefix . '_logged_in'])) {
			redirect(base_url());
		} else {
			$data['app_code'] = $this->app_code;
			$data['app_name'] = $this->app_name;
			$data['app_title'] = $this->app_title;
			$data['app_version'] = $this->app_version;
			$this->load->view('authentication/index', $data);
		}
	}


	function authenticate()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		if ($username && $password) {
			try {
				$result = $this->a->check_user($username);

				if ($result && password_verify($password, $result->password)) {
					$session_data = array(
						$this->prefix . '_app_code' => $this->app_code,
						$this->prefix . '_app_name' => $this->app_name,
						$this->prefix . '_app_title' => $this->app_title,
						$this->prefix . '_app_version' => $this->app_version,
						$this->prefix . '_company_address' => $this->company_address,
						$this->prefix . '_company_contact' => $this->company_contact,
						$this->prefix . '_uid' => $result->id,
						$this->prefix . '_username' => $result->username,
						$this->prefix . '_fname' => strtoupper($result->fname),
						$this->prefix . '_lname' => strtoupper($result->lname),
						$this->prefix . '_fullname' => ucwords($result->fname) . ' ' . ucwords($result->lname),
						$this->prefix . '_role' => $result->role_id,
						$this->prefix . '_modules' => $this->a->allow_module($result->role_id),
						$this->prefix . '_parents' => $this->a->allow_parent($result->role_id),
						$this->prefix . '_timer_countdown' => $this->timer_countdown,
						$this->prefix . '_gst_percent' => $this->gst_percent
					);

					$this->session->set_userdata($this->prefix . '_logged_in', $session_data);
				} else {
					echo "Error: Login Failed, try again!";
				}
			} catch (Exception $ex) {
				echo $ex;
			}
		} else {
			echo "Error: Login Failed, try again!";
		}
	}

	function logout()
	{
		$this->session->unset_userdata($this->prefix . '_logged_in');
		redirect(base_url() . 'authentication');
	}

	//forgot password ; send to email
	function forgot_password()
	{
		//Load email library already configured @ autoload.php
		//$this->load->library('email');
		//setup email config
		$config = array();
		$config['protocol'] = trim($this->protocol);
		$config['smtp_crypto'] = trim($this->smtp_crypto);
		$config['smtp_host'] = trim($this->smtp_host);
		$config['smtp_user'] = trim($this->smtp_user);
		$config['smtp_pass'] = trim($this->smtp_pass);
		$config['smtp_port'] = trim($this->smtp_port);
		$this->email->initialize($config);
		$this->email->set_newline("\r\n");

		$to_email = $this->input->post("email");

		// Remove all illegal characters from email
		$to_email = filter_var($to_email, FILTER_SANITIZE_EMAIL);

		// Validate e-mail
		if (filter_var($to_email, FILTER_VALIDATE_EMAIL)) {

			$msg = "Dear {$to_email},\n\n";
			$msg .= "Your request is being process, for fast result kindly call your System Administrator! \n\n";
			$msg .= "Thank You,";

			$this->email->from($this->smtp_user, 'Support');
			$this->email->to($to_email);
			$this->email->subject('Request Password Reset');
			$this->email->message($msg);

			if ($this->smtp_user) {
				//Send mail
				if (!$this->email->send()) {
					echo "Error: Failed to send you request, Please call System Administrator!";
				}
			} else {
				echo "Error: Failed to send you request!, Please call System Administrator!";
			}
		} else {
			echo "Error: {$to_email} is not a valid to_email address";
		}
	}
	//forgot password ; send to email

}
