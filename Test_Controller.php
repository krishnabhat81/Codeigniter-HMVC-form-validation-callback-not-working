<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Test_Controller extends MX_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library(array('my_form_validation'));
		$this->form_validation->run($this);
	}

	public function change_password() {
		$data = array();
		if($this->input->post()){
			$this->form_validation->set_error_delimiters('<p>', '</p>');
			$this->form_validation->set_rules('old_password', 'Old Password', 'trim|required|xss_clean|callback_oldpassCheck');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|max_length[20]|xss_clean');
			$this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|xss_clean|matches[password]');
			
			if($this->form_validation->run() == TRUE){
				$password = $this->input->post('password');
				$user_id = $this->session->userdata('user_id');
				$salt = $this->config->item('store_salt', 'ion_auth') ? $this->ion_auth_model->salt() : FALSE;
				$passwordhash = $this->ion_auth_model->hash_password($password, $salt);
				$this->db->update('users', array('password' => $passwordhash), array('id' => $user_id));
				redirect($_SERVER["HTTP_REFERER"], 'refresh');
			}
		}
		$this->template->title("Change Password FOrm");
		$this->template->build('view/change_password', $data);
    }
	
	//This is callback function
	public function oldpassCheck($str){ 
		if($str=='test'){
			$this->form_validation->set_message('oldpassCheck', 'The %s field can not be the "test"');
			return FALSE;
		}else
		{
			return TRUE;	
		}
	}

}
/*end of Test_controller.php*/
