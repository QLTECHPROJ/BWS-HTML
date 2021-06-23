<?php
/**
 * The template for displaying the footer. 
 *
 * Comtains closing divs for header.php.
 *
 * For more info: https://developer.wordpress.org/themes/basics/template-files/#template-partials
 */			
 ?>

		 <?php if(!get_field('hide_default_footer_cta') || get_field('hide_default_footer_cta') == ""):?>
			<div id="footer-cta" <?php if (get_field('footer_cta_background_image','option')): ?>style="background-image:url('<?php the_field('footer_cta_background_image','option'); ?>');background-position: center top;background-repeat: no-repeat;background-size: cover;"<?php endif; ?>>
					<div class="grid-container text-center">
						<div class="grid-x">
							<div class="cell">
								<?php if($post->post_name == 'membership'): ?>
									<?php echo get_field('membership_cta_footer','option');?>
								<?php elseif($post->post_name == 'natural-alternative'): ?>
									<div class="container">
									  <div class="row justify-content-center">
									   <div class="col-lg-10 col-md-10 col-sm-12">
									<?php echo get_field('home_landing_cta_footer','option');?>
										</div>
									   </div>
									</div>
									<?php elseif($post->post_name == 'depression-help'): ?>
									<div class="container">
									  <div class="row justify-content-center">
									   <div class="col-lg-10 col-md-10 col-sm-12">
									<?php echo get_field('home_landing_cta_footer','option');?>
										</div>
									   </div>
									</div>
									<?php elseif($post->post_name == 'anxiety-help'): ?>
									<div class="container">
									  <div class="row justify-content-center">
									   <div class="col-lg-10 col-md-10 col-sm-12">
									<?php echo get_field('home_landing_cta_footer','option');?>
										</div>
									   </div>
									</div>
									<?php elseif($post->post_name == 'anger-help'): ?>
									<div class="container">
									  <div class="row justify-content-center">
									   <div class="col-lg-10 col-md-10 col-sm-12">
									<?php echo get_field('home_landing_cta_footer','option');?>
										</div>
									   </div>
									</div>
									<?php if(get_field('footer_cta_button_text','option')): ?>
										<!-- <a href="<?php echo get_field('footer_cta_button_url','option');?>" class="button"><?php echo get_field('footer_cta_button_text','option');?></a> -->

										<?php 
											if(isset($_GET['utm_source'])){
												if(isset($_GET['utm_source'])) {
												  $utm_source = $_GET['utm_source'];
												}
												if(isset($_GET['utm_medium'])) {
												  $utm_medium = $_GET['utm_medium'];
												}
												if(isset($_GET['utm_campaign'])) {
												  $utm_campaign = $_GET['utm_campaign'];
												}
												if(isset($_GET['inf_coupon_code'])) {
												  $inf_coupon_code = $_GET['inf_coupon_code'];
												}
												$param ='&utm_source='.$utm_source.'&utm_medium='.$utm_medium.'&utm_campaign='.$utm_campaign.'&inf_coupon_code='.$inf_coupon_code;
											}
											else{
												$param ='';
											}
										 ?>
										 <?php if($param != ''): ?>
										 			<a href="<?php echo get_field('footer_cta_button_url','option');?><?php echo $param; ?>" id="" class="button"><?php if($_GET['inf_coupon_code']){ echo "Book Now - $79 First Session Special"; }else{ echo get_sub_field('cta_button_text'); } ?></a>
												<?php else: ?>
													<a href="<?php echo get_field('footer_cta_button_url','option');?>" class="button"><?php echo get_field('footer_cta_button_text','option');?></a>
												<?php endif; ?>
									<?php endif; ?>
								<?php else: ?>
									<h2><?php echo get_field('footer_cta_heading','option');?></h2>
								<p><?php echo get_field('footer_cta_caption','option');?></p>
								<?php if(get_field('footer_cta_button_text','option')): ?>
										<!-- <a href="<?php echo get_field('footer_cta_button_url','option');?>" class="button"><?php echo get_field('footer_cta_button_text','option');?></a> -->

										<?php 
											if(isset($_GET['utm_source'])){
												if(isset($_GET['utm_source'])) {
												  $utm_source = $_GET['utm_source'];
												}
												if(isset($_GET['utm_medium'])) {
												  $utm_medium = $_GET['utm_medium'];
												}
												if(isset($_GET['utm_campaign'])) {
												  $utm_campaign = $_GET['utm_campaign'];
												}
												if(isset($_GET['inf_coupon_code'])) {
												  $inf_coupon_code = $_GET['inf_coupon_code'];
												}
												$param ='&utm_source='.$utm_source.'&utm_medium='.$utm_medium.'&utm_campaign='.$utm_campaign.'&inf_coupon_code='.$inf_coupon_code;
											}
											else{
												$param ='';
											}
										 ?>
										 <?php if($param != ''): ?>
										 			<a href="<?php echo get_field('footer_cta_button_url','option');?><?php echo $param; ?>" id="" class="button"><?php if($_GET['inf_coupon_code']){ echo "Book Now - $79 First Session Special"; }else{ echo get_sub_field('cta_button_text'); } ?></a>
												<?php else: ?>
													<a href="<?php echo get_field('footer_cta_button_url','option');?>" class="button"><?php echo get_field('footer_cta_button_text','option');?></a>
												<?php endif; ?>
									<?php endif; ?>
									
								<?php endif; ?>
								
							</div>
						</div>
					</div>
				</div>
			<?php endif;?>
			<footer class="footer" role="contentinfo" >
				<!-- <div style="background-image:url('<?php echo get_stylesheet_directory_uri() ?>/assets/images/footer-bg.jpg') !important;background-position: center top;background-repeat: no-repeat;background-size: cover;">
							
					<div class="grid-container">
						<div class="inner-footer grid-x">

							<div class="cell small-12 medium-3 large-3 footer-logo">
								<?php global $post;

						if ($post->post_parent != 12737) {		?>	<a href="<?php echo home_url(); ?>"><?php } ?><img alt="footerlogo" src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/footer-logo.png"/>	<?php global $post;

						if ($post->post_parent != 12737) {		?>	</a><?php } ?>
							</div>

							<?php if ($post->post_parent != 12737) { ?>
							<div class="cell small-6 medium-3 large-3 footer-links">
								<?php global $post;

								if ($post->post_parent != 12737) {		?>	
										<?php joints_footer_links(); ?>
								<?php } ?>
									</div>

									<div class="cell small-6 medium-3 large-3 social-accounts">
										<?php $items = get_field('footer_social','option'); ?>
										<?php global $post;

									if ($post->post_parent != 12737) {		?>	
										<ul>
											<li>Social</li>	
											<?php foreach($items as $item): ?>
												<li class="<?php echo strtolower($item['label']);?>-item">
													<a href="<?php echo $item['url'];?>">
													<?php echo ucfirst($item['label']); ?>
													</a>
												</li>
											<?php endforeach; ?>
										</ul>
											<?php }?>
									</div>
						<?	}if ($post->post_parent == 12737) { ?>
							<div class="cell small-6 medium-9 large-9 call-contacts">
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
						<?php }else{ ?>	
								<div class="cell small-6 medium-3 large-3 call-contacts">	
									<?php echo get_field('footer_contacts','option');?>
								</div>
						<?php } ?>	
												
						
						</div>
					</div>
				</div> -->

				<!-- <div class="grid-container">
					<div class="grid-x footer-bottom-content ">
						<div class="cell">
							<div class="grid-x">
								<div class="cell text-center">
									<?php echo get_field('footer_note','option');?>
								</div>
							</div>
							<div class="grid-x">
								<div class="cell text-center">
									<ul>
										<?php $footer_bottom_links = get_field('footer_bottom_links','option'); ?>
										<?php foreach($footer_bottom_links as $fbl): ?>
											<li>
												
												<?php if($fbl['url']): ?>
													<a href="<?php echo $fbl['url'];?>">
												<?php endif; ?>
													<?php echo $fbl['label'];?>
												<?php if($fbl['url']): ?>
													</a>
												<?php endif; ?>

											</li>
										<?php endforeach;?>
									</ul>
								</div>
							</div>
						</div>
												
					</div>
				</div> -->
				<div class="footer_main" style="background-image:url('https://brainwellnessspa.com.au/stagingbws/wp-content/uploads/2021/06/footer-bg-new.jpg') ;background-position: center top;background-repeat: no-repeat;background-size: cover;">

				    <div class="container">

				      <div class="row justify-content-center align-self-center">

				        <div class="col-lg-3 col-md-3 col-sm-12 align-self-center">

				          <a href="<?php echo home_url(); ?>" class="footer_logo"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/footer-logo.png" alt="" class="img-fluid"></a>

				        </div>

				        <div class="col-lg-3 col-md-3 col-sm-12 align-self-center">

				            <div class="footer_contbx">

				                <span class="fconticon"><i class="fas fa-map-marker-alt"></i></span>

				                <h5>Stirling Clinic</h5>

				                <p>15-51 Cedric Street. Stirling. 6021 WA.</p>

				            </div>

				        </div>  

				      <div class="col-lg-3 col-md-2 col-sm-12 align-self-center">

				        <div class="footer_contbx">

				            <span class="fconticon callicon"><i class="fas fa-phone"></i></span>

				            <h5>Phone Number</h5>

				            <a href="tel:1300884348">1300 884 348</a>

				        </div>

				      </div>      

				      <div class="col-lg-3 col-md-3 col-sm-12 align-self-center">

				        <div class="footer_contbx">

				            <span class="fconticon"><i class="fas fa-envelope"></i></span>

				            <h5>Email</h5>

				            <a href="mailto:hello@brainwellnessspa.com.au">hello@brainwellnessspa.com.au</a>

				        </div><!--footer_contbx-->

				      </div>

				      </div><!---row-->

				      <div class="footer_menu_secbx">

				          <div class="row">

				            <div class="col-lg-3 col-md-3 col-sm-12">

				              <div class="footermenulist_bx">

				                <h4 class="title">Service<span></span></h4>
				                <?php
				                wp_nav_menu( array( 
				                    'theme_location' => 'footer-sec1-menu', 
				                    'menu_class' => 'footer_menulist',  
				                  ) ); 
				                ?>
				              </div>

				            </div>

				            <div class="col-lg-3 col-md-3 col-sm-12">

				              <div class="footermenulist_bx">

				                <h4 class="title">Program<span></span></h4>

				                <?php
				                wp_nav_menu( array( 
				                    'theme_location' => 'footer-sec2-menu', 
				                    'menu_class' => 'footer_menulist',  
				                  ) ); 
				                ?>
				              
				              </div>

				            </div>

				            <div class="col-lg-2 col-md-2 col-sm-12">

				              <div class="footermenulist_bx">

				                <h4 class="title">Success Story<span></span></h4>

				                <?php
				                wp_nav_menu( array( 
				                    'theme_location' => 'footer-sec3-menu', 
				                    'menu_class' => 'footer_menulist',  
				                  ) ); 
				                ?>
				                
				              </div>

				            </div>

				            <div class="col-lg-2 col-md-2 col-sm-12">

				              <div class="footermenulist_bx">

				                <h4 class="title">Company<span></span></h4>
				                <?php
				                wp_nav_menu( array( 
				                    'theme_location' => 'footer-sec4-menu', 
				                    'menu_class' => 'footer_menulist',  
				                  ) ); 
				                ?>
				                
				              </div>

				            </div>

				            <div class="col-lg-2 col-md-2 col-sm-12">

				              <div class="footermenulist_bx">

				                <h4 class="title">About Us<span></span></h4>
				                <?php
				                wp_nav_menu( array( 
				                    'theme_location' => 'footer-sec5-menu', 
				                    'menu_class' => 'footer_menulist',  
				                  ) ); 
				                ?>
				                
				              </div>

				            </div>

				            <div class="col-lg-3 col-md-3 col-sm-12 fsocialtopbx">

				              <div class="footer_socialbx">

				                <h4 class="title">Social<span></span></h4>

				                <ul class="footersocialtxt">
				                    <li><a href="https://www.facebook.com/brainwellnessspa/"><i class="fab fa-facebook-f"></i></a></li>
				                    <li><a href="https://www.instagram.com/brainwellnessspa/"><i class="fab fa-instagram"></i></a></li>
				                    <li><a href="https://www.linkedin.com/company/brain-wellness-spa/"><i class="fab fa-linkedin-in"></i></a></li>
				                    <li><a href="https://twitter.com/brainhealthspa?lang=en"><i class="fab fa-twitter"></i></a></li>
				                    <li><a href="https://www.youtube.com/channel/UCC632041igVf2YkUo7zM5PA/"><i class="fab fa-youtube"></i></a></li>
				                </ul>

				              </div>

				            </div>

				          </div>

				        </div><!--footer_menu_secbx-->

				    </div><!--container-->

				  </div><!--footer_main-->

				  <div class="grid-container">
					<div class="grid-x footer-bottom-content ">
						<div class="cell">
							<div class="grid-x">
								<div class="cell text-center">
									<?php echo get_field('footer_note','option');?>
								</div>
							</div>
							<div class="grid-x">
								<div class="cell text-center">
									<ul>
										<?php $footer_bottom_links = get_field('footer_bottom_links','option'); ?>
										<?php foreach($footer_bottom_links as $fbl): ?>
											<li>
												
												<?php if($fbl['url']): ?>
													<a href="<?php echo $fbl['url'];?>">
												<?php endif; ?>
													<?php echo $fbl['label'];?>
												<?php if($fbl['url']): ?>
													</a>
												<?php endif; ?>

											</li>
										<?php endforeach;?>
									</ul>
								</div>
							</div>
						</div>
												
					</div>
				</div>
		
				
			</footer> <!-- end .footer -->
	
		<?php wp_footer(); ?>

<script src="https://brainwellnessspa.com.au/stagingbws/wp-content/themes/brainwellnessspa/assets/scripts/js/owl.carousel.min.js"></script>

<script type="text/javascript">
	// Move to JS file
	(function($){

		$('.mob-menu-button').click( function() {
			$('.nav-bottom').toggle();
		});

		$(window).resize( function() {
			$('.nav-bottom').css('display', 'block');
		});

		$('.video_thumbnail').click( function() {
			$('.main_video_popup').toggle();
		});

		$('.main_video_popup .close_btn').click( function() {
			$('.main_video_popup').toggle();
		});

		/* setTimeout( function() {
			$('.covid-popup').toggle();
		}, 10000); */

		$('.covid-popup .close_btn').click( function() {
			$('.covid-popup').toggle();
		});

		$('.covid-popup .covid-popup-no-thanks').click( function() {
			$('.covid-popup').toggle();
		});

		$('.testimonila-slider').slick({
		  slidesToShow: 2,
		  slidesToScroll: 1,
		  autoplay: false,
		  infinite: true,
		  autoplaySpeed: 2000,
		  responsive: [
            {
              breakpoint: 1000,
              settings: {
                slidesToShow: 1,
		  		slidesToScroll: 1
              }
            }
            ]
		});

// 19-03-2021 added by vishva for landing page slider testmonial

$('.testimonial_slide').owlCarousel({
    loop:true,
    margin:10,
    dots: false,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:2
        },
        1000:{
            items:3
        }
    }
})

// landing page slider testmonial done

$(document).on('click', 'a[href^="#"]', function (event) {
    event.preventDefault();

		$('html, body').animate({
		    scrollTop: $($.attr(this, 'href')).offset().top
		}, 500);
	});

})( jQuery );

</script>
<script>
	(function($){
		$('body').css('opacity', 1);


	})( jQuery );	
</script>

<script type='text/javascript'>
		window.__lo_site_id = 182747;
	(function() {
		var wa = document.createElement('script'); wa.type = 'text/javascript'; wa.async = true;
		wa.src = 'https://d10lpsik1i8c69.cloudfront.net/w.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(wa, s);
	})();
</script>


<script type="text/javascript">

$(document).ready(function() {

//scroll top

jQuery(".htdropdown").hide();

    jQuery(document).ready(function(){

    jQuery('.userdropdownbox').click(function() {

       jQuery('.htdropdown').toggle("slide");

    });

});



jQuery(window).scroll(function() {  // OR  $(window).scroll(function() {

    var h = jQuery("header").height();

    var height = (h+0);

    var percentage = (height / jQuery(window).height())*100; 

    if(jQuery(this).scrollTop() > 150) {  

        jQuery("header .main-header").addClass("sticky");

    }else {  

        jQuery("header .main-header").removeClass("sticky");

    }

    

    if(window.matchMedia("(max-width: 767px)").matches){

        var h = jQuery(".main-header").height();

        var percentage = (h / jQuery(window).height())*100; 

        if(jQuery(this).scrollTop() > 150) {

            jQuery(".menuu").addClass("sticky-top");

            jQuery(".menuu").css('top',(percentage+5)+'%');

        }

        else{

            jQuery(".menuu").removeClass("sticky-top"); 

            jQuery(".menuu").css('top','');

        }

        

    } else{  

       if(jQuery(this).scrollTop() > 150) {

            jQuery(".menuu").addClass("sticky-top");

            jQuery(".menuu").css('top',percentage+'%');

        }

        else{

            jQuery(".menuu").removeClass("sticky-top"); 

            jQuery(".menuu").css('top','');

        }

    }

});

jQuery('.onclicksection').on('click', function () {

    var h = jQuery("header").height();

    var height = (h-300);

    var id = jQuery(this).attr('data-id');



    jQuery('html, body').animate({

        scrollTop: jQuery("#"+id).offset().top + height

    }, 1000);

     $('.onclicksection').not(this).removeClass('active');

    $id = "#" + $(this).toggleClass('active').attr('data-id');

});

/*Header sticky*/

 $(window).scroll(function(){

  if ($(window).scrollTop() > 100){   
    $('header.stickynew').addClass('sticky');
  }

  else{   
    $('header.stickynew').removeClass('sticky');
  }

});


/*Anxiety cnt slider*/

$('.anxitey_cnttitleslider').slick({

    slidesToShow: 3,

    autoplay: true,

    autoplaySpeed: 0,

    speed: 5000,

    cssEase:'linear',

    infinite: true,

    focusOnSelect: false,

    variableWidth: true,

    arrows: false,

    responsive: [{

        breakpoint: 768,

        settings: {

            arrows: false,

            slidesToShow: 3

        }

        }, 

        {

            breakpoint: 480,

            settings: {

                arrows: false,

                slidesToShow: 1

            }

    }]

});


/*brain works image js*/



/*end breain work js*/

/*video testionialslider*/

$('.videotestimonialtabslider').slick({

  infinite: true,

  slidesToShow: 1,

  slidesToScroll: 1,

  autoplay:true,

});

$('.listrebeca-video[data-video]').one('click', function() {

var $this = $(this);

var width = $this.attr("width");

var height = $this.attr("height");



//$this.html('<iframe src="https://www.youtube.com/embed/xfBrxZZUMHs?rel=0&showinfo=0&autoplay=1' + $this.data("video") + '?autoplay=1"></iframe>');

});

/*resources slider*/

$('.resource_slider').slick({

 infinite: true,

 slidesToShow: 3,

  slidesToScroll:1,

  autoplay:true,

  arrows: true,

  responsive: [

    {

      breakpoint: 991,

      settings: {

        slidesToShow: 2

      }

    },

    {

      breakpoint: 480,

      settings: {

        slidesToShow: 1

      }

    }

  ]

});

$('.meeteam_slider_bx').slick({

 infinite: true,

 slidesToShow: 1,

 slidesToScroll:1,

 autoplay:true,

  arrows: true,

  responsive: [

    {

      breakpoint: 768,

      settings: {

        slidesToShow: 1

      }

    },

    {

      breakpoint: 480,

      settings: {

        slidesToShow: 1

      }

    }

  ]

});


$('.tabtesimonail_slider').slick({

 infinite: true,

 slidesToShow: 1,

 slidesToScroll:1,

 autoplay:true,

  arrows: true,

  responsive: [

    {

      breakpoint: 768,

      settings: {

        slidesToShow: 1

      }

    },

    {

      breakpoint: 480,

      settings: {

        slidesToShow: 1

      }

    }

  ]

});

$('.audiotestimonial_slider').slick({

 infinite: true,
 autoplay:true,

 slidesToShow: 1,

 slidesToScroll:1,

  arrows: true,

  responsive: [

    {

      breakpoint: 768,

      settings: {

        slidesToShow: 1

      }

    },

    {

      breakpoint: 480,

      settings: {

        slidesToShow: 1

      }

    }

  ]

});

$('.casestudie_slider').slick({

 infinite: true,

 slidesToShow: 2,

 slidesToScroll:1,

  arrows: true,
  autoplay:true,

  responsive: [

    {

      breakpoint: 768,

      settings: {

        slidesToShow: 2

      }

    },

    {

      breakpoint: 480,

      settings: {

        slidesToShow: 1

      }

    }

  ]

});

$('.documentarytabslider').slick({

 infinite: true,

 slidesToShow: 1,

 slidesToScroll:1,

 autoplay:true,

  arrows: true,

  responsive: [

    {

      breakpoint: 768,

      settings: {

        slidesToShow: 1

      }

    },

    {

      breakpoint: 480,

      settings: {

        slidesToShow: 1

      }

    }

  ]

});

$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {

  $('.tabslidercommon').slick('setPosition');

});


});


 
</script>
<script type="text/javascript">
    
    $(function() {
        $('ul li.menusubbx').find('a').addClass('dropdown-toggle');
        $('ul li ul li ').find('a').removeClass('nav-link');
        $('ul li ul li ').find('a').addClass('dropdown-item');
        $('ul li ul').find('a').removeClass('dropdown-toggle');
        
        $('ul li ul li.dropdown-submenu a:first').addClass('dropdown-toggle');
    });

</script>

<style type="text/css">
.fttwocol {
    display: inline-block;
    width: auto;
    margin-right: 105px;
}
</style>


	</body>
	
</html> <!-- end page -->