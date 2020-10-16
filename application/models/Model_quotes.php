<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Model_quotes extends CI_Model
{
	function get_quotes($num = 3) //number of qoutes to fetch
	{
		$sql = "SELECT quotes,author FROM quotes ORDER BY RAND() LIMIT {$num};";

		if ($query = $this->db->query($sql)) {
			if ($this->db->affected_rows() > 0) {
				//return $query->result();
				return $query->result_array();
			} else {
				return false;
			}
		} else {
			$error = $this->db->error();
			throw new Exception("Error: " . $error['message']);
		}
	}
}
