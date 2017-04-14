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

?>

<div class="wrap wcf-admin-options">
    <div id="icon-options-general" class="icon32"></div>
    <h2><?php _e('General Settings', WORDPRESS_CONTENT_FILTER_LANG) ?></h2>
    <form method="post" action="options.php">
        <?php settings_fields('wcf_settings_fields'); ?>
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row">
                        <label for="wcf_settings_options[color_scheme]"><?php echo __( 'Color Scheme', WORDPRESS_CONTENT_FILTER_LANG );?>: </label>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php echo __( 'Color Scheme', WORDPRESS_CONTENT_FILTER_LANG );?></span></legend>
                            <?php
                            $colors = wcf_get_colors();
                            $colors = array('' => __('None')) + $colors;

                            $colors_options = array(
                                'type' => 'select',
                                'name' => 'wcf_settings_options[color_scheme]',
                                'value' => $options['color_scheme'],
                                'options' => $colors,
//                                'label' => __( 'Color Scheme', WORDPRESS_CONTENT_FILTER_LANG ),
                                'class' => '',
                                'desc' => __('Choose skin for the plugin (default is dark)', WORDPRESS_CONTENT_FILTER_LANG),
                            );

                            wcf_forms_field($colors_options);
                            ?>

                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="wcf_settings_options[scroll_top]"><?php echo __( 'Scroll Top', WORDPRESS_CONTENT_FILTER_LANG );?>: </label>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php echo __( 'Scroll Top', WORDPRESS_CONTENT_FILTER_LANG );?></span></legend>
                            <?php

                            $scroll_options = array(
                                'type' => 'select',
                                'name' => 'wcf_settings_options[scroll_top]',
                                'value' => $options['scroll_top'],
                                'options' => array(
                                  'yes' => __('Yes', WORDPRESS_CONTENT_FILTER_LANG),
                                  'no' => __('No', WORDPRESS_CONTENT_FILTER_LANG),
                                ),
                                'class' => '',
                                'desc' => __('Scroll to top when the ajax done', WORDPRESS_CONTENT_FILTER_LANG),
                            );

                            wcf_forms_field($scroll_options);
                            ?>

                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="wcf_settings_options[ajax_loader]"><?php echo __( 'Ajax Loader', WORDPRESS_CONTENT_FILTER_LANG );?>: </label>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php echo __( 'Ajax Loader', WORDPRESS_CONTENT_FILTER_LANG );?></span></legend>

                            <div class="wcf-image-url-wrapper">
                                <input type="text" class="wcf-image-url" name="wcf_settings_options[ajax_loader]" id="wcf_settings_options_ajax_loader" value="<?php echo $options['ajax_loader'];?>"/>
                                <a href="#" class="button wcf-upload-image" data-field="wcf_settings_options_ajax_loader" title="<?php echo __('Add Media', WORDPRESS_CONTENT_FILTER_LANG);?>"><span class="wp-media-buttons-icon"></span> <?php echo __('Upload image', WORDPRESS_CONTENT_FILTER_LANG);?></a>
                            </div>
                            <span class="description"><?php echo __('Custom ajax loading image (.gif), leave blank for default', WORDPRESS_CONTENT_FILTER_LANG);?></span>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="wcf_settings_options[custom_css]"><?php echo __( 'Custom CSS', WORDPRESS_CONTENT_FILTER_LANG );?>: </label>
                    </th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text"><span><?php echo __( 'Custom CSS', WORDPRESS_CONTENT_FILTER_LANG );?></span></legend>

                            <?php

                            $scroll_options = array(
                                'type' => 'textarea',
                                'name' => 'wcf_settings_options[custom_css]',
                                'value' => esc_html($options['custom_css']),
                                'class' => '',
                                'desc' => __('Custom style for frontend', WORDPRESS_CONTENT_FILTER_LANG),
                            );

                            wcf_forms_field($scroll_options);
                            ?>

                        </fieldset>
                    </td>
                </tr>
            </tbody>
        </table>
        <p style="margin-top:20px;">
            <?php submit_button(); ?>
        </p>
    </form>

</div>
