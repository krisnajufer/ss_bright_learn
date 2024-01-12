<?php

class PropertyTypeAdmin extends ModelAdmin
{
    private static $menu_title = 'Property Types';

    private static $url_segment = 'property-type';

    private static $managed_models = array(
        'PropertyTypeData'
    );
}
