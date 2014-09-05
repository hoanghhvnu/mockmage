<?php
/**
 * Created by PhpStorm.
 * User: Quoc Viet
 * Date: 03/09/2014
 * Time: 09:50
 */
class Training_Album_Block_Album extends Mage_Core_Block_Template
{
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function getAlbum()
    {
        if (!$this->hasData('album')) {
            $this->setData('album', Mage::registry('album'));
        }
        return $this->getData('album');

    }
}