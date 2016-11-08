// JavaScript Document
	$(function() {
		$("#current-rating").html("mata");
		$("#current-rating").show();
		// get current rating
		getRating();
		// get rating function
		function getRating(){
			$.ajax({
				type: "GET",
				url: "/watchmovies/rating/do/getrate/movID/" + $("#movID").html(),
				cache: false,
				async: false,
				success: function(result) {
					// apply star rating to element
					$("#current-rating").css({ width: "" + result + "%" });
				},
				error: function(result) {
					alert("some error occured, please try again later" + result);
				}
			});
		}
		
		// link handler
		$('#ratelinks li a').click(function(){
			$.ajax({
				type: "GET",
				url: "/watchmovies/rating/do/rate/movID/" + $("#movID").html() + "/rating/" + $(this).text(),
				cache: false,
				async: false,
				success: function(result) {
					// remove #ratelinks element to prevent another rate
					$("#ratelinks").remove();
					$("#rate-result").html(result);
					// get rating after click
					getRating();
				},
				error: function(result) {
					alert("some error occured, please try again later");
				}
			});
			
		});
	});
