<?php

class Biotique_Banner_Block_Adminhtml_Slider extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_blockGroup = 'banner';
		$this->_controller = 'adminhtml_slider';
		$this->_headerText = Mage::helper('banner')->__('Home Slider');
		$this->_addButtonLabel = Mage::helper('banner')->__('Add New Slider');

		parent::__construct();
	}
}