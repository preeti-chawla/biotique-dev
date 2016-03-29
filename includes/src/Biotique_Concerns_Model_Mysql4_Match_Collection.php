<?php
class Biotique_Concerns_Model_Mysql4_Match_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	public function _construct()
	{
		$this->_init('biotique_concerns/match');
		parent::_construct();
	}
}