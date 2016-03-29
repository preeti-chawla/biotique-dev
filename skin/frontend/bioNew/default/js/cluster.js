;(function($){
	$(document).ready(function(){
		$('ul.socialTab li a').click(function(){
			var curr = $(this);
			var rel = $(curr).attr('class');
			
			$.ajax({
				type : "GET",
				url : "/gist/feed",
				data : {'type': rel},
				dataType : 'json',
				success: function(resp) {
					$('ul.socialTab li').removeClass('active');
					$(curr).parent().addClass('active');
					$('.socialTabContent h6').html(resp.title);
					$('.socialTabContent p').html(resp.desc);


				}
			});
			return false;
		});
		$('ul.socialTab li:first a').trigger('click');

	});
})(jQuery);