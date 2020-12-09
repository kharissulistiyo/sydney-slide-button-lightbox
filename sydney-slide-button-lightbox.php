<?php
/**
 * Sydney Slide Button Lightbox
 *
 * @package     Sydney Slide Button Lightbox
 * @author      kharisblank
 * @copyright   2020 kharisblank
 * @license     GPL-2.0+
 *
 * @sy-slide-button-lightbox
 * Plugin Name: Sydney Slide Button Lightbox
 * Plugin URI:  https://easyfixwp.com/
 * Description: Enable lightbox button on the main slider button of Sydney WordPress theme.
 * Version:     0.0.6
 * Author:      kharisblank
 * Author URI:  https://easyfixwp.com
 * Text Domain: sy-slide-button-lightbox
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 */

// Disallow direct access to file
defined( 'ABSPATH' ) or die( __('Not Authorized!', 'sy-slide-button-lightbox') );

define( 'SY_SLIDE_BUTTON_LIGHTBOX_FILE', __FILE__ );
define( 'SY_SLIDE_BUTTON_LIGHTBOX_URL', plugins_url( null, SY_SLIDE_BUTTON_LIGHTBOX_FILE ) );

if ( !class_exists('SY_Slide_Button_Lightbox') ) :
 class SY_Slide_Button_Lightbox {

   public function __construct() {

     add_action( 'wp_enqueue_scripts', array($this, 'enqueue_scripts'), 9999 );
     add_shortcode( 'SydneyVideoButton', array($this, 'button_shortcode') );

   }

   /**
    * Check whether Sydney theme is active or not
    * @return boolean true if either Sydney or Sydney Pro is active
    */
   function is_sydney_active() {

     $theme  = wp_get_theme();
     $parent = wp_get_theme()->parent();

     if ( ($theme != 'Sydney' ) && ($theme != 'Sydney Pro' ) && ($parent != 'Sydney') && ($parent != 'Sydney Pro') ) {
       return false;
     }

     return true;

   }

   /**
    * Button HTML
    * @param  string $text     Button text
    * @param  string $url      Button URL = Video URL
    * @param  string $nonSlide Use 'yes' if it is used in non main slide. The only accepted value is 'yes'.
    * @return string
    */
   function button_html($text, $url, $nonSlide) {

     $slide_btn_class = '';

     if( ('' == $nonSlide) || empty($nonSlide) || ('yes' != $nonSlide) ) {
       $slide_btn_class = 'button-slider';
     }

     if( ('' != $nonSlide) && 'yes' ) {
       $slide_btn_class = '';
     }

     if( false == $this->is_sydney_active() ) {
       $sydney_video_lightbox_button = 'sydney-video-lightbox-button';
     } else {
       $sydney_video_lightbox_button = '';
     }

     $css_class = array();
     $css_class[] = 'roll-button';
     $css_class[] = $slide_btn_class;
     $css_class[] = $sydney_video_lightbox_button;

     $btn_class = implode(" ", apply_filters( 'sydney_video_lightbox_button_css_class', $css_class ));

     $btn_args = array(
       'btn-class' => $btn_class,
       'url'       => $url,
       'text'      => $text,
       'nonSlide'  => $nonSlide,
     );

     $btn_html = apply_filters( 'sydney_video_lightbox_button_html', '<a class="'.$btn_args['btn-class'].'" href="'.esc_url($btn_args['url']).'" data-lity>'.esc_html($btn_args['text']).'</a>', $btn_args );

     return $btn_html;

   }

   /**
    * Button shortcode definition
    * @param  array $atts Shortcode params
    * @return string
    */
   function button_shortcode( $atts ) {

     $atts = shortcode_atts( array(
         'url'           => '',
         'text'          => '',
         'non-slide'     => '', // The only accepted value is: yes
     ), $atts, 'SydneyVideoButton' );

     $url        = $atts['url'];
     $text       = $atts['text'];
     $nonSlide   = $atts['non-slide'];

     return $this->button_html($text, $url, $nonSlide);

   }

   /**
    * Enqueue plugin scripts
    * @return void
    */
   function enqueue_scripts() {

     $text = get_theme_mod('slider_button_text','Click to begin');
     $url  = get_theme_mod('slider_button_url','#primary');

     $slide_button = array(
       'btn_text' => $text,
       'btn_url'  => $url,
       'button_html' => $this->button_html($text, $url, $nonSlide),
     );

     if( false == $this->is_sydney_active() ) {
       $slide_button = array('button_html' => 'not-exists');
     }

     $css_file = apply_filters('sydney_video_lightbox_button_css_file_url', SY_SLIDE_BUTTON_LIGHTBOX_URL . '/css/sy-slide-button-lightbox-style.css');
     $js_file = apply_filters('sydney_video_lightbox_button_js_file_url', SY_SLIDE_BUTTON_LIGHTBOX_URL .'/js/sy-slide-button-lightbox.js');

     wp_register_style( 'sy-slide-button-lightbox-style', $css_file, array(), null );
     wp_register_script('sy-slide-button-lightbox-script', $js_file, array ('jquery'), false, true);

     wp_localize_script( 'sy-slide-button-lightbox-script', 'slide_button', $slide_button );

     wp_enqueue_style( 'sy-slide-button-lightbox-style' );
     wp_enqueue_script( 'sy-slide-button-lightbox-script' );

   }



 }
endif;

new SY_Slide_Button_Lightbox;
