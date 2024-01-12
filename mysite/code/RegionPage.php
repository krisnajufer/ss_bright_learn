<?php

class RegionPage extends Page
{
    private static $has_many = array(
        'Regions' => 'RegionData',
    );

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Regions', GridField::create(
            'Regions',
            'Regions on this page',
            $this->Regions(),
            GridFieldConfig_RecordEditor::create()
        ));

        return $fields;
    }
}

class RegionPage_Controller extends Page_Controller
{
    private static $allowed_actions = array(
        'show'
    );

    public function index()
    {
        $data = RegionData::get();

        $regions =  new PaginatedList(
            $data,
            $this->getRequest()
        );

        $regions->setPageLength(4);
        $regions->setPaginationGetVar('s');

        return array(
            'Regions' => $regions
        );
    }

    public function show(SS_HTTPRequest $request)
    {
        $slug = $request->param('ID');
        $slug = Convert::raw2sql($slug, true);
        $region = RegionData::get()->where("\"Slug\" = $slug")->first();

        if (!$region) {
            return $this->httpError(404, 'That region could not be found');
        }


        return array(
            'Region' => $region,
            'Title' => $region->Title
        );
    }
}
