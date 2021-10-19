<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<title>Pharmacy Registration</title>

	<!-- Font Icon -->
	<link  rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/material-icon/css/material-design-iconic-font.min.css">

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
					<form method="POST" id="pharmacy_registration_form" class="signup-form" action="">
						<h2 class="form-title">Pharmacy Registration</h2>
						<div class="form-group">
							<input type="text" class="form-input" name="pharmacy_name" id="pharmacy_name" placeholder="Enter Pharmacy name" />
							<span id="pharmacy_name_error" class="text-danger"></span>
						</div>
                        <div class="form-group">
							<input type="text" class="form-input" name="address" id="address" placeholder="Enter address" />
							<span id="address_error" class="text-danger"></span>
						</div>
						<div class="form-group">
							<select name="cities" class="new-custom-select">
								<option value="select nearest city">select nearest city</option>
								<?php if (count($cities)) : ?>
									<?php foreach ($cities as $city) : ?>
										<option value=<?php echo $city->city_name; ?>><?php echo $city->city_name; ?></option>
									<?php endforeach; ?>
								<?php else : ?>
								<?php endif; ?>
							</select>
							<span id="city_error" class="text-danger"></span>
						</div>
						<div class="form-group">
							<input type="text" class="form-input" name="phone" id="phone" placeholder="Enter phone" />
							<span id="phone_error" class="text-danger"></span>
						</div>
                        <div class="form-group">
							<input type="text" class="form-input" name="email" id="email" placeholder="Enter email address" />
							<span id="email_error" class="text-danger"></span>
						</div>
						<div class="form-group">
							<input type="password" class="form-input" name="password" id="password" placeholder="Password" />
							<span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>
							<span id="password_error" class="text-danger"></span>
						</div>
						<div class="form-group">
							<input type="password" class="form-input" name="re_password" id="re_password" placeholder="Repeat your password" />
							<span id="re_password_error" class="text-danger"></span>
						</div>
						<div class="form-group">
							<input type="submit" name="register" id="register" class="form-submit" value="Register" />
						</div>
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
		$('#pharmacy_registration_form').on('submit', function(event) {
			event.preventDefault();
			$('#pharmacy_name_error').html('');
            $('#address_error').html('');
			$('#city_error').html('');
			$('#phone_error').html('');
            $('#email_error').html('');
			$('#password_error').html('');
			$('#re_password_error').html('');
			$.ajax({
				url: "<?php echo base_url(); ?>pharmacy/pharmacy_registration_validation",
				method: "POST",
				data: $(this).serialize(),
				dataType: "json",
				beforeSend: function() {
					$('#register').attr('disabled', 'disabled');

				},
				success: function(data) {

					if (data.error) {
						if (data.pharmacy_name_error != '') {
							$('#pharmacy_name_error').html(data.pharmacy_name_error);
						} else {
							$('#pharmacy_name_error').html('');
						}
                        if (data.address_error != '') {
							$('#address_error').html(data.address_error);
						} else {
							$('#address_error').html('');
						}
						if (data.city_error != '') {
							$('#city_error').html(data.city_error);
						} else {
							$('#city_error').html('');
						}
                        if (data.phone_error != '') {
							$('#phone_error').html(data.phone_error);
						} else {
							$('#phone_error').html('');
						}
                        if (data.email_error != '') {
							$('#email_error').html(data.email_error);
						} else {
							$('#email_error').html('');
						}
						if (data.password_error != '') {
							$('#password_error').html(data.password_error);
						} else {
							$('#password_error').html('');
						}
						if (data.re_password_error != '') {
							$('#re_password_error').html(data.re_password_error);
						} else {
							$('#re_password_error').html('');
						}
						if (data.mail_send_error != '') {
							$('#mail_send_error').html(data.mail_send_error);
						} else {
							$('#mail_send_error').html('');
						}
					} else {

						$('#pharmacy_name_error').html('');
                        $('#address_error').html('');
						$('#city_error').html('');
						$('#phone_error').html('');
                        $('#email_error').html('');
						$('#password_error').html('');
						$('#re_password_error').html('');
						$('#mail_send_error').html('');
						$('#pharmacy_registration_form')[0].reset();
						$('#success_message').html(data.success);
					}
					$('#register').attr('disabled', false);
				}
			})

		});

	});
</script>