<?php

class Biotique_Concerns_Block_Adminhtml_Template_Concerns extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        $value =  $row->getData($this->getColumn()->getIndex());
        $all_concrns = Mage::helper('biotique_concerns')->getAttrib('item_concern');

        $concerns = @unserialize($value);

        $concern_arr = array();
        if(is_array($concerns)){	
        	foreach ($concerns as $concern) {
        		if(isset($all_concrns[$concern])){
        			$concern_arr[] = $all_concrns[$concern];
        		}
        	}
        }

        $concern_str = '<ul style="list-style-type: decimal; margin: 0 0 0 10px; padding: 0 0 0 10px;">';
        foreach ($concern_arr as $concern) {
            $concern_str .= '<li>'. $concern .'</li>';
        }
        $concern_str .= '</ul>';
        return $concern_str;
    }
}