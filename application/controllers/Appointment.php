<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Appointment extends MY_Controller
{
    public function make_appointment()
    {
        $doctor_types=$this->Appointment_Model->get_doctor_types();
        $data=array();
        $data['doctor_types']=$doctor_types;
        $this->load->view('make_appointment',$data);
    }
    public function make_appointment_validation()
    {
        $this->form_validation->set_rules('doctor_types', 'Doctor Type', 'callback_checkDefaultType');
        $this->form_validation->set_rules('doctors', 'Doctor ', 'callback_checkDefaultDoctor');
        $this->form_validation->set_rules('time_slots', 'Time Slot', 'callback_checkDefaultTimeSlot');


        if ($this->form_validation->run()) {
            $appointment['doctor_id'] = $this->input->post('doctors');
            $appointment['time_slot_id'] = $this->input->post('time_slots');
            // $appointment['path_id'] =  $this->input->post('paths');
            

            $time_slot['status']=0;
            $this->Appointment_Model->makeAppointment($appointment,$time_slot);
            
           
            $array=array(
                'success'=> '<div class="alert alert-success">New Appointment created Successfully..</div>'
            );
           
        } else {

            $array =array(
                'error'=>true,
                'doctor_type_error'=>form_error('doctor_types'),
                'doctor_error'=>form_error('doctors'),
                'time_slot_error'=>form_error('time_slots'),
               ); 
           
        }
        echo json_encode($array);

    }
    public function getDoctors()
    {
        $doctors = array();
        $doctor_id = $this->input->post('doctor_id');
       
        if($doctor_id){
            $con['conditions'] = array('doctor_id'=>$doctor_id);
            $doctors = $this->Appointment_Model->getDoctorRows($con);
        }
        echo json_encode($doctors);
    }
    public function getTimeSlots()
    {
        $time_slot = array();
        $doctor_id = $this->input->post('doctor_id');
       
        if($doctor_id){
            $con['conditions'] = array('doctor_id'=>$doctor_id);
            $time_slot = $this->Appointment_Model->getTimeSlotRows($con);
        }
        echo json_encode($time_slot);
    }
    public function checkDefaultType($type)
    {
        if( $type==0)
        {
          $this->form_validation->set_message(
              'checkDefaultType', 'please select the doctor type'
          );
          return  false;    
        }
        else{
            return true;
        }
    }
    function checkDefaultDoctor($doctor)
    {
        if( $doctor==0)
        {
          $this->form_validation->set_message(
              'checkDefaultDoctor', 'please select the doctor'
          );
          return  false;    
        }
        else{
            return true;
        }
      
    }
    function checkDefaultTimeSlot($tslot)
    {
      
      if( $tslot==0)
      {
        $this->form_validation->set_message(
            'checkDefaultTimeSlot', 'please select the time slot'
        );
        return  false;    
      }
      else{
          return true;
      }
    }
    public function viewAppointQueue()
    {
        $appointments=$this->Appointment_Model->getPendingAppointments();
        $data=array();
        $data['appointments']=$appointments;
        $this->load->view('appointment_queue',$data);
    }
    public function acceptAppointment($appointId)
    {
        $this->Appointment_Model->acceptAppointment($appointId);
        redirect(base_url().'appointment/viewAppointQueue');
    }
    public function cancelAppointment($appointId)
    {
        $this->Appointment_Model->cancelAppointment($appointId);
        redirect(base_url().'appointment/viewAppointQueue');
    }
    public function viewConfirmedAppoint()
    {
        $appointments=$this->Appointment_Model->getConfirmedAppoint();
        $data=array();
        $data['appointments']=$appointments;
        $this->load->view('confirmed_appointments',$data);
    }
    public function managePastAppoint()
    {
        $appointments=$this->Appointment_Model->getPastAppoint();
        $data=array();
        $data['appointments']=$appointments;
        $this->load->view('manage_past_appointments',$data);
    }
    public function completeAppointment($appointId)
    {
        $this->Appointment_Model->completeAppointment($appointId);
        redirect(base_url().'appointment/managePastAppoint');
    }
    public function incompleteAppointment($appointId)
    {
        $this->Appointment_Model->incompleteAppointment($appointId);
        redirect(base_url().'appointment/managePastAppoint');
    }
    public function upcommingAppointments()
    {
        $appointments=$this->Appointment_Model->getupcommingAppointments();
        $data=array();
        $data['appointments']=$appointments;
        $this->load->view('upcomming_appointments',$data);
    }
    public function appointmentLog()
    {
        $appointments=$this->Appointment_Model->getAppointmentLog();
        $data=array();
        $data['appointments']=$appointments;
        $this->load->view('appointment_log',$data);
    }

}