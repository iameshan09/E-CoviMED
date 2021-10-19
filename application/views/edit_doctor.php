<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<title>Manage Doctor</title>

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
					<form method="POST" id="edit_doctor_form" class="signup-form" action="">
						<h2 class="form-title">Edit Doctor Details</h2>
                        <input type="text" class="form-input" name="doctor_id" id="doctor_id" value="<?php echo set_value('doctor_id',$doctor['doctor_id']);?>" hidden/>
						
                            <label for="doctor_name">Doctor Name</label>
							<input type="text" class="form-input" name="doctor_name" id="doctor_name" placeholder="Enter Doctor name" value="<?php echo set_value('doctor_name',$doctor['doctor_name']);?>" />
							<span id="doctor_name_error" class="text-danger"></span>
                            
                        <label for="doctor_type">Doctor Type</label>
                        <div class="form-group">
							<select id="doctor_type" name="doctor_type" class="new-custom-select">
                                <option value="select">select type of physician</option>
                                <option value="DerMantologists">DerMantologists</option>
                                <option value="Ophthalmologist">Ophthalmologist</option>
                                <option value="Cardiologist">Cardiologist</option>
                                <option value="Nephrologist">Nephrologist</option>
                                <option value="Urologist">Urologist</option>
                                <option value="Gynecologist">Gynecologist</option>
                                <option value="Pulmonologist">Pulmonologist</option>
                                <option value="Otolaryngologist">Otolaryngologist</option>
                                <option value="Neurologist">Neurologist</option>
                                <option value="Psychiatrist">Psychiatrist</option>
							</select>
							<span id="doctor_type_error" class="text-danger"></span>
						</div>
						<div class="form-group">
							<input type="submit" name="register" id="register" class="form-submit" value="Update" />
						</div>
					</form>
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
	$(document).ready(function() {
		$('#edit_doctor_form').on('submit', function(event) {
			event.preventDefault();
			$('#doctor_name_error').html('');
            $('#doctor_type_error').html('');
			$.ajax({
				url: "<?php echo base_url().'doctor/editDoctorValidations/'.$doctor['doctor_id'];?>",
				method: "POST",
				data: $(this).serialize(),
				dataType: "json",
				beforeSend: function() {
					$('#register').attr('disabled', 'disabled');

				},
				success: function(data) {

					if (data.error) {
						if (data.doctor_name_error != '') {
							$('#doctor_name_error').html(data.doctor_name_error);
						} else {
							$('#doctor_name_error').html('');
						}
                        if (data.doctor_type_error != '') {
							$('#doctor_type_error').html(data.doctor_type_error);
						} else {
							$('#doctor_type_error').html('');
						}
					} else {

						$('#doctor_name_error').html('');
						$('#doctor_type_error').html('');
						$('#edit_doctor_form')[0].reset();
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
        $('#doctor_type').val('<?php echo set_value('doctor_id',$doctor['doctor_type']);?>');
});
</script>