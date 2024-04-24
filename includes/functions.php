<?php

function getDataByFields($tableName, $fields=[]) {
	global $wpdb;

	// Build the WHERE clause based on the input fields

	$whereClause = [];
	$parameters = [];

	if (sizeof($fields)) {
		
		foreach ($fields as $field => $value) {
			$whereClause[] = "$field = %s";
			$parameters[] = $value;
		}
		$whereClause = implode(' AND ', $whereClause);
	}
	else{
		$whereClause = "is_active=1";
	}

	// Prepare the SQL query
	$query = $wpdb->prepare("SELECT * FROM $wpdb->prefix"."$tableName WHERE $whereClause", $parameters);

	// Execute the query
	$results = $wpdb->get_results($query, ARRAY_A);

	// Return the results
	return $results;
}

function getBuildingComponent($param)
{
	$table_data = 'adse_building_component';
	
    $building_component_data =  getDataByFields($table_data);
	echo json_encode($building_component_data);


	wp_die();
}

function getStageOfConstruction($param)
{
	global $wpdb;
	
	$query = $wpdb->prepare("SELECT sc.id,sc.name FROM `wp_adse_stage_of_construction` sc
	
    JOIN wp_adse_stage_of_construction_building_type sc_bt on sc.id = sc_bt.stage_of_construction_id
    JOIN wp_adse_building_type bt ON sc_bt.building_type_id = bt.id
    
	JOIN wp_adse_stage_of_construction_building_component sc_bc on sc.id = sc_bc.stage_of_construction_id 
    JOIN wp_adse_building_component bc ON sc_bc.building_component_id = bc.id
    
	where sc.is_active=1 and (sc_bt.building_type_id =%s and sc_bc.building_component_id = %s)", [$param["building_type_id"],$param["building_component_id"]]);
	
	$stage_of_consturction_data = $wpdb->get_results($query, ARRAY_A);
	echo json_encode($stage_of_consturction_data);

	wp_die();

}

function getBuildingElement($param)
{
	global $wpdb;

	
	$query = $wpdb->prepare("SELECT be.id, be.name, be.picture FROM `wp_adse_building_element` be 

	JOIN wp_adse_building_element_building_type be_bt ON be.id = be_bt.building_element_id 
	JOIN wp_adse_building_type bt ON be_bt.building_type_id = bt.id
	
	JOIN wp_adse_building_element_building_component be_bc on be.id = be_bc.building_element_id 
	JOIN wp_adse_building_component bc ON be_bc.building_component_id = bc.id
	
	JOIN wp_adse_building_element_stage_of_construction be_sc on be.id = be_sc.building_element_id 
	JOIN wp_adse_stage_of_construction sc ON be_sc.stage_of_construction_id = sc.id
	
	where sc.is_active=1 and ( be_bt.building_type_id =2 and be_bc.building_component_id = 2 and be_sc.stage_of_construction_id = 2 ) ", [$param["building_type_id"],$param["building_component_id"],$param["stage_of_construction_id"]]);
	
	$stage_of_consturction_data = $wpdb->get_results($query, ARRAY_A);
	echo json_encode($stage_of_consturction_data);

	wp_die();


}
?>