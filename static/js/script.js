jQuery(function () {

    jQuery('#building_type').on('change', function () {

        if (this.value) {
            jQuery.ajax({
                url: ajax_object.ajax_url,
                type: 'post',
                data: {
                    action: 'load_ajax_content',
                    callback: 'getBuildingComponent',
                    params: { 'building_type_id': this.value }
                },
                success: function (response) {
                    jQuery("#building_component").html(fillDropDown(response));
                }
            });
        }
        else {
            jQuery("#building_component").html('<option value="">-select-</option>');
        }
    });

    jQuery('#building_component').on('change', function () {

        if (this.value) {
            jQuery.ajax({
                url: ajax_object.ajax_url,
                type: 'post',
                data: {
                    action: 'load_ajax_content',
                    callback: 'getStageOfConstruction',
                    params: { 'building_type_id': jQuery('#building_type').val(), 'building_component_id': this.value }
                },
                success: function (response) {

                    jQuery("#stage_of_construction").html(fillDropDown(response));
                }
            });
        }
        else {
            jQuery("#stage_of_construction").html(setDefaultDropDown());
        }
    });

    jQuery('#stage_of_construction').on('change', function () {

        var stageofConstructionElement = this;
        var stageofConstructionValues = [];

        for (var i = 0; i < stageofConstructionElement.options.length; i++) {
            var option = stageofConstructionElement.options[i];
            if (option.selected) {
                stageofConstructionValues.push(option.value);
            }
        }

        if (this.value) {
            jQuery.ajax({
                url: ajax_object.ajax_url,
                type: 'post',
                data: {
                    action: 'load_ajax_content',
                    callback: 'getBuildingElement',
                    params: { 'building_type_id': jQuery('#building_type').val(), 'building_component_id': jQuery('#building_component').val(), 'stage_of_construction_id': this.value }
                },
                success: function (response) {

                    jQuery("#building_element_container").html(fillBuildingElement(response));
                }
            });
        }
        else {
            jQuery("#building_element_container").html('');
        }
    });

});

function fillDropDown(response) {

    var jsonObject = JSON.parse(response);
    var option = '<option value="">-select-</option>';
    jsonObject.forEach(function (component) {
        option += '<option value="' + component.id + '">' + component.name + "</option>";
    });

    return option

}

function setDefaultDropDown() {
    return '<option value="">-select-</option>';
}

function fillBuildingElement(response) {

    var elementBlock = `  <div class="container"><div class="row">`;

    var jsonObject = JSON.parse(response);

    jsonObject.forEach(function (component) {

        elementBlock += `
                
                <div class="col-md-2">
                <div class="card">
                <img src="`+ component.picture + `" class="card-img-top" alt="Image 1" width="80">
                <div class="card-body">
                    <h5 class="card-title"><input type="checkbox" name="building_element[]"  value="`+ component.id + `" /> &nbsp ` + component.name + `</h5>
                </div>
                </div>
            </div>
        `;
    });

    // ending row
    elementBlock += `<div>`;

    return elementBlock;
}