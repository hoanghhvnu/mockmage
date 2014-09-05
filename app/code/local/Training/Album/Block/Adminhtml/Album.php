<?php
/**
 * Created by PhpStorm.
 * User: Quoc Viet
 * Date: 02/09/2014
 * Time: 22:03
 */
class Training_Album_Block_Adminhtml_Album extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_album';
        $this->_blockGroup = 'album';
        $this->_headerText = Mage::helper('album')->__('album Manager');
        parent::__construct();
    }
}