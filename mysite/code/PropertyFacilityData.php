<?php

class PropertyFacilityData extends DataObject
{
    private static $db = array(
        'Name' => 'Varchar'
    );

    private static $belongs_many_many = array(
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
