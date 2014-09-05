<?php
/**
 * Created by PhpStorm.
 * User: luoi
 * Date: 9/5/14
 * Time: 10:01 AM
 */
class SM_MegaMenu_Adminhtml_MegamenuController extends Mage_Adminhtml_Controller_Action{
    protected function _initAction() {
        $this->loadLayout()
            ->_setActiveMenu('megamenu')
            ->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));

        return $this;
    }

    public function indexAction() {
        $this->_initAction()
            ->renderLayout();
    }
} // end class
// end file