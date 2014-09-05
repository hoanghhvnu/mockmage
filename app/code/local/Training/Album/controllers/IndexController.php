<?php
/**
 * Created by PhpStorm.
 * User: Quoc Viet
 * Date: 02/09/2014
 * Time: 21:35
 */
class Training_Album_IndexController extends Mage_Core_Controller_Front_Action {
    public function indexAction() {
        $album = Mage::getModel('album/album')->getCollection();
        Mage::register('album', $album);
        $this->loadLayout();
        $this->renderLayout();
    }
}