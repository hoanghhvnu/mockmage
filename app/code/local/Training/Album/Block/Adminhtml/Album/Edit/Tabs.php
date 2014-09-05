<?php
/**
 * Created by PhpStorm.
 * User: Quoc Viet
 * Date: 03/09/2014
 * Time: 09:33
 */
class Training_Album_Block_Adminhtml_Album_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('album_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('album')->__('album Information'));
    }

    protected function _beforeToHtml()
    {
        $this->addTab('form_section', array(
            'label'     => Mage::helper('album')->__('album Information'),
            'title'     => Mage::helper('album')->__('album Information'),
            'content'   => $this->getLayout()->createBlock('album/adminhtml_album_edit_tab_form')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}