<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Prescription extends MY_Controller
{
    public function create_prescription()
    {
        $patients=$this->Prescription_Model->get_patients_names();
        $data=array();
        $data['patients']=$patients;
        $this->load->view('create_prescription',$data);
    }
    public function create_prescription_validation()
    {
        $this->form_validation->set_rules('patients', 'Patient', 'callback_checkDefaultPatient');
        $this->form_validation->set_rules('pharmacies', 'Pharmacy', 'callback_checkDefaultPharmacy');
        $this->form_validation->set_rules('description', 'Description', 'required');

    if ($this->form_validation->run()) {
        
        $prescrip['patient_id']=$this->input->post('patients');
        $prescrip['pharmacy_id']=$this->input->post('pharmacies');
        $prescrip['description']=$this->input->post('description');

        $this->Prescription_Model->addPrescription($prescrip);
        
        $array=array( 'success'=> '<div class="alert alert-success">New Prescription Created..</div>');
       
       }
        else {
            
                  $array =array(
                      'error'=>true,
                      'patient_error'=>form_error('patients'),
                      'pharmacy_error'=>form_error('pharmacies'),
                      'description_error'=>form_error('description')
                     ); 
        }
        echo json_encode($array);

    }
    public function getPharmacies(){
        $pharmacies = array();
        $patient_id = $this->input->post('patient_id');
       
        if($patient_id){
            $con['conditions'] = array('patient_id'=>$patient_id);
            $pharmacies = $this->Prescription_Model->getPharmacyRows($con);
        }
        echo json_encode($pharmacies);
    }
    function checkDefaultPatient()
    {
      
      if( $this->input->post('patients')==0)
      {
        $this->form_validation->set_message(
            'checkDefaultPatient', 'please select the patient'
        );
        return  false;    
      }
      else{
          return true;
      }
    }
    function checkDefaultPharmacy()
    {
        if( $this->input->post('pharmacies')==0)
      {
        $this->form_validation->set_message(
            'checkDefaultPharmacy', 'please select the pharmacy'
        );
        return  false;    
      }
      else{
          return true;
      }
    }
    public function viewPrescRequests()
    {
      
      $orders=$this->Prescription_Model->getPrescRequests();
      $data=array();
      $data['orders']=$orders;
      $this->load->view('presc_requests',$data);
    }
    public function viewPresclog()
    {
      
      $orders=$this->Prescription_Model->getPresclog();
      $data=array();
      $data['orders']=$orders;
      $this->load->view('prescription_log',$data);
    }
}