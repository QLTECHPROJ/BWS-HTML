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
	
	if($coupoun_code != '' && $coupoun_code == 'FBSEP20OFF'){
		$is_coupon = 1;
	}
	
	
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
		<link rel="stylesheet" href="assets/css/style.css" />
		<style>
			@media all and (max-width:575px)
			{
				.mr-4, .mx-4,
				.mr-3, .mx-3 {
					margin-right: 10px!important;
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
.exitpopup_cntbxpop {  padding: 20px 10px;}
.exitmodelpopup { height: 70%; overflow-y: scroll; overflow-x: hidden; }	
.popuprightbx:before { display: none }
.popup .closePopupCross { right: 0 }
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
	<header>
		<div class="container">
			<div class="header-data">
				<div class="row align-items-center">
					<div class="col-md-6">
						<div class="header-logo">
							<img src="assets/image/logo.png" class="img-fluid" alt="">
						</div>
					</div>
					<div class="col-md-6">
						<div class="header-content section-heading-5">
							<h5 class="font-26">CALL 24/7<a href="tel:1300874693" class="font-26">1300 874 693</a></h5>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
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
				<h3 class="mb-2 font-20 font-regular Helvetica">Select a Location</h3>
				<div class="inner-card">
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
				?>
				<!-- form-group form-check -->
				<div class="select-location-section">
					<input type="radio" name="rdLocation[]" value="<?php echo $data["id"]?>" id="rdLocation_<?php echo $i;?>" class="form-check-input location" id="exampleCheck1" <?php if($data["id"] == $LocationId){echo "checked";} ?> >
					<label class="form-check-label font-14" for="rdLocation_<?php echo $i;?>"><?php echo $data["address_1"].",\n".$data["city"];?></label>
				</div>
				<?php
					$i++;
					}
				?>
				</div>
				<h3 class="mb-1 font-20 font-regular Helvetica">Select a Service</h3>
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
							<h2 class="mb-0 font-16">
								<button class="btn btn-link btn-block text-left p-0 font-16 <?php echo $cls2; ?>" type="button" data-toggle="collapse" data-target="#collapseOne<?php echo $m?>" aria-expanded="true" aria-controls="collapseOne<?php echo $m?>">
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
											<i class="fa fa-chevron-right mr-2 color-80 font-11 pt-1"></i>
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
																$perc = 20;
																$rate2=$rate;
																$rate = round($rate-$perc);
													?>
														<span class="font-18 color-80 mr-4 font-bold"><span style="text-decoration:line-through;font-weight: normal;" >$<?php echo number_format($rate2); ?></span> $<?php echo number_format($rate); ?> </span> 
													<?php					
															}
															else{
																$rate = round($rate_arr[$id]*1.1);
																$rate2=0;
													?>
														<span class="font-18 color-80 mr-4 font-bold"> $<?php echo number_format($rate); ?> </span> 
													<?php	
															}
															
													?>
														
													<?php
															
														}
													?>
														
														<span class="font-18 color-80 mr-4 mins-session"><?php echo $v['duration_in_minutes']." Mins";?></span>
													<button type="button" data-rate="<?php echo $rate; ?>" data-rate2="<?php echo $rate2; ?>"  data-name="<?php echo $v["name"]; ?>" data-id="<?php echo $v["id"];?>" class="btn btn-select btn-select pull-right font-16 font-semibold">select</button>
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
																	$perc = 20;
																	$rate2=$rate;
																	$rate = round($rate-$perc);
														?>
														<span class="font-18 color-80 mr-4 font-bold"><span style="text-decoration:line-through;font-weight: normal;" >$<?php echo number_format($rate2); ?></span> $<?php echo number_format($rate); ?> </span> 
													<?php					
															}
															else{
																$rate = round($rate_arr[$id]*1.1);
																$rate2=0;
													?>
														<span class="font-18 color-80 mr-4 font-bold"> $<?php echo number_format($rate); ?> </span> 
													<?php	
																}	
																
														
																
															}
														?>
														<span class="font-18 color-80 mr-4 mins-session"><?php echo $v['duration_in_minutes']." Mins";?></span>
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
														<button type="button" data-rate2="<?php echo $rate2; ?>" data-rate="<?php echo $rate; ?>"  data-name="<?php echo $v["name"]; ?>" data-id="<?php echo $v["id"];?>" class="btn btn-select btn-select pull-right font-16 font-semibold">select</button>
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
							<h2 class="mb-0 font-16">
								<button class="btn btn-link btn-block toggle-card text-left <?php echo $cls2; ?> font-16" type="button" data-toggle="collapse" data-target="#collapseOne<?php echo $m?>" aria-expanded="true" aria-controls="collapseOne<?php echo $m?>">
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
											<i class="fa fa-chevron-right mr-2 color-80 font-11 pt-1"></i>
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
																	$perc = 20;
																	$rate2=$rate;
																	$rate = round($rate-$perc);
																?>
														<span class="font-18 color-80 mr-4 font-bold"><span style="text-decoration:line-through;font-weight: normal;" >$<?php echo number_format($rate2); ?></span> $<?php echo number_format($rate); ?> </span> 
													<?php					
															}
															else{
																$rate = round($rate_arr[$id]*1.1);
																$rate2=0;
													?>
														<span class="font-18 color-80 mr-4 font-bold"> $<?php echo number_format($rate); ?> </span> 
													<?php	
																}
														
																
															}
														?>
														<span class="font-18 color-80 mr-4 mins-session"><?php echo $v['duration_in_minutes']." Mins";?></span>
													<button type="button" data-rate2="<?php echo $rate2; ?>" data-rate="<?php echo $rate; ?>"  data-name="<?php echo $v["name"]; ?>" data-id="<?php echo $v["id"];?>" class="btn btn-select btn-select pull-right font-16 font-semibold">select</button>
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
																	$perc = 20;
																	$rate2=$rate;
																	$rate = round($rate-$perc);
																?>
														<span class="font-18 color-80 mr-4 font-bold"><span style="text-decoration:line-through;font-weight: normal;" >$<?php echo number_format($rate2); ?></span> $<?php echo number_format($rate); ?> </span> 
													<?php					
															}
															else{
																$rate = round($rate_arr[$id]*1.1);
																$rate2=0;
													?>
														<span class="font-18 color-80 mr-4 font-bold"> $<?php echo number_format($rate); ?> </span> 
													<?php	
																}	
														
															}
														?>
														<span class="font-18 color-80 mr-4 mins-session"><?php echo $v['duration_in_minutes']." Mins";?></span>
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
														<button type="button" data-rate2="<?php echo $rate2; ?>" data-rate="<?php echo $rate; ?>" data-name="<?php echo $v["name"]; ?>" data-id="<?php echo $v["id"];?>" class="btn btn-select btn-select pull-right font-16 font-semibold">select</button>
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
	
	
	</div>

	<footer>
		<div class="container">
			<div class="footer-data">
				<div class="row align-items-center">
					<div class="col-md-6">
						<div class="footer-logo">
							<img src="assets/image/logo.png" class="img-fluid" alt="">
						</div>
					</div>
					<div class="col-md-6">
						<div class="footer-content section-heading-5">
							<h5 class="font-26">CALL 24/7<a href="tel:1300874693" class="font-26">1300 874 693</a></h5>
						</div>
					</div>
				</div>
			</div>
			<hr class="hr-main">
			<div class="footer-main-data">
				<p class="text-right font-16 text-white"><i class="fa fa-map-marker"></i> 25 Lyall Street, South Perth, 6151 WA
				</p>
				<div class="row mt-top">
					<div class="col-md-8">
						<p class="text-left font-16 text-white mb-4">© 2020 Brain Wellness Spa. | Powered by QL Tech *Results may
							vary
							from
							person to person</p>
					</div>
					<div class="col-md-4">
						<ul class="text-right">
							<li><a href="https://www.facebook.com/brainwellnessspa/" target="_blank"><i class="fa fa-facebook font-20"></i></a></li>
							<li><a href="https://www.instagram.com/brainwellnessspa/" target="_blank"><i class="fa fa-instagram font-20"></i></a></li>
							<li><a href="https://twitter.com/brainhealthspa?lang=en" target="_blank"><i class="fa fa-twitter font-20"></i></a></li>
						</ul>
					</div>
				</div>

			</div>
		</div>
	</footer>
	<div class="container">
            <div class="row footer-bottom-content ">
                <div class="col-12">
                    <div class="row mb-4">
                        <div class="col-12 text-center font-13">
							The Brain Wellness Spa offers a unique, alternative and drug free method created by our founder Terri Bowman aimed to assist people encountering struggles in their daily lives, to find inner peace and overcome negative thoughts and emotions (the BWS Method).  The BWS Method is not a scientific method.  The testimonials of our clients speak for themselves and we are so proud of the incredible results they have achieved – we want to help you and are committed to assisting you find a way to live a better life. However, as with any service, we accept that it may not be right for everyone and that results may vary from client to client. Accordingly, we make no promises or representations that our service will work for you but we invite you to try it for yourself.
						</div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <ul>
                                <li class="font-16">
                                    © Brain Wellness Spa ™
                                </li>
                                <li class="font-16">
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
	
    
        $('body').prepend('<div id="ouibounce-modal"><div class="overlay"></div><div class="popup exitmodelpopup"> <a class="closePopupCross">×</a><div class="modal-content"><div class="modal-body p-0"><div class="row row-no-gutters"><div class="col-lg-7 col-md-7 col-sm-6 p-0 popupleftbx"><div class="exitpopup_cntbxpop"><h2>NEED HELP</h2><p>to Improve Your Well-Being and Reclaim Your Quality of Life?</p><div class="book_freebxpop"> <span>Book a <span>15 Mins FREE</span> </span><p>Telehealth Consultation with Terri Bowman</p></div><div class="bookfreebtn"><a href="https://brainwellnessspa.zohobookings.com.au/#/customer/1597000000035035" class="btn-book orgbtn" target="_blank">Yes<span>I need to change my life </span></a><a class="btn-book" id="closeLeavePage">No<span>I m in perfect health </span></a></div></div></div><div class="col-lg-5 col-md-5 col-sm-6 p-0 popuprightbx"> <img src="images/exitpopupterriimg.png" alt="" /><div class="popupterriimgcnt"><h5>Terri Bowman</h5> <span>Chief Facilitator</span><p> Creator of Positive <br /> Auditory Stimuli Technique</p></div></div></div></div></div></div></div>');

        $('.closePopupLink, #closeLeavePage, .overlay , .closePopupCross').click(function() {
            $('.overlay, .popup').fadeOut(500);
        });
  
        
  
        /*var _ouibounce = ouibounce(document.getElementById('ouibounce-modal'), {
        	aggressive: true,
        	timer: 0,
        	callback: function() { console.log('ouibounce fired!'); }
      	});*/

      	$('#ouibounce-modal').delay(20000).fadeIn('slow');
});

</script>
	
	<script>
		$(window).bind("pageshow", function(event) {
			if (event.originalEvent.persisted) {
				$("#loder").hide();
			}
		});
		
		$('body').on('click', '.btn-select', function() {
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