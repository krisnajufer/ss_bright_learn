<?php

class PropertySearchPage extends Page
{
    private static $has_many = array(
        'Properties' => 'PropertyData'
    );
}


class PropertySearchPage_Controller extends Page_Controller
{
    private static $allowed_actions = array(
        'show'
    );

    // public function index(SS_HTTPRequest $request)
    // {

    //     try {

    //         // $properties = PropertyData::get();
    //         $query = "SELECT DISTINCT a.*
    //         FROM PropertyData as a
    //         LEFT JOIN PropertyDetailData as b on a.ID = b.PropertyID
    //         LEFT JOIN PropertyFacilityData as c on b.PropertyFacilityID = c.ID
    //     ";

    //         $data = Convert::raw2sql($request->postVars());
    //         if ($data['Keywords'] || $type = $data['Type'] || $data['Facility']) {
    //             $query .= " WHERE ";
    //         }

    //         if ($search = $data['Keywords']) {
    //             $query .= " a.Title LIKE '%" . $search . "%'";
    //         }

    //         if ($type = $data['Type']) {
    //             $query .= $search ? ' AND ' : '';
    //             $query .= " a.PropertyTypeID = " . $data['Type'];
    //         }

    //         if ($facility = $data['Facility']) {
    //             $query .= $search || $type ? ' AND ' : '';
    //             $query .= " b.PropertyFacilityID = " . $facility;
    //         }

    //         // $query .= "GROUP BY (a.Title, a.Slug,)"
    //         $result = DB::query($query);
    //         $properties = ArrayList::create();
    //         // $properties->remove();
    //         foreach ($result as $item) {

    //             $photo = DB::query("SELECT Filename FROM file WHERE ID = " . $item['PrimaryPhotoID'])->first();
    //             $path = "<img src='" . $photo['Filename'] . "' alt='" . $photo['Name'] . "'>";
    //             // var_dump($path);
    //             // die;
    //             $properties->push(array(
    //                 'Title' => DBField::create_field('Varchar', $item['Title']),
    //                 'Slug' => DBField::create_field('Varchar', $item['Slug']),
    //                 'PricePerNight' => DBField::create_field('Currency', $item['PricePerNight']),
    //                 'Bedrooms' => DBField::create_field('Int', $item['Bedrooms']),
    //                 'Bathrooms' => DBField::create_field('Int', $item['Bathrooms']),
    //                 'FeaturedOnHomepage' => DBField::create_field('Boolean', $item['FeaturedOnHomepage']),
    //                 'AvailableStart' => DBField::create_field('Date', $item['AvailableStart']),
    //                 'AvailableEnd' => DBField::create_field('Date', $item['AvailableEnd']),
    //                 'Description' => DBField::create_field('Text', $item['Description']),
    //                 'Address' => DBField::create_field('Text', $item['Address']),
    //                 'PrimaryPhoto' => DBField::create_field('HTMLText', $path),
    //                 'Link' => DBField::create_field('Text', 'find-a-rental' . '/show' . '/' . $item['Slug']),
    //             ));
    //         }

    //         $paginated_properties = PaginatedList::create(
    //             $properties,
    //             $request
    //         )->setPageLength(15)
    //             ->setPaginationGetVar('s');

    //         $data = array(
    //             'Results' => $paginated_properties
    //         );

    //         if ($request->isAjax()) {
    //             return $this->customise($data)
    //                 ->renderWith('PropertySearchResults');
    //         }

    //         return $data;
    //     } catch (\Exception $ex) {
    //         //throw $th;
    //         echo $ex->getMessage();
    //     }
    // }

    public function index(SS_HTTPRequest $request)
    {
        // $properties = PropertyData::get()->sort('CREATED', 'DESC');
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


        $paginated_properties = PaginatedList::create(
            $properties,
            $request
        )->setPageLength(15)
            ->setPaginationGetVar('s');

        $data = array(
            'Results' => $paginated_properties
        );

        if ($request->isAjax()) {
            return $this->customise($data)
                ->renderWith('PropertySearchResults');
        }

        return $data;
    }


    public function PropertySearchForm()
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
                    ->addExtraClass('btn-lg btn-fullcolor')
            )
        );

        $form->setFormMethod('POST')
            ->setFormAction($this->Link())
            ->disableSecurityToken()
            ->loadDataFrom($this->request->postVars());

        return $form;
    }

    public function show(SS_HTTPRequest $request)
    {
        $slug = $request->param('ID');
        $slug = Convert::raw2sql($slug, true);

        $property = PropertyData::get()->where("\"Slug\" = $slug")->first();
        $facilities = ArrayList::create();
        foreach ($property->FacilitiesList() as $item) {
            $facilities->push(array(
                'Name' => DBField::create_field('Varchar', $item)
            ));
        }
        return array(
            'Property' => $property,
            'Title' => $property->Title,
            'Facilities' => $facilities,
        );
    }
}
