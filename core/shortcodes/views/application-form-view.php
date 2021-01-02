<div class="container">
    <div class="wpfa-contain">
        <div class="row">
            <div class="col-lg-6">
                <h3 class="wpfa-title"><?php echo esc_html__("Application Form", "wpfa");?></h3>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <form action="" enctype="multipart/form-data" method="post">
                    <?php wp_nonce_field( 'wpfa_nonce_field', 'wpfa_nonce_field' );?>
                    <input type='hidden' name='wpfa_action' value='wpfa_action' />
                    <div class="row">
                        <div class='form-group wpfa-application-field fname'>
                            <label for='wpfa-fname'><?php echo esc_html__('First Name', 'wpfa'); ?><small class='wpfa_required'>*</small></label>
                            <input type='text' name='wpfa_fname' id='wpfa-fname' class='wpfa-form-control' value='' required aria-required='true'>
                            <div class="wpfa-fname wpfa_danger_text"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class='form-group wpfa-application-field lname'>
                            <label for='wpfa-lname'><?php echo esc_html__('Last Name', 'wpfa'); ?><small class='wpfa_required'>*</small></label>
                            <input type='text' name='wpfa_lname' id='wpfa-lname' class='wpfa-form-control' value='' required aria-required='true'>
                            <div class="wpfa-lname wpfa_danger_text"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class='form-group wpfa-application-field lname'>
                            <label for='wpfa-address'><?php echo esc_html__('Present Address', 'wpfa'); ?><small class='wpfa_required'>*</small></label>
                            <input type='text' name='wpfa_address' id='wpfa-address' class='wpfa-form-control' value='' required aria-required='true'>
                            <div class="wpfa-address wpfa_danger_text"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class='form-group wpfa-application-field email'>
                            <label for='wpfa-email'><?php echo esc_html__('Email', 'wpfa'); ?><small class='wpfa_required'>*</small></label>
                            <input type='email' name='wpfa_email' class='wpfa-form-control' id='wpfa-email' value='' required aria-required='true'>
                            <div class="wpfa-email wpfa_danger_text"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class='form-group wpfa-application-field phone'>
                            <label for='wpfa-phone'><?php echo esc_html__('Phone', 'wpfa'); ?><small class='wpfa_required'>*</small></label>
                            <input type='text' name='wpfa_phone' class='wpfa-form-control' id='wpfa-phone' value='' required aria-required='true'>
                            <div class="wpfa-phone wpfa_danger_text"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class='form-group wpfa-application-field post'>
                            <label for='wpfa-post'><?php echo esc_html__('Post', 'wpfa'); ?><small class='wpfa_required'>*</small></label>
                            <input type='text' name='wpfa_post' class='wpfa-form-control' id='wpfa-post' value='' required aria-required='true'>
                            <div class="wpfa-post wpfa_danger_text"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class='form-group wpfa-application-field cv'>
                            <label for='wpfa-cv'><?php echo esc_html__('CV', 'wpfa'); ?><small class='wpfa_required'>*</small></label>
                            <input type='file' name='wpfa_cv' class='wpfa-form-control' id='wpfa-cv' value='' required aria-required='true'>
                            <div class="wpfa-cv wpfa_danger_text"></div>
                        </div>
                    </div>
                    <div class="row">
                        <button type='submit' class='application_form_submit wpfa-btn' name="wpfa_submit"><?php echo esc_html__( "Submit" , 'wpfa' ); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>