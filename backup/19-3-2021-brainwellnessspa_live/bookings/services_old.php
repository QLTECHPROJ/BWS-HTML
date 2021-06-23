<?php
	include('inc.php');
	header("Cache-Control: max-age=9000, must-revalidate"); 
	if(isset($_REQUEST["bId"])){
		$bid=base64_decode($_REQUEST["bId"]);
		$arr=explode("_",$bid);
	}
	if(isset($_REQUEST["tId"])){
		$tId=$_REQUEST["tId"];
	}
	else{
		$tId=0;
	}
	if(isset($_REQUEST["inf_field_FirstName"])){
		$firstName=$_REQUEST["inf_field_FirstName"];
	}
	if(isset($_REQUEST["inf_field_LastName"])){
		$lastName=$_REQUEST["inf_field_LastName"];
	}
	if(isset($_REQUEST["inf_field_Email"])){
		$email=$_REQUEST["inf_field_Email"];
	}
	if(isset($_REQUEST["inf_field_Phone1"])){
		$number=$_REQUEST["inf_field_Phone1"];
	}
	if(isset($_REQUEST["inf_coupon_code"])){
		$coupoun_code = $_REQUEST["inf_coupon_code"];
	}
	$perc = 0;
	if($coupoun_code != ''){
		$is_coupon = 1;
		if($coupoun_code == 'FBSEP20OFF'){
			$perc = 20;
		}
		else if($coupoun_code == 'FBNOV30OFF'){
			$perc = 30;
		}
		else if($coupoun_code == 'FB20OFF'){
			$perc = 20;
		}
		else if($coupoun_code == 'REFERFRIEND'){
			$perc = 20;
		}
		else if($coupoun_code == 'G20OFF'){
			$perc = 20;
		}
		else if($coupoun_code == 'SLBMAR21'){
			$perc = 71;
		}
		else if($coupoun_code == 'COMBOOFFER'){
			$is_coupon = 0;
		}
		
	}
	
	//$LocationId="62539";
	$LocationId="62539";
  	if(isset($_REQUEST['location']) && !empty($_REQUEST['location'])){
  		$LocationId=base64_decode($_REQUEST['location']);
  	}
	
	$resp_data_billing = array();
	for($x = 1; $x <= 2; $x++) {
		$url_billing = 'https://api.au1.cliniko.com/v1/billable_items?page='.$x;
		$data = CurlCall($url_billing);
		$resp_code = $data['ResponseCode'];
		if($resp_code == 400){
			echo "Err.. Something went Wrong";
			exit;
		}
		$resp_data_billing[] = $data['ResponseData']['billable_items'];
	} 
	$rate_arr = array();
	foreach($resp_data_billing as $rb){
		foreach($rb as $r){
			$u = $r['links']['self'];
			$id = (int) filter_var($u, FILTER_SANITIZE_NUMBER_INT);
			$rate_arr[$id] = $r['price'];
		}
	}
	
?>

<!doctype html>
<html lang="en">
	<head>
		<title>Booking</title>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
			rel="stylesheet">
		<link rel="stylesheet" href="assets/css/new-style.css" />
		<link rel="stylesheet" href="assets/css/style.css" />
		<style>
			@media all and (max-width:575px)
			{
				.mr-4, .mx-4,
				.mr-3, .mx-3 {
					margin-right: 10px!important;
				}
			}
			
			/* 26-11-20 */
			section.testimonial-section
			{
				padding: 50px 0px 50px 0px;
				background-color: #fefefe;
			}
			section.testimonial-section p
			{
				font-style: italic;
				line-height: 1.8;
				font-size: 1rem;
				color: #000000;
				margin-bottom: 1rem;
				font-weight: 300;
			}
			.title-main h2
			{
				margin-bottom: 40px;
				font-size: 3.4375rem;
				font-weight: 300;
				color: #005baa;
				line-height: 1.2;
				text-align: center;
			}
			.title-main h2 span
			{
				font-weight: 700;
				color: #005baa;
				line-height: 1.2;
			}
			section.testimonial-section p span {
				font-size: 16px;
				font-style: normal;
				color: #005baa;
				font-weight: 700;
				display: block;
				text-align: center !important;
			}
			section.logo-section
			{
				padding: 0px 0px 50px 0px;
				background-color: #fff;
			}
			section.logo-section .img-main
			{
				padding-left: 0px ;
				margin-bottom:0 ;
				text-align: center;
			}
			section.logo-section .img-box
			{
				width: 156px;
				text-align: center;
				display: inline-block;
			}
			section.logo-section p {
				color: #005baa;
				font-size: 1.1rem;
				margin-bottom: 1rem;
				line-height: 1.6;
				text-align: center;
				font-weight: 700;
			}
			@media all and (max-width:1200px)
			{
				section.logo-section .img-box {
					width: 186px;
				}
			}
			@media all and (max-width:992px)
			{
				.large-mb-2{
					margin-bottom: 20px;
				}
			}
			@media all and (max-width:767px)
			{
				section.logo-section .img-box {
					width: 200px;
					margin-bottom:10px;
				}
				section.testimonial-section {
					padding: 25px 0px 25px 0px !important;
				}
				.title-main h2 {
					margin-bottom: 20px !important;
				}
			}
			@media all and (max-width:575px)
			{
				section.logo-section .img-box {
					width: 150px !important;
					margin-bottom: 10px;
				}
				section.testimonial-section {
					padding: 20px 0px 20px 0px !important;
				}
				.title-main h2 {
					font-size: 2rem !important;
				}
				.youtube iframe
				{
					height:200px !important;
				}
				.img-box img
				{
					width:80% !important;
				}
				section.logo-section {
					padding: 0px 0px 20px 0px !important;
				}
			}
		</style>
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
.popupleftbx { background-size: cover !important; background: url(../bookings3/images/exitpopup_bgimg.jpg) no-repeat; }
.exitpopup_cntbxpop{ text-align: center; color: #fff; padding: 50px 50px; font-family: 'Montserrat', sans-serif; }
.exitpopup_cntbxpop h2 { color: #fff; font-family: 'Montserrat', sans-serif;font-size:48px; line-height: 55px; font-weight: 700; margin-bottom: 0 }
.exitpopup_cntbxpop p { color: #fff; font-size: 15px; line-height: 23px; font-family: 'Montserrat', sans-serif; }
.book_freebxpop span > span {color: #f69751; font-size: 25px; line-height: 30px; font-weight: bold}
.book_freebxpop p { font-size: 17px; line-height: 21px; }
.popuprightbx { position: relative; background: #005caa }
.popuprightbx:before { content: "";position: absolute; left: 2px; top: 0; background: url('../bookings3/images/exitpopupbg-curvimg.png') no-repeat; width:35px; height: 100%; background-size: cover; }
.popuprightbx img { width: 100%; }
.popupterriimgcnt { position: absolute; right: 0; bottom: 10px; background: #005caa; color: #fff; text-align: center; padding: 7px 18px; }
.popupterriimgcnt h5 { font-weight: bold;font-size: 16px; line-height: 20px; margin-bottom: 0; font-family: 'Montserrat', sans-serif; }
.popupterriimgcnt span { font-size: 11px; line-height: 17px; display:block; vertical-align: top; text-align: right;font-family: 'Montserrat', sans-serif; font-weight:  400;  font-family: 'Montserrat', sans-serif;   }

.popupterriimgcnt p { color: #fff; font-size: 11px;line-height: 16px; margin: 0; padding: 0; text-align: right;font-family: 'Montserrat', sans-serif; }
.exitmodelpopup .modal-body { padding:0 !important}
.exitmodelpopup { padding: 0; height: auto; }

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
@media(max-width: 420px){
.exitpopup_cntbxpop { padding: 14px 0; }	
.exitpopup_cntbxpop p {font-size: 12px;line-height: 19px;}
.book_freebxpop p { font-size: 12px; line-height: 19px; }
.popuprightbx{ background: url('images/exitpopupterriimg.png') no-repeat; background-position: center center; background-size: cover  }
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
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-5TNSLT2');</script>
	</head>
	<body>
	<?php include 'noscript.php';  ?>

	<!-- header start -->

	
    <header>
        <div class="d-sm-none d-inline">
            <div class="contact-class text-center d-flex align-items-center justify-content-center">
                <div class="container">
                    <span class="white d-sm-inline d-none">Questions?</span> <i class="fa fa-phone ml-0"></i> <a
                        href="tel:+611300884348">1300 884 348</a>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="header-main justify-content-between">
                <div class="header-logo">
                    <img src="https://brainwellnessspa.com.au/wp-content/themes/brainwellnessspa/assets/images/header-logo.png"
                        class="img-fluid logo-main" alt="logo">
                </div>
                <div class="header-content ">
                    <div
                        class="contact-class inner align-items-center text-right justify-content-end d-sm-inline d-none">
                        <div class="container">
                            <span>Questions?</span> <i class="fa fa-phone"></i> <a href="tel:+611300884348">1300 884 348</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!--  -->

    <div class="page-banner">
        <div class="container">
            Book <b>Online</b>
        </div>
    </div>

    <!--  -->

	<!-- header end -->

	<div class="container">
		<div class="row mb-4">
	  		<div class="col-12">
			  <div id="wrapper">
					<i id="iPage1" class="fa fa-home baricon baricon-one has-tip active" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Step-1"></i>
					<span id="bar1" class="progress_bar"></span>
					<i id="iPage2" class="fa fa-calendar baricon baricon-two has-tip" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Step-2"></i>
					<span id="bar2" class="progress_bar"> </span>
					<i id="iPage3" class="fa fa-info baricon baricon-three has-tip" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Step-3"></i>
					<span id="bar3" class="progress_bar"></span>
					<i id="iPage4" class="fa fa-check baricon baricon-four has-tip" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Completed"></i>
				</div>
			</div>
			<?php
							if(isset($_GET['error'])){
						?>
						<div class="alert alert-danger" role="alert">
							Something went wrong. Try again later.
						</div>
						<?php	
							}
						?>
			<div class="col-12">
				<h3 class="mb-2 font-20 font-bold sub-heading" style="display: none;">Location</h3>
				<div class="inner-card" style="display: none;">
				<?php
					$url="https://api.au1.cliniko.com/v1/businesses";
					$data = CurlCall($url);
					$resp_code = $data['ResponseCode'];
					if($resp_code == 400){
						echo "Err.. Something went Wrong";
						exit;
					}
					$resp_data = $data['ResponseData']['businesses'];
					$i = 0; 		
					foreach ($resp_data as $data){
						if($data["id"] != 21743){
				?>
				<!-- form-group form-check -->
				<div class="select-location-section">
					<input type="radio" name="rdLocation[]" value="<?php echo $data["id"]?>" id="rdLocation_<?php echo $i;?>" class="form-check-input location" id="exampleCheck1" <?php if($data["id"] == $LocationId){echo "checked";} ?> >
					<label class="form-check-label font-14" for="rdLocation_<?php echo $i;?>"><?php echo $data["address_1"].",\n".$data["city"];?></label>
				</div>
				<?php
					$i++;
					}
					}
				?>
				</div>
				<h3 class="mb-1 font-20 font-bold sub-heading">Select a Service</h3>
				<p class="mb-3 color-80 mb-0 font-16" >This is an online appointment booking service. The appointment fees are payable at the end of your session. Payment can be made by cash or card.</p>
				<?php
					$url = 'https://api.au1.cliniko.com/v1/appointment_types';
					$data = CurlCallWithData($url,$arr,$bid);
					$resp_code = $data['ResponseCode'];
					if($resp_code == 400){
						echo "Err.. Something went Wrong";
						exit;
					}
					$resp_data = $data['ResponseData'];
					
					
				?>
				<div class="accordion" id="accordionExample">
					<?php
						$jk = 0;
						foreach($resp_data as $key => $value){
							if($key == "Blank"){
								$val = $value['Data'];
									foreach ($val as $k => $v){
										if($v != ""){
					?>
					<div class="card line-card">
						<div class="card-header" id="headingOne">
							<?php
								if($jk == 0){ $cls ='show'; $cls2 ='focus'; }else{ $cls =''; $cls2 =''; }
							?>
							<h2 class="mb-0">
								<button class="btn btn-link btn-block text-left p-0 font-18 font-bold <?php echo $cls2; ?>" type="button" data-toggle="collapse" data-target="#collapseOne<?php echo $m?>" aria-expanded="true" aria-controls="collapseOne<?php echo $m?>">
									<?php echo $key; ?>
								</button>
							</h2>
						</div>
						
						<div id="collapseOne<?php echo $m?>"  class="collapse <?php echo $cls; ?>" aria-labelledby="headingOne" data-parent="#accordionExample">
							<div class="card-body">
								<ul class="list-group">
								  
								<?php
									$val = $value['Data'];
									foreach($val as $k => $v){
										if($v['id'] == 214641){
											continue;
										}
										$u = $v['billable_item']['links']['self'];
										$id = (int) filter_var($u, FILTER_SANITIZE_NUMBER_INT);
										
								?>
								<li class="list-group-item outer-li">
									<div class=" align-items-center inner-li d-flex justify-content-between">
										<div class="d-flex align-items-top">
											<i class="fa fa-chevron-right mr-2 color-black font-15 pt-0"></i>
											<p class="color-80 mb-0 font-16 mr-3">
												<?php echo $v["name"]; ?>
											</p>
										</div>
										
										<div class="">
											<div class="d-sm-inline d-none">
												<div class="align-items-center d-flex">
													<?php
														if(!empty($v['description'])){
													?>
													<a class="border-button more-all btn font-14 mr-4 color-80" data-toggle="collapse" href="#collapseExample<?php echo $v['id']; ?>" role="button" aria-expanded="false" aria-controls="collapseExample<?php echo $v['id']; ?>">
														<span class="more-info">More Info <i class="fa fa-chevron-down ml-1"></i></span>
														<span class="d-none less-info">Less Info <i class="fa fa-chevron-up ml-1"></i></span>
													</a>
													<?php } ?>
													<?php
														$rate = 0;
														if(array_key_exists($id,$rate_arr)){
															if($is_coupon == 1){
																$rate = ($rate_arr[$id]*1.1);	
																
																$rate2=$rate;
																$rate = round($rate-$perc);
													?>
														<span class="font-16 color-80 mr-4 font-bold"><span style="text-decoration:line-through;font-weight: normal;" >$<?php echo number_format($rate2); ?></span> $<?php echo number_format($rate); ?> </span> 
													<?php					
															}
															else{
																$rate = round($rate_arr[$id]*1.1);
																$rate2=0;
													?>
														<span class="font-16 color-80 mr-4 font-bold"> $<?php echo number_format($rate); ?> </span> 
													<?php	
															}
															
													?>
														
													<?php
															
														}
													?>
														
														<span class="font-16 color-80 mr-4 mins-session"><?php echo $v['duration_in_minutes']." Mins";?></span>
													<button type="button" data-rate="<?php echo $rate; ?>" data-rate2="<?php echo $rate2; ?>"  data-name="<?php echo $v["name"]; ?>" data-id="<?php echo $v["id"];?>" class="btn btn-orange pull-right font-16 font-semibold">select</button>
												</div>
											</div>
											<div class="d-sm-none d-inline">
												<div class="align-items-center d-flex small-d-block">
													<?php
														if(!empty($v['description'])){
													?>
													<?php } ?>
													<div class="w-100 d-flex align-items-center sm-mb-4">
														<?php
															$rate = 0;
															if(array_key_exists($id,$rate_arr)){
																if($is_coupon == 1){
																	$rate = ($rate_arr[$id]*1.1);	
																	
																	$rate2=$rate;
																	$rate = round($rate-$perc);
														?>
														<span class="font-16 color-80 mr-4 font-bold"><span style="text-decoration:line-through;font-weight: normal;" >$<?php echo number_format($rate2); ?></span> $<?php echo number_format($rate); ?> </span> 
													<?php					
															}
															else{
																$rate = round($rate_arr[$id]*1.1);
																$rate2=0;
													?>
														<span class="font-16 color-80 mr-4 font-bold"> $<?php echo number_format($rate); ?> </span> 
													<?php	
																}	
																
														
																
															}
														?>
														<span class="font-16 color-80 mr-4 mins-session"><?php echo $v['duration_in_minutes']." Mins";?></span>
													</div>
													<div class="w-100 d-flex align-items-center">
														<?php
															if(!empty($v['description'])){
														?>
														<a class="border-button more-all btn font-14 mr-4 color-80" data-toggle="collapse" href="#collapseExample<?php echo $v['id']; ?>" role="button" aria-expanded="false" aria-controls="collapseExample<?php echo $v['id']; ?>">
															<span class="more-info">More Info <i class="fa fa-chevron-down ml-1"></i></span>
															<span class="d-none less-info">Less Info <i class="fa fa-chevron-up ml-1"></i></span>
														</a>
														<?php } ?>
														<button type="button" data-rate2="<?php echo $rate2; ?>" data-rate="<?php echo $rate; ?>"  data-name="<?php echo $v["name"]; ?>" data-id="<?php echo $v["id"];?>" class="btn btn-orange pull-right font-16 font-semibold">select</button>
													</div>
												</div>
											</div>
										</div>
									</li>
									<?php
											if(!empty($v['description'])){
										?>
										<div class="collapse" id="collapseExample<?php echo $v['id']; ?>">
										  <div class="card card-body inner-card-body font-16 color-80">
											<?php echo $v['description']; ?>
										  </div>
										</div>
										<?php } ?>
								<?php	
									}	
								?>
								</ul>
							</div>
						</div>
					</div>
					
					<?php
						
												}
											$p++;
									}
							}
							else{
								$m++;
					?>
					<div class="card line-card">
						<?php
							if($jk == 0){ $cls ='show'; $cls2 ='focus'; }else{ $cls =''; $cls2 =''; }
						?>
						<div class="card-header" id="headingOne">
							<h2 class="mb-0">
								<button class="btn btn-link btn-block toggle-card text-left font-18 font-bold <?php echo $cls2; ?> " type="button" data-toggle="collapse" data-target="#collapseOne<?php echo $m?>" aria-expanded="true" aria-controls="collapseOne<?php echo $m?>">
									<?php echo $key; ?>
								</button>
							</h2>
						</div>
						
						<div id="collapseOne<?php echo $m?>" class="collapse <?php echo $cls; ?>" aria-labelledby="headingOne" data-parent="#accordionExample">
							<div class="card-body">
								<ul class="list-group">
								  
								<?php
									$val = $value['Data'];
									foreach($val as $k => $v){
										if($v['id'] == 214641){
											continue;
										}
										$u = $v['billable_item']['links']['self'];
										$id = (int) filter_var($u, FILTER_SANITIZE_NUMBER_INT);
								?>
									<li class="list-group-item outer-li">
										<div class="align-items-center inner-li d-flex justify-content-between">
										<div class="d-flex align-items-top md-mb-2">
											<i class="fa fa-chevron-right mr-2 color-black font-15 pt-0"></i>
											<p class="color-80 mb-0 font-16 mr-3">
												<?php echo $v["name"]; ?>
											</p>
										</div>
										<div class="">
											<div class="d-sm-inline d-none">
												<div class="align-items-center d-flex">
													<?php
														if(!empty($v['description'])){
													?>
													<a class="border-button more-all btn font-14 mr-4 color-80" data-toggle="collapse" href="#collapseExample<?php echo $v['id']; ?>" role="button" aria-expanded="false" aria-controls="collapseExample<?php echo $v['id']; ?>">
														<span class="more-info">More Info <i class="fa fa-chevron-down ml-1"></i></span>
														<span class="d-none less-info">Less Info <i class="fa fa-chevron-up ml-1"></i></span>
													</a>
													<?php } ?>
														<?php
																$rate = 0;
															if(array_key_exists($id,$rate_arr)){
																
																if($is_coupon == 1){
																	$rate = ($rate_arr[$id]*1.1);	
																	
																	$rate2=$rate;
																	$rate = round($rate-$perc);
																?>
														<span class="font-16 color-80 mr-4 font-bold"><span style="text-decoration:line-through;font-weight: normal;" >$<?php echo number_format($rate2); ?></span> $<?php echo number_format($rate); ?> </span> 
													<?php					
															}
															else{
																$rate = round($rate_arr[$id]*1.1);
																$rate2=0;
													?>
														<span class="font-16 color-80 mr-4 font-bold"> $<?php echo number_format($rate); ?> </span> 
													<?php	
																}
														
																
															}
														?>
														<span class="font-16 color-80 mr-4 mins-session"><?php echo $v['duration_in_minutes']." Mins";?></span>
													<button type="button" data-rate2="<?php echo $rate2; ?>" data-rate="<?php echo $rate; ?>"  data-name="<?php echo $v["name"]; ?>" data-id="<?php echo $v["id"];?>" class="btn btn-orange pull-right font-16 font-semibold">select</button>
												</div>
											</div>
											<div class="d-sm-none d-inline">
												<div class="align-items-center d-flex small-d-block">
													<?php
														if(!empty($v['description'])){
													?>
													<?php } ?>
													<div class="w-100 d-flex align-items-center sm-mb-4">
														<?php
																$rate = 0;
															if(array_key_exists($id,$rate_arr)){
																
																if($is_coupon == 1){
																	$rate = ($rate_arr[$id]*1.1);	
																	
																	$rate2=$rate;
																	$rate = round($rate-$perc);
																?>
														<span class="font-16 color-80 mr-4 font-bold"><span style="text-decoration:line-through;font-weight: normal;" >$<?php echo number_format($rate2); ?></span> $<?php echo number_format($rate); ?> </span> 
													<?php					
															}
															else{
																$rate = round($rate_arr[$id]*1.1);
																$rate2=0;
													?>
														<span class="font-16 color-80 mr-4 font-bold"> $<?php echo number_format($rate); ?> </span> 
													<?php	
																}	
														
															}
														?>
														<span class="font-16 color-80 mr-4 mins-session"><?php echo $v['duration_in_minutes']." Mins";?></span>
													</div>
													<div class="w-100 d-flex align-items-center">
														<?php
															if(!empty($v['description'])){
														?>
														<a class="border-button more-all btn font-14 mr-4 color-80" data-toggle="collapse" href="#collapseExample<?php echo $v['id']; ?>" role="button" aria-expanded="false" aria-controls="collapseExample<?php echo $v['id']; ?>">
															<span class="more-info">More Info <i class="fa fa-chevron-down ml-1"></i></span>
															<span class="d-none less-info">Less Info <i class="fa fa-chevron-up ml-1"></i></span>
														</a>
														<?php } ?>
														<button type="button" data-rate2="<?php echo $rate2; ?>" data-rate="<?php echo $rate; ?>" data-name="<?php echo $v["name"]; ?>" data-id="<?php echo $v["id"];?>" class="btn btn-orange pull-right font-16 font-semibold">select</button>
													</div>
												</div>
											</div>
										</div>
									</li>
									<?php
											if(!empty($v['description'])){
										?>
										<div class="collapse" id="collapseExample<?php echo $v['id']; ?>">
										  <div class="card card-body inner-card-body font-16 color-80">
											<?php echo $v['description']; ?>
										  </div>
										</div>
										<?php } ?>
								<?php	
									}	
								?>
								</ul>
							</div>
						</div>
					</div>
					<?php		
							}	
							$jk++;
						}
					?>
				</div>
		</div>
		
		<?php
			if($bid != ''){
		?>	
		<div class="col-12 mb-5">
			<a href="index.php?bId=&inf_field_FirstName=<?php echo $_REQUEST['inf_field_FirstName']?>&inf_field_Email=<?php echo $_REQUEST['inf_field_Email'] ?>&inf_field_Phone1=<?php echo $_REQUEST['inf_field_Phone1']?>&inf_coupoun_code=<?php echo $_REQUEST['inf_coupoun_code']?>" class="btn float-right btn-outline-primary">For More Services</a>
		</div>
		
		<?php
		}
		?>
		
	</div>
	
	<!-- <p style="text-align: center;">
		<span>
			<a href="tel:+1300 874 752"> <strong style="color:#005baa;">We are currently matching health care rebates. Save up to $550. Talk to us</strong></a>
		</span>
	</p> -->
	
	</div>
	
    <!-- Testional start -->
    
    <section class="testimonial-section">
        <div class="container">
            <div class="title-main">
                <!-- <h2>Listen to Rebecca’s <span>Transformation</span></h2> -->
                <h2>Know More <span>About Us</span></h2>
            </div>
            <div class="row">
                <div class="col-lg-6 large-mb-2">
                    <!-- <div class="youtube" data-embed="r-afP4CZA-w">
                        <iframe width="100%" height="280" src="https://www.youtube.com/embed/YNd-pnPpfFo" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div> -->
                    <div class="youtube bookyoutubefirst" data-embed="r-afP4CZA-w">
                        <iframe width="100%" height="280" src="https://www.youtube.com/embed/b5V-Avsyh3M" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <div>
                    	<p><strong>Get a sense of what you'll Experience at the Brain Wellness Spa</strong></p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="youtube" data-embed="r-afP4CZA-w">
                        <iframe width="100%" height="280" src="https://www.youtube.com/embed/_lZg7Emg9yc" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <div>
                    	<p><strong>Hear why these people are raving about the Brain Wellness Spa</strong></p>
                    </div>
                </div>
                
            </div>
            
        </div>
	</section>
	
	<!--  -->

	<section class="logo-section">
        <div class="container">
			<p>As Seen In:</p>
			<div class="img-main">
				<div class="img-box"><img src="assets/image/slider-1.png"></div>
				<div class="img-box"><img src="assets/image/slider-2.png"></div>
				<div class="img-box"><img src="assets/image/slider-3.png"></div>
				<div class="img-box"><img src="assets/image/slider-4.png"></div>
				<div class="img-box"><img src="assets/image/slider-5.png"></div>
				<div class="img-box"><img src="assets/image/slider-6.png"></div>
				<div class="img-box"><img src="assets/image/slider-7.png"></div>
			</div>
		</div>
	</section>

<!-- footer start -->
    
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 lg-mb-4">
                    <div class="footer-data text-large-center">
                        <img src="https://brainwellnessspa.com.au/wp-content/themes/brainwellnessspa/assets/images/footer-logo.png"
                            class="img-fluid footer-logo" alt="logo">
                    </div>
                </div>

                <div class="col-xl-9 col-lg-9  col-md-12 col-sm-12 md-mb-8 footertext">
					<p><?php echo "Brain Wellness Spa provides an alternative approach to the provision of mental health services that aim to improve the quality of the lives of our clients. We are currently matching health care rebates. Take control of your life & get on the pathway towards better mental health & happier life. Using our natural technique, our programs may help you find relief from mental health issues, such as; anxiety, depression, insomnia, anger, and PTSD."; ?></p>
					<div class="footer_boxmain">

						<div class="fttwocol">
						    <i class="fa fa-map-marker" style="margin-right: 10px;"></i><strong>Stirling Clinic</strong><br>
							<span style="margin-left:20px;">15-51 Cedric Street. Stirling. 6021 WA.</span>
						</div>
						<div class="fttwocol">
						    <i class="fa fa-phone" style="margin-right: 10px;"></i><strong>Phone Number</strong><br><span style="margin-left:20px;">1300 874 693</span>
						</div>
					</div>
				</div>
                <!-- <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 md-mb-4">
                    <div class="footer-data address">
                        <ul>
                            <li>
                                <div class="d-inline-block text-center w-100">
                                    <div class="d-block">
                                        <i class="fa fa-map-marker"></i>
                                    </div>
                                    <div class="span">
                                        <p class="heading">South Perth Clinic</p>
                                        <span>25 Lyall Street<br>South Perth 6151 WA</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div> -->
                <!-- <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12 md-mb-4">
                    <div class="footer-data address">
                        <ul>
                            <li>
                                <div class="d-inline-block text-center w-100">
                                    <div class="d-block">
                                        <i class="fa fa-map-marker"></i>
                                    </div>
                                    <div class="span">
                                        <p class="heading">Stirling Clinic</p>
                                        <span>15-51 Cedric Street<br>Stirling 6021 WA</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-4 col-sm-12">
                    <div class="footer-data address">
                        <ul>
                            <li>
                                <div class="d-inline-block text-center w-100">
                                    <div class="d-block">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <div class="span">
                                        <p class="heading">Phone Number</p>
                                        <span><a href="tel:1300 884 348" class="text-white">1300 884 348</a></span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div> -->
            </div>
            
           
        </div>
    </footer>

    <!--  -->

    <div class="footer-bottom-content ">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="text-center">
                        The Brain Wellness Spa offers a unique, alternative and drug free method created by our founder
                        Terri Bowman aimed to assist people encountering struggles in their daily lives, to find inner
                        peace and overcome negative thoughts and emotions (the BWS Method). The BWS Method is not a
                        scientific method. The testimonials of our clients speak for themselves and we are so proud of
                        the incredible results they have achieved – we want to help you and are committed to assisting
                        you find a way to live a better life. However, as with any service, we accept that it may not be
                        right for everyone and that results may vary from client to client. Accordingly, we make no
                        promises or representations that our service will work for you but we invite you to try it for
                        yourself. <br>If you were a client at the Brain Wellness Spa between 20 March 2019 and 13 March
                        2020 and you consider that you were misled by any statement published on the Brain Wellness Spa
                        or Quantum Neuro Recoding websites in relation to the services Brain Wellness Spa represented
                        that it could provide and/or the result that Brain Wellness Spa claimed to be able to achieve,
                        please contact terri@brainwellnessspa.com.au to discuss obtaining a refund for services
                        received.
                    </div>
                </div>
                <div class="col-12">
                    <div class="text-center">
                        <ul>
                            <li>
                                © Brain Wellness Spa ™ | Website By <a target="_blank" href="https://www.qltech.com.au/" class="title-color font-regular">QL Tech</a>
                            </li>
                            <li>
                                *Based upon a client self-assessment survey, results may vary from person to person
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
	</div>

		<!--  -->
		
		<div class="modal fade " id="select_modal" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title font-22" id="exampleModalLongTitle">NOTE</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p class="font-20 font-regular mb-1">
					Your initial appointment fee of <span>$220</span> is payable at the end of your session. Payment can be made by cash or card.
					</p>
					<div class="text-right">
						<button class="main-select-button font-18" type="button">Proceed</button>
					</div>
				</div>
				</div>
			</div>
		</div>
		
		<div id="loder"></div>
	<form method="POST" id="form" action="practitioner.php" >
		<input type="hidden" name="txtFirstName" id="txtFirstName" class="form-control" value="<?php echo $firstName; ?>"/>
		<input type="hidden" name="txtLastName" id="txtLastName" class="form-control" value="<?php echo $lastName; ?>"/>
		<input type="hidden" name="txtEmail" id="txtEmail" class="form-control" value="<?php echo $email; ?>"/>
		<input type="hidden" name="txtNumber" id="txtNumber" class="form-control" value="<?php echo $number; ?>"/>
		<input type="hidden" name="txtcoupouncode" id="txtcoupouncode" class="form-control" value="<?php echo $coupoun_code; ?>"/>
		<input type="hidden" name="bId" id="bid" class="form-control" value="<?php echo $bid; ?>"/>
		<input type="hidden" name="businessId" id="location" class="form-control" value="<?php echo $bid; ?>"/>
		<input type="hidden" name="id" id="sid" class="form-control" value="0"/>
		<input type="hidden" name="sname" id="sname" class="form-control" value=""/>
		<input type="hidden" name="srate" id="srate" class="form-control" value=""/>
		<input type="hidden" name="srate2" id="srate2" class="form-control" value=""/>
		<input type="hidden" name="pid" id="pid" class="form-control" value="any"/>
		<input type="hidden" name="utm_campaign" id="utm_campaign" class="form-control" value="<?php echo $_REQUEST["utm_campaign"]; ?>"/>
		<input type="hidden" name="utm_source" id="utm_source" class="form-control" value="<?php echo $_REQUEST["utm_source"]; ?>"/>
		<input type="hidden" name="utm_medium" id="utm_medium" class="form-control" value="<?php echo $_REQUEST["utm_medium"]; ?>"/>
		<input type="hidden" name="utm_term" id="utm_term" class="form-control" value="<?php echo $_REQUEST["utm_term"]; ?>"/>
		<input type="hidden" name="utm_content" id="utm_content" class="form-control" value="<?php echo $_REQUEST["utm_content"]; ?>"/>
		<input type="hidden" name="source" id="source" class="form-control" value="<?php echo $_REQUEST["source"]; ?>"/>
	</form>

	<script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js" ></script>
    <script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/main.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script>

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ouibounce/0.0.11/ouibounce.min.js"></script>

<script>
    
$(document).ready(function() {
	
    
        $('body').prepend('<div id="ouibounce-modal"><div class="overlay"></div><div class="popup exitmodelpopup"> <a class="closePopupCross">×</a><div class="modal-content"><div class="modal-body p-0"><div class="row row-no-gutters"><div class="col-lg-7 col-md-7 col-sm-6 col-6 p-0 popupleftbx"><div class="exitpopup_cntbxpop"><h2>NEED HELP</h2><p>to Improve Your Well-Being and Reclaim Your Quality of Life?</p><div class="book_freebxpop"> <span>Book a <span>25 Mins FREE</span> </span><p>Telehealth Consultation with Terri Bowman</p></div><div class="bookfreebtn"><a href="https://brainwellnessspa.zohobookings.com.au/#/customer/1597000000035035" class="btn-book orgbtn" target="_blank">Yes<span>I need to change my life </span></a><a class="btn-book" id="closeLeavePage">No<span>I m in perfect health </span></a></div></div></div><div class="col-lg-5 col-md-5 col-sm-6 col-6 p-0 popuprightbx"> <img src="images/exitpopupterriimg.png" alt=""class="desktopimgpop" /><div class="popupterriimgcnt"><h5>Terri Bowman</h5> <span>Director and</span><p> Creator of Positive <br /> Auditory Stimuli Technique</p></div></div></div></div></div></div></div>');

        $('.closePopupLink, #closeLeavePage, .overlay , .closePopupCross').click(function() {
            $('.overlay, .popup').fadeOut(500);
        });
  
        
  
        /*var _ouibounce = ouibounce(document.getElementById('ouibounce-modal'), {
        	aggressive: true,
        	timer: 0,
        	callback: function() { console.log('ouibounce fired!'); }
      	});*/

      	/*juts uncomment this line after setting the image*/
      	$('#ouibounce-modal').delay(20000).fadeIn('slow');
});

</script>
	
	<script>
		$(window).bind("pageshow", function(event) {
			if (event.originalEvent.persisted) {
				$("#loder").hide();
			}
		});
		
		$('body').on('click', '.btn-orange', function() {
			var id = $(this).attr('data-id');
			var name = $(this).attr('data-name');
			var rate = $(this).attr('data-rate');
			var rate2 = $(this).attr('data-rate2');
			$("#sid").val(id);
			$("#sname").val(name);
			$("#srate").val(rate);
			$("#srate2").val(rate2);
			if($(".location:checked").length != 0){
				$("#location").val($(".location:checked").val());
			}
			if( id == 87561){
				$('#select_modal').modal('show');
			}
			else if( id == 91627){
				$('#select_modal').modal('show');
			}
			else{
				$("#loder").show();
				document.getElementById("form").submit();
			}	
		});
		$('body').on('click', '.main-select-button', function() {
			$('#select_modal').modal('hide');
			$("#loder").show();
			document.getElementById("form").submit();
		});
		Cookies.set('ANY', '0');
		
				
	</script>
	<script>   
		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		})
	</script>
	<script>    
		$('.toggle-card').on('click', function(e) {
			$(this).toggleClass("focus"); 
			$(".toggle-card").not(this).removeClass('focus');
		});
	</script>
	<script>   
		$('.more-all').on('click', function () {
			$(this).find('.more-info').toggleClass('d-none');
			$(this).find('.less-info').toggleClass('d-inline');
		});
	</script>
	</body>
</html>