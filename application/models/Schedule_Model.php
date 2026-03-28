<?php
class Schedule_Model extends CI_model
{
    function get_doctors_names()
    {
        $query=$this->db->get('tbl_doctor');
		if($query->num_rows()>0)
		{
			return $query->result();
		}
    }
    function addSchedule($schedule,$time_slot,$tscount,$start_time)
    {
        $this->db->insert('tbl_schedule',$schedule);
        $insert_id = $this->db->insert_id();
        $time_slot['schedule_id']= $insert_id;

        $end_time=new DateTime($start_time);
        $start_time=new DateTime($start_time);
        for ($i=0;$i<$tscount ;$i++)
        {
            $end_time=$end_time->add(new DateInterval('PT0H20M0S')); 
            $time_slot['time_slot']= "Date: ".$time_slot['date']."\tTime: ".$start_time->format("h:i:A")."-".$end_time->format("h:i:A");
            $this->db->insert('tbl_time_slot',$time_slot);

            $start_time=$start_time->add(new DateInterval('PT0H20M0S'));
        }
    }
    function existingSchedule($doctorId,$date)
    {
       $this->db->select('doctor_id');
       $this->db->where('doctor_id', $doctorId);
       $this->db->where('date', $date);
       $this->db->where('is_deleted', 0);
       $query=$this->db->get('tbl_schedule');
       if ($query->num_rows() > 0) {
          return true;
       } else {
          return false;
       }
 
 
    }
    function getFutureSchedules()
    {

        if($this->session->userdata('type')=="Admin")
        {
            $this->db->select('tbl_schedule.schedule_id,tbl_doctor.doctor_name,tbl_schedule.date,tbl_schedule.start_time,tbl_schedule.end_time');
            $this->db->join('tbl_doctor','tbl_schedule.doctor_id=tbl_doctor.doctor_id');
            $this->db->where('tbl_schedule.date>=',date('y-m-d'));
            $this->db->where('tbl_schedule.is_deleted', 0);
    
            return $this->db->get('tbl_schedule')->result_array();
  
        }
        else
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

                    $this->db->select('tbl_schedule.schedule_id,tbl_doctor.doctor_name,tbl_schedule.date,tbl_schedule.start_time,tbl_schedule.end_time');
                    $this->db->join('tbl_doctor','tbl_schedule.doctor_id=tbl_doctor.doctor_id');
                    $this->db->where('tbl_schedule.date>=',date('y-m-d'));
                    $this->db->where('tbl_schedule.is_deleted', 0);
                    $this->db->where('tbl_schedule.doctor_id',$doctorId);

                    return $this->db->get('tbl_schedule')->result_array();
                }
            }    
        }
       
    }
    function deleteSchedule($scheduleId)
    {
        $this->db->select('time_slot_id');
        $this->db->where('schedule_id',$scheduleId);
        $this->db->where('status', 0);
        $query=$this->db->get('tbl_time_slot');
        if ($query->num_rows() > 0) {
            return false;
        } else 
        {

            $this->db->set('is_deleted', 1);
            $this->db->where('schedule_id',$scheduleId);
            $this->db->update('tbl_schedule'); 

            $this->db->set('is_deleted', 1);
            $this->db->where('schedule_id',$scheduleId);
            $this->db->update('tbl_time_slot'); 

            return true;
        }
    }
}