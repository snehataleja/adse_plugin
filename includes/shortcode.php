   <?php
   
    //require_once plugin_dir_path( __FILE__ ) . 'functions.php';
    
    $table_building_type = 'adse_building_type';
    $building_type_data = getDataByFields($table_building_type);

    $table_substrate = 'adse_substrate';
    $substrate_data = getDataByFields($table_substrate);

    $table_special_condition = 'adse_special_condition';
    $special_condition_data = getDataByFields($table_special_condition);

    ?>

	<form  method="POST">
    <h3>Bulding Type</h3>

    <style> .row { min-height : 100px; border:1px solid gray; } </style>

    <div class="container">
        <div class="row">
            <div class="col">
            <span><b>Building Type</b></span><br />
            <select name="building_type" id="building_type" >
                <option value="" >-select-</option>
    
                <?php
                foreach ($building_type_data as $data) {
                    $building_element_output .= '<option value="' . esc_attr($data["id"]) . '">' . esc_html($data["name"]) . '</option>';
                }
                echo $building_element_output;

                ?>
                </select>

            </div>
            <div class="col"><span><b>Building Component</b></span><br /><select id="building_component" ><option value="">-select-</option></select></div>
            <div class="col"><span><b>Stage of Construction</b></span><br /><select multiple="multiple" id="stage_of_construction" rows="4"></select></div>
        </div>
        <div class="row">
            <div class="col">Building Element</div>
            <div id="building_element_container" ></div>
        </div>
        <div class="row">
            <div class="col"><span><b>Substrate</b></span><br />
            <select ><option value="" >-select-</option>
                
                <?php
                foreach ($substrate_data as $data) {
                    $substrate_output .= '<option value="' . esc_attr($data["id"]) . '">' . esc_html($data["name"]) . '</option>';
                }
                echo $substrate_output;
                ?>
            </select>
        </div>
            <div class="col"><span><b>Special Condition</b></span><br />
            <select><option value="" >-select-</option>
            <?php
                foreach ($special_condition_data as $data) {
                    $special_condition_output .= '<option value="' . esc_attr($data["id"]) . '">' . esc_html($data["name"]) . '</option>';
                }
                echo $special_condition_output;
                ?>
            </select>
        </div>
        </div>
    </div>
    



    

    <input type="submit"  name="submit_button"   value="View" /> &nbsp; <input type="submit"  name="submit_button"  value="Download"></form>
	
