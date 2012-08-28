<?php

/*
**************************************************************************

Plugin Name:  Category Current Posts Widget
Plugin URI:
Description:  Shows the posts inside a category on your sidebar
Version:      1.0
Author:       Angel Alonso
Author URI:   http://www.ebenum.es/

**************************************************************************/

class category_current_posts_widget extends WP_Widget {

	function category_current_posts_widget() {
		// Instantiate the parent object
		parent::__construct( false, 'Posts under current category' );
	}

	function widget( $args, $instance ) {
		if(is_single()){
			$category = get_category_by_path(get_query_var('category_name'), false);
		}

		if($category){
			// Widget output
			$category->term_id;
			$output = 	'<div class="widget">
							<h3>' . __('Otras casas de') . ' ' . $category->name.'</h3>
							<hr />
							<ul>';

			$posts_array = get_posts(array('category' => $category->term_id));

			foreach($posts_array as $post){
				$output .= '<li><a href="'.get_permalink($post->ID).'">'.$post->post_title.'</a></li>';
			}


			$output .=  '	</ul>
						</div>';


			echo $output;
		}
	}
}

function category_current_posts_widget_register_widgets() {
	register_widget( 'category_current_posts_widget' );
}

add_action( 'widgets_init', 'category_current_posts_widget_register_widgets' );
