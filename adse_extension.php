<?php

/*
Plugin Name: Adse Extenstion
Description: A plugin that allows managing categories and data, and displays a dropdown on a page based on a shortcode.
Version: 1.0
Author: InfoBeans Limited
*/


// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}


// Define the function to create the required tables in the database
function adse_activate_all() {
    global $wpdb;
    
    // Define table names
    $table_adse_category = $wpdb->prefix . 'adse_category';
    $table_adse_building_type = $wpdb->prefix . 'adse_building_type';
    $table_adse_building_component = $wpdb->prefix . 'adse_building_component';
    $table_adse_stage_of_construction = $wpdb->prefix . 'adse_stage_of_construction';
    $table_adse_stage_of_construction_building_type = $wpdb->prefix . 'adse_stage_of_construction_building_type';
    $table_adse_stage_of_construction_building_component = $wpdb->prefix . 'adse_stage_of_construction_building_component';
    $table_adse_building_element = $wpdb->prefix . 'adse_building_element';
    $table_adse_building_element_building_type = $wpdb->prefix . 'adse_building_element_building_type';
    $table_adse_building_element_building_component = $wpdb->prefix . 'adse_building_element_building_component';
    $table_adse_building_element_stage_of_construction = $wpdb->prefix . 'adse_building_element_stage_of_construction';
    $table_adse_substrate = $wpdb->prefix . 'adse_substrate';
    $table_adse_special_condition = $wpdb->prefix . 'adse_special_condition';

    // Define SQL queries to create tables
    $charset_collate = $wpdb->get_charset_collate();

    $sql_adse_category = "CREATE TABLE IF NOT EXISTS $table_adse_category (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name tinytext NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    $sql_adse_building_type = "CREATE TABLE IF NOT EXISTS $table_adse_building_type (`id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(64) NOT NULL , `is_active` TINYINT NOT NULL DEFAULT '1' , PRIMARY KEY (`id`))  $charset_collate;" ;

    $sql_adse_building_component = "CREATE TABLE IF NOT EXISTS $table_adse_building_component (`id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(64) NOT NULL , `is_active` TINYINT NOT NULL DEFAULT '1' , PRIMARY KEY (`id`))  $charset_collate;";

    $sql_adse_stage_of_construction = "CREATE TABLE IF NOT EXISTS $table_adse_stage_of_construction (`id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(64) NOT NULL , `is_active` INT NOT NULL DEFAULT '1' , PRIMARY KEY (`id`))  $charset_collate;";

            $sql_adse_stage_of_construction_building_type = "CREATE TABLE IF NOT EXISTS $table_adse_stage_of_construction_building_type (
                    `id` INT NOT NULL AUTO_INCREMENT,
                    `stage_of_construction_id` INT NOT NULL,
                    `building_type_id` INT NOT NULL,
                    `is_active` TINYINT NOT NULL DEFAULT '1',
                    PRIMARY KEY (`id`),
                    FOREIGN KEY (`stage_of_construction_id`) REFERENCES `wp_adse_stage_of_construction`(`id`) ON DELETE RESTRICT,
                    FOREIGN KEY (`building_type_id`) REFERENCES `wp_adse_building_type`(`id`) ON DELETE RESTRICT
                )  $charset_collate;";

            $sql_adse_stage_of_construction_building_component = "CREATE TABLE IF NOT EXISTS $table_adse_stage_of_construction_building_component (
                    `id` INT NOT NULL AUTO_INCREMENT,
                    `stage_of_construction_id` INT NOT NULL,
                    `building_component_id` INT NOT NULL,
                    `is_active` TINYINT NOT NULL DEFAULT '1',
                    PRIMARY KEY (`id`),
                    FOREIGN KEY (`stage_of_construction_id`) REFERENCES `wp_adse_stage_of_construction`(`id`) ON DELETE RESTRICT,
                    FOREIGN KEY (`building_component_id`) REFERENCES `wp_adse_building_component`(`id`) ON DELETE RESTRICT
                )  $charset_collate; ";

    $sql_adse_building_element = "CREATE TABLE IF NOT EXISTS $table_adse_building_element (`id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(64) NOT NULL , `picture` VARCHAR(256) NULL , `is_active` TINYINT NOT NULL DEFAULT '1' , PRIMARY KEY (`id`))  $charset_collate;";

            $sql_adse_building_element_building_type = "CREATE TABLE IF NOT EXISTS $table_adse_building_element_building_type  (
                    `id` INT NOT NULL AUTO_INCREMENT,
                    `building_element_id` INT NOT NULL,
                    `building_type_id` INT NOT NULL,
                    `is_active` TINYINT NOT NULL DEFAULT '1',
                    PRIMARY KEY (`id`),
                    FOREIGN KEY (`building_element_id`) REFERENCES `wp_adse_building_element`(`id`) ON DELETE RESTRICT,
                    FOREIGN KEY (`building_type_id`) REFERENCES `wp_adse_building_type`(`id`) ON DELETE RESTRICT
                )  $charset_collate;";

            $sql_adse_building_element_building_component = "CREATE TABLE IF NOT EXISTS $table_adse_building_element_building_component  (
                    `id` INT NOT NULL AUTO_INCREMENT,
                    `building_element_id` INT NOT NULL,
                    `building_component_id` INT NOT NULL,
                    `is_active` TINYINT NOT NULL DEFAULT '1',
                    PRIMARY KEY (`id`),
                    FOREIGN KEY (`building_element_id`) REFERENCES `wp_adse_building_element`(`id`) ON DELETE RESTRICT,
                    FOREIGN KEY (`building_component_id`) REFERENCES `wp_adse_building_component`(`id`) ON DELETE RESTRICT
                )  $charset_collate;";
                
                $sql_adse_building_element_stage_of_construction = "CREATE TABLE IF NOT EXISTS $table_adse_building_element_stage_of_construction (
                    `id` INT NOT NULL AUTO_INCREMENT,
                    `building_element_id` INT NOT NULL,
                    `stage_of_construction_id` INT NOT NULL,
                    `is_active` TINYINT NOT NULL DEFAULT '1',
                    PRIMARY KEY (`id`),
                    FOREIGN KEY (`building_element_id`) REFERENCES `wp_adse_building_element`(`id`) ON DELETE RESTRICT,
                    FOREIGN KEY (`stage_of_construction_id`) REFERENCES `wp_adse_stage_of_construction`(`id`) ON DELETE RESTRICT
                )  $charset_collate;";
		

        $sql_adse_substrate = "CREATE TABLE IF NOT EXISTS $table_adse_substrate (`id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(64) NOT NULL , `is_active` TINYINT NOT NULL DEFAULT '1' , PRIMARY KEY (`id`))  $charset_collate;";

        $sql_adse_special_condition = "CREATE TABLE IF NOT EXISTS $table_adse_special_condition (`id` INT NOT NULL AUTO_INCREMENT , `name` VARCHAR(64) NOT NULL , `is_active` TINYINT NOT NULL DEFAULT '1' , PRIMARY KEY (`id`))  $charset_collate;";


    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql_adse_category);
    dbDelta($sql_adse_building_type);
    dbDelta($sql_adse_building_component);
    dbDelta($sql_adse_stage_of_construction);
    dbDelta($sql_adse_stage_of_construction_building_type);
    dbDelta($sql_adse_stage_of_construction_building_component);
    dbDelta($sql_adse_building_element);
    dbDelta($sql_adse_building_element_building_type);
    dbDelta($sql_adse_building_element_building_component);
    dbDelta($sql_adse_building_element_stage_of_construction);
    dbDelta($sql_adse_substrate);
    dbDelta($sql_adse_special_condition);
    
}

// Define the function to create the required tables in the database
function adse_deactivate_all() {
    global $wpdb;
    
    // Define table names
    $table_adse_category = $wpdb->prefix . 'adse_category';
    $table_adse_building_type = $wpdb->prefix . 'adse_building_type';
    $table_adse_building_component = $wpdb->prefix . 'adse_building_component';
    $table_adse_stage_of_construction = $wpdb->prefix . 'adse_stage_of_construction';
    $table_adse_stage_of_construction_building_type = $wpdb->prefix . 'adse_stage_of_construction_building_type';
    $table_adse_stage_of_construction_building_component = $wpdb->prefix . 'adse_stage_of_construction_building_component';
    $table_adse_building_element = $wpdb->prefix . 'adse_building_element';
    $table_adse_building_element_building_type = $wpdb->prefix . 'adse_building_element_building_type';
    $table_adse_building_element_building_component = $wpdb->prefix . 'adse_building_element_building_component';
    $table_adse_building_element_stage_of_construction = $wpdb->prefix . 'adse_building_element_stage_of_construction';
    $table_adse_substrate = $wpdb->prefix . 'adse_substrate';
    $table_adse_special_condition = $wpdb->prefix . 'adse_special_condition';

    $sql_adse_category = "DROP TABLE IF EXISTS $table_adse_category";
    $sql_adse_building_type = "DROP TABLE IF EXISTS $table_adse_building_type";
    $sql_adse_building_component = "DROP TABLE IF EXISTS $table_adse_building_component";
    $sql_adse_stage_of_construction = "DROP TABLE IF EXISTS $table_adse_stage_of_construction";
    $sql_adse_stage_of_construction_building_type = "DROP TABLE IF EXISTS $table_adse_stage_of_construction_building_type";
    $sql_adse_stage_of_construction_building_component = "DROP TABLE IF EXISTS $table_adse_stage_of_construction_building_component";
    $sql_adse_building_element = "DROP TABLE IF EXISTS $table_adse_building_element";
    $sql_adse_building_element_building_type = "DROP TABLE IF EXISTS $table_adse_building_element_building_type";
    $sql_adse_building_element_building_component = "DROP TABLE IF EXISTS $table_adse_building_element_building_component";
    $sql_adse_building_element_stage_of_construction = "DROP TABLE IF EXISTS $table_adse_building_element_stage_of_construction";
    $sql_adse_substrate = "DROP TABLE IF EXISTS $table_adse_substrate";
    $sql_adse_special_condition = "DROP TABLE IF EXISTS $table_adse_special_condition";


    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    dbDelta($sql_adse_category);
    dbDelta($sql_adse_building_type);
    dbDelta($sql_adse_building_component);
    dbDelta($sql_adse_stage_of_construction);
    dbDelta($sql_adse_stage_of_construction_building_type);
    dbDelta($sql_adse_stage_of_construction_building_component);
    dbDelta($sql_adse_building_element);
    dbDelta($sql_adse_building_element_building_type);
    dbDelta($sql_adse_building_element_building_component);
    dbDelta($sql_adse_building_element_stage_of_construction);
    dbDelta($sql_adse_substrate);
    dbDelta($sql_adse_special_condition);

}

// Register activation hook to create tables when the plugin is activated
register_activation_hook(__FILE__, 'adse_activate_all');
register_deactivation_hook( __FILE__, 'adse_deactivate_all' );



function add_javascript() {
    // Enqueue Bootstrap CSS
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');

    // Enqueue Bootstrap JS and its dependencies
    wp_enqueue_script('popper-js', 'https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js', array('jquery'), null, true);
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array('jquery', 'popper-js'), null, true);


    wp_enqueue_script( 'adse-script', plugin_dir_url( __FILE__ ). 'static/js/script.js', array('jquery'), null, true );
    wp_localize_script('adse-script', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));

}

// Hook into WordPress
add_action('wp_enqueue_scripts', 'add_javascript');







if ( is_admin() ) {

    require_once plugin_dir_path( __FILE__ ) . 'admin/class-adse-admin.php';
   
}


require_once plugin_dir_path( __FILE__ ) . 'includes/functions.php';

function load_ajax_content_callbackx() {

    // calling a fuctions stored in callback post variable, sending params staored in params post variable 
    $_POST["callback"]($_POST["params"]);
    wp_die();
}

add_action( 'wp_ajax_load_ajax_content', 'load_ajax_content_callbackx' ); 


function adse_boq_download() 
{

            
            // Fetch the PDF file content from the URL
            $pdfContent = file_get_contents('http://localhost/ultimate-member/wp-content/uploads/2024/04/Hotel-BOQ.pdf');

            // Check if the download was successful
            if ($pdfContent !== false) {
                // Set the appropriate HTTP headers for file download
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="BOQ.pdf"');
                header('Content-Length: ' . strlen($pdfContent));

                // Output the PDF content
                echo $pdfContent;
            }

}



function adse_shortcode() {
	
    

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
       
        
        
        if($_POST["Building_Type"] == "Residential") {
            $redirectUrl = 'http://localhost/ultimate-member/wp-content/uploads/2024/04/Residential-BOQ.pdf';
        }elseif ($_POST["Building_Type"] == "Hotel"){
            $redirectUrl = 'http://localhost/ultimate-member/wp-content/uploads/2024/04/Hotel-BOQ.pdf';
        }

        if($_POST['submit_button']=="View")
        {
            header('Location: ' . $redirectUrl);
            exit;
        }
        else{

            //adse_boq_download();   exit;

            // Fetch the PDF file content from the URL
            $pdfContent = file_get_contents($redirectUrl);

            // Check if the download was successful
            if ($pdfContent !== false) {
                // Set the appropriate HTTP headers for file download
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="BOQ.pdf"');
                header('Content-Length: ' . strlen($pdfContent));

                // Output the PDF content
                echo $pdfContent;
                exit;
                
            } else {
                echo "Failed to download the PDF file from the URL.";
            }

            
        }

    }
	
    require_once plugin_dir_path( __FILE__ ) . 'includes/shortcode.php';

}

add_shortcode('adse_shortcode', 'adse_shortcode');



?>