<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Patient extends My_Controller
{
    public function patient_registration()
    {    
        //$cities=$this->Patient_Model->get_cities_names();
        $this->load->view('patient_registration');       
    }
    public function patient_registration_validation()
    {
        $this->form_validation->set_rules('user_name', 'User Name', 'required|callback_isUserNameExist');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_isEmailExist');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('re_password', 'Confirm Password', 'required|min_length[8]|matches[password]');


    if ($this->form_validation->run()) {
        
        $user['username']=$this->input->post('user_name');
        $user['email']=$this->input->post('email');
        $user['password']=$this->input->post('password');

        $this->form_validation->set_rules('email', 'Email', 'callback_isEmailSend');
        if ($this->form_validation->run())
        {
            $_id=$this->Patient_Model->addPatient($user);
            $array=array( 'success'=>true, '_id'=>$_id);
       
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
                      'user_name_error'=>form_error('user_name'),
                      'email_error'=>form_error('email'),
                      'password_error'=>form_error('password'),
                      're_password_error'=>form_error('re_password')


                     );
        echo json_encode($array); 
        }
       
       
    }

    public function patient_registration2($userId)
    {    
       $user['user_id']=$userId;
        $this->load->view('patient_registration2',$user);       
    }

    public function patient_registration2_validation($userId)
    {
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('cities', 'City', 'callback_checkDefaultCity');
        $this->form_validation->set_rules('phone', 'Phone', 'required|regex_match[/^[0-9]{10}$/]|callback_isPhoneExist');
        $this->form_validation->set_rules('age', 'Age', 'required|regex_match[/^[1-9][0-9]*$/]');
        $this->form_validation->set_rules('NIC', 'NIC', 'required|callback_isNicExist|callback_nicRegex');
        $this->form_validation->set_rules('gender', 'Gender', 'callback_checkDefault');


    if ($this->form_validation->run()) {
        
        $user['first_name']=$this->input->post('first_name');
        $user['last_name']=$this->input->post('last_name');
        $user['address']=$this->input->post('address');
        $user['district']=$this->input->post('cities');
        $user['mobile_number']=$this->input->post('phone');
        $user['age']=$this->input->post('age');
        $user['nic']=$this->input->post('NIC');
        $user['gender']=$this->input->post('gender');

     
        $this->Patient_Model->addUserDetails($userId,$user);
        $array=array( 'success'=> '<div class="alert alert-success">New Account Created..</div>');
    }

    else {
            
                  $array =array(
                      'error'=>true,
                      'first_name_error'=>form_error('first_name'),
                      'last_name_error'=>form_error('last_name'),
                      'address_error'=>form_error('address'),
                      'city_error'=>form_error('cities'),
                      'phone_error'=>form_error('phone'),
                      'age_error'=>form_error('age'),
                      'NIC_error'=>form_error('NIC'),
                      'gender_error'=>form_error('gender'),
                     );
        
    }
    echo json_encode($array); 
       
    }
    
    public function isUserNameExist($userName) {
        $is_exist = $this->Patient_Model->isUserNameExist($userName);
        if ($is_exist) {
            $this->form_validation->set_message(
                'isUserNameExist', 'This user name is not available.'
            );    
            return false;
        } else {
            return true;
        }
    }


    public function isPhoneExist($phone) {
        $is_exist = $this->Patient_Model->isPhoneExist($phone);
        if ($is_exist) {
            $this->form_validation->set_message(
                'isPhoneExist', 'Phone Number already exist.'
            );    
            return false;
        } else {
            return true;
        }
    }
    public function isEmailExist($email)
    {
        $is_exist = $this->Patient_Model->isEmailExist($email);

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
    public function isNicExist($nic) {
        $is_exist = $this->Patient_Model->isNicExist($nic);
    
        if ($is_exist) {
            $this->form_validation->set_message(
                'isNicExist', 'NIC is already exist.'
            );    
            return false;
        } else {
            return true;
        }
    }
    public function nicRegex($nic) {
        
        if (preg_match('/^[0-9]{9}[v,V]{1}$/', $nic ) ) 
        {
          return TRUE;
        }
        else if(preg_match('/^[0-9]{12}$/',$nic))
        {
            return TRUE;
        }
        else 
        {
            $this->form_validation->set_message(
                'nicRegex', 'invalid id'
            );
          return FALSE;
        }
      }
      function checkDefault($gender)
    {
        if($gender=="Select")
        {
            $this->form_validation->set_message(
                'checkDefault', 'please select the gender'
            );
            return  false;    
        }
        else{
            return true;
        }
    }
    function checkDefaultCity($cities)
    {
        
        if($cities=="select nearest city")
        {
            $this->form_validation->set_message(
                'checkDefaultCity', 'please select the district'
            );
            return  false;    
        }
        else{
            return true;
        }
    }
    function viewAllPatients()
    {
        $patients=$this->Patient_Model->getAllPatients();
        $data=array();
        $data['patients']=$patients;
        $this->load->view('view_all_patients',$data);
    }
    function editPatient()
    {
      $cities=$this->Patient_Model->get_cities_names();
      $patient=$this->Patient_Model->getPatient();
      $data=array();
      $data['patient']=$patient;
      $data['cities']=$cities;
      $this->load->view('edit_patient',$data);
  
    }
    public function editPatientValidations($patientId)
    {
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('cities', 'City', 'callback_checkDefaultCity');
        $this->form_validation->set_rules('phone', 'Phone', 'required|regex_match[/^[0-9]{10}$/]|callback_isEditPhoneExist');
        $this->form_validation->set_rules('age', 'Age', 'required|regex_match[/^[0-9]{2}$/]');
        $this->form_validation->set_rules('NIC', 'NIC', 'required|callback_isEditNicExist|callback_nicRegex');
        $this->form_validation->set_rules('gender', 'Gender', 'callback_checkDefault');


    if ($this->form_validation->run()) {
        
        $patient['first_name']=$this->input->post('first_name');
        $patient['last_name']=$this->input->post('last_name');
        $patient['address']=$this->input->post('address');
        $patient['city']=$this->input->post('cities');
        $patient['phone']=$this->input->post('phone');
        $patient['age']=$this->input->post('age');
        $patient['nic']=$this->input->post('NIC');
        $patient['gender']=$this->input->post('gender');
        
        $this->Patient_Model->updatePatient($patientId,$patient);
       

        $array=array( 'success'=> '<div class="alert alert-success">New Account Created..</div>');
       
       }
        else {
            
                  $array =array(
                      'error'=>true,
                      'first_name_error'=>form_error('first_name'),
                      'last_name_error'=>form_error('last_name'),
                      'address_error'=>form_error('address'),
                      'city_error'=>form_error('cities'),
                      'phone_error'=>form_error('phone'),
                      'age_error'=>form_error('age'),
                      'NIC_error'=>form_error('NIC'),
                      'gender_error'=>form_error('gender')
                     ); 
        }
        echo json_encode($array);
    }
    public function isEditPhoneExist($phone) {

        $patientId=$this->input->post('patient_id');
        $is_exist = $this->Patient_Model->isEditPhoneExist($patientId,$phone);
    
        if ($is_exist) {
            $this->form_validation->set_message(
                'isEditPhoneExist', 'Phone Number already exist.'
            );    
            return false;
        } else {
            return true;
        }
    }
    public function isEditNicExist($nic) {

        $patientId=$this->input->post('patient_id');
        $is_exist = $this->Patient_Model->isEditNicExist($patientId,$nic);
    
        if ($is_exist) {
            $this->form_validation->set_message(
                'isEditNicExist', 'NIC is already exist.'
            );    
            return false;
        } else {
            return true;
        }
    }

    public function isEmailSend()
    {
        $receiver=$this->input->post('email');
        $subject = 'Info';
        $message =  'Your are ('.$receiver.') now already a member of E-CoviMED!' ;
        
       
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