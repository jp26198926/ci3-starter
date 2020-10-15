<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_version_m extends CI_Model {
	
	function get_latest()
	{
		$this->db->order_by("id","DESC");
		$this->db->limit(1);

		if ($query = $this->db->get('app_version')){
			if($query->num_rows() > 0){
				return $query->row();
			}else{
				return false;
			}
		}else{
			$error = $this->db->error(); 			    
			throw new Exception("Error: " . $error['message']);
		}	
	}
}