<?php
class Mage_Catalog_Block_Product_All extends Mage_Catalog_Block_Product_List
{
protected function _getProductCollection()
{
if (is_null($this->_productCollection)) {
$collection = Mage::getResourceModel('catalog/product_collection')
->addAttributeToSelect('*')
->addAttributeToFilter('status', 1)
->addAttributeToFilter(array(array('attribute'=>'visibility', 'eq'=>"4")));
$this->_productCollection = $collection;
}
return $this->_productCollection;
}
}
?>