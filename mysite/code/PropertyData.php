<?php

class PropertyData extends DataObject
{

    private static $db = array(
        'Title' => 'Varchar',
        'Slug' => 'Varchar',
        'PricePerNight' => 'Currency',
        'Bedrooms' => 'Int',
        'Bathrooms' => 'Int',
        'FeaturedOnHomepage' => 'Boolean',
        'AvailableStart' => 'Date',
        'AvailableEnd' => 'Date',
        'Description' => 'Text',
        'Address' => 'Text'
    );


    private static $many_many = array(
        'PropertyFacilities' => 'PropertyFacilityData'
    );

    private static $has_one = array(
        'Region' => 'RegionData',
        'PrimaryPhoto' => 'Image',
        'PropertyType' => 'PropertyTypeData',
        'Agent' => 'AgentData',
        'PropertySearchPage' => 'PropertySearchPage'
    );

    private static $summary_fields = array(
        'Title' => 'Title',
        'Slug' => 'Slug',
        'Region.Title' => 'Region',
        'PricePerNight.Nice' => 'Price',
        'FeaturedOnHomepage.Nice' => 'Featured?',
        'PropertyType.Name' => 'Type',
        'Agent.Name' => 'Agent'
    );

    public function searchableFields()
    {
        return array(
            'Title' => array(
                'filter' => 'PartialMatchFilter',
                'title' => 'Title',
                'field' => 'TextField'
            ),
            'RegionID' => array(
                'filter' => 'ExactMatchFilter',
                'title' => 'Region',
                'field' => DropdownField::create('RegionID')
                    ->setSource(
                        RegionData::get()->map('ID', 'Title')
                    )
                    ->setEmptyString('-- Any region --')
            ),
            'FeaturedOnHomepage' => array(
                'filter' => 'ExactMatchFilter',
                'title' => 'Only featured'
            )
        );
    }


    public function getCMSFields()
    {
        $fields = FieldList::create(TabSet::create('Root'));
        $fields->addFieldsToTab('Root.Main', array(
            TextField::create('Title'),
            TextareaField::create('Description'),
            CurrencyField::create('PricePerNight', 'Price (per night)'),
            DropdownField::create('Bedrooms')
                ->setSource(ArrayLib::valuekey(range(1, 10))),
            DropdownField::create('Bathrooms')
                ->setSource(ArrayLib::valuekey(range(1, 10))),
            DropdownField::create('RegionID', 'Region')
                ->setSource(RegionData::get()->map('ID', 'Title'))
                ->setEmptyString('-- Select a region --'),
            DropdownField::create('PropertyTypeID', 'Type')
                ->setSource(PropertyTypeData::get()->map('ID', 'Name'))
                ->setEmptyString('-- Select a type --'),
            TextareaField::create('Address'),
            DateField::create('AvailableStart', 'Available Start')
                ->setConfig('showcalendar', true)
                ->setConfig('dateformat', 'd MMMM yyyy'),
            DateField::create('AvailableEnd', 'Available End')
                ->setConfig('showcalendar', true)
                ->setConfig('dateformat', 'd MMMM yyyy'),
            DropdownField::create('AgentID', 'Type')
                ->setSource(AgentData::get()->map('ID', 'Name'))
                ->setEmptyString('-- Select a agent --'),
            CheckboxField::create('FeaturedOnHomepage', 'Feature on homepage')
        ));

        $fields->addFieldToTab('Root.Photos', $upload = UploadField::create(
            'PrimaryPhoto',
            'Primary photo'
        ));

        $fields->addFieldToTab(
            'Root.Facility',
            CheckboxSetField::create(
                'PropertyFacilities',
                'Selected facilities',
                PropertyFacilityData::get()->map('ID', 'Name')
            )
        );


        $upload->getValidator()->setAllowedExtensions(array(
            'png', 'jpeg', 'jpg', 'gif'
        ));
        $upload->setFolderName('property-photos');



        // $fields->addFieldToTab('Root.Categories', CheckboxSetField::create(
        //     'Categories',
        //     'Selected categories',
        //     $this->Parent()->Categories()->map('ID', 'Title')
        // ));

        return $fields;
    }

    public function onBeforeWrite()
    {
        parent::onBeforeWrite();
        if (!$this->Slug || $this->isChanged('Title')) {
            $this->Slug = strtolower(str_replace(' ', '-', $this->Title));
        }
    }

    public function Link()
    {
        $page = PropertySearchPage::get()->first();
        if ($page) {
            return $page->Link('show/' . $this->Slug);
        }
    }

    public function FacilitiesList()
    {
        if ($this->PropertyFacilities()->exists()) {

            return $this->PropertyFacilities()->column('Name');
        }
    }
}
