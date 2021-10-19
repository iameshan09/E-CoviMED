<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<title>Create Prescription</title>

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
					<form method="POST" id="create_prescription_form" class="signup-form" action="">
						<h2 class="form-title">Create Prescription</h2>
						<div class="form-group">
							<select name="patients" class="new-custom-select" id="patients">
								<option value="0">select patient</option>
								<?php if (count($patients)) : ?>
									<?php foreach ($patients as $patient) : ?>
										<option value=<?php echo $patient->patient_id; ?>><?php echo $patient->first_name; ?> <?php echo $patient->last_name; ?></option>
									<?php endforeach; ?>
								<?php else : ?>
								<?php endif; ?>
							</select>
							<span id="patient_error" class="text-danger"></span>
                        </div>
                        <div class="form-group">
							<select name="pharmacies" class="new-custom-select" id="pharmacies">
								<option value="0" class="new-custom-select">please select patient first</option>
							</select>
							<span id="pharmacy_error" class="text-danger"></span>
						</div>
                        <div class="form-group">
                            <label  class="mylabel">Enter prescription details :</label>
							<textarea rows="5" class="form-input" name="description" id="description"></textarea>
							<span id="description_error" class="text-danger"></span>
                        </div>
						<div class="form-group">
							<input type="submit" name="register" id="register" class="form-submit" value="Create" />
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
			$('#patients').on('change',function(){
				var patientId = $(this).val();
				if(patientId){
					$.ajax({
						type:'POST',
						url:'<?php echo base_url('prescription/getPharmacies'); ?>',
						data:'patient_id='+patientId,
						success:function(data){
							$('#pharmacies').html('<option value="">select pharmacy</option>'); 
							var dataObj = jQuery.parseJSON(data);
							if(dataObj){
								$(dataObj).each(function(){
									var option = $('<option />');
									option.attr('value', this.pharmacy_id).text(this.pharmacy_name);           
									$('#pharmacies').append(option);
								});
							}else{
								$('#pharmacies').html('<option value=""> no near pharmacies available for this patient</option>');
							}
						}
					}); 
				}else{
					$('#pharmacies').html('<option value="">please select pharmacy first</option>');
				
				}
			});
		});
	</script>
</body>
</html>
<script>
	$(document).ready(function() {
		$('#create_prescription_form').on('submit', function(event) {
			event.preventDefault();
			$('#patient_error').html('');
			$('#pharmacy_error').html('');
			$('#description_error').html('');
			$.ajax({
				url: "<?php echo base_url(); ?>prescription/create_prescription_validation",
				method: "POST",
				data: $(this).serialize(),
				dataType: "json",
				beforeSend: function() {
					$('#register').attr('disabled', 'disabled');

				},
				success: function(data) {

					if (data.error) {
						if (data.patient_error != '') {
							$('#patient_error').html(data.patient_error);
						} else {
							$('#patient_error').html('');
						}
						if (data.pharmacy_error != '') {
							$('#pharmacy_error').html(data.pharmacy_error);
						} else {
							$('#pharmacy_error').html('');
						}
						if (data.description_error != '') {
							$('#description_error').html(data.description_error);
						} else {
							$('#description_error').html('');
						}
					} else {
						$('#patient_error').html('');
						$('#pharmacy_error').html('');
						$('#description_error').html('');
						$('#create_prescription_form')[0].reset();
						$('#success_message').html(data.success);
                       
					}
					$('#register').attr('disabled', false);
				}
			})

		});

	});
</script>

