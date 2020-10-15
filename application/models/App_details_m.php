<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App_details_m extends CI_Model {
	
	function get_details()
	{
		$this->db->select("d.*, z.zone as timezone");
		$this->db->from("app_details d");
		$this->db->join("app_timezone z", "z.id=d.timezone_id", "left");
		$this->db->order_by("d.id","DESC");
		$this->db->limit(1);

		if ($query = $this->db->get('app_details')){
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