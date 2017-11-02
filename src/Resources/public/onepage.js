$("[data-scroll]").click(function(event) { 
	event.preventDefault(); 
	$("[data-scroll]").parent().removeClass("active"); 
	$(window).scrollTo($("#" + $(this).data("scroll")).position().top, 800); 
	$(this).parent().addClass("active"); 
	document.location.hash = $(this).data("scroll");
});

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