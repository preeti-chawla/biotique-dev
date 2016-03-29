<?php

class Biotique_Sample_Model_Orders extends Mage_Core_Model_Abstract
{
	public function __construct()
	{
		$this->_init('sample/orders');
		parent::_construct();
	}
}