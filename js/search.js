/* JS File */

// Start Ready
$(document).ready(function() {  

	// Icon Click Focus
	$('div.icon').click(function(){
		$('input#search-live').focus();
	});

	// Live Search
	// On Search Submit and Get Results
	function search() {
		var query_value = $('input#search-live').val();
		$('b#search-string').text(query_value);
		if(query_value !== ''){
			$.ajax({
				type: "POST",
				url: "php/searchLive.php",
				data: { query: query_value },
				cache: false,
				success: function(html){
					$("#results").html(html);
				}
			});
		}return false;    
	};

	// $('input#search').live("keyup", function(e) {   deprecated
	$( "input#search-live" ).keyup(function() {
		// Set Timeout
		clearTimeout($.data(this, 'timer'));

		// Set Search String
		var search_string = $(this).val();

		// Do Search
		if (search_string == '') {
			$("#results").fadeOut();
			$('h4#results-text').fadeOut();
		}else{
			$("#results").fadeIn();
			$('h4#results-text').fadeIn();
			$(this).data('timer', setTimeout(search, 100));
		};
	});

});