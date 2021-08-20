jQuery(document).ready(function($){
	//Fixed-header
	if ($(window).width() > 1200) {

		$(window).bind("scroll resize",function() {    
			var scroll = $(window).scrollTop();
			
			if (scroll >= 400) {
				$(".main-header").addClass("pinned").css("transform","translateY(0)");
			} else if(scroll >= 300) {
				$(".main-header").css("transform","translateY(-100%)");
			} else {
				$(".main-header").removeClass("pinned").css("transform","translateY(0)");
			}
		});
	}

	
	$(window).on('scroll', function () {
		function headerFixed() {
			if ($(window).width() < 1199.98) {
				if ($(window).scrollTop() >= 10) {
					$('.main-header').addClass('bg-fixed');
				} else {
					$('.main-header').removeClass('bg-fixed');
				}
			}
		};
		headerFixed();
	});



    // MAIN-NAV
	if ($(window).width() > 1198.98) {
		$('.has-dropdown, .has-sub-dropdown').mouseenter(function(){ 
			var $this = $(this); 
	
				$this.addClass('is-opened')
	
		}).mouseleave(function(){
	
			var $this = $(this);
	
				$this.removeClass('is-opened')
	
		});   
	}
    
   
	$(".list-mv > .has-dropdown > a, .list-mv > .has-dropdown > .dropdown > .btn-back").click(function () { 
		if ($(".has-dropdown").hasClass('is-opened')) {

			$(".has-dropdown.is-opened").removeClass("is-opened");

		} else {

			$(".has-dropdown.is-opened").removeClass("is-opened");

			if ($(this)) {

				$(this).parent().addClass("is-opened");
			}
		}
	});

	$(".has-sub-dropdown > a, .has-sub-dropdown > .sub-dropdown > .btn-back > a").click(function () { 
		if ($(".has-sub-dropdown").hasClass('is-opened')) {

			$(".has-sub-dropdown.is-opened").removeClass("is-opened");

		} else {

			$(".has-sub-dropdown.is-opened").removeClass("is-opened");

			if ($(this)) {

				$(this).parent().addClass("is-opened");
			}
		}
	}); 

	$('.has-dropdown > a, .has-dropdown > .dropdown > .btn-back > a').click(function() {
		$(".has-dropdown").parent().toggleClass('moves-out');
	});

	$('.has-sub-dropdown > a, .has-sub-dropdown > .sub-dropdown > .btn-back > a').click(function() {
		$(".has-sub-dropdown").parent().toggleClass('moves-out');
	});



	// SIDE-NAV
	if ($(window).width() > 1198.98) {
		$('.list-sm > .sm-has-dropdown').mouseenter(function(){ 
			var $this = $(this); 
	
				$this.addClass('is-opened')
	
		}).mouseleave(function(){
	
			var $this = $(this);
	
				$this.removeClass('is-opened')
	
		});   
	}

	$(".list-sm > .sm-has-dropdown > a, .list-sm > .sm-has-dropdown > .dropdown li > .btn-back").click(function () { 
		if ($(".list-sm > li").hasClass('is-opened')) {

			$(".list-sm > li.is-opened").removeClass("is-opened");

		} else {

			$(".list-sm > li.is-opened").removeClass("is-opened");

			if ($(this)) {

				$(this).parent().addClass("is-opened");
			}
		}
	});

	$('.sm-has-dropdown > a, .sm-has-dropdown > .dropdown li > .btn-back').click(function() {
		$(".sm-has-dropdown").parent().toggleClass('moves-out');
	});






	//Landing-nav
    $('#bidang-toggle, .close-toggle-bidang').click(function() {
        bidangToggle();
    });

    function bidangToggle() {
		$('.float-bidang').toggleClass('is-opened');
		$('body').toggleClass('scroll-lock');
	}

	//MAIN-MENU
	if ($(window).width() < 991.98) {
		$('.is-toggle, .page-scroll').click(function() {
			isToggle();
		});

		function isToggle() {
			$('body').toggleClass('scroll-lock');
			$('.mh-center').toggleClass('is-opened');
		}
	}


    
    //BURGER-SIDEBAR-MENU
    $('.nav-toggle i, .close-toggle-sm').click(function() {
        navigationToggle();
    });

    function navigationToggle() {
		$('body').toggleClass('scroll-lock');
        $('.sidebar-menu').toggleClass('is-opened');
		$(".sm-has-dropdown.is-opened").removeClass("is-opened");
        $('.dropdown').removeClass('moves-out');
        $('.list-sm').removeClass('moves-out');
    }


	


	//SEARCH-NAV
	$('.search-toggle, .cancel-toggle').click(function() {
        searchToggle();
    });
	

    function searchToggle() {
		$('.search-wrap').toggleClass('is-opened');
        setTimeout (function(){
			if ($('.search-wrap').hasClass('is-opened')) {
				$('#search-box').focus();
			} else {
				$('#search-box').val('');
			}
		}, 300);
    }


	$(document).mouseup(function (e) {
		var var_burger = $(".nav-toggle i");//ubah ke class button nya
		if (!var_burger.is(e.target) && $('.sidebar-menu').hasClass('is-opened')&& ( !$(".sidebar-menu, .sidebar-menu *").is(e.target)) ) {
			navigationToggle();
		}
		

		var var_search = $(".search-toggle");//ubah ke class button nya
		if (!var_search.is(e.target) && $('.nav-search').hasClass('is-opened')&& ( !$(".nav-search, .nav-search *").is(e.target)) ) {
			searchToggle();
		}
		
		var var_is = $(".is-toggle, .page-scroll");//ubah ke class button nya
		if (!var_is.is(e.target) && $('.mh-center').hasClass('is-opened')&& ( !$(".main-nav, .main-nav *").is(e.target)) ) {
			isToggle();
		}
		


	});
	
	
	
	//PARALAX BG
	$(window).scroll(function() {
		var pixs = $(window).scrollTop(),
			scale = (pixs / 16000) + 1,
			opacity = 1 - pixs / 750;
		$(".banner-breadcrumb > .thumb-img").css({
			"transform": "translate3d(0, "+pixs/4+"px, 0)",
			"opacity": opacity
		});
	});

	//BACK TOP
	var btn = $('#button-top');

	$(window).scroll(function() {
	  if ($(window).scrollTop() > 1000) {
		btn.addClass('show');
	  } else {
		btn.removeClass('show');
	  }
	});

	btn.on('click', function(e) {
	  e.preventDefault();
	  $('html, body').animate({scrollTop:0}, 1000, 'easeInOutExpo');
	});
	
	// GALLERY FOOTER
	$('.list-photo').lightGallery({
		selector: '.item-photo',
		counter: false,
	});

    
});



