<?php
/**
 * Created by PhpStorm.
 * User: Quoc Viet
 * Date: 03/09/2014
 * Time: 09:41
 */
class Training_Album_Block_Adminhtml_Images_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'album';
        $this->_controller = 'adminhtml_images';

        $this->_updateButton('save', 'label', Mage::helper('album')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('album')->__('Delete Item'));

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('album_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'album_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'album_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('images_data') && Mage::registry('images_data')->getId() ) {
            return Mage::helper('album')->__("Edit Images '%s'", $this->htmlEscape(Mage::registry('images_data')->getTitle()));
        } else {
            return Mage::helper('album')->__('Add Images');
        }
    }
}