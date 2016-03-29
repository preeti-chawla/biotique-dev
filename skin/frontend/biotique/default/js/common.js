jQuery(document).ready(function($) {
	$('#flexslider1').flexslider({
		animation: "slide",
		controlNav: false
	});

  	var menuTimer;
	$('.menu li').hover(
	    function () {
			var t = this;
			menuTimer = setTimeout(function(){
				$('.dropwrap', t).stop(true, true).slideDown(600);
				$('.dropwrap', t).prev('a').addClass('hover');
			},300);
	    },
	    function () {
			clearTimeout(menuTimer);
	        $('.dropwrap', this).stop(true, true).slideUp(200);   
	        $('.dropwrap', this).prev('a').removeClass('hover');         
	});	

  	var carousel = $('#bestseller').carousel({
		itemWidth:185,
		itemHeight:250,
		distance:80,
		startIndex:'auto',
		enableMouseWheel:false,		
		selectedItemDistance:30
	});
	
  	$('.tabCont').hide();
    $('.tabCont:first').show();
    $('.tabs li:first').addClass('active');
      $('.tabs li a').click(function(){
      $('.tabs li').removeClass('active');
    $(this).parent().addClass('active');
    var currentTab = $(this).attr('href');
    $('.tabCont').hide();
    $(currentTab).show();
    return false;
    });

	$('#loginctn').click(function(){
		$(this).parents().find('.signupWrap').slideToggle();
		$(this).parents().find('.accountWrap').slideUp();
	});

	$('#account').click(function(){
		$(this).parents().find('.accountWrap').slideToggle();
		$(this).parents().find('.signupWrap').slideUp();		
	});

	$('#fa-search').click(function(){
		$(this).parents().find('.searchBlock').slideToggle();
		$(this).parents().find('.cartBlock').slideUp();
	});
	$('#faLock').click(function(){
		$(this).parents().find('.cartBlock').slideToggle();
		$(this).parents().find('.searchBlock').slideUp();
	});

	$('.cartCtn').click(function(){		
		$(this).parents().find('.cartBlock').slideUp();
	});

	
	$("#sl1img").click(function() {
		$.fancybox.open('../images/seller2.png');
	});
	$("#sl2img").click(function() {
		$.fancybox.open('../images/seller2.png');
	});
	$("#sl3img").click(function() {
		$.fancybox.open('../images/seller2.png');
	});
	$("#sl4img").click(function() {
		$.fancybox.open('../images/seller2.png');
	});
	$("#sl5img").click(function() {
		$.fancybox.open('../images/seller2.png');
	});
	$("#sl6img").click(function() {
		$.fancybox.open('../images/seller2.png');
	});

	$('#flexslider2').flexslider({
	    animation: "slide",
	    controlNav: false
	});
	  $('#flexslider3').flexslider({
	    animation: "slide",
	    controlNav: false
	  });

	var count = $(".social_icon_mid ul li");
	$(count[0]).addClass('active')
	var count_div = $(".social_content section")
	$(count_div[0]).css("display","block")
	$(".social_icon_mid ul li").click(function() {
		$(".social_icon_mid ul li").removeClass('active')
		var classname = $(this).attr('class');
		$(".social_content section").css("display","none")
		$("#"+classname).fadeIn();
		$(this).addClass('active')
	});
	$('#flexslider4').flexslider({
	    animation: "slide",
	    controlNav: false,
	    itemWidth: 160,
	    maxItems:3,
    	itemMargin: 3
	  });
	var slide = false;
	var height = $('.footerStripBottom').height();
	$('.downArrow').click(function() {
		var docHeight = $(document).height();
		var windowHeight = $(window).height();
		var scrollPos = docHeight - windowHeight + height;
		$('.footerStripBottom').animate({ height: "toggle"}, 1000);
		if(slide == false) {
			if($.browser.opera) {
				$('html').animate({scrollTop: scrollPos+'px'}, 1000);
			} else {
				$('html, body').animate({scrollTop: scrollPos+'px'}, 1000);
			}
			slide = true;
		} else {
			slide = false;
		}		
	});	

	$('.stripContent').hide();
    $('.stripContent:first').show();
    $('.stripLinks li:first').addClass('active');
      	$('.stripLinks li a').click(function(){
      	$('.stripLinks li').removeClass('active');
    	$(this).parent().addClass('active');
    	var currentTab = $(this).attr('href');
    	$('.stripContent').hide();
    	$(currentTab).show();
    	$('.footerStripBottom').animate({height: "show"}, 1000);
   		return false;
    });	
    $('.stylish-drop').sSelect();
    values=new Array();
	i=0;
	jQuery('input[type=text],input[type=email],textarea').each(function(){
		values[i]=jQuery(this).val();
		jQuery(this).attr('dval',i);
		i++;
	});
	jQuery('input[type=text],input[type=email],textarea').focus(function(){
		dval=jQuery(this).attr('dval');
		val=jQuery(this).val();
		if(val==values[dval])jQuery(this).val('');
	});
	jQuery('input[type=text],textarea').blur(function(){
		dval=jQuery(this).attr('dval');
		val=jQuery(this).val();
		if(val=='')jQuery(this).val(values[dval]);
	});
	
	
	if(jQuery().fancybox){
	 	$(".newsletter").fancybox({
	 	autoDimensions: false,
	     height:10,
	    width:500
	 	});
 }	
	
});