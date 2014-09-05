<?php
/**
 * Created by PhpStorm.
 * User: Quoc Viet
 * Date: 02/09/2014
 * Time: 21:37
 */
class Training_Album_Model_Resource_Album_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract {
    protected function _construct()
    {
        $this->_init('album/album');
    }
}