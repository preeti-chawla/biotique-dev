<?php
class Biotique_Banner_Model_Mysql4_Prodbanner_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	public function _construct()
	{
		$this->_init('banner/prodbanner');
		parent::_construct();
	}
}