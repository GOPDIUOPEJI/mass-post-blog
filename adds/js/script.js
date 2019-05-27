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
    	  	response = jQuery.parseJSON(response);
    	  	console.log(response.code);
    	  	if(response.code == 205){
    	  		$('#CsvPosts p.error').text("Error: Bad file type!");
    	  	}
    	  	if(response.code == 204){
    	  		$('#CsvPosts p.error').text("Error: Wrong file structure (some of important headers are not exists)!");
    	  	}
    	  	if(response.code == 203){
    	  		var bad_posts = response.bad_posts.split(", ");
    	  		bad_posts = bad_posts.map(function(n){return Number(n) + 2;})
    	  		var err_msg = "Error: posts in rows " + bad_posts.join(", ") + " was not added!";
    	  		$('#CsvPosts p.error').text(err_msg);
    	  	}
    	  	if(response.code == 200){
    	  		$('#CsvPosts p.error').text("All posts was created!");
    	  	}
    	  },
		});

		return false;
	});
	
});