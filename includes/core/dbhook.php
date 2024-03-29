<?php
	// Exit if accessed directly
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	/**
	 * @package datavice-wp-plugin
     * @version 0.1.0
     * Here is where you add hook to WP to create our custom database if not found.
	*/

	function dv_dbhook_activate(){

		// Initialized WordPress core.
		global $wpdb;

		//Passing from global defined variable to local variable
		$tbl_configs = DV_CONFIG_TABLE;
		$tbl_contacts = DV_CONTACTS_TABLE;
		$tbl_address = DV_ADDRESS_TABLE;
		$tbl_events = DV_EVENTS_TABLE;
		$tbl_configs = DV_CONFIG_TABLE;
		$tbl_docu = DV_DOCUMENTS;
		$tbl_link_acc = DV_LINK_ACCOUNT;
		$tbl_error_log = DV_ERROR_LOG;
		$tbl_users = DV_USERS;
		$tbl_address_view = DV_ADDRESS_VIEW;

		$wpdb->query("START TRANSACTION ");

		$get_last_pocket = $wpdb->get_row(" SHOW VARIABLES LIKE 'max_allowed_packet'; ");

		$wpdb->query("SET GLOBAL max_allowed_packet=12582912;");

		if($wpdb->get_var( "SHOW TABLES LIKE '$tbl_configs'" ) != $tbl_configs) {
			$sql = "CREATE TABLE `".$tbl_configs."` (";
				$sql .= "`ID` bigint(20) NOT NULL AUTO_INCREMENT, ";
				$sql .= "`hash_id` varchar(255) NOT NULL , ";
				$sql .= "`title` varchar(255) NOT NULL, ";
				$sql .= "`info` varchar(255) NOT NULL, ";
				$sql .= "`config_key` varchar(50) NOT NULL,";
				$sql .= "`config_val` varchar(120) NOT NULL, ";
				$sql .= "PRIMARY KEY (`ID`) ";
				$sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; ";
			$result = $wpdb->get_results($sql);

			//Pass the globally defined constant to a variable
			$conf_list = DV_CONFIG_DATA;
			$wpdb->query("CREATE INDEX `config_key` ON $tbl_configs (`config_key`);");
			$wpdb->query("CREATE INDEX `title` ON $tbl_configs (`title`);");

			//Dumping data into tables(title, info, config_key, config_val,  hash_id) ($conf_fields, hash_id)
			$wpdb->query("INSERT INTO `".$tbl_configs."` (title, info, config_key, config_val,  hash_id) VALUES $conf_list");
		}

		// Database table creation for dv_address - QA: 01/08/2020
		if($wpdb->get_var( "SHOW TABLES LIKE '$tbl_address'" ) != $tbl_address) {
			$sql = "CREATE TABLE `".$tbl_address."` (";
				$sql .= "`ID` bigint(20) NOT NULL AUTO_INCREMENT, ";
				$sql .= "`hash_id` varchar(255) NOT NULL , ";
				$sql .= " `status` enum('active', 'inactive') NOT NULL  COMMENT 'Status of this Address.', ";
				$sql .= "`wpid` bigint(20) NOT NULL DEFAULT 0 COMMENT 'User ID, 0 if Null', ";
				$sql .= "`stid` varchar(150) NOT NULL DEFAULT 0 COMMENT 'Store ID, 0 if Null', ";
				$sql .= "`types` enum('none','home','office','business') NOT NULL DEFAULT 'none' COMMENT 'Group', ";
				$sql .= "`street` varchar(150) NOT NULL DEFAULT 0 COMMENT 'Street address from Revs, 0 if Null', ";
				$sql .= "`brgy` bigint(20) NOT NULL DEFAULT 0 COMMENT 'Barangay code from Revs, 0 if Null', ";
				$sql .= "`city` bigint(20) NOT NULL DEFAULT 0 COMMENT 'CityMun code from Revs, 0 if Null', ";
				$sql .= "`province` bigint(20) NOT NULL DEFAULT 0 COMMENT 'Province code from Revs, 0 if Null', ";
				$sql .= "`country` varchar(10) NOT NULL DEFAULT 0 COMMENT 'Country code from Revs, 0 if Null', ";
				$sql .= "`latitude` DECIMAL(10, 8) NOT NULL DEFAULT 0 COMMENT 'Latitude id from Revs, 0 if Null', ";
				$sql .= "`longitude` DECIMAL(11, 8) NOT NULL DEFAULT 0 COMMENT 'Longitude id from Revs, 0 if Null', ";
				$sql .= "`img_url` varchar(150) NOT NULL DEFAULT 0 COMMENT 'Url id from Revs, 0 if Null', ";
				$sql .= "`date_created` datetime DEFAULT current_timestamp() NULL COMMENT 'Date created', ";
				$sql .= "PRIMARY KEY (`ID`) ";
				$sql .= ") ENGINE = InnoDB; ";
			$result = $wpdb->get_results($sql);
			$wpdb->query("CREATE INDEX `status` ON $tbl_address (`status`);");
			$wpdb->query("CREATE INDEX `wpid` ON $tbl_address (`wpid`);");
			$wpdb->query("CREATE INDEX `stid` ON $tbl_address (`stid`);");
			$wpdb->query("CREATE INDEX `brgy` ON $tbl_address (`brgy`);");
			$wpdb->query("CREATE INDEX `city` ON $tbl_address (`city`);");
			$wpdb->query("CREATE INDEX `province` ON $tbl_address (`province`);");
			$wpdb->query("CREATE INDEX `country` ON $tbl_address (`country`);");

		}

		/* //Database table creation for plugin_config
		if($wpdb->get_var( "SHOW TABLES LIKE '$tbl_docu'" ) != $tbl_docu) {
			$sql = "CREATE TABLE `".$tbl_docu."` (";
				$sql .= "`ID` bigint(20) NOT NULL AUTO_INCREMENT, ";
				$sql .= "`hash_id` varchar(255) NOT NULL COMMENT 'Hash of id.', ";
				$sql .= "`wpid` bigint(20) NOT NULL DEFAULT 0 COMMENT 'Store ID of Merchant', ";
				$sql .= "`` bigint(20) NOT NULL COMMENT 'Image url of document', ";
				$sql .= "`date_created` datetime DEFAULT current_timestamp() COMMENT 'Date document was created', ";
				$sql .= "PRIMARY KEY (`ID`) ";
				$sql .= ") ENGINE = InnoDB; ";
			$result = $wpdb->get_results($sql);
		} */

		//Database table creation for mover documents
		if($wpdb->get_var( "SHOW TABLES LIKE '$tbl_docu'" ) != $tbl_docu) {
			$sql = "CREATE TABLE `".$tbl_docu."` (";
				$sql .= " `ID` bigint(20) NOT NULL AUTO_INCREMENT, ";
				$sql .= " `hash_id` varchar(255) NOT NULL COMMENT 'This column is used for table realtionship' , ";
				$sql .= " `wpid` varchar(255) NOT NULL COMMENT 'User documents', ";
				$sql .= " `preview` bigint(20) NOT NULL COMMENT 'preview of this docuemtns', ";
				$sql .= " `types`  enum('id', 'face') NOT NULL COMMENT 'types of documents', ";
				$sql .= " `status` enum('active', 'inactive') NOT NULL COMMENT 'Status of documents', ";
				$sql .= " `id_number` int(50) COMMENT 'ID nunmber for this user', ";
				$sql .= " `instructions` varchar(255) COMMENT 'Instruction of this documents', ";
				$sql .= " `comments` varchar(255) COMMENT 'Comments for this documents', ";
				$sql .= " `executed_by` bigint(20)  COMMENT 'approved by', ";
				$sql .= " `doctype` varchar(150)  COMMENT 'parent of this document', ";
				$sql .= " `parent_id` bigint(20)  COMMENT 'parent of this document', ";
				$sql .= " `activated` enum('false', 'true') NOT NULL COMMENT 'Status of this mover if approved or not', ";
				$sql .= " `date_created` datetime NOT NULL DEFAULT current_timestamp(), ";
				$sql .= "PRIMARY KEY (`ID`) ";
				$sql .= ") ENGINE = InnoDB; ";
			$result = $wpdb->get_results($sql);

			$wpdb->query("CREATE INDEX hash_id ON $tbl_docu (hash_id);");
			$wpdb->query("CREATE INDEX wpid ON $tbl_docu (wpid);");
		}

		// Database table creation for dv_contacts - QA: 01/08/2020
		if($wpdb->get_var( "SHOW TABLES LIKE '$tbl_contacts'" ) != $tbl_contacts) {
			$sql = "CREATE TABLE `".$tbl_contacts."` (";
				$sql .= "`ID` bigint(20) NOT NULL AUTO_INCREMENT, ";
				$sql .= "`hash_id` varchar(255) NOT NULL , ";
				$sql .= "`status` enum('active', 'inactive') NOT NULL COMMENT 'Live/Hiden', ";
				$sql .= "`adid` varchar(150) NOT NULL DEFAULT 0 COMMENT 'Address id for this contact', ";
				$sql .= "`value` varchar(80) NOT NULL DEFAULT 0 COMMENT 'Value of this contact', ";
				$sql .= "`contact_person` varchar(80) NOT NULL DEFAULT 0 COMMENT 'Value of this contact', ";
				$sql .= "`contact_type` varchar(80) NOT NULL DEFAULT 0 COMMENT 'Value of this contact', ";
				$sql .= "`created_by` bigint(20) NOT NULL, ";
				$sql .= "`date_created` datetime NOT NULL DEFAULT current_timestamp() , ";
				$sql .= "PRIMARY KEY (`ID`) ";
				$sql .= ") ENGINE = InnoDB; ";
			$result = $wpdb->get_results($sql);

			$wpdb->query("CREATE INDEX `adid` ON $tbl_contacts (`adid`);");
			$wpdb->query("CREATE INDEX `status` ON $tbl_contacts (`status`);");

		}

		//Database table creation for dv_geo_countries - QA: 01/08/2020
		$tbl_countries = DV_COUNTRY_TABLE;

		if($wpdb->get_var( "SHOW TABLES LIKE '$tbl_countries'" ) != $tbl_countries) {
			$sql = "CREATE TABLE `".$tbl_countries."` (";
				$sql .= "`ID` bigint(20) NOT NULL AUTO_INCREMENT, ";
				$sql .= "`status` bigint(20) NOT NULL DEFAULT 0, ";
				$sql .= "`country_code` varchar(2) NOT NULL DEFAULT '', ";
				$sql .= "`country_name` varchar(100) NOT NULL DEFAULT '', ";
				$sql .= "PRIMARY KEY (`ID`) ";
				$sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; ";
			$result = $wpdb->get_results($sql);

			//Pass the globally defined constant to a variable
			$ctry_data = DV_COUNTRY_DATA;
			$ctry_fields = DV_COUNTRY_FIELD;

			$wpdb->query("CREATE INDEX `country_code` ON $tbl_countries (`country_code`);");
			$wpdb->query("CREATE INDEX `status` ON $tbl_countries (`status`);");

			//Dumping data into tables
			$wpdb->query("INSERT INTO `".$tbl_countries."` $ctry_fields VALUES $ctry_data");
		}

		//Database table creation for dv_geo_provinces - QA: 01/08/2020
		$tbl_province = DV_PROVINCE_TABLE;

		if($wpdb->get_var( "SHOW TABLES LIKE '$tbl_province'" ) != $tbl_province) {
			$sql = "CREATE TABLE `".$tbl_province."` (";
				$sql .= "`ID` bigint(20) NOT NULL AUTO_INCREMENT, ";
				$sql .= "`status` bigint(20) NOT NULL DEFAULT 0, ";
				$sql .= "`country_code` varchar(2) DEFAULT NULL, ";
				$sql .= "`prov_code` varchar(10) DEFAULT NULL, ";
				$sql .= "`prov_name` varchar(100) DEFAULT NULL, ";
				$sql .= "PRIMARY KEY (`ID`) ";
				$sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; ";
			$result = $wpdb->get_results($sql);

			$wpdb->query("CREATE INDEX `status` ON $tbl_province (`status`);");
			$wpdb->query("CREATE INDEX `country_code` ON $tbl_province (`country_code`);");
			$wpdb->query("CREATE INDEX `prov_code` ON $tbl_province (`prov_code`);");

			//Pass the globally defined constant to a variable
			$prov_list = DV_PROVINCE_DATA;
			$prov_fields = DV_PROVINCE_FIELD;

			//Dumping data into tables
			$wpdb->query("INSERT INTO `".$tbl_province."` $prov_fields VALUES $prov_list");
		}

		//Database table creation for dv_geo_cities - QA: 01/08/2020
		$tbl_city = DV_CITY_TABLE;

		if($wpdb->get_var( "SHOW TABLES LIKE '$tbl_city'" ) != $tbl_city) {
			$sql = "CREATE TABLE `".$tbl_city."` (";
				$sql .= "`ID` bigint(20) NOT NULL AUTO_INCREMENT, ";
				$sql .= "`status` bigint(20) NOT NULL DEFAULT 0, ";
				$sql .= "`prov_code` varchar(10) DEFAULT NULL,";
				$sql .= "`city_code` varchar(10) DEFAULT NULL, ";
				$sql .= "`city_name` varchar(100) DEFAULT NULL, ";
				$sql .= "PRIMARY KEY (`ID`) ";
				$sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; ";
			$result = $wpdb->get_results($sql);

			//Pass the globally defined constant to a variable
			$cty_list = DV_CITY_DATA;
			$cty_fields = DV_CITY_FIELD;

			$wpdb->query("CREATE INDEX `status` ON $tbl_city (`status`);");
			$wpdb->query("CREATE INDEX `prov_code` ON $tbl_city (`prov_code`);");
			$wpdb->query("CREATE INDEX `city_code` ON $tbl_city (`city_code`);");

			//Dumping data into tables
			$wpdb->query("INSERT INTO `".$tbl_city."` $cty_fields VALUES $cty_list");
		}

		//Database table creation for dv_geo_brgys - QA: 01/08/2020
		$tbl_brgy = DV_BRGY_TABLE;

		if($wpdb->get_var( "SHOW TABLES LIKE '$tbl_brgy'" ) != $tbl_brgy) {
			$sql = "CREATE TABLE `".$tbl_brgy."` (";
				$sql .= "`ID` bigint(20) NOT NULL AUTO_INCREMENT, ";
				$sql .= "`status` bigint(20) NOT NULL DEFAULT 1, ";
				$sql .= "`city_code` varchar(10) DEFAULT NULL, ";
				$sql .= "`brgy_name` varchar(100) DEFAULT NULL, ";
				$sql .= "PRIMARY KEY (`ID`) ";
				$sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; ";
			$result = $wpdb->get_results($sql);

			//Pass the globally defined constant to a variable
			$brgy_data = DV_BRGY_DATA;
			$brgy_field = DV_BRGY_FIELD;

			$wpdb->query("CREATE INDEX `status` ON $tbl_brgy (`status`);");
			$wpdb->query("CREATE INDEX `city_code` ON $tbl_brgy (`city_code`);");

			//Dumping data into tables
			$wpdb->query("INSERT INTO `".$tbl_brgy."` $brgy_field VALUES $brgy_data");
		}

		//Database table creation for dv_geo_timezone
		$tbl_timezone = DV_TZ_TABLE;

		if($wpdb->get_var( "SHOW TABLES LIKE '$tbl_timezone'" ) != $tbl_timezone) {
			$sql = "CREATE TABLE `".$tbl_timezone."` (";
				$sql .= "`ID` bigint(20) NOT NULL AUTO_INCREMENT, ";
				$sql .= "`country_code` varchar(2) NOT NULL, ";
				$sql .= "`tzone_name` varchar(50) NOT NULL, ";
				$sql .= "`utc_offset` varchar(10) NULL, ";
				$sql .= "`utc_dst_offset` varchar(10) NULL, ";
				$sql .= "PRIMARY KEY (`ID`) ";
				$sql .= ") ENGINE=InnoDB DEFAULT CHARSET=utf8mb4; ";
			$result = $wpdb->get_results($sql);

			//Pass the globally defined constant to a variable
			$tz_data = DV_TZ_DATA;
			$tz_field = DV_TZ_FIELD;

			//Dumping data into tables
			$wpdb->query("INSERT INTO `".$tbl_timezone."` $tz_field VALUES $tz_data");

			$wpdb->query("CREATE INDEX `country_code` ON $tbl_timezone (`country_code`);");

		}

		//Database table creation for dv_events
		if($wpdb->get_var( "SHOW TABLES LIKE '$tbl_events'" ) != $tbl_events) {
			$sql = "CREATE TABLE `".$tbl_events."` (";
				$sql .= "`ID` bigint(20) NOT NULL AUTO_INCREMENT, ";
				$sql .= "`wpid` bigint(20) NOT NULL DEFAULT 0 COMMENT 'User id of the owner of this event',";
				$sql .= "`keys` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Key of the event', ";
				$sql .= "`info` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT 'Additional Information on the event', ";
				$sql .= "`date_created` datetime DEFAULT current_timestamp() COMMENT 'The date this event is created.', ";
				$sql .= "PRIMARY KEY (`ID`) ";
				$sql .= ") ENGINE = InnoDB; ";
			$result = $wpdb->get_results($sql);

			$wpdb->query("CREATE INDEX `wpid` ON $tbl_events (`wpid`);");
			$wpdb->query("CREATE INDEX `keys` ON $tbl_events (`keys`);");

		}

		//Database table creation for link ACCOUNT
		if($wpdb->get_var( "SHOW TABLES LIKE '$tbl_link_acc'" ) != $tbl_link_acc) {
			$sql = "CREATE TABLE `".$tbl_link_acc."` (";
				$sql .= " `ID` bigint(20) NOT NULL AUTO_INCREMENT, ";
				$sql .= " `hash_id` bigint(20) NOT NULL DEFAULT 0 COMMENT 'User id of the owner of this event',";
				$sql .= " `wpid` bigint(20) NOT NULL,";
				$sql .= " `platform` enum('facebook','google') NOT NULL, ";
				$sql .= " `token` varchar(255) NOT NULL, ";
				$sql .= " `status` enum('1','0') DEFAULT '1' NOT NULL, ";
				$sql .= " `date_created` datetime NOT NULL DEFAULT current_timestamp(),";
				$sql .= "PRIMARY KEY (`ID`) ";
				$sql .= ") ENGINE = InnoDB; ";
			$result = $wpdb->get_results($sql);

			$wpdb->query("CREATE INDEX `wpid` ON $tbl_link_acc (`wpid`);");
			$wpdb->query("CREATE INDEX `platform` ON $tbl_link_acc (`platform`);");

		}

		//Database table creation for error log
		if($wpdb->get_var( "SHOW TABLES LIKE '$tbl_error_log'" ) != $tbl_error_log) {
			$sql = "CREATE TABLE `".$tbl_error_log."` (";
				$sql .= "  `ID` bigint(20) NOT NULL AUTO_INCREMENT, ";
				$sql .= "  `hash_id` varchar(255) NOT NULL DEFAULT 0 COMMENT 'User id of the owner of this event',";
				$sql .= "  `platform` varchar(50) NOT NULL, ";
				$sql .= "  `device_ip` varchar(50) NOT NULL, ";
				$sql .= "  `public_ip` varchar(50) NOT NULL, ";
				$sql .= "  `error_key` varchar(255) DEFAULT NULL, ";
				$sql .= "  `error_code` varchar(255) DEFAULT NULL, ";
				$sql .= "  `status` tinyint(2) NOT NULL, ";
				$sql .= "  `date_created` datetime NOT NULL DEFAULT current_timestamp(),";
				$sql .= "PRIMARY KEY (`ID`) ";
				$sql .= ") ENGINE = InnoDB; ";
			$result = $wpdb->get_results($sql);

			$wpdb->query("CREATE INDEX `platform` ON $tbl_error_log (`platform`);");
			$wpdb->query("CREATE INDEX `device_ip` ON $tbl_error_log (`device_ip`);");

		}


		//Database table creation for dv_events
		if($wpdb->get_var( "SHOW TABLES LIKE '$tbl_users'" ) != $tbl_users) {
			$sql = "CREATE TABLE `".$tbl_users."` (";
				$sql .= "`ID` bigint(20) NOT NULL AUTO_INCREMENT, ";
				$sql .= "`hash_id` varchar(255) NOT NULL DEFAULT 0 COMMENT 'Hash id of user',";
				$sql .= "`wpid` bigint(20) NOT NULL DEFAULT 0 COMMENT 'User id of the owner of this event',";
				$sql .= "`date_created` datetime DEFAULT current_timestamp() COMMENT 'The date this event is created.', ";
				$sql .= "PRIMARY KEY (`ID`) ";
				$sql .= ") ENGINE = InnoDB; ";
			$result = $wpdb->get_results($sql);

			$wpdb->query("CREATE INDEX `wpid` ON $tbl_users (`wpid`);");

		}

		// Store View
		// if($wpdb->get_var( "SHOW CREATE VIEW $tbl_address_view" ) != $tbl_address_view) {
		// 	$sql = "CREATE ALGORITHM=UNDEFINED  VIEW  `".$tbl_address_view."` AS SELECT";
		// 		$sql .= "  `add`.ID,
		// 			`add`.stid,
		// 			`add`.wpid,
		// 			IF(`add`.types = 'business', 'Business', 'Office' )as `type`,
		// 			( SELECT child_val FROM dv_revisions WHERE id = `add`.street ) AS street,
		// 			( SELECT child_val FROM dv_revisions WHERE id = `add`.latitude ) AS latitude,
		// 			( SELECT child_val FROM dv_revisions WHERE id = `add`.longitude ) AS longitude,
		// 			( SELECT brgy_name FROM dv_geo_brgys WHERE ID = ( SELECT child_val FROM dv_revisions WHERE id = `add`.brgy ) ) AS brgy,
		// 			( SELECT city_name FROM dv_geo_cities WHERE city_code = ( SELECT child_val FROM dv_revisions WHERE id = `add`.city ) ) AS city,
		// 			( SELECT prov_name FROM dv_geo_provinces WHERE prov_code = ( SELECT child_val FROM dv_revisions WHERE id = `add`.province ) ) AS province,
		// 			( SELECT country_name FROM dv_geo_countries WHERE id = ( SELECT child_val FROM dv_revisions WHERE id = `add`.country ) ) AS country,
		// 			IF (( select child_val from dv_revisions where id = `add`.`status` ) = 1, 'Active' , 'Inactive' ) AS `status`,
		// 			`add`.date_created
		// 		FROM
		// 			dv_address `add`";
		// 	$result = $wpdb->get_results($sql);

		// 	$wpdb->query("CREATE INDEX `stid` ON $tbl_address_view (`stid`);");
		// 	$wpdb->query("CREATE INDEX `wpid` ON $tbl_address_view (`wpid`);");

		// }


		$wpdb->query("SET GLOBAL max_allowed_packet=$get_last_pocket->value;");

		$wpdb->query("COMMIT");
	}
    add_action( 'activated_plugin', 'dv_dbhook_activate' );