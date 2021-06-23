<?php
/*
Template Name: Home Landing
*/

get_header(); ?>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,900&display=swap" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets/styles/bootstrap.min.css">
<div class="home_landingpage">
	<section class="sanctuary_sec" style="background: url('<?php echo get_field('first_background_image'); ?>') no-repeat;">
		<div  class="container">
			<div  class="row">
				<div class="col-lg-9 col-md-9 col-sm-12">
					<h2 ><?php echo get_field('first_heading'); ?></h2>
					<?php echo get_field('first_content'); ?>
					<a href="#." class="button mt-2 mt-lg-3"><?php echo get_field('first_button_text'); ?></a>
				</div>
			</div><!--row-->
		</div><!--container-->
	</section><!--sanctuary_sec-->

	<!-- <section class="testimonialslider">
		<div class="container">
			<div class="testimonial_slide">
				<div class="slider autoplay">
				<div class="slide_bx">
					<div class="tetestimonialslidimg"><img src="image/testimonial_img1.png" alt=""></div>
					<div class="tetestimonialslidcnt">
						<h5>Jenny’s Burnout</h5>
						<p>Jenny presented at the Brain Wellness Spa due to feeling that she was burnt out; no energy no motivation and sheer... <a href="#." class="readmore_btn">Read More »</a></p>
					</div>
				</div>
				<div class="slide_bx">
					<div class="tetestimonialslidimg"><img src="image/testimonial_img2.png" alt=""></div>
					<div class="tetestimonialslidcnt">
						<h5>Kay Was in Crisis Mode</h5>
						<p>Kay came to see us in a state of crisis. Unable to control her negative feelings which would come and go daily impacting... <a href="#." class="readmore_btn">Read More »</a></p>
					</div>
				</div>
				<div class="slide_bx">
					<div class="tetestimonialslidimg"><img src="image/testimonial_img3.png" alt=""></div>
					<div class="tetestimonialslidcnt">
						<h5>Overthinking Everything Was Liam’s Life</h5>
						<p>Liam came to see us for anxiety and depression. When he initially came to see us he was really struggling with creating an..<a href="#." class="readmore_btn">Read More »</a></p>
					</div>
				</div>
				<div class="slide_bx">
					<div class="tetestimonialslidimg"><img src="image/testimonial_img1.png" alt=""></div>
					<div class="tetestimonialslidcnt">
						<h5>Jenny’s Burnout</h5>
						<p>Jenny presented at the Brain Wellness Spa due to feeling that she was burnt out; no energy no motivation and sheer mental exhaustion. Jenny... <a href="#." class="readmore_btn">Read More »</a></p>
					</div>
				</div>
			</div>
			</div>
		</div>
	</section> --> <!--testimonialslider--->
	<section class="asseenin_sec">
		<div class="container">
			<h2>As Seen In:</h2>
			<?php $items = get_field('first_icons');?>
			<ul class="asseein_listimg">
				<?php foreach($items as $item): ?>
					<li><img src="<?php echo $item['url'];?>" alt=""></li>
				<?php endforeach; ?>
			</ul>
		</div><!--container-->
	</section><!--asseenin_sec-->
	<section class="bwsvideo_sec">
		<div class="large reveal reveal-video" id="video-modal" data-reveal data-reset-on-close="false" data-animation-in="fade-in" data-animation-out="fade-out" data-options="closeOnClick:false;">
			<div class="wrapper">
				<a data-close aria-label="Close modal" class="close-modal-link" aria-label="Dismiss alert" data-close>×</a>
				<div class="youtube" data-embed="b5V-Avsyh3M" data-vidhost="youtube">
					<div class="play-button"></div>
				</div>
			</div>
		</div>
		<div class="container">
			<h2>See Our Vibe Inside Brain Wellness Spa</h2>
			<div class="row justify-content-center">
				<div class="col-lg-8 col-md-8 col-sm-11">
					<div class="youtube" data-embed="<?php the_sub_field('video');?>" data-vidhost="youtube">
						<div class="play-button"></div>
					</div>
					
				</div>
			</div>
		</div>
	</section><!--bwsvideo_sec-->
	<section class="apporch_sec" style="background: url('<?php echo get_field('second_background_image'); ?>') #fefdfd no-repeat;">
		<div class="container">
			<div class="row justify-content-end text-right">
				<div class="col-lg-7 col-md-7 col-sm-12">
					<h2><?php echo get_field('second_title'); ?></h2>
					<?php echo get_field('second_content'); ?>

				</div>
			</div>
		</div>
	</section>
	<section class="empowermentprogram_sec" style="background: url('<?php echo get_field('third_background_image'); ?>') #fefdfd no-repeat;">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-8 col-sm-12">
					<h2><?php echo get_field('third_title'); ?></h2>
					<p><?php echo get_field('third_content'); ?></p>
					<a href="#." class="button"><?php echo get_field('third_button_text'); ?></a>
				</div>
			</div>
		</div>
	</section>
	<section class="testimonial_sec text-center">
		<div class="container">
			<h2 class="mb-lg-5 mb-md-4 mb-2"><?php echo get_field('client_testmonial_title'); ?></h2>
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-12">
					<div class="ytvideo youtube testimonial-video" data-video="<?php echo get_field('client_testmonial_video'); ?>" style="width:100%; height:319px; background-image:url(image/Client_Transformation.png)">
							 <span class="play-button"></span>
						</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 text-left">
					<p><?php echo get_field('client_testmonial_content'); ?></p>
				</div>
			</div>
			<a href="#." class="button mt-lg-5 mt-md-3 mt-2"><?php echo get_field('client_testmonial_button_text'); ?></a>
		</div>
	</section>
	<section class="natural_method_sec text-center">
		<div class="container">
			<h2><?php echo get_field('fourth_title'); ?></h2>
			<p><?php echo get_field('forth_content'); ?></p>
			<div class="ytvideo youtube naturmethod-video" data-video="" style="width:868px; height:489px; background-image:url(image/Reclaim_their_MentalHealth.png)">
				 <span class="play-button"></span>
			</div>
			<h3><?php echo get_field('forth_sub_title'); ?></h3>
		</div>
	</section><!--natural_method_sec-->
	<section class="experienceself_sec" style="background: url('<?php echo get_field('fifth_background_image'); ?>') no-repeat">
		<div  class="container">
			<div class="row justify-content-end text-right">
				<div class="col-lg-9 col-md-8 col-sm-12">
					<h2><?php echo get_field('fifth_title'); ?></h2>
					<div  class="experience_txt">
						<?php echo get_field('fifth_content'); ?>
					</div>
				</div>
			</div><!--row--> 
		</div>
	</section><!---experienceself_sec-->
	<section class="wordfirst_sec text-center" style="background: url('<?php echo get_field('sixth_background_image') ?>') #fff no-repeat;">
		<div class="container">
			<h2><?php echo get_field('sixth_title'); ?></h2>
			<?php echo get_field('sixth_content'); ?>
		</div>
	</section><!--wordfirst_sec-->
	<section class="perth_sec" style="background:url('<?php echo get_field('seventh_background_image') ?>') #fff no-repeat;">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-8 col-sm-12">
					<?php echo get_field('seventh_content') ?>
					
					<a href="#." class="button" ><?php echo get_field('seventh_button_text'); ?></a>
				</div>
			</div>
		</div>
	</section><!--wordfirst_sec-->
	<section class="videosecprocess text-center">
		<div class="container">
			<h2 class="mb-2 mb-md-3 mb-lg-5"><?php echo get_field('eighth_title'); ?></h2>
			<div class="row justify-content-center">
				<div class="col-lg-8 col-md-8 col-sm-11">
					<div class="ytvideo youtube" data-video="<?php echo get_field('eighth_video'); ?>" style="width:100%; height:481px; background-image:url(image/BWS-Corporate-Video-Thumbnail-1.jpg)">
							 <span class="play-button"></span>
						</div>
				</div>
			</div><!--row-->
		</div>
	</section><!--videosecprocess-->
	<section class="spacenter_sec text-center" style="background:url('<?php echo get_field('ninth_background_image') ?>') no-repeat">
		<div class="container">
			<h2 class="mb-2 mb-md-3 mb-lg-5"><?php echo get_field('ninth_title'); ?></h2>
			<div class="row">
				<?php $items = get_field('items');?>
					<?php foreach($items as $item):?>
							<div  class="col-lg-3 col-md-4 col-sm-6">
								<div class="spacenterbx">
									<div class="spacenterimg"><img src="<?php echo $item['image']; ?>" alt="" class="img-fluid"></div>
									<div class="spacentercnt text-left">
										<h4><?php echo $item['title'];?></h4>
										<p><?php echo $item['content']; ?></p>
										<?php if($item['url']):?>
										<a href="<?php echo $item['url'];?>" class="readmorebtn">Read More</a>
										<?php endif;?>
									</div>
								</div><!--spacenterbx-->
							</div>
				<?php endforeach;?>
			</div><!--row-->
		</div>
	</section><!--videosecprocess-->
	<section class="nathantransformation_sec" style="background: url('<?php echo get_field('client_background_image'); ?>') no-repeat;">
		<div class="container">
			<h2 class="mb-2 mb-md-3 mb-lg-5"><?php echo get_field('client_title'); ?></h2>
			<div class="row">
				<div  class="col-lg-6 col-md-6 col-sm-12">
					<div class="ytvideo youtube nathanvideo" data-video="<?php echo get_field('client_video'); ?>" style="width:100%; height:319px; background-image:url(image/Nathan_Transformation.png)">
						 <span class="play-button"></span>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12">
					<div class="nathancnt_bx">
						<?php echo get_field('client_content');  ?>
					</div>
				</div>
			</div><!--row-->
		</div>
	</section><!--nathantransformation_sec-->
</div>
<?php get_footer(); ?>
