<?php
/**
 * Created by PhpStorm.
 * User: Quoc Viet
 * Date: 03/09/2014
 * Time: 10:22
 */

class Training_Album_Block_Adminhtml_Images_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('images_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('album')->__('Images Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'     => Mage::helper('album')->__('Images Information'),
            'title'     => Mage::helper('album')->__('Images Information'),
            'content'   => $this->getLayout()->createBlock('album/adminhtml_images_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}