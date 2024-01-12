<?php

class AgentData extends DataObject
{
    private static $db = array(
        'Name' => 'Varchar',
        'Address' => 'Text',
        'About' => 'HTMLText',
        'Phone' => 'Varchar'
    );

    private static $has_one = array(
        'Photo' => 'Image',
    );

    private static $has_many = array(
        'Properties' => 'PropertyData'
    );

    private static $summary_fields = array(
        'GridThumbnail' => 'Photo',
        'Name', 'Address', 'About', 'Phone'
    );

    public function getGridThumbnail()
    {
        if ($this->Photo()->exists()) {
            return $this->Photo()->SetWidth(100);
        }

        return '(no image)';
    }

    public function getCMSFields()
    {
        $fields = FieldList::create(
            TextField::create('Name'),
            TextareaField::create('Address'),
            HtmlEditorField::create('About'),
            TextField::create('Phone'),
            $uploader = UploadField::create('Photo')
        );

        $uploader->setFolderName('agent-photos');
        $uploader->getValidator()->setAllowedExtensions(array(
            'png', 'gif', 'jpeg', 'jpg', 'webp'
        ));

        return $fields;
    }
}
