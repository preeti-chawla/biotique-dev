<?php

class Biotique_Banner_Model_Prodbanner extends Mage_Core_Model_Abstract
{
	public function __construct()
	{
		$this->_init('banner/prodbanner');
		parent::_construct();
	}
}