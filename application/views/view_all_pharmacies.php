<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>All Pharmacies</title>

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
                <h2 class="form-title">Pharmacies</h2>
                <input type="hidden" id="session_type" data-value="<?php echo $this->session->userdata('type'); ?>" />
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <tr>
                                <th>Pharmacy ID</th>
                                <th>Pharmacy Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th id="th_edit">Edit</th>
                            </tr>
                            <div class="overflow-auto">
                            <?php if(!empty($pharmacies)){foreach ($pharmacies as $pharmacy){?>
                            </tr>
                                <td><?php echo $pharmacy['pharmacy_id']?></td>
                                <td><?php echo $pharmacy['pharmacy_name']?></td>
                                <td><?php echo $pharmacy['address']?>, <?php echo $pharmacy['city']?></td>
                                <td><?php echo $pharmacy['phone']?></td>
                                <td>
                                    <a href="<?php echo base_url().'pharmacy/editPharmacy/'.$pharmacy['pharmacy_id']?>" class="btn btn-warning" >Edit
                                </td>
                            </tr>
                            <?php } }else {?>
                            <tr>
                               <td colspan="5">Records not found</td>
                            </tr>
                        <?php } ?>
                            </div>
                        </table>
                   
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
        $('#th_edit').hide();
        $('a').hide(); 
    }
});
</script>