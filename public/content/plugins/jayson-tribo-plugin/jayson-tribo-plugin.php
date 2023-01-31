<?php

/**
 *
 * @link              https://google.com
 * @since             1.0.0
 * @package           Jayson_Tribo_Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       Jayson Tribo Plugin
 * Plugin URI:        https://google.com
 * Description:       This plugin will be used for Jayson Tribo's Assessment.
 * Version:           1.0.0
 * Author:            Jayson Tribo
 * Author URI:        https://google.com
*/

// Install Plugin, create table
function register_plugin()
{      
  global $wpdb; 
  $db_table_name = $wpdb->prefix . 'newsletter';
  $charset_collate = $wpdb->get_charset_collate();

  $sql = "CREATE TABLE $db_table_name (
                id int(11) NOT NULL AUTO_INCREMENT,
                name varchar(150) NOT NULL,
                email varchar(200) NOT NULL,
                subscription_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (id)
        ) $charset_collate;";

   require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
   dbDelta( $sql );
}

register_activation_hook( __FILE__, 'register_plugin' );

// Uninstall Plugin, delete table
function deregister_plugin() {
     global $wpdb;
     $db_table_name = $wpdb->prefix . 'newsletter';

     $sql = "DROP TABLE IF EXISTS $db_table_name";
     $wpdb->query($sql);
} 

register_deactivation_hook( __FILE__, 'deregister_plugin' );

// Add custom styling
function load_assets() {
    $plugin_url = plugin_dir_url( __FILE__ );

    // Register style and scripts
    wp_register_style( 'custom_css', $plugin_url.'/css/style.css' );
    wp_register_script( 'custom_js', $plugin_url.'/js/custom.js' );

    // Call all registered style and script
    wp_enqueue_script( 'custom_js' );
    wp_enqueue_style( 'custom_css' );
}

add_action('wp_enqueue_scripts', 'load_assets');

// Start session
function start_session() {
    if(!session_id()) {
        session_start();
    }
}

add_action('init', 'start_session', 1);

// Custom endpoints
function save_newsletter_subscription($request_data) {
    $response = array(
        "status" => "failed",
        "message" => "Failed to signup, please try again later"
    );

    $data = $request_data->get_params();

    if(isset($data['name']) && isset($data['email'])) {
        global $wpdb;
        $db_table_name = $wpdb->prefix . 'newsletter';

        // Insert data to database
        $insertData = $wpdb->insert($db_table_name, array(
            'name' => $data['name'],
            'email' => $data['email']
        ));

        if($insertData) {
            // Save session to prevent showing popup again
            $_SESSION['subscribed'] = true;

            $response = array(
                "status" => "success",
                "message" => "Thank you for signing up to our newsletter!"
            );
        }        
    }

    return $response;
}

add_action('rest_api_init', function () {
    register_rest_route( 'newsletter/v1', '/save', array(
        'methods' => 'POST',
        'callback' => 'save_newsletter_subscription'
    ));
});

function display_popup_form() {    
    // Check if session is already present
    if(!isset($_SESSION['subscribed'])) {
        echo "
            <div class='newsletter-modal'>
                <div class='newsletter-modal-content'>
                    <h3>PRUNDERGROUND NEWSLETTER</h3>

                    <form name='newsletter-form' method='POST' onsubmit='return validateForm()'>
                        <input type='text' class='newsletter-input' name='name' placeholder='Your Name'>
                        <input type='email' class='newsletter-input' name='email' placeholder='Email Address'>
                        <button class='newsletter-button'>Signup</button>
                    </form>
                </div>
            </div>
        ";
    }
}

add_action( 'wp_footer', 'display_popup_form' );
?>