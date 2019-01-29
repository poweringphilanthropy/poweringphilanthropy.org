<?php
/**
 * Display a notice on the EDD checkout page showing the amount to be donated.
 *
 * @since       1.0.0
 * @author      Eric Daams 
 * @copyright   Copyright (c) 2017, Studio 164a
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License  
 */
global $edd_receipt_args;

$payment_id = $edd_receipt_args['id'];
$user      = edd_get_payment_meta_user_info( $payment_id );
$edd_cart = Charitable_EDD_Cart::create_with_payment( $payment_id );

$campaigns_on_payment = PP_Team_Fundraising::pp_get_campaigns_on_payment($payment_id);

// echo "<pre>";
// print_r($campaigns_on_payment);
// echo "</pre>";

$at_date    = new DateTime( get_post_field( 'post_date', $payment_id ) );

$meta       = edd_get_payment_meta( $payment_id );
$email      = edd_get_payment_user_email( $payment_id );

/* If there are no benefactors or fees for this payment, return. */
if ( ! $edd_cart->has_benefactors( $at_date ) && ! $edd_cart->has_donations_as_fees() ) {
    return;
}


$campaign_donations = array();

/* Add all campaign donations created as fees. */
if ( $edd_cart->has_donations_as_fees() ) {

    foreach ( $edd_cart->get_fees() as $campaign_id => $fees ) {

        if(!array_key_exists($campaign_id, $campaigns_on_payment))
            continue;

        $benefit_amount = array_sum( $fees );

        $campaign_donations[$campaign_id][] = array(
            'donation_type' => 'donation',
            'campaign_id' => $campaign_id,
            'amount'      => $benefit_amount,
        );

    }
}

/* Add all campaign donations from benefactor relationships. */
foreach ( $edd_cart->get_benefactor_benefits() as $benefactor_id => $benefits ) {

    foreach ( $benefits as $b_download_id => $benefit ) {
        
        $campaign_id = $benefit['campaign_id'];

        if(!array_key_exists($campaign_id, $campaigns_on_payment))
            continue;

        /**
         * parse actual download id, since charitable edd concate download id with price id
         * @see  Charitable_EDD_Cart::filter_download() [<description>]
         * @var [type]
         */
        $_download_id = explode('_', $b_download_id);
        $download_id = $_download_id[0];
        $price_id = ( edd_has_variable_prices( $download_id ) && isset($_download_id[1]) ) ? $_download_id[1] : null;

        /* Unless a download is a ticket, we will classify it as "merchandise". */
        $download_type = has_term( 'ticket', 'download_category', $download_id ) ? 'tickets' : 'merchandise';

        $campaign_donations[$campaign_id][] = array(
            'donation_type' => $download_type,
            'campaign_id' => $benefit['campaign_id'],
            'download_id' => $download_id,
            'price_id'      => $price_id,
            'price' => $benefit['price'],
            'quantity' => $benefit['quantity'],
            'download_files'      => edd_get_download_files( $download_id, $price_id ),
            'amount'      => $benefit['contribution'],
        );

    }
}
foreach ( $campaign_donations as $campaign_id => $data ){ 
	$campaign_id = $campaign_id;
	$url = "";
	if ( has_post_thumbnail( $campaign_id ) ) :
		$url =  get_the_post_thumbnail_url( $campaign_id, 'reach-post-thumbnail-full' );
	endif;
}
?> 

<h2 class="checkout_title">Thanks for your donation!</h2>
<div class="col-lg-6 form-block">
	<p> <?php echo $user['first_name'];?>,</p>
	<p>It's not every day that you get to help someone change the world. But today, you did just that. Thank you!</p>
	<p style="padding:0;">Here are the details of your tax deductible donation to:</p>
	
	<a target="_blank" href="<?php echo get_permalink($campaign_id);?>"><h2 class="mb-3 font-weight-bold"><?php echo get_the_title($campaign_id);?></h2></a>
	<div class="form-image">
	<img src="<?php echo $url;?>" alt="image" class="img-fluid"><br>
		
		
		
		<ul class="amount-detail">
			<li>
			<label>
			<?php if ( filter_var( $edd_receipt_args['date'], FILTER_VALIDATE_BOOLEAN ) ) : 
				echo date_i18n( get_option( 'date_format' ), strtotime( $meta['date'] ) );
			endif; ?>
			</label>
			</li>
			<li><label for="amount">DONATION AMOUNT:</label> <span class="edd_cart_fee_amount"><?php echo charitable_format_money( $edd_cart->get_total_campaign_benefit_amount( $campaign_id ) ) ?></span></li>
			<?php 
				$charge_details = edd_get_payment_meta( $payment_id, 'charge_details', true );
				$donor_covers_fee = $charge_details['donor-covers-fee'];
				if( $donor_covers_fee == "yes" ): ?>
				<li>
					<label><?php _e( 'PROCESSING FEES:', 'easy-digital-downloads' ); ?></label>
					<span>
						<?php echo edd_currency_filter( $charge_details['total-fee-amount'] ); ?>
					</span>
				</li>
			<?php endif; ?>
			<li>
				<label><b>TOTAL CHARGE:</b></label>
				<span>
				<?php 
					$total = edd_payment_amount( $payment_id );
						// if( !empty($covered_fees) ){
						if( $donor_covers_fee == "yes" ){
							$total_including_fees = floatval( edd_get_payment_amount( $payment_id ) ) + floatval($charge_details['total-fee-amount']);
							$total = edd_currency_filter( edd_format_amount( $total_including_fees ) );
						}
						echo '<b>'.$total.'</b>'; 
				?>
				</span>
			</li>
			
		</ul>
		<p>Thanks again - your support  helps young rockstars make the world a better place!
		</p>
		<p style="text-align:center;">
		<a href="https://www.givemyday.com/#pledgenow"><input type="button" class="pledge_button edd-submit blue button" id="edd-purchase-button" name="edd-purchase" value="Pledge your day, TOO!"></a>
		</p> 
						
						
	</div>
</div>
