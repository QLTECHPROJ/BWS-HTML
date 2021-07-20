<?php 
/*
Template Name: Home New
*/

get_header('services'); 

global $post;

?>

<section class="banner_sec homebanner_sec" style="background:url(<?php echo get_field('first_background_image'); ?>) no-repeat">
    <!-- <div class="homebanner_img"><img src="<?php echo get_field('first_mobile_image'); ?>" alt="" class="img-fluid"></div> -->
    <div class="hbanner_content">
        <div class="container">
            <div class="row">
                <div class="col-xl-7 col-lg-8 col-md-10 col-sm-12">
                    <div class="banner_content">
                        <h2 class="mb-lg-3 mb-md-3 mb-md-2"><?php echo get_field('first_heading'); ?></h2>
                        <?php echo get_field('first_content'); ?>
            			<div class="bannerhome_btn">
                            <a href="#homeintroform" class="btn-main"><?php echo get_field('first_button_text'); ?></a>
                            <a href="#." class="btn-main trans-black home_popvideo" data-toggle="modal" data-target="#exampleModal">SEE WHAT TO EXPECT <i class="fas fa-play"></i></a>
                        </div>
                    </div>
                </div>            
            </div>
        </div>
    </div>
</section>
<div class="modal fade home_popvideo" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <button type="button" class="close close-modal-link" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span> </button>
      <div class="modal-body">
        <div class="youtube" data-embed="pzqD4sLx6NA" data-vidhost="youtube"><iframe frameborder="0" allowfullscreen="" src="https://www.youtube.com/embed/pzqD4sLx6NA?rel=0&amp;showinfo=0&amp;autoplay=1"></iframe></div>
      </div>
    </div>
  </div>
</div><!--home_popvideo-->
<section class="google_reviewsec">
    <div class="contaner">
        <?php // echo  do_shortcode('[trustindex no-registration=google]'); ?>
        <script defer async src='https://cdn.trustindex.io/loader.js?4503345306c58005835c061014'></script>
      <!-- <img src="<?php echo get_field('google_review_image'); ?>" class="img-fluid"> -->
    </div>
</section>
<div class="Home_newpage">
    <section class="wecanhelpsec">
        <div class="container">
           <h2 class="text-blue"><?php echo get_field('second_title'); ?></h2>
            <div class="row justify-content-center" >    
                <div class="col-lg-10 col-md-10 col-sm-12">
                    <?php echo get_field('second_content'); ?>
                </div>
            </div>
            <div class="wecanrowbx">
                <div class="row">
                	<?php
                        $args1 = array(  
                            'post_type' => 'help-you',
                            'post_status' => 'publish',
                            'orderby' => 'id', 
                            'order' => 'ASC',
                        );

                        $casestudy = new WP_Query( $args1 ); 
                        while ( $casestudy->have_posts() ) : $casestudy->the_post(); 
                      
                    ?>
                    
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <a href="<?php echo get_field('url'); ?>" target="_blank"  class="wecanboxcol" style="background:url(<?php echo get_field('image'); ?>) no-repeat" >
                            <div class="wecancntbxcol">
                                <h3><?php the_title(); ?></h3>
                                <?php //$contentwecanhelp = mb_strimwidth(get_the_content(), 0, 50, '...');  ?>
                                 <?php  // $stringCut = substr(get_the_content(), 0, 50);
                                //         $endPoint = strrpos($stringCut, ' ');
                                //         $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                //         $string .= '... '; ?>
                                <p><?php echo get_the_content(); ?></p>
                                <span class="discovmorbtn">Discover More</span>
                            </div>
                        </a>
                    </div>
                    <?php
                        endwhile;
                        wp_reset_postdata(); 
                    ?>
                </div>
            </div>
        </div>
    </section><!--wecanhelpsec-->
    <section class="whoeffect_sec" style="background: url(<?php echo get_field('what_does_it_affect_background_image'); ?>) no-repeat;">
        <div class="container">
            <h2 class="text-blue"><?php echo get_field('what_does_it_affect_title'); ?></h2>
            <?php echo get_field('what_does_it_affect_content'); ?>
            <div class="whoeffect_slider">
            	<?php $itaffectitems = get_field('what_does_it_affect_items');?>
                <?php foreach($itaffectitems as $itaffectitem):?>
                <div class="whoeff_slidebx">
                    <div class="whoeff-slidimg">
                        <img src="<?php echo $itaffectitem['image'];?>" alt="">
                        <span class="whoeffslideimgtitle"><?php echo $itaffectitem['image_text'];?></span>
                    </div>
                    <div class="whoeff_cntbxslide">
                        <?php echo $itaffectitem['description'];?>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        </div>
    </section><!--whoeffect_sec-->
	<section class="ideal_transformation_sec">
	    <div class="container">   
	        <h2 class="text-blue"><?php echo get_field('pathways_title'); ?></h2>
	         <div class="listentabbx_sec">
	            <ul class="nav nav-tabs" role="tablist">
	            	<?php 
	                  $toptab = get_field('pathways_sub_title');
	                  $toptab1 = explode(',', $toptab);
	                  $i=1;
	                  foreach ($toptab1 as $key => $value) {
	                  	$pst = explode('-', $value)
	                  	                  
	                 ?>
	                	<li class="nav-item"><a class="nav-link <?php if($i==1){ ?> active <?php } ?>" data-toggle="tab" href="#<?php echo $pst[0]; ?>"><?php echo $pst[1]; ?></a></li>
	                <?php  $i++;
	                 } ?>
	            </ul>
	        </div><!--listentabbx_sec-->
	    </div>
	    <div class="listtabcntbx">
	        <div class="container">
	            <div class="tab-content">
	            	<?php $pathwayscontents = get_field('pathways_sub_content'); $j = 1; ?>
	                <?php foreach($pathwayscontents as $pathwayscontent):?>
		                <div id="<?php echo $pathwayscontent['title_id'] ?>" class="tab-pane <?php if($j==1){ ?> active <?php } ?>">
		                    <div class="row">
		                        <div class="col-lg-7 col-md-7 col-sm-12">
		                            <h3><?php echo $pathwayscontent['title'] ?></h3>
		                            <?php echo $pathwayscontent['content'] ?>
		                            <a href="<?php echo $pathwayscontent['url'] ?>" class="morebtn">Know More »</a>
		                        </div>
		                        <div class="col-lg-5 col-md-5 col-sm-12">
                                    <div class="ideal_info_img">
                                        <img src="<?php echo $pathwayscontent['image'] ?>" alt="" class="img-fluid">
                                    </div>
		                        </div>
		                    </div>
		                </div>
	                <?php $j++; endforeach;?>
	            </div>
	        </div>
	    </div>
    </section><!---ideal_transformation_sec-->
    <section class="whyshoud_chooseus_sec brain-bgimg">
        <div class="container">
            <h2 class="text-blue"><?php echo get_field('choose_us_title'); ?></h2>
            <div class="whyshoud_chootxt">
                <?php echo get_field('choose_us_content'); ?>
            </div>
            <div class="row">
            	<?php $chooseusitems = get_field('choose_us_items');  $c = 0;?>
            	<?php foreach ($chooseusitems as $chooseusitem) { ?>
            		<div class="col-lg-4 col-md-4 col-sm-6 wsc-bxborder <?php if($c == 3 || $c == 4 || $c == 5){ ?> wsc-bxborbottom-none <?php } ?>">
	                    <div class="whyshchoos_bx">
	                        <div class="spadifficon"><img src="<?php echo $chooseusitem['image'] ?>" alt="" class="img-fluid"></div>
	                        <h4 class="mb-0 mt-2 mt-md-3 mt-lg-4"><?php echo $chooseusitem['title'] ?></h4>
	                    </div>
	                </div>
            	<?php  $c++; } ?>
            </div>
        </div>
    </section><!--whyshoud_chooseus_sec-->
    <section class="graphic_slidersec">
        <div class="container">
            <h2 class="text-blue"><?php echo get_field('third_title'); ?></h2>
            <div class="grapgic_imgslider">
                <?php $thirdimages = get_field('third_content'); ?>
                <?php foreach($thirdimages as $thirdimage){ ?>
                    <div class="graphic_imgslide">
                        <?php echo $thirdimage['text_content']; ?>
                        <img src="<?php echo $thirdimage['image']; ?>" alt="" class="img-fluid">
                    </div>
                <?php } ?>
            </div>
        </div>
    </section><!--graphic_slidersec-->
    <?php if(get_field('slider_text') != ''){ ?>
    <section class="anxiety_depsec text-center">
        <div class="container">
            <div class="anxitey_cnttitleslider">
                <?php 
                  $slidertext = get_field('slider_text');
                  $slidertext1 = explode(',', $slidertext);
                  foreach ($slidertext1 as $k => $v) {
                ?>
                    <div class="anxietyslidbx item">
                        <h3><?php echo $v; ?> </h3>
                    </div>
                <?php  } ?>
            </div>
        </div>
    </section><!--anxiety_depsec-->
    <?php } ?>
    <section class="howitwork_sec brain-rightimg brain-bgimg brainrightopimg" id="overview" >
        <div class="container">
            <h2 class="text-blue"><?php echo get_field('how_does_it_work_title'); ?></h2>
            <?php echo get_field('how_does_it_work_content'); ?>
    		<div class="symotomstwocolrow">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 align-self-center">
                        <div class="symortoms-img text-left"><img src="<?php echo get_field('unique_approch_image'); ?>" alt="" class="img-fluid"></div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 align-self-center">
						<div class="symotoms_cntbx text-left">
						  <h2 class="text-blue"><?php echo get_field('unique_approch_title'); ?></h2>
						  <?php echo get_field('unique_approch_content'); ?>
                        </div>
                    </div>								
				</div>
			</div>

			<div class="symotomstwocolrow">
	    		<div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 align-self-center">
                        <div class="symotoms_cntbx text-left">
                          <h2 class="text-blue"><?php echo get_field('world_first_title'); ?></h2>
                          <?php echo get_field('world_first_content'); ?>
                        </div>
                    </div>
	    			<div class="col-lg-6 col-md-6 col-sm-12 align-self-center">
					  <div class="symortoms-img text-right">
                        <img src="<?php echo get_field('world_first_image'); ?>" alt="" class="img-fluid">
                      </div>
					</div>
    	      </div>
			</div>
    	</div>
    </section>
    <section class="experiencelook_sec">
        <div class="container">
            <h2 class="text-blue"><?php echo get_field('experience_look_title'); ?></h2>
            <div class="row justify-content-center">
                <?php $explookcontents = get_field('experience_look_content'); ?>
                <?php $e = 1;
                    foreach($explookcontents as $explookcontent){ ?>
                <div class="col-lg-3 col-md-4 col-sm-6 explright-arrow">
                    <div class="experienceloobx">
                        <div class="exlookiocn <?php if($e==1){ ?> bgblue <?php } ?> <?php if($e==2 || $e==7){ ?>bgorange <?php } ?> <?php if($e==3 || $e==6){ ?>bgpink <?php } ?> <?php if($e==4){ ?>bglgreen <?php } ?> <?php if($e==5){ ?>bglblue <?php } ?> ">
                            <img src="<?php echo $explookcontent['image']; ?>" alt="">
                        </div>
                        <div class="exlooktitle">
                            <h5><?php echo $explookcontent['title']; ?></h5>
                        </div>
                    </div>
                </div>
                <?php $e++; } ?>
            </div>
            <?php if(get_field('experience_look_button_url') != ''){ ?>
                <a href="<?php echo get_field('experience_look_button_url'); ?>" class="btn-main explookbtn"><?php echo get_field('experience_look_button_text'); ?></a>
            <?php } ?>
        </div>
    </section><!--experiencelook_sec-->
    <section class="listenstory_sec text-center brain-bgimg" style="background: url(<?php echo get_field('transformation_background_image'); ?>) no-repeat;">
        <div class="container">
            <h2 class="text-blue mb-2 mb-md-3 mb-lg-4"><?php echo get_field('transformation_title'); ?></h2>
    	    <div class="videotestimonialtabslider text-left tabslidercommon">
                <?php $transformationcontents = get_field('transformation_content'); ?>
                <?php foreach($transformationcontents as $transformationcontent){ ?>
                <div class="videoslidbx">
                    <div class="row align-items-center">
                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <div class="videotestmonialtslidimg">
                                <div class="youtube" data-embed="<?php echo $transformationcontent['video']; ?>" style="width:100%; height:322px;">
                                    <span class="play-button"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6">
                            <h3><?php echo $transformationcontent['title']; ?></h3>
                            <?php echo $transformationcontent['content']; ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div><!--container--> 

    </section><!--listenstory_sec-->
    <section class="testimonial_slider_sec">
        <div class="testimonalslider-bxsec ">
            <?php $TextImageVideos = get_field('text_video_image'); ?>
            <?php $t = 1; foreach ($TextImageVideos as $TextImageVideo) { ?>
            <div class="tesidebxmain" style="background:url(<?php echo $TextImageVideo['image']; ?>) no-repeat;" >
                <img src="<?php echo $TextImageVideo['image']; ?>" class="img-fluid">
                <div class="tesimonail_slide_cnt ">
                    <div class="container">
                        <div class="testimonislidecntxtbx">
                            <h3><?php echo $TextImageVideo['title']; ?></h3>
                            <?php  
                                $contentwordcount = str_word_count($TextImageVideo['content']);
                                if($contentwordcount > 100){
                                    // $string = mb_strimwidth($TextImageVideo['content'], 0, 200, '...');

                                    $stringCut1 = substr($TextImageVideo['content'], 0, 200);
                                    $endPoint1 = strrpos($stringCut1, ' ');
                                    $string = $endPoint? substr($stringCut1, 0, $endPoint1) : substr($stringCut1, 0);
                                    $string .= '... ';
                                }else{
                                    $string = $TextImageVideo['content'];
                                }
                            ?>
                            <?php echo $string; 

                            if($contentwordcount > 100){ ?>
                                <p><button class="testimonailreadmore" data-toggle="modal" data-target="#slidecnttestimoanilpopup<?php echo $t ?>">Read More</button></p>
                            <?php } ?>
                            <div class="playbtntestilmonial">
                                <button class="playicons" data-toggle="modal" data-target="#testimonialpopupModal<?php echo $t ?>"><img src="<?php echo $TextImageVideo['play_image']; ?>"></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php $t++; } ?>
        </div>
       <?php if(get_field('text_video_section_button_url') != ''){ ?>
                <a href="<?php echo get_field('text_video_section_button_url'); ?>" class="btn-main"><?php echo get_field('text_video_section_button_text'); ?></a>
        <?php } ?>
    </section><!--testimonial_slider_sec-->
    <?php $TextImageVideosss = get_field('text_video_image'); ?>
    <?php $y = 1; foreach ($TextImageVideosss as $TextImageVideos) { ?>
    <?php 
    $contentwordcount = str_word_count($TextImageVideos['content']);
    if($contentwordcount > 100){ ?>
        <div class="modal fade slidecnttestimoanilpopup" id="slidecnttestimoanilpopup<?php echo $y ?>" tabindex="-1" role="dialog" aria-labelledby="slidecnttestimoanilpopup<?php echo $y ?>" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <div class="modal-body">
                <div class="slidepoptestimonialcntbx">
                    <?php echo $TextImageVideos['content']; ?>
                    <div class="slidetestionail_img-namecnt">
                        <img src="<?php echo $TextImageVideos['popup_image']; ?>" class="img-fluid">
                        <div class="slideimgtestpopupcnt">
                            <h3><?php echo $TextImageVideos['title']; ?></h3>
                        </div>
                    </div>
                </div><!--slidepoptestimonialcntbx-->
              </div>
            </div>
          </div>
        </div>
    <?php } ?>
    <?php $y++; } ?>
    <div class="modal fade hometestimonial_popvideo" id="testimonialpopupModal1" tabindex="-1" role="dialog" aria-labelledby="testimonialpopupModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <button type="button" class="close close-modal-link" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span> </button>
          <div class="modal-body">
            <div class="youtube" data-embed="YNd-pnPpfFo" data-vidhost="youtube"><iframe frameborder="0" allowfullscreen="" src="https://www.youtube.com/embed/YNd-pnPpfFo?rel=0&amp;showinfo=0&amp;autoplay=1"></iframe></div>
          </div>
        </div>
      </div>
    </div><!--hometestimonial_popvideo-->
    <div class="modal fade hometestimonial_popvideo" id="testimonialpopupModal2" tabindex="-1" role="dialog" aria-labelledby="testimonialpopupModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <button type="button" class="close close-modal-link" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span> </button>
          <div class="modal-body">
            <div class="youtube" data-embed="hUUyapA3QvM" data-vidhost="youtube"><iframe frameborder="0" allowfullscreen="" src="https://www.youtube.com/embed/hUUyapA3QvM?rel=0&amp;showinfo=0&amp;autoplay=1"></iframe></div>
          </div>
        </div>
      </div>
    </div><!--hometestimonial_popvideo-->
    <div class="modal fade hometestimonial_popvideo" id="testimonialpopupModal3" tabindex="-1" role="dialog" aria-labelledby="testimonialpopupModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <button type="button" class="close close-modal-link" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"><i class="fas fa-times"></i></span> </button>
          <div class="modal-body">
            <div class="youtube" data-embed="r-afP4CZA-w" data-vidhost="youtube"><iframe frameborder="0" allowfullscreen="" src="https://www.youtube.com/embed/r-afP4CZA-w?rel=0&amp;showinfo=0&amp;autoplay=1"></iframe></div>
          </div>
        </div>
      </div>
    </div><!--hometestimonial_popvideo-->
    <section class="resourse_sec">
        <div class="container">
            <h2 class="text-blue"><?php echo get_field('resources_title'); ?></h2>
            <div class="row">
                <?php
                    $args = array(  
                        'post_type' => 'post',
                        'post_status' => 'publish',
                        'orderby' => 'title', 
                        'order' => 'DESC',
                        'posts_per_page' => '4'
                        // 'category_name'=>'depression'
                    );

                    $loop = new WP_Query( $args ); 
                    $r = 1;
                    while ( $loop->have_posts() ) : $loop->the_post(); 
                    
                ?>
                <div class="<?php if($r == 1 || $r == 4){ ?> col-lg-7 col-md-7 col-sm-6 <?php }else{ ?> col-lg-5 col-md-5 col-sm-6 <?php } ?>">
                    <div class="resourse_bx">
                        <div class="resourceimg">
                            <img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id( $post->ID ), 'thumbnail' );?>" alt="" class="img-fluid">
                            <span class="resourimgtag">Blog</span>
                        </div>
                        <div class="resourcecntbx">
                            <h3 class="text-blue"><?php the_title(); ?></h3>
                            <?php $contentblogpost = mb_strimwidth(get_the_content(), 0, 200, '...');  ?>
                            <div class="resourctxt">
                                <p><?php echo strip_tags($contentblogpost); ?></p>
                            </div>
                            <a href="<?php the_permalink(); ?>" target="_blank" class="morebtn">Know More »</a>
                        </div>
                    </div>
                </div>
                <?php
                    $r++;
                    endwhile;
                    
                    wp_reset_postdata(); 
                ?>
            </div>
            <?php if(get_field('resource_button_url') != ''){ ?>
                <a href="<?php echo get_field('resource_button_url'); ?>"class="btn-main btn-trans hresourcebtn"><?php echo get_field('resource_button_text'); ?></a>
            <?php } ?>
        </div>
    </section><!--resourse_sec-->
    <section class="onestsession_introductorysec">
        <div class="container">
            <div class="row" id="homeintroform">
                <div class="col-lg-7 col-md-6 col-sm-12 align-self-center">
                    <div class="onesession_intocntsec">
                        <h2 class="text-blue"><?php echo get_field('introductory_title'); ?></h2>
                        <?php echo get_field('introductory_content'); ?>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6 col-sm-12 align-self-center">
                    <div class="introductory_sec">
                        <?php the_field('introductory_form'); ?>
                    </div>
                    <div class="onesession_autorsec mt-2 mt-md-3 mt-lg-4">
                        <div class="onesession_img"><img src="<?php echo get_field('introductory_sub_image'); ?>" alt="" class="img-fluid"></div>
                        <div class="onesession_cnt">
                            <h4 class="m-0"><strong><?php echo get_field('introductory_sub_title'); ?></strong></h4>
                            <p><?php echo get_field('introductory_sub_content'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!--1stsession_introductorysec-->

    <section class="asseenin_sec">
        <div class="container">
            <h2 class="font-weight-bold text-orange">As Seen In:</h2>
            <?php $items = get_field('icons'); ?>
            <ul class="asseein_listimg">
                <?php foreach($items as $item): ?>
                    <li><img src="<?php echo $item['url'];?>" width="100%" height="auto" alt="itemicons"></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
</div><!--depression_landingnewpage-->


<?php echo do_shortcode('[global_popup]'); ?>
<?php  get_footer('services'); ?>
