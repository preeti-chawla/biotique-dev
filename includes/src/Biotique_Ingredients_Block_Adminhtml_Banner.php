<?php

class Biotique_Ingredients_Block_Adminhtml_Banner extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_blockGroup = 'biotique_ingredients';
		$this->_controller = 'adminhtml_banner';
		$this->_headerText = Mage::helper('biotique_ingredients')->__('Ingredients');
		$this->_addButtonLabel = Mage::helper('biotique_ingredients')->__('Add Ingredient Data');

		parent::__construct();
	}
}