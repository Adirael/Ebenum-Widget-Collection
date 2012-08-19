<?php

/*
**************************************************************************

Plugin Name:  Category Description Widget
Plugin URI:   
Description:  Shows the current category on your sidebar
Version:      1.0
Author:       Angel Alonso
Author URI:   http://www.ebenum.es/

**************************************************************************/

class category_description_widget extends WP_Widget {

	function category_description_widget() {
		// Instantiate the parent object
		parent::__construct( false, 'Category Description' );
	}

	function widget( $args, $instance ) {
		if(is_single() || is_category()){
			$category        = get_category_by_path(get_query_var('category_name'), false);
		} 
		
		if(!empty($category->description)){
			// Widget output
			$output = 	'<div class="widget">
							<h3>' . __('About') . ' ' . $category->name.'</h3>
							<hr />
							<p>
								'.nl2br($category->description).'
							</p>
						</div>';

			echo $output;
		}
	}
}

function category_description_widget_register_widgets() {
	register_widget( 'category_description_widget' );
}

add_action( 'widgets_init', 'category_description_widget_register_widgets' );
