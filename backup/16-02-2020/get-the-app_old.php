<?php 

include('../Bws-consumer-panel/html/config.php');
include('../Analytics/lib/Segment.php');
use Segment;

// Segment::init('jIBbMd1o4H2Qdk2PBl0jHj9OhpDf2yXk');      // vishva segment key
Segment::init('wmVVmc1rB9PZbPsGiJBDX0IcbVuNdBcf');         // live segment key

$data = array();
$mobile11 = $_GET['mobile'];
$getphone1 = $_GET['phone1'];
$getphone2 = $_GET['phone2'];

$iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
$iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
$Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
$webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");

$UserID = "";
$planStatus = "";
$planStartDt = "";
$planExpiryDt = "";
$clinikoId = "";
$mobileNo = "";
$up = "";
$userName ="";


if((isset($_GET['phone1']) && $_GET['phone1'] != '') OR (isset($_GET['phone2'])  && $_GET['phone2'] != '') && $_POST['submit'] != 'GET THE APP'){
    $mobilenumber1 = $_GET['phone1'];
    $mobilenumber2 = $_GET['phone2'];
        $flag=true;
        $mobile=trim($mobilenumber1);
        $mobile=preg_replace('/[^0-9]/','', $mobile);
        $mobile=preg_replace ( "/^0/","",$mobile);
        $mobile=preg_replace ( "/^61/","",$mobile);   //change by vishva on 25/11 for US number check

        
        $length=strlen($mobile);
     
        $firstPart=substr($mobile,0,1);
        $first2Part=substr($mobile,0,2);
        $first3Part=substr($mobile,0,3);
        if($length > 9){
            $flag=false;
        }
        if($length < 9){
            $flag=false;
        }
        else if($length == 9){
            if($firstPart == "4"){}
            else{
                $flag=false;
            }
        }
        if($flag){
            $mobile="0".$mobile;
            // $mobile=$mobile;
        }
        else{
            $mobile=$mobile;
            $flag=false;
        }
        
    $query = mysqli_query($conn_db,"SELECT * FROM wp_sub WHERE _billing_phone = '$mobile' OR  _billing_phone_2 = '$mobile' ORDER BY id DESC");
    $data = mysqli_fetch_array($query);

    $UserID = $data['id'];
    $userName = $data['_billing_first_name'];
    $mobileNo = $mobilenumber1;

    $plancheck = $data['Plan'];
    if($plancheck == 1){
        $up = 'Monthly';
    }elseif ($plancheck == 2) {
        $up = 'Six Monthly';
    }elseif ($plancheck == 3) {
        $up = 'Yearly';
    }else{
        $up = "";
    }

    $planStatus = 1;
    $PlanEndDatestr = strtotime($data['PlanEndDate']);
    $curdatestr = strtotime(date("Y-m-d H:i:s"));
    if($plancheck == 5){
        $planStatus = 3;
    }
    if($plancheck == 4){
        if($PlanEndDatestr > $curdatestr){
            $planStatus = 4;
        }
        else{
            $planStatus = 2;
        }
    }
    $planStartDt = $data['PlanSatrtDate'];
    $planExpiryDt = $data['PlanEndDate'];
    $clinikoId = $data['patient_id'];

    Segment::identify(array(
      "userId" => $UserID,
      "traits" => array(
        "userId" => $UserID,
        "userName" => $userName,
        "mobileNo" => $mobilenumber2,
        "plan" => $up,
        "planStatus" => $planStatus,
        "planStartDt" => $planStartDt,
        "planExpiryDt" => $planExpiryDt,
        "clinikoId" => $clinikoId
      )
    ));

    Segment::page(array(
      "userId" => $UserID,
      "name" => "Get The App Page Viewed",
      "properties" => array(
        "userId" => $UserID,
        "source" => "From link",
        "userName" => $userName,
        "mobileNo" => $mobileNo,
        "plan" => $up,
        "planStatus" => $planStatus,
        "planStartDt" => $planStartDt,
        "planExpiryDt" => $planExpiryDt,
        "clinikoId" => $clinikoId
      )
    ));
    
 }
 if(isset($_GET['mobile']) && $_GET['mobile'] != '' && $_POST['submit'] != 'GET THE APP'){

    $mobilenumber1 = $_GET['mobile'];
    $query = mysqli_query($conn_db,"SELECT * FROM wp_sub WHERE _billing_phone = '$mobilenumber1' OR _billing_phone_2 = '$mobilenumber1' ORDER BY id DESC");
    $data = mysqli_fetch_array($query);

    $UserID = $data['id'];
    $userName = $data['_billing_first_name'];
    $mobileNo = $mobilenumber1;

    $plancheck = $data['Plan'];
    if($plancheck == 1){
        $up = 'Monthly';
    }elseif ($plancheck == 2) {
        $up = 'Six Monthly';
    }elseif ($plancheck == 3) {
        $up = 'Yearly';
    }else{
        $up = "";
    }

    $planStatus = 1;
    $PlanEndDatestr = strtotime($data['PlanEndDate']);
    $curdatestr = strtotime(date("Y-m-d H:i:s"));
    if($plancheck == 5){
        $planStatus = 3;
    }
    if($plancheck == 4){
        if($PlanEndDatestr > $curdatestr){
            $planStatus = 4;
        }
        else{
            $planStatus = 2;
        }
    }
    $planStartDt = $data['PlanSatrtDate'];
    $planExpiryDt = $data['PlanEndDate'];
    $clinikoId = $data['patient_id'];

    Segment::identify(array(
      "userId" => $UserID,
      "traits" => array(
        "userId" => $UserID,
        "userName" => $userName,
        "mobileNo" => $mobilenumber1,
        "plan" => $up,
        "planStatus" => $planStatus,
        "planStartDt" => $planStartDt,
        "planExpiryDt" => $planExpiryDt,
        "clinikoId" => $clinikoId
      )
    ));

    Segment::page(array(
      "userId" => $UserID,
      "name" => "Get The App Page Viewed",
      "properties" => array(
        "userId" => $UserID,
        "source" => "Thank you page",
        "userName" => $userName,
        "mobileNo" => $mobilenumber1,
        "plan" => $up,
        "planStatus" => $planStatus,
        "planStartDt" => $planStartDt,
        "planExpiryDt" => $planExpiryDt,
        "clinikoId" => $clinikoId
      )
    ));


 }


if(($_GET['mobile'] == '') && ($_GET['phone2'] == '') && ($_GET['phone1'] == '')  && $_POST['submit'] != 'GET THE APP'){
    Segment::track(array(
      "userId" => "Null",
      "event" => "Get The App Page Viewed",
      "properties" => array(
        "source" => "Login page"
      )
    ));
}

if(($_GET['mobile'] == '') && ($_GET['phone2'] == '') && ($_GET['phone1'] == '')  && $_POST['submit'] == 'GET THE APP'){ 
    $res_segment = Segment::track(array(
      "userId" => "Null",
      "event" => "Get The App Clicked",
      "properties" => array(
        "userName" => "",
        "mobileNo" => "",
        "plan" => "",
        "planStatus" => "",
        "planStartDt" => "",
        "planExpiryDt" => "",
        "clinikoId" => "",
      )
    ));

    if ($Android) {
        header('location:https://play.google.com/store/apps/details?id=com.brainwellnessspa');
    }else{
        header('location:https://apps.apple.com/au/app/brain-wellness-spa/id1534412422');
    }
}
if (isset($_POST['submit']) && (($mobile11 != '') OR ($getphone1 != ''))) { 

    if($mobile11 != ''){
        $query = mysqli_query($conn_db,"SELECT * FROM wp_sub WHERE _billing_phone = '$mobile11' OR  _billing_phone_2 = '$mobile11' ORDER BY id DESC");
    }
    if($getphone1 != ''){

        $flag=true;
        $mobile=trim($getphone1);
        $mobile=preg_replace('/[^0-9]/','', $mobile);
        $mobile=preg_replace ( "/^0/","",$mobile);
        $mobile=preg_replace ( "/^61/","",$mobile);   //change by vishva on 25/11 for US number check

        
        $length=strlen($mobile);
     
        $firstPart=substr($mobile,0,1);
        $first2Part=substr($mobile,0,2);
        $first3Part=substr($mobile,0,3);
        if($length > 9){
            $flag=false;
        }
        if($length < 9){
            $flag=false;
        }
        else if($length == 9){
            if($firstPart == "4"){}
            else{
                $flag=false;
            }
        }
        if($flag){
            $mobile="0".$mobile;
            // $mobile=$mobile;
        }
        else{
            $mobile=$mobile;
            $flag=false;
        }
        
    $query = mysqli_query($conn_db,"SELECT * FROM wp_sub WHERE _billing_phone = '$mobile' OR  _billing_phone_2 = '$mobile' ORDER BY id DESC");
    }
    
    $data = mysqli_fetch_array($query);
    $UserID = $data['id'];
    $userName = $data['_billing_first_name'];
    $mobileNo = $data['_billing_phone'];

    $plancheck = $data['Plan'];
    if($plancheck == 1){
        $up = 'Monthly';
    }elseif ($plancheck == 2) {
        $up = 'Six Monthly';
    }elseif ($plancheck == 3) {
        $up = 'Yearly';
    }else{
        $up = "";
    }

    $planStatus = 1;
    $PlanEndDatestr = strtotime($data['PlanEndDate']);
    $curdatestr = strtotime(date("Y-m-d H:i:s"));
    if($plancheck == 5){
        $planStatus = 3;
    }
    if($plancheck == 4){
        if($PlanEndDatestr > $curdatestr){
            $planStatus = 4;
        }
        else{
            $planStatus = 2;
        }
    }
    $planStartDt = $data['PlanSatrtDate'];
    $planExpiryDt = $data['PlanEndDate'];
    $clinikoId = $data['patient_id'];


    $res_segment = Segment::track(array(
      "userId" => $UserID,
      "event" => "Get The App Clicked",
      "properties" => array(
        "userId" => $UserID,
        "userName" => $userName,
        "mobileNo" => $mobileNo,
        "plan" => $up,
        "planStatus" => $planStatus,
        "planStartDt" => $planStartDt,
        "planExpiryDt" => $planExpiryDt,
        "clinikoId" => $clinikoId
      )
    ));

    if ($Android) {
        header('location:https://play.google.com/store/apps/details?id=com.brainwellnessspa');
    }else{
        header('location:https://apps.apple.com/au/app/brain-wellness-spa/id1534412422');
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="https://brainwellnessspa.com.au/wp-content/uploads/2020/04/cropped-favicon-32x32.png" type="image/png" />
    <link rel="stylesheet" href="../bwsmembershipstaging/html/css/bootstrap.min.css">
    <title>Promotional Download</title>
    <link rel="stylesheet" href="css/style.css">
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-5TNSLT2');</script>
</head>
    
<body>
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5TNSLT2" height="0" width="0" style="display:none;visibility:hidden"></iframe>
    </noscript>
    <div class="fullHeight">

        <!-- Header start -->

        <header class="header-data text-center">
            <img src="image/logo.png" class="img-responsive logo" alt="YupIT" />
        </header>

        <!-- Header End -->

        <!-- Main Text start -->

        <div class="main-text text-center">
            <div class="container">
                <div class="row justify-content-center d-flex align-items-center">
                    <div class="col-12 col-md-7 col-sm-9 col-lg-5 col-xl-4 pl-3 pr-3">
                        <h1><span> Develop yourself</span> in the comfort of your home</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Text End -->


        <!-- Image Main start -->


        <div class="image-main text-center">

            <img src="image/main.svg" class="blog-image" alt="blog-image">

        </div>

        <!-- Image Main End -->

        <!-- Bullets start -->


        <div class="bullets justify-content-center d-block">
            <div class=" bullets-1">
                <img src="image/icon1.svg" class="img-fluid icon"><span>Access over 75 audio programs</span>
            </div>
       
            <div class="bullets-2">
                <img src="image/icon2.svg" class="img-fluid icon"><span>Create your very own playlists</span>
            </div>
       
            <div class="bullets-3">
                <img src="image/icon3.svg" class="img-fluid icon"><span>Set reminders on your phone</span>
            </div>
        </div>

        <!-- Bullets End -->

        <!-- Get Button start -->
       
        <form method="POST" name="getapp" action="">
            <div class="get-button text-center">
                <div class="code container">
                    <input type="submit" name="submit" class="btn btn-secondary btn-download" value="GET THE APP" />
                </div>
            </div>
        </form>        
            
    </div>
    <!-- Get Button End -->

    <div class="getapp_popoupmodelbx modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Download the App</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
             <p>Scan the QR code to download the app</p>
             <div class="text-center">
                <img src="../bwsmembershipstaging/html/image/Asset.png" alt="">
              </div>
            </div>
           </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="js/main.js"></script>
    <script src="../bwsmembershipstaging/html/js/bootstrap.min.js"></script>
    
    <script>
        

        $(document).ready(function(){
            
            if (navigator.appVersion.indexOf("Win")!=-1){
                $("#exampleModal").modal('show');
            }
            
        });
        // $( document ).ready(function() {
        //     var md = new MobileDetect(window.navigator.userAgent);
        //     console.log(md);

        //     $( ".btn-download" ).click(function() {
        //         if(md.mobile()){
        //             if(md.os() == 'AndroidOS'){
        //                 window.location.href = "https://play.google.com/store/apps/details?id=com.brainwellnessspa";
        //             }
        //             else if(md.os() == 'iOS'){
        //                 window.location.href = "https://apps.apple.com/au/app/brain-wellness-spa/id1534412422";
                        
        //             }   
        //         }
                
        //     });
        // });
        
        
    </script>

</body>

</html>