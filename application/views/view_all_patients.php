<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>All Patients</title>

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
                <h2 class="form-title">Patients</h2>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <tr>
                                <th>Patient Id</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Age</th>
                                <th>NIC</th>
                                <th>Gender</th>
                            </tr>
                            <div class="overflow-auto">
                            <?php if(!empty($patients)){foreach ($patients as $patient){?>
                            </tr>
                                <td><?php echo $patient['patient_id']?></td>
                                <td><?php echo $patient['first_name']?> <?php echo $patient['last_name']?></td>
                                <td><?php echo $patient['address']?>, <?php echo $patient['city']?></td>
                                <td><?php echo $patient['phone']?></td>
                                <td><?php echo $patient['age']?></td>
                                <td><?php echo $patient['nic']?></td>
                                <td><?php echo $patient['gender']?></td>
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