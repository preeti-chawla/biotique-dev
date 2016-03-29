<?php
class Atwix_Cmsattr_Block_List extends Mage_Catalog_Block_Product_Abstract
{
    protected $_itemCollection = null; 
    public function getItems($att,$att_val)
    {
        if (!$att_val)
            return false;
        if (is_null($this->_itemCollection)) {
           // $this->_itemCollection = Mage::getModel('atwix_cmsattr/products')->getItemsCollection($color);
		   $this->_itemCollection = Mage::getModel('atwix_cmsattr/products')->getItemsCollection($att,$att_val);
        }
        return $this->_itemCollection;
    }
}