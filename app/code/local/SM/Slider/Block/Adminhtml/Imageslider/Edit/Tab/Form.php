<?php

class SM_Slider_Block_Adminhtml_Imageslider_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('imageslider_form', array('legend'=>Mage::helper('slider')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('slider')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('imagename', 'file', array(
          'label'     => Mage::helper('slider')->__('Image'),
//          'class'     => 'required-entry',
//          'required'  => true,
          'name'      => 'imagename',
      ));

      $fieldset->addField('description', 'textarea', array(
          'label'     => Mage::helper('slider')->__('Description'),
          'name'      => 'description',
      ));

      $fieldset->addField('slider_id', 'select', array(
          'label'     => Mage::helper('slider')->__('Slider'),
          'name'      => 'slider_id',
          'values'    => $this->getListSlider(),
      ));

      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('slider')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('slider')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('slider')->__('Disabled'),
              ),
          ),
      ));


      if ( Mage::getSingleton('adminhtml/session')->getSliderData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getSliderData());
          Mage::getSingleton('adminhtml/session')->setSliderData(null);
      } elseif ( Mage::registry('imageslider_data') ) {
          $form->setValues(Mage::registry('imageslider_data')->getData());
      }
      return parent::_prepareForm();
  }

    /**
     * get all slider to select
     */
    public function getListSlider(){
        $SliderCollection = Mage::getModel('slider/slider')
            ->getCollection()
        ;
//        echo "<pre>";
//        var_dump($SliderCollection->getData());
        $ResultArray = array();
        foreach ($SliderCollection as $Slider){
            $temp = array();
            if($Slider['status'] == 2){
                continue;
            }
            $temp['label'] = $Slider['title'];
            $temp['value'] = $Slider['slider_id'];
            $ResultArray[] = $temp;
        } // end foreach
        return $ResultArray;
    } // end method getListSlider
} // end class
// end file