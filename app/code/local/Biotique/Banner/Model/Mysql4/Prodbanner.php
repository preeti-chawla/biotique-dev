<?php
class Biotique_Banner_Model_Mysql4_Prodbanner extends Mage_Core_Model_Mysql4_Abstract
{
	public function _construct()
	{
		$this->_init('banner/prodbanner', 'prodbanner_id');
	}
}