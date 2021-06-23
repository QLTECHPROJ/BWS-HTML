<header>
  <div class="header_top">
    <div class="container">
        <ul class="htsocial_left">
            <li><a href="https://www.facebook.com/brainwellnessspa/"><i class="fab fa-facebook-f"></i></a></li>
            <li><a href="https://www.instagram.com/brainwellnessspa/"><i class="fab fa-instagram"></i></a></li>
            <li><a href="https://www.linkedin.com/company/brain-wellness-spa/"><i class="fab fa-linkedin-in"></i></a></li>
            <li><a href="https://twitter.com/brainhealthspa?lang=en"><i class="fab fa-twitter"></i></a></li>
            <li><a href="https://www.youtube.com/channel/UCC632041igVf2YkUo7zM5PA/"><i class="fab fa-youtube"></i></a></li>
        </ul>
        <div class="header-topright">
            <a href="tel:1300884348" class="htcall"><i class="fa fa-phone"></i>1300 884 348</a>  
        </div>
    </div><!--container-->
  </div><!--header_top-->
  <div class="header_main">
    <div class="container">
         <nav class="navbar navbar-expand-xl navbar-light " className="bg-none">
           <div class="navbar-brand">
            <?php global $post; ?>
            <a href="<?php echo home_url(); ?>" class="navbar-brand logo" >
                <img src="<?php bloginfo('template_url'); ?>/assets/images/depression-logo.png" class="img-fluid" width="100%" height="auto" alt="<?php bloginfo('name'); ?>" />  
            </a>
            
           </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </button>

                <div class="navbar-collapse justify-content-end collapse" id="navbarSupportedContent">

                    <div class="justify-content-end">

                    <?php // joints_top_nav(); ?>

                    <?php

                    wp_nav_menu( array( 
                        'theme_location' => 'my-custom-menu', 
                        'container' => 'ul',
                        'menu_class'=> 'navbar-nav',
                        'add_li_class'  => 'nav-item',
                        'walker' => new Primary_Walker_Nav_Menu()

                     ) ); 
                  ?>
                    <a href="https://brainwellnessspa.com.au/bookings/services.php?bId=MzI4MzQ4XzMyODU0OQ==" class="bookbtn btn-main btn-trans">Book Online</a>
                </div>
            </div>
        </nav>
    </div><!--container-->
  </div><!--header_main-->
</header>
