<?php
	
	defined('BASEPATH') or die('No direct script access allowed!');

	require_once dirname(__FILE__) . '/PHPExcel/Classes/PHPExcel.php';

	class Excel extends PHPExcel{
		
		function __contruct(){
			parent::__contruct();
		}		
	}
?>