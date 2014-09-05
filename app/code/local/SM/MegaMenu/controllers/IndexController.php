<?php
/**
 * Created by PhpStorm.
 * User: luoi
 * Date: 9/4/14
 * Time: 2:01 PM
 */
class SM_MegaMenu_IndexController extends Mage_Core_Controller_Front_Action{
    public function indexAction(){
        echo __METHOD__;
        $this->loadLayout()->renderLayout();
    } // end indexAction
} // end class
// end file