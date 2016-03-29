<?php

class Biotique_Concerns_Block_Adminhtml_Match extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_blockGroup = 'biotique_concerns';
		$this->_controller = 'adminhtml_match';
		$this->_headerText = Mage::helper('biotique_concerns')->__('Category Concerns');
		$this->_addButtonLabel = Mage::helper('biotique_concerns')->__('Assign concern');

		parent::__construct();
	}
}