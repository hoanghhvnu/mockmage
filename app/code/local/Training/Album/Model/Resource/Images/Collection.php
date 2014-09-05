<?php
/**
 * Created by PhpStorm.
 * User: Quoc Viet
 * Date: 03/09/2014
 * Time: 10:15
 */

class Training_Album_Model_Resource_Images_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract {
    protected function _construct()
    {
        $this->_init('album/images');
    }
}