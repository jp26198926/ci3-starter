<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_chat extends CI_Model {
	
	function get_last_message(){
		$this->db->select('c.*, u.fname');
		$this->db->from('chat c');
		$this->db->join('user u','u.id=c.sender_id','left');
		$this->db->limit(1);
		$this->db->order_by('c.id', 'DESC');
		
		if ($query = $this->db->get()){
			return $query->row();
		}else{
			$error = $this->db->error();
			throw new Exception("Error: " . $error['message']);
		}
	}
	
	function get_latest_message($start_date){
		
		$this->db->select('c.*, CONCAT(u.fname, " ", u.mname, " ", u.lname) as sender');
		$this->db->from('chat c');
		$this->db->join('user u','u.id=c.sender_id','left');
		$this->db->where('c.dt >=', $start_date);
		
		if ($query = $this->db->get()){
			return $query->result();
		}else{
			$error = $this->db->error();
			throw new Exception("Error: " . $error['message']);
		}
	}
	
	function send_message($msg="", $current_user){
		$data = array(
			'sender_id' => $current_user,
			'msg' => $msg
		);
		
		if ($this->db->insert('chat',$data)){
			if ($this->db->affected_rows() > 0){
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