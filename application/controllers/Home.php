<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Home extends MY_Controller
{
    
    public function viewAdminDashboard()
    {
        $this->load->view('admin_dashboard');
    }
    public function viewPatientDashboard()
    {
        $this->load->view('patient_dashboard');
    }
    public function viewDoctorDashboard()
    {
        $this->load->view('doctor_dashboard');
    }
    public function viewPharmacyDashboard()
    {
        $this->load->view('pharmacy_dashboard');
    }
    public function logout()
	{
        $this->session->unset_userdata('name');
        $this->session->unset_userdata('url');
        $this->session->unset_userdata('type');
		$this->session->sess_destroy();
        redirect(base_url());
	}

}
