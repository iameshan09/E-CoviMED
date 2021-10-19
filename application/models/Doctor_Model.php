<?php
class Doctor_Model extends CI_model
{
    function addDoctor($user,$doctor)
    {

       
         $this->db->insert('tbl_user',$user);
         $insert_id = $this->db->insert_id();
         $doctor['user_id']= $insert_id;
         $this->db->insert('tbl_doctor',$doctor);


    }
    /*public function sendEmail($receiver)
    {
        $this->load->library('email');
        $from = "teanandana09@gmail.com";    //senders email address
        $subject = 'Verify email address';  //email subject

        //sending confirmEmail($receiver) function calling link to the user, inside message body
        $message = 'Dear User,<br><br> Please click on the below activation link to verify your email address<br><br>
         <a href=\'http://www.localhost/echanneling/Doctor/confirmEmail/' . md5($receiver) . '\'>http://www.localhost/echanneling/Doctor/confirmEmail/' . md5($receiver) . '</a><br><br>Thanks';


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
    }*/
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
    function getAlldoctors()
	{   //$this->db->select('driver_id, name, path_id');
		return $doctors=$this->db->get('tbl_doctor')->result_array();
	}
    function getDoctor($doctorId)
	{
		$this->db->where('doctor_id',$doctorId);
		return $doctor=$this->db->get('tbl_doctor')->row_array();
    }
    function getDoctorProfile()
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
                $this->db->where('doctor_id',$doctorId);
                return $doctor=$this->db->get('tbl_doctor')->row_array();
            }
        }
    }
    function updateDoctor($doctorId,$doctor)
	{
		$this->db->where('doctor_id',$doctorId);
		$this->db->update('tbl_doctor',$doctor);

    }
}