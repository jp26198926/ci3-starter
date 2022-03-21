<?php
defined('BASEPATH') or die("No direct script allowed!");

class Admin_module extends CI_Controller
{
	protected $module_permission = array();
	protected $prefix; //check or update app_details table in db for session_prefix field
	protected $default_error_msg = "Error: Critical Error Encountered!";
	protected $role_id;
	protected $module = "admin_module";
	protected $module_description = "Module";
	protected $page_name = "Module";
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
		$data['timer_countdown'] = $this->timer_countdown;

		if ($this->cf->is_allowed_module($this->module, $prefix)) {
			$data['role_id'] = $this->role_id;
			$data['module_permission'] = $this->module_permission;
			$data['uid'] = strtoupper($this->session->userdata[$prefix . '_logged_in'][$prefix . '_uid']);
			$data['ufname'] = strtoupper($this->session->userdata[$prefix . '_logged_in'][$prefix . '_fname']);
			$data['parent_list'] = $this->adm->show_parent();

			$this->load->view('admin_module/index', $data);
		} else {
			redirect(base_url() . 'authentication');
		}
	}


	//start module
	function search_module()
	{
		$search = $this->input->get('search');

		try {
			$result = $this->adm->show_module($search);
			echo json_encode($result);
		} catch (Exception $ex) {
			echo $ex->getMessage();
		}



		// if (is_array($result)) {
		// 	//return $this->populate_table_module($result);
		// } else {
		// 	return $result;
		// }
	}

	function add_module()
	{
		$module_name = $this->input->post('module_name');
		$module_description = $this->input->post('module_description');
		//$module_icon = $this->input->post('module_icon');
		//$module_parent = $this->input->post('module_parent');
		$parent_id = $this->input->post('parent_id');

		if ($module_name && $module_description && $parent_id) {

			//$add = $this->adm->add_module($module_name, $module_description, $module_icon, $module_parent, $module_parent_id);
			try {
				$add = $this->adm->add_module($module_name, $module_description, $parent_id);

				if ($add) {
					try {
						$result = $this->adm->show_module($module_name);
						echo json_encode($result);
						//return $this->populate_table_module($result);
					} catch (Exception $ex) {
						echo $ex->getMessage();
					}
				}
			} catch (Exception $ex) {
				echo $ex->getMessage();
			}
		} else {
			echo "Error: Module Name is Required!";
		}
	}

	function info_module()
	{
		$module_id = $this->input->post('id');

		if ($module_id) {
			try {
				$result = $this->adm->info_module($module_id);

				if ($result) {
					echo json_encode($result);
				} else {
					echo "Error: Unable to fetch record!";
				}
			} catch (Exception $ex) {
				echo $ex->getMessage();
			}
		} else {
			echo "Error: Critical error encountered!";
		}
	}

	function update_module()
	{
		$module_id = $this->input->post('id');
		$module_name = $this->input->post('module_name');
		$module_description = $this->input->post('module_description');
		//$module_icon = $this->input->post('module_icon');
		//$module_parent = $this->input->post('module_parent');
		$parent_id = $this->input->post('parent_id');

		if ($module_id && $module_name && $module_description) {

			//$save = $this->adm->update_module($module_id, $module_name, $module_description, $module_icon, $module_parent);
			$save = $this->adm->update_module($module_id, $module_name, $module_description, $parent_id);

			if ($save) {
				//$result = $this->adm->info_module($module_id);
				try {
					$result = $this->adm->show_module_row($module_id);
					if ($result) {
						return $this->populate_table_row_module($result);
					} else {
						echo "Error: Cannot get module information!";
					}
				} catch (Exception $ex) {
					echo $ex->getMessage();
				}
			}
		} else {
			echo "Error: Module Name is Required!";
		}
	}

	private function populate_table_module($result)
	{
		foreach ($result as $key => $value) {
			$id = $value->id;
			$module_name = $value->module_name;
			$module_description = $value->module_description;
			//$module_icon = $value->module_icon;
			//$module_parent = $value->parent_module;
			//$parent_icon = $value->parent_icon;
			$parent_name = $value->parent_name;

			echo "<tr id='tr_{$id}'>";
			echo "   <td align='center'>";

			if ($this->role_id == 1 || $this->cf->module_permission("modify", $this->module_permission)) { //if admin or have modify permission
				echo "		<button id='{$id}' class='btn_module_modify btn btn-xs btn-info fa fa-pencil' title='Modify' data-toggle='tooltip'></button>";
			}

			echo "	 </td>";
			echo "   <td>{$module_name}</td>";
			echo "   <td>{$module_description}</td>";
			//echo "   <td>{$parent_icon}</td>";
			echo "	 <td>{$parent_name}</td>";
			echo "</tr>";
		}
	}
	private function populate_table_row_module($value)
	{

		$id = $value->id;
		$module_name = $value->module_name;
		$module_description = $value->module_description;
		//$module_icon = $value->module_icon;
		//$module_parent = $value->parent_module;
		//$parent_icon = $value->parent_icon;
		$parent_name = $value->parent_name;

		echo "   <td align='center'>";

		if ($this->role_id == 1 || $this->cf->module_permission("modify", $this->module_permission)) { //if admin or have modify permission
			echo "		<button id='{$id}' class='btn_module_modify btn btn-xs btn-info fa fa-pencil' title='Modify' data-toggle='tooltip'></button>";
		}

		echo "	 </td>";
		echo "   <td>{$module_name}</td>";
		echo "   <td>{$module_description}</td>";
		//echo "   <td>{$parent_icon}</td>";
		echo "	 <td>{$parent_name}</td>";
	}
	//end module
}
