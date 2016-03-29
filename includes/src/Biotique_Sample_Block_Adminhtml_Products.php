<?php

class Biotique_Sample_Block_Adminhtml_Products extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_blockGroup = 'sample';
		$this->_controller = 'adminhtml_products';
		$this->_headerText = Mage::helper('sample')->__('Sample Home');
		$this->_addButtonLabel = Mage::helper('sample')->__('Add New Sample');

		parent::__construct();
	}
}