<?php

class HomePage extends Page
{
}

class HomePage_Controller extends Page_Controller
{
    private static $allowed_actions = array(
        'SearchPropertyForm',
        'SearchPropertyDo'
    );

    public function index(SS_HTTPRequest $request)
    {
        $regions = RegionData::get()->sort('Created', 'DESC')->limit(6);

        $properties = PropertyData::get()->sort('Created', 'DESC')->limit(6);

        $articles = ArticlePage::get()->sort('CREATED', 'DESC')->limit(3);

        return array(
            'Regions' => $regions,
            'Properties' => $properties,
            'Articles' => $articles
        );
    }

    public function SearchPropertyForm()
    {
        $form = Form::create(
            $this,
            __FUNCTION__,
            FieldList::create(
                TextField::create('Keywords')
                    ->setAttribute('placeholder', 'City, State, Country, etc...')
                    ->addExtraClass('form-control'),
                DropdownField::create('Type')
                    ->setSource(PropertyTypeData::get()->map('ID', 'Name'))
                    ->setEmptyString('-- Select a Type --')
                    ->addExtraClass('form-control'),
                DropdownField::create('Facility')
                    ->setSource(PropertyFacilityData::get()->map('ID', 'Name'))
                    ->setEmptyString('-- Select a Facility --')
                    ->addExtraClass('form-control'),
            ),
            FieldList::create(
                FormAction::create('SearchPropertyDo', 'Search')
                    ->addExtraClass('btn btn-fullcolor')
            )
        );

        return $form;
    }

    public function SearchPropertyDo()
    {
        echo $this->getRequest()->postVar('Keyword');
    }
}
