<?php
	include('inc.php');
	include('config.php');
	header("Cache-Control: max-age=9000, must-revalidate"); 
	
	if(!isset($_POST['businessId'])){
		echo "<script>window.location = 'services.php?error=1';</script>";
		exit;
	}

	
	if (isset($_POST["id"])) {
		$appointmentId = $_POST["id"];
    } 
	if (isset($_REQUEST["month"])) {
		$month = $_REQUEST["month"];
		$year = $_REQUEST["year"];
	} else {
		$month = date("m");
		$year = date("Y");
	}
	$businessId=$_POST["businessId"];
	if(isset($_POST["firstName"])) {
		$firstName = $_POST["firstName"];
	}
	if(isset($_POST["txtFirstName"])) {
		$firstName = $_POST["txtFirstName"];
	}
	if(isset($_POST["lastName"])) {
		$lastName = $_POST["lastName"];
	}
	if(isset($_POST["txtLastName"])) {
		$lastName = $_POST["txtLastName"];
	}
	if(isset($_POST["email"])) {
		$email = $_POST["email"];
	}
	if(isset($_POST["txtEmail"])) {
		$email = $_POST["txtEmail"];
	}
	if(isset($_POST["number"])) {
		$number = $_POST["number"];
	}
	if(isset($_POST["txtNumber"])) {
		$number = $_POST["txtNumber"];
	}
	if(isset($_POST["txtNumber"])) {
		$number = $_POST["txtNumber"];
	}
	if(isset($_POST["tId"])){
		$txtTime=$_POST["tId"];
	}
	if(isset($_POST["txtcoupouncode"])){
		$coupoun_code = $_POST["txtcoupouncode"];
	}

	//for the default practitioner code//

	$select_quey = mysqli_query($conn_back,"SELECT partcinoer_id,parctioner_first_name,parctioner_last_name FROM practioner WHERE pract_default_status = 'Yes' ORDER BY id DESC Limit 1");
	$row_query = mysqli_fetch_assoc($select_quey);

	$partcinoer_id = $row_query['partcinoer_id'];
	$parctioner_first_name = $row_query['parctioner_first_name'];
	$parctioner_last_name = $row_query['parctioner_last_name'];

	/*end of default practitioner code*/
	
	$ua="AEDT";
	$utc = new DateTimeZone($ua);
	$perth= new DateTimeZone('Australia/Perth');
	$pid =  $_POST["pid"];
	$url = 'https://api.au1.cliniko.com/v1/businesses/'.$businessId.'/practitioners';
	$data = CurlCall($url);
	$resp_code = $data['ResponseCode'];
	if($resp_code == 400){
		echo "Err.. Something went Wrong";
		exit;
	}
	$resp_data = $data['ResponseData'];
	$rand_arr = array();
	foreach ($resp_data['practitioners'] as $key => $val){
        if($val["show_in_online_bookings"]){
        	if(isset($partcinoer_id))
        	{
        			$rand_arr[] =  $partcinoer_id;
        	}
        	else
        	{
				$rand_arr[] =  $val["id"];
		    }
			
		}
	}
	
	$json_string = json_encode($rand_arr,true);
	setcookie('PRAC', $json_string);
	$any = $_COOKIE['ANY'];
	
	if($pid != ''){
		if($pid == 'any'){
			if($any == 0){
				$random_keys = array_rand($rand_arr,1);
				$pid = $rand_arr[$random_keys];
			}
			else{
				$pid =  $pid;
			}
		}
		else{
			$pid =  $pid;
		}
	}
	else{
		$random_keys = array_rand($rand_arr,1);
		$pid =  $rand_arr[$random_keys];
	}
	$url = 'https://api.cliniko.com/v1/practitioners/'.$pid;
	$prac_data = CurlCallDB($url,$conn,$pid);
	
	
	
	$from = date('Y-m-d');
	$effectiveDate = date("Y-m-t", strtotime($from));	
	$month = date('m');
	$dates = date_range($from, $effectiveDate);
	$total_count = count($dates);
	$k = 0;
	$dt = array();
	foreach($dates as $d){
		if(date('m', strtotime($d. ' + '.$k.' days')) == $month){
			if($k > 0){
				if (array_key_exists(($k+1),$dates)){ $key = $k+1; }else{ $key = $k; }  
				$dt[] = array("From" =>  date('Y-m-d', strtotime($d. ' + '.$k.' days')),"To" =>  date('Y-m-d', strtotime($dates[$key]. ' + '.$k.' days'))); 
			} 
			else{
				if (array_key_exists(($k+1),$dates)){ $key = $k+1; }else{ $key = $k; }  
				$dt[] = array("From" => $d,"To" => $dates[$key]); 
			}
		}
		$k++;
	}
	
	$array = array();
	$marray = array();
	$earray = array();
	$aarray = array();
	if($any == '0'){
		foreach($dt as $d){
			if($d['From'] != $d['To']){
				$URL="https://api.cliniko.com/v1/businesses/".$businessId."/practitioners/".$pid."/appointment_types/".$appointmentId."/available_times?from=".$d['From']."&to=".$d['To'];
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL,$URL);
				curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
				curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
				curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
				curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
				curl_setopt($ch, CURLOPT_USERPWD, USERNAME.":".PASSWORD);
				$result=curl_exec ($ch);
				$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
				curl_close ($ch);
				$json = json_decode($result,true);
				if($json["total_entries"]>0){
					for($p=0;$p<$json["total_entries"];$p++){
						$appTime=new DateTime($json["available_times"][$p]["appointment_start"],$utc);
						$arrAppTime=$appTime->setTimeZone($perth);
						$time=$arrAppTime->format("Y-m-d");
						$hour=$arrAppTime->format("H");
						$morning = 0;
						$afternoon = 0;
						$evening = 0;
						if($hour<12){
							$morning = 1;
							$marray[] = $arrAppTime->format('Y-m-d');
						}
						else if($hour<17 && $hour>=12){
							$afternoon = 1;
							$earray[] = $arrAppTime->format('Y-m-d');
						}
						else if($hour>=17){
							$evening = 1;
							$aarray[] = $arrAppTime->format('Y-m-d');
						}
						
						$date = $arrAppTime->format('Y-m-d');
						$time = $arrAppTime->format('H:i:s');
						if(array_key_exists($date,$array)){
							$time_arr = $array[$date]['Time'];
							$temp_arr = array('time' => $time ,"pid" => $pid);
							array_push($time_arr,$temp_arr);
							$array[$date]['Time'] = $time_arr;
							$array[$date]['Morning'] = $array[$date]['Morning'] + $morning;
							$array[$date]['Pid'] = $pid;
							$array[$date]['Afternoon'] = $array[$date]['Afternoon'] + $afternoon;
							$array[$date]['Evening'] = $array[$date]['Evening'] + $evening;
						}
						else{
							$array[$date] = array("Date"=> $date,"Time" => array(array('time' => $time, "pid" => $pid)),"Morning" => $morning,"Afternoon" => $afternoon,"Evening" => $evening);
						}
					}
				}
			}
		}
	}
	else{
		foreach($rand_arr as $ra){
			foreach($dt as $d){
				if($d['From'] != $d['To']){
					$URL="https://api.cliniko.com/v1/businesses/".$businessId."/practitioners/".$ra."/appointment_types/".$appointmentId."/available_times?from=".$d['From']."&to=".$d['To'];
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,$URL);
					curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
					curl_setopt($ch, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
					curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
					curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
					curl_setopt($ch, CURLOPT_USERPWD, USERNAME.":".PASSWORD);
					$result=curl_exec ($ch);
					$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);   //get status code
					curl_close ($ch);
					$json = json_decode($result,true);
					if($json["total_entries"]>0){
						for($p=0;$p<$json["total_entries"];$p++){
							$appTime=new DateTime($json["available_times"][$p]["appointment_start"],$utc);
							$arrAppTime=$appTime->setTimeZone($perth);
							$time=$arrAppTime->format("Y-m-d");
							$hour=$arrAppTime->format("H");
							$morning = 0;
							$afternoon = 0;
							$evening = 0;
							if($hour<12){
								$morning = 1;
								$marray[] = $arrAppTime->format('Y-m-d');
							}
							else if($hour<17 && $hour>=12){
								$afternoon = 1;
								$earray[] = $arrAppTime->format('Y-m-d');
							}
							else if($hour>=17){
								$evening = 1;
								$aarray[] = $arrAppTime->format('Y-m-d');
							}
							
							$date = $arrAppTime->format('Y-m-d');
							$time = $arrAppTime->format('H:i:s');
							if(array_key_exists($date,$array)){
								$time_arr = $array[$date]['Time'];
								$temp_arr = array('time' => $time, "pid" => $ra);
								array_push($time_arr,$temp_arr);
								$array[$date]['Time'] = $time_arr;
								$array[$date]['Morning'] = $array[$date]['Morning'] + $morning;
								$array[$date]['Afternoon'] = $array[$date]['Afternoon'] + $afternoon;
								$array[$date]['Evening'] = $array[$date]['Evening'] + $evening;
							}
							else{
								$array[$date] = array("Date"=> $date,"Time" => array(array('time' => $time, "pid" => $ra)),"Morning" => $morning,"Afternoon" => $afternoon,"Evening" => $evening);
							}
						}
					}
				}
			}
		}
	}
		
	$marray = array_unique($marray); 
	$earray = array_unique($earray); 
	$aarray = array_unique($aarray); 
	
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
		<link rel="stylesheet" href="assets/css/dp.css" />
		<link rel="stylesheet" href="assets/jquery.filthypillow.css" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
			rel="stylesheet">
		<link rel="stylesheet" href="assets/css/new-style.css" />
		<link rel="stylesheet" href="assets/css/style.css" />
		<style>
		.overlay {
			width: 100%;
			background: rgba(0, 162, 255, 0.05);
		}
		#infoi {
			width: 100%;
			height: 100%;
			position: absolute;
			top: 0;
			left: 0;
			background: #fff;
			opacity:0.9;
		}
		#infoi {
		  z-index: 10;
		}
		.loader {
		  border: 8px solid #f3f3f3;
		  border-radius: 50%;
		  border-top: 8px solid #3498db;
		  width: 70px;
		  height: 70px;
		  -webkit-animation: spin 2s linear infinite; /* Safari */
		  animation: spin .5s linear infinite;
		  left: 40%;top: 50%;position: absolute;
		}
		  

		/* Safari */
		@-webkit-keyframes spin {
		  0% { -webkit-transform: rotate(0deg); }
		  100% { -webkit-transform: rotate(360deg); }
		}

		@keyframes spin {
		  0% { transform: rotate(0deg); }
		  100% { transform: rotate(360deg); }
		}
		.table-condensed .old{
			opacity: 0;
			cursor: not-allowed;
		}
		.table-condensed .new{
			display:none;
		}
		 
		@media all and (max-width:450px)
		{
			.col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
				position: relative;
				width: 100%;
				padding-right: 10px !important;
				padding-left: 10px !important;
			}
		}

		/*  */
		

		ul.parsley-errors-list 
		{
			padding-left:0px !important;
		}
		ul.parsley-errors-list li
		{
			list-style:none !important;
			font-size: 13px;
			color: #F00;
			font-weight: 400;
			display: inline-block;
			margin-bottom: 0px;
		}
		.parsley-required
		{
			font-size: 13px;
			color: #F00;
			font-weight: 400;
			display: inline-block;
			margin-bottom: 0px;
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
        color: #fff; z-index: 999; cursor: pointer
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
					<i id="iPage1" onclick="window.history.go(-1); return false;" class="fa fa-home baricon baricon-one has-tip active" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Step-1"></i>
					<span id="bar1" class="progress_bar active"></span>
					<i id="iPage2" class="fa fa-calendar baricon baricon-two has-tip active" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Step-2"></i>
					<span id="bar2" class="progress_bar"></span>
					<i id="iPage3" class="fa fa-info baricon baricon-three has-tip" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Step-3"></i>
					<span id="bar3" class="progress_bar"></span>
					<i id="iPage4" class="fa fa-check baricon baricon-four has-tip" aria-hidden="true"  data-toggle="tooltip" data-placement="top" title="Completed"></i>
				</div>
			</div>
		</div>
		<div class="row mb-4">
	  		<div class="col-xl-5 col-lg-12 col-md-12">
				  <div class="card-woborder bg-white two shadow mb-30">
					<h5 class="h5-relative font-18 font-bold ">Select a Facilitator</h5>
					<div class="card-woborder-content">
						<select class="form-control" id="exampleFormControlSelect1">
							<?php
								foreach ($resp_data['practitioners'] as $key => $val){
									if($val["show_in_online_bookings"]){
							?>
								<option  value="<?php echo $val["id"] ?>" <?php if ($pid == $val["id"]) { echo "selected='selected'";} ?> >
										<?php echo $val['first_name'] . " " . $val["last_name"]; ?>
								</option>
							<?php
									}
								}
							?>
							<option value="any" <?php if ($pid == 'any'){echo "selected";} ?> >Any</option>
						</select>
					</div>
				  </div>
				  <div class="card-woborder bg-white shadow mb-30">
					  <div class="two pb-0">
						<h5 class="h5-relative c2 font-18 font-bold ">Select a Suitable Date</h5>
					</div>
					<div class="two pt-0 xs-p-0">
						<div class="card-woborder-content">
							<div id="datetimepicker12"></div>
						</div>
						<div id="infoi" style="Display:none;">
							<div class="loader" ></div>
						</div>
					</div>
				  </div>
				  	<div class="d-xl-inline d-none">
						<button  onclick="window.history.go(-1); return false;" type="button" class="btn btn-orange font-16 font-semibold xl-mb-4">Back</button>
					</div>
				  </div>
			<div class="col-xl-4 col-lg-12 col-md-12">
				<div class="card-woborder bg-white two shadow mb-30" id="slot_section">
				  <h5 class="h5-relative c3 font-18 font-bold ">Select a Suitable Time</h5>
				  <div class="card-woborder-content">
					<label class="italic-label font-14 font-regular">All times shown in AWST</label>
					<label id="labelDetails" class="font-16"></label>
					<div class="row text-center" id="app_err" style="display:none;">
						<div class="col-12">
							<p class="app_err" >Sorry, there are no appointments available this date.</p>
						</div>
					</div>
					<div class="row text-center" id="app_slots">
						<div class="col-4">
							<img src="assets/image/morning.png" class="img-fluid days-icon" alt="">
							<p class="font-15">Morning</p>
							<div class="m">
							</div>
						</div>
						<div class="col-4">
							<img src="assets/image/afternoon.png" class="img-fluid days-icon" alt="">
							<p class="font-15">Afternoon</p>
							<div class="a">
							</div>
						</div>
						<div class="col-4">
							<img src="assets/image/evening.png" class="img-fluid days-icon" alt="">
							<p class="font-15">Evening</p>
							<div class="e">
							</div>
						</div>
					</div>
				  </div>
				</div>
				<div class="mb-30">
					<a href="javascript:;" data-toggle="modal" data-target="#exampleModal" class="external-link " >Can't find a suitable time slot? Get in touch</a>
				</div>
				
			</div>
			
			
			
			<?php $str='style="display:none;"'; if($pid != 'any'){ $str=''; } ?> 
			<div id="infopat" class="col-xl-3 col-lg-12 col-md-12" <?php echo $str; ?> >
				<div class="card-woborder bg-white two shadow mb-30">
					<div class="justify-content-center d-flex">
						<div class="img-practitioner">
							<img id="imgPractitioner" src="assets/images/<?php echo $prac_data['Images']; ?>" class="img-fluid " alt="">
						</div>
					</div>
					<h3 class="font-18 font-medium text-center text-black mb-0 text-title"><?php echo $prac_data['Title']; ?></h3>
					<p class="font-15 color-555 text-center text-desc mb-0"><?php echo $prac_data['Description']; ?></p>
				</div>
			</div>

			<div class="col-xl-12 d-xl-none d-inline-block">
				<button  onclick="window.history.go(-1); return false;" type="button" class="btn btn-orange font-16 font-semibold">Back</button>
			</div>
			
		</div>

	</div>
	
	
<!-- footer start -->
    
<!-- footer start -->
    
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

	<div id="loder"></div>
	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Get in touch</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<form method="POST" id="form22" data-parsley-validate=""  action="#">
				<div class="row"  >
					
					<div class="col-12">
						<div class="form-group">
							<label id="lblDate" for="dob" class="font-185 font-regular">Name:</label>
							<input type="text" class="form-control text-45" data-parsley-trigger="keyup"  required data-parsley-required-message="Name is required" value="<?php echo $firstName; ?> <?php echo $lastName; ?>" name="datepicker" id="name">
							
						</div>
						<div class="form-group">
							<label id="lblDate" for="dob" class="font-185 font-regular">Email:</label>
							<input type="text" class="form-control text-45" data-parsley-trigger="keyup"  data-parsley-type="email" required data-parsley-required-message="Email is required" data-parsley-type-message="Enter a valid email address" value="<?php echo $email; ?>" name="datepicker" id="email">
							
						</div>
						<div class="form-group">
							<label id="lblDate" for="dob" class="font-185 font-regular">Mobile:</label>
							<input type="text" class="form-control text-45" data-parsley-trigger="keyup"  data-parsley-length="[8, 16]" data-parsley-length-message="Please enter a valid mobile number" data-parsley-required-message="Mobile number is required" data-parsley-pattern="[+ \d-]+" value="<?php echo $number; ?>"  data-parsley-pattern-message="Please enter a valid mobile number" required  value="" name="datepicker" id="phone">
							
						</div>
						<div class="form-group">
							<label id="lblDate" for="dob" class="font-185 font-regular">Preferred Date & Time:</label>
							<input type="text" class="form-control filthypillow-1 text-45" data-parsley-trigger="keyup"  required data-parsley-required-message="Preferred Date & Time is required" value="" name="datepicker" id="time2">
							
						</div>
						<div class="form-group">
							<label id="lblDate" for="dob" class="font-185 font-regular">Notes (Optional):</label>
							<textarea class="form-control"  name="" id="note" ></textarea>
						</div>
					</div>
					
				</div>
				</form>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn main-border-button" data-dismiss="modal">Close</button>
			<button type="button" class="main-select-button"  id="BookReq">Request</button>
		  </div>
		</div>
	  </div>
	</div>
	<form method="POST" id="form" action="practitioner.php">
		<input type="hidden" id="hidId" name="hidId" value="<?php echo $appointmentId; ?>"/>
		<input type="hidden" id="businessId" name="businessId" value="<?php echo $businessId; ?>"/>
		<input type="hidden" id="id" name="id" value="<?php echo $appointmentId; ?>"/>
		<input type="hidden" id="txtMonth" value="<?php echo $month; ?>"/>
		<input type="hidden" id="txtYear" value="<?php echo $year; ?>" />
		<input type="hidden" name="txtPractioner" id="txtPractioner" value="<?php echo $pid; ?>"/>
		<input type="hidden" name="txtFirstName" id="txtFirstName" value="<?php echo $firstName; ?>"/>
		<input type="hidden" name="txtLastName" id="txtLastName" value="<?php echo $lastName; ?>"/>
		<input type="hidden" name="txtEmail" id="txtEmail" value="<?php echo $email; ?>"/>
		<input type="hidden" name="txtNumber" id="txtNumber" value="<?php echo $number; ?>"/>
		<input type="hidden" name="txtcoupouncode" id="txtcoupouncode" value="<?php echo $coupoun_code; ?>"/>
		<input type="hidden" id="txtTime" value="<?php echo $txtTime;?>">
		<input type="hidden" id="day" name="day" value="">
		<input type="hidden" id="time" name="time" value="">
		<input type="hidden" id="pid" name="pid" value="<?php echo $pid; ?>">
		<input type="hidden" id="pname" name="pname" value="<?php echo $_POST['pname']; ?>">
		<input type="hidden" id="sname" name="sname" value="<?php echo $_POST['sname']; ?>">
		<input type="hidden" id="srate" name="srate" value="<?php echo $_POST['srate']; ?>">
		<input type="hidden" id="srate2" name="srate2" value="<?php echo $_POST['srate2']; ?>">
		<input type="hidden" name="utm_campaign" id="utm_campaign" class="form-control" value="<?php echo $_POST["utm_campaign"]; ?>"/>
		<input type="hidden" name="utm_source" id="utm_source" class="form-control" value="<?php echo $_POST["utm_source"]; ?>"/>
		<input type="hidden" name="utm_medium" id="utm_medium" class="form-control" value="<?php echo $_POST["utm_medium"]; ?>"/>
		<input type="hidden" name="utm_term" id="utm_term" class="form-control" value="<?php echo $_POST["utm_term"]; ?>"/>
		<input type="hidden" name="utm_content" id="utm_content" class="form-control" value="<?php echo $_POST["utm_content"]; ?>"/>
		<input type="hidden" name="source" id="source" class="form-control" value="<?php echo $_POST["source"]; ?>"/>
	</form>
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" ></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
    <script src="assets/js/dp.js"></script>
    <script src="assets/jquery.filthypillow.min.js"></script>
	<script src="assets/js/main.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/js-cookie@rc/dist/js.cookie.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.js"></script>
	
	<script src="assets/js/amplify.store.js"></script>
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ouibounce/0.0.11/ouibounce.min.js"></script>

<script>
    
$(document).ready(function() {
	
    
        $('body').prepend('<div id="ouibounce-modal"><div class="overlay"></div><div class="popup exitmodelpopup"> <a class="closePopupCross">×</a><div class="modal-content"><div class="modal-body p-0"><div class="row row-no-gutters"><div class="col-lg-7 col-md-7 col-sm-6 p-0 popupleftbx"><div class="exitpopup_cntbxpop"><h2>NEED HELP</h2><p>to Improve Your Well-Being and Reclaim Your Quality of Life?</p><div class="book_freebxpop"> <span>Book a <span>25 Mins FREE</span> </span><p>Telehealth Consultation with Terri Bowman</p></div><div class="bookfreebtn"><a href="https://brainwellnessspa.zohobookings.com.au/#/customer/1597000000035035" class="btn-book orgbtn" target="_blank">Yes<span>I need to change my life </span></a><a class="btn-book" id="closeLeavePage">No<span>I m in perfect health </span></a></div></div></div><div class="col-lg-5 col-md-5 col-sm-6 p-0 popuprightbx"> <img src="images/exitpopupterriimg.png" alt="" /><div class="popupterriimgcnt"><h5>Terri Bowman</h5> <span>Chief Facilitator</span><p> Creator of Positive <br /> Auditory Stimuli Technique</p></div></div></div></div></div></div></div>');

        $('.closePopupLink, #closeLeavePage, .overlay , .closePopupCross').click(function() {
            $('.overlay, .popup').fadeOut(500);
        });
  
        
  
        var _ouibounce = ouibounce(document.getElementById('ouibounce-modal'), {
        	aggressive: true,
        	timer: 0,
        	callback: function() { console.log('ouibounce fired!'); }
      	});
});

</script>
	<script>   
		var $fp = $( ".filthypillow" ),
		now = moment( ).subtract( "seconds", 1 );
		$fp.filthypillow( { 
		  minDateTime: function( ) {
			return now;
		  } 
		} );
		$fp.on( "focus", function( ) {
		  $fp.filthypillow( "show" );
		} );
		$fp.on( "fp:save", function( e, dateObj ) {
		  $fp.val( dateObj.format( "MMM DD YYYY hh:mm A" ) );
		  $fp.filthypillow( "hide" );
		} );
		$("#BookReq").click(function() {
			var $form = $('#form22');
			var name = $("#name").val();	
			var email = $("#email").val();	
			var phone = $("#phone").val();	
			var time = $("#time2").val();	
			var note = $("#note").val();	
			var utm_source = $("#utm_source").val();	
			var utm_campaign = $("#utm_campaign").val();	
			var utm_medium = $("#utm_medium").val();	
			var utm_term = $("#utm_term").val();	
			var utm_content = $("#utm_content").val();	
			var source = $("#source").val();	
			
			if($form.parsley().validate()){
				$.ajax({
					url: "ajax_request.php", 
					crossDomain: true,
					dataType: "json",
					type: "post",
					data: {name:name,email:email,phone:phone,time:time,note:note,utm_source:utm_source,utm_campaign:utm_campaign,utm_medium:utm_medium,utm_term:utm_term,utm_content:utm_content,source:source},
					success: function (data, textStatus, jqXHR) {
						document.getElementById("form").reset();						
						window.location = 'thank-you.php';
					}
				});
			}
		});
	</script>   
	<script>   
		$(function () {
			$('[data-toggle="tooltip"]').tooltip();
			
			
		})
		
	</script>
	<script type="text/javascript">
		$(function () {
			$("#pname").val($("#exampleFormControlSelect1 option:selected").text());
			$("#exampleFormControlSelect1").val('<?php echo $pid; ?>');
			$('#exampleFormControlSelect1').on('change', function() {
				$("#loder").show();
				$("#pid").val($(this).val());
				$("#pname").val($(this).text());
				if($(this).val() == 'any'){
					Cookies.set('ANY', '1');
				}
				else{
					Cookies.set('ANY', '0');
				}
				$('#form').attr('action', 'practitioner.php');
				$( "#form" ).submit();
			});
			$(document).on('click','.btn-time',function(){
				var value = $(this).attr('data-value');
				var pid = $(this).attr('data-pid');
				$("#pid").val(pid);
				$("#time").val(value);
				var pid_main = '<?php echo $pid; ?>';
				if(pid_main == 'any'){
					$.ajax({
						url: "ajax_pat.php", 
						crossDomain: true,
						dataType: "json",
						type: "post",
						data: {pid:pid},
						success: function (data, textStatus, jqXHR) {
							$("#pname").val(data.Title);
							$(".text-title").attr('src','assets/images/'+data.Images);
							$(".text-title").html(data.Title);
							$(".text-desc").html(data.Description);
							$("#infopat").show();
							$('#form').attr('action', 'details.php');
							$( "#form" ).submit();
						}
					});
				}
				else{
					$('#form').attr('action', 'details.php');
					$( "#form" ).submit();
				}
			});
			var isMobile = {
				Android: function() {
					return navigator.userAgent.match(/Android/i);
				},
				BlackBerry: function() {
					return navigator.userAgent.match(/BlackBerry/i);
				},
				iOS: function() {
					return navigator.userAgent.match(/iPhone|iPad|iPod/i);
				},
				Opera: function() {
					return navigator.userAgent.match(/Opera Mini/i);
				},
				Windows: function() {
					return navigator.userAgent.match(/IEMobile/i);
				},
				any: function() {
					return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
				}
			};
			function onlyUnique(value, index, self) { 
				return self.indexOf(value) === index;
			}
			function pad2(number) {
				return (number < 10 ? '0' : '') + number
			}
			function tConvert (time) {
				time = time.toString ().match (/^([01]\d|2[0-3])(:)([0-5]\d)(:[0-5]\d)?$/) || [time];
				if (time.length > 1) { // If time format correct
					time = time.slice (1);  // Remove full string match value
					time[5] = +time[0] < 12 ? ' AM' : ' PM'; // Set AM/PM
					time[0] = +time[0] % 12 || 12; // Adjust hours
				}
				
				var t = pad2(time[0])+''+time[1]+''+time[2]+''+time[5];
				
				return t; // return adjusted time or original string
			}
			Cookies.set('APP', '<?php echo json_encode($array,true) ?>');
			amplify.store( "APP2", '<?php echo json_encode($array,true) ?>' );
			Cookies.set('MAPP', '<?php echo json_encode($marray,true) ?>');
			Cookies.set('EAPP', '<?php echo json_encode($earray,true) ?>');
			Cookies.set('AAPP', '<?php echo json_encode($aarray,true) ?>');
			
			$('body').on('DOMSubtreeModified', '#datetimepicker12', function(){
				var MAPP = JSON.parse(Cookies.get('MAPP'));
				var EAPP = JSON.parse(Cookies.get('EAPP'));
				var AAPP = JSON.parse(Cookies.get('AAPP'));
				$.each(MAPP, function( key, value ) {
					$(".date_"+value).addClass('highlightdate');
				})
				$.each(EAPP, function( key, value ) {
					$(".date_"+value).addClass('highlightdate');
				})
				$.each(AAPP, function( key, value ) {
					$(".date_"+value).addClass('highlightdate');
				})
			});
			var Now = new Date();
			
			$('#datetimepicker12').datetimepicker2({
				inline: true,
				sideBySide: true,
				showTodayButton: false,
				minDate:Now,
				icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down",
					previous: "fa fa-angle-left",
					next: "fa fa-angle-right",
                },
				format: 'YYYY/MM/DD'
			}).on('dp.show dp.change', function (e) {
				var formatedValue = e.date.format(e.date._f);
				var d = formatedValue.split("T");
				var date = d[0];
				$("#labelDetails").html(moment(date, 'YYYY-MM-DD').format('Do MMMM YYYY'));
				$("#day").val(date);
				var json = JSON.parse(amplify.store( "APP2" ));
				if(json[date] !== undefined){
					var pid = json[date].Time;
					if(json[date].Time.length > 0){
						var htmlm= '';
						var htmla= '';
						var htmle= '';
						var time_array = json[date].Time;
						var unique = time_array.filter(onlyUnique);
						var t_arr = new Array();
						$.each(unique, function( key, value ) {
							var time = value['time'];
							var pid = value['pid'];
							var t = time.split(":");
							if(t_arr.indexOf(time) === -1){
								t_arr.push(time); 
								if(t[0] < 12){    
									htmlm+='<button type="button" data-pid="'+pid+'" data-value="'+time+'" class="btn btn-time book book-primary font-regular font-14 mb-2">'+tConvert(time)+'</button>';
								}
								else if(t[0] < 17 && t[0] >= 12){ 
									htmla+='<button type="button" data-pid="'+pid+'" data-value="'+time+'" class="btn btn-time book book-primary font-regular font-14 mb-2">'+tConvert(time)+'</button>';       
								}
								else if(t[0] >= 17){
									htmle+='<button type="button" data-pid="'+pid+'" data-value="'+time+'" class="btn btn-time book book-primary font-regular font-14 mb-2">'+tConvert(time)+'</button>';       
								}
							}
						});
						$("#app_err").hide();
						$("#app_slots").show();
						$(".m").html(htmlm);
						$(".a").html(htmla);
						$(".e").html(htmle);
						$(".slots1").show();
						$(".slots2").show();
						if(isMobile.any()){
							$('html, body').animate({
								scrollTop: $("#slot_section").offset().top
							}, 500);
						}
					}
					else{
						$("#app_err").show();
						$("#app_slots").hide();
						$(".m").html('');
						$(".a").html('');
						$(".e").html('');
					}
				}
				else{
					$("#app_err").show();
					$("#app_slots").hide();
					$(".m").html('');
					$(".a").html('');
					$(".e").html('');
				}
				var MAPP = JSON.parse(Cookies.get('MAPP'));
				var EAPP = JSON.parse(Cookies.get('EAPP'));
				var AAPP = JSON.parse(Cookies.get('AAPP'));
				$.each(MAPP, function( key, value ) {
					$(".date_"+value).addClass('highlightdate');
				})
				$.each(EAPP, function( key, value ) {
					$(".date_"+value).addClass('highlightdate');
				})
				$.each(AAPP, function( key, value ) {
					$(".date_"+value).addClass('highlightdate');
				})
				
			}).on('dp.update', function (e) {
				$(".m").html('');
				$(".a").html('');
				$(".e").html('');
				$("#app_err").hide();
				$("#app_slots").show();
				$("#infoi").show();
				  $.ajax({
					url: "ajax_appointment.php", 
					crossDomain: true,
					dataType: "json",
					type: "post",
					data: {month:e.viewDate.format("M"),year:e.viewDate.format("Y"),pid:$("#exampleFormControlSelect1").val(),businessId:$("#businessId").val(),appointmentId:$("#id").val()},
					success: function (data, textStatus, jqXHR) {
						Cookies.set('APP', data.Array);
						amplify.store( "APP2", JSON.stringify(data.Array));
						Cookies.set('MAPP', JSON.stringify(data.MArray));
						Cookies.set('EAPP', JSON.stringify(data.EArray));
						Cookies.set('AAPP', JSON.stringify(data.AArray));
						$.each(data.MArray, function( key, value ) {
							$(".date_"+value).addClass('highlightdate');
						})
						$.each(data.EArray, function( key, value ) {
							$(".date_"+value).addClass('highlightdate');
						})
						$.each(data.AArray, function( key, value ) {
							$(".date_"+value).addClass('highlightdate');
						})
						$("#infoi").hide();
					}
				});	
			});
		});
	</script>
	</body>
</html>
	