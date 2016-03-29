<?php

class Biotique_Ingredients_Block_Adminhtml_Banner_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

	public function __construct()
	{
		$this->_objectId = 'id';			// identifier in URL, adds delete button
		$this->_blockGroup = 'biotique_ingredients';
		$this->_controller = 'adminhtml_banner';

		parent::__construct();
	}

	public function getHeaderText()
	{
		return Mage::helper('biotique_ingredients')->__('New Banner');
	}

	// form save url
	public function getSaveUrl()
	{
		return $this->getUrl('*/ingredients_banner/save', array('_current' => true));
	}
}

?>