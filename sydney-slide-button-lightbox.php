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

    }


    function button_html($text, $url) {
      return '<a class="slide-lightbox-html roll-button button-slider" href="'.esc_url($url).'" data-lity>'.esc_html($text).'</a>';
    }

    function enqueue_scripts() {

      $text = get_theme_mod('slider_button_text','Click to begin');
      $url  = get_theme_mod('slider_button_url','#primary');

      $slide_button = array(
        'btn_text' => $text,
        'btn_url'  => $url,
        'button_html' => $this->button_html($text, $url),
      );

      $css_file = apply_filters('efw_wa_seller_css_file_url', SY_SLIDE_BUTTON_LIGHTBOX_URL . '/css/sy-slide-button-lightbox-style987.css');
      $js_file = apply_filters('efw_wa_seller_js_file_url', SY_SLIDE_BUTTON_LIGHTBOX_URL .'/js/sy-slide-button-lightbox962.js');

      wp_register_style( 'sy-slide-button-lightbox-style', $css_file, array(), null );
      wp_register_script('sy-slide-button-lightbox-script', $js_file, array ('jquery'), false, true);

      wp_localize_script( 'sy-slide-button-lightbox-script', 'slide_button', $slide_button );

      wp_enqueue_style( 'sy-slide-button-lightbox-style' );
      wp_enqueue_script( 'sy-slide-button-lightbox-script' );

      do_action('efw_wa_seller_scripts');

    }



  }
endif;

new SY_Slide_Button_Lightbox;
