<?php
class Email_Model extends CI_model
{
    function sendEmail($receiver,$subject,$message)
    {
        $this->load->library('email');
        $from = "Ecovimed@gmail.com";    //senders email address
     
        //config email settings
        $config['protocol'] = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';
        $config['smtp_port'] = '465';
        $config['smtp_user'] = $from;
        $config['smtp_pass'] = 'ecovimed123';  //sender's password
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
            return false;
        }
    }
    function verifyEmail($key)
    {
        $user = array('status' => 1);
        $this->db->where('md5(email)', $key);             // this code use for 
        return $this->db->update('tbl_user', $user);    //update status as 1 to make active user
    }
}