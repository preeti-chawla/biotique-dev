<?php
class Biotique_Sample_Model_Mysql4_Orders_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	public function _construct()
	{
		$this->_init('sample/orders');
		parent::_construct();
	}
}