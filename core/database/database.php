<?php

namespace Wpfs\Core\Database;

class Database {

    use \Wpfs\Traits\Singleton;

    public function init() {
        $this->_action_create_table();
    }

    /**
     * Create plugin specific tables to store data
     *
     * @return void
     */
    private function _action_create_table() {
        global $wpdb;
        $tableName       = 'applicant_submissions';
        $charset_collate = $wpdb->get_charset_collate();

        // create table for storing data
        if ( $wpdb->get_var( "SHOW TABLES LIKE '$tableName'" ) != $tableName ) {

            require_once ABSPATH . 'wp-admin/includes/upgrade.php';

            // create fundraising table
            $wdp_sql = "CREATE TABLE IF NOT EXISTS `$tableName` (
                        `application_id` mediumint(9) NOT NULL AUTO_INCREMENT,
                        `first_name` varchar(150) NOT NULL,
                        `last_name` varchar(150) NOT NULL,
                        `present_address` varchar(255) NOT NULL,
                        `email` varchar(150) NOT NULL,
                        `phone` varchar(16) NOT NULL,
                        `post_name` varchar(150) NOT NULL,
                        `cv_path` varchar(255) NOT NULL,
                        PRIMARY KEY (`application_id`)
                    ) $charset_collate;";

            dbDelta( $wdp_sql );
        }

    }

}

?>