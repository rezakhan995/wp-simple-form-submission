<div class="container">
    <div class="wpfs-contain">
        <div class="row">
            <div class="col-lg-6">
                <h3 class="wpfs-title"><?php echo esc_html__("Application Form", "wpfs");?></h3>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <form action="" enctype="multipart/form-data" method="post">
                    <?php wp_nonce_field( 'wpfs_nonce_field', 'wpfs_nonce_field' );?>
                    <input type='hidden' name='wpfs_action' value='wpfs_action' />
                    <div class="row">
                        <div class='form-group wpfs-application-field fname'>
                            <label for='wpfs-fname'><?php echo esc_html__('First Name', 'wpfs'); ?><small class='wpfs_required'>*</small></label>
                            <input type='text' name='wpfs_fname' id='wpfs-fname' class='wpfs-form-control' value='' required aria-required='true'>
                            <div class="wpfs-fname wpfs_danger_text"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class='form-group wpfs-application-field lname'>
                            <label for='wpfs-lname'><?php echo esc_html__('Last Name', 'wpfs'); ?><small class='wpfs_required'>*</small></label>
                            <input type='text' name='wpfs_lname' id='wpfs-lname' class='wpfs-form-control' value='' required aria-required='true'>
                            <div class="wpfs-lname wpfs_danger_text"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class='form-group wpfs-application-field lname'>
                            <label for='wpfs-address'><?php echo esc_html__('Present Address', 'wpfs'); ?><small class='wpfs_required'>*</small></label>
                            <input type='text' name='wpfs_address' id='wpfs-address' class='wpfs-form-control' value='' required aria-required='true'>
                            <div class="wpfs-address wpfs_danger_text"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class='form-group wpfs-application-field email'>
                            <label for='wpfs-email'><?php echo esc_html__('Email', 'wpfs'); ?><small class='wpfs_required'>*</small></label>
                            <input type='email' name='wpfs_email' class='wpfs-form-control' id='wpfs-email' value='' required aria-required='true'>
                            <div class="wpfs-email wpfs_danger_text"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class='form-group wpfs-application-field phone'>
                            <label for='wpfs-phone'><?php echo esc_html__('Phone', 'wpfs'); ?><small class='wpfs_required'>*</small></label>
                            <input type='text' name='wpfs_phone' class='wpfs-form-control' id='wpfs-phone' value='' required aria-required='true'>
                            <div class="wpfs-phone wpfs_danger_text"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class='form-group wpfs-application-field post'>
                            <label for='wpfs-post'><?php echo esc_html__('Post', 'wpfs'); ?><small class='wpfs_required'>*</small></label>
                            <input type='text' name='wpfs_post' class='wpfs-form-control' id='wpfs-post' value='' required aria-required='true'>
                            <div class="wpfs-post wpfs_danger_text"></div>
                        </div>
                    </div>
                    <div class="row">
                        <div class='form-group wpfs-application-field cv'>
                            <label for='wpfs-cv'><?php echo esc_html__('CV', 'wpfs'); ?><small class='wpfs_required'>*</small></label>
                            <input type='file' name='wpfs_cv' class='wpfs-form-control' id='wpfs-cv' value='' required aria-required='true'>
                            <div class="wpfs-cv wpfs_danger_text"></div>
                        </div>
                    </div>
                    <div class="row">
                        <button type='submit' class='application_form_submit wpfs-btn' name="wpfs_submit"><?php echo esc_html__( "Submit" , 'wpfs' ); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>