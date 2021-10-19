<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Doctor extends CI_Controller
{
    public function doctor_registration()
    {
        $this->load->view('doctor_registration');
    }
    public function doctor_registration_validation()
    {
        $this->form_validation->set_rules('doctor_name', 'Doctor Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_isEmailExist');
        $this->form_validation->set_rules('doctor_type', 'Doctor Type', 'callback_checkDefault');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('re_password', 'Confirm Password', 'required|min_length[8]|matches[password]');


    if ($this->form_validation->run()) {
        
        $doctor['doctor_name']="Dr. ".$this->input->post('doctor_name');
        $doctor['doctor_type']=$this->input->post('doctor_type');
        
        $user['email']=$this->input->post('email');
        $user['password']=$this->input->post('password');
        $user['user_type']="Doctor";


        $this->form_validation->set_rules('email', 'Email', 'callback_isEmailSend');
        if ($this->form_validation->run())
        {
            $this->Doctor_Model->addDoctor($user,$doctor);
            $array=array( 'success'=> '<div class="alert alert-success">New Account Created..</div>');
        }
        else
        {
            $array=array('error'=>true,
                         'mail_send_error'=>'<div class="alert alert-danger">Email send failed please contact the service provider..</div>');
        }
        echo json_encode($array);
       }
        else {
            
                  $array =array(
                      'error'=>true,
                      'doctor_name_error'=>form_error('doctor_name'),
                      'email_error'=>form_error('email'),
                      'doctor_type_error'=>form_error('doctor_type'),
                      'password_error'=>form_error('password'),
                      're_password_error'=>form_error('re_password')


                     );
        echo json_encode($array); 
        }
        
    }
    public function isEmailExist($email)
    {
        $is_exist = $this->Doctor_Model->isEmailExist($email);

        if ($is_exist) {
            $this->form_validation->set_message(
                'isEmailExist',
                'Email is already exist.'
            );
            return false;
        } else {
            return true;
        }
    }
    function checkDefault()
    {
        if($this->input->post('doctor_type')=="select")
        {
            $this->form_validation->set_message(
                'checkDefault', 'please select Type of physician'
            );
            return  false;    
        }
        else{
            return true;
        }
    }
    public function viewAllDoctors()
    {
        $doctors=$this->Doctor_Model->getAlldoctors();
        $data=array();
        $data['doctors']=$doctors;
        $this->load->view('view_all_doctors',$data);
    }
    function editDoctor($doctorId)
    {
      
      $doctor=$this->Doctor_Model->getDoctor($doctorId);
      $data=array();
      $data['doctor']=$doctor;
      $this->load->view('edit_doctor',$data);
  
    }
    function editDoctorProfile()
    {
      $doctor=$this->Doctor_Model->getDoctorProfile();
      $data=array();
      $data['doctor']=$doctor;
      $this->load->view('edit_doctor',$data);
    }
    public function editDoctorValidations($doctorId)
    {
        $this->form_validation->set_rules('doctor_name', 'Doctor Name', 'required');
        $this->form_validation->set_rules('doctor_type', 'Doctor Type', 'callback_checkDefault');

        if ($this->form_validation->run()) 
        {
            $doctor['doctor_name']=$this->input->post('doctor_name');
            $doctor['doctor_type']=$this->input->post('doctor_type');
            $this->Doctor_Model->updateDoctor($doctorId,$doctor);
            $array=array('success'=>true);

        }
        else
        {
            $array =array(
                'error'=>true,
                'doctor_error'=>form_error('doctor_name'),
                'doctor_type_error'=>form_error('doctor_type')
               ); 
        }

        echo json_encode($array);
    }
    public function isEmailSend()
    {
        $receiver=$this->input->post('email');
        $subject = 'Verify email address';
        $message = 'Dear User,<br><br> Please click on the below activation link to verify your email address<br><br>
        <a href=\'http://www.localhost/echanneling/Email/confirmEmail/' . md5($receiver) . '\'>http://www.localhost/echanneling/Email/confirmEmail/' . md5($receiver) . '</a><br><br>Thanks';
        
        $is_sent= $this->Email_Model->sendEmail($receiver,$subject,$message);

        if($is_sent)
        {
            return  true;    
        }
        else
        {
            return false;
        }
    }
}