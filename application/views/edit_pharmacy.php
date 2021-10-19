<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<title>Manage Pharmacy</title>

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
					<form method="POST" id="edit_pharmacy_form" class="signup-form" action="">
						<h2 class="form-title">Edit Pharmacy Details</h2>
                        <input type="text" class="form-input" name="pharmacy_id" id="pharmacy_id" value="<?php echo set_value('pharmacy_id',$pharmacy['pharmacy_id']);?>" hidden/>
						
                            <label for="pharmacy_name">Pharmacy Name</label>
							<input type="text" class="form-input" name="pharmacy_name" id="pharmacy_name" placeholder="Enter Pharmacy name" value="<?php echo set_value('pharmacy_id',$pharmacy['pharmacy_name']);?>" />
							<span id="pharmacy_name_error" class="text-danger"></span>
                            <br>
                            <br>
                            <label for="address">Address</label>
							<input type="text" class="form-input" name="address" id="address" placeholder="Enter address" value="<?php echo set_value('pharmacy_id',$pharmacy['address']);?>" />
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
							<input type="text" class="form-input" name="phone" id="phone" placeholder="Enter phone" value="<?php echo set_value('pharmacy_id',$pharmacy['phone']);?>"/>
							<span id="phone_error" class="text-danger"></span>
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

	<!-- JS -->
	<script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/main.js"></script>
</body>

</html>
<script>
	$(document).ready(function() {
		$('#edit_pharmacy_form').on('submit', function(event) {
			event.preventDefault();
			$('#pharmacy_name_error').html('');
            $('#address_error').html('');
            $('#city_error').html('');
            $('#phone_error').html('');
			$.ajax({
				url: "<?php echo base_url().'pharmacy/editPharmacyValidations/'.$pharmacy['pharmacy_id'];?>",
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
					} else {

						$('#pharmacy_name_error').html('');
						$('#address_error').html('');
                        $('#city_error').html('');
                        $('#phone_error').html('');
						$('#edit_pharmacy_form')[0].reset();
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
        $('#cities').val('<?php echo set_value('pharmacy_id',$pharmacy['city']);?>');
});
</script>