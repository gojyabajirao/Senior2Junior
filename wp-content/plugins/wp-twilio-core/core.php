<?php

/**
 * Plugin Name: WP SMS for WordPress
 * Description: Wordpress SMS Plugin - Send SMS Messages & notifications to users using Twilio API.Pro version, Addons and Bulk SMS available. 
 * Version: 1.3.2
 * Author: WPSMS.IO
 * Author URI: https://wpsms.io
 * License: GPLv2 or later
 * Text Domain: twilio-core
 * Domain Path: /languages
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */
define( 'TWL_CORE_VERSION', '1.3.2' );
define( 'TWL_CORE_OPTION', 'twl_option' );
define( 'TWL_CORE_OPTION_PAGE', 'twilio-options' );
define( 'TWL_CORE_SETTING', 'twilio-options' );
define( 'TWL_LOGS_OPTION', 'twl_logs' );
define( 'TWL_CORE_NOTIFICATION_OPTION', 'twl_notification_option' );
define( 'TWL_CORE_NOTIFICATION_SETTING', 'twilio-notification-options' );
define( 'TWL_CORE_NEWSLETTER_OPTION', 'twl_newsletter_option' );
define( 'TWL_CORE_NEWSLETTER_SETTING', 'twilio-newsletter-options' );
if ( !defined( 'TWL_TD' ) ) {
    define( 'TWL_TD', 'twilio-core' );
}
if ( !defined( 'TWL_PATH' ) ) {
    define( 'TWL_PATH', plugin_dir_path( __FILE__ ) );
}

if ( !function_exists( 'twl_freemius' ) ) {
    // Create a helper function for easy SDK access.
    function twl_freemius()
    {
        global  $twl_freemius ;
        
        if ( !isset( $twl_freemius ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $twl_freemius = fs_dynamic_init( array(
                'id'             => '2894',
                'slug'           => 'wp-twilio-core',
                'type'           => 'plugin',
                'public_key'     => 'pk_41d58e132e8e380880894f44eb5ca',
                'is_premium'     => false,
                'premium_suffix' => 'Pro',
                'has_addons'     => true,
                'has_paid_plans' => true,
                'menu'           => array(
                'slug'    => 'twilio-options',
                'support' => false,
            ),
                'is_live'        => true,
            ) );
        }
        
        return $twl_freemius;
    }
    
    // Init Freemius.
    twl_freemius();
    // Signal that SDK was initiated.
    do_action( 'twl_freemius_loaded' );
}

require_once TWL_PATH . 'twilio-php/src/Twilio/autoload.php';
require_once TWL_PATH . 'helpers.php';
require_once TWL_PATH . 'url-shorten.php';
require_once TWL_PATH . 'inc/helpers.php';
//admin notices
require_once TWL_PATH . 'inc/admin-notices.php';

if ( is_admin() ) {
    require_once TWL_PATH . 'admin-pages.php';
    require_once TWL_PATH . 'apps-integrations.php';
}

require_once TWL_PATH . 'hooks.php';
class WP_Twilio_Core
{
    private static  $instance ;
    private  $page_url ;
    private function __construct()
    {
        $this->set_page_url();
        // Init Freemius.
        twl_freemius();
        // Signal that SDK was initiated.
        do_action( 'twl_freemius_loaded' );
    }
    
    public function init()
    {
        $options = $this->get_options();
        load_plugin_textdomain( TWL_TD, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
        
        if ( is_admin() ) {
            /** Settings Pages **/
            add_action( 'admin_init', array( $this, 'register_settings' ), 1000 );
            add_action( 'admin_menu', array( $this, 'admin_menu' ), 1000 );
        }
        
        /** User Profile Settings **/
        if ( isset( $options['mobile_field'] ) && $options['mobile_field'] ) {
            add_filter( 'user_contactmethods', 'twl_add_contact_item', 10 );
        }
    }
    
    /**
     * Add the Twilio item to the Settings menu
     * @return void
     * @access public
     */
    public function admin_menu()
    {
        add_menu_page(
            __( 'WPSMS', TWL_TD ),
            __( 'WPSMS', TWL_TD ),
            'administrator',
            TWL_CORE_OPTION_PAGE,
            array( $this, 'display_tabs' ),
            'dashicons-email-alt',
            91
        );
    }
    
    /**
     * Determines what tab is being displayed, and executes the display of that tab
     * @return void
     * @access public
     */
    public function display_tabs()
    {
        $options = $this->get_options();
        $tabs = $this->get_tabs();
        $current = ( !isset( $_GET['tab'] ) ? current( array_keys( $tabs ) ) : $_GET['tab'] );
        ?>
		<div class="wrap">
			<div id="icon-options-general" class="icon32"></div><h2><?php 
        _e( 'WPSMS - Twilio', TWL_TD );
        ?></h2>
			<h2 class="nav-tab-wrapper"><?php 
        foreach ( $tabs as $tab => $name ) {
            $classes = array( 'nav-tab', $tab );
            if ( $tab == $current ) {
                $classes[] = 'nav-tab-active';
            }
            $href = esc_url( add_query_arg( 'tab', $tab, $this->page_url ) );
            echo  '<a class="' . implode( ' ', $classes ) . '" href="' . $href . '">' . $name . '</a>' ;
        }
        ?>
			</h2>
			
			<div class="tabcontent">

			<?php 
        do_action( 'twl_display_tab', $current, $this->page_url );
        ?>
			
			</div>
			
		</div>
		<?php 
    }
    
    /**
     * Saves the URL of the plugin settings page into the class property
     * @return void
     * @access public
     */
    public function set_page_url()
    {
        $base = admin_url( 'admin.php' );
        $this->page_url = add_query_arg( 'page', TWL_CORE_OPTION_PAGE, $base );
    }
    
    /**
     * Returns an array of settings tabs, extensible via a filter
     * @return void
     * @access public
     */
    public function get_tabs()
    {
        $default_tabs = array(
            'general'       => __( 'Settings', TWL_TD ),
            'logs'          => __( 'Logs', TWL_TD ),
            'test'          => __( 'Test', TWL_TD ),
            'notifications' => __( 'Notifications', TWL_TD ),
        );
        return apply_filters( 'twl_settings_tabs', $default_tabs );
    }
    
    /**
     * Register/Whitelist our settings on the settings page, allow extensions and other plugins to hook into this
     * @return void
     * @access public
     */
    public function register_settings()
    {
        register_setting( TWL_CORE_SETTING, TWL_CORE_OPTION, 'twl_sanitize_option' );
        do_action( 'twl_register_additional_settings' );
        register_setting( TWL_CORE_NOTIFICATION_SETTING, TWL_CORE_NOTIFICATION_OPTION, 'twl_sanitize_option' );
        register_setting( TWL_CORE_NEWSLETTER_SETTING, TWL_CORE_NEWSLETTER_OPTION, 'twl_sanitize_option' );
        do_action( 'twl_register_additional_settings' );
    }
    
    /**
     * Original get_options unifier
     * @return array List of options
     * @access public
     */
    public function get_options()
    {
        return twl_get_options();
    }
    
    /**
     * Get the singleton instance of our plugin
     * @return class The Instance
     * @access public
     */
    public static function get_instance()
    {
        if ( !self::$instance ) {
            self::$instance = new WP_Twilio_Core();
        }
        return self::$instance;
    }
    
    /**
     * Adds the options to the options table
     * @return void
     * @access public
     */
    public static function plugin_activated()
    {
        add_option( TWL_CORE_OPTION, twl_get_defaults() );
        add_option( TWL_LOGS_OPTION, '' );
        add_option( TWL_CORE_NOTIFICATION_OPTION, twl_get_notification_defaults() );
        add_option( TWL_CORE_NEWSLETTER_OPTION, twl_get_newsletter_defaults() );
    }
    
    /**
     * Deletes the options to the options table
     * @return void
     * @access public
     */
    public static function plugin_uninstalled()
    {
        delete_option( TWL_CORE_OPTION );
        delete_option( TWL_LOGS_OPTION );
        delete_option( TWL_CORE_NOTIFICATION_OPTION );
        delete_option( TWL_CORE_NEWSLETTER_OPTION );
    }

}
$twl_instance = WP_Twilio_Core::get_instance();
add_action( 'plugins_loaded', array( $twl_instance, 'init' ) );
register_activation_hook( __FILE__, array( 'WP_Twilio_Core', 'plugin_activated' ) );
twl_freemius()->add_action( 'after_uninstall', array( 'WP_Twilio_Core', 'plugin_uninstalled' ) );


// Admin notices
// Load notice css
add_action( 'admin_enqueue_scripts', 'notice_admin_css' );
function notice_admin_css()
{
    wp_enqueue_style( 'admin_css', plugins_url( 'assets/css/admin.css', __FILE__ ) );
}