<?php
/* Register Custom Post Type for Portfolio */
add_action('init', 'ddc_content_type');
function ddc_content_type() {
  $labels = array(
    'name' => __('Dynamic Content', 'ddc'),
    'singular_name' => __('List Content', 'ddc'),
    'add_new' => __('Add List', 'ddc'),
    'add_new_item' => __('Add List','ddc'),
    'edit_item' => __('Edit List','ddc'),
    'new_item' => __('New List','ddc'),
    'view_item' => __('View List','ddc'),
    'search_items' => __('Search List','ddc'),
    'not_found' =>  __('No list found','ddc'),
    'not_found_in_trash' => __('No list found in Trash','ddc'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'rewrite' => true,
    'query_var' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'show_in_nav_menus' => true,
    'menu_position' => 25,
    'rewrite' => array(
      'slug' => 'content_list',
      'with_front' => false,
    ),    
    'taxonomies' => array('content_organizer'),
    'supports' => array(
      'title'
    )
  );

  register_post_type('content_list',$args);
}


register_taxonomy("content_organizer", 
		array("content_list"), 
		array( "hierarchical" => true, 
			"label" => __("Organizer Lists",'ddc'), 
			"singular_label" => __("Organizer List",'ecobiz'), 
			"rewrite" => false,
			"query_var" => false
));  
                        
