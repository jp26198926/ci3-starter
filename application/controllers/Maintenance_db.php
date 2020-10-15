<?php
defined('BASEPATH') or die("No direct script allowed!");

class Maintenance_db extends CI_Controller
{
	protected $module_permission = array();
	protected $prefix; //check or update app_details table in db for session_prefix field
	protected $default_error_msg = "Error: Critical Error Encountered!";
	protected $role_id;
	protected $module = "maintenance_db";
	protected $module_description = "Database";
	protected $page_name = "Database";
	protected $parent_menu = "Maintenance";
	protected $uid = 0;
	protected $uname;
	protected $app_code;
	protected $app_name;
	protected $app_title;
	protected $app_version;
	protected $company_address;
	protected $company_contact;
	protected $timer_countdown;

	function __construct()
	{

		parent::__construct();
		//date_default_timezone_set("Pacific/Port_Moresby");

		//get session prefix from db
		$this->load->model('app_details_m', 'ad');
		try {
			$ad = $this->ad->get_details();
			if ($ad) {
				$this->prefix = $ad->session_prefix;
				date_default_timezone_set($ad->timezone);

				if (!isset($this->session->userdata[$this->prefix . '_logged_in'])) {
					redirect(base_url() . 'authentication');
				} else {
					$prefix = $this->prefix;

					$this->uid = $this->session->userdata[$prefix . '_logged_in'][$prefix . '_uid'];
					$this->uname = strtoupper($this->session->userdata[$prefix . '_logged_in'][$prefix . '_fname']);
					$this->app_title = $this->session->userdata[$prefix . '_logged_in'][$prefix . '_app_title'];
					$this->app_version = $this->session->userdata[$prefix . '_logged_in'][$prefix . '_app_version'];

					$this->load->model('maintenance_m', 'mm');

					$this->load->model('authentication_m', 'a');
					$this->role_id = $this->session->userdata[$this->prefix . '_logged_in'][$this->prefix . '_role'];
					$this->module_permission = $this->a->allow_permission($this->role_id, $this->module);

					$this->load->library('custom_function', NULL, 'cf');
				}
			}
		} catch (Exception $ex) {
			//echo $ex;
			redirect(base_url() . 'authentication');
		}
		//end of getting session prefix			
	}

	function index()
	{

		$data['prefix'] = $this->prefix;
		$data['app_title'] = $this->app_title;
		$data['app_version'] = $this->app_version;
		$data['page_name'] = $this->page_name;
		$data['parent_menu'] = $this->parent_menu;
		$data['module'] = $this->module;
		$data['module_description'] = $this->module_description;

		if ($this->cf->is_allowed_module($this->module, $this->prefix)) {
			$data['role_id'] = $this->role_id;
			$data['module_permission'] = $this->module_permission;
			$data['uid'] = $this->uid;
			$data['ufname'] = $this->uname;
			$this->load->view('maintenance_db/index', $data);
		} else {
			redirect(base_url() . 'authentication');
		}
	}

	function backup_db()
	{
		// Load the DB utility class
		$this->load->dbutil();

		$prefs = array(
			//'tables'        => array('table1', 'table2'),   // Array of tables to backup.
			'ignore'        => array('trail_db_backup', 'trail_db_restore', 'trail_db_status'),                     // List of tables to omit from the backup
			'format'        => 'sql',                       // gzip, zip, txt
			//'filename'      => 'backup' . date('YmdHis') . '.sql',              // File name - NEEDED ONLY WITH ZIP FILES
			'add_drop'      => TRUE,                        // Whether to add DROP TABLE statements to backup file
			'add_insert'    => TRUE,                        // Whether to add INSERT data to backup file
			'newline'       => "\n"                         // Newline character used in backup file
		);

		// Backup your entire database and assign it to a variable
		$backup = $this->dbutil->backup($prefs);
		$filename = 'backup' . date('YmdHi') . '.sql';

		// Load the file helper and write the file to your server
		//$this->load->helper('file');
		//write_file('/db/' . $filename, $backup);

		// Load the download helper and send the file to your desktop
		$this->load->helper('download');

		//log initial attempt
		try {
			$uid = $this->uid;
			$save_log = $this->mm->trail_db_backup($uid, "", 1);

			if ($save_log) {
				force_download($filename, $backup);
			} else {
				echo "Error: Error Saving Log, Please try again!";
			}
		} catch (Exception $ex) {
			echo $ex;
		}
	}

	public function restore_db()
	{
		if ($_FILES["file_restore"]["error"] > 0) {
			echo "Error: " . $_FILES["file_restore"]["error"];
		} elseif ($_FILES["file_restore"]["type"] !== "application/octet-stream") {
			echo "Error: File must be a sql file (*.sql)";
		} else {

			$filename = $_FILES['file_restore']['name'];
			//log initial attempt
			try {
				$uid = $this->uid;
				$save_log = $this->mm->trail_db_restore($uid, $filename, 1);

				if ($save_log) {
					//start executing the restore command
					$lines = file($_FILES['file_restore']['tmp_name']);
					$statement = '';
					foreach ($lines as $line) {
						$statement .= $line;

						if (substr(trim($line), -1) === ';') {
							$this->db->simple_query($statement);
							$statement = '';
						}
					}

					//log completed attempt
					try {
						$uid = $this->uid;
						$save_log = $this->mm->trail_db_restore($uid, $filename, 2);

						if (!$save_log) {
							echo "Error: Error Saving Log, Please try again!";
						}
					} catch (Exception $ex) {
						echo $ex;
					}
				} else {
					echo "Error: Error Saving Log, Please try again!";
				}
			} catch (Exception $ex) {
				echo $ex;
			}
		}
	}
}
