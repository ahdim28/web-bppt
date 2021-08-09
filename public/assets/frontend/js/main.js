jQuery(document).ready(function($){
	//Fixed-header
	if ($(window).width() > 1200) {

		$(window).bind("scroll resize",function() {    
			var scroll = $(window).scrollTop();
			
			if (scroll >= 600) {
				$(".main-header").addClass("pinned").css("transform","translateY(0)");
			} else if(scroll >= 300) {
				$(".main-header").css("transform","translateY(-100%)");
			} else {
				$(".main-header").removeClass("pinned").css("transform","translateY(0)");
			}
		});
	}


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



	//Landing-nav
    $('#bidang-toggle, .close-toggle-bidang').click(function() {
        ctToggle();
    });

    function ctToggle() {
		$('.float-bidang').toggleClass('is-opened');
		$('body').toggleClass('scroll-lock');
	}


    
    //BURGER-MENU
    $('.nav-toggle i, .close-toggle').click(function() {
        navigationToggle();
    });

    function navigationToggle() {
		$('body').toggleClass('scroll-lock');
        $('.mh-center').toggleClass('is-opened');
		$(".has-dropdown.is-opened").removeClass("is-opened");
		$(".has-sub-dropdown.is-opened").removeClass("is-opened");
        $('.dropdown').removeClass('moves-out');
        $('.list-mv').removeClass('moves-out');
    }
	


	//SEARCH-NAV
	$('.search-toggle').click(function() {
        searchToggle();
    });
	

    function searchToggle() {
		$('.nav-search').toggleClass('is-opened');
		$('.bottom-header').toggleClass('search-is-opened');
        setTimeout (function(){
			if ($('.nav-search').hasClass('is-opened')) {
				$('#search-header').focus();
			} else {
				$('#search-header').val('');
			}
		}, 300);
    }


	$(document).mouseup(function (e) {
		var var_burger = $(".nav-toggle i");//ubah ke class button nya
		if (!var_burger.is(e.target) && $('.mh-center').hasClass('is-opened')&& ( !$(".main-nav, .main-nav *, .switcher, .switcher *").is(e.target)) ) {
			navigationToggle();
		}
		
		

		var var_search = $(".search-toggle");//ubah ke class button nya
		if (!var_search.is(e.target) && $('.nav-search').hasClass('is-opened')&& ( !$(".nav-search, .nav-search *").is(e.target)) ) {
			searchToggle();
		}
		
		var var_account = $(".ct-toggle");//ubah ke class button nya
		if (!var_account.is(e.target) && $('.th-right').hasClass('is-opened')&& ( !$(".th-ctbox, .th-ctbox *").is(e.target)) ) {
			ctToggle();
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



