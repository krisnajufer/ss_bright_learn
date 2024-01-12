<?php

class PropertyFacilityAdmin extends ModelAdmin
{
    private static $menu_title = 'Property Facilities';

    private static $url_segment = 'property-facility';

    private static $managed_models = array(
        'PropertyFacilityData'
    );
}
