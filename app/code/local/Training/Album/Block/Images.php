<?php
/**
 * Created by PhpStorm.
 * User: Quoc Viet
 * Date: 03/09/2014
 * Time: 10:37
 */

class Training_Album_Block_Images extends Mage_Core_Block_Template
{
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function getImages()
    {
        if (!$this->hasData('images')) {
            $this->setData('images', Mage::registry('images'));
        }
        return $this->getData('images');

    }
}