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
    class DV_Contact_Stores_Select{

        public static function listen(){

            global $wpdb;

            if ( DV_Verification::is_verified() == false ) {
                return rest_ensure_response( 
                    array(
                        "status" => "unknown",
                        "message" => "Please contact your administrator. Request Unknown!",
                    )
                );
            }


            // Step1 : Sanitize all Request
            //REVISE REVISE:contact id & store_id
			if (!isset($_POST["wpid"]) || !isset($_POST["snky"])  || !isset($_POST['ctc']) || !isset($_POST['type'])) {
				return rest_ensure_response( 
					array(
						"status" => "unknown",
						"message" => "Please contact your administrator. Request unknown!",
					)
                );
                
            }
            
              // Step 2: Check if ID is in valid format (integer)
			if (!is_numeric($_POST["wpid"]) ) {
				return rest_ensure_response( 
					array(
						"status" => "failed",
						"message" => "Please contact your administrator. ID not in valid format!",
					)
                );
                
			}

			// Step 3: Check if ID exists
			if (!get_user_by("ID", $_POST['wpid'])) {
				return rest_ensure_response( 
					array(
						"status" => "failed",
						"message" => "User not found!",
					)
                );
                
            }

            

            $table_contact = DV_CONTACTS_TABLE;
            $table_revs = DV_REVS_TABLE;


            $created_by = $_POST['wpid'];

            $contact_id = $_POST['ctc'];

            $key = $_POST['type'];

            $result  = $wpdb->get_results("SELECT
                ctc.ID,
                ctc.types,
                ctc.`status`,
               
                revs.child_val as $key
            FROM
                $table_revs revs
                INNER JOIN $table_contact ctc ON revs.parent_id = ctc.ID 
            WHERE
                revs.child_key = '$key' 
                AND ctc.ID = $contact_id
                AND ctc.`status` = 1");


            if (!$result) {
                return rest_ensure_response( 
					array(
						"status" => "failed",
						"message" => "No contacts found!.",
					)
                );
            }

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