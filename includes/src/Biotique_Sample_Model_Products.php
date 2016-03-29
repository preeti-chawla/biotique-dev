<?php

class Biotique_Sample_Model_Products extends Mage_Core_Model_Abstract
{
	public function __construct()
	{
		$this->_init('sample/products');
		parent::_construct();
	}
}