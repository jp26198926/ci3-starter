<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance_m extends CI_Model {
	
	function trail_db_backup($performed_by, $remarks="", $status_id)
	{
		$data = array(
					  'remarks' => $remarks,
					  'performed_by' => $performed_by,
					  'status_id' => $status_id
					 );
		
		if ($this->db->insert('trail_db_backup',$data)){
			
			if($this->db->affected_rows() > 0){
				return $this->db->insert_id();
			}else{
				return false;
			}
		}else{
			$error = $this->db->error();
			throw new Exception("Error: " . $error['message']);
		}
	}
	
	function trail_db_restore($performed_by, $remarks="", $status_id)
	{
		$data = array(
					  'remarks' => $remarks,
					  'performed_by' => $performed_by,
					  'status_id' => $status_id
					 );
		
		if ($this->db->insert('trail_db_restore',$data)){
			
			if($this->db->affected_rows() > 0){
				return $this->db->insert_id();
			}else{
				return false;
			}
		}else{
			$error = $this->db->error();
			throw new Exception("Error: " . $error['message']);
		}
	}
}