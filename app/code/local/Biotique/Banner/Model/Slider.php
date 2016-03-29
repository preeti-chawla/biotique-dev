<?php

class Biotique_Banner_Model_Slider extends Mage_Core_Model_Abstract
{
	public function __construct()
	{
		$this->_init('banner/slider');
		parent::_construct();
	}
}