<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Email extends MY_Controller
{
    function confirmEmail($hashcode)
    {

        if ($this->Email_Model->verifyEmail($hashcode)) {
            $this->session->set_flashdata('verify', '<div class="alert alert-success text-center">Email address is confirmed. Please login to the system</div>');
            redirect(base_url());
        } else {
            $this->session->set_flashdata('verify', '<div class="alert alert-danger text-center">Email address is not confirmed. Please try to re-register.</div>');
            redirect(base_url());
        }
    }
}