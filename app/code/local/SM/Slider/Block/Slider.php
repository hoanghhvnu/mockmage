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
    }

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