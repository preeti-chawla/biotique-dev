<?php

class Biotique_Concerns_Block_Adminhtml_Match_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

	public function __construct()
	{
		$this->_objectId = 'id';			// identifier in URL, adds delete button
		$this->_blockGroup = 'biotique_concerns';
		$this->_controller = 'adminhtml_match';

		parent::__construct();
	}

	public function getHeaderText()
	{
		return Mage::helper('biotique_concerns')->__('New Concern');
	}

	// form save url
	public function getSaveUrl()
	{
		return $this->getUrl('*/concerns_match/save', array('_current' => true));
	}
}

?>