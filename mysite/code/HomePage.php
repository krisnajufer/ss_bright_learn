<?php

class HomePage extends Page
{
}

class HomePage_Controller extends Page_Controller
{
    private static $allowed_actions = array(
        'SearchPropertyForm',
    );

    public function index(SS_HTTPRequest $request)
    {
        $regions = RegionData::get()->sort('Created', 'DESC')->limit(6);
        $articles = ArticlePage::get()->sort('CREATED', 'DESC')->limit(3);

        $properties = PropertyData::get()
            ->innerJoin('PropertyData_PropertyFacilities', '"PropertyData_PropertyFacilities"."PropertyDataID" = "PropertyData"."ID"')
            ->innerJoin('PropertyFacilityData', '"PropertyFacilityData"."ID" = "PropertyData_PropertyFacilities"."PropertyFacilityDataID"');

        $data = Convert::raw2sql($request->postVars());


        if ($search = $data['Keywords']) {
            $properties = $properties->filter(array(
                'Title:PartialMatch' => $search
            ));
        }

        if ($type = $data['Type']) {
            $properties = $properties->filter(array(
                'PropertyTypeID' => $type
            ));
        }

        if ($facility = $data['Facility']) {
            $properties = $properties
                ->filter(array('PropertyData_PropertyFacilities.PropertyFacilityDataID' => $facility));
        }

        return array(
            'Regions' => $regions,
            'Properties' => $properties->limit(6),
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
        $form->setFormMethod('POST')
            ->setFormAction($this->Link())
            ->disableSecurityToken()
            ->loadDataFrom($this->request->postVars());
        return $form;
    }

    public function SearchPropertyDo()
    {
        echo $this->getRequest()->postVar('Keyword');
    }
}
