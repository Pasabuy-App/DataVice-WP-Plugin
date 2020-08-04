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
    class DV_Signup {

        public static function listen(){

            // Step 1 : Check if the fields are passed
            if( !isset($_POST['un']) || !isset($_POST['em']) || 
                !isset($_POST['fn']) || !isset($_POST['ln']) || 
                !isset($_POST['gd']) || !isset($_POST['bd']) || 
                !isset($_POST['co']) || !isset($_POST['pv']) || 
                !isset($_POST['ct']) || !isset($_POST['bg']) ){
                return rest_ensure_response( 
                    array(
                            "status" => "unknown",
                            "message" => "Please contact your administrator. Request Unknown!",
                    )
                );
            }

            // Step 2 : Check if username or email is existing.
            if ( empty($_POST['un']) || empty($_POST['em'])
                || empty($_POST['fn']) || empty($_POST['ln'])
                || empty($_POST['gd']) || empty($_POST['bd'])
                || empty($_POST['co']) || empty($_POST['pv']) 
                || empty($_POST['ct']) || empty($_POST['bg']) ) {
                return rest_ensure_response( 
                    array(
                            "status" => "failed",
                            "message" => "Required field cannot be empty.",
                    )
                );
            }

            // Step 2 : Check if username or email is existing.
            if ( username_exists( $_POST['un'] ) ||  email_exists($_POST['em']) ) {
                return rest_ensure_response( 
                    array(
                            "status" => "failed",
                            "message" => "Username or Email already exist.",
                    )
                );
            }

            // Step 2 : Check if gender value is either Male or Female only.
            if (!($_POST['gd'] === 'Male') && !($_POST['gd'] === 'Female')) {
                return rest_ensure_response( 
                    array(
                            "status" => "failed",
                            "message" => "Invalid value for gender.",
                    )
                );
            }

            // Step 2 : Check if email is in valid format.
            if ( !is_email($_POST['em']) ) {
                return rest_ensure_response( 
                    array(
                            "status" => "failed",
                            "message" => "Invalid email address",
                    )
                );
            }

            // Step 2 : Check if birthday is in valid format (eg. 2020-08-02).
            if ( date('Y-m-d', strtotime($_POST['bd'])) !== date($_POST['bd']) ) {
                return rest_ensure_response( 
                    array(
                            "status" => "failed",
                            "message" => "Invalid birthday format",
                    )
                );
            }

            //Country input validation
                // Step 2 : Check if country passed is in integer format.
                if ( !is_numeric($_POST['co']) ) {
                    return rest_ensure_response( 
                        array(
                                "status" => "failed",
                                "message" => "Invalid value for country.",
                        )
                    );
                }

                // Step 2 : Check if country_id is in database. 
                $co_status = DV_Globals:: check_availability(DV_COUNTRY_TABLE, $_POST['co']);
                
                if ( $co_status == false ) {
                    return rest_ensure_response( 
                        array(
                                "status" => "failed",
                                "message" => "Invalid value for country.",
                        )
                    );
                }
                
                if ( $co_status === "unavail" ) {
                    return rest_ensure_response( 
                        array(
                                "status" => "failed",
                                "message" => "Not available yet in selected country",
                        )
                    );
                }
            //end of country validation

            //Province input validation
                // Step 2 : Check if province passed is in integer format.
                if ( !is_numeric($_POST['pv']) ) {
                    return rest_ensure_response( 
                        array(
                                "status" => "failed",
                                "message" => "Invalid value for province.",
                        )
                    );
                }

                // Step 2 : Check if province is in database. 
                $pv_status = DV_Globals:: check_availability(DV_PROVINCE_TABLE, $_POST['pv']);
                
                if ( $pv_status == false ) {
                    return rest_ensure_response( 
                        array(
                                "status" => "failed",
                                "message" => "Invalid value for province.",
                        )
                    );
                }
                
                if ( $pv_status === "unavail" ) {
                    return rest_ensure_response( 
                        array(
                                "status" => "failed",
                                "message" => "Not available yet in selected province",
                        )
                    );
                }
            // end of province validation

            //City input validation
                // Step 2 : Check if city passed is in integer format.
                if ( !is_numeric($_POST['ct']) ) {
                    return rest_ensure_response( 
                        array(
                                "status" => "failed",
                                "message" => "Invalid value for city.",
                        )
                    );
                }

                // Step 2 : Check if city is in database. 
                $ct_status = DV_Globals:: check_availability(DV_CITY_TABLE, $_POST['ct']);
                
                if ( $ct_status == false ) {
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
            // end of city validation

            //Barangay input validation
                // Step 2 : Check if barangay passed is in integer format.
                if ( !is_numeric($_POST['bg']) ) {
                    return rest_ensure_response( 
                        array(
                                "status" => "failed",
                                "message" => "Invalid value for barangay.",
                        )
                    );
                }

                // Step 2 : Check if barangay is in database. 
                $bg_status = DV_Globals:: check_availability(DV_BRGY_TABLE, $_POST['bg']);
                
                if ( $bg_status == false ) {
                    return rest_ensure_response( 
                        array(
                                "status" => "failed",
                                "message" => "Invalid value for barangay.",
                        )
                    );
                }
                
                if ( $bg_status === "unavail" ) {
                    return rest_ensure_response( 
                        array(
                                "status" => "failed",
                                "message" => "Not available yet in selected barangay",
                        )
                    );
                }
            // end of barangay validation

            // Step 3 : Actual creation of user.
            // Initialize WordPress Core DB.
            global $wpdb;

            // Get user object.
            $user = DV_Signup::catch_post();

            // Try to create a User.
            $created_id = wp_insert_user( $user );

            // Handle user creation events.
            if( !is_wp_error($created_id) ) {

                // Insert Gender etc. 
                $add_key_meta = update_user_meta( $created_id, 'gender', $user['gender'] );
                $add_key_meta = update_user_meta( $created_id, 'birthday', $user['birthday'] );

                
                //Start for mysql transaction.
                //This is crucial in inserting data with connection with each other
                $wpdb->query("START TRANSACTION");
                
                $dv_rev_table = DV_REVS_TABLE;
                
                $date = DV_Globals:: date_stamp();

                $rev_fields = DV_INSERT_REV_FIELDS;

                $wpdb->query("INSERT INTO $dv_rev_table ($rev_fields) VALUES ('address', 'status', 'active', $created_id, '$date');");
                
                $revtype = $wpdb->insert_id;

                $wpdb->query("INSERT INTO $dv_rev_table ($rev_fields) VALUES ('address', 'street', 'test street', $created_id, '$date');");
                
                $street = $wpdb->insert_id;

                $wpdb->query("INSERT INTO $dv_rev_table ($rev_fields) VALUES ('address', 'brgy', {$user["brgy"]}, $created_id, '$date');");
                
                $brgy = $wpdb->insert_id;

                $wpdb->query("INSERT INTO $dv_rev_table ($rev_fields) VALUES ('address', 'city', {$user["city"]}, $created_id, '$date');");
                
                $city = $wpdb->insert_id;
                
                $wpdb->query("INSERT INTO $dv_rev_table ($rev_fields) VALUES ('address', 'province', {$user["province"]}, $created_id, '$date');");
                
                $province = $wpdb->insert_id;

                $wpdb->query("INSERT INTO $dv_rev_table ($rev_fields) VALUES ('address', 'country', {$user["country"]}, $created_id, '$date');");
                
                $country = $wpdb->insert_id;
                
                //Check if any of the insert queries above failed
                if ($revtype < 1 || $street < 1 || $brgy < 1 ||
                   $province < 1 || $city < 1 || $country < 1 ) {

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

                
                $table_address = DV_ADDRESS_TABLE;

                $address_fields = DV_INSERT_ADDRESS_FIELDS;

                //Save the address in the parent table
                $wpdb->query("INSERT INTO $table_address ($address_fields) VALUES ('1', $created_id, '0', 'home', $street, $brgy, $city, $province, $country, '$date')");

                $address_id = $wpdb->insert_id;

                //Check if insert success, if not, return error message
                if ($address_id < 1) {
                    return rest_ensure_response( 
                        array(
                            "status" => "failed",
                            "message" => "An error occured while submitting data to the server"
                        )
                    );
                }

                //Update user meta for saving the address
                $add_key_meta = update_user_meta( $created_id, 'address_home', "{$address_id}" );   
                
                //Update revision table for saving the parent_id(address_id)
                $wpdb->query("UPDATE $dv_rev_table SET `parent_id` = {$address_id} WHERE ID IN ($revtype, $street, $brgy, $city, $province, $country)");
                
                
                // Insert user meta for expiration of current activation_key.
                /** Get the password expiration time in config table
                 * @param1 = key
                 * @param2 = default value if no value found
                **/
                $pword_expiry_span = DV_Library_Config::dv_get_config('pword_expiry_span', 1800);
    
                $expiration_date = date( 'Y-m-d H:i:s', strtotime("now") + (int)$pword_expiry_span );
                $add_key_meta = update_user_meta( $created_id, 'reset_pword_expiry', $expiration_date );
                
                // Try to send mail.
                if( DV_Signup::is_success_sendmail( $user ) ) {
                    return rest_ensure_response( 
                        array(
                                "status" => "success",
                                "message" => "Please check your email for password reset key.",
                        )
                    );
                } else {
                    return rest_ensure_response( 
                        array(
                                "status" => "failed",
                                "message" => "Please contact site administrator. Email not sent!",
                        )
                    );
                }
                
            } else {
                return rest_ensure_response( 
                    array(
                            "status" => "error",
                            "message" => "WordPress Error!",
                    )
                );
            }
        }

        // Return of SignUp user object from POST.
        public static function catch_post()
        {
            $cur_user = array();

            $cur_user['user_login'] = $_POST['un'];
            $cur_user['user_pass'] = wp_generate_password( 49, false, false );
            $cur_user['user_email'] = $_POST['em'];

            $cur_user['user_nicename'] = ""; //user post url
            $cur_user['user_url'] = ""; //referral url

            $cur_user['first_name'] = $_POST['fn'];
            $cur_user['last_name'] = $_POST['ln'];
            $cur_user['display_name'] = $cur_user['first_name'] ." ". $cur_user['last_name'];

            $cur_user['gender'] = $_POST['gd']; //Male, Female
            $cur_user['birthday'] = $_POST['bd']; //Y-m-d

            $cur_user['country'] = $_POST['co'];
            $cur_user['province'] = $_POST['pv'];
            $cur_user['city'] = $_POST['ct'];
            $cur_user['brgy'] = $_POST['bg'];

            $cur_user['show_admin_bar_front'] = false;
            $cur_user['role'] = "subscriber";
            $cur_user['user_activation_key'] = wp_generate_password( 12, false, false );
            $cur_user['user_registered'] = Date("Y-m-d H:i:s");

            return  $cur_user;
        }

        // Try to Send email for a new verification or activation key.
        public static function is_success_sendmail($user) {
            $message = "Hello " .$user['display_name']. ",";
            $message .= "\n\nWelcome to PasaBuy.App! We're happy that your here.";
            $message .= "\nPassword Reset Key: " .$user['user_activation_key'];
            $message .= "\n\nPasaBuy.App";
            $message .= "\nsupport@pasabuy.app";
            return wp_mail( $user['user_email'], "Bytes Crafter - Forgot Password", $message );
        }

    }
?>