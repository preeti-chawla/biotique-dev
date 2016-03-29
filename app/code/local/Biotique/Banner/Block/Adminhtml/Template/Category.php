<?php

class Biotique_Banner_Block_Adminhtml_Template_Category extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $value =  $row->getData($this->getColumn()->getIndex());
        $cat = Mage::getModel('catalog/category')->load((int) $value);
        return $cat->getName();
    }
}