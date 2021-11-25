jQuery(window).load(function () {
  // The slider being synced must be initialized first
  //dataSlide = jQuery('#slider').data('slide');
  // jQuery('#carousel').flexslider({
  //   animation: "slide",
  //   controlNav: false,
  //   animationLoop: false,
  //   slideshow: dataSlide,
  //   itemWidth: 200,
  //   asNavFor: '#slider'
  // });

  // jQuery('#slider').flexslider({
  //   animation: "slide",
  //   directionNav: false, 
  //   controlNav: false,
  //   animationLoop: false,
  //   slideshow: dataSlide,
  //   sync: "#carousel"
  // });

  jQuery('.woocommerce-form-register p:nth-child(1) input').attr('tabindex', '2');
  jQuery('.woocommerce-form-register p:nth-child(2) select').attr('tabindex', '5');
  jQuery('.woocommerce-form-register p:nth-child(3) input').attr('tabindex', '7');
  jQuery('.woocommerce-form-register p:nth-child(4) input').attr('tabindex', '3');

  jQuery('.woocommerce-form-register p:nth-child(5) input').attr('tabindex', '1');
  jQuery('.woocommerce-form-register p:nth-child(6) input').attr('tabindex', '4');
  jQuery('.woocommerce-form-register p:nth-child(7) input').attr('tabindex', '8');

  jQuery('.woocommerce-form-register p:nth-child(8) input').attr('tabindex', '9');

  jQuery('.flexslider').flexslider({
    animation: "slide",
    animationLoop: false,
    itemWidth: 250,
    itemMargin: 20,
    maxItems: 4,
    slideshow: false
  });
  jQuery('.flexslider2').flexslider({
    animation: "slide",
    animationLoop: false,
    itemWidth: 250,
    itemMargin: 20,
    maxItems: 4,
    slideshow: false
  });
  jQuery('.flexslider3').flexslider({
    animation: "slide",
    animationLoop: false,
    itemWidth: 340,
    itemMargin: 43,
    slideshow: false
  });

  jQuery(document).ready(function () {
    var width = jQuery(window).width();
    if (width >= 768) {
      jQuery('.aboutslider').flexslider({
        animation: "slide",
        controlNav: "thumbnails"
      });
    } else {
      jQuery('.aboutslider').flexslider({
        animation: "slide",
        animationLoop: false,
        itemWidth: 300,
        itemMargin: 25,
        maxItems: 4,
        slideshow: false
      });
    }
  });



  jQuery('.flexslider.carousel .flex-direction-nav').addClass('fix-flex');
  jQuery('.flexslider2.carousel .flex-direction-nav').addClass('fix-flex');
  jQuery('.flexslider3.carousel .flex-direction-nav').addClass('fix-flex');
  jQuery('#menu-brandtoys li').find('active').css("display", "none");

  var $menudropdown = jQuery('.product-category .main-nav ul.menu');
  var $current = jQuery('.current-menu-item.menu-item-has-children');
  var $filter = jQuery('.product-category ul.menu').find('.menu-item-has-children>.sub-menu');
  var $filter_submenu = $menudropdown.find('.menu-item-has-children .sub-menu .current-menu-item');
  $filter.hide();

  if ($current.length != 0) {
    $filter.show();
    $filter.find('li a').prepend('<i class="fas fa-caret-right"></i> ');
  }
  if ($filter_submenu.length != 0) {
    $filter.show();
    $filter.find('li a').prepend('<i class="fas fa-caret-right"></i> ');
  }

  // jQuery('.button-viewed-product span').click(function() {
  //   console.log("aaa");
  //   jQuery('.list-viewed-product').toggle(300);
  // });

  /*jQuery('.button-viewed-product span').click(function(){
    console.log("aaa");
      if(jQuery('div.list-viewed-product-inner').hasClass('hide')){
        jQuery('div.list-viewed-product').animate({left: 0},500,function(){
          jQuery('div.list-viewed-product-inner').removeClass('hide');  
        })
      }else{
        jQuery('div.list-viewed-product').animate({left: -300},500,function(){
          jQuery('div.list-viewed-product-inner').addClass('hide'); 
        })
      }
  })
  */



  jQuery(".woocommerce-EditAccountForm fieldset :input").each(function (index, elem) {
    var eId = jQuery(elem).attr("id");
    var label = null;
    if (eId && (label = jQuery(elem).parents("form").find("label[for=" + eId + "]")).length == 1) {
      jQuery(elem).attr("placeholder", jQuery(label).html());
      jQuery(label).remove();
    }
  });
  /*
  jQuery.validator.setDefaults({
    debug: true,
    success: "true"
  });
  jQuery( ".register" ).validate({
    rules: {
      input_box_1616744435: {
        required: true,
        number: true
      },
      user_pass: {
        required: true,
        minlength: 8
      },
      user_login: {
        required: true,
        minlength: 4
      },
      user_confirm_password: {
          required: true,
          minlength: 8,
          equalTo: "#user_pass"
      }
    }
  });
  */


});