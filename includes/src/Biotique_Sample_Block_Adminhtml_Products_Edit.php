<?php

class Biotique_Sample_Block_Adminhtml_Products_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

	public function __construct()
	{
		$this->_objectId = 'product_id';			// identifier in URL, adds delete button
		$this->_blockGroup = 'sample';
		$this->_controller = 'adminhtml_products';

		parent::__construct();
	}

	public function getHeaderText()
	{
		return Mage::helper('sample')->__('New Sample');
	}

	// form save url
	public function getSaveUrl()
	{
		return $this->getUrl('*/sample/save', array('_current' => true));
	}
}

?>