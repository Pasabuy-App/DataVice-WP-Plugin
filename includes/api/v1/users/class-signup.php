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

    class DV_Signup {

        public static function listen(){
            return rest_ensure_response(
				self::listen_open()
			);
        }

        public static function listen_open(){

            // Step 1 : Check if the fields are passed
            if( !isset($_POST['em']) || !isset($_POST['fn']) || !isset($_POST['ln']) ){
                return array(
                    "status" => "unknown",
                    "message" => "Please contact your administrator. Request Unknown!",
                );
            }

            // Step 2 : Check if username or email is existing.
            if ( empty($_POST['em']) || empty($_POST['fn']) || empty($_POST['ln']) ) {
                return array(
                    "status" => "failed",
                    "message" => "Required fields cannot be empty.",
                );
            }

            // Step 2 : Check if username or email is existing.
            if ( email_exists($_POST['em']) ) {
                return array(
                    "status" => "failed",
                    "message" => "Username or Email already exist.",
                );
            }

            // Step 2 : Check if email is in valid format.
            if ( !is_email($_POST['em']) ) {
                return  array(
                    "status" => "failed",
                    "message" => "Invalid email address.",
                );
            }

            // Step 3 : Actual creation of user.
            // Initialize WordPress Core DB.
            global $wpdb;

            // Get user object.
            $user = DV_Signup::catch_post();
            $tempActKey = $user['user_activation_key'];
            $user['user_activation_key'] = md5($user['user_activation_key']);

            // Try to create a User.
            $created_id = wp_insert_user( $user );

            // Handle user creation events.
            if( !is_wp_error($created_id) ) {

                $insert_dv_user = self::insert_dv_users($created_id);

                if ($insert_dv_user == false) {
                    return array(
                        "status" => "failed",
                        "message" => "An error occured while submitting data to server.",
                    );
                }

                // Insert Gender etc.

                // Insert user meta for expiration of current activation_key.
                /** Get the password expiration time in config table
                 * @param1 = key
                 * @param2 = default value if no value found
                **/
                $pword_expiry_span = DV_Library_Config::dv_get_config('pword_expiry_span', 1800);

                $expiration_date = date( 'Y-m-d H:i:s', strtotime("now") + (int)$pword_expiry_span );
                $add_key_meta = update_user_meta( $created_id, 'reset_pword_expiry', $expiration_date );

                $user['user_activation_key'] = $tempActKey;

                // Try to send mail.
                if( DV_Signup::is_success_sendmail( $user ) ) {
                    return rest_ensure_response(
                        array(
                                "status" => "success",
                                "message" => "Please check your email for password reset key.",
                        )
                    );

                } else {
                    return  array(
                        "status" => "failed",
                        "message" => "Please contact site administrator. Email not sent!"
                    );

                }

            } else {
                return array(
                    "status" => "error",
                    "message" => "Please contact site administrator. Insert Error!",
                );
            }
        }

        // Return of SignUp user object from POST.
        public static function catch_post()
        {
            $cur_user = array();
            $cur_user['user_login'] = $_POST['em'];

            $cur_user['user_pass'] = wp_generate_password( 49, false, false );
            $cur_user['user_email'] = $_POST['em'];

            $cur_user['user_nicename'] = ""; //user post url
            $cur_user['user_url'] = ""; //referral url

            $cur_user['first_name'] = $_POST['fn'];
            $cur_user['last_name'] = $_POST['ln'];
            $cur_user['display_name'] = $cur_user['first_name'] ." ". $cur_user['last_name'];

            $cur_user['show_admin_bar_front'] = false;
            $cur_user['role'] = "subscriber";
            $cur_user['user_activation_key'] = DV_Globals::activation_key();
            $cur_user['user_registered'] = Date("Y-m-d H:i:s");

            return  $cur_user;
        }

        // Try to Send email for a new verification or activation key.
        public static function is_success_sendmail($user) {
            $message = "Hello " .$user['display_name']. ",";
            $message .= "\n\nWelcome to PasaBuy.App! We're happy that your here.";
            $message .= "\nPassword Activation Key: " .$user['user_activation_key'];
            $message .= "\n\nPasaBuy.App";
            $message .= "\nsupport@pasabuy.app";
            $pasabuy = EMAIL_HEADER;
            $subject = EMAIL_HEADER_SUBJECT_ACTIVATE;
            $mail = wp_mail( $user['user_email'], $pasabuy." - ".$subject, $message );

            if(is_wp_error($mail)){
                return false;
            }else{
                return $mail;
            }
        }

        public static function insert_dv_users($wpid){
            global $wpdb;
            $table = DV_USERS;

            $insert_user = $wpdb->query("INSERT INTO $table (wpid) VALUES ('$wpid') ");
            $insert_id = $wpdb->insert_id;

            $data = DV_Globals::update_public_key_hash($insert_id, $table);

            if ($insert_user == false || $data == false) {
                return false;

            }else{
                return true;

            }
        }
    }