$( document ).ready(function() {
	
	$(function() {
	  	$(".datepicker").datepicker({ dateFormat: 'yy-mm-dd' });
	});

	$(".btn-danger").click(function(){
		if (!confirm("Do you really want to delete?")){
			return false;
		}
	});

	var avgRate = $( "#avgRate" ).text();

	$('#portalbundle_rating_rate').barrating({
		theme: 'fontawesome-stars-o',
		initialRating: avgRate
	});
	
});

//document.getElementById('ratingForm').submit();