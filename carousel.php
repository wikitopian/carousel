<?php
/*
Plugin Name: Image Carousel
Plugin URI: http://www.github.com/wikitopian/carousel
Description: Simple and generic image carousel
Version: 0.1.0
Author: @wikitopian
Author URI: http://www.github.com/wikitopian
License: GPLv2
 */

class Carousel {
	public static $PREFIX = 'carousel';
	private $options;

	public function __construct() {
		add_action( 'init', array( &$this, 'set_options' ) );
		add_action( 'init', array( &$this, 'do_image_register' ) );

		add_action( 'wp_enqueue_scripts', array( &$this, 'do_style' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'do_script' ) );

		add_shortcode( 'carousel', array( &$this, 'do_carousel' ) );

	}
	public function do_image_register() {

		$labels = array(
			'name'               => 'Carousel Images',
			'singular_name'      => 'Carousel Image',
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New Image',
			'edit_item'          => 'Edit Image',
			'new_item'           => 'New Image',
			'all_items'          => 'All Images',
			'view_item'          => 'View Images',
			'search_items'       => 'Search Images',
			'not_found'          => 'No images found',
			'not_found_in_trash' => 'No images found in Trash',
			'menu_name'          => 'Carousel Images',
		);

		$args = array(
			'labels'             => $labels,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => self::$PREFIX ),
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => 60,
			'supports'           => array(
				'title',
				'thumbnail',
			),
		);

		register_post_type( self::$PREFIX, $args );
	}
	public function set_options() {
		$defaults = array(
			'width'       => 749,
			'height'      => 310,
			'max'         => 10,
		);
		$this->options = get_option( self::$PREFIX, $defaults );
	}
	public static function do_style() {
		wp_enqueue_style(
			self::$PREFIX,
			plugins_url( 'css/carousel.css', __FILE__ )
		);
	}
	public static function do_script() {
		wp_enqueue_script(
			self::$PREFIX,
			plugins_url( 'js/carousel.js', __FILE__ ),
			'jquery',
			false,
			true
		);
	}
	public function do_carousel( $atts ) {
		extract(
			shortcode_atts(
				array(
					'width'  => $this->options['width'],
					'height' => $this->options['height'],
					'max'    => $this->options['max'],
				), $atts
			)
		);

		$images = $this->get_images( $width, $height, $max );

		$carousel = "\n" . '<div id="carousel" />' . "\n";

		foreach ( $images as $image ) {
			$carousel .= "\n";
			$carousel .= $image;
		}

		$carousel .= "\n" . '</div>' . "\n";

		return $carousel;
	}
	public function get_images( $width, $height, $max ) {

		$post_images = get_posts(
			array(
				'posts_per_page' => $max,
				'post_type'      => 'carousel',
			)
		);

		$images = array();
		foreach ( $post_images as $image_id => $image ) {
			$image_id  = get_post_thumbnail_id( $image->ID );
			$image_url = wp_get_attachment_image_src( $image_id, 'full' );

			$image_html  = " <img src='{$image_url[0]}' ";
			$image_html .= " width='{$width}' height='{$height}' ";
			$image_html .= ' /> ';

			$images[] = $image_html;
		}

		return $images;
	}
}
$carousel = new Carousel();

?>
