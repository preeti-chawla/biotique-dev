<?php

class Biotique_Banner_Block_Adminhtml_Template_Parent extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $value =  $row->getData($this->getColumn()->getIndex());
        return $value == 1 ? 'Yes':'No';
    }
}