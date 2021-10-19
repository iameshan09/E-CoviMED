<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<title>Make Appointment</title>

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
					<form method="POST" id="make_appointment_form" class="signup-form" action="">
						<h2 class="form-title">Make Appointment</h2>
						<div class="form-group">
							<select name="doctor_types" class="new-custom-select" id="doctor_types">
								<option value="">select the type of phycians</option>
								<?php if (count($doctor_types)) : ?>
									<?php foreach ($doctor_types as $doctor_type) : ?>
										<option value=<?php echo $doctor_type->doctor_id; ?>><?php echo $doctor_type->doctor_type; ?></option>
									<?php endforeach; ?>
								<?php else : ?>
								<?php endif; ?>
							</select>
							<span id="doctor_type_error" class="text-danger"></span>
                        </div>
                        <div class="form-group">
							<select name="doctors" class="new-custom-select" id="doctors">
								<option value="0" class="new-custom-select">please select type of the doctor first</option>
							</select>
							<span id="doctor_error" class="text-danger"></span>
						</div>
                        <div class="form-group">
							<select name="time_slots" class="new-custom-select" id="time_slots">
								<option value="0" class="new-custom-select">please select the doctor first</option>
							</select>
							<span id="time_slot_error" class="text-danger"></span>
						</div>
						<div class="form-group">
							<input type="submit" name="register" id="register" class="form-submit" value="Make Appointment" />
						</div>
					</form>
				</div>
			</div>
		</section>

	</div>

	<!-- JS -->
	<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
	<script>
		$(document).ready(function(){
			/* Populate data to state dropdown */
			$('#doctor_types').on('change',function(){
				var typeId = $(this).val();
				if(typeId){
					$.ajax({
						type:'POST',
						url:'<?php echo base_url('appointment/getDoctors'); ?>',
						data:'doctor_id='+typeId,
						success:function(data){
							$('#doctors').html('<option value="">select doctor</option>'); 
							var dataObj = jQuery.parseJSON(data);
							if(dataObj){
								$(dataObj).each(function(){
									var option = $('<option />');
									option.attr('value', this.doctor_id).text(this.doctor_name);           
									$('#doctors').append(option);
								});
							}else{
								$('#doctors').html('<option value="">doctors not available</option>');
							}
						}
					}); 
				}else{
					$('#doctors').html('<option value="">please select type of physician first</option>');
				
				}
			});
		});
	</script>

<script>
		$(document).ready(function(){
			/* Populate data to state dropdown */
			$('#doctors').on('change',function(){
				var typeId = $(this).val();
				if(typeId){
					$.ajax({
						type:'POST',
						url:'<?php echo base_url('appointment/getTimeSlots'); ?>',
						data:'doctor_id='+typeId,
						success:function(data){
							$('#time_slots').html('<option value="">select date & time slot</option>'); 
							var dataObj = jQuery.parseJSON(data);
							if(dataObj){
								$(dataObj).each(function(){
									var option = $('<option />');
									option.attr('value', this.time_slot_id).text(this.time_slot);           
									$('#time_slots').append(option);
								});
							}else{
								$('#time_slots').html('<option value="">Time slot not available</option>');
							}
						}
					}); 
				}else{
					$('#time_slots').html('<option value="">please select doctor first</option>');
				
				}
			});
		});
	</script>
</body>
</html>
<script>
	$(document).ready(function() {
		$('#make_appointment_form').on('submit', function(event) {
			event.preventDefault();
			$('#doctor_type_error').html('');
			$('#doctor_error').html('');
			$('#time_slot_error').html('');
			$.ajax({
				url: "<?php echo base_url(); ?>appointment/make_appointment_validation",
				method: "POST",
				data: $(this).serialize(),
				dataType: "json",
				beforeSend: function() {
					$('#register').attr('disabled', 'disabled');

				},
				success: function(data) {

					if (data.error) {
						if (data.doctor_type_error != '') {
							$('#doctor_type_error').html(data.doctor_type_error);
						} else {
							$('#doctor_type_error').html('');
						}
						if (data.doctor_error != '') {
							$('#doctor_error').html(data.doctor_error);
						} else {
							$('#doctor_error').html('');
						}
						if (data.time_slot_error != '') {
							$('#time_slot_error').html(data.time_slot_error);
						} else {
							$('#time_slot_error').html('');
						}
					} else {
						$('#doctor_type_error').html('');
						$('#doctor_error').html('');
						$('#time_slot_error').html('');
						$('#make_appointment_form')[0].reset();
						$('#success_message').html(data.success);
                       
					}
					$('#register').attr('disabled', false);
				}
			})

		});

	});
</script>

