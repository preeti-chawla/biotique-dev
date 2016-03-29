<?php

class Biotique_Ingredients_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function fetch_ingredients($range = null)
    {
		$bannerData = Mage::getModel("biotique_ingredients/banner")
				->getCollection()
				->setOrder('alias', 'ASC');
		if($range){
			$range_ext = explode('_', $range);
			if(ctype_alpha($range_ext[0]) && ctype_alpha($range_ext[1])) {
				$alprange = range($range_ext[0], $range_ext[1]);
				$bannerData->addFieldToFilter('alias',array(
					'regexp'=>'^['. $range_ext[0] .'-'. $range_ext[1] .']'
				));
			}
		}
        return $bannerData;
    }

    public function item_ingredients()
    {
		$attribute_code = "item_ingregident"; 
		$ingred_arr = array();

		$attribute_details = Mage::getSingleton("eav/config")->getAttribute("catalog_product", $attribute_code); 
		$all_ingredients =  $attribute_details->getSource()->getAllOptions(false); 

		
		foreach($all_ingredients as $option){
			$ingred_arr[$option["value"]] =  $option["label"]; 
		}
		asort($ingred_arr);

		return $ingred_arr;
    }

    public function getOptionText($option_val)
    {
    	$opt_text = '';
		$productModel = Mage::getModel('catalog/product');
		$attr = $productModel->getResource()->getAttribute("item_ingregident");
		if ($attr->usesSource()) {
		    $opt_text = $attr->getSource()->getOptionText($option_val);
		}

		return $opt_text;
    }
    
}