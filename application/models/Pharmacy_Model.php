<?php
class Pharmacy_Model extends CI_model
{
    function addPharmacy($user,$pharmacy)
    {

       
         $this->db->insert('tbl_user',$user);
         $insert_id = $this->db->insert_id();
         $pharmacy['user_id']= $insert_id;
         $this->db->insert('tbl_pharmacy',$pharmacy);


    }
    function get_cities_names()
    {
        $query=$this->db->get('tbl_city');
		if($query->num_rows()>0)
		{
             return $query->result();
		}
    }
    function isPhoneExist($phone) {
		$this->db->select('pharmacy_id');
		$this->db->where('phone', $phone);
		$query = $this->db->get('tbl_pharmacy');
	
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
    function isEmailExist($email)
    {
        $this->db->select('user_id');
        $this->db->where('email', $email);
        $query = $this->db->get('tbl_user');

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function getAllPharmacies()
    {
        return $this->db->get('tbl_pharmacy')->result_array();
    }
    function getPharmacy($pharmacyId)
    {
        $this->db->where('pharmacy_id',$pharmacyId);
		return $this->db->get('tbl_pharmacy')->row_array();
    }
    function isEditPhoneExist($pharmacyId,$phone)
    {
        $this->db->select('pharmacy_id');
		$this->db->where('phone', $phone);
		$query = $this->db->get('tbl_pharmacy');
		$id= $query->result_array();
	
		if ($query->num_rows() > 0) {
			if($id[0]['pharmacy_id']==$pharmacyId)
			{
				return false;
			}
			else
			{
				return true;
				
			}
			
		}
		else
		{
			return false;
		}
    }
    function updatePharmacy($pharmacyId,$pharmacy)
    {
        $this->db->where('pharmacy_id',$pharmacyId);
		$this->db->update('tbl_pharmacy',$pharmacy);
    }
    function getPharmacyProfile()
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
                $pharmachyId=$query2->result_array();
                $pharmachyId= $pharmachyId[0]['pharmacy_id'];
                $this->db->where('pharmacy_id',$pharmachyId);
                return $this->db->get('tbl_pharmacy')->row_array();
            }
        }
    }
}