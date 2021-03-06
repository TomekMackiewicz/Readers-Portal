
$(document).ready(function() {
	
	$(function() {
	  	$(".datepicker").datepicker({ dateFormat: 'yy-mm-dd' });
	  	//$(".datepicker").datepicker({ dateFormat: 'yy' });
	});

	$(".btn-danger").click(function(){
		if (!confirm("Do you really want to delete?")) {
			return false;
		}
	});

	var avgRate = $( "#avgRate" ).text();

	$('#portalbundle_rating_rate').barrating({
		theme: 'fontawesome-stars-o',
		initialRating: avgRate
	});

	$('#portalbundle_review_rate').barrating({
		theme: 'fontawesome-stars-o',
		initialRating: avgRate
	});

	$('.showRating').each(function() {
		$(this).barrating({
			theme: 'fontawesome-stars-o',
			initialRating: $(this).next().text(),
			readonly: true
		});
	});

	$('.showReaderRating').each(function() {
		$(this).barrating({
			theme: 'fontawesome-stars-o',
			initialRating: $(this).prev().text(),
			readonly: true
		});
	});

});
