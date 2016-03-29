<?php

class Biotique_Concerns_Model_Match extends Mage_Core_Model_Abstract
{
	public function __construct()
	{
		$this->_init('biotique_concerns/match');
		parent::_construct();
	}

	public function getCats($except)
	{

		$collection = Mage::getModel("biotique_concerns/match")->getCollection();
		$collection->addFieldToFilter('id', array('neq' => (int) $except))
			->getSelect()
     		->reset(Zend_Db_Select::COLUMNS)
     		->columns('category_id');

     	$cat_arr = array();
     	foreach ($collection as $cat_col) {
     		$cat_arr[] = $cat_col->getCategoryId();
     	}

		return $cat_arr;
	}

	public function getCategoryConcerns($category)
	{

		$collection = Mage::getModel("biotique_concerns/match")->getCollection();
		$collection->addFieldToFilter('category_id', (int) $category)
			->getFirstItem();

		$concern_ids = $collection->getColumnValues('concern_ids');
		$concern_ids = @unserialize($concern_ids[0]);


		$concern_arr = array();
		if(is_array($concern_ids)){
			$item_concerns = Mage::helper('biotique_concerns')->getAttrib('item_concern');
			foreach ($concern_ids as $cid) {
				$concern_arr[$cid] = $item_concerns[$cid];
			}
		}
		
		return $concern_arr;
	}
}