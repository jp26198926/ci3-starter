<?php
defined('BASEPATH') or die('No direct script access allowed');

class Administration_m extends CI_Model
{
	//start users
	function changepass_users($user_id, $password)
	{
		$data = array(
			'password' => $password
		);

		$this->db->where('id', $user_id);

		if ($this->db->update('user', $data)) {
			return true;
		} else {
			$error = $this->db->error();
			throw new Exception("Error: " . $error['message']);
		}
	}

	function show_users($search = '')
	{

		$this->db->select("u.id as id, u.username as username, CONCAT(u.lname,', ',u.fname,' ',u.mname) as fullname,
							  u.email as email, u.status_id as status_id,
							  r.role_name as role_name,
							  s.status as status");
		$this->db->from('user u');
		$this->db->join('admin_role r', 'r.id=u.role_id', 'left');
		$this->db->join('user_status s', 's.id=u.status_id', 'left');
		$this->db->order_by('u.username');

		if ($search) {
			$this->db->where("CONCAT_WS(' ',u.username,u.lname,u.fname,u.mname,u.email,
								 r.role_name, s.status) LIKE '%{$search}%'");
		}

		if ($query = $this->db->get()) {
			return $query->result();
		} else {
			$error = $this->db->error();
			throw new Exception("Error: " . $error['message']);
		}
	}

	function show_users_byid($id)
	{

		$this->db->select("u.id as id, u.username as username, CONCAT(u.lname,', ',u.fname,' ',u.mname) as fullname,
							  u.email as email, u.status_id as status_id,
							  r.role_name as role_name,
							  s.status as status");
		$this->db->from('user u');
		$this->db->join('admin_role r', 'r.id=u.role_id', 'left');
		$this->db->join('user_status s', 's.id=u.status_id', 'left');
		$this->db->where('u.id', $id);
		$this->db->order_by('u.username');

		if ($query = $this->db->get()) {
			return $query->row();
		} else {
			$error = $this->db->error();
			throw new Exception("Error: " . $error['message']);
		}
	}

	function add_users($username, $password, $fname, $mname, $lname, $email, $role_id)
	{
		$data = array(
			'username' => $username,
			'password' => $password,
			'fname' => $fname,
			'mname' => $mname,
			'lname' => $lname,
			'email' => $email,
			'role_id' => $role_id
		);

		if ($this->db->insert('user', $data)) {
			return true;
		} else {
			$error = $this->db->error();
			throw new Exception("Error: " . $error['message']);
		}
	}

	function info_users($user_id)
	{

		$this->db->where('id', $user_id);

		if ($query = $this->db->get('user')) {

			if ($query->num_rows() > 0) {
				return $query->row();
			} else {
				return false;
			}
		} else {
			$error = $this->db->error();
			throw new Exception("Error: " . $error['message']);
		}
	}

	function update_users($id, $username, $fname, $mname, $lname, $email, $role_id)
	{
		$data = array(
			'username' => $username,
			'fname' => $fname,
			'mname' => $mname,
			'lname' => $lname,
			'email' => $email,
			'role_id' => $role_id
		);

		$this->db->where('id', $id);

		if ($this->db->update('user', $data)) {
			return true;
		} else {
			$error = $this->db->error();
			throw new Exception("Error: " . $error['message']);
		}
	}

	function update_users_status($id, $status_id)
	{
		$data = array('status_id' => $status_id);
		$this->db->where('id', $id);

		if ($this->db->update('user', $data)) {
			return true;
		} else {
			$error = $this->db->error();
			throw new Exception("Error: " . $error['message']);
		}
	}
	//users

	//start role
	function show_role($search = '')
	{

		$this->db->select('r.id as id, r.role_name as role_name');
		$this->db->from('admin_role r');
		$this->db->order_by('r.role_name');

		if ($search) {
			$this->db->where("r.role_name LIKE '%{$search}%'");
		}

		if ($query = $this->db->get()) {
			return $query->result();
		} else {
			return "Error: " . $this->db->error();
		}
	}

	function show_role_by_id($id)
	{

		$this->db->select('r.id as id, r.role_name as role_name');
		$this->db->from('admin_role r');
		$this->db->order_by('r.role_name');

		$this->db->where("r.id", $id);

		if ($query = $this->db->get()) {
			return $query->result();
		} else {
			return "Error: " . $this->db->error();
		}
	}

	function add_role($role_name)
	{
		$data = array(
			'role_name' => $role_name
		);

		$this->db->insert('admin_role', $data);

		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	function info_role($role_id)
	{

		$this->db->where('id', $role_id);
		$query = $this->db->get('admin_role');

		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	function update_role($role_id, $role_name)
	{
		$data = array(
			'role_name' => $role_name
		);

		$this->db->where('id', $role_id);


		if ($this->db->update('admin_role', $data)) {
			return true;
		} else {
			return false;
		}
	}
	// end role

	function duplicate_role($role_id, $role_name)
	{
		$this->db->trans_start();

		$new_role = array(
			'role_name' => $role_name
		);

		$this->db->insert('admin_role', $new_role);
		$new_role_id = $this->db->insert_id();

		$sql = "INSERT INTO `admin_mod_perm`(`role_id`, `module_id`, `permission_id`) 
				SELECT {$new_role_id}, a.module_id, a.permission_id
				FROM `admin_mod_perm` a
				where a.role_id={$role_id};";

		$this->db->query($sql);

		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			// generate an error... or use the log_message() function to log your error
			$error = $this->db->error();
			throw new Exception("Error: Problem saving to database, Please contact your System Administrator!");
		} else {
			return $new_role_id;
		}
	}

	//start module
	function show_module($search = '')
	{

		//$this->db->select('m.id as id, m.module_name as module_name,
		//				   m.module_description, m.module_icon, m.parent_module,
		//				   p.parent_name, p.parent_icon');
		$this->db->select('m.id as id, m.module_name as module_name,
							   m.module_description,
							   p.parent_name, p.parent_icon');
		$this->db->from('admin_module m');
		$this->db->join('admin_parent p', 'p.parent_id = m.parent_id', 'left');
		$this->db->order_by('m.module_name');

		if ($search) {
			$this->db->where("m.module_name LIKE '%{$search}%'");
		}

		if ($query = $this->db->get()) {
			return $query->result();
		} else {
			return "Error: " . $this->db->error();
		}
	}

	function add_module($module_name, $module_description, $parent_id)
	{
		$data = array(
			'module_name' => $module_name,
			'module_description' => $module_description,
			'parent_id' => $parent_id
		);

		if ($this->db->insert('admin_module', $data)) {
			return true;
		} else {
			$error = $this->db->error();
			throw new Exception("Error: " . $error['message']);
		}
	}

	function show_module_row($module_id)
	{
		$this->db->select('m.id as id, m.module_name as module_name,
							   m.module_description,
							   p.parent_name, p.parent_icon');
		$this->db->from('admin_module m');
		$this->db->join('admin_parent p', 'p.parent_id = m.parent_id', 'left');
		$this->db->order_by('m.module_name');
		$this->db->where('m.id', $module_id);

		if ($query = $this->db->get()) {
			if ($this->db->affected_rows() > 0) {
				return $query->row();
			} else {
				return false;
			}
		} else {
			return "Error: " . $this->db->error();
		}
	}

	function info_module($module_id)
	{
		$this->db->where('id', $module_id);
		if ($query = $this->db->get('admin_module')) {
			return $query->row();
		} else {
			$error = $this->db->error();
			throw new Exception("Error: " . $error['message']);
		}
	}

	function update_module($module_id, $module_name, $module_description, $parent_id)
	{
		$data = array(
			'module_name' => $module_name,
			'module_description' => $module_description,
			'parent_id' => $parent_id
		);

		$this->db->where('id', $module_id);

		if ($this->db->update('admin_module', $data)) {
			return true;
		} else {
			$error = $this->db->error();
			throw new Exception("Error: " . $error['message']);
		}
	}
	// end module

	//start parent
	function show_parent($search = '')
	{

		$this->db->select('m.parent_id as id, m.parent_name as parent_name,
							   m.parent_description, m.parent_icon, m.parent_order');
		$this->db->from('admin_parent m');
		$this->db->order_by('m.parent_order');

		if ($search) {
			$this->db->where("m.parent_name LIKE '%{$search}%'");
		}

		if ($query = $this->db->get()) {
			return $query->result();
		} else {
			$error = $this->db->error();
			throw new Exception("Error: " . $error['message']);
		}
	}

	function add_parent($parent_name, $parent_description, $parent_icon, $parent_order)
	{
		$data = array(
			'parent_name' => $parent_name,
			'parent_description' => $parent_description,
			'parent_icon' => $parent_icon,
			'parent_order' => $parent_order
		);

		if ($this->db->insert('admin_parent', $data)) {
			return true;
		} else {
			$error = $this->db->error();
			throw new Exception("Error: " . $error['message']);
		}
	}

	function info_parent($parent_id)
	{

		$this->db->where('parent_id', $parent_id);

		if ($query = $this->db->get('admin_parent')) {
			return $query->row();
		} else {
			$error = $this->db->error();
			throw new Exception("Error: " . $error['message']);
		}
	}

	function update_parent($parent_id, $parent_name, $parent_description, $parent_icon, $parent_order)
	{
		$data = array(
			'parent_name' => $parent_name,
			'parent_description' => $parent_description,
			'parent_icon' => $parent_icon,
			'parent_order' => $parent_order,
		);

		$this->db->where('parent_id', $parent_id);

		if ($this->db->update('admin_parent', $data)) {
			return true;
		} else {
			$error = $this->db->error();
			throw new Exception("Error: " . $error['message']);
		}
	}

	//end parent

	//start permission
	function show_permission($search = '')
	{

		$this->db->select('p.id as id, p.permission as permission');
		$this->db->from('admin_permission p');
		$this->db->order_by('p.permission');

		if ($search) {
			$this->db->where("p.permission LIKE '%{$search}%'");
		}


		if ($query = $this->db->get()) {
			return $query->result();
		} else {
			return "Error: " . $this->db->error();
		}
	}

	function add_permission($permission_name)
	{
		$data = array(
			'permission' => $permission_name
		);

		$this->db->insert('admin_permission', $data);

		if ($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}

	function info_permission($permission_id)
	{

		$this->db->where('id', $permission_id);
		$query = $this->db->get('admin_permission');

		if ($query->num_rows() > 0) {
			return $query->row();
		} else {
			return false;
		}
	}

	function update_permission($permission_id, $permission_name)
	{
		$data = array(
			'permission' => $permission_name
		);

		$this->db->where('id', $permission_id);

		if ($this->db->update('admin_permission', $data)) {
			return true;
		} else {
			return false;
		}
	}
	// end permission

	//start mod_perm
	function show_mod_perm($role_id)
	{

		$this->db->select('mp.id as id, m.module_name as module_name, p.permission as permission');
		$this->db->from('admin_mod_perm mp');
		$this->db->join('admin_module m', 'm.id=mp.module_id', 'left');
		$this->db->join('admin_permission p', 'p.id=mp.permission_id', 'left');
		$this->db->order_by('m.module_name, p.permission');

		$this->db->where("mp.role_id", $role_id);


		if ($query = $this->db->get()) {
			return $query->result();
		} else {
			return "Error: " . $this->db->error();
		}
	}

	function add_mod_perm($role_id, $module_id, $permission_id)
	{
		$data = array(
			'role_id' => $role_id,
			'module_id' => $module_id,
			'permission_id' => $permission_id
		);


		if ($this->db->insert('admin_mod_perm', $data)) {
			return true;
		} else {
			$error = $this->db->error();
			throw new Exception("Error: " . $error['message']);
		}
	}

	function delete_mod_perm($id)
	{
		$this->db->where('id', $id);

		if ($this->db->delete('admin_mod_perm')) {
			return true;
		} else {
			$error = $this->db->error();
			throw new Exception("Error: " . $error['message']);
		}
	}
	//end mod_perm

}
