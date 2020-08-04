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
    class DV_Contact_Delete{

        public static function listen(){
            
            global $wpdb;

            if ( DV_Verification::is_verified() == false) {
                return rest_ensure_response( 
                    array(
                        "status" => "unknown",
                        "message" => "Please contact your administrator. Request Unknown!",
                    )
                );
            }

            // Step1 : Sanitize all Request
			if (!isset($_POST["wpid"]) || !isset($_POST["snky"]) || !isset($_POST['ctc']) ) {
				return rest_ensure_response( 
					array(
						"status" => "unknown",
						"message" => "Please contact your administrator. Request unknown!",
					)
                );
                
            }

            //Check if params passed has values
            if (empty($_POST["wpid"]) || empty($_POST["snky"]) || empty($_POST['ctc']) ) {
				return rest_ensure_response( 
					array(
						"status" => "failed",
						"message" => "Required fields cannot be empty",
					)
                );
                
            }

            //Check if contact id and user id is valid
            if (!is_numeric($_POST['ctc']) ||  !is_numeric($_POST['wpid']) ) {
                return rest_ensure_response( 
                    array(
                        "status" => "failed",
                        "message" => "Please contact your administrator. ID not in valid format!",
                    )
                );
                
            }  
			
            $table_contact = DV_CONTACTS_TABLE;
            $table_revisions = DV_REVS_TABLE;

            $wpid = $_POST['wpid'];
          
            $contact_id = $_POST['ctc'];
            
            // Step 2: Check if ID exists
            $get_contact = $wpdb->get_row("SELECT `created_by` FROM `dv_contacts`  WHERE `ID` = $contact_id");
            
            //Check if wpid match the created_by value
            if ( !$get_contact ) {
                return rest_ensure_response( 
                    array(
                        "status" => "error",
                        "message" => "An error occurred while submiting data to the server.",
                    )
                );
            }
            

            //Check if wpid match the created_by value
            if ($get_contact->created_by !== $wpid ) {
                return rest_ensure_response( 
                    array(
                        "status" => "error",
                        "message" => "An error occurred while submiting data to the server.",
                    )
                );
            }

            $result = $wpdb->query("UPDATE `$table_contact` SET `status` = '0' WHERE ID = $contact_id AND created_by = $wpid ");

            if ($result < 0) {
                return rest_ensure_response( 
                    array(
                        "status" => "failed",
                        "message" => "Please Contact your Administrator. Contact Deletion Failed!"
                    )
                );
            }

            return rest_ensure_response( 
                array(
                    "status" => "success",
                    "message" => "Contact successfully deleted!"
                )
            );
        }
    }