<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Order extends MY_Controller
{
  
  public function viewPendingOrder($orderId)
  {
    
      
      $order=$this->Order_Model->getPendingOrder($orderId);
      $data=array();
      $data['order']=$order;
      $this->load->view('view_pending_order',$data);
  
    
  }
  public function proceed_pending_order()
  {
    $this->form_validation->set_rules('amount', 'Amount', 'required|regex_match[/^[0-9]/]');

    if ($this->form_validation->run()) {
    
      $order['presc_id']=$this->input->post('presc_id');
      $order['customer']=$this->input->post('customer_name');
      $order['delivery_address']=$this->input->post('address');
      $order['phone']=$this->input->post('phone');
      $order['description']=$this->input->post('description');
      $order['amount']=$this->input->post('amount');

      $pharmacy=$this->Order_Model->getPharmacyDetails();

      $receiver=$this->input->post('email');
      $subject = $pharmacy['pharmacy_name']. 'Prescription Invoice';
      $message = '<br><br>'.$pharmacy['pharmacy_name'].'<br>'.$pharmacy['address'].'<br>'.$pharmacy['city'].'<br><br><br><br>'
      .$order['description'].'<br><br><br><br>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;
       &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Total Amount
       : LKR '.$order['amount'];
      
       if($this->Email_Model->sendEmail($receiver,$subject,$message))
       {
          $this->Order_Model->placeOrder($order);
          $array=array( 'success'=> '<div class="alert alert-success">New Account Created..</div>');
       }
       else
       {
        $array=array('error'=>true,
                     'mail_send_error'=>'<div class="alert alert-danger">Email send failed please contact the service provider..</div>');
       }
       echo json_encode($array);
     }
     else{
      $array =array(
        'error'=>true,
        'amount_error'=>form_error('amount'));
        
        echo json_encode($array);
     }
     
     
  }

  public function viewWaitingOrders()
  {
    
    $orders=$this->Order_Model->getWaitingOrders();
    $data=array();
    $data['orders']=$orders;
    $this->load->view('confirm_orders',$data);
  }
  public function acceptOrder($prescId)
  {
    $this->Order_Model->acceptOrder($prescId);
    redirect(base_url().'order/viewWaitingOrders');
  }
  public function cancelOrder($prescId)
  {
    $this->Order_Model->cancelOrder($prescId);
    redirect(base_url().'order/viewWaitingOrders');
  }
  public function viewAcceptedOrders()
  {
    
    $orders=$this->Order_Model->getAcceptedOrders();
    $data=array();
    $data['orders']=$orders;
    $this->load->view('view_accepted_orders',$data);
  }
  public function completeOrder($orderId)
  {
   $this->Order_Model->completeOrder($orderId);
    redirect(base_url().'order/viewAcceptedOrders');
  }
  public function patientOrderLog()
  {
    
    $orders=$this->Order_Model->getPatientOrderLog();
    $data=array();
    $data['orders']=$orders;
    $this->load->view('order_log_patient',$data);
  }
  public function pharmacyOrderLog()
  {
    
    $orders=$this->Order_Model->getPharmacyOrderLog();
    $data=array();
    $data['orders']=$orders;
    $this->load->view('order_log_pharmacy',$data);
  }
}