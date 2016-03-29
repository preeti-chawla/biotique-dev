<?php

class Biotique_Banner_Block_Adminhtml_Template_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        return $this->_getValue($row);
    }

    protected function _getValue(Varien_Object $row)
    {      
        $val = $row->getData($this->getColumn()->getIndex());
        $val = str_replace("no_selection", "", $val);
        $out = '';
        if(!empty($val)){
	        $url = Mage::getBaseUrl('media') . 'banners/' . $val;
	        $out = "<img src=". $url ." width='240px'/>";
        }
        return $out;
    }
}