<?php
if(empty($_GET)) {
	echo "invalid access.";
    exit; 
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Thank-You</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  
  <style>
    body
    {
      background-color: white !important;
    }
    .container {
      max-width: 1170px !important;
    }
    header {
      background: url(./image/header-bg.png) no-repeat !important;
      background-size: cover !important;
      background-position: center top !important;
      min-height: 220px !important;
      position: unset !important;
      padding: 0px !important;
      width:100% !important;
    }

    .header-data {
      padding: 15px 0px !important;
    }

    .header-content {
      text-align: right !important;
    }
    .section-heading-5 h5 a {
        font-size: 26px;
        line-height: 30px;
        padding: 10px;
        color: #ffc010 !important;
    }
    .section-heading-5 h5 {
        font-size: 26px;
        line-height: 30px;
        color: white;
    }
    /* Custom checkbox End */
    @media all and (max-width:767px) {
      .footer-main-data p {
        text-align: center !important;
      }

      .footer-main-data .mt-top {
        margin-top: 0px !important;
      }

      .footer-main-data ul {
        text-align: center !important;
      }

      .footer-content h5,
      .header-content h5 {
        text-align: center !important;
      }

      .footer-logo,
      .header-logo {
        text-align: center !important;
        margin-bottom: 10px !important;
      }

      .footer-logo img,
      .header-logo img {
        width: 130px !important;
      }
    }

    /* Footer Start */

    footer {
      background: url(./image/footer-top-bg.png) no-repeat !important;
      background-size: cover !important;
      background-position: center top !important;
      padding: 30px 0px !important;
      color: white;
      background-color: white;
    }

    .footer-data {
      padding: 15px 0px !important;
    }

    .footer-logo img {
      width: 200px !important;
    }

    .footer-content {
      text-align: right !important;
    }

    .hr-main {
      margin-top: 5px;
      margin-bottom: 5px;
      border: 0;
      border-top: 1px solid #1e95dd;
    }

    .footer-main-data p {
      color: white !important;
      font-size: 13px !important;
      margin-bottom: 10px;
    }

    .footer-main-data ul {}

    .footer-main-data ul li {
      display: inline-block !important;
      width: 30px !important;
      height: 30px !important;
      background-color: #fff !important;
      border-radius: 50px !important;
      padding: 3px !important;
      margin-right: 5px !important;
    }

    .footer-main-data ul li a {
      display: block !important;
      text-align: center !important;
      color: #3388bb !important;
    }
   /*  */

   .btn-orange
   {
     color: white;
     background: #f89552;
     border:none;
     border-radius: 25px;
     padding: 15px 25px !important;
    -webkit-transition: all 0.5s ease-out;
    -moz-transition: all 0.5s ease-out;
    -ms-transition: all 0.5s ease-out;
    -o-transition: all 0.5s ease-out;
    transition: all 0.5s ease-out;
   }
   .btn-orange:hover {
        background-color: #ffc010 !important;
    }
    .checkout-data
    {
      z-index: 2;
    }
    @media all and (max-width:575px)
    {
      .thank-you-text
      {
        width: 270px;
      }
      .thank-you-blog
      {
        width: 310px;
      }
      .checkout {
        padding-bottom: 15px !important;
      }
    }
   /*  */
   .checkout
   {
     position: relative;
   }
   .checkout::before
   {
     content: "";
     position: absolute;
     background: url("./image/thankyou-left.png");
     background-size: 100% !important;
     top: 0;
     bottom: 0;
     margin: auto 0;
     left: 0;
     z-index: -1;
     height: 400px;
     width: 350px;
   }
   .checkout::after
   {
     content: "";
     position: absolute;
     background: url("./image/thankyou-right.png");
     background-size: 100%;
     top: 0;
     bottom: 0;
     margin: auto 0;
     right: 0;
     z-index: -1;
     height: 469px;
     width: 350px;
   }
   @media all and (max-width:1100px)
   {
      .checkout::before {
      height: 300px ;
      width: 250px;
    }
    .checkout::after {
    height: 369px;
    width: 250px;
    }
   }
   @media all and (max-width:600px)
   {
    .checkout::after
    {
      display: none;
    }
   }
   @media all and (max-width:767px)
   {
    .thank-you-text {
    width: 320px;
    }
  }
   @media all and (max-width:575px)
   {
    .section-heading-5 h5 a {
        font-size: 23px;
    }
   }
  </style>
</head>

<body>


  <header>
    <div class="container">
        <div class="header-data">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="header-logo">
                        <img src="image/logo.png" class="img-fluid" alt="">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="header-content section-heading-5">
                        <h5>CALL 24/7<a href="tel:1300236272">1300 236 272</a></h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

  <!--  -->

  <div class="checkout pt-0">
    <div class="container">
      <div class="checkout-data text-center">
        <div class="row justify-content-center d-flex">
          <div class="col-md-9">
            <div class="d-block mb-3">
              <img src="image/thankyou-blog.png" class="img-fluid thank-you-blog" width="450" height="450" alt="thankyou-blog">
            </div>
            <div class="d-block mb-3">
              <img src="image/thankyoy-text.png" class="img-fluid thank-you-text" width="450" alt="thankyou-text">
            </div>
            
            
            <h1 class="font-18-bold mb-3">Congratulations on joining the Brain Wellness Spa Audio Membership.</h1>
            <p class="font-16 mb-4">During the next month you can test-drive our membership website and explore how this content can be an enjoyable asset to keeping your mental health strong. Click the below link to launch the experience.</p>
            <a href="index.php?mobile=<?php echo $_GET['mobile']; ?>&code=<?php echo $_GET['code']; ?>&country=<?php echo $_GET['country']; ?>" class="btn btn-orange font-16">Membership Login</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  
 <!-- Footer Start -->

 <footer>
  <div class="container">
      <div class="footer-data">
          <div class="row align-items-center">
              <div class="col-md-6">
                  <div class="footer-logo">
                      <img src="image/logo.png" class="img-fluid" alt="">
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="footer-content section-heading-5">
                      <h5>CALL 24/7<a href="tel:1300236272">1300 236 272</a></h5>
                  </div>
              </div>
          </div>
      </div>
      <hr class="hr-main">
      <div class="footer-main-data">
          <p class="text-right"><i class="fa fa-map-marker"></i> 25 Lyall Street, South Perth, 6151 WA
          </p>
          <div class="row mt-top">
              <div class="col-md-8">
                  <p class="text-left">© 2020 Brain Wellness Spa. | Powered by QL Tech *Results may
                      vary
                      from
                      person to person</p>
              </div>
              <div class="col-md-4">
                  <ul class="text-right">
                      <li><a href="#" target="_blank"><i class="fa fa-facebook"></i></a></li>
                      <li><a href="#" target="_blank"><i class="fa fa-instagram"></i></a></li>
                      <li><a href="#" target="_blank"><i class="fa fa-twitter"></i></a></li>
                  </ul>
              </div>
          </div>

      </div>
  </div>
</footer>



  <script src="js/jquery.min.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>
  

</body>

</html>