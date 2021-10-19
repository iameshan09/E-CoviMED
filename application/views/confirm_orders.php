<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>My Orders</title>

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
                <h2 class="form-title">waiting for you to confirm the order</h2>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped">
                            <tr>
                                <th>Pharmacy</th>
                                <th>Contact No</th>
                                <th>Total Amount</th>
                                <th>Accept</th>
                                <th>Cancel</th>
                            </tr>
                            <div class="overflow-auto">
                            <?php if(!empty($orders)){foreach ($orders as $order){?>
                            </tr>
                                <td><?php echo $order['pharmacy_name']?></td>
                                <td><?php echo $order['phone']?></td>
                                <td>LKR <?php echo $order['amount']?></td>
                                <td>
                                    <a href="<?php echo base_url().'order/acceptOrder/'.$order['presc_id']?>" class="btn btn-primary">Accept
                                </td>
                                <td> <a href="<?php echo base_url().'order/cancelOrder/'.$order['presc_id']?>" class="btn btn-danger">Cancel</td>
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