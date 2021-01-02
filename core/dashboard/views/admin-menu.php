<div class="container">
    <div class="row">
    <h3><?php echo esc_html__("All applications", "wpfa");?></h3>
    </div>
    <div class="row">
        <table>
            <th>
                <td>First Name</td>
                <td>Last Name</td>
                <td>Phone</td>
                <td>Address</td>
                <td>E-mail</td>
                <td>Post</td>
                <td>CV</td>
            </th>
            <?php
            global $wpdb;
            $all_applications = $wpdb->get_results("SELECT * FROM applicant_submissions", ARRAY_A);
            if( is_array( $all_applications ) && !empty( $all_applications )){
                foreach( $all_applications as $single_application){
                    ?>
                    <tr>
                        <td><?php echo esc_html($single_application["first_name"]);?></td>
                        <td><?php echo esc_html($single_application["last_name"]);?></td>
                        <td><?php echo esc_html($single_application["phone"]);?></td>
                        <td><?php echo esc_html($single_application["present_address"]);?></td>
                        <td><?php echo esc_html($single_application["email"]);?></td>
                        <td><?php echo esc_html($single_application["post_name"]);?></td>
                        <td><?php echo esc_html($single_application["cv_path"]);?></td>
                        
                    </tr>
                    <?php
                }
            }
            ?>
        </table>
    </div>
</div>