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
}
$carousel = new Carousel();

?>
