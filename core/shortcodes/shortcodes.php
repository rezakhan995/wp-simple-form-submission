<?php

namespace Wpfa\Core\Shortcodes;

use Wpfa\Helper;

defined("ABSPATH") || die();

class Shortcodes {

    use \Wpfa\Traits\Singleton;

    public function init() {
        add_shortcode( 'applicant_form', [$this, 'applicant_form'] );
        add_action( "init", [$this, "submit_application_form"] );
    }

    /**
     * Create a shortcode to render the application form.
     * Print the application form's HTML code.
     */
    public function applicant_form( $atts ) {
        ob_start();
        $default_form_template     = WPFA_CORE_PATH . "/shortcodes/views/application-form-view.php";
        $application_form_template = apply_filters( "wpfa/application/template", $default_form_template );

        if ( file_exists( $application_form_template ) ) {
            include $application_form_template;
        }

        return ob_get_clean();
    }

    /**
     * Handle form submission
     *
     * @return void
     */
    public function submit_application_form() {

        if ( isset( $_POST["wpfa_submit"] ) && !empty( $_POST['wpfa_action'] ) && "wpfa_action" === sanitize_text_field( $_POST['wpfa_action'] ) ) {
            $post_arr    = filter_input_array( INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS );
            $is_secured = Helper::is_secured('wpfa_nonce_field', 'wpfa_nonce_field', $post_arr );
            wp_head();

            if ( $is_secured ) {

                if ( empty( $post_arr["wpfa_fname"] ) || empty( $post_arr["wpfa_lname"] ) ||
                    empty( $post_arr["wpfa_address"] ) || empty( $post_arr["wpfa_email"] ) ||
                    empty( $post_arr["wpfa_phone"] ) || empty( $post_arr["wpfa_post"] ) ||
                    empty( $_FILES["wpfa_cv"] ) ) {
                    //early return if any field is empty
                    ?>
                    <div class="section-inner">
                        <h3 class="wpfa-error-text-title">
                            <?php echo esc_html__( "All fields are required. ", "wpfa" ); ?>
                        </h3>
                        <div class="wpfa-error-text-body">
                            <a class="wpfa-btn" class="btn btn-primary" href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html__( "Try Again", "wpfa" ); ?></a>
                        </div>
                    </div>
                    <?php
                } else {
                    $first_name = $post_arr["wpfa_fname"];
                    $last_name  = $post_arr["wpfa_lname"];
                    $address    = $post_arr["wpfa_address"];
                    $email      = $post_arr["wpfa_email"];
                    $phone      = $post_arr["wpfa_phone"];
                    $post       = $post_arr["wpfa_post"];
                    $cv_file_path  = "";

                    // process data
                    $file_size              = $_FILES['wpfa_cv']['size'];
                    $file_ext               = end( explode("/", $_FILES['wpfa_cv']['type'] ) );
                    $accepted_file_types    = ["pdf", "doc", ".docx"];

                    if ( $file_size <= 500000 && in_array( $file_ext, $accepted_file_types ) ) {
                        $custom_filename    = time() . $_FILES['wpfa_cv']['name'];
                        $upload             = wp_upload_bits( $custom_filename, null, file_get_contents( $_FILES['wpfa_cv']['tmp_name'] ) );
                        if( !empty( $upload['url'] ) ){
                            $cv_file_path = $upload['url'];
                        }
                    }

                    //insert into db
                    global $wpdb;
                    $inserted  = $wpdb->query( "INSERT INTO `applicant_submissions` (`first_name`, `last_name`, `present_address`, `email`, `phone`, `post_name`, `cv_path`) VALUES ('$first_name', '$last_name', '$address', '$email', '$phone', '$post', '$cv_file_path')" );
                    $id_insert = $wpdb->insert_id;

                    if ( empty( $id_insert ) ) {
                        ?>
                        <div class="section-inner">
                            <h3 class="wpfa-error-text-title">
                                <?php echo esc_html__( "Application submission failed, please try again!. ", "wpfa" ); ?>
                            </h3>
                            <div class="wpfa-error-text-body">
                                <a class="wpfa-btn" href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html__( "Return to form", "wpfa" ); ?></a>
                            </div>
                        </div>
                        <?php
                    } else {
                        $from_name  = get_bloginfo( "name" );
                        $from       = get_bloginfo( 'admin_email' );
                        $subject    = esc_html__( 'Application submission', "wpfa" );

                        ob_start();
                        ?>
                        <div class="section-inner">
                            <div class="wpfa-error-text-title">
                                <?php echo esc_html__( "Application submission successful!. Your application id is " . $id_insert . ", please save this ID for future use.", "wpfa" ); ?>
                            </div>
                            <div class="wpfa-error-text-body">
                                <a class="wpfa-btn" href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html__( "Submit Another Application", "wpfa" ); ?></a>
                            </div>
                        </div>
                        <?php
                        $body       = ob_get_clean();
                        Helper::send_email( $email, $subject, $body, $from, $from_name );
                        echo Helper::render( $body );
                    }

                }

            } else {
                //invalid nonce, show error message
                ?>
                <div class="section-inner">
                    <h3 class="wpfa-error-text-title">
                        <?php echo esc_html__( "Invalid Request. ", "wpfa" ); ?>
                    </h3>
                    <div class="wpfa-error-text-body">
                        <a class="wpfa-btn" href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html__( "Return to form", "wpfa" ); ?></a>
                    </div>
                </div>
                <?php
            }

            wp_footer();
            unset( $_POST["wpfa_submit"] );
            exit;
        }

    }

}

?>