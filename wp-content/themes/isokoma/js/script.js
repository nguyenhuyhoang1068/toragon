/*
jQuery('iframe[src*="https://www.youtube.com/embed/"]').addClass("youtube-iframe");
jQuery(".carousel-control-next").click(function() {
  // changes the iframe src to prevent playback or stop the video playback in our case
  jQuery('.mobile .youtube-iframe').each(function(index) {
    jQuery(this).attr('src', jQuery(this).attr('src'));
    return false;
  });
  jQuery('.deskstop .youtube-iframe').each(function(index) {
    jQuery(this).attr('src', jQuery(this).attr('src'));
    return false;
  });

});


jQuery(".carousel-control-prev").click(function() {
  // changes the iframe src to prevent playback or stop the video playback in our case
  jQuery('.mobile .youtube-iframe').each(function(index) {
    jQuery(this).attr('src', jQuery(this).attr('src'));
    return false;
  });
  jQuery('.deskstop .youtube-iframe').each(function(index) {
    jQuery(this).attr('src', jQuery(this).attr('src'));
    return false;
  });

});
*/

jQuery(".carousel-indicators li").click(function() {
  // changes the iframe src to prevent playback or stop the video playback in our case
  jQuery('.mobile .youtube-iframe').each(function(index) {
    jQuery(this).attr('src', jQuery(this).attr('src'));
    return false;
  });
  jQuery('.deskstop .youtube-iframe').each(function(index) {
    jQuery(this).attr('src', jQuery(this).attr('src'));
    return false;
  });

});
jQuery(".carousel-control-prev").click(function(event){  
  jQuery('video').trigger('play');
  jQuery('video').trigger('pause');
});
jQuery(".carousel-control-next").click(function(event){  
  jQuery('video').trigger('play');
  jQuery('video').trigger('pause');
});
jQuery('.carousel-indicators li').click(function (e) { 
  e.preventDefault();  
  jQuery('video').trigger('play');
  jQuery('video').trigger('pause');
});

/*

jQuery('.carousel-control-next').click(function (e) { 
  e.preventDefault();
  
  var player;
  player = new YT.Player('player');
  player.stopVideo();  
});

jQuery('.carousel-control-prev').click(function (e) { 
  e.preventDefault();
  var player;
  player = new YT.Player('player');
  // var videoURL = $('#player').prop('src');
  // videoURL += "&autoplay=1";
  // $('#player').prop('src',videoURL);  
  var videoURL = jQuery('#player').prop('src');
  videoURL = videoURL.replace("&autoplay=1", "");
  jQuery('#player').prop('src','');
  jQuery('#player').prop('src',videoURL);
});


jQuery('.carousel-indicators li').click(function (e) { 
  e.preventDefault();
  var player;
  player = new YT.Player('player');
  // var videoURL = $('#player').prop('src');
  // videoURL += "&autoplay=1";
  // $('#player').prop('src',videoURL);  
  var videoURL = jQuery('#player').prop('src');
  videoURL = videoURL.replace("&autoplay=1", "");
  jQuery('#player').prop('src','');
  jQuery('#player').prop('src',videoURL);
});
*/

//
//jQuery(document).on('click', '.play-icon', function(e) { 
  //jQuery("video.banner-video").trigger('play').css("z-index","5");
  //jQuery(this).hide();
//});
//

//var width = $(window).width();
//    if (width >= 768) {
      //code for mobile devices
//    }
var video = jQuery('video.banner-video').get(0);
jQuery(document).on('click', '.play-icon', function() { 
  jQuery("video.banner-video").trigger('play').css("z-index","5");
  jQuery(this).hide();
  
});

jQuery(document).ready(function(){
  jQuery('video.banner-video').on('click',function(){
      if(video.play){
        jQuery('.play-icon').css("z-index","6").show();
      }
      if(video.paused){
        jQuery('.play-icon').css("z-index","4").hide();
      }
  });
});

jQuery(document).ready(function(){
  jQuery('.carousel-control-next,.carousel-control-prev,.carousel-indicators li').on('click',function(){
      if(video.play){
        jQuery('.play-icon').css("z-index","4").hide();
      }
      if(video.paused){
        jQuery('.play-icon').css("z-index","6").show();
      }
  });
  
});

jQuery(document).ready(function(){
  var width = jQuery(window).width();
   if (width < 768) {
    jQuery( ".home form.search" ).prependTo( jQuery( "#collapsible_navbar" ) );
    //jQuery( "#header_info .dropdown.language" ).appendTo( jQuery( "#collapsible_navbar" ) );

   }
  
});

/**Menu Dropdown */
const $dropdown = jQuery(".dropdown");
const $dropdownToggle = jQuery(".dropdown-toggle");
const $dropdownMenu = jQuery(".dropdown-menu");
const showClass = "show";
jQuery(window).on("load resize", function () {
  if (this.matchMedia('(pointer:fine)').matches) {
    $dropdown.hover(function () {
      const $this = jQuery(this);
      $this.addClass(showClass);
      $this.find($dropdownToggle).attr("aria-expanded", "true");
      $this.find($dropdownMenu).addClass(showClass);
    }, function () {
      const $this = jQuery(this);
      $this.removeClass(showClass);
      $this.find($dropdownToggle).attr("aria-expanded", "false");
      $this.find($dropdownMenu).removeClass(showClass);
    });
  } else {
    $dropdown.off("mouseenter mouseleave");
  }

});

