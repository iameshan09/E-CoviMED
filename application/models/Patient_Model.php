<?php
class Patient_Model extends CI_model
{
    function addPatient($user)
    {

       
         $this->db->insert('user',$user);
        return $this->db->insert_id();
        //  $patient['user_id']= $insert_id;
        //  $this->db->insert('tbl_patient',$patient);


    }
    function get_cities_names() { 
		
		$query=$this->db->get('tbl_city');
		if($query->num_rows()>0)
		{
             return $query->result();
		}

	}
    /*function getLastUserId()
    {
        //SELECT fields FROM table ORDER BY id DESC LIMIT 1;
        $this->db->select('user_id');
		$this->db->order_by('user_id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get('tbl_user')->row_array();

        if (!empty($query)) {
            return $query['user_id']+1;
        } else {
            return 1;
        }
    }*/
    public function sendEmail($receiver)
    {
        $this->load->library('email');
        $from = "teanandana09@gmail.com";    //senders email address
        $subject = 'Verify email address';  //email subject

        //sending confirmEmail($receiver) function calling link to the user, inside message body
        $message = 'Dear User,<br><br> Please click on the below activation link to verify your email address<br><br>
         <a href=\'http://www.localhost/echanneling/Patient/confirmEmail/' . md5($receiver) . '\'>http://www.localhost/echanneling/Patient/confirmEmail/' . md5($receiver) . '</a><br><br>Thanks';


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
            //for testing
            // echo "sent to: " . $receiver . "<br>";
            // echo "from: " . $from . "<br>";
            // echo "protocol: " . $config['protocol'] . "<br>";
            // echo "message: " . $message;
            return true;
        } else {
            echo "email send failed";
            return false;
        }
    }
    function verifyEmail($key)
    {
        $user = array('status' => 1);
        $this->db->where('md5(email)', $key);             // this code use for 
        return $this->db->update('tbl_user', $user);    //update status as 1 to make active user
    }
    function isPhoneExist($phone) {
		$this->db->select('user_id');
		$this->db->where('mobile_number', $phone);
		$query = $this->db->get('user');
	
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
        $query = $this->db->get('user');

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function isNicExist($nic) {
		$this->db->select('user_id');
		$this->db->where('nic', $nic);
		$query = $this->db->get('user');
	
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
    function getAllPatients()
    {
        return $this->db->get('tbl_patient')->result_array();
    }
    function getPatient()
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

                $this->db->where('patient_id',$patientId);
		        return $doctor=$this->db->get('tbl_patient')->row_array();
            }
        }
    }
    function isEditPhoneExist($patientId,$phone)
    {
        $this->db->select('patient_id');
		$this->db->where('phone', $phone);
		$query = $this->db->get('tbl_patient');
		$id= $query->result_array();
	
		if ($query->num_rows() > 0) {
			if($id[0]['patient_id']==$patientId)
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
    function isEditNicExist($patientId,$nic) {
		$this->db->select('patient_id');
		$this->db->where('nic', $nic);
		$query = $this->db->get('tbl_patient');
	
		$id= $query->result_array();
	
		if ($query->num_rows() > 0) {
			if($id[0]['patient_id']==$patientId)
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
    function updatePatient($patientId,$patient)
    {
        $this->db->where('patient_id',$patientId);
		$this->db->update('tbl_patient',$patient);
    }

    function addUserDetails($userId,$user)
    {
        $this->db->where('user_id',$userId);
		$this->db->update('user',$user);
    }

    function isUserNameExist($userName)
    {
        $this->db->select('user_id');
        $this->db->where('username', $userName);
        $query = $this->db->get('user');

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
}