<?php 

/* 
Template Name: Booking
*/

// Fetch options stored in $data
global $data;

// Get booking page ID
$booking_page = $data['booking_page_url'];

// Check if form has been submit
if ( $_SERVER['HTTP_REFERER'] == $data['booking_page_url']  && $_POST['submit'] == 'submit' ) {
	$submit = true;
	
	// Post form data from this page
	$book_room_type = $_POST['book_cottage_type'];
	$book_date_from = $_POST['book_date_from'];
	$book_date_to = $_POST['book_date_to'];
	$book_full_name = $_POST['book_full_name'];
	$book_num_people = $_POST['book_num_people'];
	$book_email = $_POST['book_email'];
	$book_phone = $_POST['book_phone'];
	$book_message = $_POST['book_message'];
	$book_cottage_price = $_POST['book_cottage_price'];
	
	if(trim( $book_cottage_type ) === '') {
		$book_cottage_type_error = __('Cottage Type is a required field', 'qns');
		$got_error = true;
	}
	
	if(trim( $book_date_from ) === '') {
		$book_date_from_error = __('Date From is a required field', 'qns');
		$got_error = true;
	}
	
	if(trim( $book_date_to ) === '') {
		$book_date_to_error = __('Date To is a required field', 'qns');
		$got_error = true;
	}
	
	if(trim( $book_full_name ) === '' or trim( $book_full_name ) === 'Full Name') {
		$book_full_name_error = __('Full Name is a required field', 'qns');
		$got_error = true;
	}
	
	if(trim( $book_num_people ) === '' or trim( $book_num_people ) === 'Number of People') {
		$book_num_people_error = __('Number of People is a required field', 'qns');
		$got_error = true;
	}
	
	if(trim( $book_email ) === '' or trim( $book_email ) === 'Email Address' or valid_email( trim($book_email) ) === FALSE ) {
		$book_email_error = __('Email Address is a required field', 'qns');
		$got_error = true;
	}
	
}

// If the form on this page has not been submit post the values from the accommodation page
else {
	
	if($_POST['book_cottage_type_and_price'] != '') {
		$book_cottage_price_array = explode(',', $_POST['book_cottage_type_and_price']);		
		$book_cottage_type = $book_cottage_price_array[0];
		$book_cottage_price = $book_cottage_price_array[1];
	}
	
	else {
		
		$book_cottage_type = $_POST['book_cottage_type'];
		$book_cottage_price = $_POST['book_cottage_price'];
		
	}
	
	$book_date_from = $_POST['book_date_from'];
	$book_date_to = $_POST['book_date_to'];
	
}

// Calculate Length of Stay
$date_from_stt = strtotime($book_date_from);
$date_to_stt = strtotime($book_date_to);
$datediff = $date_to_stt - $date_from_stt;
$total_stay = floor($datediff/(60*60*24));

// Calculate Total Price
$total_price = $book_cottage_price * $total_stay;

// Get currency unit stored in the theme options
if ( $data['currency_unit'] !== '' ) {
	$currency_unit = $data['currency_unit'];
}

// If the unit is not set
else {
	$currency_unit = '$';
}

// If form has been submit and there are no errors send it
if ( $submit == true && $got_error != true ) {
	
	$email_to = $data['contact_email'];

	if (!isset($email_to) || ($email_to == '') ){
		$email_to = get_option('admin_email');
	}

	$subject = get_bloginfo( 'name' ) . __(' Booking Form','qns');
	
	$body = '<ul style="margin: 0px;padding:0 0 0 15px;">';
	$body .= '<li style="margin-bottom: 3px;"><strong>' . __('Cottage Type','qns') . ":</strong> " . $book_cottage_type . "</li>";
	$body .= '<li style="margin-bottom: 3px;"><strong>' . __('Date','qns') . ":</strong> " . $book_date_from . " - " . $book_date_to . "</li>";
	$body .= '<li style="margin-bottom: 3px;"><strong>' . __('Guest Name','qns') . ":</strong> " . $book_full_name . "</li>";
	$body .= '<li style="margin-bottom: 3px;"><strong>' . __('Number of People','qns') . ":</strong> " . $book_num_people . "</li>";
	$body .= '<li style="margin-bottom: 3px;"><strong>' . __('Email','qns') . ":</strong> " . $book_email . "</li>";
	$body .= '<li style="margin-bottom: 3px;"><strong>' . __('Phone','qns') . ":</strong> " . $book_phone . "</li>";
	$body .= '<li style="margin-bottom: 3px;"><strong>' . __('Price Quoted','qns') . ":</strong> " . $currency_unit.$total_price . "</li>";
	$body .= '<li style="margin-bottom: 3px;"><strong>' . __('Special Requirements','qns') . ":</strong> " . $book_message . "</li>";
	$body .= '<li style="margin-bottom: 3px;"><strong>' . __('IP Address','qns') . ":</strong> " . $_SERVER['REMOTE_ADDR'] . "</li>";
	$body .= '</ul>';

	$headers = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=UTF-8\r\n";
	$headers .= "From: ".$book_full_name." <".$email_to.">" . "\r\n" . "Reply-To: " . $book_email;
	
	mail($email_to, $subject, $body, $headers);
	$emailSent = true;
	
}

?>

<?php get_header(); ?>

	<?php //Display Page Header
		global $wp_query;
		$postid = $wp_query->post->ID;
		echo page_header( get_post_meta($postid, 'qns_page_header_image', true) );
		wp_reset_query();
	?>
	
	<!-- BEGIN .section -->
	<div class="section page-full clearfix">

		<h2 class="page-title">Cottage Booking</h2>
		
		<!-- BEGIN .page-content -->
		<div class="page-content page-content-full">
			
			<?php // Prevent users from loading the page directly
				if ( $_SERVER['HTTP_REFERER'] == '' or $_POST['book_confirm'] != '1' ) : 
					echo '<div class="msg fail"><p>Please do not load this page directly, go to the accommodation page first and select cottage</p></div>'; 
			?>
			
			<?php else : ?>
			
			<!-- BEGIN .even-cols -->
			<div class="even-cols booking-cols clearfix">
				
				<!-- BEGIN .one-half -->
				<div class="one-half">
					
					<?php
					
						if ( $submit == true && $got_error != true ) {
							echo '<div class="msg success"><p>';
							
							if($data['accom_success_msg']) {
								echo $data['accom_success_msg'];
							} else {
								_e('Booking Successful! Nice Hotel will reply within 24 hours','qns');
							}
							
							echo '</p></div>';
						}
						
						if ( $got_error == true ) {
							
							echo '<div class="msg fail">
							<ul class="list-fail">';
							
							if ( $book_cottage_type_error != '' ) { echo '<li>' . $book_cottage_type_error . '</li>'; }
							if ( $book_date_from_error != '' ) { echo '<li>' . $book_date_from_error . '</li>'; }
							if ( $book_date_to_error != '' ) { echo '<li>' . $book_date_to_error . '</li>'; }
							if ( $book_full_name_error != '' ) { echo '<li>' . $book_full_name_error . '</li>'; }
							if ( $book_num_people_error != '' ) { echo '<li>' . $book_num_people_error . '</li>'; }
							if ( $book_email_error != '' ) { echo '<li>' . $book_email_error . '</li>'; }

							echo '</ul></div>';
							
						}
					
					?>
					
					<?php if ( $emailSent == true ) : ?>
						
						<table class="booking-table">
							<thead>
								<tr>
									<th><?php _e('Booking Option','qns'); ?></th>
									<th><?php _e('Selection','qns'); ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><strong><?php _e('Cottage Type','qns'); ?>:</strong></td>
									<td><?php echo $book_cottage_type; ?></td>
								</tr>
								<tr>
									<td><strong><?php _e('Date','qns'); ?>:</strong></td>
									<td><?php echo $book_date_from; ?> - <?php echo $book_date_to; ?> (<?php echo $total_stay; ?> <?php _e('Nights','qns'); ?>)</td>
								</tr>
								<tr>
									<td><strong><?php _e('Name','qns'); ?>:</strong></td>
									<td><?php echo $book_full_name; ?></td>
								</tr>
								<tr>
									<td><strong><?php _e('Number of People','qns'); ?>:</strong></td>
									<td><?php echo $book_num_people; ?></td>
								</tr>
								<tr>
									<td><strong><?php _e('Email Address','qns'); ?>:</strong></td>
									<td><?php echo $book_email; ?></td>
								</tr>
								<tr>
									<td><strong><?php _e('Phone Number','qns'); ?>:</strong></td>
									<td><?php echo $book_phone; ?></td>
								</tr>
								<tr>
									<td><strong><?php _e('Special Requirements','qns'); ?>:</strong></td>
									<td><?php echo $book_message; ?></td>
								</tr>
								<tr class="table-highlight">
									<td><strong><?php _e('Total Cost','qns'); ?>:</strong></td>
									<td><?php echo $currency_unit.$total_price; ?></td>
								</tr>
							</tbody>
						</table>
					
					<?php else : ?>
					
					<!-- BEGIN .booknow-accompage -->
					<div class="booknow-accompage full-booking-form">
						
						<div class="book-price">
							
							<h2 class="price"><?php echo $currency_unit; ?><span class="cottage-price"><?php echo $total_price; ?></span><span class="price-detail"><span class="price-detail-value"><?php echo $total_stay; ?></span> <?php _e('Nights','qns'); ?></span></h2>
							
							<div class="price-tl"></div>
							<div class="price-tr"></div>
							<div class="price-bl"></div>
							<div class="price-br"></div>
							
						</div>
						
						<script>
							// Set cottage price for external JS file
							var getPrice = <?php echo $book_cottage_price; ?>;
						</script>
						
						<form class="booking-form booking-form-accompage" name="bookcottage" action="<?php echo $booking_page; ?>" method="post">
							
							<input type="text" value="<?php echo $book_cottage_type; ?>" class="text-input" disabled="disabled">

							<div class="clearfix">
								<input type="text" name="book_date_from" id="datefrom" value="<?php echo $book_date_from; ?>" class="input-half datepicker">
								<input type="text" name="book_date_to" id="dateto" value="<?php echo $book_date_to; ?>" class="input-half input-half-last datepicker">
							</div>
							
							<input type="text" onblur="if(this.value=='')this.value='Full Name';" onfocus="if(this.value=='Full Name')this.value='';" value="<?php 
								if(isset($_POST['book_full_name'])) : echo $_POST['book_full_name']; 
								else : _e('Full Name','qns'); 
								endif;
							?>" name="book_full_name" class="text-input" />
							
							<input type="text" onblur="if(this.value=='')this.value='Number of People';" onfocus="if(this.value=='Number of People')this.value='';" value="<?php 
								if(isset($_POST['book_num_people'])) : echo $_POST['book_num_people']; 
								else : _e('Number of People','qns'); 
								endif;
							?>" name="book_num_people" class="text-input" />
							
							<input type="text" onblur="if(this.value=='')this.value='Email Address';" onfocus="if(this.value=='Email Address')this.value='';" value="<?php 
								if(isset($_POST['book_email'])) : echo $_POST['book_email']; 
								else : _e('Email Address','qns'); 
								endif;
							?>" name="book_email" class="text-input" />
							
							<input type="text" onblur="if(this.value=='')this.value='Phone Number';" onfocus="if(this.value=='Phone Number')this.value='';" value="<?php 
								if(isset($_POST['book_phone'])) : echo $_POST['book_phone']; 
								else : _e('Phone Number','qns'); 
								endif;
							?>" name="book_phone" class="text-input" />
							
							<textarea class="text-input" rows="6" name="book_message" onfocus="if(this.value=='Special Requirements')this.value='';" onblur="if(this.value=='')this.value='Special Requirements';"><?php 
								if(isset($_POST['book_message'])) : echo $_POST['book_message']; 
								endif;
							?></textarea>
							
							<input type="hidden" name="book_confirm" value="1" />
							<input type="hidden" name="book_cottage_type" value="<?php echo $book_cottage_type; ?>" />
							<input type="hidden" name="book_cottage_price" value="<?php echo $book_cottage_price; ?>" />
							<input type="hidden" name="submit" value="submit" />
							
							<input class="bookbutton" type="submit" value="<?php _e('Book Now','qns'); ?>" />

						</form>
						
					<!-- END .booknow-accompage -->
					</div>
					
					<?php endif; ?>
				
				<!-- END .one-half -->
				</div>
			
				<!-- BEGIN .one-half -->
				<div class="one-half last-col">
					
					<?php the_content(); ?>
				
				<!-- END .one-half -->
				</div>
				
			<!-- END .even-cols -->
			</div>
			
			<?php endif; ?>
			
		<!-- END .page-content -->
		</div>

	<!-- END .section -->
	</div>
	
<?php get_footer(); ?>