<?php
/**
 * Created by PhpStorm.
 * User: Quoc Viet
 * Date: 03/09/2014
 * Time: 09:31
 */
class Training_Album_Block_Adminhtml_Album_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('album_form', array('legend'=>Mage::helper('album')->__('album information')));

        $fieldset->addField('albumname', 'text', array(
            'label'     => Mage::helper('album')->__('Album name'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'albumname',
        ));



        if ( Mage::getSingleton('adminhtml/session')->getAlbumData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getAlbumData());
            Mage::getSingleton('adminhtml/session')->getAlbumData(null);
        } elseif ( Mage::registry('album_data') ) {
            $form->setValues(Mage::registry('album_data')->getData());
        }
        return parent::_prepareForm();
    }
}