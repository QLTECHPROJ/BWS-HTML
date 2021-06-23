<?php
	include('inc.php');
	include('config.php');
	include("infusionsoft-php-sdk-master/Infusionsoft/infusionsoft.php");
	include("infusionsoft-php-sdk-master/Infusionsoft/DataFormField.php");
	include("infusionsoft-php-sdk-master/Infusionsoft/examples/object_editor_all_tables.php");
	header("Cache-Control: max-age=9000, must-revalidate"); 
	if(!isset($_POST['day'])){
		echo "<script>window.location = 'services.php?error=1';</script>";
		exit;
	}
	$busseiness_id = $_POST['businessId'];
	$ua="AEDT";
	$utc = new DateTimeZone($ua);
	$perth= new DateTimeZone('Australia/Perth');
	$URL='https://api.cliniko.com/v1/businesses/'.$busseiness_id;
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
	$business_name = $json['business_name'];
	$business_address = $json['address_1'];
	$business_city = $json['city'];
	$business_state = $json['state'];
	$business_post_code = $json['post_code'];
	

	$book_tag="186";
	$call_tag="350";
	
	$URL="https://api.au1.cliniko.com/v1/settings";
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
	$json23 = json_decode($result,true);
	$term =  $json23["online_bookings"]["policy"];
	
	
	
	$practitionerId = $_POST['pid'];
	$appointmentId = $_POST['id'];
	$time = $_POST['time'];
	$day = $_POST['day'];
	$firstName=$_POST["txtFirstName"];
	$lastName=$_POST["txtLastName"];
	$number=$_POST["txtNumber"];
	$email=$_POST["txtEmail"];
	
	
	
	
	if(isset($_REQUEST["btnBookAppointment"])){
	
		$busseiness_id = $_POST['busseiness_id'];
		$URL='https://api.cliniko.com/v1/businesses/'.$busseiness_id;
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
		$business_name = $json['business_name'];
		$business_address = $json['address_1'];
		$business_city = $json['city'];
		$business_state = $json['state'];
		$business_post_code = $json['post_code'];
	
	
		$error=0;
		$addFlag=0;
		$username = $api_key;
		$password = "";
		$firstName=$_REQUEST["txtFirstName"];
		$lastName=$_REQUEST["txtLastName"];
		$number=$_REQUEST["txtNumber"];
		$code=$_REQUEST["txtCode"];
		$chkCall=$_REQUEST["chkCall"];
		$comment=$_REQUEST["taComments"];
		$_SESSION["notes"]=$comment;
		$dateOfBirth=$_REQUEST["datepicker"];
		$email=$_REQUEST["txtEmail"];
		$address=$_REQUEST["txtAddress"];
		//for the coupoun code check - 11-06-2020
		$coupoun_code_txt=$_REQUEST["txtcoupouncode"];
		$success_coupoun_value=$_REQUEST['success_coupoun_value'];
		
		$practitionerId = $_POST['practitionerId'];
		$appointmentId = $_POST['appointmentId'];
		$time = $_POST['time'];
		$day = $_POST['day'];
		//end of coupoun code check - 11-06-2020
		
		$utm_campaign = $_POST['utm_campaign'];
		$utm_source = $_POST['utm_source'];
		$utm_medium = $_POST['utm_medium'];
		$utm_term = $_POST['utm_term'];
		$utm_content = $_POST['utm_content'];
		$source = $_POST['source'];
		
		
		if($_REQUEST["txtCity"] !="otherCity")
		{
			$city=$_REQUEST["txtCity"];
		}
		else
		{
			$city=$_REQUEST["txtSuburb"];
		}
		$state=$_REQUEST["txtState"];
		$pincode=$_REQUEST["txtPinCode"];
		$country=$_REQUEST["state"];
		$otherCountry=$_REQUEST["txtOther"];
		
		
		
		
		if($city!="")
		{
			$qrySel="SELECT * FROM wp_timeZone WHERE  `displayName` LIKE '%$city%'";
			$rsltTimeZone=mysqli_query($conn,$qrySel);
			$numTimeZone=mysqli_num_rows($rsltTimeZone);
			if($numTimeZone > 0)
			{
				$rowTimeZone=mysqli_fetch_assoc($rsltTimeZone);
				$timeZone=$rowTimeZone["name"];
			}
			else
			{
				$timeZone="Asia/Shanghai";	
			}
		}
		else
		{
			$timeZone="Asia/Shanghai";
		}
		if(empty($firstName))
		{
			$error=1;
		}
		if(empty($lastName))
		{
			$error=1;
		}
		if(empty($email))
		{
			$error=1;
		}
		if(empty($address))
		{
			$error=1;
		}
		if(empty($number))
		{
			$error=1;
		}
		if(empty($dateOfBirth))
		{
			$error=1;
		}
		if(empty($city))
		{
			$error=1;
		}
		if(empty($state))
		{
			$error=1;
		}	
		if(empty($pincode))
		{
			$error=1;
		}
		if($country != ""){
			$finalCountry=$country;
		}
		else{
			$finalCountry=$otherCountry;
		}
		if(empty($finalCountry))
		{
			$error=1;
		}
		if($error==1)
		{
		
		?>
			<div id="myModal1" class="no-outer-script-box w-100">
				<div class="row justify-content-center d-flex">
					<div class="col-xl-8 col-lg-9 col-md-12 text-center">
						<div class="modal-content-popup">
							<div class="header-no-script justify-content-between d-flex">
							<h5 class="font-22 mb-0">OOPS!</h5>
							<span class="closePopUp1 font-22 mb-0">&times;</span>
							</div>
							<div class="no-inner-script-box">
								<h5 class="font-22 mb-2">It seems that you have missed one of the fields. Please fill all mandatory fields with * mark and then proceed for booking.</h5>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
			
		}
		else{
		if($practitionerId==31836)
		{
			$pTag="172";
		}
		else if($practitionerId==33267)
		{
			$pTag="174";
		}
		else if($practitionerId==63975)
		{
			$pTag="176";
		}
		else if($practitionerId==69826)
		{
			$pTag="178";
		}
		else if($practitionerId==88614)
		{
			$pTag="990";
		}
		
		
		else if($practitionerId==92059)
		{
			$pTag="2070";
		}
		else if($practitionerId==95180)
		{
			$pTag="2216";
		}
		
		else if($practitionerId==96061)
		{
			$pTag="2298";
		}
		else if($practitionerId==99107)
		{
			$pTag="3103";
		}
		else if($practitionerId==99961)
		{
			$pTag="3105";
		}
		else if($practitionerId==100508)
		{
			$pTag="3107";
		}
		else if($practitionerId==106254)
		{
			$pTag="5430";
		}
		else if($practitionerId==108194)
		{
			$pTag="5432";
		}
		else if($practitionerId==106256)
		{
			$pTag="5450";
		}
		else if($practitionerId==114372)
		{
			$pTag="5478";
		}
		else if($practitionerId==114371)
		{
			$pTag="5476";
		}
		else if($practitionerId==118488)
		{
			$pTag="5582";
		}
		else if($practitionerId==117776)
		{
			$pTag="5586";
		}
		else if($practitionerId==121163)
		{
			$pTag="5762";
		}
		else if($practitionerId==127935)
		{
			$pTag="6074";
		}
		else if($practitionerId==138195)
		{
			$pTag="6076";
		}
		else if($practitionerId==138197)
		{
			$pTag="6078";
		}
		else if($practitionerId==139353)
		{
			$pTag="6080";
		}
		else if($practitionerId==152617)
		{
			$pTag="6134";
		}
		else
		{
			$headers_email = "From: info@qltech.com.au";
			$msg_email = "Add tag of this Practitioner ID:".$practitionerId;
			mail("sunny@qltech.com.au","Add Practiitoner Tag in Booking Form",$msg_email,$headers_email);
			mail("manish@qltech.com.au","Add Practiitoner Tag in Booking Form",$msg_email,$headers_email);
		}
		if($GLOBALS['browserName'] != 'safari'){
			$time1=$time;
			$arrTime=explode(" ",$time);
		}
		else{
			$app=new DateTime($time,$utc);
			$arrApp=$app->setTimeZone($perth);//Convert Time in Perth
			$arrSafari=$arrApp->format("Y-m-d H:i:s");
			$arrT=date("Y-m-d\TH:i:s\Z", strtotime($arrSafari));
			$time1=$arrT;
			$arrTime=explode("T",$arrT);
		}
		$URL_C="https://api.au1.cliniko.com/v1/businesses/".$busseiness_id."/practitioners/".$practitionerId."/appointment_types/".$appointmentId."/available_times?from=".$day."&to=".$day;
		$ch_c = curl_init();
		curl_setopt($ch_c, CURLOPT_URL,$URL_C);
		curl_setopt($ch_c, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
		curl_setopt($ch_c, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
		curl_setopt($ch_c, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch_c, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($ch_c, CURLOPT_USERPWD, USERNAME.":".PASSWORD);
		$result_c=curl_exec ($ch_c);
		curl_close ($ch_c);
		$json_c = json_decode($result_c,true);
		
		$arrCheck=array();
		if($json_c["total_entries"]>0){
		for($l=0;$l<$json_c["total_entries"];$l++){
				$appTime=new DateTime($json_c["available_times"][$l]["appointment_start"],$utc);
				$arrAppTime=$appTime->setTimeZone($perth);//Convert Time in Perth
				$arrTimeCheck=$arrAppTime->format("Y-m-d H:i:s");
				if($GLOBALS['browserName'] != 'safari'){
					$arrCheck[$l]=$arrTimeCheck;
				}
				else{
					$arrCheck[$l]=date("Y-m-d\TH:i:s\Z", strtotime($arrTimeCheck));
				}
			}
		}
		
		
		if(in_array($day." ".$time,$arrCheck)){
			$myfile = fopen("details.txt", "a");
			$finalAddress= $address." , ".$city." , ".$state." , ".$finalCountry." , ".$pincode;
			fwrite($myfile, "-------------------------------------------------------------------");
			fwrite($myfile, "\n <h2>Patients Details</h2>");
			fwrite($myfile, "\nCurrent Date Time = ".date("Y-m-d H:i:s"));
			fwrite($myfile, "\nFirst Name = ".$firstName.",\nLast Name = ".$lastName);
			fwrite($myfile, "\nBirth_Date = ".$dateOfBirth);
			fwrite($myfile, "\n Email = ".$email);
			fwrite($myfile, "\n practitioners  =".$practitionerId);
			fwrite($myfile, "\n Call Back = ".$chkCall);
			fwrite($myfile, "\n Address =".$finalAddress);
			fwrite($myfile, "\n Comments =".$comment);
			fwrite($myfile, "\n Appointment id =".$appointmentId);
			fwrite($myfile, "\n Pincode =".$pincode);
			fwrite($myfile, "\n Phone Number= ".$number);
			fwrite($myfile, "\n Appointment Book Date Time =: ".$time);
			fwrite($myfile, "\n convert Date Time AEDT =: ".$ar);
			fwrite($myfile, "\n convert Date Time UTC =: ".$au);
			$URL_p="https://api.au1.cliniko.com/v1/patients?q=email:~".$email;
			$ch_P = curl_init();
			curl_setopt($ch_P, CURLOPT_URL,$URL_p);
			curl_setopt($ch_P, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
			curl_setopt($ch_P, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
			curl_setopt($ch_P, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch_P, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch_P, CURLOPT_USERPWD, USERNAME.":".PASSWORD);
			$result_p=curl_exec ($ch_P);
			curl_close ($ch_P);
			$json_P = json_decode($result_p,true);
			$flag=0;
			$count=0;
			$finalArr=array();
			if($json_P["total_entries"]>0){
				foreach ($json_P["patients"] as $key => $arrSinglePatient) 
				{
					$fname=trim($arrSinglePatient["first_name"]);	
					if (strcasecmp($fname,trim($firstName)) == 0) 
					{
				    	$flag=1;
				    	$same_id=$arrSinglePatient["id"];
					}
				}
				
				$count=ceil($json_P["total_entries"]/50);
			}
			$a=0;
			
			if($flag==1){
				$phone[] = array(
				    'number' => $code."-".$number,
				    'phone_type' => 'Mobile'
				    );
				$data = array("first_name"=>$firstName, 
					 "last_name"=>$lastName,
					 "patient_phone_numbers" => $phone,
					 "address_1"=>$address,
					 "city"=>$city,
					 "state"=>$state,
					 "post_code"=>$pincode);
				$json_p_Update = json_encode($data);
				$URL_P_Update = 'https://api.au1.cliniko.com/v1/patients/'.$same_id; //.$pat_id;
				$header = array("Accept: application/json","Connection: close", "Expect:",
				   "Content-Type: application/json".strlen($data));
				$ch_p_Update = curl_init();
			  	curl_setopt($ch_p_Update, CURLOPT_URL,$URL_P_Update);
			  	curl_setopt($ch_p_Update, CURLOPT_USERPWD, USERNAME.":".PASSWORD);
			  	curl_setopt($ch_p_Update, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
			  	curl_setopt($ch_p_Update, CURLOPT_HTTPHEADER, $header);
			  	curl_setopt($ch_p_Update, CURLOPT_CUSTOMREQUEST, 'PUT'); 
			  	curl_setopt($ch_p_Update, CURLOPT_POST, true);
			  	curl_setopt($ch_p_Update, CURLOPT_POSTFIELDS, $json_p_Update);
			  	curl_setopt($ch_p_Update, CURLOPT_RETURNTRANSFER,true);
			  	$result_Update=curl_exec ($ch_p_Update);
			  	curl_close($ch_p_Update);
			  	$json_Update = json_decode($result_Update,true);
			  	$pId_Add=$json_Update["id"];
			}
			else{
				$data = array("first_name"=>$firstName, 
					 "last_name"=>$lastName,
					 "date_of_birth"=>$dateOfBirth,
					 "email"=>$email,
					 "address_1"=>$address,
					 "city"=>$city,
					 "state"=>$state,
					 "post_code"=>$pincode);
				$URL_Add = "https://api.au1.cliniko.com/v1/patients";
				$ch_Add = curl_init();
				curl_setopt($ch_Add, CURLOPT_URL,$URL_Add);
				curl_setopt($ch_Add, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
				curl_setopt($ch_Add, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
				curl_setopt($ch_Add, CURLOPT_POST, true);
				curl_setopt($ch_Add, CURLOPT_POSTFIELDS, $data);
				curl_setopt($ch_Add, CURLOPT_RETURNTRANSFER,1);
				curl_setopt($ch_Add, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
				curl_setopt($ch_Add, CURLOPT_USERPWD, USERNAME.":".PASSWORD);
				$result=curl_exec ($ch_Add);
				$status_code = curl_getinfo($ch_Add, CURLINFO_HTTP_CODE);   //get status code
				curl_close ($ch_Add);
				$json_Add = json_decode($result,true);
				$p_id=$json_Add["id"];
				$add=1;
				$phone[] = array(
				    'number' => $code."-".$number,
				    'phone_type' => 'Mobile'
				    );
				$fields = array('patient_phone_numbers' => $phone);
				$json_p_Add = json_encode($fields);
				$URL_P = 'https://api.au1.cliniko.com/v1/patients/'.$p_id; //.$pat_id;
				$header = array("Accept: application/json","Connection: close", "Expect:",
				   "Content-Type: application/json".strlen($fields));
				$ch_p_Add = curl_init();
			  	curl_setopt($ch_p_Add, CURLOPT_URL,$URL_P);
			  	curl_setopt($ch_p_Add, CURLOPT_USERPWD, USERNAME.":".PASSWORD);
			  	curl_setopt($ch_p_Add, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
			  	curl_setopt($ch_p_Add, CURLOPT_HTTPHEADER, $header);
			  	curl_setopt($ch_p_Add, CURLOPT_CUSTOMREQUEST, 'PUT'); 
			  	curl_setopt($ch_p_Add, CURLOPT_POST, true);
			  	curl_setopt($ch_p_Add, CURLOPT_POSTFIELDS, $json_p_Add);
			  	curl_setopt($ch_p_Add, CURLOPT_RETURNTRANSFER,true);
			  	$result_Add=curl_exec ($ch_p_Add);
			  	curl_close($ch_p_Add);
			  	$json_Add = json_decode($result_Add,true);
			  	$pId_Add=$json_Add["id"];
			}
			$question=array("name"=>"Presenting complaint","type"=>"paragraph","answer"=>$comment);
			$questions[]=$question;
			$section=array("name"=>$firstName." ".$lastName,"questions"=>$questions);
			$sections[]=$section;
			$content=array("sections"=>$sections);
			$data_treatment = array("draft"=>true, 
							 "patient_id"=>$pId_Add,
							 "practitioner_id"=>$practitionerId,
							 "treatment_note_template_id"=>48475,
							 "content"=>$content);
			$header = array("Accept: application/json","Connection: close", "Expect:",
						   "Content-Type: application/json".strlen($data_treatment));
			$appTime=new DateTime($day." ".$time,$perth);
			$arrAppTime=$appTime->setTimeZone($utc);//Convert Time in Perth
			$fTime=$arrAppTime->format('Y-m-d H:i:s');
			$finalTime=date("Y-m-d\TH:i:s\Z", strtotime($fTime));
			//echo $day." ".$time;
			date_default_timezone_set("Australia/Perth");
			$dt = strtotime($day." ".$time);
			date_default_timezone_set("UTC");
			$finalTime = date('Y-m-d\TH:i:s\Z',$dt);
			
			$dataAppointment = array('appointment_start' => $finalTime, 'patient_id' => $pId_Add, 'practitioner_id' => $practitionerId, 'appointment_type_id' =>$appointmentId , 'business_id' => $busseiness_id,"notes"=>$comment);
			
			
			//print_r($dataAppointment);
			//exit;
			$URL_App = "https://api.au1.cliniko.com/v1/appointments";
			$ch_App = curl_init();
			curl_setopt($ch_App, CURLOPT_URL,$URL_App);
			curl_setopt($ch_App, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
			curl_setopt($ch_App, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
			curl_setopt($ch_App, CURLOPT_POST, true);
			curl_setopt($ch_App, CURLOPT_POSTFIELDS, $dataAppointment);
			curl_setopt($ch_App, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch_App, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch_App, CURLOPT_USERPWD, USERNAME.":".PASSWORD);
			$result_App=curl_exec ($ch_App);
			
			$status_code = curl_getinfo($ch_App, CURLINFO_HTTP_CODE);   //get status code
			curl_close ($ch_App);
			$json_App = json_decode($result_App,true);
			$headers_p = "From: info@qltech.com.au";
			$msg_p = "Name is=".$firstName." ".$lastName." <br>email is = ".$email. "<br> Your Contact Number =".$number."Appointment Start Time = ".$time;
			fwrite($myfile, "-------------------------------------------------------------------");
			fwrite($myfile, "<br>\nAppointment Details \n");
			fwrite($myfile, "<br>\nCurrent Appointment Date Time = ".date("Y-m-d H:i:s"));
			fwrite($myfile, "<br>\nAppointment End ". $json_App['appointment_end']);
			fwrite($myfile, "<br>\nAppointment Start ". $json_App['appointment_start']);
			fwrite($myfile, "<br>\nAppointment Create at". $json_App['created_at']);
			fwrite($myfile, "<br>\nPatient Name ". $json_App['patient_name']);
			fwrite($myfile, "<br>\nBooking IP Address ". $json_App['booking_ip_address']);
			//mail("sunny@qltech.com.au","Bookings Details",$msg_p,$headers_p);
			$URL2 = $json_App['appointment_type']['links']['self'];
			$ch2 = curl_init();
			curl_setopt($ch2, CURLOPT_URL,$URL2);
			curl_setopt($ch2, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');
			curl_setopt($ch2, CURLOPT_TIMEOUT, 30); //timeout after 30 seconds
			curl_setopt($ch2, CURLOPT_RETURNTRANSFER,1);
			curl_setopt($ch2, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			curl_setopt($ch2, CURLOPT_USERPWD, USERNAME.":".PASSWORD);
			$result2 = curl_exec ($ch2);
			$status_code = curl_getinfo($ch2, CURLINFO_HTTP_CODE);   //get status code
			curl_close ($ch2);
			$json2 = json_decode($result2,true);
			
			
			
			
			$status="Book";
			$created_at = new DateTime($json_App['created_at'], $utc);
			$created_at->setTimeZone($perth);
			$headers = "From: info@qltech.com.au";
			$msg = "First Name is=".$firstName." Last Name is = ".$lastName." $email is = ".$email. " Contact Number =".$code."".$number;
			$msg = wordwrap($msg,70);
			//mail("sunny@qltech.com.au","Infusionsoft Details",$msg,$headers);
			$infusionsoft_host = $infusion_host; //"nj314";
			$infusionsoft_api_key =$infusion_api_key; //"e942a626f663fc58d1d36fd65196cea0";
			if(empty($json)){
				echo "<h2>Failed</h2>";
			}
			else{
				$contact = new Infusionsoft_Contact();
				$contact->FirstName = $firstName;
				$contact->LastName = $lastName;
				$contact->Email =$email;
				$contact->Phone1=$code."-".$number;
				$contact->StreetAddress1=$address;
				$contact->City=$city;
				$contact->State=$state;
				$contact->Country=$finalCountry;
				$contact->PostalCode=$pincode;
				$contact->TimeZone=$timeZone;
				$optinreason = "You have signed up to our list by booking an appointment online via our website";
				$patient_url=trim("https://api.au1.cliniko.com/v1/patients/".$pId_Add);
				$objectsURL = Infusionsoft_DataService::query(new Infusionsoft_Contact(), array('_patientURL0' =>$patient_url));
				if(empty($objectsURL))
				{
					$objects = Infusionsoft_DataService::query(new Infusionsoft_Contact(), array('Email' =>$contact->Email));
					if(empty($objects))
					{
						
						$contact->save();
						//$objects = Infusionsoft_DataService::query(new Infusionsoft_Contact(), array('Email' =>$contact->Email));
						Infusionsoft_EmailService::optIn($contact->Email,$optinreason);
						Infusionsoft_ContactService::addToGroup($contact->Id,$book_tag);
						if(!empty($pTag))
						{
							Infusionsoft_ContactService::addToGroup($contact->Id,$pTag);
						}						
						Infusionsoft_ContactService::addToGroup($contact->Id,"726");
						if($add==1)
						{
							Infusionsoft_ContactService::addToGroup($contact->Id,"314");
						}
						if($chkCall == 'on'){
							Infusionsoft_ContactService::addToGroup($contact->Id,$call_tag);
						}
						$finalContactId=$contact->Id;
						fwrite($myfile, "\Contact Create IF inside IF condition and Contact ID = ". $finalContactId);
					}
					else
					{
						$lengthEmail=count($objects);
						if($lengthEmail==1)
						{
							if(strcasecmp(trim($firstName),trim($objects[0]->FirstName))==0)
							{
								$contactId = $objects[0]->Id;
							    $contact1 = new Infusionsoft_Contact($contactId);
							    $contact1->FirstName = $firstName;
							    $contact1->LastName = $lastName;
							    $contact1->Phone1 =$code."-".$number;
							    $contact1->StreetAddress1=$address;
								$contact1->City=$city;
								$contact1->State=$state;
								$contact1->Country=$finalCountry;
								$contact1->PostalCode=$pincode;
								$contact1->TimeZone=$timeZone;
							    $contact1->save();

							    Infusionsoft_ContactService::addToGroup($contactId,$book_tag);
								/*Infusionsoft_ContactService::addToGroup($contactId,$pTag);*/
								if(!empty($pTag))
								{
									Infusionsoft_ContactService::addToGroup($contactId,$pTag);
								}
								Infusionsoft_ContactService::addToGroup($contactId,"726");
								if($add==1)
								{
									Infusionsoft_ContactService::addToGroup($contactId,"314");
								}
								if($chkCall == 'on'){
									Infusionsoft_ContactService::addToGroup($contactId,$call_tag);
								}
								$finalContactId=$contactId;
								fwrite($myfile, "\Contact Create IF inside else inside if condition and Contact ID =". $finalContactId);
							}
							else
							{
								$optinreason = "You have signed up to our list by booking an appointment online via our website";
								$contact->save();
								Infusionsoft_EmailService::optIn($contact->Email,$optinreason);
								//$objects = Infusionsoft_DataService::query(new Infusionsoft_Contact(), array('Email' =>$contact->Email));
								Infusionsoft_ContactService::addToGroup($contact->Id,$book_tag);
								if(!empty($pTag))
								{
									Infusionsoft_ContactService::addToGroup($contact->Id,$pTag);
								}
								/*Infusionsoft_ContactService::addToGroup($contact->Id,$pTag);*/
								Infusionsoft_ContactService::addToGroup($contact->Id,"726");
								if($add==1)
								{
									Infusionsoft_ContactService::addToGroup($contact->Id,"314");
								}
								if($chkCall == 'on'){
									Infusionsoft_ContactService::addToGroup($contact->Id,$call_tag);
								}
								$finalContactId=$contact->Id;
								fwrite($myfile, "\Contact Create IF inside else inside else condition and Contact ID =". $finalContactId);
							}
						}
						else
						{
							for($e=0;$e<$lengthEmail;$e++)
							{
								if(strcasecmp(trim($firstName),trim($objects[
									$e]->FirstName))==0)
								{
									$addFlag=1;
									$index=$e;
								}
							}
							if($addFlag==1)
							{
								$contactId = $objects[$index]->Id;
							    $contact1 = new Infusionsoft_Contact($contactId);
							    $contact1->FirstName = $firstName;
							    $contact1->LastName = $lastName;
							    $contact1->Phone1 =$code."-".$number;
							    $contact1->StreetAddress1=$address;
								$contact1->City=$city;
								$contact1->State=$state;
								$contact1->Country=$finalCountry;
								$contact1->PostalCode=$pincode;
								$contact1->TimeZone=$timeZone;
							    $contact1->save();
							  
							    Infusionsoft_ContactService::addToGroup($contactId,$book_tag);
								/*Infusionsoft_ContactService::addToGroup($contactId,$pTag);*/
								if(!empty($pTag))
								{
									Infusionsoft_ContactService::addToGroup($contactId,$pTag);
								}
								Infusionsoft_ContactService::addToGroup($contactId,"726");
								if($add==1)
								{
									Infusionsoft_ContactService::addToGroup($contactId,"314");
								}
								if($chkCall == 'on'){
									Infusionsoft_ContactService::addToGroup($contactId,$call_tag);
								}
								$finalContactId=$contactId;
								fwrite($myfile, "\Contact Create IF inside else inside if condition and Contact ID =". $finalContactId);
							}
							else
							{
								$optinreason = "You have signed up to our list by booking an appointment online via our website";
								$contact->save();
								Infusionsoft_EmailService::optIn($contact->Email,$optinreason);
								Infusionsoft_ContactService::addToGroup($contact->Id,$book_tag);
								if(!empty($pTag))
								{
									Infusionsoft_ContactService::addToGroup($contact->Id,$pTag);
								}
								Infusionsoft_ContactService::addToGroup($contact->Id,"726");
								if($add==1)
								{
									Infusionsoft_ContactService::addToGroup($contact->Id,"314");
								}
								if($chkCall == 'on'){
									Infusionsoft_ContactService::addToGroup($contact->Id,$call_tag);
								}
								$finalContactId=$contact->Id;
								fwrite($myfile, "\Contact Create IF inside else inside else condition and Contact ID =". $finalContactId);
							}
						}
					}
				}
				else
				{
					if(strcasecmp(trim($objectsURL[0]->Email),trim($email))==0)
					{
						$contact2 = new Infusionsoft_Contact($objectsURL[0]->Id);
						$contact2->FirstName = $firstName;
						$contact2->LastName = $lastName;
						$contact2->Email =$email;
						$contact2->Phone1=$code."-".$number;
						$contact2->StreetAddress1=$address;
						$contact2->City=$city;
						$contact2->State=$state;
						$contact2->Country=$finalCountry;
						$contact2->PostalCode=$pincode;
						$contact2->TimeZone=$timeZone;
						$contact2->save();
						$finalContactId=$objectsURL[0]->Id;
						fwrite($myfile, "\Contact Create else inside IF condition and Contact ID =". $finalContactId);
					}
					else
					{
						$contact_e = new Infusionsoft_Contact($objectsURL[0]->Id);
						$contact_e->EmailAddress2=$objectsURL[0]->Email;
						$contact_e->Email=$email;
						$contact_e->save();
						$finalContactId=$objectsURL[0]->Id;
						fwrite($myfile, "\Contact Create else inside else condition and Contact ID =". $finalContactId);
					}
				}
				if(isset($rowGetLocation))
				{
					Infusionsoft_ContactService::addToGroup($finalContactId,$rowGetLocation["tagId"]);
				}
				fwrite($myfile,"\n Business Id=".$busseiness_id);
				$qrySel="SELECT * FROM `bookTagAdd` WHERE `service_id`=$appointmentId";
				$rsltTag=mysqli_query($conn,$qrySel);
				$numTag=mysqli_num_rows($rsltTag);
				if($numTag==1)
				{
					$rowTag=mysqli_fetch_assoc($rsltTag);
					Infusionsoft_ContactService::addToGroup($finalContactId, $rowTag["tag_id"]);
				}
				else
				{
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					$headers .= "From: info@qltech.com.au";
					$mailbody="<br><h3>Add Tag</h3>
					<br>Hello
					<br>Please Insert the Tag for Booked Online Tag of Appointment Id=". $appointmentId."
					<br>
					<br>
					
					<br><br><b>Thank You</b>";
					mail('sunny@qltech.com.au',"Please Insert the Tag in BWS Server",$mailbody,$headers);
				}
				if($chkCall == 'on')
				{
					$requestCallBack="on";
				}
				else
				{
					$requestCallBack="off";
				}

				// Log the appointment
				$clinikoAppId="";
				$arrAppointment=[];
				if(isset($json_App['id'])) 
				{
					$clinikoAppId=$json_App['id'];
					$arrAppointment['appointment_id']=$json_App['id'];
					$arrAppointment['app_start_date']=$json_App['appointment_start'];
					$arrAppointment['app_end_date']=$json_App['appointment_end'];
				}
				$arrAppointment['busseiness_id']=$busseiness_id;
				$arrAppointment['cliniko_patient_id']=$pId_Add;
				$arrAppointment['infusion_contact_id']=$finalContactId;
				$arrAppointment['email']=$email;
				$arrAppointment['first_name']=$firstName;
				$arrAppointment['last_name']=$lastName;
				$arrAppointment['appointment_type_id']=$appointmentId;
				$arrAppointment['dob']=date("Y-m-d",strtotime($dateOfBirth));
				$arrAppointment['practitioner_id']=$practitionerId;
				$arrAppointment['booking_time']=date("Y-m-d H:i:s");
				$arrAppointment['ip_address']=$_SERVER['REMOTE_ADDR'];
				$arrAppointment['address']=$address;
				$arrAppointment['country']=$finalCountry;
				$arrAppointment['mobile_code']=$code;
				$arrAppointment['mobile']=$number;
				$arrAppointment['suburb_city']=$city;
				$arrAppointment['state']=$state;
				$arrAppointment['pincode']=$pincode;
				$arrAppointment['comments']=$comment;
				$arrAppointment['request_callback']=$chkCall;
				$arrAppointment['email_sent']='N';
				$arrAppointment['coupouncode']=$coupoun_code_txt;
				$arrAppointment['utm_campaign']=$utm_campaign;
				$arrAppointment['utm_source']=$utm_source;
				$arrAppointment['utm_medium']=$utm_medium;
				$arrAppointment['utm_term']=$utm_term;
				$arrAppointment['utm_content']=$utm_content;
				$arrAppointment['source']=$source;
				

				// Insert record in database
				$columns=implode(",", array_keys($arrAppointment));
				$arrAppointment=array_map("addslashes", $arrAppointment);

				foreach ($arrAppointment as $key => $value) {
					$arrAppointment[$key]="'".$value."'";
				}

				$values=implode(",", $arrAppointment);

				$qryInsert="INSERT INTO online_booking_form_appointments($columns)
								VALUES($values)";
				$rsltInsert=mysqli_query($conn,$qryInsert);

				//condition check for coupoun code 
				if($success_coupoun_value==1)
				{
					$url=base64_encode("aid=".$appointmentId."&pid=".$practitionerId."&time=".$time."&firstName=".$firstName."&lastName=".$lastName."&email=".$email."&number=".$number."&tId=".$txtTime."&busseiness_id=".$busseiness_id."&call=".$requestCallBack."&clinikoAppId=".$clinikoAppId."&cliniko_patient_id=".$pId_Add."&coupoun_code_txt=".$coupoun_code_txt);
				}
				else
				{	
					$url=base64_encode("aid=".$appointmentId."&pid=".$practitionerId."&time=".$time."&firstName=".$firstName."&lastName=".$lastName."&email=".$email."&number=".$number."&tId=".$txtTime."&busseiness_id=".$busseiness_id."&call=".$requestCallBack."&clinikoAppId=".$clinikoAppId);
			    }


				$url2="aid=".$appointmentId."&pid=".$practitionerId."&time=".$day." ".$time."&fname=".$firstName."&lname=".$lastName."&email=".$email."&number=".$number."&tId=".$txtTime."&busseiness_id=".$busseiness_id."&call=".$requestCallBack."&clinikoAppId=".$clinikoAppId."&utm_campaign=".$utm_campaign."&utm_source=".$utm_source."&utm_medium=".$utm_medium."&utm_term=".$utm_term."&utm_content=".$utm_content;
				$currentPath = $_SERVER['PHP_SELF']; 
				$pathInfo = pathinfo($currentPath); 
				$hostName = $_SERVER['HTTP_HOST']; 
				$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
				$baseurl =  $protocol.'://'.$hostName.$pathInfo['dirname']."/ajax/ajaxdetailmail.php";
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $baseurl);
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
				curl_setopt($ch, CURLOPT_POSTFIELDS, $url2);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				$data = json_decode(curl_exec($ch), TRUE);
				curl_close($ch);
				
				?>
				<form id="successform" method="POST" action="acknowledge.php">
					<input type="hidden" name="aid" value="<?php echo $appointmentId; ?>" />
					<input type="hidden" name="pid" value="<?php echo $practitionerId; ?>" />
					<input type="hidden" name="day" value="<?php echo $day; ?>" />
					<input type="hidden" name="time" value="<?php echo $time; ?>" />
					<input type="hidden" name="firstName" value="<?php echo $firstName; ?>" />
					<input type="hidden" name="lastName" value="<?php echo $lastName; ?>" />
					<input type="hidden" name="email" value="<?php echo $email; ?>" />
					<input type="hidden" name="number" value="<?php echo $number; ?>" />
					<input type="hidden" name="tId" value="<?php echo $txtTime; ?>" />
					<input type="hidden" name="busseiness_id" value="<?php echo $busseiness_id; ?>" />
					<input type="hidden" name="call" value="<?php echo $requestCallBack; ?>" />
					<input type="hidden" name="clinikoAppId" value="<?php echo $clinikoAppId; ?>" />
					<input type="hidden" name="cliniko_patient_id" value="<?php echo $pId_Add; ?>" />
					<input type="hidden" name="coupoun_code_txt" value="<?php echo $coupoun_code_txt; ?>" />
					<input type="hidden" name="success_coupoun_value" value="<?php echo $success_coupoun_value; ?>" />
					<input type="hidden" name="utm_campaign" value="<?php echo $utm_campaign; ?>" />
					<input type="hidden" name="utm_source" value="<?php echo $utm_source; ?>" />
					<input type="hidden" name="utm_medium" value="<?php echo $utm_medium; ?>" />
					<input type="hidden" name="utm_term" value="<?php echo $utm_term; ?>" />
					<input type="hidden" name="utm_content" value="<?php echo $utm_content; ?>" />
					<input type="hidden" name="source" value="<?php echo $source; ?>" />

				</form>
				<script>document.getElementById("successform").submit(); </script>
				<?php
			}
		}
		else
		{
			?>
			<form method="post">
				
			<div id="myModal2" class="no-outer-script-box w-100">
				<div class="row justify-content-center d-flex">
					<div class="col-xl-8 col-lg-9 col-md-12 text-center">
						<div class="modal-content-popup">
							<div class="header-no-script justify-content-between d-flex">
							<h5 class="font-22 mb-0">OOPS!</h5>
							<span class="closePopUp2 font-22 mb-0">&times;</span>
							</div>
							<div class="no-inner-script-box">
								<h5 class="font-22 mb-2">This time slot has already been booked. Please select another time slot to book your session.</h5>
							</div>
						</div>
					</div>
				</div>
			</div>
			  </form>
	  		<?php
		}
	}
	
	}
	
?>	

<!doctype html>
<html lang="en">

<head>
	<title>Booking Details</title>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.css">
	<link
		href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
		rel="stylesheet">
	<link rel="stylesheet" href="assets/css/new-style.css" />
	<link rel="stylesheet" href="assets/css/style.css" />
	<style>
	th.prev span, th.next span {
		color: unset !important;
		background: unset !important;
		border-radius: unset !important;
		width: unset !important;
		height: unset !important;
		line-height: unset !important;
	}
	.table-condensed thead tr:first-child
	{
		background: #337ab7;
		color: white !important;
		height:45px !important;
	}
	.table-condensed thead tr:first-child th
	{
		color:white !important;
	}
	.table-condensed thead tr:last-child th
	{
		margin-bottom:20px !important;
	}
	.bootstrap-datetimepicker-widget table td.day {
		height: 33px !important;
		line-height: 33px !important;
		width: 20px !important;
	}
	.bootstrap-datetimepicker-widget table td, .bootstrap-datetimepicker-widget table th {
		border-radius: 0px !important;
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
					<i id="iPage1" onclick="window.history.go(-2); return false;" class="fa fa-home baricon baricon-one has-tip active" aria-hidden="true"
						data-toggle="tooltip" data-placement="top" title="Step-1"></i>
					<span id="bar1" class="progress_bar active"></span>
					<i id="iPage2" onclick="window.history.go(-1); return false;" class="fa fa-calendar baricon baricon-two has-tip active" aria-hidden="true"
						data-toggle="tooltip" data-placement="top" title="Step-2"></i>
					<span id="bar2" class="progress_bar active"></span>
					<i id="iPage3" class="fa fa-info baricon baricon-three has-tip active" aria-hidden="true"
						data-toggle="tooltip" data-placement="top" title="Step-3"></i>
					<span id="bar3" class="progress_bar"></span>
					<i id="iPage4" class="fa fa-check baricon baricon-four has-tip" aria-hidden="true"
						data-toggle="tooltip" data-placement="top" title="Completed"></i>
				</div>
			</div>
		</div>
		
		<form method="POST" >
				<input type="hidden" name="practitionerId" id="practitionerId" value="<?php echo $practitionerId; ?>" />
					<input type="hidden" name="busseiness_id" id="busseiness_id" value="<?php echo $busseiness_id; ?>" />
					<input type="hidden" name="appointmentId" id="appointmentId" value="<?php echo $appointmentId; ?>" />
					<input type="hidden" name="time" id="time" value="<?php echo $time; ?>" />
					<input type="hidden" name="day" id="day" value="<?php echo $day; ?>" />
					<input type="hidden" name="utm_campaign" id="utm_campaign" class="form-control" value="<?php echo $_POST["utm_campaign"]; ?>"/>
					<input type="hidden" name="utm_source" id="utm_source" class="form-control" value="<?php echo $_POST["utm_source"]; ?>"/>
					<input type="hidden" name="utm_medium" id="utm_medium" class="form-control" value="<?php echo $_POST["utm_medium"]; ?>"/>
					<input type="hidden" name="utm_term" id="utm_term" class="form-control" value="<?php echo $_POST["utm_term"]; ?>"/>
					<input type="hidden" name="utm_content" id="utm_content" class="form-control" value="<?php echo $_POST["utm_content"]; ?>"/>
					<input type="hidden" name="source" id="source" class="form-control" value="<?php echo $_POST["source"]; ?>"/>
			<div class="row">
				<div class="col-xl-8 col-lg-12">
					<div class="card-woborder two divContact mb-4">
						<div>
							<h4 class="font-18 title font-medium">Your Information</h4>
							<p class="font-14 mb-4 font-regular">Please make sure you fill out all information requested.
								Required fields are marked *</p>
							<div class="row mt-2">
								<div class="col-sm-12 col-md-12 col-lg-6">
									<div class="form-group">
										<label id="lblFirst" for="fname" class="font-185 font-regular">First Name*:</label>
										<input type="text" class="form-control text" name="txtFirstName" id="txtFirstName" value="<?php echo $firstName?>" placeholder="First name">
									<span id="spnFirstName" class="spnClass"></span>
									</div>
								</div>
								<div class="col-sm-12 col-md-12 col-lg-6">
									<div class="form-group">
										<label id="lblLast" for="lname" class="font-185 font-regular">Last Name*:</label>
										<input type="text" class="form-control text" name="txtLastName" id="txtLastName" value="<?php echo $lastName?>" placeholder="Last name">
									<span id="spnLastName" class="spnClass"></span>
									</div>
								</div>
								<div class="col-sm-12 col-md-12 col-lg-6">
									<div class="form-group">
										<label id="lblEmail" for="email" class="font-185 font-regular">Email Address*:</label>
										<input type="text" class="form-control text" name="txtEmail" id="txtEmail" value="<?php echo $email?>"<?php echo $read;?> placeholder="Email Address">
										<span class="spnClass" id="spnEmail"></span>
									</div>
								</div>
								<div class="col-sm-12 col-md-12 col-lg-6">
									<div class="form-group">
										<label id="lblDate" for="dob" class="font-185 font-regular">Date of Birth*:</label>
										<input type="text" class="form-control text" value="<?php echo $_POST['datepicker']; ?>" name="datepicker" id="datepicker" placeholder="Date of Birth">
									<span class="spnClass" id="spnDate"></span> 
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<label id="lblAddress" for="address" class="font-185 font-regular">Address*:</label>
										<input type="text" class="form-control text" name="txtAddress" id="txtAddress" value="<?php echo $_POST['txtAddress']; ?>" placeholder="Address">
									<span class="spnClass" id="spnAddress"></span>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="form-group">
										<label id="lblCountry" for="address" class="font-185 font-regular">Country*:</label>
										<select class="js-example-basic-single form-control text" name="state[]" id="country" class="country" onChange="fnCountryCode(this.value);fnCountry()" >
										<option>-Select-</option>
										<option class="lstCounntry" value="AD">Andorra</option>
										<option class="lstCounntry" value="AR">Argentina</option>
										<option class="lstCounntry" value="AS">American Samoa</option>
										<option class="lstCounntry" value="AT">Austria</option>
										<option class="lstCounntry" selected="selected" value="AU">Australia</option>
										<option class="lstCounntry" value="BD">Bangladesh</option>
										<option class="lstCounntry" value="BE">Belgium</option>
										<option class="lstCounntry" value="BG">Bulgaria</option>
										<option class="lstCounntry" value="BR">Brazil</option>
										<option class="lstCounntry" value="CA">Canada</option>
										<option class="lstCounntry" value="CH">Switzerland</option>
										<option class="lstCounntry" value="CZ">Czech Republic</option>
										<option class="lstCounntry" value="DE">Germany</option>
										<option class="lstCounntry" value="DK">Denmark</option>
										<option class="lstCounntry" value="DO">Dominican Republic</option>
										<option class="lstCounntry" value="ES">Spain</option>
										<option class="lstCounntry" value="FI">Finland</option>
										<option class="lstCounntry" value="FO">Faroe Islands</option>
										<option class="lstCounntry" value="FR">France</option>
										<option class="lstCounntry" value="GB">Great Britain</option>
										<option class="lstCounntry" value="GF">French Guyana</option>
										<option class="lstCounntry" value="GG">Guernsey</option>
										<option class="lstCounntry" value="GL">Greenland</option>
										<option class="lstCounntry" value="GP">Guadeloupe</option>
										<option class="lstCounntry" value="GT">Guatemala</option>
										<option class="lstCounntry" value="GU">Guam</option>
										<option class="lstCounntry"  value="GY">Guyana</option>
										<option class="lstCounntry" value="HR">Croatia</option>
										<option class="lstCounntry" value="HU">Hungary</option>
										<option class="lstCounntry" value="IM">Isle of Man</option>
										<option class="lstCounntry" value="IN">India</option>
										<option class="lstCounntry" value="IS">Iceland</option>
										<option class="lstCounntry" value="IT">Italy</option>
										<option class="lstCounntry" value="JE">Jersey</option>
										<option class="lstCounntry" value="JP">Japan</option>
										<option class="lstCounntry" value="LI">Liechtenstein</option>
										<option class="lstCounntry" value="LK">Sri Lanka</option>
										<option class="lstCounntry" value="LT">Lithuania</option>
										<option class="lstCounntry" value="LU">Luxembourg</option>
										<option class="lstCounntry" value="MC">Monaco</option>
										<option class="lstCounntry" value="MD">Moldavia</option>
										<option class="lstCounntry" value="MH">Marshall Islands</option>
										<option class="lstCounntry" value="MK">Macedonia</option>
										<option class="lstCounntry" value="MP">Northern Mariana Islands</option>
										<option class="lstCounntry" value="MQ">Martinique</option>
										<option class="lstCounntry" value="MX">Mexico</option>
										<option class="lstCounntry" value="MY">Malaysia</option>
										<option class="lstCounntry" value="NL">Holland</option>
										<option class="lstCounntry" value="NO">Norway</option>
										<option class="lstCounntry" value="NZ">New Zealand</option>
										<option class="lstCounntry" value="PH">Phillippines</option>
										<option class="lstCounntry" value="PK">Pakistan</option>
										<option class="lstCounntry" value="PL">Poland</option>
										<option class="lstCounntry" value="PM">Saint Pierre and Miquelon</option>
										<option class="lstCounntry" value="PR">Puerto Rico</option>
										<option class="lstCounntry" value="PT">Portugal</option>
										<option class="lstCounntry" value="RE">French Reunion</option>
										<option class="lstCounntry" value="RU">Russia</option>
										<option class="lstCounntry" value="SE">Sweden</option>
										<option class="lstCounntry" value="SI">Slovenia</option>
										<option class="lstCounntry"  value="SJ">Svalbard & Jan Mayen Islands</option>
										<option class="lstCounntry" value="SK">Slovak Republic</option>
										<option class="lstCounntry" value="SM">San Marino</option>
										<option class="lstCounntry" value="TH">Thailand</option>
										<option class="lstCounntry" value="TR">Turkey</option>
										<option class="lstCounntry" value="US">United States</option>
										<option class="lstCounntry" value="VA">Vatican</option>
										<option class="lstCounntry" value="VI">Virgin Islands</option>
										<option class="lstCounntry" value="YT">Mayotte</option>
										<option class="lstCounntry" value="ZA">South Africa</option>
										<option class="lstCounntry" value="other">Other</option>
									</select>
										<input type="text" name="txtOther" id="txtOther" class="form-control " style="display:none" />
										<span class="spnClass" id="spnCountry"></span>
									</div>
								</div>
								<div class="col-sm-12 col-md-12 col-lg-6">
									<div class="form-group">
										<label id="lblPinCode" for="dob" class="font-185 font-regular">Post Code*:</label>
										<input type="text" class="form-control text" value="<?php echo $_POST['txtPinCode']; ?>" name="txtPinCode" id="txtPinCode" class="form-control" onBlur="fnZip()" placeholder="Post Code">
									<span class="spnClass" id="spnPincode"></span>
									</div>
								</div>
								<div class="col-sm-12 col-md-12 col-lg-6">
									<div class="form-group">
										<label  id="lblNumber" class="font-185 font-regular">Mobile Number*:</label>
										<div class="input-group mb-0">
											<div class="input-group-prepend mb-0 mr-2" style="width: 55px;">
												<input type="text" class="form-control text" value="<?php echo ($_POST['txtCode'] != '') ? $_POST['txtCode']:'+61'; ?>" id="txtCode" name="txtCode" placeholder="+61">
											</div>
											
											<input type="text" class="form-control text" value="<?php echo $_POST['txtNumber']; ?>" name="txtNumber" id="txtNumber" value="<?php echo $number?>" placeholder="Mobile Number">
									
										</div><span class="spnClass" id="spnNumber"></span>
									</div>
								</div>
								<div class="col-sm-12 col-md-12 col-lg-6">
									<div class="form-group">
										<label id="lblCity" for="dob" class="font-185 font-regular">Suburb/City*:</label>
										<input type="text" class="form-control text" value="<?php echo $_POST['txtCity']; ?>" name="txtCity" id="txtCity" placeholder="Suburb/City">
									<span class="spnClass" id="spnCity"></span>
									</div>
									<div class="divTableRow divPost" id="divCitySuburb" style="display:none">
									<label>Other City*:</label>
									<input class="form-control text" type="text" name="txtSuburb" id="txtSuburb"  placeholder="Enter Suburb/City"/>
										<span class="spnClass" id="spnSuburb"></span>
								</div>
								</div>
								<div class="col-sm-12 col-md-12 col-lg-6" id="divstate" >
									<div class="form-group">
										<label id="lblState" for="dob" class="font-185 font-regular">State*:</label>
											<input type="text" class="form-control text" value="<?php echo $_POST['txtState']; ?>" name="txtState" id="txtState" placeholder="State">
									<span class="spnClass" id="spnState"></span>
									</div>
								</div>
								<div class="col-sm-12 col-md-12 col-lg-6">
									<div class="form-group">
										<label id="lblcoupouncode" for="dob" class="font-185 font-regular">Coupon Code:</label>
										<input type="text" class="form-control text" value="<?php echo $_POST['txtcoupouncode']; ?>" name="txtcoupouncode" id="txtcoupouncode" placeholder="Coupon Code">
									<span class="spnClass" id="spncoupouncode" style="display: none">Coupon code is invalid</span>
									<input type="hidden" name="success_coupoun_value" id="success_coupoun_value" value="">
									</div>
								</div>
							</div>
						</div>


						<div class="mt-3">
							<h4 class="font-18 title font-medium">Extra Information</h4>
							<div class="row mt-2">
								<div class="col-sm-12">
									<div class="form-group">
										<label for="dob" class="font-185 font-regular">Comments:</label>
										<textarea class="form-control" id="taComments" name="taComments" rows="5"></textarea>
									</div>
								</div>
								<div class="col-sm-12">
									<div class="mt-4">
										<label class="lblRequest font-15">Request Call Back
											<input type="checkbox" class="form-check-input d-none" id="chkCall" name="chkCall">
											<span class="checkmark"></span>
										</label>
									</div>
								</div>
							</div>
						</div>

						<div class="mt-3 mb-2">
							<h4 class="font-18 title font-medium">Terms</h4>
							<p class="font-14 mb-4 font-regular"><?php echo $term; ?></p>
						</div>

						<div class="row mt-3 mb-4">
							<div class="col-sm-6 text-left text-small-center sm-mb-4">
								<button onclick="window.history.go(-1); return false;" class="btn main-border-button" type="button">Back</button>
							</div>
							<div class="col-sm-6 text-right text-small-center">
								<button class="main-select-button" name="btnBookAppointment" type="submit" onClick="return fnDataValidation()" id="BookBtn">Book Appoinment</button>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-4 col-lg-12">	
					<div class="pos-sticky mb-2">		
						<div class="card-woborder two divContact mb-3 ">
							<div>
								<h4 class="font-18 title font-medium">Booking summary</h4>
								<div class="summury-main mb-3">
									<div class="summury-icon">
										<i class="fa fa-map-marker"></i>
									</div>
									<div class="summury-data">
										<address class="mb-0 font-16 font-regular">
											<b><?php echo $business_name;?></b><br>
											<?php echo $business_address;?>,<br>
											<?php echo $business_city;?>,<?php echo $business_state;?> <?php echo $business_post_code;?><br>
											
											
										</address>
										
									</div>
								</div>
								<div class="summury-main mb-3">
									<div class="summury-icon">
										<i class="fa fa-calendar-check-o"></i>
									</div>
									<div class="summury-data">
										<p class="mb-0 font-16 font-regular"><?php echo $_POST['sname']; ?></p>
										<?php 
											if($_POST['srate'] != 0){
												if($_POST['srate2'] !=0){	
										?>
										<p class="mb-0 font-16 font-regular"><span style="text-decoration:line-through;" > $<?php echo round($_POST['srate2']); ?> </span> <b>$<?php echo round($_POST['srate']); ?></b></p>
										<?php
												}
												else{
										?>
										<p class="mb-0 font-16 font-regular">$<?php echo round($_POST['srate']); ?></p>
										<?php		
												}
										
											}
										?>
									</div>
								</div>
								<div class="summury-main mb-3">
									<div class="summury-icon">
										<i class="fa fa-user-o"></i>
									</div>
									<div class="summury-data">
										<p class="mb-0 font-16 font-regular"><?php echo $_POST['pname']; ?></p>
									</div>
								</div>
								<div class="summury-main">
									<div class="summury-icon">
										<i class="fa fa-clock-o"></i>
									</div>
									<div class="summury-data">
										<p class="mb-0 font-16 font-regular"><?php echo date('g:ia \o\n l jS F Y',strtotime($day." ".$time)); ?></p>
									</div>
								</div>
							</div>
						</div>
						<div class="mb-3">
							<p class=" color-80 mb-0 font-14">This is an online appointment booking service. The appointment fees are payable at the end of your session. Payment can be made by cash or card.</p>					
						</div>
					</div>	
				</div>
			</div>
		</form>
		
		
				
			</div>
		</div>
	</div>

	
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

	<!-- condition-script-box  -->

	<div class="condition-script-box" >
		<div class="row justify-content-center d-flex">
			<div class="col-xl-8 col-lg-9 col-md-12 text-center">
				<div class="header-no-script">
					<h5 class="font-22 mb-0">Opps..</h5>
				</div>
				<div class="no-inner-script-box">
					<h5 class="font-22 mb-2">Our system indicates that Javascript is disabled in your Browser. 
						To continue booking your session, enable the Javascript following the instructions given in this </h5>
					<a href="https://www.whatismybrowser.com/guides/how-to-enable-javascript/" target="_blank" class="font-22 title-color d-block">Click Here</a>
				</div>
			</div>
		</div>
	</div>

	<!--  -->
	
	<script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/popper.min.js" ></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/js/select2.full.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.9/css/select2.min.css" rel="stylesheet"/>
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
	<script type="text/javascript">
		$(function () {
			$('#datepicker').datetimepicker({
				showTodayButton: false,
				format: 'DD-MM-YYYY',
				icons: {
                    time: "fa fa-clock-o",
                    date: "fa fa-calendar",
                    up: "fa fa-arrow-up",
                    down: "fa fa-arrow-down",
					previous: "fa fa-angle-left",
					next: "fa fa-angle-right",
                },
			});
			
		});
    </script>
	<script>
		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		})
	</script>	
	<script type="text/javascript">
		$(document).ready(function(){
			if($('#txtcoupouncode').val() != ''){
				var coupoun_code = $('#txtcoupouncode').val();
				if(coupoun_code){
					$.ajax({
						type:'POST',
						url:'check_coupoun_booking.php',
						dataType:'json',
						data:'coupoun_code='+coupoun_code,
						success:function(data){

							if(data.success_coupoun=='')
							{
									$('#spncoupouncode').show();
							}
							else
							{
									$('#success_coupoun_value').val(data.success_coupoun);
									$('#spncoupouncode').hide();
							}
							
						}
					}); 
				}
			}
		
			$('#txtcoupouncode').on('blur',function(){
				var coupoun_code = $(this).val();
				//alert(coupoun_code);
				if(coupoun_code){
					$.ajax({
						type:'POST',
						url:'check_coupoun_booking.php',
						dataType:'json',
						data:'coupoun_code='+coupoun_code,
						success:function(data){

							if(data.success_coupoun=='')
							{
									$('#spncoupouncode').show();
							}
							else
							{
									$('#success_coupoun_value').val(data.success_coupoun);
									$('#spncoupouncode').hide();
							}
							
						}
					}); 
				}
			});
			$(".form-control").on("blur",function () {
					var flag=0;
					var txt_id = this.id;
					var objId=document.getElementById(txt_id);
					if(txt_id=="txtFirstName")
					{
						var objFirstName=document.getElementById("txtFirstName");
						var regExp=/^[a-zA-Z\s]+$/;
						var check=regExp.test(objFirstName.value.trim());
						$( "#"+ txt_id+" + span").html("");
						$msg="First Name is Required."
						if(objId.value.trim()=="")
						{
							$( "#"+ txt_id+" + span").html($msg);
						}
						else if(check == false)
						{
							document.getElementById("spnFirstName").innerHTML ="Please Enter a Correct Value";
						}
					}
					else if(txt_id=="txtLastName")
					{
						var objLastName=document.getElementById("txtLastName");
						var regExp=/^[a-zA-Z\s]+$/;
						var check=regExp.test(objLastName.value.trim());
						$( "#"+ txt_id+" + span").html("");
						$msg="Last Name is Required."
						if(objId.value.trim()=="")
						{
							$( "#"+ txt_id+" + span").html($msg);
						}
						else if(check == false)
						{
							document.getElementById("spnLastName").innerHTML ="Please Enter a Correct Value";
						}
					}
					else if(txt_id == "txtEmail")
					{
						document.getElementById("spnEmail").innerHTML="";
						$msg="Please Enter a Email Address";
						var regExp=/^[a-zA-Z0-9._+%-]+@[a-zA-Z0-9._]+\.[a-zA-Z]+$/;
						var check=regExp.test(objId.value.trim());
						if(objId.value.trim()=="")
						{
							$( "#"+ txt_id+" + span").html($msg);
							$flag=1;
						}
						else if(check == false){
							document.getElementById("spnEmail").innerHTML ="Please Enter a Correct Email Address";
							flag=1;
						}
					}
					else if(txt_id == "txtAddress")
					{	
						document.getElementById("spnAddress").innerHTML="";
						var objAddress=document.getElementById("txtAddress");
						if(objAddress.value.trim() == ""){
							document.getElementById("spnAddress").innerHTML="Address is Required.";
							//flag=1;
						}
					}
					else if(txt_id=="txtPinCode")
					{
						document.getElementById("spnPincode").innerHTML="";
						var objPincode=document.getElementById("txtPinCode");
						var regExp=/^[a-zA-Z0-9\s]+$/;
						var checkExp=regExp.test(objPincode.value.trim());
						if(objPincode != null){
							var check=isNaN(objPincode.value.trim());
							if(objPincode.value.trim() == ""){
								document.getElementById("spnPincode").innerHTML="Post Code is Required.";
							}
							else if(checkExp==false)
							{
								document.getElementById("spnPincode").innerHTML="Please Enter valid Post Code";
							}
						}
						
					}
					else if(txt_id=='txtOther')
					{
						document.getElementById("spnCountry").innerHTML="";
						var objOther=document.getElementById("txtOther");
						var regExp=/^[a-zA-Z\s]+$/;
						var checkExp=regExp.test(objOther.value.trim());
						if(objOther.value.trim() == ""){
							document.getElementById("spnCountry").innerHTML="Please Enter Country Value";
						}
						else if(checkExp==false)
						{
							document.getElementById("spnCountry").innerHTML="Please Enter valid Value";
						}
					}
					else if(txt_id == "txtNumber")
					{
						document.getElementById("spnNumber").innerHTML="";
						var mobile=document.getElementById("txtNumber").value.trim();
						var length=mobile.length;
						var check=isNaN(mobile);
						if(check == true || mobile == ""){
							document.getElementById("spnNumber").innerHTML ="Please Enter a Mobile Number";
							//flag=1;
						}
						else if(check== true){
							document.getElementById("spnNumber").innerHTML ="Enter Only Numeric value for Mobile";
							//flag=1;
						}
						else if(length <7 || length >= 15)
						{
							document.getElementById("spnNumber").innerHTML ="Please Enter Valid Mobile Number ";
						}
					}
					else if(txt_id=="txtCity")
					{
						document.getElementById("spnCity").innerHTML="";
						var objCity=document.getElementById("txtCity");
						var regExp=/^[a-zA-Z\s]+$/;
						var check=regExp.test(objCity.value.trim());
						if(objCity.value.trim() == ""){
							document.getElementById("spnCity").innerHTML="City is Required.";
						}
						else if(check == false){
						document.getElementById("spnCity").innerHTML ="Please Enter a Correct Value";
						}
					}
					else if(txt_id=="txtSuburb")
					{
						document.getElementById("spnSuburb").innerHTML="";
						var objSuburb=document.getElementById("txtSuburb");
						var regExp=/^[a-zA-Z\s]+$/;
						var check=regExp.test(objSuburb.value.trim());
						if(objSuburb.value.trim() == ""){
							document.getElementById("spnSuburb").innerHTML="City is Required.";
						}
						else if(check == false){
						document.getElementById("spnSuburb").innerHTML ="Please Enter a Correct Value";
						}
					}
					else if(txt_id=="txtState")
					{
						document.getElementById("spnState").innerHTML="";
						var objState=document.getElementById("txtState");
						var regExp=/^[a-zA-Z\s]+$/;
						var check=regExp.test(objState.value.trim());
						if(objState.value.trim() == ""){
							document.getElementById("spnState").innerHTML="State is Required.";
						}
						else if(check == false){
						document.getElementById("spnState").innerHTML ="Please Enter a Correct Value";
						}
					}
					else if(txt_id=="datepicker")
					{
						document.getElementById("spnDate").innerHTML="";
						var objDate=document.getElementById("datepicker");
						if(objDate.value.trim() == ""){
							document.getElementById("spnDate").innerHTML="Please Select a Birth Date";
						}
						else
						{
							dob=objDate.value.trim()
							var objDateRegex=new RegExp("^(((([0][1-9])|([12][0-9])|([3][0-1]))(-)((01)|(03)|(05)|(07)|(08)|(10)|(12))(-)([0-9]{4}))|(((([0][1-9])|([12][0-9])|(30))(-)((04)|(06)|(09)|(11))(-)([0-9]{4})))|(((([0][1-9])|([1][0-9])|([2][0-8]))(-)((02))(-)([0-9]{4})))|(((([0][1-9])|([12][0-9]))(-)((02))(-)([0-9]{2}(([0][48])|([13579][26]|([2468][048]))))))|(((([0][1-9])|([12][0-9]))(-)((02))(-)((([0][48])|([13579][26])|([2468][048]))[00]{2}))))$");

							if(objDateRegex.test(dob))
							{

							}
							else
							{
								document.getElementById("spnDate").innerHTML="Please enter valid Birth Date(dd-mm-yyyy).";
							}

						}
					}
		    	});
		});
		
		function fnScroll(strId){
			$('html, body').animate({
		 		scrollTop: $("#"+strId).offset().top
			}, 500);
		}
		
		
		function fnCountryCode(strCity)
			{
				document.getElementById("txtCode").value="";
				if(strCity != 'other'){
					document.getElementById("txtOther").style.display="none";
					var client = new XMLHttpRequest();
					client.open("GET", "https://restcountries.eu/rest/v2/alpha/"+strCity, true);
					client.send();
					client.onreadystatechange = function() {
						if(client.readyState == 4 && this.status == 200){
							var arr=JSON.parse(client.responseText);		
							document.getElementById("txtCode").value="+"+arr.callingCodes;
						}
					};
				}
				else
				{
					document.getElementById("txtOther").style.display="block";
					document.getElementById("txtState").value="";
					document.getElementById("txtCity").value="";
				}
			}
			
			function fnSuburb()
			{
				var objSuburb=document.getElementById("txtCity");
				if(objSuburb != null)
				{
					if(objSuburb.value.trim()=="otherCity")
					{
						document.getElementById("divCitySuburb").style.display="block";
						document.getElementById("divstate").style.cssFloat = "left";
					}
					else
					{
						document.getElementById("divstate").style.cssFloat = "right";
						document.getElementById("divCitySuburb").style.display="none";
					}
				}
			}
			function fnCountry()
			{
				flag=0;
				document.getElementById("spnCountry").innerHTML="";
				var objCountry=document.getElementById("country");
				if(objCountry.value.trim() == "-Select-"){
					document.getElementById("spnCountry").innerHTML="Please Select a Country.";
					flag=1;
				}
				if(flag==1){
					return false;
				}
				else
				{
					return true;
				}
			}
			function fnZip(){
				var objCity=document.getElementById("country").value;
				if(objCity != 'other'){
					document.getElementById("txtOther").style.display="none";
					var zip=document.getElementById("txtPinCode").value;
					document.getElementById("txtState").value="";
					document.getElementById("txtCity").value="";
					var client = new XMLHttpRequest();
					client.open("GET", "https://api.zippopotam.us/"+objCity+"/"+zip, true);
					client.send();
					client.onreadystatechange = function() {
						if(client.readyState == 4 && this.status == 200){
							var arr=JSON.parse(client.responseText);
							if(arr["places"].length>1)
							{
								jQuery("input[name='txtCity']").replaceWith('<select name="txtCity" id="txtCity" class="js-example-basic-single form-control" onChange="fnSuburb()"></select><div class="divCity"></div>');
		                        jQuery("select[name='txtCity']").empty();
		                        
		                        var myDDL = document.getElementById("txtCity");
		 						var option = document.createElement("option");
	                            option.text = "-Select-";
	                            option.value = "-Select-";
	                            myDDL.options.add(option);
		                        for (i = 0; i < arr['places'].length; i++) {
		                           	var option = document.createElement("option");
		                            option.text = arr['places'][i]['place name'];

		                            option.value = arr['places'][i]['place name'];
		                            try {
		                                myDDL.options.add(option);
		                            }
		                            catch (e) {
		                                alert(e);
		                            }
		                        }
		                        option.text = "Other";
	                            option.value = "otherCity";
	                            myDDL.options.add(option);
		                        var state=arr["places"][0]["state"];
								document.getElementById("txtState").value=state;
		                        document.getElementById("spnCity").innerHTML="";
								document.getElementById("spnState").innerHTML="";
								var $example = jQuery(".js-example-basic-single").select2({width: '100%', placeholder: "Select an Option", allowClear: true,closeOnSelect: true});
		                        $(".select2-results__option").on("click", function () {
									//$example.select2("open");
									console.log("WWW");
								});
							}
							else
							{
								jQuery("select[name='txtCity']").replaceWith('<input class="form-control" type="text" name="txtCity" id="txtCity" />');
								$("#txtCity + .select2").remove();
								jQuery("input[name='txtCity']").empty();
								document.getElementById("divCitySuburb").style.display="none";
								document.getElementById("divstate").style.cssFloat = "right";
								var city=arr["places"][0]["place name"];
								var state=arr["places"][0]["state"];
								document.getElementById("txtState").value=state;
								document.getElementById("txtCity").value=city;
								document.getElementById("spnCity").innerHTML="";
								document.getElementById("spnState").innerHTML="";
							}		
						}
					};
				}
				else{
					document.getElementById("txtOther").style.display="block";
					document.getElementById("txtState").value="";
					document.getElementById("txtCity").value="";
				}
			}
			function fnDataValidation(){
				var flag=0;
				var objFirstName=document.getElementById("txtFirstName");
				var objLastName=document.getElementById("txtLastName");
				var objDate=document.getElementById("datepicker");
				var objEmail=document.getElementById("txtEmail");
				var objNumber=document.getElementById("txtNumber");
				var objAddress=document.getElementById("txtAddress");
				var objPincode=document.getElementById("txtPinCode");
				var objCountry=document.getElementById("country");
				var objCity=document.getElementById("txtCity");
				var objSuburb=document.getElementById("txtSuburb");
				var objState=document.getElementById("txtState");
				document.getElementById("spnFirstName").innerHTML="";
				document.getElementById("spnLastName").innerHTML="";
				document.getElementById("spnDate").innerHTML="";
				document.getElementById("spnEmail").innerHTML ="";
				document.getElementById("spnNumber").innerHTML="";
				document.getElementById("spnAddress").innerHTML="";
				document.getElementById("spnPincode").innerHTML="";
				document.getElementById("spnCountry").innerHTML="";
				document.getElementById("spnCity").innerHTML="";
				document.getElementById("spnState").innerHTML="";
				document.getElementById("spnSuburb").innerHTML="";
				//For First Name..........................
				$("#loder").show();
				if(objFirstName != null){
					var regExp=/^[a-zA-Z\s]+$/;
					var check=regExp.test(objFirstName.value.trim());
					if(objFirstName.value.trim() == ""){
						document.getElementById("spnFirstName").innerHTML="First Name is Required.";
						fnScroll("lblFirst");
						flag=1;
					}
					else if(check == false){
						document.getElementById("spnFirstName").innerHTML ="Please Enter a Correct Value";
						fnScroll("lblFirst");
						flag=1;
					}
				}

				//For Last Name............................

				if(objLastName != null){
					var regExp=/^[a-zA-Z\s]+$/;
					var check=regExp.test(objLastName.value.trim());
					if(objLastName.value.trim() == ""){
						document.getElementById("spnLastName").innerHTML="Last Name is Required";
						if(flag != 1)
						{
							fnScroll("lblLast");
						}
						flag=1;
					}
					else if(check == false){
						document.getElementById("spnLastName").innerHTML ="Please Enter a Correct Value";
						if(flag != 1)
						{
							fnScroll("lblLast");
						}
						flag=1;
					}
				}
	
				
		
				//For Email...............................

				if(objEmail != null){
					//var regExp=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
					var regExp=/^[a-zA-Z0-9._+%-]+@[a-zA-Z0-9._]+\.[a-zA-Z]+$/;
					var check=regExp.test(objEmail.value.trim());
					if(objEmail.value.trim() == ""){
						document.getElementById("spnEmail").innerHTML ="Please Enter a Email Address";
						if(flag != 1)
						{
							fnScroll("lblEmail");
						}
						flag=1;
					}
					else if(check == false){
						document.getElementById("spnEmail").innerHTML ="Please Enter a Correct Email Address";
						if(flag != 1)
						{
							fnScroll("lblEmail");
						}
						flag=1;
					}
				}
			
				//For Birth Date........................................

				if(objDate != null)
				{
					if(objDate.value ==""){
						document.getElementById("spnDate").innerHTML ="Please Select a Birth Date";
						if(flag != 1)
						{
							fnScroll("lblDate");
						}
						flag=1;
					}
					else
					{
						var dob=objDate.value.trim()
						var objDateRegex=new RegExp("^(((([0][1-9])|([12][0-9])|([3][0-1]))(-)((01)|(03)|(05)|(07)|(08)|(10)|(12))(-)([0-9]{4}))|(((([0][1-9])|([12][0-9])|(30))(-)((04)|(06)|(09)|(11))(-)([0-9]{4})))|(((([0][1-9])|([1][0-9])|([2][0-8]))(-)((02))(-)([0-9]{4})))|(((([0][1-9])|([12][0-9]))(-)((02))(-)([0-9]{2}(([0][48])|([13579][26]|([2468][048]))))))|(((([0][1-9])|([12][0-9]))(-)((02))(-)((([0][48])|([13579][26])|([2468][048]))[00]{2}))))$");

						if(objDateRegex.test(dob))
						{

						}
						else
						{
							document.getElementById("spnDate").innerHTML="Please enter valid Birth Date(dd-mm-yyyy).";
							if(flag != 1)
							{
								fnScroll("lblDate");
							}
							flag=1;
						}	
					}
				}

				//For Address...........................

				if(objAddress != null){
					if(objAddress.value.trim() == ""){
						document.getElementById("spnAddress").innerHTML="Address is Required.";
						if(flag != 1)
						{
							fnScroll("lblAddress");
						}
						flag=1;
					}
				}

				//For Pincode..................................

				if(objPincode != null){
					var regExp=/^[a-zA-Z0-9\s]+$/;
					var checkExp=regExp.test(objPincode.value.trim());
					if(objPincode.value.trim() == ""){
						document.getElementById("spnPincode").innerHTML="Post Code is Required.";
						if(flag != 1)
						{
							fnScroll("lblPinCode");
						}
						flag=1;
					}
					else if(checkExp==false)
					{
						document.getElementById("spnPincode").innerHTML="Please Enter valid Post Code";
						if(flag != 1)
						{
							fnScroll("lblPinCode");
						}
						flag=1;
					}
				}

				//For Country...........................
				
				if(objCountry != null){
					if(objCountry.value.trim() == "-Select-"){
						document.getElementById("spnCountry").innerHTML="Please Select a Country.";
						if(flag != 1)
						{
							fnScroll("lblCountry");
						}
						flag=1;
					}
				}

				//For Number............................

				if(objNumber != null){
					var mobile=objNumber.value.trim();
					var length=objNumber.value.length;
					var check=isNaN(mobile);
					if(check == true || mobile == ""){
						document.getElementById("spnNumber").innerHTML ="Please Enter a Mobile Number";
						if(flag != 1)
						{
							fnScroll("lblNumber");
						}
						flag=1;
					}
					else if(check== true){
						document.getElementById("spnNumber").innerHTML ="Enter Only Numeric value for Mobile";
						if(flag != 1)
						{
							fnScroll("lblNumber");
						}
						flag=1;
					}
					else if(length < 7 || length >= 15)
					{
						document.getElementById("spnNumber").innerHTML ="Please Enter Valid Mobile Number ";
						if(flag != 1)
						{
							fnScroll("lblNumber");
						}
						flag=1;
					}
				}


				//For City.....................................

				if(objCity != null){
					var regExp=/^[a-zA-Z\s]+$/;
					var check=regExp.test(objCity.value.trim());
					if(objCity.value.trim() == ""){
						document.getElementById("spnCity").innerHTML="City is Required.";
						if(flag != 1)
						{
							fnScroll("lblCity");
						}
						flag=1;
					}
					else if(check == false){
						document.getElementById("spnCity").innerHTML ="Please Enter a Correct Value";
						if(flag != 1)
						{
							fnScroll("lblCity");
						}
						flag=1;
					}
				}

				if(objSuburb != null)
				{
					var objStyle=document.getElementById("divCitySuburb").style.display;
					if(objStyle != "none")
					{
						var regExp=/^[a-zA-Z\s]+$/;
						var check=regExp.test(objSuburb.value.trim());
						if(objSuburb.value.trim() == ""){
							document.getElementById("spnSuburb").innerHTML="City is Required.";
							if(flag != 1)
							{
								fnScroll("lblCity");
							}
							flag=1;
						}
						else if(check == false){
							document.getElementById("spnSuburb").innerHTML ="Please Enter a Correct Value";
							if(flag != 1)
							{
								fnScroll("lblCity");
							}
							flag=1;
						}
					}
				}

				if(objState != null){
					var regExp=/^[a-zA-Z\s]+$/;
					var check=regExp.test(objState.value.trim());
					if(objState.value.trim() == ""){
						document.getElementById("spnState").innerHTML="State is Required.";
						if(flag != 1)
						{
							fnScroll("lblState");
						}
						flag=1;
					}
					else if(check == false){
						document.getElementById("spnState").innerHTML ="Please Enter a Correct Value";
						if(flag != 1)
						{
							fnScroll("lblState");
						}
						flag=1;
					}
				}
				if(flag==1){
					$("#loder").hide();
					return false;
				}
				else{
				
					return true;
				}
				/*else{
					var idTime=document.getElementById("hidTime").value;
					var intSecond=document.getElementById("secondelement").innerHTML;
					var xmlHttp = new XMLHttpRequest();
	                xmlHttp.open("GET", "ajax/ajaxTimerDetails.php?timeId=" + idTime+"&second="+intSecond, true);
	                xmlHttp.send();
	                xmlHttp.onreadystatechange = function (){
	                    if (xmlHttp.readyState == 4){
	                    	$("#BookBtn").attr("disabled", "disabled");
	                    	//document.getElementById("BookBtn").readOnly = true;
							return true;
	                    }
	                }
				}*/
			}
  </script>
  <script>
	  
	$(".closePopUp1").on("click", function () {
		$("#myModal1").hide();
	});

	$(".closePopUp2").on("click", function () {
		$("#myModal2").hide();
	});
 
</script>
	</body>
</html>