<?php
class MassPostBlog {

	public function get_interface($plugin_name){
		$args['plugin_name'] = $plugin_name;
		include( plugin_dir_path( __FILE__ ) . 'views/interface.php');
	}

	public function fill_blog($args) {
		if($this->is_file_correct($args[0])){
			foreach ($args as $key => $value) {
				if ($k == 0){
					return;
				}
				create_post($args[$key]['post_name'], $args[$key]['post_content'], $args[$key]['post_categories'],
				 $args[$i]['post_date']);
			}
			return true;
		} else {
			return "Wrong file structure!";
		}
	}

	public function is_file_correct($arr) {
		if(!in_array('post_name', $arr) || !in_array('post_content', $arr) || 
			!in_array('post_categories', $arr) || !in_array('post_date', $arr)){
			return false;
		}else {
			return true;
		}
	}

	private function create_post($post_name, $post_content, $post_categories, $post_date){
		$categories = $this->get_post_categories($post_categories);
		$post_data = array(
			'post_title'    => wp_strip_all_tags( $post_name ),
			'post_content'  => $post_content,
			'post_status'   => 'publish',
			'post_author'   => 1,
			'post_category' => count($categories) > 3 ? array_slice($categories, 0, 3) : $categories,
			'post_date'     => check_post_date($post_date),
		);

		// Вставляем запись в базу данных
		$post_id = wp_insert_post( $post_data ); 
		return $post_id;
	}

	private function get_post_categories($a_categories) {
		$categories = array();
		foreach ($a_categories as $key => $value) {
			if(get_category_by_slug($value)){
				array_push($categories, get_category_by_slug($value)->cat_ID);
			}
		}
		return $categories;
	}

	private function check_post_date($date) {
		$d = explode(',', $date)[0];
		$m = explode(',', $date)[1];
		$y = explode(',', $date)[2];
		if(wp_checkdate($m, $d, $y, $date)) {
			return wp_checkdate($m, $d, $y, $date);
		} else {
			return current_time();
		}
	}

}