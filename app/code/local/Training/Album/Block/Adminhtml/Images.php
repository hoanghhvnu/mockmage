<?php
/**
 * Created by PhpStorm.
 * User: Quoc Viet
 * Date: 03/09/2014
 * Time: 10:02
 */

class Training_Album_Block_Adminhtml_Images extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_images';
        $this->_blockGroup = 'album';
        $this->_headerText = Mage::helper('album')->__('Images Manager');
        parent::__construct();
    }
}