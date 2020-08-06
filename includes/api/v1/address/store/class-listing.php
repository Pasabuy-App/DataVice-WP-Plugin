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
?>
<?php
    class DV_Select_All_Store_Address{
        public static function listen(){
			global $wpdb;
			
            // Step 1: Validate user
            if ( DV_Verification::is_verified() == false ) {
                return rest_ensure_response( 
                    array(
                        "status" => "unknown",
                        "message" => "Please contact your administrator. Request Unknown!",
                    )
                );
            }


            // Step 2: Sanitize and validate all requests
			if (!isset($_POST["wpid"]) || !isset($_POST["snky"]) || !isset($_POST['stid'])) {
				return rest_ensure_response( 
					array(
						"status" => "unknown",
						"message" => "Please contact your administrator. Request unknown!",
					)
                );
                
            }
            
            //Check if passed values are not null
            if (empty($_POST["wpid"]) || empty($_POST["snky"]) || empty($_POST['stid'])) {
				return rest_ensure_response( 
					array(
						"status" => "failed",
						"message" => "Required fields cannot be empty.",
					)
                );
                
            }

            //Check if ID is in valid format (integer)
			if (!is_numeric($_POST["wpid"]) || !is_numeric($_POST['stid']) ) {
				return rest_ensure_response( 
					array(
						"status" => "failed",
						"message" => "Please contact your administrator. Id not in valid format!",
					)
                );
                
            }
            

            $stid = $_POST['stid'];
            $get_contact = $wpdb->get_row("SELECT ID FROM tp_stores  WHERE ID = $stid ");
            
            //Check if this store id exists
             if ( !$get_contact ) {
                return rest_ensure_response( 
                    array(
                        "status" => "error",
                        "message" => "An error occurred while fetching data to the server.",
                    )
                );
            }

			// Check if ID exists
			if (!get_user_by("ID", $_POST['wpid'])) {
				return rest_ensure_response( 
					array(
						"status" => "failed",
						"message" => "User not found!",
					)
                );
                
			}
			$dv_rev_table = DV_REVS_TABLE;
			$table_address = DV_ADDRESS_TABLE;

            $user = DV_Select_All_Store_Address::catch_post();

            $result  = $wpdb->get_results("SELECT
					dv_add.ID,
					dv_add.types,
					dv_rev.child_val as `status`,
					(SELECT dv_rev.child_val FROM $dv_rev_table dv_rev WHERE dv_rev.ID = dv_add.street ) as street,
					(SELECT dv_rev.child_val FROM $dv_rev_table dv_rev WHERE dv_rev.ID = dv_add.street ) as street,
					(SELECT dv_geo_brgys.brgy_name FROM dv_geo_brgys WHERE dv_geo_brgys.ID = (SELECT dv_rev.child_val FROM $dv_rev_table dv_rev WHERE dv_rev.ID = dv_add.brgy ) ) as brgy,
					(SELECT dv_geo_cities.city_name FROM dv_geo_cities WHERE dv_geo_cities.ID = (SELECT dv_rev.child_val FROM $dv_rev_table dv_rev WHERE dv_rev.ID = dv_add.city ) ) as city,
					(SELECT dv_geo_provinces.prov_name FROM dv_geo_provinces WHERE dv_geo_provinces.ID = (SELECT dv_rev.child_val FROM $dv_rev_table dv_rev WHERE dv_rev.ID = dv_add.city ) ) as province,
					(SELECT dv_geo_countries.country_name FROM dv_geo_countries WHERE dv_geo_countries.ID = (SELECT dv_rev.child_val FROM $dv_rev_table dv_rev WHERE dv_rev.ID = dv_add.city ) ) as country
				FROM
					$table_address dv_add
				INNER JOIN $dv_rev_table dv_rev 
					ON dv_rev.ID = dv_add.status
				WHERE dv_add.stid = '{$user["store_id"]}' 
					AND dv_rev.child_val = 1"
			);

			if (!$result) {
                return rest_ensure_response( 
                    array(
                        "status" => "failed",
                        "message" => "An error occured while submitting data to the server."
                    )
                );
            }else{
                return rest_ensure_response( 
					array(
						"status" => "success",
						"data" => array(
							'list' => $result, 
						
						)
					)
				);
            }


		}
		

		public static function catch_post()
        {
			$cur_user = array();
			
            $cur_user['store_id']      = $_POST['stid'];
			$cur_user['created_by']  = $_POST['wpid'];


            return  $cur_user;
        }
	}
	
	