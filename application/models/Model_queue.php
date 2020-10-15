<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Model_queue extends CI_Model {
	
	function update_queue($trans_id, $status_id){
		
		if (intval($status_id) == 2){
			$this->db->set('queue_caller', $this->uid);
		}else{
			$this->db->set('queue_caller', 0);
		}
		
		$this->db->set('queue_status_id', $status_id);
		$this->db->where('id', $trans_id);
		
		if ($this->db->update('transaction')){
			return true;
		}else{
			$error = $this->db->error();
			throw new Exception("Error: " . $error['message']);
		}
	}
	
	function general_queue(){
		
		$this->db->select('t.*, CONCAT(YEAR(t.date_transaction), "-", LPAD(t.id,10,"0")) as trans_no,
						  u.fname as caller, q.status
						  ');
		$this->db->from('transaction t');
		$this->db->join('queue_status q','q.queue_status_id = t.queue_status_id','left');
		$this->db->join('user u','u.id = t.queue_caller', 'left');
		
		$this->db->where('t.status_id !=', 7); // completed
		$this->db->where('t.status_id !=', 8); //paid
		$this->db->where('t.status_id >', 2);
		$this->db->order_by('t.id');
		
		if ($query = $this->db->get()){
			return $query->result();
		}else{
			$error = $this->db->error();
			throw new Exception("Error: " . $error['message']);
		}
	}
}