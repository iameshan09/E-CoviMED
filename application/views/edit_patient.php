<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<title>Patient Registration</title>

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
					<form method="POST" id="patient_registration_form" class="signup-form" action="">
						<h2 class="form-title">Patient Registration</h2>
                        <input type="text" class="form-input" name="patient_id" id="patient_id" value="<?php echo set_value('patient_id',$patient['patient_id']);?>" hidden/>
						
                            <label for="first_name">First Name</label>
							<input type="text" class="form-input" name="first_name" id="first_name" placeholder="Enter first name" value="<?php echo set_value('patient_id',$patient['first_name']);?>" />
							<span id="first_name_error" class="text-danger"></span>
                            <br>
                            <br>
						
                            <label for="last_name">Last Name</label>
							<input type="text" class="form-input" name="last_name" id="last_name" placeholder="Enter last name" value="<?php echo set_value('patient_id',$patient['last_name']);?>" />
							<span id="last_name_error" class="text-danger"></span>
						    <br>
                            <br>

                            <label for="address">Address</label>
							<input type="text" class="form-input" name="address" id="address" placeholder="Enter address" value="<?php echo set_value('patient_id',$patient['address']);?>" />
							<span id="address_error" class="text-danger"></span>
                            <br>
                            <br>
						
                            <label for="cities">City</label>
							<select id="cities" name="cities" class="new-custom-select">
								<option value="select nearest city">select nearest city</option>
								<?php if (count($cities)) : ?>
									<?php foreach ($cities as $city) : ?>
										<option value=<?php echo $city->city_name; ?>><?php echo $city->city_name; ?></option>
									<?php endforeach; ?>
								<?php else : ?>
								<?php endif; ?>
							</select>
							<span id="city_error" class="text-danger"></span>
                            <br>
                            <br>
			
                            <label for="phone">Phone</label>
							<input type="text" class="form-input" name="phone" id="phone" placeholder="Enter phone" value="<?php echo set_value('patient_id',$patient['phone']);?>"/>
							<span id="phone_error" class="text-danger"></span>
                            <br>
                            <br>
					
						    <label for="age">Age</label>
							<input type="text" class="form-input" name="age" id="age" placeholder="Enter age" value="<?php echo set_value('patient_id',$patient['age']);?>" />
							<span id="age_error" class="text-danger"></span>
                            <br>
                            <br>
						
						    <label for="NIC">NIC</label>
							<input type="text" class="form-input" name="NIC" id="NIC" placeholder="Enter NIC(national identity card)number" value="<?php echo set_value('patient_id',$patient['nic']);?>" />
							<span id="NIC_error" class="text-danger"></span>
                            <br>
                            <br>
					
                            <label for="gender">Gender</label>
							<select id="gender" name="gender" class="new-custom-select">
								<option value="Select">Select</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
							</select>
							<span id="gender_error" class="text-danger"></span>
                            <br>
                            <br>

						<div class="form-group">
							<input type="submit" name="register" id="register" class="form-submit" value="Update" />
						</div>
					</form>
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
		$('#patient_registration_form').on('submit', function(event) {
			event.preventDefault();
			$('#first_name_error').html('');
            $('#last_name_error').html('');
            $('#address_error').html('');
			$('#city_error').html('');
			$('#phone_error').html('');
            $('#age_error').html('');
			$('#NIC_error').html('');
            $('#gender_error').html('');
			$.ajax({
				url: "<?php echo base_url().'patient/editPatientValidations/'.$patient['patient_id'];?>",
				method: "POST",
				data: $(this).serialize(),
				dataType: "json",
				beforeSend: function() {
					$('#register').attr('disabled', 'disabled');

				},
				success: function(data) {

					if (data.error) {
						if (data.first_name_error != '') {
							$('#first_name_error').html(data.first_name_error);
						} else {
							$('#first_name_error').html('');
						}
                        if (data.last_name_error != '') {
							$('#last_name_error').html(data.last_name_error);
						} else {
							$('#last_name_error').html('');
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
                        if (data.age_error != '') {
							$('#age_error').html(data.age_error);
						} else {
							$('#age_error').html('');
						}
						if (data.NIC_error != '') {
							$('#NIC_error').html(data.NIC_error);
						} else {
							$('#NIC_error').html('');
						}
                        if (data.gender_error != '') {
							$('#gender_error').html(data.gender_error);
						} else {
							$('#gender_error').html('');
						}
					} else {

						$('#first_name_error').html('');
                        $('#last_name_error').html('');
                        $('#address_error').html('');
						$('#city_error').html('');
						$('#phone_error').html('');
                        $('#age').html('');
						$('#NIC_error').html('');
						$('#gender_error').html('');
						$('#patient_registration_form')[0].reset();
                        window.location = "<?php echo base_url(); ?>home/<?php echo $this->session->userdata('url');?>";
					}
					$('#register').attr('disabled', false);
				}
			})

		});

	});
</script>
<script>
	$( document ).ready(function() {
        $('#cities').val('<?php echo set_value('patient_id',$patient['city']);?>');
        $('#gender').val('<?php echo set_value('patient_id',$patient['gender']);?>');
});
</script>