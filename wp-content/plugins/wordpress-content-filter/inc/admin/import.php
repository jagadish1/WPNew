<?php
/**
 * @version    $Id$
 * @package    WordPress Content Filter
 * @author     ZuFusion
 * @copyright  Copyright (C) 2015 ZuFusion All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */

if (!current_user_can('manage_options')) {
    wp_die('You do not have sufficient permissions to access this page.');
}


$options = wcf_get_options();
$current_url = admin_url('/edit.php?') . $_SERVER['QUERY_STRING'];
?>

<div class="wrap wcf-import-page">
    <div id="icon-options-general" class="icon32"></div>
    <h2><?php _e('Import Search Form', WORDPRESS_CONTENT_FILTER_LANG) ?></h2>
    <?php
    if (isset($_GET['wcf_action'])) { ?>
        <div class="updated">
            <p><?php echo __('Import form successfully', WORDPRESS_CONTENT_FILTER_LANG);?></p>
        </div>
        <p><?php echo __('Done', WORDPRESS_CONTENT_FILTER_LANG)?> <a href="<?php echo admin_url('/edit.php?post_type=zf-wcf');?>"><?php echo __('View Forms', WORDPRESS_CONTENT_FILTER_LANG);?></a></p>
        <?php
        return;
    }
    ?>
    <p><?php echo __('Upload a WCF file to import the form into the plugin. Choose a .wcf file to upload, then click "Import".', WORDPRESS_CONTENT_FILTER_LANG)?></p>

    <form method="post" action="<?php echo $current_url . '&wcf_action=import';?>" enctype="multipart/form-data">

        <?php wp_nonce_field( 'wcf_import', 'wcf_import_nonce' ); ?>

        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="import_file"><?php echo __( 'Import', WORDPRESS_CONTENT_FILTER_LANG );?>: </label>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php echo __( 'Import', WORDPRESS_CONTENT_FILTER_LANG );?></span></legend>
                            <input type="file" name="import_file" id="import_file" />
                            <br/>
                            <span class="description"><?php echo __('Upload a file to import search form')?></span>
                        </fieldset>
                    </td>
                </tr>


            </tbody>
        </table>
        <p style="margin-top:20px;">
            <?php submit_button(_x( 'Import', 'button', WORDPRESS_CONTENT_FILTER_LANG ) ); ?>
        </p>
    </form>

</div>
