<?php 
/*
Template Name: Depression Landing New
*/

get_header('depression'); ?>

<div class="site-main">

    <section class="banner_sec" style="background: url('<?php echo get_template_directory_uri(); ?>/newdepressionlanding/images/depression_Top_Banner.png') no-repeat;">

       <video autoplay loop muted class="wrapper__video">

          <source src="<?php echo get_template_directory_uri(); ?>/newdepressionlanding/images/Depression_Landing_page_Vidoe.mp4">

        </video> 

        <div class="banner_cntbxmain">

            <div class="container">
            
                <nav aria-label="breadcrumb">
            
                  <ol class="breadcrumb">
            
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
            
                    <li class="breadcrumb-item" aria-current="page"><a href="#">Services</a></li>
            
                    <li class="breadcrumb-item active" aria-current="page">Depression</li>
            
                  </ol>
            
                </nav>
            
                <div class="row">
            
                    <div class="col-xl-7 col-lg-8 col-md-10 col-sm-12">
            
                        <div class="banner_content">
            
                            <h2 class="text-white mb-lg-3 mb-md-3 mb-md-2"><?php echo get_field('first_title'); ?></h2>
            
                            <h5 class="text-white"><?php echo get_field('first_sub_title'); ?></h5>
            
                            <p class="text-white"><?php echo get_field('first_content'); ?></p>
            
                            <a href="<?php echo get_field('first_button_url'); ?>" class="btn-main mt-lg-4 mt-mb-3 mt-sm-2"><?php echo get_field('first_button_text'); ?></a>
            
                        </div><!--banner_content-->
            
                    </div>            
            
                </div><!--row-->
            
                <blockquote class="blockquote">
            
                  <p><?php echo get_field('first_sub_content'); ?></p>
            
                  <h5 class="m-0">Alicia</h5>
            
                </blockquote>
            
            </div>
        
        </div>
        
    </section><!--banner_sec-->

    <div class="depression_landingnewpage">

        <section class="asseenin_sec">

            <div class="container">

                <h2 class="font-weight-bold text-orange">As Seen In:</h2>

                <?php $items = get_field('first_icon'); ?>
                <ul class="asseein_listimg">
                    <?php foreach($items as $item): ?>
                        <li><img src="<?php echo $item['url'];?>" width="100%" height="auto" alt="itemicons"></li>
                    <?php endforeach; ?>
                </ul>

            </div><!--container-->

        </section>

        <section class="depressiontab_sec menuu">

            <div class="container">

                <nav class="navbar navbar-expand-md navbar-light bg-none p-0">

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent1">

                      <span class="navbar-toggler-icon"></span>

                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent1">

                      <ul class="navbar-nav m-auto deprestabmenu">
                        <?php 
                          $toptab = get_field('submenu');
                          $toptab1 = explode(',', $toptab);
                          foreach ($toptab1 as $key => $value) {
                          
                         ?>
                        <li class="nav-item">

                          <a class="nav-link onclicksection" data-id="<?php echo str_replace(' ', '', $value); ?>" href="javascript:;"><?php echo $value; ?></a>

                        </li>

                        <?php } ?>
                      </ul>

                    </div>

                </nav>

            </div>

        </section><!--depressiontab_sec-->

        <section class="symotoms_sec brain-bgimg" id="Overview" >

            <div class="container">
                <?php
                    $args = array(  
                        'post_type' => 'depression-details',
                        'post_status' => 'publish',
                        'orderby' => 'title', 
                        'order' => 'DESC',
                        'category_name'=>'Depression Landing Section1'
                    );

                    $loop = new WP_Query( $args ); 
                    while ( $loop->have_posts() ) : $loop->the_post(); 
                    
                    // echo $post->ID;
                ?>

                <div class="symotomstwocolrow">

                    <div class="row">

                        <?php if ($post->ID == 14596) { ?>
                            <div class="col-lg-6 col-md-6 col-sm-12 align-self-center">

                              <div class="symortoms-img text-left"><img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id( $post->ID ), 'thumbnail' );?>" alt="" class="img-fluid"></div>

                            </div>
                        <?php } ?>

                        <div class="col-lg-6 col-md-6 col-sm-12 align-self-center">

                            <div class="symotoms_cntbx">

                              <h2 class="text-blue"><?php echo the_title();?></h2>
                              <?php $contentblog = mb_strimwidth(get_the_content(), 0, 300, '...');  ?>
                              <p>
                                <?php echo $contentblog;?> 
                              </p>
                              <a href="<?php the_permalink() ?>" target="_blank" class="morebtn">Know More »</a>
                            </div>

                        </div>
                        <?php if ($post->ID == 14579) { ?>
                            <div class="col-lg-6 col-md-6 col-sm-12 align-self-center">

                              <div class="symortoms-img text-right"><img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id( $post->ID ), 'thumbnail' );?>" alt="" class="img-fluid"></div>

                            </div>
                       <?php  } ?>
                        
                    </div><!--row-->

                </div>
                <?php
                    endwhile;
                    wp_reset_postdata(); 
                ?>
                
            </div>

        </section>

        <section class="symotoms_sec_two brain-rightimg brain-bgimg" id="Symptoms" style="background: url('<?php echo get_template_directory_uri(); ?>/newdepressionlanding/images/bg_img.png') no-repeat;" >

            <div class="container">

                <?php
                    $args = array(  
                        'post_type' => 'depression-details',
                        'post_status' => 'publish',
                        'orderby' => 'title', 
                        'order' => 'DESC',
                        'category_name'=>'Depression Landing Section2'
                    );

                    $loop = new WP_Query( $args ); 
                    while ( $loop->have_posts() ) : $loop->the_post(); 
                    
                ?>

                <div class="symotomstwocolrow">

                    <div class="row">

                        <?php if ($post->ID == 14606) { ?>
                            <div class="col-lg-6 col-md-6 col-sm-12 align-self-center">

                              <div class="symortoms-img text-left"><img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id( $post->ID ), 'thumbnail' );?>" alt="" class="img-fluid"></div>

                            </div>
                        <?php } ?>

                        <div class="col-lg-6 col-md-6 col-sm-12 align-self-center">

                            <div class="symotoms_cntbx">

                              <h2 class="text-blue"><?php echo the_title();?></h2>
                              <?php $contentblog2 = mb_strimwidth(get_the_content(), 0, 300, '...');  ?>
                              <p><?php echo $contentblog2;?> </p>

                              <?php if($post->ID == 14608){  ?>
                                        <a href="#." class="btn-main btn-trans mt-2 mt-md-3 mt-lg-4">Start Your Test</a>
                              <?php }else{ ?>
                              
                                        <a href="<?php the_permalink() ?>" target="_blank" class="morebtn">Know More »</a>
                              <?php  } ?>
                            </div><!---symotoms_cntbx-->

                        </div>
                        <?php if ($post->ID == 14601 || $post->ID == 14608) { ?>
                            <div class="col-lg-6 col-md-6 col-sm-12 align-self-center">

                              <div class="symortoms-img text-right"><img src="<?php echo wp_get_attachment_url( get_post_thumbnail_id( $post->ID ), 'thumbnail' );?>" alt="" class="img-fluid"></div>

                            </div>
                        <?php } ?>
                    </div><!--row-->

                </div>

                <?php
                    endwhile;
                    wp_reset_postdata(); 
                ?>

            </div><!--container-->

        </section><!--symotoms_sec-->

        <section class="bwsworks_Sec" id="Solution">

            <div class="container">

                <div class="row align-items-center">

                    <div class="col-lg-6 col-md-6 col-sm-12">

                        <div class="bwsworksimg">

                            <img src="<?php echo get_field('bws_works_image'); ?>" alt="" class="img-fluid">

                        </div>

                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12">

                        <div class="bwsworkseccntbx">

                            <h2 class="text-blue"><?php echo get_field('bws_works_title'); ?></h2>
                            <?php echo get_field('bws_works_content'); ?>
                        </div><!--bwsworkseccntbx-->

                    </div>

                </div><!--row-->

            </div><!--container-->

        </section><!--bwsworks_Sec-->

        <section class="client_statices_sec text-center brain-rightimg brain-bgimg brainrightopimg" id="ClientStories">

            <div class="container">

                <h2 class="text-blue"><?php echo get_field('client_statistics_title'); ?></h2>

                <?php echo get_field('client_statistics_content'); ?>

                <div class="clientstaticesimg"><img src="<?php echo get_field('client_statistics_image'); ?>" alt="" class="img-fluid"></div>

            </div>

        </section><!--client_statices_sec-->

        <section class="spadifference_sec text-center brain-bgimg">

            <div class="container">

                <h2 class="text-blue mb-4 mb-md-3 mb-lg-5"><?php echo get_field('bws_difference_title'); ?></h2>

                <div class="row">

                    <?php $items = get_field('bws_difference_items');?>
                        <?php foreach($items as $item):?>

                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="spadiffbx">
                                    <div class="spadifficon"><img src="<?php echo $item['icon'];?>" alt="" class="img-fluid"></div>

                                    <h4 class="mb-0 mt-2 mt-md-3 mt-lg-4"><?php echo $item['title'];?></h4>
                                    
                                </div>
                            </div>
                        <?php endforeach;?>
                </div>

            </div>

        </section><!--spadifference_sec-->

        <section class="anxiety_depsec text-center">

            <div class="container">

                <div class="anxitey_cnttitleslider">
                    <?php 
                      $slidertext = get_field('slider_text');
                      $slidertext1 = explode(',', $slidertext);
                      foreach ($slidertext1 as $k => $v) {
                     ?>
                        <div class="anxietyslidbx">

                            <h3><?php echo $v; ?> </h3>

                        </div>
                    <?php  } ?>
                </div><!---anxitey_cnttitleslider-->
            </div>

        </section><!--anxiety_depsec-->

        <section class="listenstory_sec text-center">

            <div class="container">

                <h2 class="text-blue mb-2 mb-md-3 mb-lg-4">Listen<strong>Transformation </strong> Story</h2>

                <div class="listentabbx_sec">

                        <ul class="nav nav-tabs" role="tablist">

                            <li class="nav-item">

                              <a class="nav-link active" data-toggle="tab" href="#documentary">Documentary</a>

                            </li>

                            <li class="nav-item">

                              <a class="nav-link" data-toggle="tab" href="#audiotestimonials">Audio testimonials</a>

                            </li>

                            <li class="nav-item">

                              <a class="nav-link" data-toggle="tab" href="#videotestimonials">Video testimonials</a>

                            </li>

                            <li class="nav-item">

                              <a class="nav-link" data-toggle="tab" href="#casestudies">Case studies</a>

                            </li>

                            <li class="nav-item">

                              <a class="nav-link" data-toggle="tab" href="#testimonials">Testimonials</a>

                            </li>

                        </ul>

                </div><!--listentabbx_sec-->

            </div><!--container-->

             <div class="listtabcntbx">

                 <div class="container">

                    <div class="tab-content">

                       <div id="documentary" class="tab-pane active">

                          <h3>HOME</h3>

                          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

                        </div>

                        <div id="audiotestimonials" class="tab-pane fade">
                          <?php $audioitems = get_field('audio_testmonial');?>
                          <?php foreach($audioitems as $audioitem):?>
                            <div class="item-inner">
                                <div class="heading">
                                    <div class="featured-image"><img src="<?php echo $audioitem['featured_image'];?>"  alt="audio testimonial img" /></div>
                                    <div class="title"><?php echo $audioitem['title']; ?></div>
                                </div>
                                <div class="content"><?php echo $audioitem['content']; ?></div>                               
                            </div>
                            <div class="audio"><?php echo $audioitem['audio'];?></div>
                          <!-- <h3><?php echo $audioitem['title']; ?></h3>

                          <p><?php echo $audioitem['content']; ?></p> -->
                          <?php endforeach;?>
                        </div>

                        <div id="videotestimonials" class="tab-pane fade">
                            <div class="videotestimonialtabslider text-left tabslidercommon">
                                <?php $videoitems = get_field('video_testmonial');?>
                                <?php foreach($videoitems as $videoitem):?>
                                    <div class="videoslidbx">
                                        <div class="row align-items-center">
                                            <div class="col-lg-6 col-md-6 col-sm-6">
                                                <div class="videotestmonialtslidimg">
                                                    <div class="youtube" data-embed="<?php echo $videoitem['video']; ?>" style="width:100%; height:322px;">
                                                        <span class="play-button"></span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-md-6 col-sm-6">

                                                <h3><strong><?php echo $videoitem['title'];?></strong></h3>

                                                <p><?php echo $videoitem['title'];?></p>

                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach;?>
                            </div><!--videotestimonialtabslider-->
                        </div>
                        
                        <div id="casestudies" class="tab-pane fade">
                            <?php
                                $args1 = array(  
                                    'post_type' => 'case-study',
                                    'post_status' => 'publish',
                                    'orderby' => 'title', 
                                    'order' => 'DESC',
                                    // 'category_name'=>'Depression Landing Section2'
                                );

                                $casestudy = new WP_Query( $args1 ); 
                                while ( $casestudy->have_posts() ) : $casestudy->the_post(); 
                                
                                if(get_the_title() == 'Overthinking Everything Was Liam’s Life'){ }else{
                            ?>

                              <h3><?php the_title(); ?></h3>
                              <?php $contentcasestudy = mb_strimwidth(get_the_content(), 0, 300, '...');  ?>
                              <p><?php echo $contentcasestudy; ?></p>
                              <a href="<?php the_permalink() ?>" target="_blank" class="morebtn">Know More »</a>
                              <?php
                                    }
                                    endwhile;
                                    wp_reset_postdata(); 
                              ?>
                      
                        </div>

                        <div id="testimonials" class="tab-pane fade">
                          <div class="tabtesimonail_slider tabslidercommon">
                            <?php
                                $args = array(  
                                    'post_type' => 'testimonial',
                                    'post_status' => 'publish',
                                    'orderby' => 'title', 
                                    'order' => 'DESC',
                                    // 'category_name'=>'Depression Landing Section2'
                                );

                                $loop = new WP_Query( $args ); 
                                while ( $loop->have_posts() ) : $loop->the_post(); 
                                
                            ?>
                              <div class="tabtestimonialbx">
                                <div class="tabtestimoimg"><img src="<?php if(get_field('testimonial_image')){  echo get_field('testimonial_image'); } ?>" alt="" class="img-fluid"></div>
                                <div class="tabtestimocnt">
                                    <h4 class="font-weight-bold"><?php the_title(); ?></h4>
                                    <?php $testmonialcontent = mb_strimwidth(get_the_content(), 0, 300, '...');  ?>
                                    <p><?php echo $testmonialcontent; ?></p>
                                </div>
                              </div>
                              <?php
                                    endwhile;
                                    wp_reset_postdata(); 
                              ?>
                          </div>
                        </div>

                    </div>
                    <a href="#." class="btn-main mt-3 mt-md-4 mt-lg-5">Watch more Success Story</a>
                </div>

            </div>

        </section><!--listenstory_sec-->

        <section class="meetteam_sec text-center" id="Team">

            <div class="container">

                <h2 class="text-blue">Meet <strong>Our Team</strong></h2>

                <div class="meeteam_slider_bx">

                    <div>
                        <?php
                          $type = 'team';
                          $args=array(
                          'post_type' => $type,
                          'post_status' => 'publish',
                          'posts_per_page' => -1,
                          'caller_get_posts'=> 1,
                            'order' => 'asc'
                          );
                          $my_query = null;
                          $my_query = new WP_Query($args);
                          if( $my_query->have_posts() ) {
                          while ($my_query->have_posts()) : $my_query->the_post(); 
                        ?>
                        <div class="row align-items-center">

                           <div class="col-lg-4 col-md-5 col-sm-12">

                                <div class="meetimg">
                                    <?php if(has_post_thumbnail()): ?>
                                <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('team-member'); ?></a><?php endif; ?>
                                    <!-- <img src="<?php the_post_thumbnail('team-member'); ?>" alt="" class="meetamimg"> -->
                                    <span class="meetquote_bx"><img src="<?php echo get_template_directory_uri(); ?>/newdepressionlanding/images/quote-right.png" alt="" class="img-fluid"></span>

                                </div>

                            </div>

                            <div class="col-lg-8 col-md-7 col-sm-12">

                                <div class="meetcntbx text-left">

                                    <h3 class="font-weight-bold"><?php the_title(); ?></h3>

                                    <p>
                                        <?php 
                                            remove_filter('get_the_excerpt', 'wp_trim_excerpt');
                                            if(get_the_excerpt()){
                                                $content = get_the_excerpt();
                                                $content_arr = explode(" ",$content);
                                                $idx=0;
                                                $new_content = array();
                                                foreach($content_arr as $c){
                                                    if($idx<42){
                                                        $new_content[] = $c;
                                                        $idx++;
                                                    }
                                                }
                                                echo strip_tags(implode(" ",$new_content));
                                            }else{
                                                $content = get_the_content();
                                                $content_arr = explode(" ",$content);
                                                $idx=0;
                                                $new_content = array();
                                                foreach($content_arr as $c){
                                                    if($idx<42){
                                                        $new_content[] = $c;
                                                        $idx++;
                                                    }
                                                }
                                                echo strip_tags(implode(" ",$new_content));
                                            } 
                                        ?>
                                        
                                    </p>

                                    <a href="<?php the_permalink(); ?>" class="btn-main mt-2 mt-md-3 mt-lg-5">Discover More</a>

                                </div><!--meetcntbx-->

                            </div>

                        </div><!--row-->
                        <?php
                      endwhile;
                      }
                      wp_reset_query();
                      ?>
                    </div>

                </div><!--meeteam_slider_bx-->

            </div><!--container-->

        </section><!--meetteam_sec-->

        <section class="resourse_sec text-center" id="Resources">

            <div class="container">

                <h2 class="text-blue mb-3 mb-md-4 mb-lg-5">Brain Wellness Spa <strong>Resources</strong></h2>

                <div class="resource_slider">

                    <div class="resourceslidebxmain">

                        <div class="respourceslidimg"><img src="<?php echo get_template_directory_uri(); ?>/newdepressionlanding/images/resource_img1.png" alt="" class="img-fluid"></div>

                            <div class="resourceslidecnt">

                                <span class="txt-infotag">Blog</span>

                                <h4 class="text-blue font-weight-bold">I am a Teenage Child: Who Am I?</h4>

                                <p>Teenagers questioning who they are is common. But it becomes more complex when your child may...</p>

                                <a href="#." class="morebtn text-blue">Know More »</a>

                            </div>

                        

                    </div><!--resourceslidebxmain-->

                    <div class="resourceslidebxmain">

                        <div class="respourceslidimg"><img src="<?php echo get_template_directory_uri(); ?>/newdepressionlanding/images/resource_img2.png" alt=""></div>

                        <div class="resourceslidecnt">

                            <span class="txt-infotag">Tips</span>

                            <h4 class="text-blue font-weight-bold">Depression Control Tips</h4>

                            <ul class="resircetipslist">

                                <li>Lorem ipsum dolor</li>

                                <li>Lorem ipsum dolor</li>

                                <li>Lorem ipsum dolor</li>

                                <li>Lorem ipsum dolor</li>

                                <li>Lorem ipsum dolor</li>

                                <li>Lorem ipsum dolor</li>

                                <li>Lorem ipsum dolor</li>

                                <li>Lorem ipsum dolor</li>

                            </ul>

                        </div>

                    </div><!--resourceslidebxmain-->

                    <div class="resourceslidebxmain">

                        <div class="respourceslidimg"><img src="<?php echo get_template_directory_uri(); ?>/newdepressionlanding/images/resource_img3.png" alt="" class="img-fluid"></div>

                        <div class="resourceslidecnt">

                            <span class="txt-infotag">E-Book</span>

                            <h4 class="text-blue font-weight-bold">Break the Cycle of Anger & Frustration</h4>

                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris ultrices, enim et fermentum egestas...</p>

                            <a href="#." class="morebtn text-blue">Know More »</a>

                        </div>

                    </div><!--resourceslidebxmain-->

                    <div class="resourceslidebxmain">

                        <div class="respourceslidimg"><img src="<?php echo get_template_directory_uri(); ?>/newdepressionlanding/images/resource_img1.png" alt="" class="img-fluid"></div>

                            <div class="resourceslidecnt">

                                <span class="txt-infotag">Blog</span>

                                <h4 class="text-blue font-weight-bold">I am a Teenage Child: Who Am I?</h4>

                                <p>Teenagers questioning who they are is common. But it becomes more complex when your child may...</p>

                                <a href="#." class="morebtn text-blue">Know More »</a>

                            </div>

                        

                    </div><!--resourceslidebxmain-->

                </div><!--resource_slider-->

                <div class="resourcebtn"><a href="#." class="btn-main">View All</a></div>

            </div><!--container-->

        </section><!--resourse_sec-->

        <section class="faq_sec accordian-div brain-rightimg brain-bgimg brainrightopimg" id="FAQs" style="background: url('<?php echo get_template_directory_uri(); ?>/newdepressionlanding/images/bg_img.png') no-repeat">

            <div class="container">

                <h2 class="text-blue text-center mb-2 mb-md-3 mb-lg-5">Frequently <strong>Asked Questions</strong></h2>

                <div id="accordion" class="accordion faq_accordion">

                    <div class="row">
                        <?php
                          $type = 'faq';
                          $args=array(
                          'post_type' => $type,
                          'post_status' => 'publish',
                          'order' => 'asc'
                          );
                          $my_query = null;
                          $my_query = new WP_Query($args);
                          if( $my_query->have_posts() ) {
                            $f=1;
                          while ($my_query->have_posts()) : $my_query->the_post(); 
                          
                        ?>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-header" id="heading<?php echo $f; ?>">
                                     <button class="btn btn-link <?php if($f != 1){ ?> collapsed <?php } ?> font-18 font-medium p-0" data-toggle="collapse" data-target="#collapse<?php echo $f; ?>" aria-expanded="<?php if($f==1){ ?> true <?php }else{ ?> false <?php } ?>" aria-controls="collapse<?php echo $f; ?>">
                                    <?php echo get_the_title(); ?>
                                    </button>
                                </div>

                                <div id="collapse<?php echo $f; ?>" class="collapse <?php if($f==1){ ?> show <?php } ?>" aria-labelledby="heading<?php echo $f; ?>" data-parent="#accordion">

                                    <div class="card-body font-16 font-regular">
                                        <?php echo get_the_content(); ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <?php $f++;
                          endwhile;
                          }
                          wp_reset_query();
                        ?>
                    </div><!--row-->

                </div><!--faq_accordion-->

            </div><!--container-->

        </section><!--faq_sec-->

        <section class="onestsession_introductorysec">

            <div class="container">

                <div class="row">

                    <div class="col-lg-7 col-md-6 col-sm-12">

                        <div class="onesession_intocntsec">

                            <h2 class="text-blue"><?php echo get_field('first_session_title'); ?></h2>

                            <p><?php echo get_field('first_session_content'); ?></p>

                            <div class="onesession_autorsec mt-2 mt-md-3 mt-lg-4">

                                <div class="onesession_img">

                                    <img src="<?php echo get_field('first_session_image'); ?>" alt="" class="img-fluid">

                                </div>

                                <div class="onesession_cnt">

                                    <h4 class="m-0"><strong><?php echo get_field('first_session_sub_title'); ?></strong></h4>

                                    <p><?php echo get_field('first_session_sub_content'); ?></p>

                                </div>

                            </div><!--onesession_autorsec-->

                        </div><!--onesession_intocntsec-->

                    </div>

                    <div class="col-lg-5 col-md-6 col-sm-12">

                        <div class="introductory_sec">

                            <!-- <h3>INTRODUCTORY OFFER</h3>

                            <p>Try our introductory 'Experience Session' today,for just $99 (normally $220).</p> -->

                            <?php the_field('booking_form'); ?>

                            <!-- <form>

                              <div class="form-group">

                                <input type="text" class="form-control" placeholder="First Name*">

                              </div>

                              <div class="form-group">

                                <input type="text" class="form-control" placeholder="Emial*">

                              </div>

                              <div class="form-group">

                                <input type="text" class="form-control" placeholder="Phone*">

                              </div>

                               <button type="submit" class="btn btn-main mt-2 mt-md-3 mt-lg-4">Book Now - $99 First Session Special</button>

                            </form> -->

                        </div>

                    </div>

                </div>

            </div>

        </section><!--1stsession_introductorysec-->

        <section class="support_friendfamily_sec" id="ContactUs">

            <div class="container">

                <div class="row align-items-center">

                    <div class="col-lg-5 col-md-6 col-sm-12">

                        <div class="support_friendimg"><img src="<?php echo get_field('support_friend_image'); ?>" alt="" class="img-fluid"></div>

                    </div>

                    <div class="col-lg-7 col-md-6 col-sm-12">

                        <div class="supportfriendcnt">

                            <h2 class="text-blue"><?php echo get_field('support_friend_title'); ?></h2>

                            <p><?php echo get_field('support_friend_content'); ?></p>

                            <a href="<?php echo get_field('support_friend_button_url'); ?>" class="btn-main mt-2 mt-md-3 mt-lg-4"><?php echo get_field('support_friend_button_text'); ?></a>

                        </div>

                    </div>

                </div><!--row-->

            </div><!--container-->

        </section><!--support_friendfamily_sec-->

    </div><!--depression_landingnewpage-->

</div>
<!--scripts ends here-->

<?php echo do_shortcode('[global_popup]'); ?>
<?php  get_footer('depression'); ?>