<?php

class RegionData extends DataObject
{
    private static $db = array(
        'Title' => 'Varchar',
        'Description' => 'HTMLText',
        'Slug' => 'Varchar'
    );

    private static $has_one = array(
        'Photo' => 'Image',
        'RegionPage' => 'RegionPage'
    );

    private static $has_many = array(
        'Articles' => 'ArticlePage'
    );

    private static $summary_fields = array(
        'GridThumbnail' => '',
        'Title' => 'Title of region',
        'Description' => 'Short description',
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
            TextField::create('Title'),
            HtmlEditorField::create('Description'),
            $uploader = UploadField::create('Photo')
        );

        $uploader->setFolderName('region-photos');
        $uploader->getValidator()->setAllowedExtensions(array(
            'png', 'gif', 'jpeg', 'jpg'
        ));

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
        $page = RegionPage::get()->first();

        if ($page) {
            return $page->Link('show/' . $this->Slug);
        }
    }


    public function LinkingMode()
    {
        return Controller::curr()->getRequest()->param('ID') == $this->Slug ? 'current' : 'link';
    }

    public function ArticlesLink()
    {
        $page = ArticleHolderPage::get()->first();

        if ($page) {
            return $page->Link('region/' . $this->Slug);
        }
    }
}
