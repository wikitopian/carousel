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

		add_action( 'wp_enqueue_scripts', array( &$this, 'do_style' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'do_script' ) );

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
