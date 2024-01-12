<?php

class RegionAdmin extends ModelAdmin
{
    private static $menu_title = 'Region';

    private static $url_segment = 'region';

    private static $managed_models = array(
        'RegionData'
    );
}
