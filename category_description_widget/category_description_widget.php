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
							<h3>' . __('Sobre') . ' ' . $category->name.'</h3>
							<hr />
							<p>
								'.auto_link_text(nl2br($category->description)).'
							</p>
						</div>';

			echo $output;
		}
	}
}

/**
 * Replace links in text with html links
 *
 * @param  string $text
 * @return string
 */
function auto_link_text($text) {
	// Pattern from http://daringfireball.net/2010/07/improved_regex_for_matching_urls
   $pattern  = "#(?i)\b((?:[a-z][\w-]+:(?:/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'\".,<>?«»“”‘’]))#";
   $callback = create_function('$matches', '
       $url       = array_shift($matches);
       $url_parts = parse_url($url);

       $text = parse_url($url, PHP_URL_HOST) . parse_url($url, PHP_URL_PATH);
       $text = preg_replace("/^www./", "", $text);

       $last = -(strlen(strrchr($text, "/"))) + 1;
       if ($last < 0) {
           $text = substr($text, 0, $last) . "&hellip;";
       }

       return sprintf(\'<a href="%s">%s</a>\', $url, $text);
   ');

   return preg_replace_callback($pattern, $callback, $text);
}

function category_description_widget_register_widgets() {
	register_widget( 'category_description_widget' );
}

add_action( 'widgets_init', 'category_description_widget_register_widgets' );
