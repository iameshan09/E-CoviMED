<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<title>Create Schedule</title>

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
					<form method="POST" id="create_schedule_form" class="signup-form" action="">
						<h2 class="form-title">New Schedule</h2>
					    <div class="form-group">
							<select name="doctors" class="new-custom-select">
								<option value="0">Select Doctor</option>
								<?php if (count($doctors)) : ?>
									<?php foreach ($doctors as $doctor) : ?>
										<option value=<?php echo $doctor->doctor_id; ?>><?php echo $doctor->doctor_name; ?></option>
									<?php endforeach; ?>
								<?php else : ?>
								<?php endif; ?>
							</select>
							<span id="doctor_name_error" class="text-danger"></span>
						</div>
                        <div class="form-group">
                            <label class="label other" for="schedule_date">pick schedule date &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;</label>
                            <input type="date" id="schedule_date" name="schedule_date">
                            <span id="schedule_date_error" class="text-danger"></span>
                        </div>
                        <div class="form-group">
                            <label for="start_time">pick schedule start time:&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;&nbsp;</label>
                            <input type="time" id="start_time" name="start_time">  
							<span id="start_time_error" class="text-danger"></span>
						</div>
                        <div class="form-group">
                            <label for="end_time">pick schedule end time:&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&ensp;&nbsp;&ensp;</label>
                            <input type="time" id="end_time" name="end_time">  
							<span id="end_time_error" class="text-danger"></span>
						</div>
						<div class="form-group">
							<input type="submit" name="add" id="add" class="form-submit" value="ADD" />
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
		$('#create_schedule_form').on('submit', function(event) {
			event.preventDefault();
			$('#doctor_name_error').html('');
			$.ajax({
				url: "<?php echo base_url(); ?>schedule/create_schedule_validation",
				method: "POST",
				data: $(this).serialize(),
				dataType: "json",
				beforeSend: function() {
					$('#add').attr('disabled', 'disabled');

				},
				success: function(data) {

					if (data.error) {
						if (data.doctor_name_error != '') {
							$('#doctor_name_error').html(data.doctor_name_error);
						} else {
							$('#doctor_name_error').html('');
						}
                        if (data.schedule_date_error != '') {
							$('#schedule_date_error').html(data.schedule_date_error);
						} else {
							$('#schedule_date_error').html('');
						}
                        if (data.start_time_error != '') {
							$('#start_time_error').html(data.start_time_error);
						} else {
							$('#start_time_error').html('');
						}
                        if (data.end_time_error != '') {
							$('#end_time_error').html(data.end_time_error);
						} else {
							$('#end_time_error').html('');
						}
                        
						
					} else {

						$('#doctor_name_error').html('');
                        $('#schedule_date_error').html('');
                        $('#start_time_error').html('');
                        $('#end_time_error').html('');
						$('#create_schedule_form')[0].reset();
						$('#success_message').html(data.success);
					}
					$('#add').attr('disabled', false);
				}
			})

		});

	});
</script>