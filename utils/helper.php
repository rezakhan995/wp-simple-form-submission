<?php

namespace Wpfs\Utils;

defined("ABSPATH") || die();

class Helper {

    /**
     * validation for nonce
     */
    public static function is_secured( $nonce_field, $action, $post ) {

        $nonce = isset( $post[$nonce_field] ) ? sanitize_text_field( $post[$nonce_field] ) : '';

        if ( $nonce == '' ) {
            return false;
        }

        if ( !wp_verify_nonce( $nonce, $action ) ) {
            return false;
        }

        return true;
    }

    
    /**
     * Send email function
     */
    public static function send_email( $to, $subject, $mail_body, $from, $from_name ) {
        $body       = html_entity_decode($mail_body);
        $headers    = ['Content-Type: text/html; charset=UTF-8', 'From: ' . $from_name . ' <' . $from . '>'];
        $result     = wp_mail( $to, $subject, $body, $headers );

        return $result;
    }

    public static function render( $content ) {
        return $content;
    }

    public static function get_all_applications() {
        global $wpdb;
        $applications = $wpdb->get_results("SELECT * FROM applicant_submissions", ARRAY_A);
        
        return $applications;
    }

}

?>