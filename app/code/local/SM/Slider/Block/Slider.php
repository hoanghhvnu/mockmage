<?php
class SM_Slider_Block_Slider extends Mage_Core_Block_Template
{
    public function __construct(){
//        echo __METHOD__;
        return parent::__construct();
    }
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    } // end _prepareLayout()


    public function addItem( $type, $name){
        $name = trim($name);
        if($name == ''){
            return FALSE;
        }
//        echo "<pre>";
//        var_dump($name);
        if(gettype($name) == 'array'){
            $this->addMultiItem($type, $name);
        } else if (gettype($name) == 'string'){
            $this->addSingleItem($type, $name);
        } // end if gettype
//        die();
    } // end method addSkinJs()

    public function addSingleItem($type = NULL, $name = NULL){
        if($name == NULL){
            return FALSE;
        }
        $ItemBlock = Mage::app()->getLayout()
//            ->getBlock('head')
//            ->createBlock('Mage_Page_Block_Html_Head')
//            ->addItem($type,$name)
            ;
        var_dump($ItemBlock);
        die();
        $this->getLayout()
            ->getBlock('head')
            ->append($ItemBlock);
    } // end method addSingleSkinItem

    public function addMultiItem($type = NULL, $name = array()){
        if( empty($name)){
            return FALSE;
        }
        $ItemBlock = Mage::app()->getLayout()
//            ->getBlock('head')
            ->createBlock('Mage_Page_Block_Html_Head')
        ;
        foreach ($name as $item){
            if($item != ''){
                $ItemBlock->addItem($type,$item);
            }
        } // end foreach
        ;
        $this->getLayout()
            ->getBlock('head')
            ->append($ItemBlock);
    } // end method addMultiSkinItem

    /**
     * get Array image for slider will be show
     * @return array
     */
    public function getSliderInfo(){
        $SliderCollection = Mage::getModel('slider/slider')
            ->getCollection()
        ;
        $FinalSlider = array();
        foreach ($SliderCollection as $Slider){
            if($Slider['status'] == 2){ // if it's Disable
                continue;
            }
            if($Slider['status'] == 1){
                $FinalSlider = $Slider;
                break;
            }
        } // end foreach $SliderCollection

        $ImageCollection = Mage::getModel('slider/imageslider')
            ->getCollection()
        ;
        $ImageArray = array();
        foreach ($ImageCollection as $Image ){
            if($Image['slider_id'] == $FinalSlider['slider_id']
            && $Image['status'] == 1){
                $ImageArray[] = $Image->getData();
            } // end if valid image
        }  // end foreach

        // Order by sort_order field
        $tempArray = array();
        foreach ($ImageArray as $key => $value){
            $tempArray[$key] = $value['sortorder'];
        }
        asort($tempArray);
//        var_dump($tempArray);
//        die();
        $SortedImageArray = array();
        foreach ($tempArray as $key => $value){
            $SortedImageArray[] = $ImageArray[$key];
        }
        return $SortedImageArray;
//        return $ImageArray;
    } // end method getSliderInfo
} // end class
// end file