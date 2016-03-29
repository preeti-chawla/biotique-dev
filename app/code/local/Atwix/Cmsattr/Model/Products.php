<?php
class Atwix_Cmsattr_Model_Products extends Mage_Catalog_Model_Product
{
    public function getItemsCollection($attId,$valueId)
    {
        $collection = $this->getCollection()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter($attId, array('eq' => $valueId));
        Mage::getSingleton('cataloginventory/stock')->addInStockFilterToCollection($collection);
        return $collection;
    }
}