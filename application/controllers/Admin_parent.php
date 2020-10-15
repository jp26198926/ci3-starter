<?php
defined('BASEPATH') or die("No direct script allowed!");

class Admin_parent extends CI_Controller
{
	protected $module_permission = array();
	protected $prefix; //check or update app_details table in db for session_prefix field
	protected $default_error_msg = "Error: Critical Error Encountered!";
	protected $role_id;
	protected $module = "admin_parent";
	protected $module_description = "Parent Module";
	protected $page_name = "Parent Module";
	protected $parent_menu = "Administration";
	protected $uid = 0;
	protected $uname;
	protected $app_code;
	protected $app_name;
	protected $app_title;
	protected $app_version;
	protected $company_address;
	protected $company_contact;
	protected $timer_countdown;

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
					$this->timer_countdown = $this->session->userdata[$prefix . '_logged_in'][$prefix . '_timer_countdown'];

					$this->load->model('authentication_m', 'a');
					$this->role_id = $this->session->userdata[$this->prefix . '_logged_in'][$this->prefix . '_role'];
					$this->module_permission = $this->a->allow_permission($this->role_id, $this->module);

					$this->load->library('custom_function', NULL, 'cf');

					//load needed models for this page
					$this->load->model('administration_m', 'adm');
				}
			}
		} catch (Exception $ex) {
			redirect(base_url() . 'authentication');
		}
		//end of getting session prefix		
	}

	function index()
	{
		$prefix = $this->prefix;

		$data['prefix'] = $prefix;
		$data['app_title'] = $this->session->userdata[$prefix . '_logged_in'][$prefix . '_app_title'];
		$data['app_version'] = $this->session->userdata[$prefix . '_logged_in'][$prefix . '_app_version'];
		$data['page_name'] = $this->page_name;
		$data['parent_menu'] = $this->parent_menu;
		$data['module'] = $this->module;
		$data['module_description'] = $this->module_description;
		//$data['timer_countdown'] = $this->timer_countdown;

		if ($this->cf->is_allowed_module($this->module, $prefix)) {
			$data['role_id'] = $this->role_id;
			$data['module_permission'] = $this->module_permission;
			$data['uid'] = strtoupper($this->session->userdata[$prefix . '_logged_in'][$prefix . '_uid']);
			$data['ufname'] = strtoupper($this->session->userdata[$prefix . '_logged_in'][$prefix . '_fname']);

			$this->load->view('admin_parent/index', $data);
		} else {
			redirect(base_url() . 'authentication');
		}
	}

	//start module
	public function search_parent()
	{
		$search = $this->input->get('search');

		$result = $this->adm->show_parent($search);

		if (is_array($result)) {
			return $this->populate_table_parent($result);
		} else {
			return $result;
		}
	}

	public function add_parent()
	{
		$parent_name = $this->input->post('parent_name');
		$parent_description = $this->input->post('parent_description');
		$parent_icon = $this->input->post('parent_icon');
		$parent_order = $this->input->post('parent_order');

		if ($parent_name && $parent_description) {

			$add = $this->adm->add_parent($parent_name, $parent_description, $parent_icon, $parent_order);

			if ($add) {
				$result = $this->adm->show_parent($parent_name);
				return $this->populate_table_parent($result);
			}
		} else {
			echo "Error: Role Name is Required!";
		}
	}

	public function info_parent()
	{
		$parent_id = $this->input->post('id');

		if ($parent_id) {
			$result = $this->adm->info_parent($parent_id);

			if ($result) {
				echo json_encode($result);
			} else {
				echo "Error: Unable to fetch record!";
			}
		} else {
			echo "Error: Critical error encountered!";
		}
	}

	public function update_parent()
	{
		$parent_id = $this->input->post('id');
		$parent_name = $this->input->post('parent_name');
		$parent_description = $this->input->post('parent_description');
		$parent_icon = $this->input->post('parent_icon');
		$parent_order = $this->input->post('parent_order');

		if ($parent_id && $parent_name && $parent_description && $parent_order) {

			$save = $this->adm->update_parent($parent_id, $parent_name, $parent_description, $parent_icon, $parent_order);

			if ($save) {
				$result = $this->adm->info_parent($parent_id);
				return $this->populate_table_row_parent($result);
			}
		} else {
			echo "Error: Role Name is Required!";
		}
	}

	private function populate_table_parent($result)
	{
		foreach ($result as $key => $value) {
			$id = $value->id;
			$parent_name = $value->parent_name;
			$parent_description = $value->parent_description;
			$parent_icon = $value->parent_icon;
			$parent_order = $value->parent_order;

			echo "<tr id='tr_{$id}'>";
			echo "   <td align='center'>";

			if ($this->role_id == 1 || $this->cf->module_permission("modify", $this->module_permission)) { //if admin or have modify permission
				echo "		<button id='{$id}' class='btn_parent_modify btn btn-xs btn-info fa fa-pencil' title='Modify' data-toggle='tooltip'></button>";
			}

			echo "	 </td>";
			echo "   <td>{$parent_name}</td>";
			echo "   <td>{$parent_description}</td>";
			echo "   <td>{$parent_icon}</td>";
			echo "	 <td>{$parent_order}</td>";
			echo "</tr>";
		}
	}
	private function populate_table_row_parent($value)
	{

		$id = $value->parent_id;
		$parent_name = $value->parent_name;
		$parent_description = $value->parent_description;
		$parent_icon = $value->parent_icon;
		$parent_order = $value->parent_order;

		echo "   <td align='center'>";

		if ($this->role_id == 1 || $this->cf->module_permission("modify", $this->module_permission)) { //if admin or have modify permission
			echo "		<button id='{$id}' class='btn_parent_modify btn btn-xs btn-info fa fa-pencil' title='Modify' data-toggle='tooltip'></button>";
		}

		echo "	 </td>";
		echo "   <td>{$parent_name}</td>";
		echo "   <td>{$parent_description}</td>";
		echo "   <td>{$parent_icon}</td>";
		echo "	 <td>{$parent_order}</td>";
	}
	//end module
}
