<?php
class Prescription_Model extends CI_model
{
    function get_patients_names() 
    { 

        if($this->session->userdata('type')=="Admin")
        {
            $this->db->select('tbl_patient.patient_id,tbl_patient.first_name,tbl_patient.last_name');    
            $this->db->join('tbl_appointment', 'tbl_patient.patient_id = tbl_appointment.patient_id');
            $this->db->where('tbl_appointment.status',"completed");
            $query=$this->db->get('tbl_patient');
            if($query->num_rows()>0)
            {
                return $query->result();
            }   
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

                    $this->db->select('tbl_patient.patient_id,tbl_patient.first_name,tbl_patient.last_name');    
                    $this->db->join('tbl_appointment', 'tbl_patient.patient_id = tbl_appointment.patient_id');
                    $this->db->where('tbl_appointment.status',"completed");
                    $this->db->where('tbl_appointment.doctor_id',$doctorId);
                    $query=$this->db->get('tbl_patient');
                    if($query->num_rows()>0)
                    {
                        return $query->result();
                    }
                }
            }
        }
		

    }
  
	function getPharmacyRows($params = array()){
        $this->db->select('tbl_pharmacy.pharmacy_id,tbl_pharmacy.pharmacy_name');
        $this->db->from('tbl_pharmacy');
        $this->db->join('tbl_patient', 'tbl_pharmacy.city = tbl_patient.city');
        
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
    function addPrescription($prescrip)
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
                $prescrip['doctor_id']= $doctorId[0]['doctor_id'];
                
                $this->db->insert('tbl_prescription',$prescrip);
            }
        }

    }
    function getPrescRequests()
    {
        
        $this->db->select('user_id');
		$this->db->where('email',$this->session->userdata('name'));
		$query = $this->db->get('tbl_user');
        if($query->num_rows()>0)
		{
            $userId=$query->result_array();
            $userId= $userId[0]['user_id'] ;
            
            $this->db->select('pharmacy_id');
            $this->db->where('user_id',$userId);
            $query2 = $this->db->get('tbl_pharmacy');
            if($query2->num_rows()>0)
            {
                $pharmacyId=$query2->result_array();
                $pharmacyId= $pharmacyId[0]['pharmacy_id'];
                
                $this->db->select('tbl_prescription.presc_id,tbl_doctor.doctor_name,tbl_prescription.date,tbl_patient.first_name,tbl_patient.last_name,tbl_patient.address,tbl_patient.city');
                $this->db->from('tbl_prescription');
                $this->db->join('tbl_patient','tbl_prescription.patient_id=tbl_patient.patient_id');
                $this->db->join('tbl_doctor','tbl_prescription.doctor_id=tbl_doctor.doctor_id');
                $this->db->where('tbl_prescription.status',0);
                $this->db->where('tbl_prescription.pharmacy_id',$pharmacyId);

                return $this->db->get()->result_array();
                
            }
        }
        
	
    }
    function getPresclog()
    {
        if($this->session->userdata('type')=="Admin")
        {
            $this->db->select('tbl_prescription.presc_id,tbl_doctor.doctor_name,tbl_prescription.date,tbl_patient.first_name,tbl_patient.last_name,tbl_prescription.description');
            $this->db->from('tbl_prescription');
            $this->db->join('tbl_patient','tbl_prescription.patient_id=tbl_patient.patient_id');
            $this->db->join('tbl_doctor','tbl_prescription.doctor_id=tbl_doctor.doctor_id');
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

                    $this->db->select('tbl_prescription.presc_id,tbl_doctor.doctor_name,tbl_prescription.date,tbl_patient.first_name,tbl_patient.last_name,tbl_prescription.description');
                    $this->db->from('tbl_prescription');
                    $this->db->join('tbl_patient','tbl_prescription.patient_id=tbl_patient.patient_id');
                    $this->db->join('tbl_doctor','tbl_prescription.doctor_id=tbl_doctor.doctor_id');
                    $this->db->where('tbl_prescription.doctor_id',$doctorId);
                    return $this->db->get()->result_array();
                }
            }    
        }
    }
}