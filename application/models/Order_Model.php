<?php
class Order_Model extends CI_model
{
    
    function getWaitingOrders()
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
                
                $this->db->select('tbl_pharmacy.pharmacy_name,tbl_pharmacy.phone, tbl_order.amount,tbl_prescription.presc_id');
                $this->db->from('tbl_order');
                $this->db->join('tbl_prescription','tbl_order.presc_id=tbl_prescription.presc_id');
                $this->db->join('tbl_pharmacy','tbl_order.pharmacy_id=tbl_pharmacy.pharmacy_id');
                $this->db->where('tbl_order.status',"waiting");
                $this->db->where('tbl_prescription.patient_id',$patientId);

                return $this->db->get()->result_array();
                
            }
        }
    }
    function getPendingOrder($orderId)
	{
        $this->db->select('tbl_prescription.presc_id,tbl_prescription.date,tbl_prescription.description, tbl_patient.first_name,tbl_patient.last_name,tbl_patient.address,tbl_patient.phone,tbl_user.email,tbl_doctor.doctor_name');
        $this->db->from('tbl_prescription');
        $this->db->join('tbl_patient','tbl_prescription.patient_id=tbl_patient.patient_id');
        $this->db->join('tbl_doctor','tbl_prescription.doctor_id=tbl_doctor.doctor_id');
        $this->db->join('tbl_user','tbl_patient.user_id=tbl_user.user_id');
        $this->db->where('tbl_prescription.presc_id',$orderId);


		return $this->db->get()->row_array();

	}
    public function sendEmail($receiver,$pharmacy,$order)
    {
        $this->load->library('email');
        $from = "teanandana09@gmail.com";    //senders email address
        $subject = 'Verify email address';  //email subject

        //sending confirmEmail($receiver) function calling link to the user, inside message body
       


        //config email settings
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';
        $config['smtp_port'] = '465';
        $config['smtp_user'] = $from;
        $config['smtp_pass'] = 'nandana1234';  //sender's password
        $config['mailtype'] = 'html';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = 'TRUE';
        $config['newline'] = "\r\n";


        $this->email->initialize($config);
        //send email
        $this->email->from($from);
        $this->email->to($receiver);
        $this->email->subject($subject);
        $this->email->message($message);

        if ($this->email->send()) {
            return true;
        } else {
            echo "email send failed";
            return false;
        }
    }
    function placeOrder($order)
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
                $presc['status']=1;
                $order['pharmacy_id']=$pharmacyId[0]['pharmacy_id'];
                $this->db->insert('tbl_order',$order);
                $this->db->where('presc_id',$order['presc_id'] ); 
                $this->db->update('tbl_prescription', $presc);
            }
        }
       

    }
    function getPharmacyDetails()
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
                
                $this->db->select('pharmacy_name,address,city,phone');
                $this->db->where('pharmacy_id',$pharmacyId);
                return $this->db->get('tbl_pharmacy')->row_array();
                
            }
        }
    }
    function acceptOrder($prescId)
    {
        $order['status']="ready to deliever";
        $this->db->where('presc_id',$prescId);
        $this->db->update('tbl_order', $order);
    }
    function cancelOrder($prescId)
    {
        $order['status']="cancelled";
        $this->db->where('presc_id',$prescId);
        $this->db->update('tbl_order', $order);
    }
    function getAcceptedOrders()
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
                
                $this->db->select('order_id,date,customer,delivery_address,amount,description');
                $this->db->from('tbl_order');
                $this->db->where('status',"ready to deliever");
                $this->db->where('tbl_order.pharmacy_id',$pharmacyId);

                return $this->db->get()->result_array();
                
            }
        }
    }
    function completeOrder($orderId)
    {
        $order['status']="completed";
        $this->db->where('order_id',$orderId);
        $this->db->update('tbl_order', $order);
    }
    function getPatientOrderLog()
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
                
                $this->db->select('tbl_order.date,tbl_pharmacy.pharmacy_name,tbl_order.description, tbl_order.amount,tbl_order.status');
                $this->db->from('tbl_order');
                $this->db->join('tbl_pharmacy','tbl_order.pharmacy_id=tbl_pharmacy.pharmacy_id');
                $this->db->join('tbl_prescription','tbl_order.presc_id=tbl_prescription.presc_id');
                $condition = '(tbl_order.status="ready to deliever" or tbl_order.status = "completed")';
                $this->db->where($condition);
                $this->db->where('tbl_prescription.patient_id',$patientId);

                return $this->db->get()->result_array();
                
            }
        }
    }
    function getPharmacyOrderLog()
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
                
                $this->db->select('date,customer,delivery_address,amount,description,status');
                $this->db->from('tbl_order');
                $condition = '(tbl_order.status="ready to deliever" or tbl_order.status = "completed")';
                $this->db->where($condition);
                $this->db->where('tbl_order.pharmacy_id',$pharmacyId);

                return $this->db->get()->result_array();
                
            }
        }
    }
}