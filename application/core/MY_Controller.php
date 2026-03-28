<?php
defined('BASEPATH') or exit('No direct script access allowed');
class MY_Controller extends CI_Controller{
    public function __construct()
    {
        parent::__construct();

        $admin_methods = array('make_appointment','make_appointment_validation','viewConfirmedAppoint','patient_registration','patient_registration_validation','editPatient',
                                'editPatientValidations','viewPrescRequests','viewPendingOrder','proceed_pending_order','viewWaitingOrders','acceptOrder','cancelOrder',
                               'viewAcceptedOrders','completeOrder','patientOrderLog','pharmacyOrderLog','viewPatientDashboard','viewDoctorDashboard','viewPharmacyDashboard');

        $patient_methods = array('editPatient',
                                  'editPatientValidations','make_appointment','make_appointment_validation','viewConfirmedAppoint','viewWaitingOrders','acceptOrder','cancelOrder','patientOrderLog',
                                'confirmEmail','logout','viewPatientDashboard','getDoctors','getTimeSlots');

        $pharmacy_methods=array('viewPrescRequests','viewPendingOrder','proceed_pending_order','viewAcceptedOrders','completeOrder','pharmacyOrderLog','editPharmacyProfile',
                                 'editPharmacyValidations','logout','viewPharmacyDashboard');
        
        $doctor_methods=array('viewAppointQueue','upcommingAppointments','acceptAppointment','cancelAppointment','appointmentLog','create_prescription','create_prescription_validation',
                               'viewPresclog','viewFutureSchedules','viewAllPharmacies','editDoctorProfile','editDoctorValidations','logout','viewDoctorDashboard');

        $offline_methods=array('viewLogin','login_validations','forgot_password','forget_Recorrect','resetlink','reset','updatepass','confirmEmail','patient_registration','patient_registration_validation','patient_registration2','patient_registration2_validation');

        if($this->session->userdata('type')=='Admin')
        {
            if(in_array($this->router->method, $admin_methods))
            { 
                redirect(base_url());
            }    
        }
        else if($this->session->userdata('type')=='Patient')
        {
            if(!in_array($this->router->method, $patient_methods))
            { 
                redirect(base_url());
            }    
        }
        else if($this->session->userdata('type')=='Pharmacy')
        {
            if(!in_array($this->router->method, $pharmacy_methods))
            { 
                redirect(base_url());
            }    
        }
        else if($this->session->userdata('type')=='Doctor')
        {
            if(!in_array($this->router->method, $doctor_methods))
            { 
                redirect(base_url());
            }    
        }
        else if(!$this->session->has_userdata('name'))
        {
            if(!in_array($this->router->method, $offline_methods))
            { 
                redirect(base_url());
            }    
        }

    }

}
?>