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

    class DV_Update_Address{

        public static function listen() {

            global $wpdb;
            
               // Step1: Validate user
               if ( DV_Verification::is_verified() == false ) {
                return rest_ensure_response( 
                    array(
                        "status" => "unknown",
                        "message" => "Please contact your administrator. Verification Issue!",
                    )
                );
            }

            // Step 1 : Check if the fields are passed
            if( !isset($_POST['id']) ){
                return rest_ensure_response( 
                    array(
                            "status" => "unknown",
                            "message" => "Please contact your administrator. Request Unknown!",
                    )
                );
            }

             // Step 1 : Check if the fields are passed
             if( empty($_POST['id']) ){
                return rest_ensure_response( 
                    array(
                            "status" => "unknown",
                            "message" => "Please contact your administrator. Request Empty!",
                    )
                );
            }

            isset($_POST['co']) ?  $country_code = $_POST['co'] : $country_code = NULL;
            isset($_POST['pv']) ?  $prov_code = $_POST['pv'] : $prov_code = NULL;
            isset($_POST['ct']) ?  $city_code = $_POST['ct'] : $city_code = NULL;
            isset($_POST['bg']) ?  $brgy_code = $_POST['bg'] : $brgy_code = NULL;
            isset($_POST['st']) ?  $street = $_POST['st'] : $street = NULL;
            
            // Step 2 : Check if country_id is in database. 
            $co_status = DV_Globals:: check_availability(DV_COUNTRY_TABLE, " WHERE country_code ='$country_code'", true);
            
            if ( $co_status == false && $country_code) {
                return rest_ensure_response( 
                    array(
                            "status" => "failed",
                            "message" => "Invalid value for country.",
                    )
                );
            }
            
            if ( $co_status === "unavail" && $country_code ) {
                return rest_ensure_response( 
                    array(
                            "status" => "failed",
                            "message" => "Not available yet in selected country",
                    )
                );
            }
           
            // Step 2 : Check if province is in database. 
            $pv_status = DV_Globals:: check_availability(DV_PROVINCE_TABLE, " WHERE prov_code ='$prov_code' ");
            
            if ( $pv_status == false && $prov_code) {
                return rest_ensure_response( 
                    array(
                            "status" => "failed",
                            "message" => "Invalid value for province.",
                    )
                );
            }
            
            if ( $pv_status === "unavail" && $prov_code ) {
                return rest_ensure_response( 
                    array(
                            "status" => "failed",
                            "message" => "Not available yet in selected province",
                    )
                );
            }
        
            // Step 2 : Check if city is in database. 
            $ct_status = DV_Globals:: check_availability(DV_CITY_TABLE, " WHERE city_code ='$city_code' ");
            
            if ( $ct_status == false && $city_code) {
                return rest_ensure_response( 
                    array(
                            "status" => "failed",
                            "message" => "Invalid value for city.",
                    )
                );
            }
            
            if ( $ct_status === "unavail" ) {
                return rest_ensure_response( 
                    array(
                            "status" => "failed",
                            "message" => "Not available yet in selected city",
                    )
                );
            }
        
            // Step 2 : Check if barangay is in database. 
            $bg_status = DV_Globals:: check_availability(DV_BRGY_TABLE, " WHERE ID ='$brgy_code'");
            
            if ( $bg_status == false && $brgy_code ) {
                return rest_ensure_response( 
                    array(
                            "status" => "failed",
                            "message" => "Invalid value for barangay.",
                    )
                );
            }
            
            if ( $bg_status === "unavail" && $brgy_code ) {
                return rest_ensure_response( 
                    array(
                            "status" => "failed",
                            "message" => "Not available yet in selected barangay",
                    )
                );
            }
            
            $table_address = DV_ADDRESS_TABLE;
            $dv_rev_table = DV_REVS_TABLE;
            $country_table = DV_COUNTRY_TABLE;
            $province_table = DV_PROVINCE_TABLE;
            $city_table = DV_CITY_TABLE;
            $brgy_table = DV_BRGY_TABLE;
            $id = $_POST['id'];

            $data = array('country' => $country_code,
                          'province' => $prov_code,
                          'city' => $city_code,
                          'brgy' => $brgy_code,
                          'street' => $street
            );

            $where = array('id' => $id); 

            $update = DV_Globals:: custom_update($id, $_POST['wpid'], 'address', $table_address, $dv_rev_table, $data, $where );
            
            if ($update == false) {
                return  array(
                        "status" => "error",
                        "message" => "An error occured while submitting data to the server."
                );
            }
           
            return array(
                    "status" => "success",
                    "message" => "Data has been updated successfully."
            );
        }

    }