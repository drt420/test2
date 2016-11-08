$(function() {

	$('#dataTbl').dataTable();

	$('.modal-embedded').colorbox();

	$("#sbJoin").click(function(e) {
		e.preventDefault();
		
		document.location.href= '/users/join';
		
		return false;
	}); 
    
	$("#signup-form").validate({
	 errorClass: "alert alert-error",
	 submitHandler: function(form) {
	   $("#signup-form").ajaxSubmit({target: '#signup_output_div'});
	 }
	});
	
	
	var options = {target: '#comment_output'}; 
    
	$("#comment-form").validate({
	 errorClass: "alert alert-error",
	 submitHandler: function(form) {
	   $("#comment-form").ajaxSubmit(options);
	   var lastID = $(".user_comments > li:last").attr('data-lastID');
	   var movID = $("#movID").html();
	   $.post('/watchmovies/ajax_last_comment', {last : lastID, movie: movID}, function(data) {
	   		$('.user_comments').append(data);
	   		$("html,body").animate({scrollTop: $('.user_comments li:last').offset().top - 30});
	   });
	 }
	});
	
	$('.rate-external').click(function() {
		var mID = $(this).attr("data-lID");
		var feedback = $(this).attr("data-type");
		
		$.post('/watchmovies/rate_external_ajax', {linkID : mID, action: feedback}, function(data) {
			$(".rate-external-result-" + mID).html(data);
			
			var updateCount = data.indexOf('Thank');
			 
			if(updateCount != -1) {
				if(feedback != 'works') {
					$('.broken-' + mID).html(parseInt($('.broken-' + mID).html())+1);
					$('.broken-' + mID).hide('fast');
					$('.broken-' + mID).show('slow');
				}else{
					$('.works-' + mID).html(parseInt($('.works-' + mID).html())+1);
					$('.works-' + mID).hide('fast');
					$('.works-' + mID).show('slow');
				}
			}
			
		});
		
	});
	
	
	$('.submit-link').click(function() {
		$('.submit-link-div').toggle('slow');
	});
	
	$("#submit-link-form").ajaxForm({target:".submit-link-output"});
	
	$('.add-to-playlist').click(function() {
		$.get('/watchmovies/ajax_add_playlist/' + $("#movID").html(), function(data) {
			$('.addtors').html(data);
		});
	});
	
	$("#imdb_link").blur(function() {
		imdbLink = $(this).val();
		$("#imdb-error").html(" ");
		
		
		$("#imdb-load").show();
		$.post('/admin/imdb_fetch', {link : imdbLink}, function(data) {
			if(data.errorMsg !== undefined){
				$("#imdb-error").html(data.errorMsg);
			}
			
			if(data.description !== undefined){
				$("#description").val(data.description);
			}
			
			if(data.title !== undefined){
				$("#title").val(data.title);
			}
			
			if(data.actors !== undefined){
				
				var myactors = data.actors;
				
				var output = '';
				$.each(myactors, function(key, kvalue){
				     output += kvalue + ',';
				});
				
				console.log(output);
				$("#actors").val(output);
			}
			
			if(data.release_date !== undefined){
				$("#release_date").val(data.release_date);
			}
			
			if(data.runtime !== undefined){
				$("#runtime").val(data.runtime);
			}
			
			if(data.thumb !== undefined) {
				$("#thumb").val(data.thumb);
			}
			
			if(data.genres !== undefined){
				var mystr = data.genres;
				for (var i = 0; i < mystr.length; i++) {
				    var origGENRE = mystr[i];
				    $("#" + origGENRE.trim()).prop('checked', true);
				    //console.log(mystr[i] + "GENRE\n");
				    //Do something
				}
			}
			
			$("#imdb-load").hide();
			
			
		});
	});
	
	
	$("#sbaddmov").click(function() {
		$("html,body").animate({scrollTop: $('.ajax-movie-out').offset().top - 30});
		$(".ajax-movie-out").html('<img src="/img/ajax-loader.gif" /> Please wait, inserting movie to database');
	});
	
	$("#ajax-movie-add").ajaxForm({target:".ajax-movie-out"});
	

	//	Scrolled by user interaction
	$('#featured-carousel').carouFredSel({
		auto: false,
		prev: '#prev2',
		next: '#next2',
		pagination: false,
		mousewheel: false,
		swipe: {
			onMouse: false,
			onTouch: false
		}
	});
	
});