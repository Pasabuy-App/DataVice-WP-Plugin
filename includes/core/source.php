<?php
	// Exit if accessed directly
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	/**
	 * @package datavice-wp-plugin
     * @version 0.1.0
     * This is where you provide all the constant config.
    */

    //Include source data for common category.
    include_once ( DV_PLUGIN_PATH . '/includes/source/common/config.php' );
    
    //Include source data for location category.
    include_once ( DV_PLUGIN_PATH . '/includes/source/location/countries.php' );
    include_once ( DV_PLUGIN_PATH. '/includes/source/location/cities.php' );
    include_once ( DV_PLUGIN_PATH . '/includes/source/location/provinces.php' );
    include_once ( DV_PLUGIN_PATH . '/includes/source/location/barangay.php' );
    include_once ( DV_PLUGIN_PATH . '/includes/source/location/timezone.php' );
