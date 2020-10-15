<?php
defined('BASEPATH') or die("No direct script allowed!");

class Admin_user extends CI_Controller
{
	protected $module_permission = array();
	protected $prefix; //check or update app_details table in db for session_prefix field
	protected $default_error_msg = "Error: Critical Error Encountered!";
	protected $role_id;
	protected $module = "admin_user";
	protected $module_description = "User Account";
	protected $page_name = "User Account";
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

			$data['role_list'] = $this->adm->show_role();

			$data['role_id'] = $this->role_id;
			$data['module_permission'] = $this->module_permission;
			$data['uid'] = strtoupper($this->session->userdata[$prefix . '_logged_in'][$prefix . '_uid']);
			$data['ufname'] = strtoupper($this->session->userdata[$prefix . '_logged_in'][$prefix . '_fname']);
			$this->load->view('admin_user/index', $data);
		} else {
			redirect(base_url() . 'authentication');
		}
	}

	//start users
	function changepass_users_global()
	{

		$id = $this->input->post('id');
		$current_password = $this->input->post('current_password');
		$password = $this->input->post('password');
		$repassword = $this->input->post('repassword');

		if ($id && $current_password && $password && $repassword) {
			if (strcmp($password, $repassword) == 0) {

				//check current password
				try {
					$result = $this->adm->info_users($id);
					if ($result && password_verify($current_password, $result->password)) {

						//start changing password
						$options = ['cost' => 12];
						$hash_pass =  password_hash($password, PASSWORD_BCRYPT, $options);

						try {
							$update = $this->adm->changepass_users($id, $hash_pass);

							if ($update) {
								echo "Password Successfully changed!";
							} else {
								echo "Error: Failed!";
							}
						} catch (Exception $ex) {
							echo $ex->getMessage();
						}
					} else {
						echo "Error: Wrong Password!";
					}
				} catch (Exception $ex) {
					echo $ex;
				}
				//end of checking current password

			} else {
				echo "Error: Password does not matched!";
			}
		} else {
			echo "Error: All fields with * are required!";
		}
	}

	function changepass_users()
	{

		$user_id = $this->input->post('id');
		$password = $this->input->post('password');
		$repassword = $this->input->post('repassword');

		if ($user_id && $password && $repassword) {
			if (strcmp($password, $repassword) == 0) {

				$options = ['cost' => 12];
				$hash_pass =  password_hash($password, PASSWORD_BCRYPT, $options);

				try {
					$update = $this->adm->changepass_users($user_id, $hash_pass);

					if ($update) {
						echo "Password Successfully changed!";
					} else {
						echo "Error: Failed!";
					}
				} catch (Exception $ex) {
					echo $ex->getMessage();
				}
			} else {
				echo "Error: Password does not matched!";
			}
		} else {
			echo "Error: All fields with * are required!";
		}
	}

	function search_users()
	{
		$search = $this->input->get('search');

		try {
			$result = $this->adm->show_users($search);
			return $this->populate_table_users($result);
		} catch (Exception $ex) {
			// treats the Exception 
			echo $ex->getMessage();
		}
	}

	function add_users()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$repassword = $this->input->post('repassword');
		$fname = $this->input->post('fname');
		$mname = $this->input->post('mname');
		$lname = $this->input->post('lname');
		$email = $this->input->post('email');
		$role_id = $this->input->post('role_id');

		if ($username && $password && $repassword && $fname && $lname && $role_id) {
			if (strcmp($password, $repassword) == 0) {

				$options = ['cost' => 12];
				$hash_pass =  password_hash($password, PASSWORD_BCRYPT, $options);

				try {
					$add = $this->adm->add_users($username, $hash_pass, $fname, $mname, $lname, $email, $role_id);

					if ($add) {
						$result = $this->adm->show_users($username);
						return $this->populate_table_users($result);
					} else {
						echo "Error: Saving New User Failed!";
					}
				} catch (Exception $ex) {
					echo $ex->getMessage();
				}
			} else {
				echo "Error: Password does not matched!";
			}
		} else {
			echo "Error: All fields with * are required!";
		}
	}

	function info_users()
	{
		$user_id = $this->input->post('id');

		if ($user_id) {

			try {
				$result = $this->adm->info_users($user_id);

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

	function update_users()
	{
		$user_id = $this->input->post('id');
		$username = $this->input->post('username');
		$fname = $this->input->post('fname');
		$mname = $this->input->post('mname');
		$lname = $this->input->post('lname');
		$email = $this->input->post('email');
		$role_id = $this->input->post('role_id');

		if ($username && $fname && $lname && $role_id) {
			if ($user_id) {
				try {
					$update = $this->adm->update_users($user_id, $username, $fname, $mname, $lname, $email, $role_id);

					if ($update) {
						$result = $this->adm->show_users_byid($user_id);
						return $this->populate_table_row_users($result);
					} else {
						echo "Error: Updating User Failed!";
					}
				} catch (Exception $ex) {
					echo $ex->getMessage();
				}
			} else {
				echo "Error: Critical Error Encountered!";
			}
		} else {
			echo "Error: All fields with * are required!";
		}
	}

	function update_users_status()
	{
		$user_id = $this->input->post('id');
		$status_id = $this->input->post('status_id');

		if ($user_id && $status_id) {
			try {
				$update = $this->adm->update_users_status($user_id, $status_id);

				if ($update) {
					$result = $this->adm->show_users_byid($user_id);
					return $this->populate_table_row_users($result);
				} else {
					echo "Error: Updating User Failed!";
				}
			} catch (Exception $ex) {
				echo $ex->getMessage();
			}
		} else {
			echo "Error: All fields with * are required!";
		}
	}


	private function populate_table_users($result)
	{
		foreach ($result as $key => $value) {
			$id = $value->id;
			$username = $value->username;
			$fullname = strtoupper($value->fullname);
			$email = $value->email;
			$role_name = $value->role_name;
			$status_id = $value->status_id;
			$status = $value->status;

			if ($status_id == 1) { //active
				echo "<tr id='tr_{$id}'>";
			} else {
				echo "<tr id='tr_{$id}' class='danger'>";
			}

			echo "   <td align='center'>";

			if ($this->role_id == 1 || $this->cf->module_permission("modify", $this->module_permission)) { //if admin or has permission
				echo "		<button id='{$id}' class='btn_change_pass btn btn-sm btn-success fa fa-refresh' title='Change Password' data-toggle='tooltip'></button>";
				echo "		<button id='{$id}' class='btn_users_modify btn btn-sm btn-info fa fa-pencil' title='Modify' data-toggle='tooltip'></button>";
			}

			if ($status_id == 1) {
				if ($this->role_id == 1 || $this->cf->module_permission("delete", $this->module_permission)) { //if admin or has permission
					echo "		<button id='{$id}' class='btn_users_deactivate btn btn-sm btn-danger fa fa-times' title='Deactivate' data-toggle='tooltip'></button>";
				}
			} else {
				if ($this->role_id == 1 || $this->cf->module_permission("activate", $this->module_permission)) { //if admin or has permission
					echo "		<button id='{$id}' class='btn_users_activate btn btn-sm btn-warning fa fa-reply' title=''Activate' data-toggle='tooltip'></button>";
				}
			}

			echo "	 </td>";
			echo "   <td>{$username}</td>";
			echo "   <td>{$fullname}</td>";
			echo "   <td>{$email}</td>";
			echo "   <td>{$role_name}</td>";
			echo "   <td>{$status}</td>";
			echo "</tr>";
		}
	}
	private function populate_table_row_users($value)
	{

		$id = $value->id;
		$username = $value->username;
		$fullname = $value->fullname;
		$email = $value->email;
		$role_name = $value->role_name;
		$status_id = $value->status_id;
		$status = $value->status;

		echo "   <td align='center'>";

		if ($this->role_id == 1 || $this->cf->module_permission("modify", $this->module_permission)) { //if admin or has permission
			echo "		<button id='{$id}' class='btn_change_pass btn btn-sm btn-success fa fa-refresh' title='Change Password' data-toggle='tooltip'></button>";
			echo "		<button id='{$id}' class='btn_users_modify btn btn-sm btn-info fa fa-pencil' title='Modify' data-toggle='tooltip'></button>";
		}

		if ($status_id == 1) {
			if ($this->role_id == 1 || $this->cf->module_permission("delete", $this->module_permission)) { //if admin or has permission
				echo "		<button id='{$id}' class='btn_users_deactivate btn btn-sm btn-danger fa fa-times' title='Deactivate' data-toggle='tooltip'></button>";
			}
		} else {
			if ($this->role_id == 1 || $this->cf->module_permission("activate", $this->module_permission)) { //if admin or has permission
				echo "		<button id='{$id}' class='btn_users_activate btn btn-sm btn-warning fa fa-reply' title=''Activate' data-toggle='tooltip'></button>";
			}
		}

		echo "	 </td>";

		echo "   <td>{$username}</td>";
		echo "   <td>{$fullname}</td>";
		echo "   <td>{$email}</td>";
		echo "   <td>{$role_name}</td>";
		echo "   <td>{$status}</td>";
	}
	//end users


}
