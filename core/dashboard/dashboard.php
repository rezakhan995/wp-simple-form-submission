<?php

namespace Wpfs\Core\Dashboard;

defined( "ABSPATH" ) || exit;

class Dashboard {
    use \Wpfs\Traits\Singleton;

    public static $default_menu_position = 60;
    public static $parent_page_slug      = 'general';
    public function init() {
        add_action( 'admin_menu', [$this, 'add_admin_menu'], 60 );
        add_action( 'wp_dashboard_setup', [$this, 'custom_dashboard_widget'] );
    }

    function custom_dashboard_widget() {
        global $wp_meta_boxes;

        wp_add_dashboard_widget( 'wpfs_dashboard_widget', 'Custom Dashboard Widget', [$this, 'dashboard_menu'] );
    }

    function dashboard_menu() {
        global $wpdb;
        $all_applications = $wpdb->get_results( "SELECT * FROM applicant_submissions ORDER BY application_id DESC LIMIT 5", ARRAY_A );

        $dashboard_widget = true;
        $template = WPFS_CORE_PATH . "/dashboard/views/admin-menu.php";
        if ( file_exists( $template ) ) {
            include_once $template;
        }

    }

    /**
     * Add main menu
     *
     * @since 1.0
     */
    public function add_admin_menu() {

        $position       = 60;
        $page_title     = esc_html__( "Wp Assignment", "wpfs" );
        $capability     = 'manage_options';
        $page_menu_slug = "wpfs";
        $icon_url       = 'dashicons-media-code';

        add_menu_page( $page_title, $page_title, $capability, $page_menu_slug, [$this, "menu_callback"], $icon_url, $position );
    }

    /**
     * Menu callback
     *
     * @since 1.0
     */
    public static function menu_callback() {
        global $wpdb;
        $all_applications = $wpdb->get_results( "SELECT * FROM applicant_submissions", ARRAY_A );

        $dashboard_widget = false;
        $template = WPFS_CORE_PATH . "/dashboard/views/admin-menu.php";

        if ( file_exists( $template ) ) {
            include_once $template;
        }

    }

}
