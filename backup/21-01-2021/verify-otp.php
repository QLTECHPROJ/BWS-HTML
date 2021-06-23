<?php
session_start();
include 'config.php';


?> 
<!DOCTYPE html>
<html lang="en"> 
<head>
    <title>Verify OTP</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="icon" href="image/favicon-16x16.png" sizes="16x16" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <style>
        
        /* MY CSS */
        .container {
            height: 100vh;
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
        }

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
        .resend:hover
        {
            color:gray !important;
        }
        
        ::placeholder { 
            color:#495057 !important;
            opacity: 1; 
        }

        :-ms-input-placeholder { 
            color:#495057 !important;
        }

        ::-ms-input-placeholder { 
            color:#495057 !important;
        }
        /*  */
        
        .form-control
        {
            background-color:transparent !important;
            width: 100%;
            outline: 0;
            color: #495057 !important;
            border: 0;
            box-shadow: 0 2px 0 -1px #e5e5e5;
            -webkit-transition: box-shadow 150ms ease-out;
            transition: box-shadow 150ms ease-out;
            border-radius:0px !important;
        }
        .focused .form-control
        {
            box-shadow: rgb(229, 229, 229) 0px 1px 0px 0px !important;
            transition: all 0.5s ease 0s;
        }
       
    </style>
</head>
<body>
    <input type="hidden" name="" id="getmobile" value="<?php echo $_GET['mobile_number'];?>">
    <!--<video autoplay muted loop id="myVideo">
        <source src="video/bg-video.mp4" type="video/mp4">
    </video>-->
    <div class="login" style="background: url('image/LoginpageImage.png') #fff no-repeat;">
        <div class="container">
            <div class="justify-content-center d-flex">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="w-400px">
                            <div class="login-data">
                                <div class=" text-center top">
                                    <img src="image/header-logo.png" class="img-fluid login-logo mb-4">
                                    <h1 class="font-22 mb-2">It's Great to see you!</h1>
                                    <span class="font-15-light">Mobile Number</span>
                                </div>

                                <div class="form-wrapper">
                                    <form class="form" method="POST">
                                        <!-- <div class="form-group mb-2 input-mobile">
                                            <label class="form-label" for="otp">One Time Password</label>
                                            <input id="otp" class="form-input mobile-input" autocomplete="off" type="text"  name="userotp" />
                                        </div> -->
                                        
                                        <div class="form-group mb-2">
                                            <label class="font-16 mb-0" for="otp">One Time Password</label>
                                            <input id="otp" class="form-control mobile-input" autocomplete="off" type="text"  name="userotp" />
                                        </div>
                                        <div class="text-left">
                                            <small class=" font-13-medium "></small>
                                        </div>
                                        <button class="btn btn-dark btn-block my-btn mt-3 mb-1" type="submit" name="submit">Let's go</button>
                                        <div style="display: none">Time left = <span id="timer"></span></div>
                                        <a class="text-right mt-3 d-block mt-3 resend font-12-light" id="resend_opt" style="display: none! important">Resend OTP!</a>
                                    </form>
                                    <?php
                                    if(isset($_POST['submit']))
                                    {
                                        
                                            $patient_id = $_GET['patient_id'];
                                            $flag = $_GET['flag'];
                                            $mobile_number = $_GET['mobile_number'];
                                            $free_status = $_GET['free_status'];
                                            $query = mysqli_query($conn_back,"SELECT * FROM membership_otp WHERE mobile_number = '$mobile_number' ORDER BY id DESC");
                                             $data = mysqli_fetch_array($query, MYSQLI_ASSOC);
                                           
                							     if($data['OTP']==$_POST['userotp'])
                							     {
                                                    if($flag==1)
                                                    {
                                                    	//echo "hi";
                        							       //header("Location: dashboard.php?patient=$patient_id");
        												   $_SESSION['patient_id']=$patient_id;
                                                             $_SESSION['phone']=$mobile_number;
                                                        
                                                           $_SESSION['free_status']=$free_status;
                                                        
                                                        
                                                           echo "<script> window.location.href = 'dashboard.php?patient=$patient_id&free_status=$free_status&phone=$mobile_number'; </script>";
        												   
                                                    }
                                                    if($flag==2)
                                                    {
        												$_SESSION['mobile_number']=$mobile_number;
                                                         $_SESSION['phone']=$mobile_number;
                                                        //header("Location: dashboard-user.php?mobile=$mobile_number");
                                                       
                                                         
                                                                $_SESSION['free_status']=$free_status;
                                                        
                                                       
                                                        echo "<script> window.location.href = 'dashboard-user.php?mobile=$mobile_number&free_status=$free_status&phone=$mobile_number'; </script>";
                                                        
                                                    }
                							     }
                							     else
                							     {
                							        echo "<script>alert('Invalid OTP');</script>";
                							     }
                  							
                                     }


                                    ?>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="loginright_bx">
                            <h2 class="mb-4"><strong>Develop yourself in the comfort of your home</strong></h2>
                            <p>Download the app and gain access to over 75 audio programs. Create your very own playlists and set reminders on your phone.</p>
                            <div class="getappbtn btn btn-dark">
                                <a href=" https://brainwellnessspa.com.au/get-the-app/">GET THE APP</a>
                                <a href="https://play.google.com/store/apps/details?id=com.brainwellnessspa" ><img src="image/Android.svg" alt=""></a>
                                <a href="https://apps.apple.com/us/app/brain-wellness-spa/id1534412422"><img src="image/IOS.svg"></a>
                            </div>
                        </div><!--loginright_bx-->
                    </div>
                </div><!--row-->
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    </script>
    <script src="js/main.js"></script>
    <script type="text/javascript">
        let timerOn = true;

function timer(remaining) {
  var m = Math.floor(remaining / 60);
  var s = remaining % 60;
  
  m = m < 10 ? '0' + m : m;
  s = s < 10 ? '0' + s : s;
  document.getElementById('timer').innerHTML = m + ':' + s;
  remaining -= 1;
  
  if(remaining >= 0 && timerOn) {
    setTimeout(function() {
        timer(remaining);
    }, 1000);
    return;
  }

  if(!timerOn) {
    // Do validate stuff here
    return;
  }
  
  // Do timeout stuff here
  $("#resend_opt").show();
}

timer(30);
    </script>
    <script type="text/javascript">
         $(document).ready(function(){

                $('#resend_opt').click(function(){

                    

                    var mobile_number  = $("#getmobile").val();


                      $.ajax({

                                type: "POST",

                                url: 'resend_otp.php',

                                dataType: "json",

                                data: {mobile_number:mobile_number}, 

                                success: function(data) {    
                                    //alert(data.flag);
                                    
                                    if(data.flag==1)
                                    {
                                           $("#resend_opt").attr("style", "display: none !important");
                                    }
                                   

                                } 
                            });


                });
            });

        

    </script>
</body>

</html>