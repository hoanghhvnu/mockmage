<?php
/**
 * Created by PhpStorm.
 * User: Quoc Viet
 * Date: 03/09/2014
 * Time: 10:15
 */
class Training_Album_Model_Resource_Images extends Mage_Core_Model_Resource_Db_Abstract {
    protected function _construct()
    {
        $this->_init('album/images', 'images_id');
    }
}