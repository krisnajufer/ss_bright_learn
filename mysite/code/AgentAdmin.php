<?php

class AgentAdmin extends ModelAdmin
{
    private static $menu_title = 'Agent';

    private static $url_segment = 'agent';

    private static $managed_models = array(
        'AgentData'
    );
}
