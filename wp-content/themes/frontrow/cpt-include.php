<?php
function RegisterCPT() {

	// Press Room
	$cpt2Labels = array(
		'name' => _x('Press Room', 'post type general name'),
		'singular_name' => _x('Press Room Item', 'post type singular name'),
		'add_new' => __('Add New Press Room Item'),
		'add_new_item' => __('Add New Press Room Item'),
		'edit_item' => __('Edit Press Room Item'),
		'new_item' => __('New Press Room Item'),
		'view_item' => __('View Press Room Item'),
		'search_items' => __('Search Press Room Items'),
		'not_found' =>  __('No Press Room Items found'),
		'not_found_in_trash' => __('No Press Room Items found in trash')
	);
	  
	$args2 = array(
		'labels' => $cpt2Labels,
		'singular_label' => __('Press Room Item'),
		'public' => true,
		'show_ui' => true,
		'capability_type' => 'post',
		'hierarchical' => true,
		'rewrite' => true,
		'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields','page-attributes'),
		'rewrite' => array(
			'slug' => 'press-room',
			'with_front' => FALSE
		  )
	);

	register_post_type( 'press-room' , $args2 );

}
add_action('init', 'RegisterCPT');