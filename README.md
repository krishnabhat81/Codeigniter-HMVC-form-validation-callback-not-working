# Codeigniter-HMVC-form-validation-callback-not-working
NOTE:

1. Create new library file into application/library/ folder named "MY_Form_validation.php".
2. Just load this library into your controller (Here i used Test_Controller.php) as below:
    $this->load->library(array('my_form_validation'));//load my library here
		$this->form_validation->run($this);//immidiatly follwoed by this line...


ENJOY...
