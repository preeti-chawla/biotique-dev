(function($){

$(document).ready(function(){
	//alert($('.checkout').attr('href'));
	$('.checkout').click(function(e){
		e.preventDefault();
		var usercheck = $('#userCheck').val();
		if(usercheck == 'guest') {
			 $('#e-login2').click();
			return false;
		} else {
			window.location = $(this).attr('href');   
			return true;
		}
		
	});
});

})(jQuery);

