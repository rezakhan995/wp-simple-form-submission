<?php

defined( "ABSPATH" ) || exit;

/**
 * Plugin Name: Wp Simple Form Submission
 * Description: A simple form submission plugin
 * Plugin URI: https://reza-khan.com
 * Author: Reza Khan
 * Version: 1.0.0
 * Author URI: https://reza-khan.com/
 * Text Domain: wpfs
 * Domain Path: /languages
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 */

final class Wpfs {

    /**
     * Plugin version
     *
     * @var string
     */
    public $version = '1.0.0';

    /**
     * Constructor for Wp_Form_Assignment class
     *
     */
    public function __construct() {
        require_once plugin_dir_path( __FILE__ ) . 'autoloader.php';

        $this->define_constants();

        register_activation_hook( __FILE__, [$this, 'activate'] );
        register_deactivation_hook( __FILE__, [$this, 'deactivate'] );
        add_action( 'plugins_loaded', [$this, 'init_plugin'] );
    }

   /**
     * Instantiate the required modules and features
     *
     * @return void
     */
    public function init_plugin() {

         do_action( 'wpfs/before_load' );
         $this->initialize_functionalities();
         do_action( 'wpfs/after_load' );
    }


    public function initialize_functionalities(){
      \Wpfs\Autoloader::run();

      $this->enqueue_scripts();

      \Wpfs\Core\Database\Database::instance()->init();
      \Wpfs\Core\Shortcodes\Shortcodes::instance()->init();
      \Wpfs\Core\Dashboard\Dashboard::instance()->init();
    }

    function enqueue_scripts(){
      add_action( "admin_enqueue_scripts", [ $this, "admin_enqueue_scripts" ]);
      add_action( "wp_enqueue_scripts", [ $this, "public_enqueue_scripts" ]);
    }

    function admin_enqueue_scripts(){
      wp_enqueue_style( 'wpfs-admin-css', WPFS_ASSETS . '/css/admin.css', [], WPFS_VERSION, 'all' );
    }

    function public_enqueue_scripts(){
      wp_enqueue_style( 'wpfs-public-css', WPFS_ASSETS . '/css/public.css', [], WPFS_VERSION, 'all' );
    } 

    /**
     * Used as activation function
     *
     * @return void
     */
    public function activate() {
      return;
    }

    /**
     * Used as deactivation function
     *
     * @return void
     */
    public function deactivate() {
      return;
    }

    public function define_constants() {
        define( 'WPFS_VERSION', $this->version );
        define( 'WPFS_FILE', __FILE__ );
        define( 'WPFS_PATH', untrailingslashit( plugin_dir_path( WPFS_FILE ) ) );
        define( 'WPFS_CORE_PATH', WPFS_PATH . '/core' );
        define( 'WPFS_URL', plugins_url( '', WPFS_FILE ) );
        define( 'WPFS_ASSETS', WPFS_URL . '/assets' );
    }

    /**
     * Initializes the Wp_Form_Assignment() class
     *
     * Checks for an existing Wp_Form_Assignment() instance
     * and if it doesn't find one, creates one.
     */
    public static function init() {
        static $instance = false;

        if ( !$instance ) {
            $instance = new Wpfs();
        }

        return $instance;
    }

}

Wpfs::init();
