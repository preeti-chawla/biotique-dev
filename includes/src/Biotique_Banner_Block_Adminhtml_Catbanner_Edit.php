<?php

class Biotique_Banner_Block_Adminhtml_Catbanner_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

	public function __construct()
	{
		$this->_objectId = 'catbanner_id';			// identifier in URL, adds delete button
		$this->_blockGroup = 'banner';
		$this->_controller = 'adminhtml_catbanner';

		parent::__construct();
	}

	public function getHeaderText()
	{
		return Mage::helper('banner')->__('New Category Banner');
	}

	// form save url
	public function getSaveUrl()
	{
		return $this->getUrl('*/catbanner/save', array('_current' => true));
	}
}

?>