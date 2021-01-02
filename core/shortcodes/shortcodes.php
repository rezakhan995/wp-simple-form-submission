<?php

namespace Wpfs\Core\Shortcodes;

use Wpfs\Utils\Helper;

defined("ABSPATH") || die();

class Shortcodes {

    use \Wpfs\Traits\Singleton;

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
        $default_form_template     = WPFS_CORE_PATH . "/shortcodes/views/application-form-view.php";
        $application_form_template = apply_filters( "wpfs/application/template", $default_form_template );

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

        if ( isset( $_POST["wpfs_submit"] ) && !empty( $_POST['wpfs_action'] ) && "wpfs_action" === sanitize_text_field( $_POST['wpfs_action'] ) ) {
            $post_arr    = filter_input_array( INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS );
            $is_secured = Helper::is_secured('wpfs_nonce_field', 'wpfs_nonce_field', $post_arr );
            wp_head();

            if ( $is_secured ) {

                if ( empty( $post_arr["wpfs_fname"] ) || empty( $post_arr["wpfs_lname"] ) ||
                    empty( $post_arr["wpfs_address"] ) || empty( $post_arr["wpfs_email"] ) ||
                    empty( $post_arr["wpfs_phone"] ) || empty( $post_arr["wpfs_post"] ) ||
                    empty( $_FILES["wpfs_cv"] ) ) {
                    //early return if any field is empty
                    ?>
                    <div class="section-inner">
                        <h3 class="wpfs-error-text-title">
                            <?php echo esc_html__( "All fields are required. ", "wpfs" ); ?>
                        </h3>
                        <div class="wpfs-error-text-body">
                            <a class="wpfs-btn" class="btn btn-primary" href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html__( "Try Again", "wpfs" ); ?></a>
                        </div>
                    </div>
                    <?php
                } else {
                    $first_name = $post_arr["wpfs_fname"];
                    $last_name  = $post_arr["wpfs_lname"];
                    $address    = $post_arr["wpfs_address"];
                    $email      = $post_arr["wpfs_email"];
                    $phone      = $post_arr["wpfs_phone"];
                    $post       = $post_arr["wpfs_post"];
                    $cv_file_path  = "";

                    // process data
                    $file_size              = $_FILES['wpfs_cv']['size'];
                    $file_type              = $_FILES['wpfs_cv']['type'];
                    $file_type_array        = explode("/", $file_type );
                    $file_ext               = end( $file_type_array );
                    $accepted_file_types    = ["pdf", "doc", ".docx"];

                    if ( $file_size <= 500000 && in_array( $file_ext, $accepted_file_types ) ) {
                        $custom_filename    = time() . $_FILES['wpfs_cv']['name'];
                        $upload             = wp_upload_bits( $custom_filename, null, file_get_contents( $_FILES['wpfs_cv']['tmp_name'] ) );
                        if( !empty( $upload['url'] ) ){
                            //file upload successful, insert all data in our storage
                            $cv_file_path = $upload['url'];

                            //insert into db
                            global $wpdb;
                            $inserted  = $wpdb->query( "INSERT INTO `applicant_submissions` (`first_name`, `last_name`, `present_address`, `email`, `phone`, `post_name`, `cv_path`) VALUES ('$first_name', '$last_name', '$address', '$email', '$phone', '$post', '$cv_file_path')" );
                            $id_insert = $wpdb->insert_id;

                            if ( empty( $id_insert ) ) {
                                ?>
                                <div class="section-inner">
                                    <h3 class="wpfs-error-text-title">
                                        <?php echo esc_html__( "Application submission failed, please try again!. ", "wpfs" ); ?>
                                    </h3>
                                    <div class="wpfs-error-text-body">
                                        <a class="wpfs-btn" href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html__( "Return to form", "wpfs" ); ?></a>
                                    </div>
                                </div>
                                <?php
                            } else {
                                $from_name  = get_bloginfo( "name" );
                                $from       = get_bloginfo( 'admin_email' );
                                $subject    = esc_html__( 'Application submission', "wpfs" );

                                ob_start();
                                ?>
                                <div class="section-inner">
                                    <div class="wpfs-error-text-title">
                                        <?php echo esc_html__( "Application submission successful!. Your application id is " . $id_insert . ", please save this ID for future use.", "wpfs" ); ?>
                                    </div>
                                    <div class="wpfs-error-text-body">
                                        <a class="wpfs-btn" href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html__( "Submit Another Application", "wpfs" ); ?></a>
                                    </div>
                                </div>
                                <?php
                                $body       = ob_get_clean();
                                Helper::send_email( $email, $subject, $body, $from, $from_name );
                                echo Helper::render( $body );
                            }
                        } else {
                            ?>
                            <div class="section-inner">
                                <h3 class="wpfs-error-text-title">
                                    <?php echo esc_html__( "There was a problem uploading your file, please try again!. ", "wpfs" ); ?>
                                </h3>
                                <div class="wpfs-error-text-body">
                                    <a class="wpfs-btn" href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html__( "Return to form", "wpfs" ); ?></a>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <div class="section-inner">
                            <h3 class="wpfs-error-text-title">
                                <?php echo esc_html__( "Invalid file, please try again!. ", "wpfs" ); ?>
                            </h3>
                            <div class="wpfs-error-text-body">
                                <a class="wpfs-btn" href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html__( "Return to form", "wpfs" ); ?></a>
                            </div>
                        </div>
                        <?php
                    }
                }

            } else {
                //invalid nonce, show error message
                ?>
                <div class="section-inner">
                    <h3 class="wpfs-error-text-title">
                        <?php echo esc_html__( "Invalid Request. ", "wpfs" ); ?>
                    </h3>
                    <div class="wpfs-error-text-body">
                        <a class="wpfs-btn" href="<?php echo esc_url( get_permalink() ); ?>"><?php echo esc_html__( "Return to form", "wpfs" ); ?></a>
                    </div>
                </div>
                <?php
            }

            wp_footer();
            unset( $_POST["wpfs_submit"] );
            exit;
        }

    }

}

?>