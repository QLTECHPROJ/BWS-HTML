<footer >

  <div class="footer_main" style="background-image:url('https://brainwellnessspa.com.au/wp-content/uploads/2021/06/footer-bg-new.jpg') ;background-position: center top;background-repeat: no-repeat;background-size: cover;">

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

  <div class="footer_bottom">
    <div class="container">
          <p><?php echo get_field('footer_note','option');?></p>
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
  </div><!--footer_bottom-->
<?php // wp_footer(); ?>
</footer>



<script src="https://brainwellnessspa.com.au/wp-content/themes/brainwellnessspa/newdepressionlanding/js/bootstrap.min.js"></script>

<script src="https://brainwellnessspa.com.au/wp-content/themes/brainwellnessspa/newdepressionlanding/js/slick.js"></script>

 <!-- <script src="https://brainwellnessspa.com.au/wp-content/themes/brainwellnessspa/newdepressionlanding/js/jquery.min.js"></script> -->

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
    $('header').addClass('sticky');
  }

  else{
    $('header').removeClass('sticky');
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



$this.html('<iframe src="https://www.youtube.com/embed/xfBrxZZUMHs?rel=0&showinfo=0&autoplay=1' + $this.data("video") + '?autoplay=1"></iframe>');

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

<script type='text/javascript' src='https://brainwellnessspa.com.au/wp-content/plugins/gravityforms/js/jquery.json.min.js?ver=2.4.23'></script>
<script type='text/javascript'>
/* <![CDATA[ */
var gf_global = {"gf_currency_config":{"name":"Australian Dollar","symbol_left":"$","symbol_right":"","symbol_padding":" ","thousand_separator":",","decimal_separator":".","decimals":2},"base_url":"https:\/\/brainwellnessspa.com.au\/wp-content\/plugins\/gravityforms","number_formats":[],"spinnerUrl":"https:\/\/brainwellnessspa.com.au\/wp-content\/plugins\/gravityforms\/images\/spinner.gif"};
/* ]]> */
</script>
<script type='text/javascript' src='https://brainwellnessspa.com.au/wp-content/plugins/gravityforms/js/gravityforms.min.js?ver=2.4.23'></script>
<script src='https://brainwellnessspa.com.au/wp-content/plugins/gravityforms/js/placeholders.jquery.min.js?ver=2.4.22'></script>
<script src='https://brainwellnessspa.com.au/wp-content/plugins/gravityforms/js/conditional_logic.js?ver=2.4.22'></script>
<script>
jQuery(function(s) {
    function e() {
        for (var e = document.querySelectorAll(".youtube"), t = 0; t < e.length; t++) ! function(a) {
                var n, o, e;
                "vimeo" === a.dataset.vidhost ? ((n = new XMLHttpRequest).open("GET", "https://vimeo.com/api/v2/video/" + a.dataset.embed + ".xml", !0), n.onreadystatechange = function() {
                    var e, t;
                    4 == n.readyState && 200 == n.status && (e = n.responseXML, o = e.getElementsByTagName("thumbnail_large")[0].innerHTML, (t = new Image).src = o, t.style.top = "0%", t.addEventListener("load", function() {
                        a.appendChild(t)
                    }))
                }, n.send(null)) : (o = "https://img.youtube.com/vi/" + a.dataset.embed + "/hq720.jpg", (e = new Image).src = o, e.addEventListener("load", function() {
                    a.appendChild(e)
                }))
            }(e[t]),
            function(e) {
                var t = "vimeo" === e.dataset.vidhost ? "https://player.vimeo.com/video/" + e.dataset.embed + "?autoplay=1" : "https://www.youtube.com/embed/" + e.dataset.embed + "?rel=0&showinfo=0&autoplay=1";
                e.addEventListener("click", function() {
                    var e = document.createElement("iframe");
                    e.setAttribute("frameborder", "0"), e.setAttribute("allowfullscreen", ""), e.setAttribute("src", t), this.innerHTML = "", this.appendChild(e)
                })
            }(e[t])
    }
    s(".is-dropdown-submenu li a").on("click touchend", function(e) {
        var t = s(this).attr("href");
        window.location = t
    }), s(".archive-grid .columns").last().addClass("end"), s("body").addClass("loaded"), s(".scroll").click(function() {
        return s("html,body").animate({
            scrollTop: s("#featured-panel").offset().top
        }, "4000"), !1
    }), 
    $(".close-modal-link").click(function() {
         $("div.youtube").remove("iframe"), $(".youtube iframe").remove()
    }), 
    s(function() {
        var e = s(".split-list"),
            l = "sub-list";
        e.each(function() {
            for (var e = new Array, t = s(this).find("li"), a = Math.floor(t.length / 3), n = t.length - 3 * a, o = 0; o < 3; o++) e[o] = o < n ? a + 1 : a;
            for (o = 0; o < 3; o++) {
                s(this).append(s("<ul ></ul>").addClass(l));
                for (var i = 0; i < e[o]; i++) {
                    for (var d = 0, r = 0; r < o; r++) d += e[r];
                    s(this).find("." + l).last().append(t[i + d])
                }
            }
        })
    }), window.onload = function() {
        e()
    };
    var t = 1;
    s(".line").each(function() {
        var e = s(this).parent().parent().height();
        t < 10 ? s(this).height(e + 150) : s(this).height(e), t++
    }), s(window).resize(function() {
        s(".timeline .grid-x").each(function() {
            var e = s(window).width(),
                t = s(this).find("div.has-background");
            e < 600 ? t.addClass("small-order-2") : t.removeClass("small-order-2")
        })
    })
});
$(document).ready(function() {
 $('.dropdown-menu a.dropdown-toggle').on('click', function(e) {
  //alert('hi');
    if (!$(this).next().hasClass('show')) {
      $(this).parents('.dropdown-menu').first().find('.show').removeClass('show');
    }
    var $subMenu = $(this).next('.dropdown-menu');
    $subMenu.toggleClass('show');


    $(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
      $('.dropdown-submenu .show').removeClass('show');
    });


    return false;
  });

});
</script>
</div>

<!--scripts ends here-->

</body>

</html>