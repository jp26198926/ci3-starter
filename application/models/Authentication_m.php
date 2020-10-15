<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Authentication_m extends CI_Model
	{
				
		function check_user($username){
			$this->db->where('username',$username);			
			$this->db->where('status_id',1);
			$this->db->limit(1);
			
			if ($query = $this->db->get('user')){
				if ($query->num_rows() == 1){
					return $query->row();
				}else{
					return false;
				}
			}else{
				$error = $this->db->error(); 			    
				throw new Exception("Error: " . $error['message']);
			}
		}
		
		function allow_module($role_id){
			$this->db->select('m.module_name, m.module_description, m.parent_id');
			$this->db->from('admin_mod_perm mp');
			$this->db->join('admin_module m','m.id=mp.module_id','left');
			$this->db->where('mp.role_id',$role_id);
			$this->db->group_by('mp.module_id');
			$this->db->order_by('m.parent_id');			
            $this->db->order_by('m.module_description');
			
			if ($query=$this->db->get()){
				return $query->result();
			}else{
				$error = $this->db->error();
				throw new Exception("Error: " . $error['message']);
			}
		}
		
		function allow_parent($role_id){
			$this->db->select('distinct(m.parent_id), p.parent_name, p.parent_icon');
			$this->db->from('admin_mod_perm mp');
			$this->db->join('admin_module m','m.id=mp.module_id','left');
			$this->db->join('admin_parent p','p.parent_id = m.parent_id', 'left');
			$this->db->where('mp.role_id',$role_id);
			$this->db->group_by('mp.module_id');
			$this->db->order_by('p.parent_order');
			
			
			if ($query=$this->db->get()){
				return $query->result();
			}else{
				$error = $this->db->error();
				throw new Exception("Error: " . $error['message']);
			}
		}
		
		function allow_permission($role_id, $module_name){
			$this->db->select('LCASE(p.permission) as permission');
			$this->db->from('admin_mod_perm mp');
			$this->db->join('admin_permission p','p.id=mp.permission_id','left');
			$this->db->join('admin_module m','m.id=mp.module_id','left');
			$this->db->where('mp.role_id',$role_id);
			$this->db->where('m.module_name', $module_name);
			$this->db->order_by('p.permission');
								
			if ($query=$this->db->get()){
				return $query->result_array();
			}else{
				$error = $this->db->error();
				throw new Exception("Error: " . $error['message']);
			}					
		}

	}

?>