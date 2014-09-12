<?php
/**
 * Created by PhpStorm.
 * User: luoi
 * Date: 9/5/14
 * Time: 10:34 AM
 */

class SM_MegaMenu_Block_MegaMenu extends Mage_Core_Block_Template
{
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    public function getMegaMenu()
    {
        if (!$this->hasData('megamenu')) {
            $this->setData('megamenu', Mage::registry('megamenu'));
        }
        return $this->getData('megamenu');

    }
}