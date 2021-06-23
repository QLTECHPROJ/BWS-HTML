$(document).ready(function () {
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });
});

//   toggle

$("#sidebarCollapse").click(function(){
    $("#header").toggleClass("width-130");
    $("#content").toggleClass("width-130");
    $(".music-bar").toggleClass("width-130");
    $("footer").toggleClass("width-130");
  });
  

$('.list-unstyled.components li').on('click', function () {
    $('.list-unstyled.components li').removeClass('active');
    $(this).addClass('active');
});


// music

$("#close-playlist").on("click", function () {
    $(".playlist-div").toggleClass('d-block');
});

$(".play-1").on("click", function () {
    $(".music-bar").css("display", "block");
});
$(".play").on("click", function () {
    $(".music-bar").css("display", "block");
});

$(".cross").on("click", function () {
    $(".music-bar").css("display", "none");
});


$("#open-playlist").on("click", function () {
    $(".playlist-div").toggleClass('d-block');
});
$("#open-pl").on("click", function () {
    $(".playlist-div").toggleClass('d-block');
});
$("#plList").on("click", function () {
    $(".music-bar").css("display", "block");
});
 

$('input').focus(function () {
    $(this).parents('.form-group').addClass('focused');
});

$('input').blur(function () {
    var inputValue = $(this).val();
    if (inputValue == "") {
        $(this).removeClass('filled');
        $(this).parents('.form-group').removeClass('focused');
    } else {
        $(this).addClass('filled');
    }
})

// login & verify-otp

$(document).ready(function () {
    $(".mobile-input").focus(function () {
        $('.mobile-input').css("box-shadow", "0 2px 0 0 #fff");
        $('.mobile-input').css("transition", "all 0.5s");
        //return false;
    });
    $(".mobile-input").focusout(function () {
        $('.mobile-input').css("box-shadow", "0 1px 0 0 #e5e5e5");
    });

});

// signup


$(document).ready(function () {
    $(".mobile-input").focus(function () {
        $('.mobile-input.sign').css("box-shadow", "0 2px 0 0 #2a3042");
        $('.mobile-input.sign').css("transition", "all 0.5s");
        //return false;
    });
    $(".mobile-input").focusout(function () {
        $('.mobile-input.sign').css("box-shadow", "0 1px 0 0 #2a3042");
    });

});

// audio-filter 

$(".button-group").each(function (i, buttonGroup) {
    var $buttonGroup = $(buttonGroup);
    $buttonGroup.on("click", "button", function () {
        $buttonGroup.find(".is-checked").removeClass("is-checked");
        $(this).addClass("is-checked");
    });
});



// rate
$("label.full").click(function(){
    $(this).parent().find("label").css({"background-color": "#78e2fb"});
    $(this).css({"background-color": "orange"});
    $(this).nextAll().css({"background-color": "orange"});
  });
  $(".star label").click(function(){
    $(this).parent().find("label").css({"color": "#78e2fb"});
    $(this).css({"color": "orange"});
    $(this).nextAll().css({"color": "orange"});
    $(this).css({"background-color": "transparent"});
    $(this).nextAll().css({"background-color": "transparent"});
  });

//   favorite class change

$('.fa-heart-o').click(function() {
    $(this).toggleClass('fa-heart-o');
    $(this).addClass('fa-heart');
});

// toast msg

function showtoast() {
    var x = document.getElementById("favorite-msg");
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
  }

  
// notification details 

$("#more-best").click(function(){
    $(".more-menu.bell").toggleClass("showmenu");
});

$(".more-menu-item").click(function(){
      document.addEventListener('mousedown', hideMenu, false);
});
  
// corousal

