<?php

class Biotique_Banner_Block_Adminhtml_Prodbanner_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

	public function __construct()
	{
		$this->_objectId = 'prodbanner_id';			// identifier in URL, adds delete button
		$this->_blockGroup = 'banner';
		$this->_controller = 'adminhtml_prodbanner';

		parent::__construct();
	}

	public function getHeaderText()
	{
		return Mage::helper('banner')->__('New Category Banner');
	}

	// form save url
	public function getSaveUrl()
	{
		return $this->getUrl('*/prodbanner/save', array('_current' => true));
	}
}

?>