<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Schedule extends MY_Controller
{
    public function create_schedule()
    {
        $doctors=$this->Schedule_Model->get_doctors_names();
        $this->load->view('create_schedule',['doctors'=>$doctors]);
    }
    
    public function create_schedule_validation()
    {
        
    $this->form_validation->set_rules('doctors', 'Doctor', 'callback_checkDefault|callback_isExistingSchedule');
        $this->form_validation->set_rules('schedule_date', 'Schedule Date', 'required|callback_isValidDate');
        $this->form_validation->set_rules('start_time', 'Start Time', 'required|callback_validStartTime');
        $this->form_validation->set_rules('end_time', 'End Time', 'required|callback_isValidEndTime|callback_timedifference|callback_validEndTime');
        if ($this->form_validation->run()) {
            $schedule['doctor_id']=$this->input->post('doctors');
            $schedule['date']=$this->input->post('schedule_date');
            $schedule['start_time']=$this->input->post('start_time');
            $schedule['end_time']=$this->input->post('end_time');

            $time_slot['doctor_id']=$this->input->post('doctors');
            $time_slot['date']=$this->input->post('schedule_date');

            $start_time=$this->input->post('start_time');

            $stime=strtotime($this->input->post('start_time'));
            $etime=strtotime($this->input->post('end_time'));

            $interval=($etime-$stime)/60;
            $tscount=$interval/20;
            $tscount=intval($tscount);


            $this->Schedule_Model->addSchedule($schedule,$time_slot,$tscount,$start_time);

            $array=array( 'success'=> '<div class="alert alert-success">New schedule created..</div>');
        }else {
            $array =array('error'=>true,
                          'doctor_name_error'=>form_error('doctors'),
                          'schedule_date_error'=>form_error('schedule_date'),
                          'start_time_error'=>form_error('start_time'),
                          'end_time_error'=>form_error('end_time'),
                         ); 
        }
       echo json_encode($array);
    }
    function isExistingSchedule()
    {
        $doctorId=$this->input->post('doctors');
        $date=$this->input->post('schedule_date');
        $is_exist = $this->Schedule_Model->existingSchedule($doctorId,$date);

    if ($is_exist) {
        $this->form_validation->set_message(
            'isExistingSchedule', 'cannot create a schedule for same doctor on same date twice'
        );
        return false;
    } else {
       
        return true;    
    }
    }
    function checkDefault()
    {
        $this->input->post('doctors');
        if( $this->input->post('doctors')==0)
        {
            $this->form_validation->set_message(
                'checkDefault', 'please select the doctor'
            );
            return  false;    
        }
        else{
            return true;
        }
    }
    
    function isValidDate()
    {
        if ($this->input->post('schedule_date')< $today = date('Y-m-d'))
        {
            $this->form_validation->set_message(
                'isValidDate', 'please valid date'
            );
            return  false;   
        }
        else{
            return true;
        }
    }
    function isValidEndTime()
    {

        if($this->input->post('start_time')>=$this->input->post('end_time'))
        {
            $this->form_validation->set_message(
                'isValidEndTime', 'End Time must be greater than start time'
            );
            return  false;
        }
        else{
            return true;
        }
    }
    function timedifference()
    {
        $stime=strtotime($this->input->post('start_time'));
        $etime=strtotime($this->input->post('end_time'));

        $interval=$etime-$stime;
        $interval=$interval/60;
        
        if($interval>20)
        {
            return true;
        }
        else
        {
            $this->form_validation->set_message(
                'timedifference', 'Time difference between end & start times must be at least 20 minutes'
            );
            return  false;
        }    
    }

    function validStartTime()
    {
        $stime=new DateTime($this->input->post('start_time'));
        if(new DateTime('08:00:00')<=$stime && $stime<new DateTime('22:40:00'))
        {
            return true;
        }
        else{
            $this->form_validation->set_message(
                'validStartTime', 'start time must be in 8:00 AM to 10:20 PM'
            );
            return  false;
        }
 
    }
    function validEndTime()
    {
        $etime=new DateTime($this->input->post('end_time'));
        if(new DateTime('08:20:00')<=$etime && $etime<=new DateTime('23:00:00'))
        {
            return true;
        }
        else{
            $this->form_validation->set_message(
                'validEndTime', 'end time must be in 8:20 AM to 11:00 PM'
            );
            return  false;
        }
 
    }
    function viewFutureSchedules()
    {
        $schedules=$this->Schedule_Model->getFutureSchedules();
        $data=array();
        $data['schedules']=$schedules;
        $this->load->view('view_schedules',$data);
    }
    function deleteSchedule($scheduleId)
    {
        $is_deleted=$this->Schedule_Model->deleteSchedule($scheduleId);
        if($is_deleted)
        {
            redirect(base_url().'schedule/viewFutureSchedules');
        }
        else
        {
            $this->session->set_flashdata('message1', 'you cannot delete schedules which already got appointments !');
            redirect(base_url().'schedule/viewFutureSchedules');
        }
    
      
    }
}