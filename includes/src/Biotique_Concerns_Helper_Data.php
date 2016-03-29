<?php

class Biotique_Concerns_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function getAllCategories()
    {
		$cat_arr = array();

		$cat = Mage::getSingleton('catalog/category')->load('2');
		$subcats = $cat->getChildren();
		foreach(explode(',',$subcats) as $subCatid){
			$categ = Mage::getModel('catalog/category')->load($subCatid);
			$cat_arr[$subCatid] = $categ->getName();
		}
		asort($cat_arr);
		return $cat_arr;
    }

    public function getConcernCategories($except)
    {

        $all_cats = $this->getAllCategories();
        $used_cats = Mage::getModel('biotique_concerns/match')->getCats($except);

        foreach ($used_cats as $catid) {
            if(array_key_exists($catid, $all_cats))
                unset($all_cats[$catid]);
        }
        
        return $all_cats;
    }

    public function getCategoryName($catId)
    {

        $all_cats = $this->getAllCategories();
        return isset($all_cats[$catId]) ? $all_cats[$catId] : '';
    }

    public function getAttrib($attrib)
    {
		$attrib_arr = array();

		$attribute_details = Mage::getSingleton("eav/config")->getAttribute("catalog_product", $attrib); 
		$all_attribs =  $attribute_details->getSource()->getAllOptions(false); 

		
		foreach($all_attribs as $option){
			$attrib_arr[$option["value"]] =  $option["label"]; 
		}
		asort($attrib_arr);
		return $attrib_arr;
    }

    public function getAttribFormat($attrib)
    {
    	$attrib_arr = $this->getAttrib($attrib);
    	$attrib_frm = array();
    	foreach ($attrib_arr as $key => $value) {
    		array_push($attrib_frm, array(
    			'label' => $value,
    			'value' => $key
    		));
    	}
    	return $attrib_frm;
    }
}