<?php
class Biotique_Banner_Model_Mysql4_Catbanner_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	public function _construct()
	{
		$this->_init('banner/catbanner');
		parent::_construct();
	}
}