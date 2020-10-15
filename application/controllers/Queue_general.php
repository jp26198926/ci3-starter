<?php
	defined('BASEPATH') or die("No direct script allowed!");
	
	class Queue_general extends CI_Controller{
		protected $module_permission = array();
		protected $prefix; //check or update app_details table in db for session_prefix field
		protected $default_error_msg = "Error: Critical Error Encountered!";
		protected $role_id;
		protected $module = "queue_general";
		protected $module_description = "General Queue";		
		protected $page_name = "General Queue";
		protected $parent_menu = "Queuing";
		protected $uid = 0;
		protected $uname;
		protected $app_code;
		protected $app_name;
		protected $app_title;
		protected $app_version;
		protected $company_address;
		protected $company_contact;
		protected $timer_countdown;
		
		function __construct(){
			
			parent::__construct();			
			//date_default_timezone_set("Pacific/Port_Moresby");
			
			//get session prefix from db
			$this->load->model('app_details_m', 'ad');
			try{
				$ad = $this->ad->get_details();	
				if ($ad){
					$this->prefix = $ad->session_prefix;
					date_default_timezone_set($ad->timezone);
					
					if (!isset($this->session->userdata[$this->prefix . '_logged_in'])){
						redirect(base_url() . 'authentication');
					}else{
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
												
						//$this->load->model('model_transaction');
						//$this->load->model('model_charges');
						//$this->load->model('model_payment');
						$this->load->model('model_queue');
						
						$this->load->model('authentication_m','a');			
						$this->role_id = $this->session->userdata[$this->prefix . '_logged_in'][$this->prefix . '_role'];			
						$this->module_permission = $this->a->allow_permission($this->role_id, $this->module);
					
						$this->load->library('custom_function', NULL, 'cf');
					}
				}
			}catch(Exception $ex){
				redirect(base_url() . 'authentication');
			}	
			//end of getting session prefix			
		}
		
		
		function index(){			
			$data['prefix'] = $this->prefix;
			$data['app_title'] = $this->app_title;
			$data['app_version'] = $this->app_version;			
			$data['page_name'] = $this->page_name;
			$data['parent_menu'] = $this->parent_menu;
			$data['module'] = $this->module;
			$data['module_description'] = $this->module_description;
			$data['timer_countdown'] = $this->timer_countdown;
			
			if ($this->cf->is_allowed_module($this->module, $this->prefix)){			
				$data['role_id'] = $this->role_id;
				$data['module_permission'] = $this->module_permission;
				$data['uid'] = $this->uid;
				$data['ufname'] = $this->uname;	
				
				$this->load->view('queue_general/index',$data);				
			}else{				
				redirect(base_url() . 'authentication');			
			}
		}	
				
		//start transaction		
		//search
		public function search(){
			$mysearch = $this->input->post('mysearch');
			
			try{
				$result = $this->model_queue->general_queue();
				echo json_encode($result);
			}catch(Exception $ex){
				echo $ex->getMessage();
			}
		}
		
		
	}
