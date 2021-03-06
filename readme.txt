=== THEME Cyon ===

* by the Greater Than Website team, http://gtwebsite.com/

== Description ==

== Future Updates ==
slider add thumbnail
slider feature list
Widgets - to which page appear

== Changelog ==

= 1.4.2 =
* Updated tabs, toggle, accordion shortcode
* Added Akismet support for the forms

= 1.4.1 =
* Updated gutter width of grid
* Updated Woocommerce override
* Updated Subpage widget
* Updated Metabox to 4.2.4

= 1.4.0 =
* Updated Options Framework to 1.5
* Updated for Woocommerce 2.0
* Updated Contact Form widget
* Updated Subpage widget

= 1.3.5 =
* Updated Contact widget
* Updated Socialize widget
* Updated Ads widget
* Updated Twitter widget
* Fixed blog shortcode not getting the excerpt

= 1.3.4 =
* Added CSS3 Transitions
* Added Menu font
* Added Gallery widget
* Remove Cyon slider/banner
* Updated breadcrumb
* Updated Ad widget
* Updated Supersized 3.2.7
* Fixed few css/php issues

= 1.3.3 =
* Added Testimonial widget / shortcode
* Added Submenu widget
* Added Sitemap shortcode
* Added Masonry blog layout
* Added Contact form widget / shortcode
* Added background image on pages, posts, and categories
* Added Localization
* Added Back to Top shortcode
* Added Post Format gallery
* Updated Horizontal Line
* Updated Iframe
* Updated Video player
* Updated Post Format
* Updated Google fonts
* Updated Homepage slider
* Updated Menu function
* Updated Meta box to 4.2.3
* Updated Options Framework to 1.4
* Updated icons
* Fixed few css/php issues

= 1.3.2 =
* Added image banner on blog categories
* Added Blog post shortcode
* Added Ad widget
* Added Post Formats (Standard, Aside, Image, Link, Quote, Video, Audio)
* Added simple SEO function 
* Added Popup blank page template
* Updated Map Widget, added text
* Updated Subpage shortcode
* Updated Forms
* Fixed PHP bug
* Fixed Theme options CSS bug


= 1.3.1 =
* Added Tax-meta-class
* Added Category page layout option
* Added Category list layout option
* Added Newsletter widget
* Added Tab widget
* Added 3 Custom Widget area
* Updated social bookmarking
* Improved page layout
* Fixed few css/php issues

= 1.3.0 =
* Added child theme support
* Added grid fluid system
* Added custom MCE menu
* Added Breacrumb NavXT support
* Added Display Author info
* Added Tab shortcode
* Added Poshytip
* Added Theme Selection
* Added List grid with icons
* Added Message boxes with icons
* Added Icons shortcode
* Added Header shortcode
* Added Button shortcode
* Added Table shortcode
* Added Map shortcode & widget
* Added Iframe shortcode & widget
* Added Video / Audio shortcode & widget
* Added Contact widget
* Added Social widget
* Updated Price Grid
* Updated CSS formatting
* Updated responsive design
* Updated core files

= 1.2.0 =
* Added Comment enable/disable
* Added ancestor body class to subpages
* Added Subpages shortcode
* Added Excerpt on Pages
* Added Product Categories Widget
* Added Slider Caption width and location
* Added Slider Pagination location
* Added Price Grid shortcode
* Added CloudZoom for product image
* Added new style on radio buttons/checkboxes
* Updated some HTML
* Updated Back to Top
* Updated CSS
* Updated Twitter code

= 1.2.4 =
* Added remove WP core and plugin updates
* Added Facebook Like Box widget
* Added Flickr Gallery widget
* Added Background support
* Updated menu to fade on hover
* Updated footer menu when not set
* Updated homepage slider with clickable image
* Fixed few PHP issues

= 1.2.3 =
* Added Toggle shortcode
* Added Accordion shortcode

= 1.2.2 =
* Added support for Blog page layout
* Added Google Font support
* Added WP-PageNavi support
* Added Gallery using Flexslider
* Updated  Meta Box to 4.1.1
* Updated slider with Meta Box
* Updated breadcrumb
* Updated Meta Post
* Fixed Featured Image on Home
* Fixed few PHP issues

= 1.2.1 =

* Added options for slider
* Added Twitter Update widget
* Added Youtube widget
* Added support for Gravity Form
* Added support for Woocommerce
* Added support for Image Widget
* Added Total Cart widget for Woocommerce
* Added Modernizr 2.6.1 and removed html5.js
* Added unhook example to functions.php
* Added featured image on post and page
* Added logo and background color to admin login page
* Added show home page content
* Added new hooks, see init.php
* Updated Social Settings
* Updated Style for the sidebar widget
* Updated sample helloword.php widget
* Updated to Flexlider 2.1
* Updated comments
* Updated registering custom js/css, see init.php
* Fixed layout on sidebars
* Fixed main/footer menu styling
* Fixed PHP error on Slider
* Fixed few PHP issues
* Fixed Javascript conflict issue regarding page tabs

= 1.1.1 =

* Fixed a few PHP issues

= 1.1.0 =

* Added readme.txt
* Name change to "Theme Cyon"
* Theme Options updated to 1.3
* Fixed some spellings
* Added Fluid Column Layout shortcodes
* Change default font to "Segoe UI"
* Change default slider to "Use Page's Default"
* Added default function on meta-boxes for selectbox and radio button
* Added more styling
* Updated search form widget
* Updated Editor style

= 1.0.0 =

* Deploy


== WP Enqueue ==

* jquery (default)
* modernizr (default)
* jquery_cycle
* twitter_blogger_js
* twitter_user_timeline_js
* fancybox
* fancybox_thumbs
* fancybox_media
* fancybox_buttons
* lazyload
* mousewheel
* flexislider
* supersized
* tubular
* cloud_zoom
* uniform
* poshytip
* mediaelement
* gmap_api
* gmap
* masonry

== Custom Hooks ==

* cyon_before_header
* cyon_header
	Top Columns: cyon_header_columns_hook, 10
	Logo: cyon_header_logo_hook, 20
	Main Nav: cyon_header_mainnav_hook, 30
* cyon_before_body
* cyon_after_body
* cyon_before_body_wrapper
	Breadcrumb: cyon_breadcrumb_hook, 10
* cyon_after_body_wrapper
* cyon_primary_before
* cyon_primary_after
	Comments: cyon_comments_hook, 10
* cyon_sidebar_before
* cyon_sidebar_after
* cyon_post_header_before
* cyon_post_header_after
	Single Meta: cyon_post_header_single_meta_hook, 10
* cyon_post_content_before
	Featured Image: cyon_post_content_featured_image_content, 10
* cyon_post_content_after
	Read more: cyon_readmore, 10
	Social Buttons: cyon_socialshare_hook, 20
* cyon_post_footer
	Author: cyon_author_hook, 10
* cyon_home_content
	Home Banner: cyon_banner_hook, 10
	Home Middle Block: cyon_homepage_middle_block_hook, 20
	Home Widgets: cyon_homepage_columns_hook, 30
	Home Content: cyon_homepage_content_hook, 40
* cyon_footer
	Footer Widgets: cyon_footer_columns_hook, 10
	Copyright: cyon_footer_copyright_hook, 20
	Subfooter: cyon_footer_subfooter_hook, 30
	Back to Top: cyon_footer_backtotop_hook, 40
* cyon_after_footer