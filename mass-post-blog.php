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

add_action( 'admin_menu', 'add_menupage' );
add_filter( 'option_page_capability_'.'mass-post-blog', 'page_capability' );

// Добавим видимость пункта меню для Редакторов
function add_menupage(){
	add_menu_page( 'Mass Post Plugin', 'Mass Post Plugin', 'edit_others_posts', 'mass-post-blog', 'interface_function', 'dashicons-admin-tools', 99 ); 
}

// Изменим права
function page_capability( $capability ) {
	return 'edit_others_posts';
}

function interface_function() {
	$masspoblog = new MassPostBlog();
	$masspoblog->get_interface(get_plugin_data(__FILE__)['Name']);
}
