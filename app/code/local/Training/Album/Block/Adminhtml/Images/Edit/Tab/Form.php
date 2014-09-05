<?php
/**
 * Created by PhpStorm.
 * User: Quoc Viet
 * Date: 03/09/2014
 * Time: 10:22
 */
class Training_Album_Block_Adminhtml_Images_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('images_form', array('legend'=>Mage::helper('album')->__('images information')));


        $fieldset->addField('imagesname', 'file', array(
            'label'     => Mage::helper('album')->__('Image Upload'),
            'required'  => false,
            'name'      => 'imagesname',
        ));

        $fieldset->addField('album_id', 'text', array(
            'label'     => Mage::helper('album')->__('album_id'),
            'class'     => 'required-entry',
            'required'  => true,
            'name'      => 'album_id',
        ));



        if ( Mage::getSingleton('adminhtml/session')->getImagesData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getImagesData());
            Mage::getSingleton('adminhtml/session')->getImagesData(null);
        } elseif ( Mage::registry('images_data') ) {
            $form->setValues(Mage::registry('images_data')->getData());
        }
        return parent::_prepareForm();
    }
}