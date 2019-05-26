jQuery(function($){
	$('#CsvPosts').on('submit', function(e){

		e.preventDefault();
		var file_data = $(this).find('input[name="csv"]').prop('files')[0];   
	    var form_data = new FormData();

	    form_data.append('action', 'mass_post_blog');
	    form_data.append('file', file_data);


	    $.ajax({
		  type: "POST",
		  url: ajaxurl,
		  data: form_data,
		  contentType: false,
    	  processData: false,
    	  success: function(response){
    	  	console.log(response);
    	  },
		});

		// $.post( ajaxurl, form_data, function(response) {
		// 	console.log(response);
		// });
		return false;
	});
	
});