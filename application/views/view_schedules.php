<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Future Schedules</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link class="one" rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link class="second" rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
</head>

<body>

    <div class="main">

        <section class="signup">
            <!-- <img src="images/signup-bg.jpg" alt=""> -->
            <div class="container2">
                <div class="table-content">
                <h2 class="form-title">Schedule</h2>
                <input type="hidden" id="session_type" data-value="<?php echo $this->session->userdata('type'); ?>" />
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <tr>
                                <th>Schedule Id</th>
                                <th>Doctor Name</th>
                                <th>Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th id="th_delete">Delete</th>
                            </tr>
                            <div class="overflow-auto">
                            <?php if(!empty($schedules)){foreach ($schedules as $schedule){?>
                            </tr>
                                <td><?php echo $schedule['schedule_id']?></td>
                                <td><?php echo $schedule['doctor_name']?></td>
                                <td><?php echo $schedule['date']?></td>
                                <td><?php echo $schedule['start_time']?></td>
                                <td><?php echo $schedule['end_time']?></td>
                                <td>
                                    <a href="<?php echo base_url().'schedule/deleteSchedule/'.$schedule['schedule_id']?>" class="btn btn-danger" id=>Delete</a>
                                </td>
                            </tr>
                            <?php } }else {?>
                            <tr>
                               <td colspan="5">Records not found</td>
                            </tr>
                        <?php } ?>
                            </div>
                        </table>
                        <span id="infoMessage" class="text-danger"><?php echo $this->session->flashdata('message1');?></span>
                   
                </div>
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/main.js"></script>
</body>
</html>
<script>
$( document ).ready(function() {
    var sessionType= $("#session_type").data('value');
    if(sessionType=="Doctor")
    {
        $('#th_delete').hide();
        $('a').hide(); 
    }
});
$(document).ready( function() {
        $('#infoMessage').delay(3500).fadeOut();
      });
</script>
