<?php
/**
 * Created by PhpStorm.
 * User: Quoc Viet
 * Date: 03/09/2014
 * Time: 10:16
 */

class Training_Album_Model_Images extends Mage_Core_Model_Abstract {
    protected function _construct()
    {
        $this->_init('album/images');
    }
}