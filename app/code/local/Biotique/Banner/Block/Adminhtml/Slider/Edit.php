<?php

class Biotique_Banner_Block_Adminhtml_Slider_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

	public function __construct()
	{
		$this->_objectId = 'slider_id';			// identifier in URL, adds delete button
		$this->_blockGroup = 'banner';
		$this->_controller = 'adminhtml_slider';

		parent::__construct();
	}

	public function getHeaderText()
	{
		return Mage::helper('banner')->__('New Slider');
	}

	// form save url
	public function getSaveUrl()
	{
		return $this->getUrl('*/slider/save', array('_current' => true));
	}
}

?>