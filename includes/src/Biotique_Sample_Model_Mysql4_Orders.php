<?php
class Biotique_Sample_Model_Mysql4_Orders extends Mage_Core_Model_Mysql4_Abstract
{
	public function _construct()
	{
		$this->_init('sample/orders', 'id');
	}
}