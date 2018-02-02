<?php
/*
Plugin Name: Snowbotica Search
Plugin URI: http://nowbotica.com/lets-tzu-this/
Description: A rust proof diy starter kit for miro enterprises
Author: Andrew MacKay
Version: 1.2.3
Author URI: http://nowbotica.com/
*/

define( 'SNOWBOTSEARCH', plugin_dir_path( __FILE__ ) );
define( 'SNOWBOTSEARCH_URL', plugin_dir_url( __FILE__ ) );

# Includes the Listing module
// include( SNOWBOTCLIENT . '/parts/Listing.php');
// include( SNOWBOTCLIENT . '/parts/Listing-model.php');

/**
  * Creates shortcode to display main application
  *
  */
function snowboticaSearch(  ) {
  ?>
    <section class="whitelabel" ng-app="SearchApp" style="min-height: 300px;">
      <ui-view autoscroll="false" ng-if='!isRouteLoading'></ui-view>
    </section>

  <?php
}
add_shortcode('snowboticaSearch', 'snowboticaSearch');

/**
 * Includes js when shortcode called - kinda slow
 *
 */
function snowboticaSearch_head(){
   global $posts;
   $pattern = get_shortcode_regex();
   preg_match('/'.$pattern.'/s', $posts[0]->post_content, $matches);
   // if (is_array($matches) && $matches[2] == 'snowboticaSearch') {
        // shortcode is being used
        add_action('wp_enqueue_scripts','snowboticaSearch_css');
        add_action('wp_enqueue_scripts','snowboticaSearch_scripts');
   // }
}
add_action('template_redirect','snowboticaSearch_head');


/*-------------------------------------------------------------------------------
  Frontend dependencies Javascript and CSS to be included by [snowboticaSearch] shortcode
-------------------------------------------------------------------------------*/

if ( ! function_exists( 'snowboticaSearch_css' ) ) {
    /*
     *  loads the applications css dependancies and theme css files
     */
    function snowboticaSearch_css() {

        // MVP Mechanic Application files
        wp_enqueue_style( 'snowboticaSearch_build',  SNOWBOTSEARCH_URL . '/application/build/build.css', false, '1.0.0', 'all');

    }

}

if ( ! function_exists( 'snowboticaSearch_scripts' ) ) {
    /*
     *  loads the applications js dependancies and application files
     */
    function snowboticaSearch_scripts() {

        // '_'
        wp_enqueue_script( 'underscore-js', SNOWBOTSEARCH_URL .  'application/dependencies/underscore/underscore.js', array(), '', true);

        // 'angular'
        wp_enqueue_script( 'angular', SNOWBOTSEARCH_URL .  'application/dependencies/angular/angular.js', array(
            'jquery', 'underscore-js'
        ), '', true);

        // 'ui-router'
        wp_enqueue_script( 'angular-ui', SNOWBOTSEARCH_URL .  'application/dependencies/angular-ui-router/release/angular-ui-router.js', array(
            'angular'
        ), '', true);

        // 'ngAnimate'
        wp_enqueue_script( 'ng-animate', SNOWBOTSEARCH_URL .  'application/dependencies/angular-animate/angular-animate.js', array(
            'angular'
        ), '', true);

        // MVP Mechanic System files
        wp_enqueue_script( 'snowbotica-search', SNOWBOTSEARCH_URL .  'application/snowbotica-search.js', array(
            'jquery',
            'underscore-js',
            'angular',
            'angular-ui',
            'ng-animate'
        ), '', true);

        // API Token set up
        wp_localize_script( 'snowbotica-search', 'mvpm_api_object', array(
            'ajax_nonce'      => wp_create_nonce('mvpm_system'),
            'ajax_url'        => admin_url( 'admin-ajax.php' ) ,
            'url_domain_path' => get_site_url(),
            'partials_path'   => SNOWBOTSEARCH_URL .  '/application/templates' ,
            'image_path'      => SNOWBOTSEARCH_URL .  '/application/build/images/'
        ), '', true);

        // MVP Mechanic Base Application
        wp_enqueue_script('mvpm-controllers', SNOWBOTSEARCH_URL . 'application/system/controllers.js', array(
           'snowbotica-search'
        ), '', true);
        wp_enqueue_script('mvpm-directives', SNOWBOTSEARCH_URL . 'application/system/directives.js', array(
           'snowbotica-search'
        ), '', true);
        wp_enqueue_script('mvpm-factories', SNOWBOTSEARCH_URL . 'application/system/factories.js', array(
           'snowbotica-search'
        ), '', true);
        wp_enqueue_script('mvpm-services', SNOWBOTSEARCH_URL . 'application/system/services.js', array(
           'snowbotica-search'
        ), '', true);

        // MVP Mechanic User Module
        wp_enqueue_script( 'mvpm-user-module', SNOWBOTSEARCH_URL . '/application/system/User.js', array(
            'snowbotica-search'
        ), '', true);

        wp_localize_script( 'snowbotica-search', 'mvpm_user_object', array(
            'mvpm_redirecturl' => home_url(),
            'mvpm_passwordreseturl' => 'resetp',
            'mvpm_registerurl' => 'register',
            'mvpm_loginloadingmessage' => __('Sending user info, please wait...')
        ));

        // MVP Mechanic Listing Module
        wp_enqueue_script( 'mvpm-listing-module', SNOWBOTSEARCH_URL . '/application/system/Listing.js', array(
            'snowbotica-search'
        ), '', true);

    }
}


