<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<title>request customer confirmation</title>

	<!-- Font Icon -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/material-icon/css/material-design-iconic-font.min.css">

	<!-- Main css -->
	<link class="one" rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link class="second" rel="stylesheet" href="<?php echo base_url(); ?>/assets/css/style.css">
</head>

<body>

	<div class="main">

		<section class="signup">
			<!-- <img src="images/signup-bg.jpg" alt=""> -->
			<div class="container ">
				<div class="signup-content">
				        <div class="form-group">
                          <span id="success_message"></span>
						</div>
					<form method="POST" id="view_order_form" class="signup-form" action="">
						<h2 class="form-title">Request Customer Confirmation</h2>
							<input type="text" class="form-input" name="presc_id" id="presc_id"  value="<?php echo set_value('presc_id',$order['presc_id']);?>" hidden/>
							<input type="text" class="form-input" name="email" id="email"  value="<?php echo set_value('email',$order['email']);?>" hidden/>

                            <div class="form-group">
                            <label for="date">Date</label>
							<input type="text" class="form-input" name="date" id="date"  value="<?php echo set_value('date',$order['date']);?>" readonly/>
		                    </div>
                            
                            <div class="form-group">
							<label for="customer_name">Customer Name</label>
							<input type="text" class="form-input" name="customer_name" id="customer_name"  value="<?php echo set_value('first_name',$order['first_name']);?> <?php echo set_value('last_name',$order['last_name']);?>" readonly>
		                    </div>

                            <div class="form-group">
                            <label for="address">Address</label>
							<input type="text" class="form-input" name="address" id="address"  value="<?php echo set_value('address',$order['address']);?>" />
                            </div>
                           
                            <div class="form-group">
                            <label for="phone">Customer Mobile No</label>
							<input type="text" class="form-input" name="phone" id="phone"  value="<?php echo set_value('phone',$order['phone']);?>" readonly/>
                            </div>

                            <div class="form-group">
                            <label  for="description">Prescription</label>
							<textarea readonly rows="5" class="form-input" name="description" id="description" ><?php echo set_value('description',$order['description']);?></textarea>
                            </div>


                            <div class="form-group">
						    <label for="doctor">Prescription by</label>
							<input type="text" class="form-input" name="doctor" id="doctor" value="<?php echo set_value('doctor_name',$order['doctor_name']);?>" readonly/>
                            </div>

                            <div class="form-group">
							<input type="number"  step="0.01" class="form-input" name="amount" id="amount" placeholder="Enter order total amount" />
							<span id="amount_error" class="text-danger"></span>
						    </div>
							<input type="submit" name="register" id="register" class="form-submit" value="Proceed" />
					</form>
					<span id="mail_send_error"></span>
				</div>
			</div>
		</section>
	</div>
	<div class="modal"></div>
	<!-- JS -->
	<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/main.js"></script>
</body>

</html>
<script>
	$(document).ready(function() {
		$('#view_order_form').on('submit', function(event) {
			event.preventDefault();
			$('#amount_error').html('');
			$('#mail_send_error').html('');
			$.ajax({
				url: "<?php echo base_url().'order/proceed_pending_order'?>",
				method: "POST",
				data: $(this).serialize(),
				dataType: "json",
				beforeSend: function() {
					$('#register').attr('disabled', 'disabled');

				},
				success: function(data) {

					if (data.error) {
						if (data.amount_error != '') {
							$('#amount_error').html(data.amount_error);
						} else {
							$('#amount_error').html('');
						}
						if (data.mail_send_error != '') {
							$('#mail_send_error').html(data.mail_send_error);
						} else {
							$('#mail_send_error').html('');
						}
					} else {
                        
						window.location = "<?php echo base_url(); ?>prescription/viewPrescRequests";
					}
					$('#register').attr('disabled', false);
				}
			})

		});

	});
</script>

