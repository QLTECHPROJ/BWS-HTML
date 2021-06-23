<?php
session_start();

$member_check = $_GET['member_check'];
$session_referesh = $_GET['session_referesh'];

$mobile_infusion = $_GET['mobile'];
$code = isset($_GET['code']) ? $_GET['code'] : '';
$country = isset($_GET['country']) ? $_GET['country'] : '';



$iPod    = stripos($_SERVER['HTTP_USER_AGENT'],"iPod");
$iPhone  = stripos($_SERVER['HTTP_USER_AGENT'],"iPhone");
$iPad    = stripos($_SERVER['HTTP_USER_AGENT'],"iPad");
$Android = stripos($_SERVER['HTTP_USER_AGENT'],"Android");
$webOS   = stripos($_SERVER['HTTP_USER_AGENT'],"webOS");

?>
<!DOCTYPE html>
<html lang="en">
<input type="hidden" name="" id="dontmember" value="<?php echo $member_check;?>">
<input type="hidden" name="" id="session_referesh" value="<?php echo $session_referesh;?>">
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="icon" href="image/favicon-16x16.png" sizes="16x16" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css' rel='stylesheet' type='text/css'>
    <style>
        body
        {
            height: 100vh;
            background:#2a3042 !important
        }
        .center-page {
            -webkit-flex-flow: column wrap;
            -ms-flex-flow: column wrap;
            flex-flow: column wrap;
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: center;
            -webkit-justify-content: center;
            -ms-flex-pack: center;
            justify-content: center;
            height: 100vh;
        }
        .login
        {
            position: fixed;
            top: 0px;
            right: 0px;
            width: 100%;
            height: 100%;
        }
        /* 12-02-2020 */
        @media all and (max-width:575px)
        {
            .other-links
            {
                text-align:center !important;
                width:100% !important;
                padding-left: 20px;
                }
        }
        /* 12-02-2020 */

        /* Change autocomplete styles in WebKit */

        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus,
        textarea:-webkit-autofill,
        textarea:-webkit-autofill:hover,
        textarea:-webkit-autofill:focus,
        select:-webkit-autofill,
        select:-webkit-autofill:hover,
        select:-webkit-autofill:focus {
            border-bottom: 1px solid #fff !important;
            -webkit-text-fill-color: white;
            -webkit-box-shadow: none !important;
            transition: background-color 5000s ease-in-out 0s !important;
        }

        /*  */

         .form-group {
        position: relative;
        margin-bottom: 1.5rem;
        }
        select
        {
            border-radius:0px !important;
            padding:10px;
            padding: 0px 30px 0px 5px;
            background-color:transparent !important;
            outline: 0;
            color: #ddd;
            border: 0;
            box-shadow: 0 2px 0 -1px #e5e5e5;
            -webkit-transition: box-shadow 150ms ease-out;
            transition: box-shadow 150ms ease-out;
            margin-left:0px !important;
            background-image: url("./image/down-arrow-white.png") !important;
            background-position: right 10px center;
            background-repeat: no-repeat;
            background-size: auto 30%;
            -webkit-appearance: none;
            -moz-appearance: none;
            -ms-appearance: none;
            appearance: none;
        }
        select option
        {
            background-color:transparent !important;
            color: #000 !important;
        }

        .form-control
        {
            background-color:transparent !important;
            width: 100%;
            outline: 0;
            color:#495057 !important;
            border: 0;
            box-shadow: 0 2px 0 -1px #e5e5e5;
            -webkit-transition: box-shadow 150ms ease-out;
            transition: box-shadow 150ms ease-out;
            border-radius:0px;
        }
        .focused .form-control
        {
            box-shadow: rgb(229, 229, 229) 0px 1px 0px 0px !important;
            transition: all 0.5s ease 0s;
        }
        .form-control-placeholder {
            position: absolute;
            top: 6px;
            left:55px;
            padding: 0px 0 0 13px;
            transition: all 200ms;
            opacity: 1;
            color: #495057 !important;
        }

        .focused .form-control-placeholder {
            position: absolute;
            top: -20px !important;
            left: -12px !important;
            color: #495057;
            font-size:0.75em !important;
            font-weight:500;
        }  
        .input-group-prepend
        {
            width:75px;
        }
        .input-group-prepend .form-control
        {
            border-radius:0px;
        }
        body .login,
        body
        {
           /* overflow:hidden !important;*/
        }
        .select2-container--default .select2-selection--single
        {
            background:transparent;
            border-radius:0px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered
        {
            background:transparent;
            box-shadow: 0 2px 0 -1px #e5e5e5;
            border-radius:0px;
            line-height:38px !important;
            height:38px !important;
            padding-left: 40px !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered::before 
        {
            line-height:38px !important;
            left: 10px !important;
           /* color:#fff !important;*/
        }
        .select2-selection__rendered,.form-control
        {
           /* color:#fff !important;*/
        }
        ::placeholder { 
            /*color:#fff !important;*/
            opacity: 1; 
        }

        :-ms-input-placeholder { 
           /* color:#fff !important;*/
        }

        ::-ms-input-placeholder { 
           /* color:#fff !important;*/
        }
        
        body{
        overflow-x: hidden;
        }
        .select2-container--default .select2-results>.select2-results__options{
            max-height: 111px !important;
        }
        .select2-selection__arrow{
            display:none;
        }
        .pr-5
        {
            padding-right:5px !important;
        }
    </style>
</head>

<body>
   <!-- <video autoplay muted loop id="myVideo">
        <source src="video/bg-video.mp4" type="video/mp4">
    </video>-->
    <div class="login" style="background: url('image/LoginpageImage.png') #fff no-repeat;">
        <div class="container">
            <div class="center-page">
            <div class="fullheight">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="justify-content-center d-flex">
                        <div class="w-400px">
                            <div class="login-data">
                                <div class=" text-center top">
                                    <img src="image/header-logo.png" class="img-fluid login-logo mb-4">
                                <h1 class="font-22">Sign In</h1>
                            </div>

                            <div class="form-wrapper">
                                <form class="form" method="POST">

                                      <div >
                                    <label id="lblCountry" class="font-16">Country</label>
                                        <select class="js-example-basic-single form-control" name="state[]" id="country" class="country" onChange="fnCountryCode(this.value);fnCountry()" >
                                        
                                        <option class="lstCounntry" <?php echo ($country == 'AD') ? "selected" : "";  ?> value="AD">Andorra</option>
                                        <option class="lstCounntry" <?php echo ($country == 'AR') ? "selected" : "";  ?> value="AR">Argentina</option>
                                        <option class="lstCounntry" <?php echo ($country == 'AS') ? "selected" : "";  ?> value="AS">American Samoa</option>
                                        <option class="lstCounntry" <?php echo ($country == 'AT') ? "selected" : "";  ?> value="AT">Austria</option>
                                        <option class="lstCounntry" <?php echo ($country == '') ? "selected" : "";  ?> <?php echo ($country == 'AU') ? "selected" : "";  ?> value="AU">Australia</option>
                                        <option class="lstCounntry" <?php echo ($country == 'BD') ? "selected" : "";  ?> value="BD">Bangladesh</option>
                                        <option class="lstCounntry" <?php echo ($country == 'BE') ? "selected" : "";  ?> value="BE">Belgium</option>
                                        <option class="lstCounntry" <?php echo ($country == 'BG') ? "selected" : "";  ?> value="BG">Bulgaria</option>
                                        <option class="lstCounntry" <?php echo ($country == 'BR') ? "selected" : "";  ?> value="BR">Brazil</option>
                                        <option class="lstCounntry" <?php echo ($country == 'CA') ? "selected" : "";  ?> value="CA">Canada</option>
                                        <option class="lstCounntry" <?php echo ($country == 'CH') ? "selected" : "";  ?> value="CH">Switzerland</option>
                                        <option class="lstCounntry" <?php echo ($country == 'CZ') ? "selected" : "";  ?> value="CZ">Czech Republic</option>
                                        <option class="lstCounntry" <?php echo ($country == 'DE') ? "selected" : "";  ?> value="DE">Germany</option>
                                        <option class="lstCounntry" <?php echo ($country == 'DK') ? "selected" : "";  ?> value="DK">Denmark</option>
                                        <option class="lstCounntry" <?php echo ($country == 'DO') ? "selected" : "";  ?> value="DO">Dominican Republic</option>
                                        <option class="lstCounntry" <?php echo ($country == 'ES') ? "selected" : "";  ?> value="ES">Spain</option>
                                        <option class="lstCounntry" <?php echo ($country == 'FI') ? "selected" : "";  ?> value="FI">Finland</option>
                                        <option class="lstCounntry" <?php echo ($country == 'FO') ? "selected" : "";  ?> value="FO">Faroe Islands</option>
                                        <option class="lstCounntry" <?php echo ($country == 'FR') ? "selected" : "";  ?> value="FR">France</option>
                                        <option class="lstCounntry" <?php echo ($country == 'GB') ? "selected" : "";  ?> value="GB">Great Britain</option>
                                        <option class="lstCounntry" <?php echo ($country == 'GF') ? "selected" : "";  ?> value="GF">French Guyana</option>
                                        <option class="lstCounntry" <?php echo ($country == 'GG') ? "selected" : "";  ?> value="GG">Guernsey</option>
                                        <option class="lstCounntry" <?php echo ($country == 'GL') ? "selected" : "";  ?> value="GL">Greenland</option>
                                        <option class="lstCounntry" <?php echo ($country == 'GP') ? "selected" : "";  ?> value="GP">Guadeloupe</option>
                                        <option class="lstCounntry" <?php echo ($country == 'GT') ? "selected" : "";  ?> value="GT">Guatemala</option>
                                        <option class="lstCounntry" <?php echo ($country == 'GU') ? "selected" : "";  ?> value="GU">Guam</option>
                                        <option class="lstCounntry" <?php echo ($country == 'GY') ? "selected" : "";  ?> value="GY">Guyana</option>
                                        <option class="lstCounntry" <?php echo ($country == 'HR') ? "selected" : "";  ?> value="HR">Croatia</option>
                                        <option class="lstCounntry" <?php echo ($country == 'HU') ? "selected" : "";  ?> value="HU">Hungary</option>
                                        <option class="lstCounntry" <?php echo ($country == 'IM') ? "selected" : "";  ?> value="IM">Isle of Man</option>
                                        <option class="lstCounntry" <?php echo ($country == 'IN') ? "selected" : "";  ?> value="IN">India</option>
                                        <option class="lstCounntry" <?php echo ($country == 'IS') ? "selected" : "";  ?> value="IS">Iceland</option>
                                        <option class="lstCounntry" <?php echo ($country == 'IT') ? "selected" : "";  ?> value="IT">Italy</option>
                                        <option class="lstCounntry" <?php echo ($country == 'JE') ? "selected" : "";  ?> value="JE">Jersey</option>
                                        <option class="lstCounntry" <?php echo ($country == 'JP') ? "selected" : "";  ?> value="JP">Japan</option>
                                        <option class="lstCounntry" <?php echo ($country == 'LI') ? "selected" : "";  ?> value="LI">Liechtenstein</option>
                                        <option class="lstCounntry" <?php echo ($country == 'LK') ? "selected" : "";  ?> value="LK">Sri Lanka</option>
                                        <option class="lstCounntry" <?php echo ($country == 'LT') ? "selected" : "";  ?> value="LT">Lithuania</option>
                                        <option class="lstCounntry" <?php echo ($country == 'LU') ? "selected" : "";  ?> value="LU">Luxembourg</option>
                                        <option class="lstCounntry" <?php echo ($country == 'MC') ? "selected" : "";  ?> value="MC">Monaco</option>
                                        <option class="lstCounntry" <?php echo ($country == 'MD') ? "selected" : "";  ?> value="MD">Moldavia</option>
                                        <option class="lstCounntry" <?php echo ($country == 'MH') ? "selected" : "";  ?> value="MH">Marshall Islands</option>
                                        <option class="lstCounntry" <?php echo ($country == 'MK') ? "selected" : "";  ?> value="MK">Macedonia</option>
                                        <option class="lstCounntry" <?php echo ($country == 'MP') ? "selected" : "";  ?> value="MP">Northern Mariana Islands</option>
                                        <option class="lstCounntry" <?php echo ($country == 'MQ') ? "selected" : "";  ?> value="MQ">Martinique</option>
                                        <option class="lstCounntry" <?php echo ($country == 'MX') ? "selected" : "";  ?> value="MX">Mexico</option>
                                        <option class="lstCounntry" <?php echo ($country == 'MY') ? "selected" : "";  ?> value="MY">Malaysia</option>
                                        <option class="lstCounntry" <?php echo ($country == 'NL') ? "selected" : "";  ?> value="NL">Holland</option>
                                        <option class="lstCounntry" <?php echo ($country == 'NO') ? "selected" : "";  ?> value="NO">Norway</option>
                                        <option class="lstCounntry" <?php echo ($country == 'NZ') ? "selected" : "";  ?> value="NZ">New Zealand</option>
                                        <option class="lstCounntry" <?php echo ($country == 'PH') ? "selected" : "";  ?> value="PH">Phillippines</option>
                                        <option class="lstCounntry" <?php echo ($country == 'PK') ? "selected" : "";  ?> value="PK">Pakistan</option>
                                        <option class="lstCounntry" <?php echo ($country == 'PL') ? "selected" : "";  ?> value="PL">Poland</option>
                                        <option class="lstCounntry" <?php echo ($country == 'PM') ? "selected" : "";  ?> value="PM">Saint Pierre and Miquelon</option>
                                        <option class="lstCounntry" <?php echo ($country == 'PR') ? "selected" : "";  ?> value="PR">Puerto Rico</option>
                                        <option class="lstCounntry" <?php echo ($country == 'PT') ? "selected" : "";  ?> value="PT">Portugal</option>
                                        <option class="lstCounntry" <?php echo ($country == 'RE') ? "selected" : "";  ?> value="RE">French Reunion</option>
                                        <option class="lstCounntry" <?php echo ($country == 'RU') ? "selected" : "";  ?> value="RU">Russia</option>
                                        <option class="lstCounntry" <?php echo ($country == 'SE') ? "selected" : "";  ?> value="SE">Sweden</option>
                                        <option class="lstCounntry" <?php echo ($country == 'SI') ? "selected" : "";  ?> value="SI">Slovenia</option>
                                        <option class="lstCounntry" <?php echo ($country == 'SJ') ? "selected" : "";  ?> value="SJ">Svalbard & Jan Mayen Islands</option>
                                        <option class="lstCounntry" <?php echo ($country == 'SK') ? "selected" : "";  ?> value="SK">Slovak Republic</option>
                                        <option class="lstCounntry" <?php echo ($country == 'SM') ? "selected" : "";  ?> value="SM">San Marino</option>
                                        <option class="lstCounntry" <?php echo ($country == 'TH') ? "selected" : "";  ?> value="TH">Thailand</option>
                                        <option class="lstCounntry" <?php echo ($country == 'TR') ? "selected" : "";  ?> value="TR">Turkey</option>
                                        <option class="lstCounntry" <?php echo ($country == 'US') ? "selected" : "";  ?> value="US">United States</option>
                                        <option class="lstCounntry" <?php echo ($country == 'VA') ? "selected" : "";  ?> value="VA">Vatican</option>
                                        <option class="lstCounntry" <?php echo ($country == 'VI') ? "selected" : "";  ?> value="VI">Virgin Islands</option>
                                        <option class="lstCounntry" <?php echo ($country == 'YT') ? "selected" : "";  ?> value="YT">Mayotte</option>
                                        <option class="lstCounntry" <?php echo ($country == 'ZA') ? "selected" : "";  ?> value="ZA">South Africa</option>
                                        
                                    </select>
                                    <span id="showlist"></span>
                                        <input type="text" name="txtOther" id="txtOther" class="form-control" style="display:none" />
                                        <span class="spnClass" id="spnCountry"></span>
                                </div>

                          
                                    <?php
                                    if($mobile_infusion)
                                    {
                                        ?>
                                 <!--  <div class="form-group mb-2 input-mobile focused">
                                    <label class="form-label" for="first">Mobile Number</label>
                                    <input id="first" class="form-input mobile-input" autocomplete="off" type="text" minlength="10" maxlength="13" value="<?php //echo $mobile_infusion;?>" required=""  oninput="this.value = this.value.replace(/[^0-9]/g, '');"/>
                                  </div> -->
                                   <!-- <div class="form-group mb-2 input-mobile ">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <select class="form-contol w-100" name="codec">
                                                <option value="61">61</option>
                                                <option value="91">91</option>
                                                </select> 

                                            </div>
                                            <input type="text" id="first" class="form-control mobile-input" autocomplete="off" type="text" minlength="10" maxlength="13" value="<?php echo $mobile_infusion;?>" required=""  oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                            <label class="form-control-placeholder" for="first">Mobile Number</label>
                                        </div>
                                   </div>  -->
                                   
                                   <div class="form-group">
                                        <label class="font-16" for="first">Mobile Number</label> 
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend pr-5">
                                            <input type="text" class="form-control" id="txtCode" name="txtCode" placeholder="+61" value="<?php echo $code;?>" disabled>
                                        </div>
                                            <input type="text" id="first" class="form-control mobile-input"  autocomplete="off" type="text" minlength="10" maxlength="13" value="<?php echo $mobile_infusion;?>" required=""  oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                        </div>
                                   </div>
                                  <small class=" font-13-medium" id="showerrormo" style="display: none">Mobile Number Cannot Be blank</small>
                                  <?php
                                    }
                                    else
                                    {
                                        ?>
                                         <!-- <div class="form-group mb-2 input-mobile">
                                    <label class="form-label" for="first">Mobile Number</label>
                                    <input id="first" class="form-input mobile-input" autocomplete="off" type="text" minlength="10" maxlength="13" value="<?php //echo $mobile_infusion;?>" required=""  oninput="this.value = this.value.replace(/[^0-9]/g, '');"/>
                                  </div> -->
                                  
                                   <!-- <div class="form-group mb-2 input-mobile">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <input type="text" class="form-control" id="txtCode" name="txtCode" placeholder="+61">
                                            </div>
                                            <input type="text" id="first" class="form-control mobile-input" autocomplete="off" type="text" minlength="10" maxlength="13" value="<?php echo $mobile_infusion;?>" required=""  oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                            <label class="form-control-placeholder"for="first">Mobile Number</label>
                                        </div>
                                   </div> -->
                                   
                                   <div class="form-group">
                                        <label class="font-16"for="first">Mobile Number</label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend pr-5">
                                                <input type="text" class="form-control" id="txtCode" name="txtCode" placeholder="+61" value="<?php echo $code;?>" disabled>
                                            </div>
                                            <input type="text" id="first" class="form-control mobile-input" autocomplete="off" type="text" minlength="10" maxlength="13" value="<?php echo $mobile_infusion;?>" required=""  oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                        </div>
                                   </div>


                                  <small class="font-13-medium" id="showerrormo" style="display: none">Mobile Number Cannot Be blank</small>
                                        
                                        <?php
                                    }
                                    ?>
                                    <div class="text-left a-color">
                                        <small class="font-13-medium" id="showerror" style="display: none">The Mobile Number entered is not registed. <a href="https://brainwellnessspa.com.au/membership/" class="ml-1" target="_blank">Register Now?</a></small>
                                        <small class="font-13-medium" id="showerrordigit" style="display: none">Please Enter the 10 digit mobile number</small>
                                    </div>
                                  <button class="btn btn-dark btn-block my-btn mt-3" type="button" id="cont">Get SMS Code</button>
                                </form>
                              </div>

                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="justify-content-center d-flex">
                            <div class="loginright_bx">
                                <h2 class="mb-4"><strong>Develop yourself in the comfort of your home</strong></h2>
                                <p>Download the app and gain access to over 75 audio programs. Create your very own playlists and set reminders on your phone.</p>
                                  <div class="getappbtn btn btn-dark">
                                      <a href=" https://brainwellnessspa.com.au/get-the-app/index.php?mobile=<?php echo $mobile; ?>&code=<?php echo $codecountry; ?>">GET THE APP</a>
                                      <a <?php if($Android){ ?> href="https://play.google.com/store/apps/details?id=com.brainwellnessspa" <?php }else{ ?>  data-toggle="modal" data-target="#exampleModal" <?php } ?> ><img src="image/Android.svg" alt=""></a>
                                      <a <?php if( $iPod || $iPhone || $iPad){ ?>href="https://apps.apple.com/us/app/brain-wellness-spa/id1534412422" <?php }else{ ?> data-toggle="modal" data-target="#exampleModal" <?php } ?>  ><img src="image/IOS.svg"></a>
                                  </div>
                                  

                            </div>
                        </div>
                    </div>
                </div><!--row-->
            <div class="other-links">
                <div class="container">
                    <ul class="font-14-medium">
                        <li><a href="https://brainwellnessspa.com.au/privacy-policy/" target="_blank">Privacy policy</a></li>
                        <li><span>|</span></li>
                        <li><a href="https://brainwellnessspa.com.au/terms-conditions" target="_blank">Terms & Condition</a></li>
                    </ul>
                </div>
            </div><!--fullheight-->
            </div>
            </div>
        </div>
    </div>
    <div class="getapp_popoupmodelbx modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">NOTE</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
             <p>Your initial appointment fee of $220 is payable at the end of your session. Payment can be made by cash or card.</p>
             <div class="text-right">
                <button class="btn btn-orange font-16" type="button">Proceed</button>
              </div>
            </div>
           </div>
        </div>
    </div><!--getapp_popoupmodelbx-->
    <input type="hidden" id="member" value="">
    <input type="hidden" id="flag" value="">
    <input type="hidden" id="mobile_number" value="">
    <input type="hidden" id="free_status" value="">
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js' type='text/javascript'></script>
    <script>
        $(".select2-search--dropdown").on("click", function () {
            alert("fsadf");
            $(".select2-search--dropdown").css("display", "none");
        });
    </script>
    <script>
            if ($(window).width() < 575) {
                function onKeyboardOnOff(isOpen) {
            // Write down your handling code
            if (isOpen) {
                // keyboard is open
                $(".other-links").addClass('d-none');
                $(".other-links").removeClass('d-block');
            } else {
                // keyboard is closed
                $(".other-links").addClass('d-block');
                $(".other-links").removeClass('d-none');
            }
        }
        
        var originalPotion = false;
        $(document).ready(function(){
            if (originalPotion === false) originalPotion = $(window).width() + $(window).height();
        });

        /**
        * Determine the mobile operating system.
        * This function returns one of 'iOS', 'Android', 'Windows Phone', or 'unknown'.
        *
        * @returns {String}
        */
        function getMobileOperatingSystem() {
            var userAgent = navigator.userAgent || navigator.vendor || window.opera;

            // Windows Phone must come first because its UA also contains "Android"
            if (/windows phone/i.test(userAgent)) {
                return "winphone";
            }

            if (/android/i.test(userAgent)) {
                return "android";
            }

            // iOS detection from: http://stackoverflow.com/a/9039885/177710
            if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
                return "ios";
            }

            return "";
        }

        function applyAfterResize() {

            if (getMobileOperatingSystem() != 'ios') {
                if (originalPotion !== false) {
                    var wasWithKeyboard = $('body').hasClass('view-withKeyboard');
                    var nowWithKeyboard = false;

                        var diff = Math.abs(originalPotion - ($(window).width() + $(window).height()));
                        if (diff > 100) nowWithKeyboard = true;

                    $('body').toggleClass('view-withKeyboard', nowWithKeyboard);
                    if (wasWithKeyboard != nowWithKeyboard) {
                        onKeyboardOnOff(nowWithKeyboard);
                    }
                }
            }
        }

        $(document).on('focus blur', 'select, textarea, input[type=text], input[type=date], input[type=password], input[type=email], input[type=number]', function(e){
            var $obj = $(this);
            var nowWithKeyboard = (e.type == 'focusin');
            $('body').toggleClass('view-withKeyboard', nowWithKeyboard);
            onKeyboardOnOff(nowWithKeyboard);
        });

        $(window).on('resize orientationchange', function(){
            applyAfterResize();
        });
            }
    </script>
     <!-- <script>
            if ($(window).width() < 575) {
                $(".option-select").on("click", function () {
                    alert("hatsn");
                $(".other-links").addClass('d-block');
                }); 
            }
    </script> -->
    <script type="text/javascript">
        $(document).ready(function(){

                $('#cont').click(function(){

                            var mobile_number = $("#first").val();

                            var dontmember = $("#dontmember").val();

                            var codec = $("#codec").val();

                           // alert(dontmember);


                           if(mobile_number=="")
                           {
                                jQuery('#showerrormo').show();
                                            return false;
                           }


                           if(mobile_number.length<8)
                            {
                                    jQuery('#showerrordigit').show();
                                            return false;
                            }

                            if(dontmember=='did')
                            {

                                    //alert('if');


                             $.ajax({

                                type: "POST",

                                url: 'verify_member_2.php',

                                dataType: "json",

                                data: {mobile_number:mobile_number,codec:codec}, 

                                success: function(data) {    

                                    
                                    if(data.flag!="")
                                    {
                                            var assign = document.getElementById("member").value = data.patient_id;
                                            var check = $("#member").val();
                                            var flag = document.getElementById("flag").value = data.flag;
                                            var flag_check = $("#flag").val();
                                            var mobile_number_assign = document.getElementById("mobile_number").value = data.mobile_check_member;
                                            var mobile_number = $("#mobile_number").val();
                                            var id = data.id;
                                            var free_status = document.getElementById("free_status").value = data.free_status;
                                            var free_status_assign = $("#free_status").val();
                                            //alert(check);
                                            //alert(flag_check);
                                            
                                            if(check!="")
                                            {                


                                               window.location.href = "verify-otp.php?patient_id="+check+"&flag="+flag_check+"&mobile_number="+mobile_number+"&free_status="+free_status_assign;
                                            }
                                    }
                                    else
                                    {
                                        
                                            jQuery('#showerror').show();
                                            return false;
                                        
                                    }

                                } 
                            });



                            
                            
                            }  //end of if loop
                            else
                            {
                                //alert('else');

                            $.ajax({

                                type: "POST",

                                url: 'verify_member.php',

                                dataType: "json",

                                data: {mobile_number:mobile_number,codec:codec}, 

                                success: function(data) {    

                                    
                                    if(data.flag!="")
                                    {
                                            var assign = document.getElementById("member").value = data.patient_id;
                                            var check = $("#member").val();
                                            var flag = document.getElementById("flag").value = data.flag;
                                            var flag_check = $("#flag").val();
                                            var mobile_number_assign = document.getElementById("mobile_number").value = data.mobile_check_member;
                                            var mobile_number = $("#mobile_number").val();
                                            var id = data.id;
                                             var free_status = document.getElementById("free_status").value = data.free_status;
                                            var free_status_assign = $("#free_status").val();
                                            //alert(check);
                                            //alert(flag_check);
                                            
                                            if(check!="")
                                            {                


                                               window.location.href = "verify-otp.php?patient_id="+check+"&flag="+flag_check+"&mobile_number="+mobile_number+"&free_status="+free_status_assign;
                                            }
                                    }
                                    else
                                    {
                                        
                                            jQuery('#showerror').show();
                                            return false;
                                        
                                    }

                                } 
                            });
                        
                                    }  //else of did
                           });


        });
    </script>
    <script type="text/javascript">
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
    </script>
  
        <script type="text/javascript">
            $(document).ready(function(){

            // Initialize select2
            $("#country").select2({
                 dropdownParent: $('#showlist')
            });

            $('#country').on("change", function(e) { 
                $(this).select2("close");
            });
            
            });
        </script>

        <script type="text/javascript">
             $(document).ready(function(){


                var session_referesh = $('#session_referesh').val();
                if(session_referesh=='logout')
                {

                    alert('You have been logged out as your session has expired. Please log in again.');
                }
             });

        </script>

  
</body>

</html>