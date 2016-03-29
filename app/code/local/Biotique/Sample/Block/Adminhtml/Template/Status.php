<?php

class Biotique_Sample_Block_Adminhtml_Template_Status extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $value =  $row->getData($this->getColumn()->getIndex());
        return $value == 1 ? 'Active':'Inactive';
    }
}