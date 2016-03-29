<?php
class Biotique_Sample_Model_Mysql4_Products_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	public function _construct()
	{
		$this->_init('sample/products');
		parent::_construct();
	}
}