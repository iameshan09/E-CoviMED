<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pharmacy extends MY_Controller
{
  public function pharmacy_registration()
  {
    $cities=$this->Pharmacy_Model->get_cities_names();
    $this->load->view('pharmacy_registration',['cities'=>$cities]);     
  }
  public function pharmacy_registration_validation()
  {
        $this->form_validation->set_rules('pharmacy_name', 'Pharmacy Name', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('cities', 'City', 'callback_checkDefaultCity');
        $this->form_validation->set_rules('phone', 'Phone', 'required|regex_match[/^[0-9]{10}$/]|callback_isPhoneExist');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_isEmailExist');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');
        $this->form_validation->set_rules('re_password', 'Confirm Password', 'required|min_length[8]|matches[password]');


    if ($this->form_validation->run()) {
        
        $pharmacy['pharmacy_name']=$this->input->post('pharmacy_name');
        $pharmacy['address']=$this->input->post('address');
        $pharmacy['city']=$this->input->post('cities');
        $pharmacy['phone']=$this->input->post('phone');
        
        $user['email']=$this->input->post('email');
        $user['password']=$this->input->post('password');
        $user['user_type']="Pharmacy";

        $this->form_validation->set_rules('email', 'Email', 'callback_isEmailSend');
        if ($this->form_validation->run())
        {
            $this->Pharmacy_Model->addPharmacy($user,$pharmacy);
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
                      'pharmacy_name_error'=>form_error('pharmacy_name'),
                      'address_error'=>form_error('address'),
                      'city_error'=>form_error('cities'),
                      'phone_error'=>form_error('phone'),
                      'email_error'=>form_error('email'),
                      'password_error'=>form_error('password'),
                      're_password_error'=>form_error('re_password')


                     );
                     echo json_encode($array); 
        }
       
    }
    function checkDefaultCity()
    {
        $this->input->post('cities');
        if( $this->input->post('cities')=="select nearest city")
        {
            $this->form_validation->set_message(
                'checkDefaultCity', 'please select the city'
            );
            return  false;    
        }
        else{
            return true;
        }
    }
    public function isPhoneExist($phone) {
        $is_exist = $this->Pharmacy_Model->isPhoneExist($phone);
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
        $is_exist = $this->Pharmacy_Model->isEmailExist($email);

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
    public function viewAllPharmacies()
    {
        $pharmacies=$this->Pharmacy_Model->getAllPharmacies();
        $data=array();
        $data['pharmacies']=$pharmacies;
        $this->load->view('view_all_pharmacies',$data);
    }
    function editPharmacy($pharmacyId)
    {
      $cities=$this->Patient_Model->get_cities_names();
      $pharmacy=$this->Pharmacy_Model->getPharmacy($pharmacyId);
      $data=array();
      $data['pharmacy']=$pharmacy;
      $data['cities']=$cities;
      $this->load->view('edit_pharmacy',$data);
  
    }
    public function editPharmacyValidations($pharmacyId)
    {
        $this->form_validation->set_rules('pharmacy_name', 'Pharmacy Name', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('cities', 'City', 'callback_checkDefaultCity');
        $this->form_validation->set_rules('phone', 'Phone', 'required|regex_match[/^[0-9]{10}$/]|callback_isEditPhoneExist');

        if ($this->form_validation->run()) {
            
            $pharmacy['pharmacy_name']=$this->input->post('pharmacy_name');
            $pharmacy['address']=$this->input->post('address');
            $pharmacy['city']=$this->input->post('cities');
            $pharmacy['phone']=$this->input->post('phone');
    
            $this->Pharmacy_Model->updatePharmacy($pharmacyId,$pharmacy);
        

            $array=array( 'success'=> '<div class="alert alert-success">New Account Created..</div>');
        
        }
            else {
                
                    $array =array(
                        'error'=>true,
                        'pharmacy_name_error'=>form_error('pharmacy_name'),
                        'address_error'=>form_error('address'),
                        'city_error'=>form_error('cities'),
                        'phone_error'=>form_error('phone')
                        ); 
            }
            echo json_encode($array);
    }
    public function isEditPhoneExist() {
        $phone=$this->input->post('phone');
        $pharmacyId=$this->input->post('pharmacy_id');
        $is_exist = $this->Pharmacy_Model->isEditPhoneExist($pharmacyId,$phone);
    
        if ($is_exist) {
            $this->form_validation->set_message(
                'isEditPhoneExist', 'Phone Number already exist.'
            );    
            return false;
        } else {
            return true;
        }
    }
    public function editPharmacyProfile()
    {   $cities=$this->Patient_Model->get_cities_names();
        $pharmacy=$this->Pharmacy_Model->getPharmacyProfile();
        $data=array();
        $data['pharmacy']=$pharmacy;
        $data['cities']=$cities;
        $this->load->view('edit_pharmacy',$data);
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