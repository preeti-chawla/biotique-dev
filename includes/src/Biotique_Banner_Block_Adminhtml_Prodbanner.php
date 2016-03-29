<?php

class Biotique_Banner_Block_Adminhtml_Prodbanner extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_blockGroup = 'banner';
		$this->_controller = 'adminhtml_prodbanner';
		$this->_headerText = Mage::helper('banner')->__('Product Banner Home');
		$this->_addButtonLabel = Mage::helper('banner')->__('Add New Banner');

		parent::__construct();
	}
}