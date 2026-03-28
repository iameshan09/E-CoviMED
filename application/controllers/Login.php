<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Login extends MY_Controller
{
	public function __construct()
	{   
		parent::__construct();
		if ($this->session->has_userdata('name'))
        {
            redirect(base_url().'home/'.$this->session->userdata('url'));
        }
    }	
		
    public function viewLogin()
    {
        $this->load->view('login');
    }
	public function login_validations()
    {   
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|callback_isPassNotMatched');
        if ($this->form_validation->run()==false) {
            $this->load->view('login');
		} else {
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$row = $this->Login_Model->login($email, $password);
			if ($row) {
				// $userType = $this->Login_Model->getType($email);
				// $array1 = json_decode(json_encode($userType[0]), true);

                $this->session->set_userdata('name', $email);
				$this->session->set_userdata('url', 'viewAdminDashboard');
				$this->session->set_userdata('logged_in', TRUE);
                redirect(base_url().'home/viewAdminDashboard');
              
           }
		}
	}

	public function isPassNotMatched()
	{
		
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$is_exist = $this->Login_Model->passNotMatched($email, $password);
		if ($is_exist) {
			return true;
		} else {
			$this->form_validation->set_message(
				'isPassNotMatched',
				'Invalid Password'
			);
			return false;
		}
	}
	public function forgot_password()
	{
		$this->load->view('forgot_password');
	}
	public function forget_Recorrect()
	{
		$this->load->view('Forget_Recorrect');
	}

	public function resetlink()
	{
		$this->form_validation->set_rules('email', 'Email', 'required|callback_isValidEmail');

		if ($this->form_validation->run() == false) {
			$this->load->view('forgot_password');
		} 
		else 
		{
			$receiver = $this->input->post('email');
			$tokan = rand(1000, 9999);
			$subject = 'reset Password Link';
			$this->Login_Model->updateTokan($receiver,$tokan);
			$message = "Please Click on Password Reset Link <a href='" . base_url('login/reset?tokan=') . $tokan . "'> Reset Password </a>";

			if ($this->Email_Model->sendEmail($receiver,$subject,$message)) {
				$this->session->set_flashdata('forgetpass', '<div class="alert alert-success text-center">Recorrect Password link sent to Your Email </div>');
				redirect(base_url() . 'login/forgot_password');
				return true;
			} else {
				$this->session->set_flashdata('verify', '<div class="alert alert-danger text-center">Email address is not confirmed. Please try to re-register.</div>');
				echo "email send failed";
				return false;
			}
		}
	}
	public function isValidEmail()
	{
		
		$email = $this->input->post('email');
		$is_exist = $this->Login_Model->validEmail($email);
		if ($is_exist) {
			return true;
		} else {
			$this->form_validation->set_message(
				'isValidEmail',
				'Invalid Email'
			);
			return false;
		}
	}
	public function isActiveAcc()
	{
		
		$email = $this->input->post('email');
		$is_active = $this->Login_Model->activeAcc($email);
		if ($is_active) {
			return true;
		} else {
			$this->form_validation->set_message(
				'isActiveAcc',
				'This account is not activated by the user'
			);
			return false;
		}
	}

	public function reset()
	{
		$data['tokan'] = $this->input->get('tokan');
		$_SESSION['tokan'] = $data['tokan'];
		$this->load->view('Forget_Recorrect');
	}
	public function updatepass()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules("password", "Password", 'required|min_length[8]');
		$this->form_validation->set_rules("cpassword", "Cpassword", 'required|matches[password]');
		if ($this->form_validation->run() == false) {
			$this->load->view('Forget_Recorrect');
		} else {
			$sstokan=$_SESSION['tokan'];
			$password = $this->input->post('password');
			$this->Login_Model->updatepass($sstokan,$password);
			$this->load->view('login');
		}
	}
}
