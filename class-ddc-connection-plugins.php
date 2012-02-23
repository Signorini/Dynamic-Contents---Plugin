<?php

class ddc_plugins {
    private static $label = array('title' => '', 'descripition' => '');

    public static function get_content_meta($postid, $field) {
        $sucess = self::check_active_plugin();
        $key = self::$label[$field];
        if ($sucess) {
            $dd = get_post_meta($postid, $key, true);
            if (!empty($dd)) {
                return $dd;
            }
        }

        return false;
    }

    private static function check_active_plugin() {
        self::get_plugins();
        
        if (is_plugin_active('wordpress-seo/wp-seo.php')) {
            self::$label['title'] = '_yoast_wpseo_title';
            self::$label['description'] = '_yoast_wpseo_metadesc';
            return true;
        }

        if (is_plugin_active('all-in-one-seo-pack/all_in_one_seo_pack.php')) {
            self::$label['title'] = '_aioseop_title';
            self::$label['description'] = '_aioseop_description';
            return true;
        }

        if (is_plugin_active('seo-ultimate/seo-ultimate.php')) {
            self::$label['title'] = '_su_title';
            self::$label['description'] = '_su_description';
            return true;
        }

        return false;
    }

    private static function get_plugins() {
        if (!function_exists('is_plugin_active')) {
            include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        }
    }

}
