<?php

class Biotique_Concerns_Block_Adminhtml_Template_Category extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $value =  (int) $row->getData($this->getColumn()->getIndex());
        return Mage::helper('biotique_concerns')->getCategoryName($value);
    }
}