<?php
	// Exit if accessed directly
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	/**
	 * @package datavice-wp-plugin
     * @version 0.1.0
     * Config related class and function
    */

    class DV_Library_Config {

        public static function dv_get_config($key, $default){
            
            global $wpdb; 
            $tbl_config = DV_CONFIG_TABLE;
            
            $result = $wpdb->get_row("SELECT config_value FROM {$tbl_config} WHERE config_key = '$key'");

            if (!$result) {
                return $default;
            } else {
                return $result->config_value;
            }
        }

        public static function dv_set_config($title, $info, $key, $value){
            
            global $wpdb; 
            $tbl_config = DV_CONFIG_TABLE;
            
            $result = $wpdb->query("INSERT INTO {$tbl_config} (`title`, `info`, `config_key`, `config_value`) VALUES ('$title', '$info', '$key', '$value');");

            if (!$result) {
                return false;
            } else {
                return true;
            }
        }

        public static function dv_update_config($key, $value){
            
            global $wpdb; 
            $tbl_config = DV_CONFIG_TABLE;
            
            $result = $wpdb->query("UPDATE {$tbl_config} SET `config_key`='$key', `config_value`='$value';");

            if (!$result) {
                return false;
            } else {
                return true;
            }
        }

    }
