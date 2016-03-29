<?php

class Biotique_Banner_Model_Catbanner extends Mage_Core_Model_Abstract
{
	public function __construct()
	{
		$this->_init('banner/catbanner');
		parent::_construct();
	}
}