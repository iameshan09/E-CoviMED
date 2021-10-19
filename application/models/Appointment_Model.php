<?php
class Appointment_Model extends CI_model
{
    function get_doctor_types()
    {
        $query=$this->db->get('tbl_doctor');
		if($query->num_rows()>0)
		{
			return $query->result();
		}
    }
    function getDoctorRows($params = array()){
        $this->db->select('doctor_id,doctor_name');
        $this->db->from('tbl_doctor');
        
        //fetch data by conditions
        if(array_key_exists("conditions",$params)){
            foreach ($params['conditions'] as $key => $value) {
                if(strpos($key,'.') !== false){
                    $this->db->where($key,$value);
                }else{
                    $this->db->where($key,$value);
                }
            }
        }
        
        $query = $this->db->get();
        $result = ($query->num_rows() > 0)?$query->result_array():FALSE;

        //return fetched data
        return $result;
    }
    function getTimeSlotRows($params = array()){


        $this->db->select('time_slot_id,time_slot');
        $this->db->from('tbl_time_slot');
        $this->db->where('status',1);
        $this->db->where('is_deleted',0);
        $this->db->where('date>',date('y-m-d'));

        //fetch data by conditions
        if(array_key_exists("conditions",$params)){
            foreach ($params['conditions'] as $key => $value) {
                if(strpos($key,'.') !== false){
                    $this->db->where($key,$value);
                }else{
                    $this->db->where($key,$value);
                }
            }
        }
        
        $query = $this->db->get();
        $result = ($query->num_rows() > 0)?$query->result_array():FALSE;

        //return fetched data
        return $result;
    }
    function makeAppointment($appointment,$time_slot)
    {
        $this->db->select('date');
		$this->db->where('time_slot_id', $appointment['time_slot_id']);
		$query = $this->db->get('tbl_time_slot');
        if($query->num_rows()>0)
        {
            $date=$query->result_array();
            $appointment['date']= $date[0]['date'] ;
            
            $this->db->select('user_id');
            $this->db->where('email',$this->session->userdata('name'));
            $query2 = $this->db->get('tbl_user');
            if($query2->num_rows()>0)
            {
                $userId=$query2->result_array();
                $userId= $userId[0]['user_id'] ;

                $this->db->select('patient_id');
                $this->db->where('user_id',$userId);
                $query3 = $this->db->get('tbl_patient');
                
                if($query3->num_rows()>0)
                {
                   
                    $patientId=$query3->result_array();
                    $appointment['patient_id']= $patientId[0]['patient_id'];
                
                    $this->db->insert('tbl_appointment',$appointment);
                    $this->db->where('time_slot_id', $appointment['time_slot_id']); 
                    $this->db->update('tbl_time_slot', $time_slot);
                }
            }
        }
    }
    function getPendingAppointments()
    {
        if($this->session->userdata('type')=="Admin")
        {
            $this->db->select('tbl_appointment.appoint_id,tbl_doctor.doctor_name,tbl_time_slot.time_slot');
            $this->db->from('tbl_appointment');
            $this->db->join('tbl_doctor','tbl_doctor.doctor_id=tbl_appointment.doctor_id');
            $this->db->join('tbl_time_slot','tbl_time_slot.time_slot_id=tbl_appointment.time_slot_id');
            $this->db->where('tbl_appointment.status',"pending");
            $this->db->where('tbl_appointment.date>',date('y-m-d'));


            return $this->db->get()->result_array();
        }
        else
        {
            $this->db->select('user_id');
            $this->db->where('email',$this->session->userdata('name'));
            $query = $this->db->get('tbl_user');
            if($query->num_rows()>0)
            {
                $userId=$query->result_array();
                $userId= $userId[0]['user_id'] ;
                
                $this->db->select('doctor_id');
                $this->db->where('user_id',$userId);
                $query2 = $this->db->get('tbl_doctor');
                if($query2->num_rows()>0)
                {
                    $doctorId=$query2->result_array();
                    $doctorId= $doctorId[0]['doctor_id'];

                    $this->db->select('tbl_appointment.appoint_id,tbl_doctor.doctor_name,tbl_time_slot.time_slot');
                    $this->db->from('tbl_appointment');
                    $this->db->join('tbl_doctor','tbl_doctor.doctor_id=tbl_appointment.doctor_id');
                    $this->db->join('tbl_time_slot','tbl_time_slot.time_slot_id=tbl_appointment.time_slot_id');
                    $this->db->where('tbl_appointment.status',"pending");
                    $this->db->where('tbl_appointment.date>',date('y-m-d'));
                    $this->db->where('tbl_appointment.doctor_id',$doctorId);
                    
                    return $this->db->get()->result_array();
                }
            }    
        }
    }
    function acceptAppointment($appointId)
    {
        $appoint['status']="accepted";
        $this->db->where('appoint_id',$appointId);
        $this->db->update('tbl_appointment', $appoint);
    }
    function cancelAppointment($appointId)
    {
        $appoint['status']="declined";
        $this->db->where('appoint_id',$appointId);
        $this->db->update('tbl_appointment', $appoint);
    }
    function getConfirmedAppoint()
    {
        $this->db->select('user_id');
        $this->db->where('email',$this->session->userdata('name'));
        $query = $this->db->get('tbl_user');
        if($query->num_rows()>0)
        {
            $userId=$query->result_array();
            $userId= $userId[0]['user_id'] ;
            
            $this->db->select('patient_id');
            $this->db->where('user_id',$userId);
            $query2 = $this->db->get('tbl_patient');
            if($query2->num_rows()>0)
            {
                $patientId=$query2->result_array();
                $patientId= $patientId[0]['patient_id'];
                
                $this->db->select('tbl_appointment.appoint_id,tbl_time_slot.time_slot,tbl_doctor.doctor_name');
                $this->db->from('tbl_appointment');
                $this->db->join('tbl_doctor','tbl_doctor.doctor_id=tbl_appointment.doctor_id');
                $this->db->join('tbl_time_slot','tbl_time_slot.time_slot_id=tbl_appointment.time_slot_id');
                $this->db->where('tbl_appointment.status',"accepted");
                $this->db->where('tbl_appointment.date>',date('y-m-d'));
                $this->db->where('tbl_appointment.patient_id',$patientId);

                return $this->db->get()->result_array();
            }
        }        
    }
    function getPastAppoint()
    {
        $this->db->select('tbl_appointment.appoint_id,tbl_patient.first_name,tbl_patient.last_name,tbl_doctor.doctor_name,tbl_time_slot.time_slot');
        $this->db->from('tbl_appointment');
        $this->db->join('tbl_patient','tbl_patient.patient_id=tbl_appointment.patient_id');
        $this->db->join('tbl_doctor','tbl_doctor.doctor_id=tbl_appointment.doctor_id');
        $this->db->join('tbl_time_slot','tbl_time_slot.time_slot_id=tbl_appointment.time_slot_id');
        $condition = '(tbl_appointment.status="accepted" or tbl_appointment.status = "pending")';
        $this->db->where($condition);
        $this->db->where('tbl_appointment.date<',date('y-m-d'));
        return $this->db->get()->result_array();
    }
    function completeAppointment($appointId)
    {
        $appoint['status']="completed";
        $this->db->where('appoint_id',$appointId);
        $this->db->update('tbl_appointment', $appoint);
    }
    function incompleteAppointment($appointId)
    {
        $appoint['status']="incomplete";
        $this->db->where('appoint_id',$appointId);
        $this->db->update('tbl_appointment', $appoint);
    }
    function getupcommingAppointments()
    {
        if($this->session->userdata('type')=="Admin")
        {
            $this->db->select('tbl_appointment.appoint_id,tbl_patient.first_name,tbl_patient.last_name,tbl_doctor.doctor_name,tbl_time_slot.time_slot');
            $this->db->from('tbl_appointment');
            $this->db->join('tbl_patient','tbl_patient.patient_id=tbl_appointment.patient_id');
            $this->db->join('tbl_doctor','tbl_doctor.doctor_id=tbl_appointment.doctor_id');
            $this->db->join('tbl_time_slot','tbl_time_slot.time_slot_id=tbl_appointment.time_slot_id');
            $this->db->where('tbl_appointment.status',"accepted");
            $this->db->where('tbl_appointment.date>',date('y-m-d'));
            return $this->db->get()->result_array();
        }
        else
        {
            $this->db->select('user_id');
            $this->db->where('email',$this->session->userdata('name'));
            $query = $this->db->get('tbl_user');
            if($query->num_rows()>0)
            {
                $userId=$query->result_array();
                $userId= $userId[0]['user_id'] ;
                
                $this->db->select('doctor_id');
                $this->db->where('user_id',$userId);
                $query2 = $this->db->get('tbl_doctor');
                if($query2->num_rows()>0)
                {
                    $doctorId=$query2->result_array();
                    $doctorId= $doctorId[0]['doctor_id'];

                    $this->db->select('tbl_appointment.appoint_id,tbl_patient.first_name,tbl_patient.last_name,tbl_doctor.doctor_name,tbl_time_slot.time_slot');
                    $this->db->from('tbl_appointment');
                    $this->db->join('tbl_patient','tbl_patient.patient_id=tbl_appointment.patient_id');
                    $this->db->join('tbl_doctor','tbl_doctor.doctor_id=tbl_appointment.doctor_id');
                    $this->db->join('tbl_time_slot','tbl_time_slot.time_slot_id=tbl_appointment.time_slot_id');
                    $this->db->where('tbl_appointment.status',"accepted");
                    $this->db->where('tbl_appointment.date>',date('y-m-d'));
                    $this->db->where('tbl_appointment.doctor_id',$doctorId);
                    return $this->db->get()->result_array();
                }
            }    
        }
    }
    function getAppointmentLog()
    {
        if($this->session->userdata('type')=="Admin")
        {
            $this->db->select('tbl_appointment.appoint_id,tbl_patient.first_name,tbl_patient.last_name,tbl_doctor.doctor_name,tbl_appointment.date,tbl_appointment.status');
            $this->db->from('tbl_appointment');
            $this->db->join('tbl_patient','tbl_patient.patient_id=tbl_appointment.patient_id');
            $this->db->join('tbl_doctor','tbl_doctor.doctor_id=tbl_appointment.doctor_id');
            $condition = '(tbl_appointment.status="completed" or tbl_appointment.status = "incomplete")';
            $this->db->where($condition);
            return $this->db->get()->result_array();
        }
        else
        {
            $this->db->select('user_id');
            $this->db->where('email',$this->session->userdata('name'));
            $query = $this->db->get('tbl_user');
            if($query->num_rows()>0)
            {
                $userId=$query->result_array();
                $userId= $userId[0]['user_id'] ;
                
                $this->db->select('doctor_id');
                $this->db->where('user_id',$userId);
                $query2 = $this->db->get('tbl_doctor');
                if($query2->num_rows()>0)
                {
                    $doctorId=$query2->result_array();
                    $doctorId= $doctorId[0]['doctor_id'];

                    $this->db->select('tbl_appointment.appoint_id,tbl_patient.first_name,tbl_patient.last_name,tbl_doctor.doctor_name,tbl_appointment.date,tbl_appointment.status');
                    $this->db->from('tbl_appointment');
                    $this->db->join('tbl_patient','tbl_patient.patient_id=tbl_appointment.patient_id');
                    $this->db->join('tbl_doctor','tbl_doctor.doctor_id=tbl_appointment.doctor_id');
                    $condition = '(tbl_appointment.status="completed" or tbl_appointment.status = "incomplete")';
                    $this->db->where($condition);
                    $this->db->where('tbl_appointment.doctor_id',$doctorId);
                    return $this->db->get()->result_array();
                }
            }    
        }

    }
    

}