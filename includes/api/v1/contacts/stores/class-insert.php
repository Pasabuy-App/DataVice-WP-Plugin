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
    class DV_Contact_Stores_Insert{
        
        public static function listen() {
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
            if ( !isset($_POST["wpid"]) || !isset($_POST["snky"]) || !isset($_POST['value']) || !isset($_POST['type']) || !isset($_POST['stid'])) {
                return rest_ensure_response( 
                    array(
                        "status" => "unknown",
                        "message" => "Please contact your administrator. Request unknown!",
                    )
                );
            }

            // Check if required fields are not empty
            if ( empty($_POST["wpid"]) || empty($_POST["snky"]) || empty($_POST['value']) || empty($_POST['type']) || empty($_POST['stid']) ) {
                return rest_ensure_response( 
                    array(
                        "status" => "failed",
                        "message" => "Required fields cannot be empty.",
                    )
                );
            }

            // Check if value of type is valid
            if (!($_POST['type'] === 'phone') && !($_POST['type'] === 'email') && !($_POST['type'] === 'emergency')) {
                return rest_ensure_response( 
                    array(
                            "status" => "failed",
                            "message" => "Invalid value for type.",
                    )
                );
            }
            
            // Check if ID is in valid format (integer)
            if (!is_numeric($_POST["wpid"]) || !is_numeric($_POST["stid"]) ) {
                return rest_ensure_response( 
                    array(
                        "status" => "failed",
                        "message" => "Please contact your administrator. Id not in valid format!",
                    )
                );
                
            }

            //Check contact type if phone, email, or emergency
            if ($_POST['type'] == 'phone') {
                
                $type = 'phone';

            } else if ($_POST['type'] == 'email') {
                
                $type = 'email';
                
                //if type is email, make sure to sanitize if its a valid email format
                if (!is_email($_POST['value'])) {
                    return rest_ensure_response( 
                        array(
                            "status" => "failed",
                            "message" => "Email not in valid format."
                        )
                    );
                }
            
            } else {

                $type = 'emergency';
            
            }

            // Check if wpid match the created_by value
            $stid = $_POST['stid'];
            $get_contact = $wpdb->get_row("SELECT ID FROM tp_stores  WHERE ID = $stid ");
            
            if ( !$get_contact ) {
                return rest_ensure_response( 
                    array(
                        "status" => "error",
                        "message" => "An error occurred while submiting data to the server.",
                    )
                );
            }

            // Check if id(owner) of this contact exists
            if (!get_user_by("ID", $_POST['wpid'])) {
                return rest_ensure_response( 
                    array(
                        "status" => "failed",
                        "message" => "User not found",
                    )
                );
            }

            // Step 3: Pass constants to variables and catch post values 
            $table_contact = DV_CONTACTS_TABLE;
            $table_revs = DV_REVS_TABLE;
            $wpid = $_POST['wpid'];
            $snky = $_POST['snky'];
            $value = $_POST['value'];
            $revs_type = 'contacts';
            $date_stamp = DV_Globals::date_stamp();


            // Step 4: Start query
            $wpdb->query("START TRANSACTION ");

                $wpdb->query("INSERT INTO `$table_contact` (`status`, `types`, `revs`, `stid`, `created_by`, `date_created`) 
                                    VALUES ('1', '$type', '0', $stid, $wpid, '$date_stamp');");
                
                $contact_id = $wpdb->insert_id;

                $wpdb->query("INSERT INTO `$table_revs` (revs_type, parent_id, child_key, child_val, created_by, date_created) 
                                    VALUES ( '$revs_type', $contact_id, '$type', '$value', $wpid, '$date_stamp'  )");
                
                $revs_id = $wpdb->insert_id;

                $wpdb->query("UPDATE `$table_contact` SET `revs` = $revs_id WHERE ID = $contact_id ");

            // Check if any of the insert queries above failed
            if ($contact_id < 1  || $revs_id < 1) {
                //If failed, do mysql rollback (discard the insert queries(no inserted data))
                $wpdb->query("ROLLBACK");
                
                return rest_ensure_response( 
                    array(
                        "status" => "failed",
                        "message" => "An error occured while submitting data to the server"
                    )
                );
            }

            //If no problems found in queries above, do mysql commit (do changes(insert rows))
            $wpdb->query("COMMIT");

            // Step 5: Return a success message and complete object
            return rest_ensure_response( 
                array(
                        "status" => "Success",
                        "message" => "Data has been added successfully.",
                )
            );


        }

    }