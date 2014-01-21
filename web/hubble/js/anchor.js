/*******

	***	Anchor Slider by Cedric Dugas   ***
	*** Http://www.position-absolute.com ***
	
	You can use and modify this script for any project you want, but please leave this comment as credit.
	
	Never have an anchor jumping your content, slide it.
	
	Just add the class anchor at your <a> tag and it will slide, user with no javascript will 
	still go to destination with the normal html anchor

	Don't forget to put an id to your anchor !
	
*****/
		
$(document).ready(function() {
	anchor.init()
});

anchor = {
	init : function()  {
		$("a.anchorLink").click(function () {	
			elementClick = $(this).attr("href")
			destination = $(elementClick).offset().top;
			$("html:not(:animated),body:not(:animated)").animate({ scrollTop: destination}, 1100 );
		  	return false;
		})
	}
}