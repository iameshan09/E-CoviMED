<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Login_Model extends CI_Model
{
    function login($email, $password)
    {
        $que = $this->db->query("select * from user where username='" . $email . "' and password=hash_string('" . $password . "') ");
        return $que->num_rows();
    }
    function getType($email)
    {
        $this->db->select('user_type');
        $this->db->where('email', $email);
        $query = $this->db->get('tbl_user');
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }
    function passNotMatched($email, $password)
    {
        $query = $this->db->query("select user_id from user where username='" . $email . "' and password=hash_string('" . $password . "')");
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function validEmail($email)
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
    function activeAcc($email)
    {
        $this->db->select('user_id');
        $this->db->where('email', $email);
        $this->db->where('status', 1);
        $query = $this->db->get('tbl_user');
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    function updateTokan($email,$tokan)
    {

        $this->db->query("update tbl_user set password=hash_string('".$tokan."') where email='". $email ."'");
    }
    function updatepass($sstokan,$password)
    {
        $this->db->query("update tbl_user set password=hash_string('".$password."') where password=hash_string('". $sstokan ."')");
    }
}
