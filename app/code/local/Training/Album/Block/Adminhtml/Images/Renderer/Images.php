<?php
/**
 * Created by PhpStorm.
 * User: Quoc Viet
 * Date: 03/09/2014
 * Time: 10:19
 */
class Training_Album_Block_Adminhtml_Images_Renderer_Images extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        return sprintf('
                <a href="%s">%s</a>',
            Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . '/images/' . $row->getImagesname(),
            '<img alt="" src="' . Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . '/images/' . $row->getImagesname() . '" width="150" />'
        );
    }
}