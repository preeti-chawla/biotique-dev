<?php
class Biotique_Concerns_Model_Mysql4_Match extends Mage_Core_Model_Mysql4_Abstract
{
	public function _construct()
	{
		$this->_init('biotique_concerns/match', 'id');
	}
}