<?php
	// Exit if accessed directly
	if ( ! defined( 'ABSPATH' ) ) {
		exit;
	}

	/**
        * @package datavice-wp-plugin
		* @version 0.1.0
		* This is the primary gateway of all the rest api request.
	*/

    class DV_Select_type_Address{
        public static function listen(){
			global $wpdb;

            // Step 1: Validate user
            if ( DV_Verification::is_verified() == false ) {
                return rest_ensure_response(
                    array(
                        "status" => "unknown",
                        "message" => "Please contact your administrator. Verification Issue!",
                    )
                );
            }


            // Step 2: Sanitize and validate all requests
			if ( !isset($_POST["address_type"]) ) {
				return rest_ensure_response(
					array(
						"status" => "unknown",
						"message" => "Please contact your administrator. Request Unknown!",
					)
                );

            }

            //Check if passed values are not null
            if ( empty($_POST["address_type"]) ) {
				return rest_ensure_response(
					array(
						"status" => "failed",
						"message" => "Please contact your administrator. Request Empty!",
					)
                );
            }

            //Check if type value is either 'home','office','business'.
			if (!($_POST['address_type'] === 'home')  && !($_POST['address_type'] === 'office') && !($_POST['address_type'] === 'business')) {
				return rest_ensure_response(
					array(
							"status" => "failed",
							"message" => "Invalid value for address type.",
					)
				);
			}

			$address_type = $_POST["address_type"];

			$dv_rev_table = DV_REVS_TABLE;
			$table_address = DV_ADDRESS_TABLE;
			$country_table = DV_COUNTRY_TABLE;
            $province_table = DV_PROVINCE_TABLE;
            $city_table = DV_CITY_TABLE;
            $brgy_table = DV_BRGY_TABLE;

            $result  = $wpdb->get_results("SELECT
					(SELECT dv_rev.child_val FROM $dv_rev_table dv_rev WHERE dv_rev.ID = dv_add.street ) as street,
					(SELECT $brgy_table.brgy_name FROM $brgy_table WHERE $brgy_table.ID = (SELECT dv_rev.child_val FROM $dv_rev_table dv_rev WHERE dv_rev.ID = dv_add.brgy ) ) as brgy,
					(SELECT $city_table.city_name FROM $city_table WHERE $city_table.city_code = (SELECT dv_rev.child_val FROM $dv_rev_table dv_rev WHERE dv_rev.ID = dv_add.city ) ) as city,
					(SELECT $province_table.prov_name FROM $province_table WHERE $province_table.prov_code = (SELECT dv_rev.child_val FROM $dv_rev_table dv_rev WHERE dv_rev.ID = dv_add.province ) ) as province,
					(SELECT $country_table.country_name FROM $country_table WHERE $country_table.ID = (SELECT dv_rev.child_val FROM $dv_rev_table dv_rev WHERE dv_rev.ID = dv_add.country ) ) as country
				FROM
					$table_address dv_add
				INNER JOIN $dv_rev_table dv_rev
					ON dv_rev.ID = dv_add.status
				WHERE (SELECT dv_rev.child_val FROM $dv_rev_table dv_rev WHERE dv_rev.ID = dv_add.status ) = 1 AND dv_add.types = '$address_type'"
			);

			if (!$result) {
                return rest_ensure_response(
                    array(
                        "status" => "failed",
                        "message" => "Address return empty."
                    )
                );
            } else {
                return rest_ensure_response(
					array(
						"status" => "success",
						"data" => $result
					)
				);
            }
		}
	}

