# Sydney Slide Button Lightbox
Enable lightbox on the main slider (**Full screen slider**) button of [Sydney WordPress theme](https://athemes.com/theme/sydney/) to play a video file (self-hosted or YouTube, Vimeo, etc.).


## How to enable Sydney's main slide button to a video lightbox button?

To enable YouTube video lightbox on the slide button of Sydney theme, follow these steps:

1. Download the [.zip package](https://github.com/kharissulistiyo/sydney-slide-button-lightbox/archive/main.zip) of this plugin
2. Install to your WordPress website's which is running Sydney theme via the **Plugins** menu > **Add New** > **Upload**
3. Activate plugin
4. Specify your video URL (e.g.: *https://www.youtube.com/watch?v=668nUCeBHyY*) to **Customize** > **Header area** > **Header Slider** > **URL for your call to action button**. You can use any video URL from YouTube, Vimeo, and other video sharing services, or even a self-hosted video file from your WordPress website's media library.
5. Update/Publish

## Available shortcode

You can use this shortcode to put the button anywhere in post, page, custom post type, widget, or template file.

```
[SydneyVideoButton btn-class="mybutton button btn" url="YOUR_VIDEO_URL" text="Button Text" nonSlide="yes"]
```

Shortcode parameters:
* **btn-class** _(required)_: CSS class
* **url** _(required)_: Video URL
* **text** _(required)_: Button text
* **nonSlide** _(optional)_: Use this parameter if you put the shortcode outside of the Sydney's main slider. The only available value is `yes`.

## Does the button still work when theme is switched?

Yes. The button you insert manually with the shortcode remains available and be working fine.

However, the button that is in Sydney's main slider will not work as it belongs to Sydney theme.


## Available filter hooks

There are several filters that allow you to modify the button to make it meets your requirements.

* Set custom button class: `sydney_video_lightbox_button_css_class`
* Rewrite button HTML: `sydney_video_lightbox_button_html`
* Rewrite plugin's CSS file: `sydney_video_lightbox_button_css_file_url`
* Rewrite plugin's JS file: `sydney_video_lightbox_button_js_file_url`

Example:

```
/**
 * Set custom button class
 */
add_filter( 'sydney_video_lightbox_button_css_class', 'prefix_custom_button_css_class' );
function prefix_custom_button_css_class() {
  $class   = array();
  $class[] = 'button';
  $class[] = 'btn';
  return $class;
}

/**
 * Rewrite button HTML
 */
add_filter( 'sydney_video_lightbox_button_html', 'prefix_custom_button_html', 10, 2 );
function prefix_custom_button_html( $btn_html, $btn_args ) {

  $btn_html = '<div class="custom-button-wrapper"><a class="'.$btn_args['btn-class'].'" href="'.esc_url($btn_args['url']).'" data-lity>'.esc_html($btn_args['text']).'</a></div>';

  return $btn_html;

}

/**
 * Rewrite plugin's CSS file
 */
add_filter( 'sydney_video_lightbox_button_css_file_url', 'prefix_custom_css_file' );
function prefix_custom_css_file() {
  return 'YOUR_CSS_FILE_URL';
}

/**
 * Rewrite plugin's JS file
 */
add_filter( 'sydney_video_lightbox_button_js_file_url', 'prefix_custom_js_file' );
function prefix_custom_js_file() {
  return 'YOUR_JS_FILE_URL';
}
```

## Credits

Thanks to [Lity](https://github.com/jsor/lity) jQuery lightbox library

## License

This plugin is licensed under GPL-2.0+
