<?php

class PropertyTypeData extends DataObject
{
    private static $db = array(
        'Name' => 'Varchar'
    );

    private static $has_many = array(
        'Properties' => 'PropertyData'
    );

    public function getCMSFields()
    {
        $fields = FieldList::create(
            TextField::create('Name'),
        );

        return $fields;
    }
}
