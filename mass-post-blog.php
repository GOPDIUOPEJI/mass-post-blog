<?php
/**
* Plugin Name: Mass Post Blog Plugin
* Plugin URI: https://www.yourwebsiteurl.com/
* Description: This is the very first plugin I ever created.
* Version: 1.0
* Author: Your Name Here
* Author URI: http://yourwebsiteurl.com/
**/

include( plugin_dir_path( __FILE__ ) . 'class.MassPostBlog.php');


function add_scripts() {
	wp_register_script( 'script.js', plugin_dir_url( __FILE__ ) . 'adds/js/script.js', array('jquery'), '1.1', true );
	wp_enqueue_script( 'script.js' );
}
add_action( 'admin_enqueue_scripts', 'add_scripts' );

function add_menupage(){
	add_menu_page( 'Mass Post Plugin', 'Mass Post Plugin', 'edit_others_posts', 'mass-post-blog', 'interface_function', 'dashicons-admin-tools', 99 ); 
}

function interface_function() {
	$masspostblog = new MassPostBlog();
	$masspostblog->get_interface(get_plugin_data(__FILE__)['Name']);
}
add_action( 'admin_menu', 'add_menupage' );


function page_capability( $capability ) {
	return 'edit_others_posts';
}
add_filter( 'option_page_capability_'.'mass-post-blog', 'page_capability' );

/* ajax callback*/

function mass_post_blog_callback() {
	if(isset($_FILES["file"]) && $_FILES["file"]["type"] == "text/csv"){
		$tmpName = $_FILES['file']['tmp_name'];
		$csvarr = array_map('str_getcsv', file($tmpName));
		$masspostblog = new MassPostBlog();
		$response = $masspostblog->fill_blog($csvarr);
		echo json_encode($response);
	} else {
		echo json_encode(array('code' => 205));
	}
	

	wp_die(); // выход нужен для того, чтобы в ответе не было ничего лишнего, только то что возвращает функция
}

add_action( 'wp_ajax_mass_post_blog', 'mass_post_blog_callback' );




