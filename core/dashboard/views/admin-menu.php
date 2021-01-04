<div class="container <?php  echo ( !$dashboard_widget ) ? "wpfs_widget" : ""; ?> ">
    <?php
    if( !$dashboard_widget ){
        ?>
        <div class="row wpfs-row wpfs-haeading">
            <div class="wpfs-admin-page-title">
                <h3><?php echo esc_html__( "All Applications", "wpfs" ); ?></h3>
            </div>
            <div class="wpfs-admin-page-search">
                <form method="post" action="#">
                    <input type="text" name="search" />
                    <input type="submit" class="wpfs-btn" name="submit" value="submit"/>
                </form>
            </div>
        </div>
        <hr>
        <?php
    }
    ?>
    <div class="row wpfs-row">
        <table class="wpfs-admin-table <?php  echo ( !$dashboard_widget ) ? "wpfs-page-table" : ""; ?>">
            <tr>
                <th class="wpfs-admin-table-head"><?php echo esc_html__("First Name", "wpfs");?></th>
                <?php if(!$dashboard_widget){?><th class="wpfs-admin-table-head"><?php echo esc_html__("Last Name", "wpfs");?></th><?php } ?>
                <th class="wpfs-admin-table-head"><?php echo esc_html__("Phone", "wpfs");?></th>
                <?php if(!$dashboard_widget){?><th class="wpfs-admin-table-head">Address</th><?php } ?>
                <th class="wpfs-admin-table-head"><?php echo esc_html__("E-mail", "wpfs");?></th>
                <?php if(!$dashboard_widget){?><th class="wpfs-admin-table-head"><?php echo esc_html__("Post", "wpfs");?></th><?php } ?>
                <?php if(!$dashboard_widget){?><th class="wpfs-admin-table-head"><?php echo esc_html__("CV", "wpfs");?></th><?php } ?>
            </tr>
            <?php
            if ( is_array( $all_applications ) && !empty( $all_applications ) ) {

                foreach ( $all_applications as $single_application ) {
                    ?>
                    <tr >
                        <td class="wpfs-admin-table-data"><?php echo esc_html( $single_application["first_name"] ); ?></td>
                        <?php if(!$dashboard_widget){?><td class="wpfs-admin-table-data"><?php echo esc_html( $single_application["last_name"] ); ?></td><?php } ?>
                        <td class="wpfs-admin-table-data"><?php echo esc_html( $single_application["phone"] ); ?></td>
                        <?php if(!$dashboard_widget){?><td class="wpfs-admin-table-data"><?php echo esc_html( $single_application["present_address"] ); ?></td><?php } ?>
                        <td class="wpfs-admin-table-data"><?php echo esc_html( $single_application["email"] ); ?></td>
                        <?php if(!$dashboard_widget){?><td class="wpfs-admin-table-data"><?php echo esc_html( $single_application["post_name"] ); ?></td><?php } ?>
                        <?php if(!$dashboard_widget){?><td class="wpfs-admin-table-data"><?php if( !empty( $single_application["cv_path"]) ){?><a class="wpfs-btn" href="<?php echo esc_url( $single_application["cv_path"] ); ?>" download><?php echo esc_html__( "Download", "wpfs" ); ?> </a> <?php } ?></td><?php } ?>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>
    </div>
</div>