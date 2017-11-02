$("div.mod_article").mouseover(function() { 
	var el = this;

	if($(this).hasClass('active') == false) {
		$("div.mod_article").removeClass('active');
		$(this).addClass('active');

		$("[data-scroll]").each(function(i, element) {
			if($(element).data("scroll") == el.id) { 
				$("[data-scroll]").parent().removeClass("active"); 
				$(element).parent().addClass("active"); 
			}
		});
	}
});