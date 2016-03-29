<?php

class Biotique_Ingredients_Block_Adminhtml_Template_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
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
	        $url = Mage::getBaseUrl('media') . 'ingredients/' . $val;
	        $out = "<img src=". $url ." height='160px'/>";
        }
        return $out;
    }
}