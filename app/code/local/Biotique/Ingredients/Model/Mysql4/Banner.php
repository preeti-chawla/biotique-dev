<?php
class Biotique_Ingredients_Model_Mysql4_Banner extends Mage_Core_Model_Mysql4_Abstract
{
	public function _construct()
	{
		$this->_init('biotique_ingredients/banner', 'id');
	}
}