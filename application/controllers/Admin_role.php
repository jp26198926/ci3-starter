<?php
defined('BASEPATH') or die("No direct script allowed!");

class Admin_role extends CI_Controller
{
	protected $module_permission = array();
	protected $prefix; //check or update app_details table in db for session_prefix field
	protected $default_error_msg = "Error: Critical Error Encountered!";
	protected $role_id;
	protected $module = "admin_role";
	protected $module_description = "Role";
	protected $page_name = "Role";
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

			$data['module_list'] = $this->adm->show_module();
			$data['permission_list'] = $this->adm->show_permission();

			$data['role_id'] = $this->role_id;
			$data['module_permission'] = $this->module_permission;
			$data['uid'] = strtoupper($this->session->userdata[$prefix . '_logged_in'][$prefix . '_uid']);
			$data['ufname'] = strtoupper($this->session->userdata[$prefix . '_logged_in'][$prefix . '_fname']);

			$this->load->view('admin_role/index', $data);
		} else {
			redirect(base_url() . 'authentication');
		}
	}

	//start role
	function search_role()
	{
		$search = $this->input->get('search');

		$result = $this->adm->show_role($search);

		if (is_array($result)) {
			return $this->populate_table_role($result);
		} else {
			return $result;
		}
	}

	function add_role()
	{
		$role_name = $this->input->post('role_name');

		if ($role_name) {

			$add = $this->adm->add_role($role_name);

			if ($add) {
				$result = $this->adm->show_role($role_name);
				return $this->populate_table_role($result);
			}
		} else {
			echo "Error: Role Name is Required!";
		}
	}

	function info_role()
	{
		$role_id = $this->input->post('id');

		if ($role_id) {
			$result = $this->adm->info_role($role_id);

			if ($result) {
				echo json_encode($result);
			} else {
				echo "Error: Unable to fetch record!";
			}
		} else {
			echo "Error: Critical error encountered!";
		}
	}

	function update_role()
	{
		$role_id = $this->input->post('id');
		$role_name = $this->input->post('role_name');

		if ($role_id && $role_name) {

			$save = $this->adm->update_role($role_id, $role_name);

			if ($save) {
				$result = $this->adm->info_role($role_id);
				return $this->populate_table_row_role($result);
			}
		} else {
			echo "Error: Role Name is Required!";
		}
	}

	function duplicate_role()
	{
		$role_id = $this->input->post('id');
		$role_name = $this->input->post('role_name');

		if ($role_id && $role_name) {

			$save = $this->adm->duplicate_role($role_id, $role_name);

			if ($save) {
				$result = $this->adm->show_role_by_id($save);
				return $this->populate_table_role($result);
			}
		} else {
			echo "Error: Role Name is Required!";
		}
	}

	private function populate_table_role($result)
	{
		foreach ($result as $key => $value) {
			$id = $value->id;
			$role_name = $value->role_name;

			if ($this->role_id != 1 && $id == 1) { //administrator
				continue;
			} else {
				echo "<tr id='tr_{$id}'>";
				echo "   <td align='center'>";

				if ($this->role_id == 1 || $this->cf->module_permission("modify", $this->module_permission)) { //if admin or have modify permission
					echo "		<button id='{$id}' class='btn_role_modify btn btn-xs btn-info fa fa-pencil' title='Modify' data-toggle='tooltip'></button>";
				}
				echo "		<button id='{$id}' class='btn_role_permission btn btn-xs btn-danger fa fa-list' title='Permission' data-toggle='tooltip'></button>";
				echo "		<button id='{$id}' class='btn_role_duplicate btn btn-xs btn-warning fa fa-copy' title='Duplicate' data-toggle='tooltip'></button>";

				echo "	 </td>";
				echo "   <td>{$role_name}</td>";
				echo "</tr>";
			}
		}
	}
	private function populate_table_row_role($value)
	{

		$id = $value->id;
		$role_name = $value->role_name;

		echo "   <td align='center'>";

		if ($this->role_id == 1 || $this->cf->module_permission("modify", $this->module_permission)) { //if admin or have modify permission
			echo "		<button id='{$id}' class='btn_role_modify btn btn-xs btn-info fa fa-pencil' title='Modify' data-toggle='tooltip'></button>";
		}
		echo "		<button id='{$id}' class='btn_role_permission btn btn-xs btn-danger fa fa-list' title='Permission' data-toggle='tooltip'></button>";
		echo "		<button id='{$id}' class='btn_role_duplicate btn btn-xs btn-warning fa fa-copy' title='Duplicate' data-toggle='tooltip'></button>";

		echo "	 </td>";
		echo "   <td>{$role_name}</td>";
	}
	//end role

	//start mod_perm
	function show_mod_perm()
	{
		$role_id = $this->input->post('role_id');

		$result = $this->adm->show_mod_perm($role_id);

		if (is_array($result)) {
			return $this->populate_table_mod_perm($result);
		} else {
			return $result;
		}
	}

	function add_mod_perm()
	{
		$role_id = $this->input->post('role_id');
		$module_id = $this->input->post('module_id');
		$permission_id = $this->input->post('permission_id');

		if ($role_id && $module_id && $permission_id) {

			try {
				$add = $this->adm->add_mod_perm($role_id, $module_id, $permission_id);
				if ($add) {
					$result = $this->adm->show_mod_perm($role_id);
					return $this->populate_table_mod_perm($result);
				}
			} catch (Exception $ex) {
				// treats the Exception 
				echo $ex->getMessage();
			}
		} else {
			echo "Error: Critical Error Encountered!";
		}
	}

	function delete_mod_perm()
	{
		$id = $this->input->post('id');

		if ($id) {

			try {
				$remove = $this->adm->delete_mod_perm($id);
				if ($remove) {
					echo "Success";
				}
			} catch (Exception $ex) {
				// treats the Exception 
				echo $ex->getMessage();
			}
		} else {
			echo "Error: Critical Error Encountered!";
		}
	}

	private function populate_table_mod_perm($result)
	{
		foreach ($result as $key => $value) {
			$id = $value->id;
			$module_name = $value->module_name;
			$permission = $value->permission;

			echo "<tr id='tr_{$id}'>";
			echo "   <td align='center'>";

			if ($this->role_id == 1 || $this->cf->module_permission("delete", $this->module_permission)) { //if admin or has delete permission
				echo "		<button id='{$id}' class='btn_mod_perm_remove btn btn-xs btn-warning fa fa-times' title='Remove' data-toggle='tooltip'></button>";
			}

			echo "	 </td>";
			echo "   <td>{$module_name}</td>";
			echo "   <td>{$permission}</td>";
			echo "</tr>";
		}
	}
	private function populate_table_row_mod_perm($value)
	{

		$id = $value->id;
		$module_name = $value->module_name;
		$permission = $value->permission;

		echo "   <td align='center'>";

		if ($this->role_id == 1 || $this->cf->module_permission("delete", $this->module_permission)) { //if admin or has delete permission
			echo "		<button id='{$id}' class='btn_mod_perm_remove btn btn-xs btn-warning fa fa-times' title='Remove' data-toggle='tooltip'></button>";
		}

		echo "	 </td>";
		echo "   <td>{$module_name}</td>";
		echo "   <td>{$permission}</td>";
	}
	//end mod_perm
}
