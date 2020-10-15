<?php
defined('BASEPATH') or die("No direct script allowed!");

class Maintenance_settings extends CI_Controller
{
	protected $module_permission = array();
	protected $prefix; //check or update app_details table in db for session_prefix field
	protected $default_error_msg = "Error: Critical Error Encountered!";
	protected $role_id;
	protected $module = "maintenance_settings";
	protected $module_description = "Settings";
	protected $page_name = "Settings";
	protected $parent_menu = "Maintenance";
	protected $uid = 0;
	protected $uname;
	protected $app_code;
	protected $app_name;
	protected $app_title;
	protected $app_version;
	protected $company_address;
	protected $company_contact;


	function __construct()
	{

		parent::__construct();
		//date_default_timezone_set("Pacific/Port_Moresby");

		//get session prefix from db
		$this->load->model('app_details_m', 'ad');
		try {
			$ad = $this->ad->get_details();
			if ($ad) {
				$this->prefix = $ad->session_prefix;
				date_default_timezone_set($ad->timezone);

				if (!isset($this->session->userdata[$this->prefix . '_logged_in'])) {
					redirect(base_url() . 'authentication');
				} else {
					$prefix = $this->prefix;

					$this->uid = $this->session->userdata[$prefix . '_logged_in'][$prefix . '_uid'];
					$this->uname = strtoupper($this->session->userdata[$prefix . '_logged_in'][$prefix . '_fname']);
					$this->app_code = $this->session->userdata[$prefix . '_logged_in'][$prefix . '_app_code'];
					$this->app_name = $this->session->userdata[$prefix . '_logged_in'][$prefix . '_app_name'];
					$this->app_title = $this->session->userdata[$prefix . '_logged_in'][$prefix . '_app_title'];
					$this->app_version = $this->session->userdata[$prefix . '_logged_in'][$prefix . '_app_version'];
					$this->company_address = $this->session->userdata[$prefix . '_logged_in'][$prefix . '_company_address'];
					$this->company_contact = $this->session->userdata[$prefix . '_logged_in'][$prefix . '_company_contact'];

					$this->load->model('model_settings');

					$this->load->model('authentication_m', 'a');
					$this->role_id = $this->session->userdata[$this->prefix . '_logged_in'][$this->prefix . '_role'];
					$this->module_permission = $this->a->allow_permission($this->role_id, $this->module);

					$this->load->library('custom_function', NULL, 'cf');
				}
			}
		} catch (Exception $ex) {
			//echo $ex;
			redirect(base_url() . 'authentication');
		}
		//end of getting session prefix			
	}

	function index()
	{

		$data['prefix'] = $this->prefix;
		$data['app_title'] = $this->app_title;
		$data['app_version'] = $this->app_version;
		$data['page_name'] = $this->page_name;
		$data['parent_menu'] = $this->parent_menu;
		$data['module'] = $this->module;
		$data['module_description'] = $this->module_description;

		if ($this->cf->is_allowed_module($this->module, $this->prefix)) {
			$data['role_id'] = $this->role_id;
			$data['module_permission'] = $this->module_permission;
			$data['uid'] = $this->uid;
			$data['ufname'] = $this->uname;
			$data['timezone_list'] = $this->model_settings->timezone_list();
			$data['currency_list'] = $this->model_settings->currency_list();
			$data['app_details'] = $this->model_settings->app_details();

			$this->load->view('maintenance_settings/index', $data);
		} else {
			redirect(base_url() . 'authentication');
		}
	}

	function save()
	{
		$company_code = $this->input->post("company_code");
		$company_name = $this->input->post("company_name");
		$company_address = $this->input->post("company_address");
		$company_contact = $this->input->post("company_contact");
		$contact_person = $this->input->post("contact_person");

		$smtp_crypto = strtolower($this->input->post("smtp_crypt"));
		$smtp_host = $this->input->post("smtp_host");
		$smtp_user = $this->input->post("smtp_user");
		$smtp_pass = $this->input->post("smtp_pass");
		$smtp_port = $this->input->post("smtp_port");

		$timezone_id = intval($this->input->post("timezone_id"));
		$currency_id = intval($this->input->post("currency_id"));
		$gst_percent = $this->input->post("gst_percent");
		$countdown_timer = $this->input->post("countdown_timer");

		if ($company_code && $company_name) {
			try {
				$save = $this->model_settings->save(
					$company_code,
					$company_name,
					$company_address,
					$company_contact,
					$contact_person,
					$smtp_crypto,
					$smtp_host,
					$smtp_user,
					$smtp_pass,
					$smtp_port,
					$timezone_id,
					$currency_id,
					$gst_percent,
					$countdown_timer,
					$this->uid
				);

				if ($save) {
					echo "Successfully Saved!";
				} else {
					echo "Error: Problem saving the changes, please try again!";
				}
			} catch (Exception $ex) {
				echo $ex->getMessage();
			}
		} else {
			echo "Error: Fields with red asterisk are required!";
		}
	}
}
