<?php

class Biotique_Banner_Block_Welcome extends Mage_Core_Block_Template
{
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('biotique/banner/welcome.phtml');
	}
}