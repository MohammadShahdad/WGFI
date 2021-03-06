$(document).ready(function(){


  //------------------------------------//
  //Navbar//
  //------------------------------------//
    	var menu = $('.navbar-scroll');
    	$(window).bind('scroll', function(e){
    		if($(window).scrollTop() > 140){
    			if(!menu.hasClass('open-nav')){
    				menu.addClass('open-nav');
    			}
    		}else{
    			if(menu.hasClass('open-nav')){
    				menu.removeClass('open-nav');
    			}
    		}
    	});


      $('.dropdown-anim').on('mouseenter.large', function () {
        $('.dropdown-menu', this).not('.in .dropdown-menu').stop( true, true ).slideDown("fast");
        $(this).toggleClass('open');
      }).on('mouseleave.large', function () {
        $('.dropdown-menu', this).not('.in .dropdown-menu').stop( true, true ).slideUp("fast");
        $(this).toggleClass('open');
      });


      $('.navbar-collapse').on('show.bs.collapse', function() {
        $(".navbar-3, .navbar-5").animate({height: "450px"}, "300");
      });
      $('.navbar-collapse').on('hide.bs.collapse', function() {
        $(".navbar-3, .navbar-5").animate({height: "60px"}, "300");
      });


  //------------------------------------//
  //Scroll To//
  //------------------------------------//
  $(".scroll").click(function(event){
  	event.preventDefault();
  	$('html,body').animate({scrollTop:$(this.hash).offset().top}, 800);

  });

  //------------------------------------//
  //Wow Animation//
  //------------------------------------//
  wow = new WOW(
        {
          boxClass:     'wow',      // animated element css class (default is wow)
          animateClass: 'animated', // animation css class (default is animated)
          offset:       0,          // distance to the element when triggering the animation (default is 0)
          mobile:       true        // trigger animations on mobile devices (true is default)
        }
      );
      wow.init();

  //------------------------------------//
  //Carousel//
  //------------------------------------//

          $('#myCarousel').carousel({
              interval: 5000
          })
          $('.fdi-Carousel .item').each(function () {
              var next = $(this).next();
              if (!next.length) {
                  next = $(this).siblings(':first');
              }
              next.children(':first-child').clone().appendTo($(this));

              if (next.next().length > 0) {
                  next.next().children(':first-child').clone().appendTo($(this));
              }
              else {
                  $(this).siblings(':first').children(':first-child').clone().appendTo($(this));
              }
          });
        });
