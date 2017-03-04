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

	$('#rating_show').barrating({
		theme: 'fontawesome-stars-o',
		initialRating: avgRate,
		readonly: true
	});
	
});

//document.getElementById('ratingForm').submit();